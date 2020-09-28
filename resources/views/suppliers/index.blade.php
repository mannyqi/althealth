@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6"><h1>Suppliers</h1></div>
        <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/suppliers/create" class="btn btn-success">Create New Supplier</a></div>
    </div>

    @if(count($suppliers) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Supplier</th>
                <th>Contact Person</th>
                <th>Telephone</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="data-container-supplier">
            @foreach ($suppliers as $supplier)
                <tr>
                    <td><a href="{{ env('APP_URL') }}/suppliers/{{$supplier->Supplier_id}}" title="View supplier info">{{$supplier->Supplier_id}}</a></td>
                    <td>{{$supplier->Contact_Person}}</td>
                    <td>{{$supplier->Supplier_Tel}}</td>
                    <td class="text-right">
                        <a href="{{ env('APP_URL') }}/suppliers/{{$supplier->Supplier_id}}/edit" class="btn btn-sm btn-primary">Edit</a> &nbsp;

                        {!! Form::open(['action' => ['SuppliersController@destroy', $supplier->Supplier_id], 'method' => 'POST', 'class' => 'float-right', 'onsubmit' => 'return altApp.deleteSupplier()']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$suppliers->links()}}
    @else
        <p class="alert alert-warning">No suppliers found</p>
    @endif
@endsection
