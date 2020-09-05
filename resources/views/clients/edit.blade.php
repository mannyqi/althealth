@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Edit Client</h1></div>
        <div class="col-sm-6 text-right"><a href="/clients" class="btn btn-secondary"><< Back</a></div>
    </div>

    @foreach($client as $c)
    {!! Form::open(['action' => ['ClientsController@update', $c->Client_id], 'method' => 'POST']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', $c->C_name, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('surname')}}
                {{Form::text('surname', $c->C_surname, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('idnum', 'ID Number')}}
            {{Form::text('idnum', $c->Client_id, ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('address', 'Address')}}
            {{Form::textarea('address', $c->Address, ['class' => 'form-control', 'placeholder' => 'e.g. Street, Suburb, Town', 'rows' => '3'])}}
        </div>
        <div class="form-group">
            {{Form::label('zip', 'Zip code')}}
            {{Form::text('zip', $c->Code, ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::email('email', $c->C_Email, ['class' => 'form-control'])}}
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {{Form::label('telh', 'Telephone (Home)')}}
                {{Form::text('telh', $c->C_Tel_H, ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('telw', 'Telephone (Work)')}}
                {{Form::text('telw', $c->C_Tel_W, ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('cell', 'Cell')}}
                {{Form::text('cell', $c->C_Tel_Cell, ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)'])}}
            </div>
        </div>
        <div class="form-group">
            <?php
            $ref = ['' => 'Please select'];
            foreach ($references as $reference) {
                $ref[$reference->Reference_ID] = $reference->Description;
            }
            ?>
            {{Form::label('reference', 'Reference')}}
            {{Form::select('reference', $ref, $c->Reference_ID, ['class' => 'form-control'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    @endforeach

@endsection
