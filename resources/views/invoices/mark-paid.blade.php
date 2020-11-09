@extends('layouts.app')

@section('content')
    <div class="invoice-mark-paid">
        <div class="row">
            <div class="col-sm-6"><h1>Mark Invoice {{$invoice[0]->Inv_Num}} as Paid</h1></div>
            <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/invoices" class="btn btn-danger">Cancel</a></div>
        </div>
        {!! Form::open(['action' => 'InvoicesController@confirmPayment', 'method' => 'POST']) !!}
        <?php $tax_rate = config('custom.tax_rate', 15); ?>
        @foreach($invoice as $inv)
            {{Form::hidden('inv_num', $inv->Inv_Num)}}
            <div class="form-row">
                <div class="form-group col">
                    {{Form::label('cost_incl', 'Cost Incl.')}}
                    {{Form::text('cost_incl', 'R ' . number_format($inv->total * (1 + $tax_rate), 2, '.', ' '), ['class' => 'form-control', 'disabled'])}}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    {{Form::label('date_paid', 'Date Paid ( DD-MM-YYYY )', ['style' => 'display:block'])}}
                    {{Form::text('date_paid', date('Y-m-d'), ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    {{Form::label('comment', 'Comments')}}
                    {{Form::textarea('comment', '', ['class' => 'form-control'])}}
                </div>
            </div>
            {{Form::submit('Confirm', ['class' => 'btn btn-primary mark-paid-form-btn'])}}
        @endforeach
        {!! Form::close() !!}
    </div>
@endsection
