<?php

namespace App\Http\Controllers;

//use http\Client;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Invoice;
use App\Client;
use App\Mail\InvoiceEmail;
use DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Production
        $invoices = Invoice::orderBy('Inv_Num', 'desc')->paginate(20);

        // Production
//        $invoices = DB::select("select inv.*, cl.C_name, cl.C_surname
//                                from tblinv_info inv
//                                inner join tblclientinfo cl
//                                on cl.Client_id = inv.Client_id
//                                order by inv.Inv_Num desc limit 10 offset 0");

        return view('invoices.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = DB::select("select * from tblclientinfo order by C_name, C_surname");

        $supplements = DB::select("select * from tblsupplements order by Supplement_id");

        $data = [
            'clients' => $clients,
            'supplements' => $supplements
        ];

        return view('invoices.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->session()->has('invoice')) {
            $invoice = $request->session()->get('invoice');
            $client = $invoice['client'];
            $items = $invoice['items'];

            // TODO check if there is available stock and show notice to admin after creating invoice about low stock

//            $this->validate($request, [
//                'name' => 'required',
//                'surname' => 'required',
//                'idnum' => 'required'
//                //            'address'   => 'required',
//                //            'email'     => 'required',
//                //            'telh'      => 'required',
//                //            'telw'      => 'required',
//                //            'cell'      => 'required',
//                //            'reference' => 'required'
//            ]);

            // Create Invoice
            $inv = new Invoice;
            $inv->Inv_Num = $invoice['invoice_id'];
            $inv->Client_id = $client->Client_id;
            $inv->Inv_Date = date('Y-m-d');
            $inv->Inv_Paid = 'N';
            $inv->save();

            // Create invoice items
            foreach ($items as $item) {
                $inv_items = new Item;
                $inv_items->Inv_Num = $invoice['invoice_id'];
                $inv_items->Supplement_id = $item->supplement_id;
                $inv_items->Item_Price = $item->cost_excl;
                $inv_items->Item_Quantity = $item->qty;
                $inv_items->save();
            }
        } else {
            return redirect('/invoices')->with('error', 'Invoice details missing!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = DB::select("select inv.*, invi.Item_Price, invi.Item_Quantity, invi.Supplement_id, sup.Supplement_Description,
                                cl.C_name, cl.C_surname, cl.Address, cl.Code, cl.C_Email, cl.C_Tel_W, cl.C_Tel_H, cl.C_Tel_Cell
                                from tblinv_info inv
                                inner join tblinv_items invi
                                on invi.Inv_Num = inv.Inv_Num
                                inner join tblsupplements sup
                                on sup.Supplement_id = invi.Supplement_id
                                inner join tblclientinfo cl
                                on cl.Client_id = inv.Client_id
                                where inv.Inv_Num = ?", [$id]);

//        dd($invoice);

        return view('invoices.show')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = DB::select("select * from tblinv_info where Inv_Num = ?", [$id]);

        return view('invoices.edit')->with('invoice', (object) $invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'surname'   => 'required',
            'idnum'     => 'required'
//            'address'   => 'required',
//            'email'     => 'required',
//            'telh'      => 'required',
//            'telw'      => 'required',
//            'cell'      => 'required',
//            'reference' => 'required'
        ]);

        // Create Invoices
        $client = Invoice::find($id);
        $client->C_name         = $request->input('name');
        $client->C_surname      = $request->input('surname');
        $client->Invoices_id      = $request->input('idnum');
        $client->Address        = $request->input('address');
        $client->Code           = $request->input('zip');
        $client->C_Email        = $request->input('email');
        $client->C_Tel_H        = $request->input('telh');
        $client->C_Tel_W        = $request->input('telw');
        $client->C_Tel_Cell     = $request->input('cell');
        $client->Reference_ID   = $request->input('reference');
        $client->save();

        return redirect('/invoices')->with('success', "Invoices '$id' updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Invoice::find($id);
        $client->delete();

        return redirect('/invoices')->with('success', "Invoices '$id' was removed");
    }

    /**
     * Create a draft invoice with new invoice id and client details
     * @param Request $request
     */
    public function createDraft(Request $request)
    {
        $invoice = array();
        $invoice['invoice_id'] = $this->_generateInvoiceNum();
        $invoice['client'] = Client::find($request->input('client_id'));
        $invoice['items'] = [];

        $request->session()->put('invoice', $invoice);
    }

    /**
     * Save draft invoice line items to existing session
     * @param Request $request
     */
    public function saveDraft(Request $request)
    {
        $items = json_decode($request->input('items'));

        try {
            $request->session()->put('invoice.items', $items);

            return 'success';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Discard draft invoice
     * @param Request $request
     */
    public function discardDraft(Request $request)
    {
        $request->session()->flush();

        return redirect('/invoices')->with('success', "Draft invoice discarded successfully!");
    }

    public function issueInvoice(Request $request) {
        if ($request->session()->has('invoice')) {
            $data = $request->session()->get('invoice');

            // store invoice in db
            $this->store($request);

            // send email
            $data = [
                'invoice' => $data,
                'verification_code' => config('custom.email_verification_code')
            ];

            $admin_email = config('custom.admin_email');
            $client_email = ($data['invoice']['client']->C_Email == '')
                            ? $admin_email
                            : $data['invoice']['client']->C_Email;
            Mail::bcc($admin_email)->to($client_email)->send(new InvoiceEmail($data));

            // discard draft invoice
            $request->session()->flush();

            return redirect('/invoices')->with('success', "Invoice was successfully created and sent!");
        } else {
            return redirect('/invoices')->with('error', "Invoice details missing!");
        }
    }

    public function markPaid($id)
    {
        $invoice = DB::select("select * from tblinv_info where Inv_Num = ?", [$id]);

        return view('invoices.mark-paid')->with('invoice', $invoice);
    }

    public function confirmPayment(Request $request) {
        $this->validate($request, [
            'inv_num'       => 'required',
            'date_paid'     => 'required'
        ]);

        $id = $request->input('inv_num');

        // Mark invoice as paid
        $invoice = Invoice::find($id);
        $invoice->Inv_Paid       = 'Y';
        $invoice->Inv_Paid_Date  = $request->input('date_paid');
        $invoice->Comments       = $request->input('comment');
        $invoice->save();

        return redirect('/invoices/' . $id)->with('success', "Invoice '$id' was marked as paid");
    }

    /**
     * Generate a new invoice number
     *
     * @return string
     */
    private function _generateInvoiceNum()
    {
        $invoice = DB::select("SELECT Inv_Num FROM `tblinv_info`  ORDER BY CONVERT(REPLACE(`Inv_Num`, 'INV', ''), INT) DESC LIMIT 1");

        foreach ($invoice as $row) {
            $inv_num = str_replace('INV', '', $row->Inv_Num);
            $new_inv_num = (int) $inv_num + 1;
        }

        if (strlen($inv_num) > strlen($new_inv_num)) {

            // put back leading zeros
            $diff = strlen($inv_num) - strlen($new_inv_num);
            for ($i = 1; $i <= $diff; $i++) {
                $new_inv_num = '0' . $new_inv_num;
            }
            $new_inv_num = 'INV' . $new_inv_num;
        } else {
            $new_inv_num = 'INV' . $new_inv_num;
        }

        return $new_inv_num;
    }
}
