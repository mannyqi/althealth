@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Edit Supplement</h1></div>
        <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/supplements" class="btn btn-secondary"><< Back</a></div>
    </div>

    @foreach($supplement as $s)
    {!! Form::open(['action' => ['SupplementsController@update', $s->Supplement_id], 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $s->Supplement_Description, ['class' => 'form-control'])}}
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
                {{Form::select('supplier', $sup, $s->Supplier_id, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('nappi', 'Nappi Code')}}
                {{Form::text('nappi', $s->Nappi_code, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                {{Form::label('costexcl', 'Cost Excl.')}}
                {{Form::text('costexcl', $s->Cost_excl, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-2">
                {{Form::label('rate', 'VAT Rate (%)')}}
                {{Form::text('rate', config('custom.tax_rate', 15), ['class' => 'form-control', 'disabled'])}}
            </div>
            <div class="form-group col-sm-3">
                {{Form::label('costincl', 'Cost Incl.')}}
                {{Form::text('costincl', $s->Cost_incl, ['class' => 'form-control', 'disabled'])}}
            </div>
            <div class="form-group col-md-2">
                {{Form::label('qty', 'Stock Qty')}}
                {{Form::text('qty', $s->Current_stock_levels, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-2">
                {{Form::label('minlvl', 'Min Level')}}
                {{Form::text('minlvl', $s->Min_levels, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary supplement-form-btn'])}}
    {!! Form::close() !!}
    @endforeach

@endsection
