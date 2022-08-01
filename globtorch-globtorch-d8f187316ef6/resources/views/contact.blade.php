@extends('layout.landing_page.app')
@section('content')
	<!-- PageBanner -->
	<div class="container-fluid no-padding pagebanner">
		<div class="container">
			<div class="pagebanner-content">
				<h3>Contact us</h3>
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li>Contact us</li>
				</ol>
			</div>
		</div>
	</div><!-- PageBanner /- -->
	<!-- ContactUs Section -->
	<div class="container-fluid no-padding contactus-section">
		<div class="container">
			<div class="section-padding"></div>
			<div class="row">
				<div class="col-md-6">
					<div class="map">
						<div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3798.182860769249!2d31.042982115201813!3d-17.83006078105055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1931a4e4cc7e93c9%3A0xfab665cf130dcd87!2sLeopold+Takawira+Street+%26+Nelson+Mandela+Avenue%2C+Harare!5e0!3m2!1sen!2szw!4v1548679552406" width="100%" height="550" frameborder="0" style="border:0" allowfullscreen></iframe></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="getintouch">
						<h3>Get in touch </h3>
						<p>Do you have a question, query or comment? <br/>
							Yes – then we want to hear from you! Drop us a line and a GLOBTORCH representative will be in touch soon.</p>
						<form class="contactus-form" id="contact-form">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<input type="text" required="" placeholder="Name" id="input_name" class="form-control" name="contact-name">
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<input type="email" required="" placeholder="Email" id="input_email" class="form-control" name="contact-email">
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<textarea placeholder="Message" id="textarea_message" class="form-control" name="contact-message" rows="5"></textarea>
									</div>
								</div>	
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<input type="submit" name="post" title="Send" id="btn_submit" value="Submit">
									</div>
								</div>
								<div class="alert-msg" id="alert-msg"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="section-padding"></div>
		</div>
		<div class="contactdetail-block">
			<div class="container">
				<div class="col-md-3 col-sm-3 col-xs-6 contactinfo-box">
					<span class="icon icon-Pointer"></span>
					<h3>Where We Are?</h3>
					<p>603 Barbara House, 6th Floor, Cnr Takawira & N.Mandela, Harare , Zimbabwe</p>
					
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 contactinfo-box">
					<span class="icon icon-Phone2"></span>
					<h3>Give us a Call</h3>
					<p>Your future is just one ring away.</p>
					<a href="tel:+263782476323" title="(+263) 0782 476 323"> (+263) 0782 476 323</a>
					<a href="tel:+263777713962" title="(+263) 077 771 3962"> (+263) 077 771 3962</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 contactinfo-box">
					<span class="icon icon-Printer"></span>
					<h3>Vist Our Office</h3>
					<p>You learn online but we would still love to meet you in person, come by!</p>
					<a href="#" title="Get Direction">Get Direction</a>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 contactinfo-box">
					<span class="icon icon-Imbox"></span>
					<h3>Drop us a Line</h3>
					<p>Give us a shout anytime, we look forward to hearing from you.</p>
					<a href="mailto:info@globtorch.com" title=" info@globtorch.com"> info@globtorch.com</a>
				</div>
			</div>
		</div>
	</div><!-- ContactUs Section /- -->	
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