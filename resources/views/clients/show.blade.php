@extends('layouts.app')

@section('content')

    <a href="/clients" class="btn btn-secondary"><< Back</a>
    @foreach($client as $c)
        <h1>{{$c->C_name}} {{$c->C_surname}}</h1>
        <p><strong>ID Number:</strong> {{$c->Client_id}}</p>
        <p>
            <strong>Address:</strong> {{$c->Address}}, {{$c->Code}}
        </p>
        <p><strong>Reference:</strong> {{$c->Description}}</p>
        <h3>Contact Details:</h3>
        <p>
            <strong>Email:</strong> {{$c->C_Email}}<br>
            <strong>Cell:</strong> {{$c->C_Tel_Cell}}<br>
            <strong>Home:</strong> {{$c->C_Tel_H}}<br>
            <strong>Work:</strong> {{$c->C_Tel_W}}
        </p>
    @endforeach

@endsection
