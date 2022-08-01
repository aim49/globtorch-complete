@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Your Courses</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">CHECK OUT</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="row justify-content-center">
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
        </div>
        <!-- Start Page Content -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?php
                    

                        # save poll Url to database
                        //call controller
                      use App\Http\Controllers\PaynowController;
                      PaynowController::savepoll($ref,$pollUrl,$course_id,$user_id,$enrollment_id);
                        ?>
                        <strong> MAKE PAYMENT NOW </strong><hr/>
                        User ID :{{  Auth::user()->id}}<br/>
                        Fullname : {{Auth::user()->name}}   {{Auth::user()->surname}}<br/>
                        Course ID :  {{ $courses->id}} <br/>
                        Course Name : {{ $courses->name}}<br/>
                        Price : ${{ $courses->price}} <br/>
                        Reference Number : <?php echo  $ref;  ?> <br/>
                        Valid : 1 month<br/><br/>
                        <!--paynow generated url for payment-->
                        <a href="<?php echo $redirectUrl; ?>" class="btn btn-primary">
                            CLICK HERE TO PAY USING PAYNOW
                        </a>
                        
                        <hr/>
                        For further information, please contact:<br/>
                        Ms Pamela Nyasha<br/>
                        Markerting <br/>
                        Tel: +263 775 017 342<br/>
                        Email:sales@globtorch.com<br/>
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