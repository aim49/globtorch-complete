@extends('app.layout')

@section('content')
    <h2>Edit Topic</h2>
    {!! Form::open(['action' => ['TopicController@update', $topic->id], 'method'=>'POST']) !!}
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $topic->name, ['class' => 'form-control', 'placeholder' => 'topic name'])}}
        </div>
        <div class="form-group">
            {{Form::label('order', 'Order')}}
            {{Form::number('order', $topic->order)}}
            <p class='text-info' style='display:inline' data-toggle="tooltip" data-html="true" title="Use this to order content. Leave as '0' to use default order">Info</p>
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {{Form::hidden('_method', 'PUT')}}
    {!! Form::close() !!}
@endsection