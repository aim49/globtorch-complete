@extends('app.layout')

@section('content')
    <h2>View all content</h2>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Path</th>
            <th colspan="3">Actions</th>
        </tr>
        @foreach($content as $value)
            <tr>
                <td><a href="/content/{{$value->id}}">{{$value['id']}}</a></td>
                <td>{{$value['type']}}</td>
                <td>{{$value['path']}}</td>
                <td>
                    {!!Form::open(['action' => ['ContentController@edit', $value->id], 'method' => 'GET'])!!}
                    {{Form::submit('Edit', ['class' => 'btn btn-primary'])}}
                    {!!Form::close()!!}
                </td>
                <td>
                    {!!Form::open(['action' => ['ContentController@destroy', $value->id], 'method' => 'POST'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                </td>
            </tr>
        @endforeach
    </table>
    <a href="{{route('content.create')}}" class="btn btn-success">Create</a>
@endsection