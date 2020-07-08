@extends('layouts.app')

@section('content')

    <a href="/supplements" class="btn btn-secondary"><< Back</a>
    @foreach($supplement as $s)
        <h1>{{$s->Supplement_Description}}</h1>
        <p><strong>Supplier:</strong> {{$s->Supplier_id}}</p>
        <p><strong>Nappi Code:</strong> {{$s->Nappi_code}}</p>
        <h3>Additional Information:</h3>
        <p>
            <strong>Current Stock:</strong> {{$s->Current_stock_levels}}<br>
            <strong>Minimum Level:</strong> {{$s->Min_levels}}<br>
            <strong>Price Excluding:</strong> R {{$s->Cost_excl}}<br>
            <strong>Price Including:</strong> R {{$s->Cost_incl}}
        </p>
    @endforeach

@endsection
