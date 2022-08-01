@extends('layout.master')
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Teacher</h3> 
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
                        <h4 class="card-title">{{$subject->name}}</h4>
                        <h6 class="card-subtitle">All Assignments</h6>
                        <div class="table-responsive m-t-40">
                            @if (count($subject->assignments) > 0)
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date Created</th>
                                            <th>Due Date</th>
                                            <th>Teacher</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subject->assignments as $assignment)
                                            <tr>
                                                <td>{{ $assignment->name }} </td>
                                                <td>{{ $assignment->created_at }}</td>
                                                <td>{{ $assignment->due_date }}</td>
                                                @if ($assignment->user != null)
                                                    <td>{{ $assignment->user->name . " " . $assignment->user->surname }}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('edit_assignments',['id'=>$assignment->id]) }}" class="btn btn-warning">Edit </a> &nbsp;
                                                    <a href="/assignment/download/{{$assignment->id}}" class="btn btn-info">Download/View </a> &nbsp;
                                                    <a href="{{ route('get_assignments_answer',['id'=>$assignment->id,'name'=>$assignment->name]) }}" class="btn btn-success">Add Marks </a> &nbsp;                                             
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-info">You do not have any assignments</p>
                            @endif    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

