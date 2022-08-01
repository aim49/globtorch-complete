@extends('layout.master')
@section('content')
<!-- End Left Sidebar  -->
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
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
                        </div><br />
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View Message Log</h4>
                        <h6 class="card-subtitle">Message Logs</h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Purpose</th>
                                        <th>Number of SMSes</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($messageLogs as $messageLog)
                                    <tr>
                                        <td>{{ $messageLog->purpose }} </td>
                                        <td>{{ $messageLog->number }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection