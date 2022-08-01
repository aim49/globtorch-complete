@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Notifications</h3>
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
                            @if (count($notifications) > 0)
                                <a href="/notification/all_read" class="btn btn-primary">Mark All As Read</a>
                                <br /><br />
                                @foreach ($notifications as $notification)
                                    @if($notification->isRead)
                                        <!-- Read Messages -->
                                        <a href="/notification/{{$notification->id}}">
                                            <div class="mail-contnet">
                                                <h5>{{$notification->title}}</h5> 
                                                <span class="mail-desc">{{$notification->body}}</span><br /> 
                                                <span class="time">{{$notification->created_at}}</span>
                                            </div>
                                        </a>    
                                    @else
                                        <!-- Message -->
                                        <a href="/notification/{{$notification->id}}">
                                            <div class="mail-contnet">
                                                <h5><b>{{$notification->title}}</b></h5> 
                                                <span class="mail-desc">{{$notification->body}}</span><br />
                                                <span class="time">{{$notification->created_at}}</span>
                                            </div>
                                        </a>
                                    @endif
                                    <hr />
                                @endforeach
                            @else
                                <p class="text-info">There are currently no notifications</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection