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
                <?php
                $sup = ['' => 'Please select'];
                foreach ($suppliers as $supplier) {
                    $sup[$supplier->Supplier_id] = $supplier->Supplier_id;
                }
                ?>
                {{Form::label('supplier', 'Supplier')}}
                {{Form::select('supplier', $sup, '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('nappi', 'Nappi Code')}}
                {{Form::text('nappi', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-3">
                {{Form::label('costexcl', 'Cost Excl.')}}
                {{Form::text('costexcl', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-sm-2">
                {{Form::label('rate', 'VAT Rate (%)')}}
                {{Form::text('rate', '', ['class' => 'form-control', 'placeholder' => 'eg. 15'])}}
            </div>
            <div class="form-group col-sm-3">
                {{Form::label('costincl', 'Cost Incl.')}}
                {{Form::text('costincl', '0.00', ['class' => 'form-control', 'disabled'])}}
            </div>
            <div class="form-group col-sm-2">
                {{Form::label('qty', 'Stock Qty')}}
                {{Form::text('qty', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-sm-2">
                {{Form::label('minlvl', 'Min Level')}}
                {{Form::text('minlvl', '', ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary supplement-form-btn'])}}
    {!! Form::close() !!}

@endsection
