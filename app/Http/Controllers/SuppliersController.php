<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use DB;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Production
        $suppliers = Supplier::orderBy('Supplier_id', 'asc')->paginate(10);

        // Staging
//        $suppliers = DB::select("select * from tblsupplier_info order by Supplier_id asc limit 10 offset 0");

        return view('suppliers.index')->with('suppliers', $suppliers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
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
            'name'       => 'required',
            'contact'    => 'required',
            'tel'        => 'required',
            'email'      => 'required'
        ]);

        // Create Supplier
        $supplier = new Supplier;
        $supplier->Supplier_id                       = $request->input('name');
        $supplier->Contact_Person                    = $request->input('contact');
        $supplier->Supplier_Tel                     = $request->input('tel');
        $supplier->Supplier_Email                    = $request->input('email');
        $supplier->Bank                              = $request->input('bank');
        $supplier->Bank_Code                         = $request->input('branch');
        $supplier->Supplier_BankNum                 = $request->input('account_num');
        $supplier->Supplier_Type_Bank_Account        = $request->input('account_type');
        $supplier->save();

        return redirect('/suppliers')->with('success', 'Supplier created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = DB::select("select * from tblsupplier_info where Supplier_id = ?", [$id]);

        return view('suppliers.show')->with('supplier', (object) $supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = DB::select("select * from tblsupplier_info where Supplier_id = ?", [$id]);

        return view('suppliers.edit')->with('supplier', (object) $supplier);
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
            'name'       => 'required',
            'contact'    => 'required',
            'tel'        => 'required',
            'email'      => 'required'
        ]);

        // Update Suppliers
        $supplier = Supplier::find($id);
        $supplier->Supplier_id                       = $request->input('name');
        $supplier->Contact_Person                    = $request->input('contact');
        $supplier->Supplier_Tel                      = $request->input('tel');
        $supplier->Supplier_Email                    = $request->input('email');
        $supplier->Bank                              = $request->input('bank');
        $supplier->Bank_Code                         = $request->input('branch');
        $supplier->Supplier_BankNum                  = $request->input('account_num');
        $supplier->Supplier_Type_Bank_Account        = $request->input('account_type');
        $supplier->save();

        return redirect('/suppliers')->with('success', "Supplier '$id' updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Supplier::find($id);
        $client->delete();

        return redirect('/suppliers')->with('success', "Suppliers '$id' was removed");
    }
}
