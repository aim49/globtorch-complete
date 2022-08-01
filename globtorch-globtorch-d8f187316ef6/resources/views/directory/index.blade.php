@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Directory Listing</h3>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row justify-content-center">
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
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                                @if (count($directories) > 0)
                                <table class="table table-bordered">
                                    <tr>
                                        <th>name</th>
                                        <th>level</th>
                                        <th>description</th>
                                        <th>url</th>
                                        <th>phone</th>
                                        <th>email</th>
                                        <th>logo</th>
                                        <th>verified</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    @foreach ($directories as $directory)
                                        <tr>
                                            <td>{{ $directory->name }}</td>
                                            <td>{{ $directory->level }}</td>
                                            <td>{{ $directory->description }}</td>
                                            <td><a href="https://{{$directory->url}}" target="_blank">{{ $directory->url }}</a></td>
                                            <td>{{ $directory->phone }}</td>
                                            <td><a href="mailto:{{ $directory->email }}">{{ $directory->email }}</td>
                                            <td><img src="{{ asset('/storage/directory/images/' . $directory->logo) }}"></td>
                                            @if ($directory->isVerified == 0)
                                                <td>No</td>
                                            @else
                                                <td>Yes</td>
                                            @endif
                                            <td><a href="{{ route('directory.verify', ['id' => $directory->id]) }}" class="btn btn-primary">Verify</a></td>
                                            <td>
                                                {!! Form::open(['action' => ['DirectoriesController@destroy', $directory->id], 'method'=>'DELETE']) !!}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>	
                                    @endforeach
                                </table>
                            @else
                                <p class="text-info">No listings yet. Check again soon!</p>
                            @endif
                        </div>
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