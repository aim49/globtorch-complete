@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <a href="{{route('institution.index')}}"><h3 class="text-primary">All Institutions</h3></a>
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
                        <h2>All Institutions</h2>
                    </div>
                    <div class="card-body">
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($institutions as $institution)
                                    <tr>
                                        <td><img src="{{asset('storage/institution/images/' . $institution->logo)}}" class="img-fluid" style="height:50px"></td>
                                        <td>{{$institution->name}}</td>
                                        <td><textarea style="border:none">{{$institution->address}}</textarea></td>
                                        <td>{{$institution->phone}}</td>
                                        <td>{{$institution->email}}</td>
                                        <td><a href="{{route('institution.edit', $institution->id)}}" class="btn btn-primary">Edit</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('institution.create')}}" class="btn btn-primary">Create</a>
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