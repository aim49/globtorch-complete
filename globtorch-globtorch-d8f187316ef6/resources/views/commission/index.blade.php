@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Commissions</h3>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-striped table-responsive">
                            <tr>
                                <th>Surname</th>
                                <th>Name</th>
                                <th>Phone No.</th>
                                <th>E-mail</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Payment Date</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{$commission->user->surname}}</td>
                                    <td>{{$commission->user->name}}</td>
                                    <td>{{$commission->user->phone}}</td>
                                    <td>{{$commission->user->email}}</td>
                                    <td>{{ date('F', mktime(0, 0, 0, $commission->month, 10))}}</td>
                                    <td>{{$commission->amount}}</td>
                                    @if ($commission->isPaid == 1)
                                        <td class="text-success">Yes</td>
                                    @else
                                        <td class="text-danger">No</td>
                                    @endif
                                    <td>
                                        @if ($commission->pay_date != null)
                                            {{$commission->pay_date}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/commission/{{$commission->id}}" class="btn btn-success">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
