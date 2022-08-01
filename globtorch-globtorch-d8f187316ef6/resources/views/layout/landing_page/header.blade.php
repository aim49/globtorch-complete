<!-- LOADER -->
	<div id="site-loader" class="load-complete">
		<div class="loader">
			<div class="loader-inner ball-clip-rotate">
				<div></div>
			</div>
		</div>
	</div><!-- Loader /- -->	
	<!-- Header -->
	<header class="header-main container-fluid no-padding">
		<!-- Top Header -->
		<div class="top-header container-fluid no-padding">
			<div class="container">
				<div class="topheader-left">
					<a href="tel:+263777713962" title="+263 77 771 3962"><i class="fa fa-mobile" aria-hidden="true"></i>(+263) 77 771 3962</a>
					<a href="https://api.whatsapp.com/send?phone=+263782476323&text=Hi, I contacted you Through your website."  title="(+263) 0782 476 323"><i class="fa fa-whatsapp" aria-hidden="true"></i>(+263) 0782 476 323</a>
					<a href="mailto:info@globtorch.com" title="info@globtorch.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>Email us: info@globtorch.com</a>
				</div>
				<div class="topheader-right">
					<a href="/signin" title="Login"><i class="fa fa-sign-out" aria-hidden="true"></i>Login</a>
					<a href="/register" title="Register">Register</a>
				</div>
			</div>
		</div><!-- Top Header /- -->
        <!-- Menu Block -->
		<div class="menu-block container-fluid no-padding">
			<!-- Container -->
			<div class="container">
				<div class="row">
					<!-- Navigation -->
					<nav class="navbar ow-navigation">
						<div class="col-md-3">
							<div class="navbar-header">
								<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a title="Logo" href="/" class="navbar-brand"><img src="{{ URL::to('landing_page/images/logo.png')}}" alt="logo"/>GLOBTORCH</a>
								<a href="/" class="mobile-logo" title="Logo"><img src="{{ URL::to('landing_page/images/logo.png')}}" alt="logo"/></a>
							</div>
						</div>
						<div class="col-md-9">
							<div class="navbar-collapse collapse" id="navbar">
								<ul class="nav navbar-nav menubar">
									<li><a  href="/" role="button"  title="Home">Home</a></li>
									<li><a  title="Courses" href="/view_courses">Courses</a></li>
									<li><a  title="Library" href="https://library.globtorch.com">Library</a></li>
									<li><a title="Directory" href="/directories">Directory</a></li>
									<li><a title="About" href="/about">About</a></li>
									<li><a title="Contact" href="/contact">Contact</a></li>
									<li><a  title="Guide" href="{{ asset('docs/student_guide.pdf') }}">User Guide</a></li>
								</ul>
							</div>
						</div>
					</nav><!-- Navigation /- -->
					<div class="menu-search">
						<div id="sb-search" class="sb-search">
							<form>
								<input class="sb-search-input" placeholder="Enter your search term..." type="text" value="" name="search" id="search" />
								<button class="sb-search-submit"><i class="fa fa-search"></i></button>
								<span class="sb-icon-search"></span>
							</form>
						</div>
					</div>
				</div>
			</div><!-- Container /- -->
		</div><!-- Menu Block /- -->
	</header><!-- Header /- -->