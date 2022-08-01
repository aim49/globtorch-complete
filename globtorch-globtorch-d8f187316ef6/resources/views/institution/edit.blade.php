@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <a href="{{route('institution.index')}}"><h3 class="text-primary">All Institutions</h3></a>
        </div>
        <div class="col-md-5 align-self-center">
            <a href="{{route('institution.create')}}"><h3 class="text-primary">Create Institution</h3></a>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="center">
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Edit a school/institution</h2>
                    </div>
                    <div class="card-body">
                        <br />
                        {!! Form::open(['action' => ['InstitutionController@update', $institution->id], 'method'=>'PUT', 'files' => 'true']) !!}
                            <img src="{{asset('storage/institution/images/' . $institution->logo)}}" class="img-fluid" style="height:50px">
                            <div class="form-group row">
                                {{Form::label('name', 'Name', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('name', $institution->name, ['class'=>'form-control col-lg-5','required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('address', 'Address', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::textarea('address', $institution->address, ['class'=>'form-control col-lg-5', 'style' => 'height:100%'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('phone', 'Phone', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('phone', $institution->phone, ['class'=>'form-control col-lg-5'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('email', 'Email', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::email('email', $institution->email, ['class'=>'form-control col-lg-5'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('logo', 'Logo (Replace)', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::file('logo', null, ['class'=>'form-control col-lg-5'])}}
                            </div>
                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
@endsection