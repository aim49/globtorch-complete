@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Discussion</h3>
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
                            <div class="mt-4">
                                <div class="media mb-4 mt-1">
                                    <img class="d-flex mr-3 rounded-circle thumb-sm" src="{{ URL::to('images/no_picture.jpeg') }}">
                                    <div class="media-body">
                                        <span class="pull-right">{{$discussion->user->surname . " " . $discussion->user->name}} <br> {{ $discussion->created_at->diffForHumans() }}</span>
                                        <h6 class="m-0">{{ $discussion->name }}</h6>
                                    </div>
                                </div>

                                <p><b>{{$discussion->subject->name . ": " . $discussion->title }}</b></p>
                                <p>{{ $discussion->body }}</p>
                                <hr/>
                            </div>
                            <!-- card-box -->
                            @foreach($discussion->comments as $comment)
                            <div class="media mb-0 mt-5">
                                <img class="d-flex mr-3 rounded-circle thumb-sm" src="{{ URL::to('images/no_picture.jpeg') }}">
                                <div class="media-body">
                                    <div class="card-box">
                                        <div class="summernote">
                                            <h6>{{$comment->user->surname . " " . $comment->user->name}}</h6>
                                            <p>
                                                {{$comment->comment}}
                                            </p>
                                            <p>
                                                {{$comment->created_at->diffForHumans()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="card">
                                <div class="card-block">
                                    <form method="post" action="{{ route('comment',['id'=>$discussion->id]) }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <textarea name="body" placeholder="Your comment here" class="form-control" required></textarea>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Add Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
@endsection