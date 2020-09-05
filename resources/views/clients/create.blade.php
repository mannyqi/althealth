@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Create Client</h1></div>
        <div class="col-sm-6 text-right"><a href="/clients" class="btn btn-secondary"><< Back</a></div>
    </div>

    {!! Form::open(['action' => 'ClientsController@store', 'method' => 'POST']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('surname')}}
                {{Form::text('surname', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('idnum', 'ID Number')}}
            {{Form::text('idnum', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('address', 'Address')}}
            {{Form::textarea('address', '', ['class' => 'form-control', 'placeholder' => 'Street, Suburb, Town', 'rows' => '3'])}}
        </div>
        <div class="form-group">
            {{Form::label('zip', 'Zip code')}}
            {{Form::text('zip', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::email('email', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {{Form::label('telh', 'Telephone (Home)')}}
                {{Form::text('telh', '', ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)', 'maxlength' => '18'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('telw', 'Telephone (Work)')}}
                {{Form::text('telw', '', ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)', 'maxlength' => '18'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('cell', 'Cell')}}
                {{Form::text('cell', '', ['class' => 'form-control', 'placeholder' => 'e.g. (072)-(123)-(4567)', 'maxlength' => '18'])}}
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
            {{Form::select('reference', $ref, '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary client-form-btn'])}}
    {!! Form::close() !!}

@endsection
