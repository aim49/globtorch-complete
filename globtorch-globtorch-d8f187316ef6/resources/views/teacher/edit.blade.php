@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Edit Teacher</h3>
        </div>
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
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            {!! Form::open(['action' => ['TeacherController@update', $teacher->id], 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Name <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" value="{{ $teacher->name }}" id="val-username" required name="name" placeholder="Enter name..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-email">Surname <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-email" value="{{ $teacher->surname }}" required name="surname" placeholder="Enter Surname..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-password">Date Of Birth <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="date" class="form-control" value="{{ $teacher->dob }}" id="val-password" required name="dob">
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
                                        <textarea class="form-control" id="val-suggestions" required name="address" rows="5">{{ $teacher->address }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">City<span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="city" value="{{$teacher->city}}" placeholder="City" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Country<span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="country" value="{{$teacher->country}}" placeholder="City" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-currency">Phonenumber <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" id="val-currency" value="{{ $teacher->phone }}" required name="phonenumber"
                                            placeholder="Enter Phonenumber">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-website">Email <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" value="{{ $teacher->email }}" required id="val-website" name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-description">Skills and Experience</label>
                                    <div class="col-lg-6">
                                        <textarea rows="10" style="height:100%" class="form-control" id="val-description" name="description" placeholder="Enter Skills and Experience">{{$teacher->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary btn-block'])}}
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
@endsection