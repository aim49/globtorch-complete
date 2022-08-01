@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Note</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if ($errors->any())
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger" style="color:red">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="card">
                        <div class="card-body">
                            <div style="color:green">
                                {{ session()->get('message') }}
                            </div><br/>
                        </div>
                    </div> 
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            {!! Form::open(['action' => ['NoteController@update', $note->id], 'method'=>'POST'])!!}
                            <div class="form-group row">
                                {{Form::label('note', 'Note', ['class'=>'col-lg-4 col-form-label'])}} 
                                {{Form::text('note', $note->note, ['class' => 'form-control col-lg-6', 'placeholder' => 'note'])}}
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    {{Form::hidden('_method', 'PUT')}} 
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
@endsection
