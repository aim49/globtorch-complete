@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Notifications</h3>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['action' => 'NotificationController@send_announcement', 'method'=>'POST']) !!}
                            <div class="form-group row">
                                {{Form::label('to', 'To', ['class'=>'col-lg-4 col-form-label'])}} 
                                {{Form::select('to', ['all_users' => 'All users', 'all_students' => 'All students', 'paid_students' => 'Paid Students', 'teachers' => 'Teachers', 'students_inactive' => 'Inactive Students', 'teachers_inactive' => 'Inactive Teachers', 'never_logged_in' => 'Users who never logged in'], null, ['placeholder' => 'select...', 'class' => 'col-lg-8 form-control'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('message', 'Message', ['class'=>'col-lg-4 col-form-label'])}} 
                                {{Form::textarea('message', '', ['placeholder' => 'message...', 'class' => 'col-lg-8', 'maxlength' => '160'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::submit('Send', ['class' => 'btn btn-primary btn-block'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection