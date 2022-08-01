@extends('layout.master')
@section('content')
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Teacher</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Teacher</li>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">
                                    @foreach($teacher_details as $teacher_detail)
                                    <form class="form-valide" action="{{ route('update_teacher_post',['id'=>$teacher_detail->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Name <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" value="{{ $teacher_detail->name }}" id="val-username" required name="name" placeholder="Enter name..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-email">Surname <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-email" value="{{ $teacher_detail->surname }}" required name="surname" placeholder="Enter Surname..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-password">Date Of Birth <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="date" class="form-control" value="{{ $teacher_detail->dob }}" id="val-password" required name="dob">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-confirm-password">Gender <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="radio" name="gender" value="Male" checked> Male
                                                <input type="radio" name="gender" value="Female"> Female
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-suggestions">Address <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="val-suggestions"  required name="address" rows="5" placeholder="{{ $teacher_detail->address }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-skill"> City<span class="text-danger"></span></label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-skill" name="city" required>
                                                    <option value="{{ $teacher_detail->city }}">{{ $teacher_detail->city }}</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-currency">Phonenumber <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control" id="val-currency" value="{{ $teacher_detail->phone }}" required name="phonenumber" placeholder="Enter Phonenumber">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-website">Email <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" value="{{ $teacher_detail->email }}" required id="val-website" name="email" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
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
