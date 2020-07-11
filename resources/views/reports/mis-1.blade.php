@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Top 10 Most Frequent Buyers Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Client</th>
                <th>Frequency</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
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
