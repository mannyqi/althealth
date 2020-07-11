<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
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
        $invoices = Invoice::orderBy('Inv_Num', 'desc')->paginate(10);

        // Production
        $invoices = DB::select("select inv.*, cl.C_name, cl.C_surname
                                from tblinv_info inv
                                inner join tblclientinfo cl
                                on cl.Client_id = inv.Client_id
                                order by inv.Inv_Num desc limit 10 offset 0");

        return view('invoices.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $client = new Invoices;
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

        return redirect('/invoices')->with('success', 'Invoices created successfully');
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
        $invoice = DB::select("select * from tblinvoices where Invoice_id = ?", [$id]);

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
}
