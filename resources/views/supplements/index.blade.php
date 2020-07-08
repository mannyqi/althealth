@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6"><h1>Supplements</h1></div>
        <div class="col-sm-6 text-right"><a href="/supplements/create" class="btn btn-success">Create New Supplement</a></div>
    </div>

    @if(count($supplements) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Supplement ID</th>
                <th>Supplier</th>
                <th>Description</th>
                <th>Stock Qty</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="data-container-supplement">
            @foreach ($supplements as $supplement)
                <tr>
                    <td><a href="/supplements/{{$supplement->Supplement_id}}" title="View supplement info">{{$supplement->Supplement_id}}</a></td>
                    <td>{{$supplement->Supplier_id}}</td>
                    <td>{{$supplement->Supplement_Description}}</td>
                    <td>{{$supplement->Current_stock_levels}}</td>
                    <td class="text-right">
                        <a href="/supplements/{{$supplement->Supplement_id}}/edit" class="btn btn-sm btn-primary">Edit</a> &nbsp;

                        {!! Form::open(['action' => ['SupplementsController@destroy', $supplement->Supplement_id], 'method' => 'POST', 'class' => 'float-right']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$supplements->links()}}
    @else
        <p class="alert alert-warning">No supplements found</p>
    @endif
@endsection
