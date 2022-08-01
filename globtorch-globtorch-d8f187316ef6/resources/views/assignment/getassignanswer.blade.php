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
                        <h4 class="card-title">{{ $assignment->subject->name }} | {{$assignment->name}}</h4>
                        <h6 class="card-subtitle">All Students</h6>
                        <div class="table-responsive m-t-40">
                            <table class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                                <tr>
                                    <td>Assignment: </td>
                                    <td><a href="/assignment/download/{{$assignment->id}}" class="btn btn-info">Download/View </a></td>
                                </tr>
                                <tr>
                                    <td>Created At:</td>
                                    <td>{{$assignment->created_at}}</td>
                                </tr>
                                <tr>
                                    <td>Due Date:</td>
                                    <td>{{$assignment->due_date}}</td>
                                </tr>
                            </table>
                        </div>

                        @if (count($answers = $assignment->assignmentanswer) > 0)
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Fullname</th>
                                    <th>Answer</th>
                                    <th>Mark %</th>
                                    <th>Marked Answer</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody> 
                                    @foreach($answers as $answer)
                                        @if ($answer->user != null)
                                            <tr> 
                                                <td>{{ $answer->user->school_id}}</td>
                                                <td>{{ $answer->user->name}}  {{ $answer->user->surname}} </td>
                                                
                                                @if ($answer->file_path == null)
                                                    <td>Did not submit</td>
                                                @else
                                                    <td><a href="{{ asset('/storage/files/assignments/' . $answer->file_path) }}" class="btn btn-info">Download/View </a></td>
                                                @endif
                                                @if ($answer->mark == null)
                                                    <td>Waiting to be marked</td>
                                                @else
                                                    <td>{{ $answer->mark }}</td>
                                                @endif
                                                @if ($answer->marked_answer == null)
                                                    <td>Waiting to be marked</td>
                                                @else
                                                    <td><a href="{{ asset('/storage/files/assignments/'. $answer->marked_answer) }}" class="btn btn-info" target="_blank">Download/View</td>
                                                @endif
                                                <td> 
                                                    <a href="{{ route('add_assignments_mark',['id'=>$answer->id]  ) }}" class="btn btn-success">
                                                        @if ($answer->marked_answer == null)
                                                            Add Assignment Mark
                                                        @else
                                                            Edit Assignment Mark
                                                        @endif
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
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
