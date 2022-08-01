@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Create Note</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Page Content  -->
    <div class="container-fluid">
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
                            {!! Form::open(['action' => 'NoteController@store', 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('note', 'Note', ['class'=>'col-lg-4 col-form-label'])}} 
                                    {{Form::textarea('note', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'note', 'maxlength' => '255'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extraJS')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'note' );
    </script>
@endsection