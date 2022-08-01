@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$question->chapter->name}}</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Question</li>
                </ol>
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
                                <h3 class="text-primary">Edit Question</h3> 
                                <p class="text-info">Select the option next to the answer that is correct to mark it as the right answer</p>
                                {!! Form::open(['action' => ['ChapterQuestionController@update', $question->id], 'method'=>'POST']) !!}
                                    <div class="form-group row">
                                        {{Form::label('question', 'Question', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('question', $question->question, ['class' => 'form-control col-lg-6', 'placeholder' => 'question'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('a', 'Answer A', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('a', $question->answer_a, ['class' => 'form-control col-lg-6', 'placeholder' => 'First Answer'])}}
                                        &nbsp;&nbsp;
                                    @if ($question->answer == $question->answer_a)
                                        {{Form::radio('answer', 'a', true)}}
                                    @else
                                        {{Form::radio('answer', 'a')}}
                                    @endif
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('b', 'Answer B', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('b', $question->answer_b, ['class' => 'form-control col-lg-6', 'placeholder' => 'Second Answer'])}}
                                        &nbsp;&nbsp;
                                    @if ($question->answer == $question->answer_b)
                                        {{Form::radio('answer', 'b', true)}}
                                    @else
                                        {{Form::radio('answer', 'b')}}
                                    @endif
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('c', 'Answer C', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('c', $question->answer_c, ['class' => 'form-control col-lg-6', 'placeholder' => 'Third Answer'])}}
                                        &nbsp;&nbsp;
                                    @if ($question->answer == $question->answer_c)
                                        {{Form::radio('answer', 'c', true)}}
                                    @else
                                        {{Form::radio('answer', 'c')}}
                                    @endif
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('d', 'Answer D', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('d', $question->answer_d, ['class' => 'form-control col-lg-6', 'placeholder' => 'Fourth Answer'])}}
                                        &nbsp;&nbsp;
                                    @if ($question->answer == $question->answer_d)
                                        {{Form::radio('answer', 'd', true)}}
                                    @else
                                        {{Form::radio('answer', 'd')}}
                                    @endif
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
