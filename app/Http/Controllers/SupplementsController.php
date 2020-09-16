<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplement;
use DB;

class SupplementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Production
        $supplements = Supplement::orderBy('Supplement_Description', 'asc')->paginate(10);

        // Staging
//        $supplements = DB::select("select * from tblsupplements order by Supplement_Description asc limit 10 offset 0");

        return view('supplements.index')->with('supplements', $supplements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = DB::select("select * from tblsupplier_info order by Supplier_id");

        return view('supplements.create')->with('suppliers', $suppliers);
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
            'name'          => 'required',
            'supplier'      => 'required',
            'costexcl'      => 'required',
            'qty'           => 'required',
            'minlvl'        => 'required'
        ]);

        // Create Supplements
        $sup = new Supplement;
        $sup->Supplement_id             = $this->_generateSupplementId();
        $sup->Supplement_Description    = $request->input('name');
        $sup->Supplier_id               = $request->input('supplier');
        $sup->Nappi_code                = $request->input('nappi');
        $sup->Cost_excl                 = $request->input('costexcl');
        $sup->Cost_incl                 = $request->input('costexcl') * (config('custom.tax_rate') / 100 + 1);
        $sup->Current_stock_levels      = $request->input('qty');
        $sup->Min_levels                = $request->input('minlvl');
        $sup->save();

        return redirect('/supplements')->with('success', 'Supplement created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplement = DB::select("select * from tblsupplements where Supplement_id = ?", [$id]);

        return view('supplements.show')->with('supplement', (object) $supplement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplement = DB::select("select * from tblsupplements where Supplement_id = ?", [$id]);

        $suppliers = DB::select("select * from tblsupplier_info order by Supplier_id");

        $data = [
            'supplement' => $supplement,
            'suppliers' => $suppliers
        ];

        return view('supplements.edit')->with($data);
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
            'name'          => 'required',
            'supplier'      => 'required',
            'costexcl'      => 'required',
            'qty'           => 'required',
            'minlvl'        => 'required'
        ]);

        // Create Supplements
        $sup = Supplement::find($id);
        $sup->Supplement_Description    = $request->input('name');
        $sup->Supplier_id               = $request->input('supplier');
        $sup->Nappi_code                = $request->input('nappi');
        $sup->Cost_excl                 = $request->input('costexcl');
        $sup->Cost_incl                 = $request->input('costexcl') * (config('custom.tax_rate') / 100 + 1);
        $sup->Current_stock_levels      = $request->input('qty');
        $sup->Min_levels                = $request->input('minlvl');
        $sup->save();

        return redirect('/supplements')->with('success', "Supplement '$id' updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Supplement::find($id);
        $client->delete();

        return redirect('/supplements')->with('success', "Supplements '$id' was removed");
    }

    /**
     * Generate a new supplement ID
     * @return string
     */
    private function _generateSupplementId()
    {
        $sup = DB::select("SELECT Supplement_id FROM `tblsupplements` ORDER BY CONVERT(REPLACE(`Supplement_id`, 'Supplement-', ''), INT) DESC LIMIT 1");
        $new_sup_id = 0;
        foreach ($sup as $row) {
            $sup_id = str_replace('Supplement-', '', $row->Supplement_id);
            $new_sup_id = (int) $sup_id + 1;
            $new_sup_id = 'Supplement-' . $new_sup_id;
        }

        return $new_sup_id;
    }
}
