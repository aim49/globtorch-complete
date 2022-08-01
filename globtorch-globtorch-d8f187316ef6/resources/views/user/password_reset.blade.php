@extends('layout.auth.app')
@section('content')
    <form method="POST" action="{{ route('request_reset') }}" class="login100-form validate-form">
        {{ csrf_field() }}
        @if ($errors->any())
            <div class="alert alert-danger" style="color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div style="color:green">
                {{ session()->get('message') }}
            </div><br/>
        @endif	
        <div class="wrap-input100 validate-input" data-validate = "User ID is required">
            <input class="input100" type="text" name="user_id" placeholder="User ID">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-user" aria-hidden="true"></i>
            </span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Reset option is required">
            <p>Select Password Reset Option:</p>
            <input class="" type="radio" name="option" value="email">Email<br />
            <input class="" type="radio" name="option" value="phone">Phone
        </div>
        
        <div class="container-login100-form-btn">
            <button class="login100-form-btn btn-primary">
                    Submit Reset Request
            </button>
        </div>

        <div class="text-center p-t-12">
            <a class="txt2" href="/signin">
                Login
            </a>
        </div>
        <div class="text-center p-t-136">
            <a class="txt2" href="/register">
                Create your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection