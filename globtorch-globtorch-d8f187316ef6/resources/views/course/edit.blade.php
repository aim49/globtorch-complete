@extends('layout.master')
@section('content')
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Edit Course</h3> 
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
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
                                <div class="form-validation">
                                    {!! Form::open(['action' => ['CourseController@update', $course_detail->id], 'method'=>'POST']) !!}
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Name <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="name" required value="{{ $course_detail->name }}" placeholder="Enter course name..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-email">Description <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <textarea  class="form-control" id="val-email" rows="6" name="description" required  placeholder="description">{{ $course_detail->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-password">Duration <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-password" required value="{{ $course_detail->duration }}" name="duration" placeholder="Enter Duration..">
                                            </div>
                                        </div>
                                        <div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-password">Level <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-password" required value="{{ $course_detail->level }}" name="level" placeholder="Enter The Level..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-confirm-password">Price <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-confirm-password" required  value="{{ $course_detail->price }}" name="price" placeholder="Price">
                                            </div>
                                        </div>
                                        @foreach($course_detail->exam_boards as $exam_board)
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-skill"> Exam Board<span class="text-danger"></span></label>
                                                <div class="col-lg-6">
                                                    <select class="form-control" id="val-skill" name="exam_board" required>
                                                            @foreach($exams as $exam)
                                                                @if ($exam->id == $exam_board->id)
                                                                    <option selected = "selected" value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                                @else
                                                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-confirm-password">Exam Months <span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="val-confirm-password" required  value="{{ $exam_board->pivot->exam_months }}" name="exam_months" placeholder="Exam Months">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-confirm-password">Exam Price <span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="val-confirm-password" required  value="{{ $exam_board->pivot->exam_price }}" name="exam_price" placeholder="Price">
                                                </div>
                                            </div>
                                        @endforeach
                                            {{Form::hidden('_method', 'PUT')}}
                                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                        {!! Form::close() !!}
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            @endsection()
@section('extraJS')
<script src="js/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>


<!-- Form validation -->
<script src="js/lib/form-validation/jquery.validate.min.js"></script>
<script src="js/lib/form-validation/jquery.validate-init.js"></script>
<!--Custom JavaScript -->
<script src="js/scripts.js"></script>
@endsection()
