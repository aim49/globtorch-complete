@extends('layout.master')
@section('content')
    <style>
        p{
            color:black;
        }
    </style>
    
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <!--Navigation links to go back-->
                <h3>
                    <a href="/subject/{{$content->topic->chapter->subject_id}}">{{$content->topic->chapter->subject->name}}/</a>
                    <a href="#">{{$content->topic->chapter->name}}/</a>
                    <a href="/topic/{{$content->topic->id}}" class="text-primary">{{$content->topic->name}}</a>
                </h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Content</h3>
            </div>
        </div>
        <!-- End Bread crumb -->
            
        <!-- Container fluid  -->
		<div class="container-fluid">
            <div class="row">
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
                </div>
            </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-9 center">
                            @if($content->type == 'video')
                                <h1>{{$content->name}}</h1>
                                <video width="640" height="480" controls>
                                    <source src="/storage/content/{{$content->path}}" type="video/mp4">
                                    <source src="/storage/content/{{$content->path}}" type="video/ogg">
                                Please update your browser to enable video features
                                </video>
                            @elseif ($content->type == 'audio')
                                <audio controls>
                                    <source src="/storage/content/{{$content->path}}" type="audio/ogg">
                                    <source src="/storage/content/{{$content->path}}" type="audio/mpeg">
                                Please update your browser to enable audio features
                                </audio>
                            @endif
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection