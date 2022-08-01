@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 ><a class="text-primary" href="/topic/{{$topic->id}}">{{$topic->name}}</a></h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Content</li>
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
                                <h3 class="text-primary">Add Content</h3> 
                                {!! Form::open(['action' => ['CourseSubjectChapterTopicContentController@store', $course_id, $subject_id, $chapter_id, $topic->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <div class="form-group">
                                        {{Form::label('type', 'Content Type')}}
                                        {{Form::select('type', ['text' => 'Text', 'pdf' => 'PDF', 'video' => 'Video', 'audio' => 'Audio'], null, ['id' => 'selected_type'])}}
                                    </div>
                                    <div class="form-group row" id="div_text">
                                        {{Form::label('name', 'Name', ['class' => 'col-lg-2 col-form-label'])}}
                                        {{Form::text('name', '', ['class'=> 'form-control col-lg-6','placeholder' => 'Enter a name for the content identity'])}}
                                        <p class='col-lg-2 text-info' style='display:inline' data-toggle="tooltip" data-html="true" title="The title is not displayed to students, it's for you to know which content it is">Info</p>
                                        {{Form::textarea('text', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'text'])}}
                                    </div>
                                    <div class="form-group" id="div_uploads">
                                        {{Form::file('file_uploaded')}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('order', 'Order')}}
                                        @if (count($topic->contents) > 0)    
                                            {{Form::number('order', $topic->contents->sortBy('order')->last()->order + 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                        @else
                                            {{Form::number('order', 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                        @endif 
                                        <p class='text-info' style='display:inline' data-toggle="tooltip" data-html="true" title="Use this to order content. Leave as '0' to use default order">Info</p>
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
@endsection()

@section('extraJS')
    //gets the ckeditor on the form
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>

    //script to check the selected content type and change the form accordingly
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

    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>


    <!-- Form validation -->
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate-init.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>
@endsection()
