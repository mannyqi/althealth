@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6"><h1>Clients</h1></div>
        <div class="col-sm-6 text-right"><a href="/clients/create" class="btn btn-success">Create New Client</a></div>
    </div>

    @if(count($clients) > 0)
        <table class="table table-striped table-light">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="data-container-client">
            @foreach ($clients as $client)
                <tr>
                    <td><a href="/clients/{{$client->Client_id}}" title="View client info">{{$client->Client_id}}</a></td>
                    <td>{{$client->C_name}}</td>
                    <td>{{$client->C_surname}}</td>
                    <td class="text-right">
                        <a href="/clients/{{$client->Client_id}}/edit" class="btn btn-sm btn-primary">Edit</a> &nbsp;

                        {!! Form::open(['action' => ['ClientsController@destroy', $client->Client_id], 'method' => 'POST', 'class' => 'float-right', 'onsubmit' => 'return altApp.deleteClient()']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$clients->links()}}
    @else
        <p class="alert alert-warning">No clients found</p>
    @endif
@endsection
