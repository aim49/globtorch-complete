@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">My Teachers</h3>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($teachers as $teacher)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="{{asset('images/no_profile_pic.png')}}" alt="Card image">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$teacher->name}} {{$teacher->surname}}</h4>
                                            <p class="card-text">
                                                @php
                                                   $ratings = $teacher->teacher_ratings->average('score');
                                                   $subjects = $teacher->subjects->whereIn('id', $subject_ids);
                                                @endphp
                                                @for ($i = 0; $i < $ratings; $i++)
                                                    <span class="fa fa-star checked text-warning"></span>
                                                @endfor
                                                @for ($i = $ratings; $i < 5; $i++)
                                                    <span class="fa fa-star"></span>
                                                @endfor
                                                <br />
                                                @foreach ($subjects as $subject)
                                                    {{$subject->name}}<br />
                                                @endforeach
                                            </p>
                                            <a href="{{route('teacher.show', $teacher->id)}}" class="btn btn-primary">See Profile</a>
                                            <a href="{{route('teacher.rating.create', $teacher->id)}}" class="btn btn-primary">Rate Teacher</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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