@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
      
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Submit/Upload Assignments </h3> 
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
                                       
                                            <form role="form" method="post" action="{{ route('save_assignmentmark') }}" enctype="multipart/form-data"  >
                                                {{ csrf_field() }}
                                            
                                                <div class="form-group">
                                                  <label for="">Assignment Name</label>
                                                      <input type="hidden"  name="assignment_id" class="form-control" value="{{ $assignments->id }}" required> 
                                                      <input type="text"  name="assign" class="form-control" value="{{ $assignments->name }}" disabled>                                              
                                                </div>
 
                                                <div class="form-group">
                                                <label for="">ZIP FILE</label>
                                                    <input type="file"  name="file_upload" class="form-control" required>
                                                </div>
                                                
                                                <div class="form-group m-b-0">
                                                    <div class="text-right">
                                                        <button class="btn btn-purple waves-effect waves-light"> <span>Save Assignment Answer</span> <i class="fa fa-send m-l-10"></i> </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end card-->
                                    </div>
                                     </div>
                                     </div>
                                     </div>
                </div>
                <!-- End PAge Content -->
              
                @endsection()
