@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Upload Assignments</h3> 
        </div>
    </div>
    <div class="container-fluid">
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
                                {!! Form::open(['action' => ['SubjectAssignmentController@store', $subject->id], 'method'=>'POST', 'files' => true]) !!}
                                    <div class="form-group">
                                        <label for="">Subject</label>
                                        <input type="text" required name="subject" class="form-control" value="{{ $subject->name }}" placeholder="subject" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Assignment Name</label>
                                        <input type="text" required name="name" class="form-control" placeholder="Name" required>
                                    </div>
                                        <div class="form-group">
                                            <label for="">Due Date</label>
                                            <input type="date" required name="due_date" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">PDF FILE</label>
                                            <input type="file"  name="file_upload" class="form-control" required>
                                        </div>
                                    <div class="form-group m-b-0">
                                        <div class="text-right">
                                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
