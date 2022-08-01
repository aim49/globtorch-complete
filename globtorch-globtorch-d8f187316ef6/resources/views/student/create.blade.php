@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
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
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-validation">
                                {!! Form::open(['action' => 'StudentController@store', 'method'=>'POST']) !!}
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="val-username" required name="name" placeholder="Enter name..">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-email">Surname <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="val-email" required name="surname" placeholder="Enter Surname..">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-password">Date Of Birth</label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" id="val-password" name="dob">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-confirm-password">Gender</label>
                                        <div class="col-lg-6">
                                            <input type="radio" name="gender" value="male" checked> Male
                                            <input type="radio" name="gender" value="female"> Female
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-suggestions">Address</label>
                                        <div class="col-lg-6">
                                            <textarea class="form-control" id="val-suggestions" name="address" rows="5" placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-skill"> City</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="city" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-skill"> School/Institution</label>
                                        <div class="col-lg-6">
                                            {{Form::select('institution_id', $institutions, null, ['class' => 'form-control', 'placeholder' => 'select...'])}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-skill"> Country<span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            {{Form::select('country', $countries, null, ['class' => 'form-control', 'required', 'placeholder' => 'select...'])}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-currency">Phone <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" id="val-currency" required name="phone" placeholder="Enter Phonenumber">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-website">Email</label>
                                        <div class="col-lg-6">
                                            <input type="email" class="form-control" id="val-website" name="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
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
@endsection()
