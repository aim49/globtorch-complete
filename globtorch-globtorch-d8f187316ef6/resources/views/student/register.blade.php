@extends('layout.auth.app')
<!-- Bootstrap Core CSS -->
@section('head_styles')
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}
</style>
@endsection
@section('content')
	<div class="login100-pic js-tilts" data-tilt>
		<img class="mySlides " src="images/image.jpg" alt="IMG">
		<img class="mySlides "  src="images/computer-training-1.jpg" alt="IMG">
		<img class="mySlides " src="images/img-01.png" alt="IMG">
		<img class="mySlides " src="images/computer-training-courses.jpg" alt="IMG">
		<img class="mySlides " src="images/pay-now_medium.png" alt="IMG">
		<br/>
	</div>
		<form method="POST" action="{{ route('reg') }}" class="login100-form validate-form">
			{{ csrf_field() }}
		<span class="login100-form-title">
			<img src="images/logo.png" alt="IMG">
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
    <div class="wrap-input100 validate-input" data-validate = "First Name is required">
			<input class="input100" type="text" placeholder="First Name" name="name" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-user" aria-hidden="true"></i>&nbsp;<span class="text-danger">*</span>
			</span>
		</div>
    <div class="wrap-input100 validate-input" data-validate = "Surname is required">
			<input class="input100" type="text" placeholder="Surname" name="surname" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-user" aria-hidden="true"></i>&nbsp;<span class="text-danger">*</span>
			</span>
		</div>
    <div class="wrap-input100 validate-input" data-validate = "Phone is required">
			<input class="input100" type="tel" placeholder="Phone" name="phone" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<span class="text-danger">*</span>
			</span>
		</div>
    <div class="wrap-input100 validate-input" data-validate = "Email is required">
			<input class="input100" type="email" placeholder="Email" name="email">
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			</span>
    </div>
    <div class="wrap-input100 validate-input">
      {{Form::select('institution_id', $institutions, null, ['class' => 'input100', 'placeholder' => 'School/Institution'])}}
      <span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class='fas fa-building'></i>
			</span>
    </div>
    <div class="wrap-input100 validate-input" data-validate = "Country is required">
      {{Form::select('country', $countries, null, ['class' => 'input100', 'placeholder' => 'Country ...', 'required'])}}
      <span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-globe"></i>&nbsp;<span class="text-danger">*</span>
			</span>
    </div>
		<div class="wrap-input100 validate-input" data-validate = "Password is required">
			<input class="input100" type="password" name="password" placeholder="Password" required>
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-lock" aria-hidden="true"></i>&nbsp;<span class="text-danger">*</span>
			</span>
		</div>
    <div class="wrap-input100 validate-input" >
     @if (app('request')->input('ref') == '')
			<input class="input100" type="text" name="referral" placeholder="Referral">
    @else
      <input class="input100" type="text" name="referral" value="{{app('request')->input('ref')}}" placeholder="Referral" readonly>
    @endif
			<span class="focus-input100"></span>
			<span class="symbol-input100">
				<i class="fa fa-arrow-right" aria-hidden="true"></i>
			</span>
		</div>
      <div class="wrap-input100 validate-input" data-validate = "Please Read T & C's it is required">
				<input type="checkbox" required> &nbsp;<span class="text-danger">*</span>
        By creating an account you agree to our 
        <font style="color:dodgerblue" ><a  href="#myBtn" id="myBtn">Terms & Privacy</a></font>.
			</div>
		<div class="container-login100-form-btn">
			<button class="login100-form-btn btn-primary">
					REGISTER NOW
			</button>
		</div>
		<div class="register-link m-t-15 text-center">
      <p>Already have account ? <a href="/signin"> Sign in</a></p>
    </div>                             
  </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
    <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <h2>Terms and Conditions</h2>
        </div>
        <div class="modal-body">
        <ul>
          <li> Granting you license in consideration of your  payment hereby grant you access to use purchased courses. 
          </li>
              <p>Content use is limited,revocable,non exclusive, non transferable and is subject to the rights and obligations granted under this terms.
                 License is personal to you and can't be shared  or exchange with others.
                </p>
          <li> we will manage your access to the products and provide support to you
          </li>
              <p>we will manage your access to the products and provide support to you , where necessary.you shall not copy, copyrighted materials provided 
                other than for individuals training. Any other purpose is expressly prohibited under this terms.
                <font color="red">You shall not permit anyone else to copy, use , modify,transmit,distribute or in anyway exploit the products or any other copyright materials.</font>
              </p>
          <li> Access to materials the starting date of your access to the content is deemed to be date that you  first have access. </li>
              <p> We will attempt to contact you where your access period ended. Where this is case, we can't guarantee that certification or competition  
                  (as appropriate) will be possible. As such it's your responsibility to ensure that you compete the content within the allocated time.
                  If you do not think this will be  possible,then extention of time are available for purchase at an additional cost .we take all commercially 
                  reasonable steps  to restore your full access   with reasonable time period and  uninterrupted access to the contents. However, 
                  your access may be restricted from time to time for power outages and action outside the law. Your access may interrupted due to 
                  software issues, sever downtime,increase Internet traffic,programming errors,computer hackers,regular maintenance and other related reasons . 
                  Where this is the case we will take reasonable steps to restore full access within short period,in this terms shall mean reasonable efforts 
                  taken in good faith,without an unduly burdensome use or expenditure of time,resources,personel or money. Our joint aims is to provide courses 
                  and materials of highest quality. As such improvements or changes to the content or any other materials may occur at any time without prior noticification
                  in order to ensure that they are up to date and accurate.  Where your access is restricted for any of the above reasons, we may provide you with 
                  free extention of time at our sole discretion. 
              </p>
          <li> Pricing and payments. </li>
                <p>We use third party payment providers, depending on the way in which you make payments eg.paynow, PayPal e.t.c 
                </p>
        </ul>
      </div>
      <div class="modal-footer">
        <h2 >I HAVE READ AND UNDERSTOOD</h2>
        <span class="close">&times;</span>
      </div>
    </div>   
@endsection
@section('body_scripts')
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
  <script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
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
@endsection