@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$result->chapter->name}}</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Chapter Test Results</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row justify-content-center">
                <div class="col-lg-12">
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
                <div class="card" >
                <div style="width:100%;  padding:20px; text-align:center; border: 10px solid green; color:black;">
                    <div style="width:99%;  padding:20px; text-align:center; border: 5px solid blue">
                       
                        <img src="{{ URL::to('images/logo.png') }}" alt="logo"  /> <br/>   <br/>           
                        <span style="font-size:50px; font-weight:bold">Certificate of Completion</span>
                        <br><br>
                        <span style="font-size:25px"><i>This is to certify that :</i></span>
                        <br><br>
                        <span style="font-size:30px"><b>{{ Auth::user()->name  }}  {{ Auth::user()->surname  }}</b></span><br/><br/>
                        <span style="font-size:25px"><i>has completed the chapter </i></span> <br/><br/>
                        <span style="font-size:30px">{{$result->chapter->name}}</span> <br/><br/>
                        <span style="font-size:20px">with score of <b>{{ $result->percentage }}%</b></span> <br/><br/><br/>
                        <span style="font-size:25px"><i>dated</i></span><br/>
                        <span style="font-size:30px">{{ date('Y-m-d')  }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
                <div class="card">
					<div class="card-body" style="text-align:center;">
								   @if ($result->percentage >= 50)
                           <h3 class="text-success">YOU HAVE PASSED</h3>
                        @else
                           <h3 class="text-danger">YOU HAVE FAILED</h3>
                        @endif
                        <a href="/chapter_answer/create/{{$result->chapter_id}}" class="video-button mt30 inline-block"><i class="fa fa-play"></i>TRY AGAIN </a>                                   
					
					</div>
			</div>
@endsection()

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
@endsection()
