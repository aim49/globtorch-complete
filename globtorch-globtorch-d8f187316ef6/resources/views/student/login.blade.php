@extends('layout.auth.app')
@section('content')
	<div class="login100-pic js-tilts" data-tilt>
		<img class="mySlides " src="images/image.jpg" alt="IMG">
		<img class="mySlides "  src="images/computer-training-1.jpg" alt="IMG">
		<img class="mySlides " src="images/img-01.png" alt="IMG">
		<img class="mySlides " src="images/computer-training-courses.jpg" alt="IMG">
		<img class="mySlides " src="images/pay-now_medium.png" alt="IMG">
		<br/>
	</div>
		<form method="POST" action="{{ route('signin') }}" class="login100-form validate-form">
			{{ csrf_field() }}
		<span class="login100-form-title">
			<img src="images/logo.png" alt="IMG"><br/><br/>
			LEARN WITHOUT CLASS
		</span>
		@if ($errors->any())
			<div class="alert alert-danger" style="color:red">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		@if(session()->has('message'))
			<div style="color:green">
				{{ session()->get('message') }}
			</div><br/>
		@endif	
		<div class="wrap-input100 validate-input" data-validate = "User ID is required">
			<input class="input100" type="text" name="school_id" placeholder="Email/Phone/User ID">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-user" aria-hidden="true"></i>
			</span>
		</div>

		<div class="wrap-input100 validate-input" data-validate = "Password is required">
			<input class="input100" type="password" name="password" placeholder="Password">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-lock" aria-hidden="true"></i>
			</span>
		</div>
		
		<div class="container-login100-form-btn">
			<button class="login100-form-btn btn-primary">
					Join Class Today   
			</button>
		</div>

		<div class="text-center p-t-12">
			<span class="txt1">
				Forgot
			</span>
			<a class="txt2" href="/password_reset">
				Password?
			</a>
		</div>
		<div class="text-center p-t-136">
			<a class="txt2" href="/register">
				Create your Account
				<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
			</a>
		</div>
	</form>
@endsection
@section('body_scripts')
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/5c715051a726ff2eea59186d/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			})();
			</script>
			<!--End of Tawk.to Script-->
	<script>
		var myIndex = 0;
		carousel();
		
		function carousel() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}
			myIndex++;
			if (myIndex > x.length) {myIndex = 1}    
			x[myIndex-1].style.display = "block";  
			setTimeout(carousel, 3000); // Change image every 3 seconds
		}
		
	</script>
	<script src="{{ URL::to('js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ URL::to('vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilts').tilt({
			scale: 1.2
			glare: true,
			maxGlare: .5
		})
	</script>
@endsection