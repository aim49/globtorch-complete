@extends('app.layout')

@section('content')
    <h2>View all topics belonging to a subject</h2>
    <table class="table table-hover">
        @if (count($topic) > 0)
            <tr>
                <th>Name</th>
                <th colspan="2">Actions</th>
            </tr>
        @else
            <p>There are no topics, click the button below to add a topic</p>
        @endif
        @foreach($topic as $value)
            <tr>
                <td><a href="/topic/{{$value->id}}">{{$value['name']}}</a></td>
                <td>
                    {!!Form::open(['action' => ['TopicController@edit', $value->id], 'method' => 'GET', 'style' =>'display:inline'])!!}
                        {{Form::submit('Edit', ['class' => 'btn btn-primary'])}}
                    {!!Form::close()!!}
                <td>
                    {!!Form::open(['action' => ['TopicController@destroy', $value->id], 'method' => 'POST', 'style' =>'display:inline'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                </td>
            </tr>
        @endforeach
    </table>
    <a href="/topic/create" class="btn btn-success">Create</a>
@endsection