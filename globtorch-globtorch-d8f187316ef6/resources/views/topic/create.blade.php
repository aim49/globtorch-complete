@extends('layout.master')
@section('content')
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{$chapter->name}}</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Topic</li>
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
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-validation">
                                <h3 class="text-primary">Add Topic</h3> 
                                {!! Form::open(['action' => 'TopicController@store', 'method'=>'POST']) !!}
                                    <div class="form-group row" hidden>
                                        <input name='chapter_id' value='{{$chapter->id}}'/>
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                        {{Form::text('name', '', ['class' => 'form-control col-lg-6', 'placeholder' => 'topic name'])}}
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('order', 'Order', ['class'=>'col-lg-4 col-form-label'])}}
                                        @if (count($chapter->topics) > 0)    
                                            {{Form::number('order', $chapter->topics->sortBy('order')->last()->order + 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                        @else
                                            {{Form::number('order', 1, ['class' => 'form-control col-lg-5', 'placeholder' => 'enter position number', 'min' => 1])}}
                                        @endif 
                                        <p class='text-info col-lg-1' style='display:inline' data-toggle="tooltip" data-html="true" title="Use this to order content. Leave as '0' to use default order">Info</p>
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
