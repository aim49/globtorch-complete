@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$chapter->name}}</h3> 
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
                                <h3 class="text-primary">Add Questions</h3> 
                                <p class="text-info">Select the option next to the answer that is correct to mark it as the right answer</p>
                                {!! Form::open(['action' => 'ChapterQuestionController@store', 'method'=>'POST']) !!}
                                    {{Form::hidden('id', $chapter->id)}}
                                    <div class="form-group row">
                                        {{Form::label('question', 'Question', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('question', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'question'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('a', 'Answer A', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('a', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'First Answer'])}}
                                        &nbsp;&nbsp;
                                        {{Form::radio('answer', 'a')}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('b', 'Answer B', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('b', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Second Answer'])}}
                                        &nbsp;&nbsp;
                                        {{Form::radio('answer', 'b')}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('c', 'Answer C', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('c', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Third Answer'])}}
                                        &nbsp;&nbsp;
                                        {{Form::radio('answer', 'c')}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('d', 'Answer D', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('d', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'Fourth Answer'])}}
                                        &nbsp;&nbsp;
                                        {{Form::radio('answer', 'd')}}
                                    </div>
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection