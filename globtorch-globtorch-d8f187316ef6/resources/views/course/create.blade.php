@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Add Course</h3>
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
                            {!! Form::open(['action' => 'CourseController@store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                                <fieldset>
                                    <legend>Course details:</legend>
                                    <div class="form-group row">
                                        {{Form::label('code', 'Code', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('code', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter course code..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('name', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter course name..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('description', 'Description', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::textarea('description', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter description..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('duration', 'Duration', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('duration', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter Duration..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('level', 'Level', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::select('level', ['Primary' => 'Primary', 'Secondary' => 'Secondary', 'Tertiary' => 'Tertiary'], null, ['class' => 'form-control col-lg-6','placeholder'=>'Pick the level...', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('price', 'Price', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('price', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter price..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('image', 'Course Image', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::file('image', null)}}
                                    </div>
                                </fieldset>
                                <br />
                                <fieldset>
                                    <legend>Exam Board details:</legend>
                                    <div class="form-group row">
                                        {{Form::label('exam_board', 'Exam Board', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::select('exam_board', $exams, null, ['class' => 'form-control col-lg-6','placeholder'=>'Pick the exam board...', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('exam_months', 'Exam Months', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('exam_months', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter exam months..', 'required'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('exam_price', 'Exam Prices', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('exam_price', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Enter exam price..', 'required'])}}
                                    </div>
                                </fieldset>
                                <br />
                                <div class="form-group row">
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary col-lg-8 ml-auto'])}}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
@endsection