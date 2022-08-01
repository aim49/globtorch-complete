@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Assignments</h3> 
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
									<h2 class="text-primary">{{$course->name}} - Subjects</h2>
								</div>
								<div class="row">
                                    @if (count($course->subjects) > 0)
                                       @foreach($course->subjects as $subject)
                                         <div class="col-md-4 col-sm-6 col-xs-6 ">
                                        <div class="welcome-box">
                                            <img src="/images/course.jpg" alt="subjects" width="370" height="440"/>
                                            <div class="welcome-title">
                                                <h3>{{ $subject->name }}</h3>
                                            </div>	
                                            <div class="welcome-content" style="height:70%">
                                                <span>{{$course->name}}</span>
                                                <a href="{{ route('view_studentassignment',['id'=>$subject->id]) }}" title="View Assignments">View Assignments</a>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                    @else
                                       <p class="text-info">There are no subjects available yet... please check again with us soon!</p>
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
