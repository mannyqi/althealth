@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Top 10 Most Frequent Buyers Report</h1></div>
    </div>

    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <p class="lead">Enter a "From" and "To" year to filter the results by. By default "From" year is 2012 and "To" year is the current year.</p>
                <hr class="my-4">
                {!! Form::open(['action' => ['ReportsController@mis1'], 'method' => 'POST']) !!}
                    <div class="form-row align-items-center">
                        <div class="col-sm-3 my-1">
                            {{Form::label('from_date', 'From Date', ['class' => 'sr-only'])}}
                            {{Form::text('from_date', $data['from_date'], ['class' => 'form-control', 'placeholder' => 'To'])}}
                        </div>
                        <div class="col-sm-3 my-1">
                            {{Form::label('to_date', 'To Date', ['class' => 'sr-only'])}}
                            {{Form::text('to_date', $data['to_date'], ['class' => 'form-control', 'placeholder' => 'To'])}}
                        </div>
                        <div class="col-auto my-1">
                            {{Form::submit('Filter', ['class' => 'btn btn-primary'])}}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if(count($data['report']) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Client</th>
                <th>Frequency</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($data['report'] as $report)
                <tr>
                    <td>{{$report->CLIENT}}</td>
                    <td>{{$report->FREQUENCY}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
