@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Assign Teacher To Subject</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Assign Teacher To Subject</li>
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
                            {!! Form::open(['action' => 'TeacherSubjectsController@store', 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('teacher_id', 'Teacher ID', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('teacher_id', $teacher->id, ['class' => 'form-control col-lg-6'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('name', $teacher->name, ['class' => 'form-control col-lg-6'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('surname', 'Surname', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('surname', $teacher->surname, ['class' => 'form-control col-lg-6'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('user_id', 'User ID', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('user_id', $teacher->school_id, ['class' => 'form-control col-lg-6'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('subjects', 'Subjects', ['class'=>'col-lg-4 col-form-label'])}}
                                    <div class="col-lg-6">
                                        <div class="col-lg-12">
                                            @foreach($courses as $course)
                                                <div class="card" style="background-color:aqua">
                                                    <div class="card-title">
                                                        <h3>{{$course->name}}</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($course->subjects as $subject)
                                                            @if (in_array($subject->id, $teacher_subjects_id))
                                                                <input type="checkbox" name="{{$subject->id}}" checked>{{$subject->name}}&nbsp;&nbsp; 
                                                            @else
                                                                <input type="checkbox" name="{{$subject->id}}">{{$subject->name}}&nbsp;&nbsp;
                                                            @endif      
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Assign</button>
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
