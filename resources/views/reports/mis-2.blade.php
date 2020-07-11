@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Number of Purchases Per Month Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>No of Purchases</th>
                <th>Month</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->NUM_OF_PURCHASES}}</td>
                    <td>{{$report->MONTH}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
