@extends('layout.landing_page.app')
@section('content')
	<!--Courses -->
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>Courses</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>Courses</li>
				</ol>
			</div>
		</div>
	</div><!-- PageBanner /- -->
		<!-- Search Courses -->
	<div class="container-fluid no-padding searchcourses">
		<div class="container">	
			<div class="search-content">
				<div class="searchcourses-block">
					<h3>Join a Class Now, search for a online course </h3>
				</div>
				<div class="course-search-block">
					{!! Form::open(['action' => 'WelcomeController@search', 'method'=>'GET']) !!}
						<div class="col-md-3 col-sm-3 col-xs-6">
							<select name="level" class="selectpicker">
								<option>Course Level</option>
								<option>Primary</option>
								<option>Secondary</option>
								<option>Tertiary</option>
							</select>
						</div>
						<div class="col-md-6 col-sm-6  col-xs-12 search_box">
							<div class="input-group">
								<input name="keyword" type="text" class="form-control" placeholder="Course Keyword . . . ">
								<span class="input-group-btn">
									<button class="btn" type="submit" title="Search courses">Search courses</button>
								</span>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div><!-- Search Courses /- -->
	<!-- Welcome Section -->
	<div class="container welcome-section welcome2">
		<div class="section-padding"></div>	
		<div class="search-result">
			<span>Search results: {{count($courses)}}</span>
			<!--<span>Showing 1-9 of total 18 courses</span>-->
			<!--<div class="input-group col-md-2">
				  <input type="text" class="form-control" placeholder="Search courses">
				  <span class="input-group-btn">
					<button class="btn" type="button"><i class="fa fa-search"></i></button>
				  </span>
			</div>-->
		</div>
		<div class="row">
			@if (count($courses) > 0)
				<div class="row">
				@foreach($courses as $course)
					<div class="col-md-4 col-sm-6 col-xs-6">
						<div class="welcome-box">
							<img src="{{asset('storage/course/' . $course->image)}}" alt="course image" width="370" height="440"/>
							<div class="welcome-title">
								<h3>{{ $course->name . ' (' . $course->exam_boards->first()->name . ')'}}</h3>
							</div>	
							<div class="welcome-content">
								<span>({{ $course->level }} )</span>
								<p>{{ $course->description }}</p>
								<ul class="course-detail">
									<li><i class="fa fa-qrcode" aria-hidden="true"></i>Course Code : <span>{{ $course->code }}</span></li>
									<li><i class="fa fa-calendar" aria-hidden="true"></i>Course duration : <span>{{ $course->duration }}</span></li>
									<li><i class="fa fa-calendar" aria-hidden="true"></i>Exam period : <span>{{ $course->exam_boards->first()->pivot->exam_months }}</span></li>
									@if ($course->level == 'Primary')
										<li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{5*100}}/Year</span></li>
									@elseif($course->level == 'Secondary')
										<li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{10*100}}/Year</span></li>
									@elseif($course->level == 'Tertiary')
										<li><i class="fa fa-money" aria-hidden="true"></i>Price : <span>RTGS ${{15*100}}/6 Months</span></li>
									@else
										<li class="text-danger">Error: cannot find price, contact admin</li>
									@endif
								</ul>
							<!--	<ul class="course-rating">
									<li><a href="#" title="1 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
									<li><a href="#" title="2 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
									<li><a href="#" title="3 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
									<li><a href="#" title="4 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
									<li><a href="#" title="5 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
								</ul> -->
								<a href="/course_details/{{$course->id}}" title="STUDY NOW">STUDY NOW</a>
							</div>
						</div>
					</div>
				@endforeach
				</div>
				{{$courses->links()}}
			@endif
		<!--
		<nav class="ow-pagination">
			<ul class="pagination">
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">Next</a></li>
			</ul>
		</nav>
		-->
		<div class="section-padding"></div>
	</div><!-- Welcome Section /- -->
	</div>
@endsection