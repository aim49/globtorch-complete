@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">My Active Courses</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
   <!-- Container fluid  -->
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
                            <div class="card">
								<div class="card-title">
									<h2 class="text-primary">My Active Courses  </h2>
								</div>
								<div class="row">
                                    @if (count($enrolled_courses) > 0)
                                     @foreach ($enrolled_courses as $enrolled_course)
                                    <div class="col-md-4 col-sm-6 col-xs-6 ">
                                        <div class="welcome-box">
                                            <img src="/images/course.jpg" alt="course"  width="370" height="440"/>
                                            <div class="welcome-title">
                                                <h3>{{$enrolled_course->name . ' (' . $enrolled_course->exam_boards->first()->name . ')'}}</h3>
                                            </div>	
                                            <div class="welcome-content" style="height:70%">
                                                <span>({{$enrolled_course->level}})</span>
                                                <a href="{{ route('view_studentsubject',['id'=>$enrolled_course->id]) }}" title="View Subjects">View Subjects</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                   @else
                                    <div class="card">
                                        <p class="text-info">You currently do not have any active courses that you are enrolled on. Please Subscribe or Purchase a course</p>
                                    </div>
                                @endif  
			                    </div>
							</div>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection

