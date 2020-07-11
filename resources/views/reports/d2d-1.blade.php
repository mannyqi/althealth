@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Unpaid Invoices Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Client ID</th>
                <th>Client</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->CLIENT_ID}}</td>
                    <td>{{$report->CLIENT}}</td>
                    <td>{{$report->INVOICE_NUMBER}}</td>
                    <td>{{$report->INVOICE_DATE}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
