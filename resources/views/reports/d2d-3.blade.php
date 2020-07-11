@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12"><h1>Supplements Below Stock Level Report</h1></div>
    </div>

    @if(count($reports) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>Supplement</th>
                <th>Supplier Information</th>
                <th>Min Levels</th>
                <th>Current Stock</th>
            </tr>
            </thead>
            <tbody id="data-container-report">
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->SUPPLEMENT}}</td>
                    <td>{{$report->SUPPLIER_INFORMATION}}</td>
                    <td>{{$report->MIN_LEVELS}}</td>
                    <td>{{$report->CURRENT_STOCK}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No results found</p>
    @endif
@endsection
