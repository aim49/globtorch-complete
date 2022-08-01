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
                                <h3 class="text-primary">View Test Questions</h3> 
                                {!! Form::open(['action' => 'ChapterQuestionController@edit', 'method'=>'POST']) !!}
                                    @if (count($chapter->questions) > 0)
                                        <table class="table table-hover">
                                            <tr>
                                                <td></td>
                                                <td>Question</td>
                                                <td>A</td>
                                                <td>B</td>
                                                <td>C</td>
                                                <td>D</td>
                                                <td>Answer</td>
                                            </tr>
                                        @foreach ($chapter->questions as $question)
                                            <tr>
                                                <td>{{Form::radio('id', $question->id)}}</td>
                                                <td>{{$question->question}}</td>
                                                <td>{{$question->answer_a}}</td>
                                                <td>{{$question->answer_b}}</td>
                                                <td>{{$question->answer_c}}</td>
                                                <td>{{$question->answer_d}}</td>
                                                <td>{{$question->answer}}</td>
                                            </tr>
                                        @endforeach
                                        </table>
                                    @else
                                        <p class="text-info">No questions to view, click the button to add</p>
                                    @endif
                                    <div class="row">
                                        <a href="/chapter_question/create/{{$chapter->id}}" class="btn btn-primary col-lg-2">Create</a>
                                        &nbsp;
                                        {{Form::submit('Edit', ['class' => 'btn btn-primary col-lg-2 center'])}}
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