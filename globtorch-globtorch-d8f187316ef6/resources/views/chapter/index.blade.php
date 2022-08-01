@extends('app.layout')

@section('content')
    @if (count($chapters) > 0)
        <table class="table table-hover">
            <tr>
                <td>Name</td>
                <td>Topics</td>
            </tr>
        @foreach ($chapters as $chapter)
            <tr>
                <td><a href="/chapter/{{$chapter->id}}">{{$chapter->name}}</a></td>
                <td>{{count($chapter->topics)}}</td>
            </tr>
        @endforeach
        </table>
    @else
        <p class="text-info">No chapters to view, click the button to add</p>
    @endif
    <a href="chapter/create" class="btn btn-primary">Create</a>
@endsection