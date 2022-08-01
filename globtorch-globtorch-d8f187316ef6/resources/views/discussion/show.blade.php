@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Discussions</h3>
        </div>
        <div class="col-md-3 align-self-center">
            <h3>{{ $subject->name }}</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">
                            @if (count($discussions) > 0)
                                @foreach($discussions as $discussion)
                                <div class="mt-4">
                                    <div class="media mb-4 mt-1">
                                        <img class="d-flex mr-3 rounded-circle thumb-sm" src="{{ URL::to('images/no_picture.jpeg') }}">
                                        <div class="media-body">
                                            <span class="pull-right">{{ $discussion->created_at }}</span>
                                            @if ($discussion->user_id == Auth::user()->id)
                                                <h6 class="m-0">You</h6>
                                            @else
                                                <h6 class="m-0">{{$discussion->user->name . " " . $discussion->user->surname}}</h6>
                                            @endif
                                        </div>
                                    </div>
                                    <p><b><a href="{{route('view_discussion', $discussion->id)}}">{{ $discussion->title }}</a></b></p>
                                    <p>{{ $discussion->body }}</p>
                                    <div class="text-right">
                                        <a href="/view_discussion/{{$discussion->id}}" class="btn btn-primary waves-effect waves-light w-md m-b-30" style="display:inline">View</a>
                                        <a href="/discussion/{{$discussion->id}}/edit" class="btn btn-primary waves-effect waves-light w-md m-b-30" style="display:inline">Edit</a>
                                    </div>
                                    <hr/>
                                </div>
                                @endforeach
                            @else
                                <p class="text-info">There are no discussions for this subject yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection