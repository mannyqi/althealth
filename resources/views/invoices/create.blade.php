@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Create Invoice</h1></div>
        @if(Session::get('invoice'))
            <div class="col-sm-6 text-right"><a href="javascript:;" id="invoice-discard" class="btn btn-danger">Discard Draft Invoice</a></div>
        @else
            <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/invoices" class="btn btn-secondary"><< Back</a></div>
        @endif
    </div>

    <?php //Session::flush(); ?>

    @if(Session::get('invoice'))
        <pre>
        <?php //print_r(Session::get('invoice')); ?>
        </pre>
        <?php $invoice = Session::get('invoice'); ?>
        {!! Form::open(['action' => 'InvoicesController@create', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-6">
                    <img src="{{asset('images/logo.png')}}" style="max-width: 100px" class="img-fluid logo" alt="{{config('app.name', 'AltHealth')}}" />
                </div>
                <div class="col-6 text-right">
                    <h1>INVOICE</h1>
                    <p>
                        <strong>Invoice #:</strong> {{$invoice['invoice_id']}}<br />
                        <strong>Date:</strong> {{date('d-m-Y')}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h2>FROM</h2>
                    <h4>{{config('app.name', 'AltHealth')}}</h4>
                    <p>
                        <strong>Address:</strong> 22 Captain street, Cape Town, 8001<br />
                        <strong>Email:</strong> accounts@althealth.co.za<br />
                        <strong>Phone:</strong> 021 123 4567
                    </p>
                </div>
                <div class="col-6">
                    <h2>TO</h2>
                    <h4>{{$invoice['client']->C_name}} {{$invoice['client']->C_surname}}</h4>
                    <p>
                        <strong>Address:</strong> {{$invoice['client']->Address}}, {{$invoice['client']->Code}}<br />
                        <strong>Email:</strong> {{$invoice['client']->C_Email}}<br />
                        <strong>Phone:</strong> {{$invoice['client']->C_Tel_W}}
                    </p>
                </div>
            </div>
            <hr />

            <template id="invoice-lineitem-template">
                <tr>
                    <td>
                        <select name="supplement_id" class="form-control-sm invoice-lineitem-supplement">
                            <option value="">Select</option>
                            @foreach($supplements as $supplement)
                                <option value="{{$supplement->Supplement_id}}" data-title="{{$supplement->Supplement_Description}}" data-cost="{{$supplement->Cost_excl}}">{{$supplement->Supplement_id}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="item-description">n/a</td>
                    <td><input type="input" value="0.00" disabled name="cost-excl-sum" class="form-control-sm"></td>
                    <td><input type="input" value="1" class="form-control-sm line-item-qty"></td>
                    <td><input type="input" value="0.00" disabled name="cost-excl-sum" class="form-control-sm"></td>
                    <td><strong class="item-subtotal">0.00</strong></td>
                    <td><a href="javascript:;" class="btn btn-sm btn-danger line-item-delete">X</a></td>
                </tr>
            </template>
            <table class="table table-light table-striped invoice-line-items">
                <thead>
                <tr>
                    <th>Supplement ID</th>
                    <th>Description</th>
                    <th>Unit Price (excl.)</th>
                    <th>Quantity</th>
                    <th>Price (excl.)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice['items'] as $item) { ?>
                        <tr>
                            <td>

                                <select name="supplement_id" class="form-control-sm invoice-lineitem-supplement">
                                    <option value="">Select</option>
                                    @foreach($supplements as $supplement)
                                        <option value="{{$supplement->Supplement_id}}" data-title="{{$supplement->Supplement_Description}}" data-cost="{{$supplement->Cost_excl}}" <?php if ($supplement->Supplement_id == $item->supplement_id) {?>selected<?php } ?>>{{$supplement->Supplement_id}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="item-description">n/a</td>
                            <td><input type="input" value="0.00" disabled name="cost-excl" class="form-control-sm"></td>
                            <td><input type="input" value="{{$item->qty}}" class="form-control-sm line-item-qty"></td>
                            <td><input type="input" value="0.00" disabled name="cost-excl-sum" class="form-control-sm"></td>
                            <td><strong class="item-subtotal">0.00</strong></td>
                            <td><a href="javascript:;" class="btn btn-sm btn-danger line-item-delete">X</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><button type="button" class="btn btn-sm btn-success" id="create-invoice-lineitem">Add Line Item</button></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><h5>Total (Excl.):</h5></td>
                        <td><strong id="invoice-total-excl">R {{number_format(0, 2, '.', ' ')}}</strong></td>
                    </tr>
                    <tr>
                        <?php $tax = 0; ?>
                        <td colspan="5" class="text-right"><h5>Total (Incl.):</h5></td>
                        <td><strong id="invoice-total-incl">R {{number_format($tax, 2, '.', ' ')}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        {!! Form::close() !!}

        <div class="row">
            <div class="col text-right"><a href="javascript:;" style="display: none;" class="btn btn-info float-right" id="invoice-issue" title="Create and email invoice to client">Issue Invoice</a></div>
        </div>
    @else
        {!! Form::open(['action' => 'InvoicesController@store', 'method' => 'POST']) !!}
            <div class="form-row">

                <div class="form-group">
                    <?php
                    $cl = ['' => 'Please select client'];
                    foreach ($clients as $client) {
                        $cl[$client->Client_id] = $client->C_name . ' ' . $client->C_surname . ' - ' . $client->Client_id;
                    }
                    ?>
                    {{Form::label('invoice-clients', 'Clients')}}
                    {{Form::select('invoice-clients', $cl, '', ['class' => 'form-control'])}}
                    <div class="row">
                        <div class="col" id="invoice-client-confirm-info" style="display: none;">
                            <p class="invoice-client-confirm-name"><strong>Name:</strong> <span></span></p>
                            <p class="invoice-client-confirm-email"><strong>Email:</strong> <span></span></p>
                            <p class="invoice-client-confirm-cell"><strong>Cell:</strong> <span></span></p>
                            <p class="invoice-client-confirm-address"><strong>Address:</strong> <span></span></p>

                            <a href="#" id="invoice-client-confirm" class="btn btn-primary">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    @endif

@endsection
