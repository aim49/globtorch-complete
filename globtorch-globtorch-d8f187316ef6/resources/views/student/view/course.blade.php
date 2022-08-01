@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Students By Course</h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
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
            @endif @if(session()->has('message'))
            <div class="card">
                <div class="card-body">
                    <div style="color:green">
                        {{ session()->get('message') }}
                    </div><br />
                </div>
            </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        @if (count($courses) > 0)
                            @foreach ($courses as $course)
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                    <div class="welcome-box">
                                        <img src="{{asset('storage/course/' . $course->image)}}" alt="course" width="370" height="440" />
                                        <div class="welcome-title">
                                            <h3>{{$course->name . ' (' . $course->exam_boards->first()->name . ')'}}</h3>
                                        </div>
                                        <div class="welcome-content">
                                            <span>({{$course->level}})</span>
                                            <a href="{{ route('student.view.by_course', [$course->id]) }}" title="View">View Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <p class="text-info">You currently do not have any courses that you are enrolled on.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection