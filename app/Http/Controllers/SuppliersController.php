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
        $suppliers = Supplier::orderBy('Supplier_id', 'asc')->paginate(10);
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

        // Create Suppliers
        $client = new Suppliers;
        $client->C_name         = $request->input('name');
        $client->C_surname      = $request->input('surname');
        $client->Suppliers_id      = $request->input('idnum');
        $client->Address        = $request->input('address');
        $client->Code           = $request->input('zip');
        $client->C_Email        = $request->input('email');
        $client->C_Tel_H        = $request->input('telh');
        $client->C_Tel_W        = $request->input('telw');
        $client->C_Tel_Cell     = $request->input('cell');
        $client->Reference_ID   = $request->input('reference');
        $client->save();

        return redirect('/suppliers')->with('success', 'Suppliers created successfully');
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

        // Create Suppliers
        $client = Supplier::find($id);
        $client->C_name         = $request->input('name');
        $client->C_surname      = $request->input('surname');
        $client->Suppliers_id      = $request->input('idnum');
        $client->Address        = $request->input('address');
        $client->Code           = $request->input('zip');
        $client->C_Email        = $request->input('email');
        $client->C_Tel_H        = $request->input('telh');
        $client->C_Tel_W        = $request->input('telw');
        $client->C_Tel_Cell     = $request->input('cell');
        $client->Reference_ID   = $request->input('reference');
        $client->save();

        return redirect('/suppliers')->with('success', "Suppliers '$id' updated successfully");
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
