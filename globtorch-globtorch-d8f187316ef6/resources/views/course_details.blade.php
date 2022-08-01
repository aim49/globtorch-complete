@extends('layout.landing_page.app')
@section('content')
<style>
.button {
	border: none;
	padding: 15px 32px;
	font-size: 16px;
  }
</style>
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>{{ $courses->name }}</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>Courses Details</li>
				</ol>
			</div>
		</div>
	</div>
	<!-- PageBanner /- -->
	<div class="container coursesdetail-section">
		<div class="section-padding"></div>
			<div class="row">
				<div class="col-md-9 col-sm-8 event-contentarea">
					<div class="coursesdetail-block">
						<img src="{{ URL::to('landing_page/images/event-coursesdetail.jpg')}}" alt="event-coursesdetail" width="860" height="500"/>
						<div class="course-description">
							<h3 class="course-title">Courses Description</h3>
							<p>{{ $courses->description }}</p>
						</div>
						<div class="courses-summary">
							<h3 class="course-title">Courses summary</h3>
							<ul>
								<li><a href="#" title="Educated Staff">Educated Staff</a></li>
								<li><a href="#" title="Assignments">Assignments</a></li>
								<li><a href="#" title="PDF Content">PDF Content</a></li>
								<li><a href="#" title="Video Lessons">Video Lessons</a></li>
							</ul>
						</div>
						<div class="courses-curriculum">
							<h3 class="course-title">Subjects</h3>
							<div class="courses-sections-block">
							@foreach($subjects as $subject)
								<ul>
									<li><h3>{{ $subject->name }}</h3></li>
								</ul>
								@endforeach
							</div>
							
						</div>
						<div class="courses-review">
							<h3 class="course-title">Courses Review</h3>
							<div class="reviewbox">
								<h3>Average Rating</h3>
								<div class="average-review">
									<h2>4.8</h2>
									<ul>
										<li><a href="#" title="1 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
										<li><a href="#" title="2 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
										<li><a href="#" title="3 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
										<li><a href="#" title="4 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
										<li><a href="#" title="5 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
									</ul>
									<span>5 Rating</span>
								</div>
							</div>
							<div class="reviewbox">
								<h3>Detailed Rating</h3>
								<div class="detail-review">
									<ul>
										<li><a href="#" title="5 stars">5 stars</a><span>5</span></li>
										<li><a href="#" title="4 stars">4 stars</a><span>0</span></li>
										<li><a href="#" title="3 stars">3 stars</a><span>0</span></li>
										<li><a href="#" title="2 stars">2 stars</a><span>0</span></li>
										<li><a href="#" title="1 stars">1 stars</a><span>0</span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 event-sidebar">
					<div class="courses-features">
						<h3>{{ $courses->name }}</h3>
						<ul>
							<li><a href="#" title="1 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="2 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="3 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="4 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
							<li><a href="#" title="5 Star"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
						</ul>
						<span>( 0  Review )</span>
						<div class="featuresbox"><img src="{{ URL::to('landing_page/images/codepen-ic.png')}}" alt="codepen-ic" width="22" height="22"/><h3>Course Code : </h3><span> {{ $courses->code }}</span></div>
						<div class="featuresbox"><img src="{{ URL::to('landing_page/images/dolar-ic.png')}}" alt="dolar-ic" width="27" height="27"/><h3>Price : </h3><span> {{ $courses->price }}</span></div>
						<div class="featuresbox"><img src="{{ URL::to('landing_page/images/cup-ic.png')}}" alt="cup-ic" width="24" height="23"/><h3>Level : </h3><span> {{ $courses->level }}</span></div>
						<div class="featuresbox"><img src="{{ URL::to('landing_page/images/clock-ic.png')}}" alt="cap-ic" width="24" height="20"/><h3>Duration :</h3>{{ $courses->duration }}</div>
						<div class="featuresbox"><img src="{{ URL::to('landing_page/images/cap-ic.png')}}" alt="cap-ic" width="24" height="20"/><h3>Certificate of Completion</h3></div>
					
					</div>
					<div >
						@if (auth()->user() != null)
							<a href="/payment/{{$courses->id}}" class="btn btn-success button">STUDY NOW</a>
						@else
							<a href="/register" title="STUDY NOW" class="btn btn-success button">STUDY NOW</a>
						@endif
					</div>
				</div>
			</div>
		<div class="section-padding"></div>
	</div>
@endsection