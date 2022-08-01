@extends('layout.master')

@section('content')
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-3 align-self-center">
            <h3 class="text-primary">Discussions</h3>
        </div>
        <div class="col-md-3 align-self-center">
            <h3 class="text-success">Subjects</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
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
                        </div><br />
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if (count($courses) > 0)
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
                                                    <a href="/discussion/create/{{$course->subject_id}}" class="btn btn-primary">Add Discussion</a>
                                                    <a href="/discussion/{{$course->subject_id}}" class="btn btn-success">View Discussion</a>
                                                </td>
                                            </tr>                        
                        @elseif($id == $course->id)
                                            <tr>
                                                <td>{{$course->subject}}</td>
                                                <td>
                                                    <a href="/discussion/create/{{$course->subject_id}}" class="btn btn-primary">Add Discussion</a>
                                                    <a href="/discussion/{{$course->subject_id}}" class="btn btn-success">View Discussion</a>
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
                                                    <a href="/discussion/create/{{$course->subject_id}}" class="btn btn-primary">Add Discussion</a>
                                                    <a href="/discussion/{{$course->subject_id}}" class="btn btn-success">View Discussion</a>
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
                @else
                    <p class="text-info">You do not have any subjects assigned to you, contact the administrator to be assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection