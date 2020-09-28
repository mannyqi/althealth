@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Edit Supplier</h1></div>
        <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/suppliers" class="btn btn-secondary"><< Back</a></div>
    </div>

    @foreach($supplier as $s)
    {!! Form::open(['action' => ['SuppliersController@update', $s->Supplier_id], 'method' => 'POST']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name (ID)')}}
                {{Form::text('name', $s->Supplier_id, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('contact', 'Contact Person')}}
                {{Form::text('contact', $s->Contact_Person, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('tel', 'Telephone')}}
            {{Form::text('tel', $s->Supplier_Tel, ['class' => 'form-control', 'placeholder' => 'e.g. (123)-(456)-(7890)'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::email('email', $s->Supplier_Email, ['class' => 'form-control'])}}
        </div>
        <h3>Banking Details:</h3>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('bank', 'Bank')}}
                {{Form::text('bank', $s->Bank, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('branch', 'Branch Code')}}
                {{Form::text('branch', $s->Bank_Code, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('account_num', 'Account Number')}}
                {{Form::text('account_num', $s->Supplier_BankNum, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('account_type', 'Account Type')}}
                {{Form::select('account_type', ['' => 'Please select', 'Cheque' => 'Cheque', 'Credit' => 'Credit', 'Savings' => 'Savings'], $s->Supplier_Type_Bank_Account, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    @endforeach

@endsection
