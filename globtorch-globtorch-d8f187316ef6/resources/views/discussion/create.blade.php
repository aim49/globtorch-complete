@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
@foreach($subject_details as $subject_detail)
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Discussions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Discussions Posts</li>
            </ol>
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
                                {!! Form::open(['action' => 'DiscussionController@store', 'method'=>'POST']) !!}
                                    <div class="form-group">
                                        <input type="text" name="id" class="form-control" value="{{$subject_detail->id}}" required hidden>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" required name="title" class="form-control" placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="body" required placeholder="Discussion Body" rows="8" cols="70" class="form-control" style="height:300px"></textarea>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="text-right">
                                            <button class="btn btn-purple waves-effect waves-light"> <span>Save</span> <i class="fa fa-send m-l-10"></i> </button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection