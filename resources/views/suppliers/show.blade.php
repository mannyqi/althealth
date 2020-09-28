@extends('layouts.app')

@section('content')

    <a href="{{ env('APP_URL') }}/suppliers" class="btn btn-secondary"><< Back</a>
    @foreach($supplier as $s)
        <h1>{{$s->Supplier_id}}</h1>
        <p><strong>Contact Person:</strong> {{$s->Contact_Person}}</p>
        <p><strong>Telephone:</strong> {{$s->Supplier_Tel}}</p>
        <p><strong>Email:</strong> {{$s->Supplier_Email}}</p>
        <h3>Banking Details:</h3>
        <p>
            <strong>Bank:</strong> {{$s->Bank}}<br>
            <strong>Branch Code:</strong> {{$s->Bank_Code}}<br>
            <strong>Account Number:</strong> {{$s->Supplier_BankNum}}<br>
            <strong>Account Type:</strong> {{$s->Supplier_Type_Bank_Account}}
        </p>
    @endforeach

@endsection
