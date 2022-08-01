@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="center">
            <div class="col-lg-6">
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
            </div>
            <div class="col-lg-12">
                <h2>Payment Steps</h2>
                <div class="card">
                    <div class="card-title">
                        <h3>Step 1 - Select the course that you want to buy</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ asset('images/payment_steps/step-1.png') }}"><img src="{{ asset('images/payment_steps/step-1.png') }}" alt="step 1"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <h3>Step 2 - Enter the number of months and the date when you want to start the course</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ asset('images/payment_steps/step-2.png') }}"><img src="{{ asset('images/payment_steps/step-2.png') }}" alt="step 2"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <h3>Step 3 - Enter into paynow as a guest using any email address</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ asset('images/payment_steps/step-3.png') }}"><img src="{{ asset('images/payment_steps/step-3.png') }}" alt="step 3"></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">
                        <h3>Step 4 - Choose payment method and finish transaction</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ asset('images/payment_steps/step-4.png') }}"><img src="{{ asset('images/payment_steps/step-4.png') }}" alt="step 4"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraJS')
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <!-- Form validation -->
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate-init.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>
@endsection