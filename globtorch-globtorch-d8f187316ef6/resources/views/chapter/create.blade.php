@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$subject->name}}</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Chapter</li>
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
                                <h3 class="text-primary">Add Chapter</h3> 
                                {!! Form::open(['action' => 'ChapterController@store', 'method'=>'POST']) !!}
                                    <div class="form-group" hidden>
                                        <input name='subject_id' value='{{$subject->id}}'/>
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('name', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'chapter name'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('order', 'Order', ['class'=>'col-lg-4 col-form-label'])}}
                                    @if (count($subject->chapters) > 0)    
                                        {{Form::number('order', $subject->chapters->sortBy('order')->last()->order + 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                    @else
                                        {{Form::number('order', 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                    @endif                                    
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