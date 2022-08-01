@extends('layout.master') 
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Feedback</h3>
        </div>
    </div>
    <div class="container-fluid">
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
                            </div><br/>
                        </div>
                    </div> 
                @endif
                <div class="card">
                    <div class="card-body">
                        @if (count($users) > 0)
                            <table class="table table-bordered">
                                <tr>
                                    <th>Surname</th>
                                    <th>Name</th>
                                    <th>Feedback</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->surname }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->feedback }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-info">You have not received any feedback yet!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection