@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Profile</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Teacher</li>
            </ol>
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
                            {!! Form::open(['action' => 'PasswordController@set', 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('current_password', 'Current Password', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::password('current_password', ['class' => 'form-control', 'placeholder' => 'Current Password'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('new_password', 'New Password', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'New Password'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('verify_password', 'Verify Password', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::password('verify_password', ['class' => 'form-control', 'placeholder' => 'Verify Password'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                    </div>
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