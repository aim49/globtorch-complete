@extends('layout.landing_page.app') 
@section('content')
	
	<!-- Blog/news -->
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>News</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>News</li>
				</ol>
			</div>
		</div>
	</div><!-- PageBanner /- -->
	<div class="container blog">
		<div class="section-padding"></div>
		<div class="row">
			<div class="col-md-9 col-sm-8 content-area">
				<article class="type-post">
					<div class="entry-cover">
						<a title="Cover" href="/news_post"><img width="860" height="470" alt="latestnews" src="{{ URL::to('landing_page/images/blogpost.jpg')}}"></a>
					</div>
					<div class="entry-block">
						<div class="entry-contentblock">
							<div class="entry-meta">
								<span class="postby">By : <a href="/news_post" title="Andreanne Turcotte">Pamela Muzoma</a></span>
								<span class="postcatgory">Category : <a href="/news_post" title="News Posted"> News Posted</a></span>
								<span class="postdate">Date : <a href="/news_post" title="28 January 2019"> 28 January 2019</a></span>
							</div>
							<div class="entry-block">
								<div class="entry-title">
									<a title="The Age of Learning Has No Age" href="/news_post"><h3>The Age of Learning Has No Age</h3></a>
								</div>
								<div class="entry-content">
									<p>The world has embraced the age of online learning and despite the misconception that e-learning is only for tech savvy millennials, the elderly in places like China are refusing to be left behind by the revolution.</p>
								</div>
							</div>
							<a href="/news_post" title="Read More">Read More</a>
						</div>
						<div class="post-ic"><span class="icon icon-Pencil"></span></div>
					</div>
				</article>
				<nav class="ow-pagination">
					<ul class="pagination">
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">Next</a></li>
					</ul>
				</nav>
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