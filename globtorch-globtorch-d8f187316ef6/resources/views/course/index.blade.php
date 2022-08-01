@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Courses</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Courses</li>
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
                        <h4 class="card-title">View Courses</h4>
                        <h6 class="card-subtitle">All Courses</h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Exam Board</th>
                                        <th>Level</th>
                                        <th>Price</th>
                                        <td>Image</td>
                                        <td>Students</td>
                                        <th colspan="4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $course->name }} </td>
                                            <td>{{ $course->description }}</td>
                                            <td>
                                                @if ($course->exam_boards->first() != null)
                                                    {{ $course->exam_boards->first()->name }}
                                                @endif
                                            </td>
                                            <td>{{ $course->level }} </td>
                                            <td>{{ $course->price }} </td>
                                            <td><img src="{{asset('storage/course/' . $course->image)}}" alt="no image" height="50" width="50"></td>
                                            <td>{{ count($course->users) }}</td>
                                            <td><a href="{{route('course.subject.index', $course->id)}}" class="btn btn-success">View</a></td>
                                            <td><a href="{{route('course.subject.create', $course->id)}}" class="btn btn-success">Add Subject</a></td>
                                            <td><a href="/course/{{$course->id}}/edit" class="btn btn-primary">Edit</a></td>
                                            <td>
                                                {!!Form::open(['action' => ['CourseController@destroy', $course->id], 'method' => 'POST', 'style' =>'display:inline'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                {!!Form::close()!!}
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