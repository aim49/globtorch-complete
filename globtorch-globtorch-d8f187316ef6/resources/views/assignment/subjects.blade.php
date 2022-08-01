@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <h3 class="text-primary">Assignments</h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Subjects</h3>
            </div>
        </div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
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
					<div class="row">
						<div class="col-lg-12">
                            @if (count($courses) > 0)
                            @foreach ($courses as $course )
                                <div class="card">
                                    <div class="card-title">
                                        <h2>{{$course->name . ' (' . $course->exam_boards->first()->name . ')'}}</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($course->subjects as $subject)
                                                @if (in_array($subject->id, $subject_ids))
                                                    <div class="col-sm-4">
                                                        <div class="welcome-box">
                                                            <img src="/images/course.jpg" alt="course" width="370" height="440"/>
                                                            <div class="welcome-title">
                                                                <h3>{{$subject->name}}</h3>
                                                            </div>	
                                                            <div class="welcome-content">
                                                                <br/>
                                                                <ul class="course-detail">
                                                                    <li>  <a href="{{ route('subject.assignment.create', [$subject->id]) }}" class="btn btn-primary">Add Assignment</a></li>
                                                                </ul>
                                                                <a href="{{ route('view_assignments',['id'=>$subject->id]) }}" title="View Assignments">View Assignments</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-info">You do not have any subjects assigned to you, contact the administrator to be assigned</p>
                        @endif
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
