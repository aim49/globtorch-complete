@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Password Reset</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('student.index')}}">Students</a></li>
                <li class="breadcrumb-item active">Reset Password</li>
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
                    <div class="card-header mb-2">
                        <h3>Reset password for {{$user->name}} {{$user->surname}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            {!! Form::open(['action' => ['PasswordController@storePasswordReset', $user->id], 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('password', 'New Password', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password', 'required'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('password_confirmation', 'Verify Password', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Verify Password', 'required'])}}
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