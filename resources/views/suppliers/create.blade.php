@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Create Supplier</h1></div>
        <div class="col-sm-6 text-right"><a href="/suppliers" class="btn btn-secondary"><< Back</a></div>
    </div>

    {!! Form::open(['action' => 'SuppliersController@store', 'method' => 'POST']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name (ID)')}}
                {{Form::text('name', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('contact', 'Contact Person')}}
                {{Form::text('contact', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('tel', 'Telephone')}}
            {{Form::text('tel', '', ['class' => 'form-control', 'placeholder' => 'e.g. (123)-(456)-(7890)'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::email('email', '', ['class' => 'form-control'])}}
        </div>
        <h3>Banking Details:</h3>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('bank', 'Bank')}}
                {{Form::text('bank', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('branch', 'Branch Code')}}
                {{Form::text('branch', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('account_num', 'Account Number')}}
                {{Form::text('account_num', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('account_type', 'Account Type')}}
                {{Form::select('account_type', ['' => 'Please select', 'Cheque' => 'Cheque', 'Credit' => 'Credit', 'Savings' => 'Savings'], '', ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
