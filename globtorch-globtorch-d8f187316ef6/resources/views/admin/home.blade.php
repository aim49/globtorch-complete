@extends('layout.master')
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stat-widget-five">
                                            <div class="stat-icon dib flat-color-1">
                                                <i class="fa fa-money faa-bounce animated" style="font-size:60px;color:green;"></i>
                                            </div>
                                            <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text">$<span class="count">{{$payments}}</span></div>
                                                <div class="stat-heading">Payments</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stat-widget-five">
                                            <div class="stat-icon dib flat-color-2">
                                                <i class="fa fa-users faa-horizontal animated" style="font-size:60px;color:blue;"></i>
                                            </div>
                                            <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">{{$num_students}}</span></div>
                                                <div class="stat-heading">All Students</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stat-widget-five">
                                            <div class="stat-icon dib flat-color-3">
                                                <i class="fa fa-users faa-pulse animated" style="font-size:60px;color:red;"></i>
                                            </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">{{$num_active_students}}</span></div>
                                                <div class="stat-heading">Active Students <small>(within 3 days)</small></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stat-widget-five">
                                            <div class="stat-icon dib flat-color-4">
                                                <i class="fa fa-user faa-flash animated" style="font-size:60px;color:purple;"></i>
                                            </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">{{$num_teachers}}</span></div>
                                                <div class="stat-heading">Teachers</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="stat-widget-five">
                                            <div class="stat-icon dib flat-color-1">
                                                <i class="fa fa-money faa-bounce animated" style="font-size:60px;color:blue;"></i>
                                            </div>
                                            <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">{{$num_claimed_promotions}}</span></div>
                                                <div class="stat-heading">Claimed Promotions</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

  <!-- /Login History --> 
      <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title box-title" style="font-size:30px;color:green;">Login History</h4>
                                <div class="card-content">
                                    <div class="todo-list">
                                        <div class="tdl-holder">
                                            <div class="tdl-content">
                                                <ul>
                                                    @foreach ($login_histories as $login_history)
                                                        <li><i class="fa fa-clock-o"></i><span>{{$login_history->created_at}}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div> <!-- /.todo-list -->
                                </div>
                            </div> <!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-content">
                                    <div >
                                        <div class="col-lg-6">
                                            <div class="card-body">
                                                    <h4 class="por-title" style="font-size:30px;color:purple;">Referral Link</h4>
                                                    <input type="text" class="form-control" value="{{ route('register', ['ref' => Auth::user()->school_id]) }}"/>
                                                    <a href="http://www.facebook.com/sharer.php?caption=[Simple%20and%20Fast%20Registration]&description=[Follow%20this%20linnk%20to%20register%20to%20Globtorch%20academy]&u={{ route('register', ['ref' => Auth::user()->school_id]) }}" target="_blank">
                                                        <img src="{{ URL::to('images/facebook.png') }}" alt="Facebook" />
                                                    </a>          
                                                    <a href="https://twitter.com/share?url={{ route('register', ['ref' => Auth::user()->school_id]) }}&amp;text=Simple%20And%20Fast%20Registration&amp;hashtags=Globtorch" target="_blank">
                                                        <img src="{{ URL::to('images/twitter.png') }}" alt="Twitter" />
                                                    </a>
                                                    <a href="whatsapp://send?text=Simple and Fast Registration, follow this link {{ route('register', ['ref' => Auth::user()->school_id]) }}" target="_blank">
                                                        <img src="{{ URL::to('images/whatsapp.png') }}" alt="Whatsapp" />
                                                    </a>
                                                    <br/><br/>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div>
                <!-- /Login History -->
	
                <!-- End PAge Content -->
                    </div>
                </div>
            </div>
        </div>
         </div>
        </div>
            @endsection()
            
