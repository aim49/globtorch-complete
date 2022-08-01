@extends('app.layout')

@section('content')
    <h2>Edit content</h2>
    {!! Form::open(['action' => ['ContentController@update', $content->id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group" hidden>
            <input name='topic_id' value='{{app('request')->input('topic_id')}}'/>
        </div>
        <div class="form-group">
            {{Form::label('type', 'Content Type')}}
            {{Form::select('type', ['text' => 'Text', 'pdf' => 'PDF', 'video' => 'Video', 'audio' => 'Audio'], $content->type, array('id' => 'selected_type'))}}
        </div>
        <div class="form-group" id="div_text">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', $content->name, ['placeholder' => 'Enter a name for the content identity'])}}
            <p class='text-info' style='display:inline' data-toggle="tooltip" data-html="true" title="The title is not displayed to students, it's for you to know which content it is">Info</p>
            @if ($content->type == 'text')
                {{Form::textarea('text', $text, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'text'])}}
            @else
                {{Form::textarea('text', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'text'])}}
            @endif
        </div>
        <div class="form-group" id="div_uploads">
            @if ($content->type != 'text')
                <p>File currently uploaded: {{$content->name}}</p>
            @endif
            {{Form::file('file_uploaded')}}
        </div>
        <div>
            {{Form::label('order', 'Order')}}
            {{Form::number('order', $content->order, ['placeholder' => 'enter position number'])}}
            <p class='text-info' style='display:inline' data-toggle="tooltip" data-html="true" title="Use this to order content. Leave as '0' to use default order">Info</p>
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

@section('body_script')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>

    <script>
        $(function(){
            $('#selected_type').change(function(){
                ft_update_form();
            });

            function ft_update_form()
            {
                $('#div_text').hide();
                $('#div_uploads').hide();
                var selected_option = $('#selected_type').val();
                if (selected_option == 'text')
                {
                    $('#div_text').show();
                }
                else
                {
                    $('#div_uploads').show();
                }
            }

            ft_update_form();
        });
    </script>
@endsection