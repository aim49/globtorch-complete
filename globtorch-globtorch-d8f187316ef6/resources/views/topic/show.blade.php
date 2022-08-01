@extends('layout.master')
@section('content')
    <style>
        p{
            color:black;
        }
    </style>
    
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-3 align-self-center">
                <!--Navigation links to go back-->
                <h3>
                    <a href="/subject/{{$topic->chapter->subject_id}}">{{$topic->chapter->subject->name}}/</a>
                    <a href="#">{{$topic->chapter->name}}/</a>
                    <a href="/topic/{{$topic->id}}" class="text-primary">{{$topic->name}}</a>
                </h3>
            </div>
            <div class="col-md-3 align-self-center">
                <h3 class="text-success">Content</h3>
            </div>
        </div>
        <!-- End Bread crumb -->
            
        <!-- Container fluid  -->
		<div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
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
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-9">
                            @if (count($texts) > 0)
                                @foreach ($texts as $text)
                                    @if ($loop->index == 0)
                                        <div id='{{$loop->index}}text' class="card">
                                    @else
                                        <div id='{{$loop->index}}text' class="card" style='display:none'>
                                    @endif
                                    <div class="card-title">
                                        <h3 class="text-primary center">Slide {{$loop->index + 1 . ' out of ' . count($texts)}}</h3>
                                    </div>
                                    <div class="card-body">
                                        {!!$text[1]!!}
                                        <table class="table table-hover">
                                            <tr>
                                                <td>
                                                    @if ($loop->first)
                                                        <button onclick='' class='btn btn-secondary' disabled>Previous</button>
                                                    @else
                                                        <button onclick='ft_previous({{($loop->index)-1}})' class='btn btn-dark'>Previous</button>
                                                    @endif
                                                </td>
                                            @if(auth()->user()->user_type=='admin')    
                                                <td>
                                                    <a href="/content/{{$text[0]}}/edit" class="btn btn-primary">Edit</a>
                                                </td>
                                                <td>
                                                    {!!Form::open(['action' => ['ContentController@destroy', $text[0]], 'method' => 'POST', 'style' =>'display:inline'])!!}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                    {!!Form::close()!!}    
                                                </td>
                                            @endif
                                                <td>
                                                        @if ($loop->last)
                                                            <button onclick='' class='btn btn-secondary' disabled>Next</button>
                                                        @else
                                                            <button onclick='ft_next({{($loop->index)+1}})' class='btn btn-success'>Next</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="card">
                                <div class="card-title">
                                    <h3 class="text-primary">Notes</h3>
                                </div>
                                <div class="card-body">    
                                    @if ((count($topic->contents) - count($texts)) > 0)
                                        <table>
                                            @foreach ($topic->contents->sortby('order') as $content)
                                                <tr>
                                                    <td>
                                                        @if ($content->type == 'text')
                                                            @continue
                                                        @elseif($content->type == 'pdf')
                                                            <a href="/content/{{$content->id}}" class="btn btn-primary" target="_blank">Click and Read: {{$content->name}}</a>
                                                        @elseif($content->type == 'video')
                                                            <a href="/content/{{$content->id}}" target="_blank">Click and Watch: {{$content->name}}</a>
                                                        @elseif($content->type == 'audio')
                                                            <a href="/content/{{$content->id}}" target="_blank">Click and Listen: {{$content->name}}</a>
                                                        @else
                                                            <p>Unrecognized content, please contact the administrator!</p>
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    @if(auth()->user()->user_type =='admin' )   
                                                        <td>
                                                            {!!Form::open(['action' => ['ContentController@edit', $content->id], 'method' => 'GET', 'style' =>'display:inline'])!!}
                                                                {{Form::submit('Edit', ['class' => 'btn btn-primary'])}}
                                                            {!!Form::close()!!}
                                                        </td>
                                                        <td>
                                                            {!!Form::open(['action' => ['ContentController@destroy', $content->id], 'method' => 'POST', 'style' =>'display:inline'])!!}
                                                                {{Form::hidden('_method', 'DELETE')}}
                                                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                            {!!Form::close()!!} 
                                                        </td>
                                                    @endif
                                                </tr>         
                                            @endforeach
                                        </table>
                                    @else
                                        <p class="text-info">No additional resources yet, please check again with us later</p>
                                    @endif    
                                </div>
                            </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('extraJS')
    <script>
        function ft_previous(id)
        {
            document.getElementById(id+'text').style.display = "block";
            document.getElementById((id + 1)+'text').style.display = "none";
        }

        function ft_next(id)
        {
            document.getElementById(id+'text').style.display = "block";
            document.getElementById((id - 1)+'text').style.display = "none";
        }

        function ft_delete(id)
        {

        }
    </script>
@endsection