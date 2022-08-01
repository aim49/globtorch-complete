@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Assignments Marks</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View Assignments Marks</li></li>
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
                                <h4 class="card-title">My Assignments Marks</h4>
                                <h6 class="card-subtitle">View Assignment Marks</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Assignment Name</th>
                                                <th>Student Name</th>
                                                <th>Submited Date</th>
                                                <th>Assignment Mark</th>
                                                 <th>Comment</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($assignments as $assignment)
                                            <tr>
                                                <td>{{ $assignment->assignment->name }} </td>
                                                <td>{{ $assignment->user->name }}</td>
                                                <td>{{ $assignment->updated_at }}</td>
                                                <td>{{ $assignment->mark }}</td>
                                                <td>{{ $assignment->comment }}</td>
                                                <td>
                                                 <a href="{{ route('add_assignments_mark',['id'=>$assignment->id]) }}" class="btn btn-primary"> Add Mark</a> &nbsp;
                                                <a href="" class="btn btn-warning">Edit</a> &nbsp;
                                                 <a href="" class="btn btn-danger">Delete</a> &nbsp;
                                                 </td>

                                            </tr>
                                            @endforeach()


                                        </tbody>
                                    </table>
                                </div>
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
                    </div>
                </div>
                <!-- End PAge Content -->


            @endsection()
