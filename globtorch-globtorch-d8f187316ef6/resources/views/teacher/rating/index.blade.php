@extends('layout.master') 
@section('extraCSS')
<style>

    .heading {
        font-size: 25px;
        margin-right: 25px;
    }

    .fa {
        font-size: 25px;
    }

    .checked {
        color: orange;
    }

    /* Three column layout */
    .side {
        float: left;
        width: 15%;
        margin-top: 10px;
    }

    .middle {
        float: left;
        width: 70%;
        margin-top: 10px;
    }

    /* Place text to the right */
    .right {
        text-align: right;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* The bar container */
    .bar-container {
        width: 100%;
        background-color: #f1f1f1;
        text-align: center;
        color: white;
    }

    /* Individual bars */
    .bar-5 {height: 18px; background-color: #4CAF50;}
    .bar-4 {height: 18px; background-color: #2196F3;}
    .bar-3 {height: 18px; background-color: #00bcd4;}
    .bar-2 {height: 18px; background-color: #ff9800;}
    .bar-1 {height: 18px; background-color: #f44336;}

    /* Responsive layout - make the columns stack on top of each other instead of next to each other */
    @media (max-width: 400px) {
        .side, .middle {
            width: 100%;
        }
        /* Hide the right column on small screens */
        .right {
            display: none;
        }
    }
</style>
@endsection
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Teacher Ratings</h3>
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
                        <span class="heading">{{$teacher->name}} {{$teacher->surname}}</span>
                        @php
                            $ratings = $teacher->teacher_ratings;
                            $average_rating = $ratings->average('score');
                        @endphp
                        @for ($i = 0; $i < $average_rating; $i++)
                            <span id="{{$i}}" class="fa fa-star checked"></span>
                        @endfor
                        @for ($i = 5; $i > $average_rating; $i--)
                            <span id="{{$i}}" class="fa fa-star"></span>
                        @endfor
                        <p>{{$average_rating}} average based on <span id="num_ratings">{{count($ratings)}}</span> reviews.</p>
                        <hr style="border:3px solid #f1f1f1">

                        <div class="row">
                            <div class="side">
                                <div>5 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                <div class="bar-5"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div><span id="score-5">{{count($ratings->where('score',5))}}</span></div>
                            </div>
                            <div class="side">
                                <div>4 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                <div class="bar-4"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div><span id="score-4">{{count($ratings->where('score',4))}}</span></div>
                            </div>
                            <div class="side">
                                <div>3 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                <div class="bar-3"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div><span id="score-3">{{count($ratings->where('score',3))}}</span></div>
                            </div>
                            <div class="side">
                                <div>2 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                <div class="bar-2"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div><span id="score-2">{{count($ratings->where('score',2))}}</span></div>
                            </div>
                            <div class="side">
                                <div>1 star</div>
                            </div>
                            <div class="middle">
                                <div class="bar-container">
                                <div class="bar-1"></div>
                                </div>
                            </div>
                            <div class="side right">
                                <div><span id="score-1">{{count($ratings->where('score',1))}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <span class="heading">Comments</span>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Comment</th>
                                    <th>Rating</th>
                                    <th>Student</th>
                                </tr>
                                @foreach ($ratings as $rating)
                                    <tr>
                                        <td>{{$rating->comment}}</td>
                                        <td>{{$rating->score}}</td>
                                        <td>{{$rating->student->name}} {{$rating->student->surname}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraJS')
    <script>
        $(document).ready(function(){
            var num_ratings = $("#num_ratings").html();
            var score_1 = $("#score-1").html();
            var score_2 = $("#score-2").html();
            var score_3 = $("#score-3").html();
            var score_4 = $("#score-4").html();
            var score_5 = $("#score-5").html();
            var bar_1 = $(".bar-1");
            var bar_2 = $(".bar-2");
            var bar_3 = $(".bar-3");
            var bar_4 = $(".bar-4");
            var bar_5 = $(".bar-5");
            bar_1.css('width', (score_1 / num_ratings * 100) + '%');
            bar_2.css('width', (score_2 / num_ratings * 100) + '%');
            bar_3.css('width', (score_3 / num_ratings * 100) + '%');
            bar_4.css('width', (score_4 / num_ratings * 100) + '%');
            bar_5.css('width', (score_5 / num_ratings * 100) + '%');
        });
    </script>

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