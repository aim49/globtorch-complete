@extends('layout.master')
@section('content')
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Admin</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Students</li></li>
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
                                <h4 class="card-title">View Teachers</h4>
                                <h6 class="card-subtitle">All Teachers</h6>
                                <div class="table-responsive m-t-40">
                                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Full Name</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                                <th>Assign</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($teachers as $teacher)
                                            <tr>
                                                <td>{{ $teacher->school_id }} </td>
                                                <td>{{ $teacher->name }} {{ $teacher->surname }} </td>
                                                <td>{{ $teacher->gender }} </td>
                                                <td>{{ $teacher->address }} </td>
                                                <td>{{ $teacher->city }} </td>
                                                <td>{{ $teacher->email }} </td>
                                                <td><a href="{{ route('edit_teacher',['id'=>$teacher->id]) }}" class="btn btn-primary">Edit</a>&nbsp;&nbsp;&nbsp;<a href="{{ route('delete_teacher',['id'=>$teacher->id]) }}" class="btn btn-danger">Delete</a> </td>
                                                <td><a href="{{ route('assign_teacher',['id'=>$teacher->id]) }}" class="btn btn-success">Assign</a> </td>
                                            </tr>
                                            @endforeach()


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End PAge Content -->


            @endsection()


