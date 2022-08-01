<!-- Footer Main -->
<footer class="footer-main container-fluid no-padding">
	<!-- Container -->
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<aside class="ftr-widget about_widget">
					<!--<a class="footer-logo" href="/" title="Logo"><img alt="logo" src="{{ URL::to('landing_page/images/logo.jpg')}}">GLOBTORCH</a><br/>-->
					<ul><br/>
						<li><a href="https://api.whatsapp.com/send?phone=263782476323" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
						<li><a href="https://www.facebook.com/globtorchonline/" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://twitter.com/globtorch" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://www.instagram.com/globtorch_online_education_/" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<li><a href="https://www.linkedin.com/in/globtorch-online-education-and-business-solutions" | title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="https://www.youtube.com/channel/UCwN4wqRnzsd_nO_mHD_wMUQ" title="Youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
					</ul>
					<p>Glotorch Online Education Institute is the newest educational corporation and the pioneer of online education in the
						entire education system covering all academic vertical levels from ECDs to tertiary level in Zimbabwe and abroad.</p>
				</aside>
			</div>
			<div class="col-md-6 col-sm-6">
				<aside class="ftr-widget newsletter_widget">
					<h3 class="widget-title">News Letters</h3>
					<div class="input-group">
						<input id="email" name="email" type="text" class="form-control" placeholder="Enter your email">
						<span class="input-group-btn"><button class="btn" onclick="subscribe_newsletter()" title="Sign Up">Sign Up</button></span>
					</div>
				</aside>
			</div>


			<!-- Footer Bottom -->
			<div class="footer-bottom col-md-12 col-sm-12 no-padding">
				<div class="copyright no-padding">
					<span>Copyright Globtorch &copy; 2018. All Rights Reserved.</span>
				</div>
				<nav class="navbar ow-navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2" aria-expanded="false"
						 aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div id="navbar2" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><a href="/" title="Home">Home</a></li>
							<li><a href="/view_courses" title="COURSE">Courses</a></li>
							<li><a href="/contact" title="Contact">Contact Us</a></li>
							<li><a href="/signin" title="Login">Login</a></li>
							<li><a href="/login" title="Register">Register</a></li>
						</ul>
					</div>
				</nav>
			</div>
			<!-- Footer Bottom /- -->
		</div>
		<!-- Container /- -->
	</div>

	<script>
		function subscribe_newsletter()
		{
			// Handle newsletter request
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			});
			jQuery.ajax({
				url: "{{ url('/newsletter') }}",
				method: 'get',
				data: {
					email: jQuery('#email').val()
				},
				success: function(result){
					alert(result['message']);
				}
			});
		}
	</script>
</footer>
<!-- Footer /- -->