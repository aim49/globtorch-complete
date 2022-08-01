@extends('layout.master')
@section('content')
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Assignments</h3> 
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
                                <h4 class="card-title">{{$subject_name}}</h4>
                                <h6 class="card-subtitle">All Assignments</h6>
                                <div class="table-responsive m-t-40">
                                   @if (count($assignments) > 0)
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date/Time</th>
                                                <th>Due Date</th>
                                                <th>Questions</th>
                                                <th>Answer</th>
                                                <th>Mark %</th>
                                                <th>Marked Answer</th>
                                                <th>Action  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assignments as $assignment)
                                            <tr>
                                                <td>{{ $assignment->name }} </td>
                                                <td>{{ $assignment->created_at }}</td>
                                                <td>{{ $assignment->due_date }}</td>
                                                <td><a href="/assignment/download/{{$assignment->id}}" class="btn btn-info">Download/View </a></td>

                                                @if ($assignment->due_date >= date('Y-m-d') )
                                                    @if ($assignment->answer == null)
                                                        <td>Not yet submitted..</td>
                                                    @else
                                                        <td>Submitted</td>
                                                    @endif

                                                    @if ($assignment->mark == null)
                                                        <td>Pending</td>
                                                    @else
                                                        <td>{{$assignment->mark}}</td>
                                                    @endif

                                                    @if ($assignment->marked_answer == null)
                                                        <td>Pending</td>
                                                    @else
                                                        <td><a href="{{ asset('/storage/files/assignments/'. $assignment->marked_answer) }}" class="btn btn-info">Download/View</td>
                                                    @endif
                                                    
                                                    @if ($assignment->answer == null)
                                                        <td><a href="{{ route('submit_assignments',['id'=>$assignment->id]) }}" class="btn btn-success" >Submit Assignment </a></td>
                                                    @else
                                                        <td><a href="{{ route('editsubmit_assignments',['id'=>$assignment->answer_id]) }}" class="btn btn-info">Edit Submitted</a></td>
                                                    @endif
                                                @else
                                                    @if ($assignment->answer == null)
                                                        <td>Did not submit</td>
                                                    @else
                                                        <td>Submitted</td>
                                                    @endif
                                                    
                                                    @if ($assignment->mark == null)
                                                        <td>Pending</td>
                                                    @else
                                                        <td>{{$assignment->mark}}</td>
                                                    @endif
                                                    @if ($assignment->marked_answer == null)
                                                        <td>Pending</td>
                                                    @else
                                                        <td><a href="{{ asset('/storage/files/assignments/'. $assignment->marked_answer) }}" class="btn btn-info">Download/View</td>
                                                    @endif
                                                    <td><p class="btn btn-danger">Assignment Overdue </p></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <p class="text-info">You do not have any assignments yet! Please check again with us soon.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 
