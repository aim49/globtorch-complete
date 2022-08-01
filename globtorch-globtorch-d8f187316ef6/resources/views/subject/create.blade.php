@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Create {{$course->name}} Subjects</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Subject</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Page Content  -->
    <div class="container-fluid">
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
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @foreach ($course->subjects->sortBy('order') as $subject)
                    <div class="card">
                        <div class="card-title">
                            <h3>{{$subject->order . ". " . $subject->name}}</h3>
                            <a href="/subject/{{$subject->id}}/edit" class="btn btn-primary">edit</a>
                        </div>
                        <div class="card-body">
                            <table id="subject{{$subject->id}}">
                                @foreach ($subject->chapters as $chapter)
                                    <tr>
                                        <td>{{$chapter->id}}</td>
                                        <td>{{$chapter->name}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            {!! Form::open(['action' => 'SubjectController@store', 'method'=>'POST']) !!}
                                <div class="form-group row" hidden>
                                    <input name='course_id' value='{{$course->id}}' />
                                </div>
                                <div class="form-group row">
                                    {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}} 
                                    {{Form::text('name', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'subject name'])}}
                                </div>
                                <div class="form-group row">
                                    {{Form::label('order', 'Order', ['class'=>'col-lg-4 col-form-label'])}} 
                                    @if (count($course->subjects) > 0)
                                        {{Form::text('order', ($course->subjects->sortByDesc('order')->first()->order) + 1, ['class' => 'form-control col-lg-6', 'placeholder' => 'order'])}}
                                    @else
                                        {{Form::text('order', '1', ['class' => 'form-control col-lg-6', 'placeholder' => 'order'])}}
                                    @endif
                                </div>
                                <div class="form-group row">
                                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
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
