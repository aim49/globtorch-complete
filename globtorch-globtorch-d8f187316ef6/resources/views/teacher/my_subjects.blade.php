@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <h3 class="text-primary">My Subjects</h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Subjects</h3>
            </div>
        </div>
		<div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
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
				<div class="col-lg-12">
                    @foreach ($courses as $course)
                        @if ($loop->first)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3>{{ $course->name }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Subject</th>
                                                <th colspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <td>{{$course->subject}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.index', [$course->id, $course->subject_id])}}">View</a>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.create', [$course->id, $course->subject_id])}}">Add Chapter</a>
                                                </td>
                                            </tr>                        
                        @elseif($id == $course->id)
                                            <tr>
                                                <td>{{$course->subject}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.index', [$course->id, $course->subject_id])}}">View</a>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.create', [$course->id, $course->subject_id])}}">Add Chapter</a>
                                                </td>
                                            </tr>
                        @else
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3>{{ $course->name }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Subject</th>
                                                <th colspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <td>{{$course->subject}}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.index', [$course->id, $course->subject_id])}}">View</a>
                                                    <a class="btn btn-primary" href="{{route('course.subject.chapter.create', [$course->id, $course->subject_id])}}">Add Chapter</a>
                                                </td>
                                            </tr>             
                        @endif
                        @if ($loop->last)
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $id = $course->id;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
