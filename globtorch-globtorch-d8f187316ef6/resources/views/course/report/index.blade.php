@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Reports</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Select Course</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-header">
                        <h3>Report - Select Course to view</h3>
                    </div>
                    <div class="card-body">
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
                                            <a href="{{route('course.report.show', [$course->id])}}" title="View">View Report</a>
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