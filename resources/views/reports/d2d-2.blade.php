@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Client Birthdays Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Client ID</th>
                <th>Client Name</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->CLIENT_ID}}</td>
                    <td>{{$report->CLIENT_NAME}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
