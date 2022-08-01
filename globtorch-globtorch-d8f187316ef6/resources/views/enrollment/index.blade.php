@extends('layout.master') 
@section('content')

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Your Courses</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
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
                    </div><br/>
                </div>
            </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                    <div class="card">
                        <div class="row">
                            @if (count($enrollments) > 0) 
                                @foreach ($enrollments as $enrollment)
                                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                                        <div class="welcome-box">
                                            <img src="{{asset('storage/course/' . $enrollment->course->image)}}" alt="course" width="370" height="440" />
                                            <div class="welcome-title">
                                                <h3>{{$enrollment->course->name . ' (' . $enrollment->course->exam_boards->first()->name . ')'}}</h3>
                                            </div>
                                            <div class="welcome-content">
                                                <span>({{$enrollment->course->level}})</span>
                                                <ul class="course-detail">
                                                    @if ($enrollment->payments->sortByDesc('end_date')->first()->end_date >= \Carbon\Carbon::now()) 
                                                        @if($enrollment->payments->sortByDesc('end_date')->first()->start_date <=\ Carbon\Carbon::now()) 
                                                            <li>Paid until {{$enrollment->payments->sortByDesc('end_date')->first()->end_date}}</li>
                                                        @else
                                                            <li>Subscription starts on the {{$enrollment->payments->sortByDesc('end_date')->first()->start_date}} up to {{$enrollment->payments->sortByDesc('end_date')->first()->end_date}}</li>
                                                        @endif
                                                        <br>
                                                        <a href="/payment/{{$enrollment->course_id}}" class="btn btn-primary">Extend Subscription</a>                                                
                                                    @else
                                                        <li>Subscription expired on {{$enrollment->payments->sortByDesc('end_date')->first()->end_date}}</li>
                                                        <br>
                                                        <li><a href="/payment/{{$enrollment->course_id}}" class="btn btn-primary">Purchase Subscription</a></li>
                                                    @endif
                                                </ul>
                                                <a href="{{route('course.subject.index',$enrollment->course_id)}}" title="View">View Now</a>
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
                <div class="col-lg-12">
                        <div class="card-title">
                            <h2 class="text-primary">Enroll on a course </h2>
                            <p>Register on a course and get a scholarship for the duration of your course</p>
                        </div>
                        <div class="row">
                            @if (count($courses) > 0) @foreach ($courses as $course)
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="welcome-box">
                                    <img src="{{asset('storage/course/' . $course->image)}}" alt="course" width="370" height="440" />
                                    <div class="welcome-title">
                                        <h3>{{$course->name . ' (' . $course->exam_boards->first()->name . ')'}}</h3>
                                    </div>
                                    <div class="welcome-content">
                                        <span>({{$course->level}})</span>
                                        <ul class="course-detail">
                                            @if ($course->level == 'Primary')
                                                <li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{5*100}}/Year</span></li>
                                            @elseif($course->level == 'Secondary')
                                                <li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{10*100}}/Year</span></li>
                                            @elseif($course->level == 'Tertiary')
                                                <li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{15*100}}/6 Months</span></li>
                                            @else
                                                <li class="text-danger">Error: cannot find price, contact admin</li>
                                            @endif
                                            <li><a href="/course/{{$course->id}}" class="btn btn-primary">View More</a></li>
                                            <li><a href="payment/{{ $course->id }}" class="btn btn-success" title="Buy now">Buy now</a></li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach @else
                            <div class="card">
                                <p class="text-info">There are no additional courses yet.. please check again with us soon.</p>
                            </div>
                            @endif
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection
