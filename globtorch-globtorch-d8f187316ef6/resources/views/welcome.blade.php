@extends('layout.landing_page.app')
@section('content')
	<!-- Home -->
	<!-- PhotoSlider Section -->
	<div class="photoslider-section container-fluid no-padding">
		<div id="home-slider" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="{{ URL::to('landing_page/images/photoslider1.jpg') }}" alt="photoslider1" width="1920" height="801"/>
					<div class="carousel-caption">
						<div class="container">
							<div class="col-md-6 col-sm-8 col-xs-8 ow-pull-right no-padding">
								<h4 data-animation="animated bounceInLeft">Welcome</h4>
								<h3 data-animation="animated fadeInDown">To <span>GLOBTORCH</span></h3>
								<p data-animation="animated bounceInRight">Zimbabwe’s leading online education specialist offering courses for all levels of learning, from primary to tertiary education</p>
								<a href="/register" title="Learn More" data-animation="animated zoomInUp">Register Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="item ">
					<img src="{{ URL::to('landing_page/images/photoslider3.jpg') }}" alt="photoslider1" width="1920" height="801"/>
					<div class="carousel-caption">
						<div class="container">
							<div class="col-md-6 col-sm-8 col-xs-8 ow-pull-right no-padding">
								<h4 data-animation="animated bounceInLeft">World Class</h4>
								<h3 data-animation="animated fadeInDown">Education at Your<span>Finger Tips</span></h3>
								<p data-animation="animated bounceInRight">Our app based platform means you can access all our courses at any time from any device</p>
								<a href="/register" title="Learn More" data-animation="animated zoomInUp">Register</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
	</div><!-- PhotoSlider Section /- -->	
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
	<!-- Welcome Section -->
	<div class="container welcome-section">
		<div class="section-padding"></div>
		<div class="section-header">
			<h3>Popular <span>Courses</span></h3>
			<p></p>
		</div>
		<div class="row">
		@foreach($courses as $course)
			<div class="col-md-4 col-sm-6 col-xs-6">
				<div class="welcome-box">
					<img src="{{asset('storage/course/' . $course->image)}}" alt="image" width="370" height="440"/>
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
						<!--<ul class="course-rating">
							<li><a href="#" title="1 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="2 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="3 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="4 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="5 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
						</ul>-->
						<a href="/course_details/{{$course->id}}" title="STUDY NOW">STUDY NOW</a>
						<br/>
					</div>
				</div>
			</div>
			
			@endforeach
		</div>
		<div class="section-padding"></div>
	</div><!-- Welcome Section /- -->
	

	<!-- Parallax Section -->
	<div class="container-fluid no-padding parallax-section">
		<div class="parallax-carousel">
			<div class="parallax-block">
				<div class="parallax-box">
					<img src="{{ URL::to('landing_page/images/parallax-bg.jpg') }}" alt="parallax" width="1920" height="600"/>
				</div>
				<div class="parallax-content">
					<h3>Learning with friends has never been more fun and affordable.</h3>
					<p> Register as a group and take advantage of our GLOBTORCH discounts, or refer a friend and get 1 month free access.
							<h3>Simple and Fast Registration </h3>
								<li>Step 1 – Set up your personal profile</li>
								<li>Step 2 – Receive an SMS with your log in details</li>
								<li>Step 3 – Make your payment</li>
								<li>Step 4 – Learn! </li>
						</p>
					<a href="/about" title="Find More About Us">Find More About Us</a>
					
				</div>
			</div>	
		</div>
		<div class="parallax-carousel">
			<div class="parallax-block">
				<div class="parallax-box">
					<img src="{{ URL::to('landing_page/images/parallax-bg.jpg') }}" alt="parallax" width="1920" height="600"/>
				</div>
				<div class="parallax-content">
					<h3>Learning with friends has never been more fun and affordable.</h3>
					<p> Register as a group and take advantage of our GLOBTORCH discounts, or refer a friend and get 1 month free access.
						<h3>Simple and Fast Registration </h3>
						<ul>
						<font color="white">
							Step 1 – Set up your personal profile<br/>
							Step 2 – Receive an SMS with your log in details<br/>
							Step 3 – Make your payment<br/>
							Step 4 – Learn!<br/>
						</font>
						</ul>
					</p>
					<a href="/about" title="Find More About Us">Find More About Us</a>
					
				</div>
			</div>	
		</div>
			
		</div>
	</div><!-- Parallax Section /- -->
	<!-- Event Section -->
	<div class="container event-section">
		<div class="section-padding"></div>	
		<div class="section-header-block">
			<div class="section-header">
				<h3>Our <span>Events</span></h3>
				<p>Upcoming Education Events to feed your brain<p>
			</div>
			<a href="/events" title="View All">View All</a>
		</div>
		<div class="event-block">
			<div class="event-box">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-xs-5">
						<img src="{{ URL::to('landing_page/images/event1.jpg')}}" alt="orientation" width="260" height="160"/>
					</div>
					<div class="col-md-7 col-sm-6 col-xs-7">
						<h3><a href="/events" title="Orientation Webinar">Orientation Webinar</a></h3>
						<div class="event-meta">
							<span><i aria-hidden="true" class="fa fa-clock-o"></i>8:00 Am - 5:00 Pm</span>
							<span><i aria-hidden="true" class="fa fa-map-marker"></i>Harare, Zimbabwe</span>
						</div>
						<p>Globtorch hosted an orientation webinar hosting over 100 students and parents of students online to give them a big Globtorch welcome. It was a fun interactive session that brought a great mix of personalities together but it was clear that despite any difference everyone shared a passion for learning. We gave out a lot of information but we also received a lot of valuable feedback from our audience which we know will help us improve our service offering and help us grow as an organisation.</p>
						<p>If you missed the orientation and have any questions or feedback feel free to give us a call or leave a message on our contact page, we would love to hear from you!</p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<a href="/event" class="readmore" title="Read More">Read More</a>
						
					</div>
				</div>
			</div>
		</div>
		<div class="section-padding"></div>
	</div><!-- Event Section /- -->	
	
	<!-- Search Courses -->
	<div class="container-fluid no-padding searchcourses">
		<div class="container">	
			<div class="search-content">
				<div class="searchcourses-block">
					<h3>Over 3,000+ students trust us world wide. Get free online courses tips, Subscribe us</h3>
				</div>
				<div class="course-search-block">
					<!--<div class="col-md-3 col-sm-3 col-xs-6">
						<select class="selectpicker">
							<option>All Categories</option>
							<option>Science</option>
							<option>Commercials</option>
							<option>Arts</option>
							<option>Information Technology</option>
							<option>Finance</option>
						</select>
					</div>-->
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
				<div class="search-categories">
					<div class="col-md-3 col-sm-3 col-xs-6">
						<p><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Over 500 students Enrolled Learn Skills</span></p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<p><i class="fa fa-paper-plane-o" aria-hidden="true"></i><span>More than 300+ Online Courses Available</span></p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<p><i class="fa fa-tencent-weibo" aria-hidden="true"></i><span>Learn Skills on any Devices anytime</span></p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<p><i class="fa fa-user-md" aria-hidden="true"></i><span>More than 320 Instructors Available</span></p>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Search Courses /- -->
	
	<!-- Video Testimonial Section -->
	<div class="container-fluid no-padding video-testimonial-section">
		<div class="container">
			<div class="section-padding"></div>
			<div class="section-header">
				<h3>Our <span>Success </span></h3>x`
				<p>Achieving the desired success requires patience and persistence your goals need time</p>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="video-block video-block-lg">
						<a title="Paly Video" class="popup-youtube" href="#"><i class="fa fa-play" aria-hidden="true"></i></a>
						<img  src="{{ URL::to('landing_page/images/video-poster-1.jpg') }}" width="570" height="400" alt="Video Poster-1"/>
						<div class="video-content">
							<h3>Your Career Starts Here</h3>
							<p>Achieving the desired success requires patience and persistence.</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="courses-features">
						<h3>Benefits of online learning with GLOBTORCH </h3>
						<ul>
							<li><a href="#" title="1 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="2 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="3 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="4 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="5 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
						</ul>
						<span>( 0  Review )</span>
						<p>Affordable – low cost education where you get more for less; pay for all your courses at once and save big</p><hr/>
						<p> <span>Flexible – with 24/7 course access and support you can learn at your own pace, on your own time </span></p><hr/>
						<p><span>Reputable – GLOBTORCH is registered with the Ministry of Primary and Secondary Education as well as tertiary education and exam boards including ACCA, IAC, etc. so we are bound by strict standards of excellence </span></p><hr/>
						<p> <span>Dynamic – adaptive course content ensures that the education you receive is always relevant</span></p>
					</div>
				</div>
			</div>
			<div class="section-padding"></div>
		</div>
	</div><!-- Video Testimonial Section /- -->	
	
	<!-- Welcome Section -->
	<div class="container welcome-section">
		<div class="section-padding"></div>
		<div class="section-header">
			<h3>Our Other <span>Services</span></h3>
			<small>click on the icon to view</small>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<a href="https://africanscity.com" target="_blank"><img style="height:100px" class="img-fluid" src="{{asset('images/logo/africanscity.png')}}"></a>
			</div>
			<div class="col-xs-6">
				<a href="https://gstorex.com" target="_blank"><img style="height:100px" class="img-fluid" src="{{asset('images/logo/gstorex.png')}}"></a>
			</div>
		</div>
		<div class="section-padding"></div>
	</div><!-- Welcome Section /- -->
@endsection