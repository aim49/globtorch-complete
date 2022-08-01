@extends('layout.landing_page.app')
@section('content')
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>About us</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>About us</li>
				</ol>
			</div>
		</div>
	</div><!-- PageBanner /- -->
	<!-- WhyChooseUs Section -->
	<div class="container whychooseus-section">
		<div class="section-padding"></div>
		<div class="section-header">
			<h3>Why Choose <span> GLOBTORCH</span></h3>
			<p>Making it easier and more affordable to realise your right to an education.</p>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="video-block">
					<a title="Paly Video" class="popup-youtube" href="#"><i class="fa fa-play" aria-hidden="true"></i></a>
					<img  src="{{ URL::to('landing_page/images/video-poster-2.jpg')}}" width="570" height="400" alt="Video Poster"/>
					<div class="video-content">
						<h3>Your Career Starts Here</h3>
						<p>Achieving the desired success requires patience and persistence.</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 accordion-section">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="accordion_1">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#accordion1" aria-expanded="true" aria-controls="accordion1">Career</a>
							</h4>
						</div>
						<div id="accordion1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accordion_1">
							<div class="panel-body">
								<p>Expanding your knowledge can open doors to new career opportunities and also help you make the most out of existing opportunities too. The key to career growth is to never stop learning and GLOBTORCH is committed to ensuring you are equipped with the knowledge you need to excel.</p>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="accordion_2">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accordion2" aria-expanded="false" aria-controls="accordion2">Student Focus</a>
							</h4>
						</div>
						<div id="accordion2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion_2">
							<div class="panel-body">
								<p>Our goal is to provide every student with an enriched learning experience no matter where they are. We strive to offer the best in content and convenience, always putting the students’ needs and growth first.</p>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="accordion_3">
							<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accordion3" aria-expanded="false" aria-controls="accordion3">24/7 Professional Support</a>
						</h4>
						</div>
						<div id="accordion3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion_3">
							<div class="panel-body">
								<p>Learning that adapts to your schedule with 24 hour professional support. No matter the time, you will have instant access to the professional assistance you need to help you on your learning journey.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-padding"></div>
	</div><!-- WhyChooseUs Section /- -->
	<!-- Team Section -->
	<div class="container-fluid no-padding team-section">
		<div class="section-padding"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12 team-content-block">
					<div class="section-header">
						<h3>Meet <span> Our Staffs</span></h3>
						<p>Our creative and professional staffs</p>
					</div>
					<div class="team-intro">
						<p>GLOBTORCH’s team is a collective of some of the brightest and most innovative individuals in Zimbabwe who are committed to empowering people through knowledge and learning. The team is driven by a shared vision to increase access to affordable education and works tirelessly to ensure that GLOBTORCH’s students don’t just get access to education but also get the best education and learning experience.</p>
					</div>
					<a class="left carousel-control" href="#team-carousel" role="button" data-slide="prev">Prev</a>
					<a class="right carousel-control" href="#team-carousel" role="button" data-slide="next">Next</a>
				</div>
				<div class="col-md-6 col-sm-12 team-gallary">
					<div id="team-carousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="team-box">
											<ul>
												<li><a title="Facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a title="Twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a title="Google-Pluse" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
												<li><a title="Behance" href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
												<li><a title="Dribbble" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											</ul>
											<img alt="team1" src="{{ URL::to('landing_page/images/team1.jpg')}}" width="290" height="370"/>
											<div class="team-content">
												<h3>Martin Phillips</h3>
												<span>Executive Director</span>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="team-box">
											<ul>
												<li><a title="Facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a title="Twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a title="Google-Pluse" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
												<li><a title="Behance" href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
												<li><a title="Dribbble" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											</ul>
											<img alt="team2" src="{{ URL::to('landing_page/images/team2.jpg')}}" width="290" height="370"/>
											<div class="team-content">
												<h3>Thomas Wright</h3>
												<span>Web Developer</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="team-box">
											<ul>
												<li><a title="Facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a title="Twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a title="Google-Pluse" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
												<li><a title="Behance" href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
												<li><a title="Dribbble" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											</ul>
											<img alt="team1" src="{{ URL::to('landing_page/images/team1.jpg')}}" width="290" height="370"/>
											<div class="team-content">
												<h3>Martin Phillips</h3>
												<span>Executive Director</span>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<div class="team-box">
											<ul>
												<li><a title="Facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a title="Twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a title="Google-Pluse" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
												<li><a title="Behance" href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
												<li><a title="Dribbble" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											</ul>
											<img alt="team2" src="{{ URL::to('landing_page/images/team2.jpg')}}" width="290" height="370"/>
											<div class="team-content">
												<h3>Thomas Wright</h3>
												<span>Web Developer</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-padding"></div>
	</div><!-- Team Section /- -->	
	<!-- callOut -->
	<div class="container-fluid no-padding callout">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-9 col-xs-8 callout-content">
					<h3>Become an instructor</h3>
					<p>Join thousand of instructors and earn money hassle free</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-4">
					<a href="#" title="Join Now">Join Now</a>
				</div>
			</div>
		</div>
	</div><!-- callOut /- -->
@endsection