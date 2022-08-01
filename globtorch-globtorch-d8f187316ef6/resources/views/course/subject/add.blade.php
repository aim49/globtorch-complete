@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Create {{$course->name}} Subjects</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Subject From Existing</li>
            </ol>
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
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h3>{{$course->name}}</h3>
                </div>
                <div class="card-body">
                    <p class="text-info">Your existing subjects currently on this course</p>
                    @foreach ($course->subjects->sortBy('name') as $subject)
                        {{$subject->name}}<br />
                    @endforeach
                </div>
            </div>
            {!! Form::open(['action' => ['CourseSubjectController@storeExistingSubject', $course->id], 'method'=>'POST']) !!}
                @foreach ($otherCourses as $otherCourse)
                    <div class="card">
                        <div class="card-header">
                            {{$otherCourse->name}}
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                @foreach ($otherCourse->subjects->sortBy('name') as $subject)
                                    @if (in_array($subject->id, $existing_subject_ids))
                                        {{Form::checkbox($subject->id, $subject->id, true)}}
                                    @else
                                        {{Form::checkbox($subject->id, $subject->id, false)}}
                                    @endif 
                                    {{$subject->name}}<br/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="form-group row">
                    {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
