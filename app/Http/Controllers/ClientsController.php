<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Production
        $clients = Client::orderBy('C_name', 'asc')->paginate(10);

        // Staging
//        $clients = DB::select("select * from tblclientinfo order by C_name asc limit 10 offset 0");

        return view('clients.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $references = DB::select("select * from tblreference");

        return view('clients.create')->with('references', $references);
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

        // Create Client
        $client = new Client;
        $client->C_name         = $request->input('name');
        $client->C_surname      = $request->input('surname');
        $client->Client_id      = $request->input('idnum');
        $client->Address        = $request->input('address');
        $client->Code           = $request->input('zip');
        $client->C_Email        = $request->input('email');
        $client->C_Tel_H        = $request->input('telh');
        $client->C_Tel_W        = $request->input('telw');
        $client->C_Tel_Cell     = $request->input('cell');
        $client->Reference_ID   = $request->input('reference');
        $client->save();

        return redirect('/clients')->with('success', 'Client created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = DB::select("select c.*, r.Description from tblclientinfo c
                                inner join tblreference r on r.Reference_ID = c.Reference_ID
                                where c.Client_id = ?", [$id]);

        return view('clients.show')->with('client', (object) $client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = DB::select("select * from tblclientinfo where Client_id = ?", [$id]);

        $references = DB::select("select * from tblreference");

        $data = [
            'client' => $client,
            'references' => $references
        ];

        return view('clients.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

        // Create Client
        $client = Client::find($id);
        $client->C_name         = $request->input('name');
        $client->C_surname      = $request->input('surname');
        $client->Client_id      = $request->input('idnum');
        $client->Address        = $request->input('address');
        $client->Code           = $request->input('zip');
        $client->C_Email        = $request->input('email');
        $client->C_Tel_H        = $request->input('telh');
        $client->C_Tel_W        = $request->input('telw');
        $client->C_Tel_Cell     = $request->input('cell');
        $client->Reference_ID   = $request->input('reference');
        $client->save();

        return redirect('/clients')->with('success', "Client '$id' updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect('/clients')->with('success', "Client '$id' was removed");
    }

    public function getClient($id)
    {
        $client = Client::find($id);

        return $client->toJson(JSON_PRETTY_PRINT);
    }
}
