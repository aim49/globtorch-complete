@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <h3 class="text-primary"><a href="/course/{{$course->id}}">{{$course->name}}</a></h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Subjects</h3>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9">
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
					<div class="row">
						<div class="col-lg-9">
                            <div class="card-title">
                                <h2 class="text-primary">  </h2>
                            </div>
                            <div class="row">
                                @if (count($course->subjects) > 0)
                                    @foreach ($course->subjects as $subject )
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                        <div class="welcome-box">
                                            <img src="{{asset('storage/course/' . $course->image)}}" alt="course" width="370" height="440"/>
                                            <div class="welcome-title">
                                                <h3>{{$subject->name}}</h3>
                                            </div>	
                                            <div class="welcome-content">
                                            <br/>  <br/>
                                                    <a href="/subject/{{$subject->id}}" title="View Subject">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @if(auth()->user()->user_type == 'student')
                                        <p class="text-info">There are no subjects available yet... please check again with us soon!</p>
                                    @elseif (auth()->user()->user_type == 'teacher')
                                        <p class="text-info">You do not have any subjects assigned to you, contact the administrator to be assigned</p>
                                    @else
                                        <p class="text-info">There are no subjects assigned to this course</p>
                                    @endif
                                @endif    
                            </div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h2 class="text-center">Exam details</h2>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Exam Board: {{ $course->exam_boards->first()->name }}<br />
                                        Exam Period: {{ $course->exam_boards->first()->pivot->exam_months }}<br />
                                        Exam Price: {{ $course->exam_boards->first()->pivot->exam_price }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
