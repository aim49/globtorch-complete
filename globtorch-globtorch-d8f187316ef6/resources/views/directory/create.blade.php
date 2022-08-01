@extends('layout.landing_page.app')
@section('content')
	<div class="container">
        <h1>Create Directory Listing</h1>
        @if ($errors->any())
            <div class="alert alert-danger" style="color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div style="color:green">
                {{ session()->get('message') }}
            </div>
        @endif
        {!! Form::open(['action' => 'DirectoriesController@store', 'method'=>'POST', 'files' => true]) !!}
            <div class="form-group row">
                {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::text('name', '', ['class' => 'form-control col-lg-6', 'maxlength'=>'191', 'required'])}}
            </div>
            <div class="form-group row">
                {{Form::label('level', 'Level', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::select('level', ['primary'=>'primary', 'secondary'=>'secondary', 'tertiary'=>'tertiary'], null, ['placeholder' => 'select', 'required', 'class' => 'form-control col-lg-6'])}}
            </div>
            <div class="form-group row">
                {{Form::label('description', 'Description', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::textarea('description', '', ['class' => 'form-control col-lg-6', 'maxlength'=>'191', 'required'])}}
            </div>
            <div class="form-group row">
                {{Form::label('url', 'Website', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::text('url', '', ['class' => 'form-control col-lg-6', 'maxlength'=>'191', 'required'])}}
            </div>
            <div class="form-group row">
                {{Form::label('phone', 'Phone', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::text('phone', '', ['class' => 'form-control col-lg-6', 'maxlength'=>'191', 'required'])}}
            </div>
            <div class="form-group row">
                {{Form::label('email', 'Email', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::email('email', '', ['class' => 'form-control col-lg-6', 'maxlength'=>'191', 'required'])}}
            </div>
            <div class="form-group row">
                {{Form::label('logo', 'Logo', ['class'=>'col-lg-4 col-form-label'])}}
                {{Form::file('logo', ['accept'=>'image/*'])}}
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
	</div>
@endsection