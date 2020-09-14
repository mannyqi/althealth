@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6"><h1>Invoices</h1></div>
        <div class="col-sm-6 text-right"><a href="/invoices/create" class="btn btn-success">Create New Invoice</a></div>
    </div>

    @if(count($invoices) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Invoice</th>
                <th>Client</th>
                <th>Date Created</th>
                <th>Date Paid</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="data-container-invoice">
            @foreach ($invoices as $invoice)
                <tr>
                    <td><a href="/invoices/{{$invoice->Inv_Num}}" title="View invoice info">{{$invoice->Inv_Num}}</a></td>
                    <td>{{$invoice->C_name}} {{$invoice->C_surname}}</td>
                    <td>{{$invoice->Inv_Date}}</td>
                    <td>{{$invoice->Inv_Paid_Date}}</td>
                    <td class="text-right">
{{--                        <a href="/invoices/{{$invoice->Inv_Num}}/edit" class="btn btn-sm btn-primary">Edit</a> &nbsp;--}}

                        {!! Form::open(['action' => ['InvoicesController@destroy', $invoice->Inv_Num], 'method' => 'POST', 'class' => 'float-right', 'onsubmit' => 'return altApp.deleteInvoice()']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$invoices->links()}}
    @else
        <p class="alert alert-warning">No invoices found</p>
    @endif
@endsection
