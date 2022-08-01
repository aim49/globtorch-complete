@extends('app.layout') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ url('/course_board/') }}" method="POST" role="form">
                {{ csrf_field() }}
                <legend>Add a new Course</legend>
                <div class="form-group">
                    <label for="">Course Name</label>
                    <select name="course_id" id="inputClassroom_id" class="form-control" required="required">
						@foreach ($courses as $course)
						
						<option value="{{ $course->id }}">{{ $course->name }}</option>
						
						@endforeach
					</select>
                </div>
                <div class="form-group">
                    <label for="">Examination Board</label>
                    <select name="board_id" id="inputClassroom_id" class="form-control" required="required">
						@foreach ($exam_boards as $exam_board)
						<option value="{{ $exam_board->id }}">{{ $exam_board->name }}</option>
					
						@endforeach
					</select>
                </div>
                <div class="form-group">
                    <label for="">Examination month</label>
                    <input name="exam_months" type="number" class="form-control" id="" placeholder="Enter exam_months">
                </div>
                <div class="form-group">
                    <label for="">Price</label>
                    <input name="exam_price" type="text" class="form-control" id="" placeholder="Enter Price">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection