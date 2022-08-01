@extends('layout.landing_page.app')
@section('content')
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>Tips to Succeed in an Online Course</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>News Details</li>
				</ol>
			</div>
		</div>
	</div><!-- PageBanner /- -->
	<div class="container blog blogpost">
		<div class="section-padding"></div>
		<div class="row">
			<div class="col-md-9 col-sm-8 content-area">
				<article class="type-post">
					<div class="entry-cover">
						<img width="860" height="470" alt="blogpost" src="{{ URL::to('landing_page/images/blogpost.jpg')}}">
					</div>
					<div class="entry-block">
						<div class="entry-contentblock">
							<div class="entry-meta">
								<span class="postby">By : <a href="#" title="Andreanne Turcotte"> Pamela Muzoma</a></span>
								<span class="postcatgory">Category : <a href="#" title="News Posted"> News Posted</a></span>
								<span class="postdate">Date : <a href="#" title="4th January 2019"> 28 January 2019</a></span>
							</div>
							<div class="entry-block">
								<div class="entry-title">
									<h3>The Age of Learning Has No Age</h3>
								</div>
								<div class="entry-content">
									<p>The world has embraced the age of online learning and despite the misconception that e-learning is only for tech savvy millennials, the elderly in places like China are refusing to be left behind by the revolution.</p>
									<p>Online education is being implemented and integrated into schools across the globe but the elderly market still remains largely untapped. According to a study by Merrill Lynch, nearly three out of five working retirees viewed retirement as an opportunity to transfer to a different line of work, showing that even in their golden years the elderly are still keen to learn and expand their knowledge. Demand for online learning by seniors has even been proven at the Shanghai University for the Elderly where courses reportedly sell out within minutes of enrolment being opened, and according to other international online learning platforms the demand for e-learning from the elderly is not just limited to developed economies.</p>
									<p>The elderly appreciate the benefits that come with online learning such as being able to learn from home, the flexibility that online courses offer and the wide range of course options available. Additionally, online courses don’t require the heavy commitment that comes with full blown degrees, seniors can simply choose specific topics that interest them and complete the courses within a short period of time.</p>
									<p>Online learning is transforming the education landscape making it easier for lifelong learners to continue pursuing wisdom; you’re never too old to learn.</p>
								</div>
							</div>
							<ul>
								<li><a title="Facebook" href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a title="Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a></li> 
								<li><a title="Behance" href="#"><i class="fa fa-behance"></i></a></li>
								<li><a title="Dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
							</ul>
						</div>
						<div class="post-ic"><span class="icon icon-Pencil"></span></div>
					</div>
				</article>
				<!--<div class="post-comments">
					<h3 class="block-title">3 Comments</h3>
					<div class="media">
						<div class="media-body">
							<div class="media-content">
								<h4 class="media-heading">
									Martin Guptil<span>Sep 23, 2015</span>
								</h4>
								<p>You bet your life Speed Racer he will see it through. Its mission explore  to strange news worlds seek out new life and new civilizations gone before.</p>
								<a href="#" title="Reply">Reply</a>
							</div>
							<div class="media">
								<div class="media-body">
									<div class="media-content">
										<h4 class="media-heading">
											Lierd Yuis<span>Sep 23, 2015</span>
										</h4>
										<p>You bet your life Speed Racer he will see it through. Its mission explore  to strange news worlds seek out new life and new civilizations gone before.</p>
										<a href="#" title="Reply">Reply</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="media">
						<div class="media-body">
							<div class="media-content last">
								<h4 class="media-heading">
									Micheal Jicob<span>Sep 23, 2015</span>
								</h4>
								<p>You bet your life Speed Racer he will see it through. Its mission explore  to strange news worlds seek out new life and new civilizations gone before.</p>
								<a href="#" title="Reply">Reply</a>
							</div>
						</div>
					</div>
				</div>-->				
				<form class="comment-form">
					<h3 class="block-title">Post a Comment</h3>
					<div class="row">
						<div class="form-group col-md-12">
							<textarea class="form-control msg" rows="5" placeholder="Write your comment here..."></textarea>
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control" placeholder="First name" required="">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control" placeholder="Surname" required="">
						</div>
						<div class="form-group col-md-4">
							<input type="email" class="form-control" placeholder="Email Address" required="">
						</div>
						<div class="form-group col-md-12">
							<input type="submit" title="Submit" name="Submit" value="Submit">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-3 col-sm-4 widget-area">
				<aside class="widget widget_categories">
					<h3 class="widget-title">Categories</h3>
					<ul>
						<li><a title="Language Science" href="#">Language Science</a><span>(10)</span></li>
						<li><a title="Student Guidance" href="#">Student Guidance</a><span>(12)</span></li>
						<li><a title="School Psychology" href="#">School Psychology</a><span>(08)</span></li>
						<li><a title="Vocational Counselling" href="#">Vocational Counselling	</a><span>(18)</span></li>
						<li><a title="Uncategorized" href="#">Uncategorized</a><span>(11)</span></li>
						<li><a title="Youth Science" href="#">Youth Science</a><span>(10)</span></li>
					</ul>
				</aside>
				<aside class="widget widget_latestnews">
					<h3 class="widget-title">Latest News</h3>
					<div class="latestnews-box">
						<a href="/news_post" title="Along Communicate Directly With Experienced Teachers">Along Communicate Directly With Experienced Teachers</a>
						<span>4th January 2019</span>
					</div>
					<div class="latestnews-box">
						<a href="/news_post" title="Given The Tips To Students Succed In An Online Courses ">Given The Tips To Students Succed In An Online Courses </a>
						<span>4th January 2019</span>
					</div>
					<div class="latestnews-box">
						<a href="/news_post" title="Why Should Read Every Day">Why Should Read Every Day</a>
						<span>4th January 2019</span>
					</div>
				</aside>
			</div>
		</div>
		<div class="section-padding"></div>
	</div>
@endsection