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
                    <div class="card-header">
                        <h2>Referrer Details:</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm">
                            <tr>
                                <th>Surname:</th>
                                <td>{{$referrer->surname}} </td>
                                <th>Name:</th>
                                <td>{{$referrer->name}} </td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>{{$referrer->gender}} </td>
                                <th>D.O.B:</th>
                                <td>{{$referrer->dob}} </td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>{{$referrer->phone}} </td>
                                <th>Email:</th>
                                <td>{{$referrer->email}} </td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{$referrer->address}}</td>
                                <th>City:</th>
                                <td>{{$referrer->city}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$referrer->country}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Referred Student Payments:</h2>
                    </div>
                    <div class="card-body">
                        <p>Payments made in the month of {{ date('F', mktime(0, 0, 0, $commission->month, 10))}}</p>
                        <p>Total commission for this month is: <b>{{$commission->amount}}</b></p>
                        @php
                            $total = 0;   
                        @endphp
                        <table class="table table-hover table-striped table-responsive">
                            <tr>
                                <th>Surname</th>
                                <th>Name</th>
                                <th>User ID</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                            </tr>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{$payment->surname}}</td>
                                    <td>{{$payment->name}}</td>
                                    <td>{{$payment->school_id}}</td>
                                    <td>{{$payment->date}}</td>
                                    <td>{{$payment->method}}</td>
                                    <td>{{$payment->amount}}</td>
                                    @php
                                        $total = $total + $payment->amount;
                                    @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>{{number_format((float)($total), 2, '.', '')}}</b></td>
                            </tr>
                        </table>
                        <br />
                        <p class="text-info">Commission: {{number_format((float)($total), 2, '.', '')}} X 20% = {{number_format((float)($total * 0.2), 2, '.', '')}}</p>
                        @if ($commission->amount != (number_format((float)($total * 0.2), 2, '.', '')))
                            <p class="text-warning">The commission calculated does not match the one in the database. Contact IT support!</p>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Payment</h2>
                    </div>
                    <div class="card-body">
                        <br />
                        {!! Form::open(['action' => ['CommissionController@update', $commission->id], 'method'=>'POST']) !!}
                            <div class="form-group row">
                                {{Form::label('isPaid', 'Is Paid', ['class'=>'col-lg-4 col-form-label'])}}
                                @if ($commission->isPaid == 1)
                                    {{Form::checkbox('isPaid', 1, true)}}
                                @else
                                    {{Form::checkbox('isPaid', 1, false)}}
                                @endif
                            </div>
                            <div class="form-group row">
                                {{Form::label('pay_date', 'Payment Date', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::date('pay_date', $commission->pay_date, ['class' => 'form-control col-lg-5'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('reference', 'Reference', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('reference', $commission->reference, ['class' => 'form-control col-lg-5'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('pay_method', 'Payment Method', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('pay_method', $commission->pay_method, ['class' => 'form-control col-lg-5'])}}
                            </div>
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
