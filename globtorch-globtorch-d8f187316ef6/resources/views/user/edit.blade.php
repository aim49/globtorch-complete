@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Profile</h3>
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
                        <div class="form-validation">
                            {!! Form::open(['action' => ['UserController@update', $user->id], 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('name', 'Name', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Enter name...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('surname', 'Surname', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::text('surname', $user->surname, ['class' => 'form-control', 'placeholder' => 'Enter surname...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('dob', 'Date of Birth', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::date('dob', $user->dob, ['class' => 'form-control', 'placeholder' => 'Enter date of birth...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('gender', 'Gender', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        @if ($user->gender == 'male')
                                            {{Form::radio('gender', 'male', true)}} Male
                                            {{Form::radio('gender', 'female')}} Female
                                        @elseif ($user->gender == 'female')
                                            {{Form::radio('gender', 'male')}} Male
                                            {{Form::radio('gender', 'female', true)}} Female
                                        @else
                                            {{Form::radio('gender', 'male')}} Male
                                            {{Form::radio('gender', 'female')}} Female
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('address', 'Address', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::textarea('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Enter address...', 'rows' => '3', 'style' => 'height:100%'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('city', 'City', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::text('city', $user->city, ['class' => 'form-control', 'placeholder' => 'Enter city...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('country', 'Country', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8 ">
                                        {{Form::select('country', $countries, $user->country ,['class' => 'form-control'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('phone', 'Phone Number', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::text('phone', $user->phone, ['class' => 'form-control', 'placeholder' => 'Enter phone number...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::label('email', 'Email', ['class' => 'col-lg-4 col-form-label required'])}}
                                    <div class="col-lg-8">
                                        {{Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Enter email address...'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::submit('Update', ['class' => 'btn btn-primary btn-block'])}}
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