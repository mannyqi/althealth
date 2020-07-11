@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Client Contact Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Client</th>
                <th>Home</th>
                <th>Work</th>
                <th>Cell</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->CLIENT}}</td>
                    <td>{{$report->HOME}}</td>
                    <td>{{$report->WORK}}</td>
                    <td>{{$report->CELL}}</td>
                    <td>{{$report->EMAIL}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
