@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-6"><h1>Create Client</h1></div>
        <div class="col-sm-6 text-right"><a href="{{ env('APP_URL') }}/clients" class="btn btn-secondary"><< Back</a></div>
    </div>

    {!! Form::open(['action' => 'ClientsController@store', 'method' => 'POST']) !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}} <span class="text-danger">*</span>
                {{Form::text('name', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('surname')}} <span class="text-danger">*</span>
                {{Form::text('surname', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('idnum', 'ID Number')}} <span class="text-danger">*</span>
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
            {{Form::label('email', 'Email')}} <span class="text-danger">*</span>
            {{Form::email('email', '', ['class' => 'form-control'])}}
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {{Form::label('telh', 'Telephone (Home)')}} <span class="text-danger">*</span>
                {{Form::text('telh', '', ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)', 'maxlength' => '18'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('telw', 'Telephone (Work)')}} <span class="text-danger">*</span>
                {{Form::text('telw', '', ['class' => 'form-control', 'placeholder' => 'e.g. (011)-(123)-(4567)', 'maxlength' => '18'])}}
            </div>
            <div class="form-group col-md-4">
                {{Form::label('cell', 'Cell')}} <span class="text-danger">*</span>
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
            {{Form::label('reference', 'Reference')}} <span class="text-danger">*</span>
            {{Form::select('reference', $ref, '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary client-form-btn'])}}
    {!! Form::close() !!}

@endsection
