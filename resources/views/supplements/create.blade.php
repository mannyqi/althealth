@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Create Supplement</h1></div>
        <div class="col-sm-6 text-right"><a href="/supplements" class="btn btn-secondary"><< Back</a></div>
    </div>

    {!! Form::open(['action' => 'SupplementsController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('supplier', 'Supplier')}}
                {{Form::select('account_type', ['' => 'Please select', 'Cheque' => 'Cheque', 'Credit' => 'Credit', 'Savings' => 'Savings'], '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('nappi', 'Nappi Code')}}
                {{Form::text('nappi', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                {{Form::label('costexcl', 'Cost Excl.')}}
                {{Form::text('costexcl', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-3">
                {{Form::label('costincl', 'Cost Incl.')}}
                {{Form::text('costincl', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-3">
                {{Form::label('qty', 'Stock Qty')}}
                {{Form::text('qty', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-3">
                {{Form::label('minlvl', 'Min Level')}}
                {{Form::text('minlvl', '', ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
