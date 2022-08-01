@extends('layout.auth.app')
@section('head_scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('content')
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
                <div class="card">
                    <div class="card-title">
                        <h3>Choose a course</h3>
                    </div>
                    <div class="card-body">
                        <p>
                            Pay the registration fee and receive a scholarship for the duration of your study.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Course</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{$course->name}}</td>
                                        <td>
                                            @if ($course->level == 'Primary')
                                                RTGS {{5*100}}/year
                                            @elseif ($course->level == 'Secondary')
                                                RTGS {{10*100}}/year
                                            @elseif($course->level == 'Tertiary')
                                                RTGS {{15*100}}/6 months
                                            @endif
                                        </td>
                                        <td><a class="btn btn-primary" href="{{route('register.course', $course->id)}}">Buy</a></td>
                                    </tr>
                                @endforeach  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('body_scripts')
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