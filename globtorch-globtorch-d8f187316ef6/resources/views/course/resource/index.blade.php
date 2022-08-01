@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Course Resources</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
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
                <div class="card">
                    <div class="card-body">
                        <p>Below are links to awarding bodies:</p>
                        <a class="btn btn-primary btn-block" href="https://www.accaglobal.com/gb/en/qualifications/accountancy-career/fees/fees-charges-ssa.html?countrycode=Zimbabwe" target="_blank">ACCA</a>
                        <a class="btn btn-success btn-block" href="http://www.iac.co.zw/" target="_blank">IAC</a>
                        <a class="btn btn-warning btn-block" href="https://www.zimsec.co.zw/resources/" target="_blank">ZIMSEC</a>
                        <a class="btn btn-danger btn-block" href="https://www.cambridgeinternational.org/programmes-and-qualifications/cambridge-upper-secondary/cambridge-igcse/subjects/" target="_blank">Cambridge</a>
                        <a class="btn btn-primary btn-block" href="https://papers.xtremepape.rs/CAIE/IGCSE/" target="_blank">Xtreme papers</a>
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