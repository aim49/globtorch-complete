@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Discussions</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
        <div class="row">
            <div class="col-12">
                @foreach ($courses as $course)
                    <div class="card">
                        <div class="card-title">
                            <h3>{{$course->name . ' (' . $course->exam_boards->first()->name . ')'}}</h3>
                        </div>
                        <div class="card-body">
                            @if(count($course->subjects) > 0)
                                @foreach($course->subjects as $subject)
                                    <b><u>{{$subject->name}}</u></b>
                                    <br>
                                    @if (count($subject->discussions) > 0)
                                        @foreach($subject->discussions as $discussion)
                                            <a href="{{route('view_discussion', $discussion->id)}}">{{$discussion->title}}</a>
                                            <br>
                                        @endforeach
                                    @else
                                        <p class="text-info">There are no discussions yet. Please check again soon.</p>
                                    @endif
                                    <a href="/discussion/create/{{$subject->id}}" class="btn btn-primary">Ask a question</a>
                                    <br>
                                    <br />
                                @endforeach
                            @else
                                <p class="text-info">There are no discussions on this course yet. Please check again soon.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
@endsection