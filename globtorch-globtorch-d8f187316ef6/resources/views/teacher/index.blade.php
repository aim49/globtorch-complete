@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Admin</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Students</li>
                </li>
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
                        <h4 class="card-title">View Teachers</h4>
                        <h6 class="card-subtitle">All Teachers</h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Last Login</th>
                                        <th colspan="5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->school_id }} </td>
                                        <td>{{ $teacher->name }} {{ $teacher->surname }} </td>
                                        <td>{{ $teacher->email }} </td>
                                        @if (count($teacher->login_histories) > 0)
                                            <td>{{ $teacher->login_histories->sortByDesc('created_at')->first()->created_at }}</td>
                                        @else
                                            <td class="text-danger">Never Logged In</td>
                                        @endif
                                        <td><a href="/teacher_activity/{{$teacher->id}}" class="btn btn-primary">Activity</a></td>
                                        <td><a href="/teacher/{{$teacher->id}}/edit" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{route('teacher.rating.index', $teacher->id)}}" class="btn btn-success">Ratings</a></td>
                                        <td><a href="{{ route('assign_teacher',['id'=>$teacher->id]) }}" class="btn btn-success">Assign</a></td>    
                                        <td>
                                            {!! Form::open(['action' => ['TeacherController@destroy', $teacher->id], 'method'=>'DELETE']) !!}
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            {!! Form::close() !!}
                                        </td>                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
