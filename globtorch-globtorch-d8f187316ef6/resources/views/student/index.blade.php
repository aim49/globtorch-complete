@extends('layout.master') 
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
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
                @endif @if(session()->has('message'))
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
                        <h4 class="card-title">View Students</h4>
                        <div class="container">
                            {!! Form::open(['action' => 'StudentController@search', 'method'=>'POST']) !!}
                                <div class="form-group row">
                                    {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('name', null, ['class'=>'col-lg-8 form-control'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('surname', 'Surname', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('surname', null, ['class'=>'col-lg-8 form-control'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('user_id', 'User ID', ['class'=>'col-lg-4 col-form-label'])}}
                                    {{Form::text('user_id', null, ['class'=>'col-lg-8 form-control'])}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="table-responsive m-t-40">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>School ID</th>
                                        <th>Surname</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Country</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->school_id }} </td>
                                        <td class="text-capitalize">{{ $student->surname }}</span></td>
                                        <td class="text-capitalize">{{ $student->name }}</td>
                                        <td>{{ $student->gender }} </td>
                                        <td>{{ $student->country }} </td>
                                        <td>{{ $student->phone }} </td>
                                        <td>{{ $student->email }} </td>
                                        <td><a href="{{ route('user.edit', $student->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{ route('password.reset', $student->id) }}" class="btn btn-primary">Reset Password</a></td>
                                        <td>
                                            {!! Form::open(['action' => ['StudentController@destroy', $student->id], 'method'=>'DELETE']) !!}
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br />
                            {{$students->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection