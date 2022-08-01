@extends('app.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
<h1>Course-Board</h1>
        <a href="{{ url('/course_board/create') }}"><button type="button" class="btn btn-lg btn-info">Add a new course-board relationship</button></a>
        <hr><br>
    <div class="table-responsive m-t-40">
        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Examination Board</th>
                        <th>Examination month</th>
                        <th>Price</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
           
                @foreach ($course_boards as $course_board)
                    <tr>
                        <td>{{ $course_board->id }}</td>
                        <td>{{ $course_board->course->name }}</td>
                        <td>{{ $course_board->board->name }}</td>
                        <td>{{ $course_board->exam_months }}</td>
                        <td>{{ $course_board->exam_price }}</td>
                        <td><a href="/course_board/{{ $course_board->id }}/edit"><button type="button" class="btn btn-priamry">Edit</button></a></td>
                        <td><a href="{{ url('/course_board/delete') }}/{{ $course_board->id }}"><button type="button" class="btn btn-danger">Delete</button></a></td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection