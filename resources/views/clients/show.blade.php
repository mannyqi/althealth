@extends('layouts.app')

@section('content')

    <a href="/clients" class="btn btn-secondary"><< Back</a>
    @foreach($client as $c)
        <h1>{{$c->C_name}} {{$c->C_surname}}</h1>
        <p>ID Number: {{$c->Client_id}}</p>
        <p>
            Address: {{$c->Address}}, {{$c->Code}}
        </p>
        <p>Reference: {{$c->Description}}</p>
        <h3>Contact Details:</h3>
        <p>
            Email: {{$c->C_Email}}<br>
            Cell: {{$c->C_Tel_Cell}}<br>
            Home: {{$c->C_Tel_H}}<br>
            Work: {{$c->C_Tel_W}}
        </p>
    @endforeach

@endsection
