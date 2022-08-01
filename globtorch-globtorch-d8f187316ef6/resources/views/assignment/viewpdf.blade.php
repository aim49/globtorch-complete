@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
      
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Upload Assignments</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Upload Assignments</li>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="card-content">
                                        <div class="mt-4">
                     //pdf view area
                     <embed
    src="{{ action('AssignmentController@getDocument', ['id'=> $assignment->id]) }}"
    style="width:600px; height:800px;"
    frameborder="0"
>
                                        </div>
                                        <!-- end card-->
                                    </div>
                                     </div>
                                     </div>
                                     </div>
                </div>
                <!-- End PAge Content -->
              
                @endsection()
