@extends('layout.master') 
@section('content')
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-3 align-self-center">
            <h3>
                @if (Auth::user()->user_type == "teacher")
                    <a href="/teacher_subjects">My Subjects/</a>
                @else
                   
                @endif
                <a href="/subject/{{$subject->id}}">{{$subject->name}}/</a>
            </h3>
        </div>
        <div class="col-md-3 align-self-center">
            <h3 class="text-success">Chapters</h3>
        </div>
    </div>
    <!-- End Bread crumb -->

    <!-- Container fluid  -->
    <div class="container-fluid">
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
        <!--chapters AREA-->
        <section class="faqs-area relative section-padding">
            <div class="area-bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                        <div class="faqs-accordion-content">
                            <h2 class="mb30 white">Chapters</h2>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @if (count($subject->chapters) > 0) @foreach ($subject->chapters->sortBy('order') as $chapter)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="{{$chapter->id}}s">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$chapter->id}}" aria-expanded="true" aria-controls="{{$chapter->id}}">
                                            {{$chapter->order . ". " . $chapter->name}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{$chapter->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$chapter->id}}s">
                                        <div class="panel-body">
                                            <p>
                                                @if (count($chapter->topics) > 0)
                                                    @foreach ($chapter->topics as $topic)
                                                        <div class="card p-30">
                                                            <div class="media">
                                                                <div class="media-body media-text-left">
                                                                    <a href="/topic/{{$topic->id}}">
                                                                        <h2>{{ $topic->name }}</h2>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <br> 
                                                            <a href="/topic/{{$topic->id}}" class="btn btn-success video-button mt30 inline-block">View Content</a>
                                                            @if(auth()->user()->user_type!='student')
                                                                <a href="/content/create/{{$topic->id}}" class="btn btn-primary video-button mt30 inline-block">Add Content</a>                                                    
                                                            @endif
                                                            @if (auth()->user()->user_type == 'admin')
                                                                {!!Form::open(['action' => ['TopicController@destroy', $topic->id], 'method' => 'DELETE', 'style' =>'display:inline'])!!}
                                                                    {{Form::submit('Delete Topic', ['class' => 'btn btn-primary video-button mt30 inline-block btn-block'])}}
                                                                {!!Form::close()!!}
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="text-info">Coming soon ...</p>
                                                @endif
                                                @if(auth()->user()->user_type !='student')
                                                    <a href="/chapter/{{$chapter->id}}/edit" class="btn btn-primary video-button mt30 inline-block">Edit</a>
                                                    <a href="/topic/create/{{$chapter->id}}" class="btn btn-primary video-button mt30 inline-block">Add Topic</a>
                                                    <a href="/chapter_question/create/{{$chapter->id}}" class="btn btn-success video-button mt30 inline-block">Add Questions</a>
                                                @endif
                                                @if (auth()->user()->user_type == 'admin')
                                                    {!!Form::open(['action' => ['ChapterController@destroy', $chapter->id], 'method' => 'DELETE', 'style' =>'display:inline'])!!}
                                                        {{Form::submit('Delete Chapter', ['class' => 'btn btn-primary video-button mt30 inline-block'])}}
                                                    {!!Form::close()!!}
                                                @endif
                                                @if (count($chapter->questions) > 0)
                                                    @if (auth()->user()->user_type == 'student')
                                                        <a href="/chapter_answer/create/{{$chapter->id}}" class="btn btn-primary video-button mt30 inline-block">Test</a>
                                                    @else
                                                        <a href="/chapter_question/{{$chapter->id}}" class="btn btn-primary video-button mt30 inline-block">Test</a>
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-info">Coming soon....</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--chapters AREA END-->
        @if(auth()->user()->user_type !='student')
            <div class="card">
                <div class="card-body" style="text-align:center">                
                    <a href="/chapter/create/{{$subject->id}}" class="btn btn-primary video-button mt30 inline-block">Add Chapter</a>               
                </div>
            </div>
        @endif
    </div>
@endsection