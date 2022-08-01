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
           {!! Form::open(['action' => ['Course_BoardController@update', $course_boards->id], 'method'=>'POST']) !!}
            	<legend>Edit a Course-Board</legend>
            
            	<div class="form-group">
            		<label for="">Course Name</label>
					<select name="course_id" id="inputClassroom_id" class="form-control" required="required">
						@foreach ($courses as $course)
						
						<option value="{{ $course->id }}">{{ $course->name }}</option>
						
						@endforeach
					</select>             	</div>
            	<div class="form-group">
            		<label for="">Examination Board</label>
					<select name="board_id" id="inputClassroom_id" class="form-control" required="required">
						@foreach ($exam_boards as $exam_board)
						<option value="{{ $exam_board->id }}">{{ $exam_board->name }}</option>
					
						@endforeach
					</select>            	</div>
            	<div class="form-group">
            		<label for="">Exam Months</label>
            		<input name="exam_months" type="text" class="form-control" id="" placeholder="Enter Exam months" value="{{ $course_boards->exam_months }}" >
            	</div>
            	<div class="form-group">
            		<label for="">Exam Price</label>
            		<input name="exam_price" type="text" class="form-control" id="" placeholder="Enter Price" value="{{ $course_boards->exam_price }}" >
            	</div>

				{{Form::hidden('_method', 'PUT')}}
				{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
			{!! Form::close() !!}
        </div>
    </div>
</div>
@endsection