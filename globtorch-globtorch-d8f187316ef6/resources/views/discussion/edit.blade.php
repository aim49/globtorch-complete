@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3>
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
                                {!! Form::open(['action' => ['DiscussionController@update', $discussion->id], 'method'=>'POST']) !!}
                                    <div class="form-group">
                                        <input type="text" name="title" required value="{{ $discussion->title }}" class="form-control" placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="body" required rows="8" cols="70" class="form-control" style="height:300px">{{ $discussion->body }}</textarea>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <div class="text-right">
                                            {{Form::hidden('_method', 'PUT')}}
                                            {{Form::submit('Submit', ['class' => 'btn btn-purple waves-effect waves-light'])}}
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
@endsection