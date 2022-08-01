@extends('layout.master') 
@section('extraCSS')
<style>
    .message-owner{
        text-align: right;
        background-color:aqua;
    }

    .message-other{
        text-align: left;
        background-color: azure;
    }
</style>
@endsection
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Chat</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header mb-2">
                        <h3>{{substr($currentUser->name, 0, 1) . '. ' . $currentUser->surname}}</h3>
                    </div>
                    <div class="card-body">
                        <div style="height:300px;overflow-y:auto" id="message">
                            @foreach ($chatRoom->messages->sortBy('created_at') as $message)
                                @if ($message->user_id == Auth::id())
                                    <div class="message-owner mb-2">{{$message->message}}<br/><small>{{$message->created_at}}</small></div>
                                @else
                                    <div class="message-other mb-2">{{$message->message}}<br /><small>{{$message->created_at}}</small></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! Form::open(['action' => 'ChatRoomController@store', 'method'=>'POST']) !!}
                            <div class="form-group" hidden>
                                <input name='chat_room_id' value='{{$chatRoom->id}}' readonly/>
                                <input name='current_user_id' value='{{$currentUser->id}}' readonly/>
                            </div>
                            <div class="form-group row">
                                {{Form::textarea('message', null, ['class' => 'col-sm-10', 'rows' => '4'])}}
                                {{Form::submit('Send', ['class' => 'btn btn-primary col-sm-2'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if (count($chatRooms) > 0)
                    <div class="card">
                        <div class="card-title">
                            <h3>Open Chats</h3>
                        </div>
                        <div class="card-body text-nowrap">
                            @foreach ($chatRooms as $chatRoom)                        
                                <a href="{{route('chat_room.show', $chatRoom->id)}}" class="btn btn-block text-left">
                                    <span>{{$chatRoom->name}}</span>
                                    @if (($numMessages = count($chatRoom->messages->where('is_read', 0)->where('user_id', '<>', Auth::id()))) > 0)
                                        <span class="text-danger">- {{$numMessages}} unread messages</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (count($users) > 0)
                    <div class="card">
                        <div class="card-title">
                            <h3 class="text-center">Contacts</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $current_user = 0;
                            @endphp
                            @foreach ($users as $user)
                                @if ($current_user != $user->id)
                                    <a href="{{route('chat_room.create', $current_user = $user->id)}}" class="btn btn-block">
                                        <span class="text-left">{{substr($user->name, 0, 1) . '. ' . $user->surname}}</span><br />
                                        @foreach ($users->where('id', $current_user) as $user_subject)
                                            <small>{{$user_subject->subject}}</small><br />
                                        @endforeach
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('extraJS')
<script>
$(document).ready(function(){
    var elem = document.getElementById('message');
    elem.scrollTop = elem.scrollHeight;
});
</script>
@endsection