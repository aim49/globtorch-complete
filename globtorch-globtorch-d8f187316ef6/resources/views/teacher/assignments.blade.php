@extends('layout.master')
@section('content')
<div class="page-wrapper">
            <!-- Bread crumb -->

            <div class="row page-titles">
                <div class="col-md-3 align-self-center">

                    <h3 class="text-primary">My Subjects</h3>

                </div>
                <div class="col-md-3 align-self-center">
                    <h3 class="text-success">Subjects</h3>
                </div>
                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Class</li>
                        <li class="breadcrumb-item active">My Subjec</li>
                    </ol>
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
										<div class="card">
											<div class="card-title">
												<h2 class="text-primary">  </h2>
											</div>
											 <div class="row">


                                                @foreach ($subjects as $subject )

                                                <div class="col-md-3">
                                                        <div class="card p-30">
                                                            <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                    <span><img alt="..." src="{{ URL::to('images/vita/curriculum_vitae.png') }}" class="media-object"></span>
                                                                </div>

                                                                <div class="media-body media-text-right">
                                                                   <a href = "class.html"> <h2>{{ $subject->name }}</h2> </a>

                                                                </div>


                                                            </div>
                                                            <br>

                                                           <div class="btn btn-primary">Add Content</div>
                                                           <div class="btn btn-default">View Subject</div>

                                                        </div>

                                                    </div>
                                                    @endforeach



			                </div>

							</div>
							<div class="card">
								<div class="card-title">
									<h3 class="text-primary"><!-- hdjdijfdkfdklf _--> </h3>
									<h4 class= "text-success"><!-- hdjdijfdkfdklf _--> </h4>
								</div>
								<div class="card-body">
									<!-- hdjdijfdkfdklf _-->
								</div>
							</div>

							<!-- /# card -->
						</div>

                        <!-- /# column -->




            @endsection()
