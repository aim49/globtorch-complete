@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <h3>
                    <a href="/subject/{{$chapter->subject_id}}">{{$chapter->subject->name}}/</a>
                    <a href="/chapter/{{$chapter->id}}">{{$chapter->name}}/</a>
                </h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Topics</h3>
            </div>
            <div class="col-md-6 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Class</li>
                    <li class="breadcrumb-item active">Topics</li>
                </ol>
            </div>
        </div>
        <!-- End Bread crumb -->
            
        <!-- Container fluid  -->
		<div class="container-fluid">
            @if(Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
			<div class="row">
				<div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9">
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
						<div class="col-lg-9">
							<div class="card">
								<div class="card-title">
									<h2 class="text-primary">  </h2>
								</div>
								<div class="row">
                                    @foreach ($chapter->topics->sortBy('order') as $topic)
                                        <div class="col-md-3">
                                            <div class="card p-30">
                                                <div class="media">
                                                    <div class="media-left meida media-middle">
                                                        <span><img alt="..." src="{{ URL::to('images/vita/curriculum_vitae.png') }}" class="media-object"></span>
                                                    </div>
                                                    <div class="media-body media-text-right">
                                                        <a href = "/topic/{{$topic->id}}"> <h2>{{$topic->order . '. ' . $topic->name }}</h2></a>
                                                    </div>
                                                </div>
                                                <br>
                                            @if(auth()->user()->user_type!='student')    
                                                <a href="/content/create/{{$topic->id}}" class="btn btn-primary">Add Content</a>
                                            @endif
                                                <a href="/topic/{{$topic->id}}" class="btn btn-default">View Topic</a>
                                            </div>
                                        </div>
                                    @endforeach
			                    </div>
							</div>
							<div class="card">
								<div class="card-title">
									<h3 class="text-primary"><!-- hdjdijfdkfdklf _--> </h3>
									<h4 class= "text-success"><!-- hdjdijfdkfdklf _--> </h4>
								</div>
								<div class="card-body">
									<!-- hdjdijfdkfdklf _-->
								</div>
							</div>

							<!-- /# card -->
						</div>
					</div>
                        <!-- /# column -->
                </div>
            </div>
        </div>
    </div>
@endsection()
