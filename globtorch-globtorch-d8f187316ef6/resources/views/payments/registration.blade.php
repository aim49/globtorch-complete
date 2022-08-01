@extends('layout.auth.app')
@section('head_scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('content')
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
            <div class="col-lg-12">
                <h2>Registration Fee RTGS 
                    @if($course->level == 'Primary')
                        RTGS {{5*100}} / Year
                    @elseif($course->level == 'Secondary')
                        RTGS {{10*100}} / Year
                    @elseif($course->level == 'Tertiary')
                        RTGS {{15*100}} / 6 Months
                    @endif
                </h2>
                <div class="card">
                    <div class="card-title">
                        <h3>Choose a payment method</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button id="ecocash_button" class="btn btn-light" style="height: 100%; width: 100%" onclick="pay_method('ecocash')"><span class="text-primary">Eco</span><span class="text-danger">Cash</span></button>
                            <img id="ecocash_image" class="img-fluid" src="{{asset('images/text/ecocash_text.png')}}" onclick="pay_method('ecocash')">
                        </div>
                        <div class="col-sm-6">
                            <button id="paynow_button" class="btn btn-light" style="height: 100%; width: 100%" onclick="pay_method('paynow')"><span class="text-primary">paynow</span></button>
                            <img id="paynow_image" class="img-fluid" src="{{asset('images/text/paynow_text.png')}}" onclick="pay_method('paynow')">
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-left">* Pay with <span id="ecocash">Ecocash</span><span id="paynow">Paynow</span></p>
                        {!! Form::open(['action' => ['PaymentController@registrationFee', $course->id], 'method'=>'POST']) !!}
                            <div class="form-group row" id="phone">
                                {{Form::label('phone', 'Ecocash Cell Number: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control col-lg-5'])}}
                            </div>
                            {{Form::hidden('payment_type', 'ecocash', ['id' => 'payment_type'])}}
                            {{Form::submit('Proceed', ['class' => 'btn btn-block', 'style' => 'background-color: green; color:white; font-size:20px'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('body_scripts')
    <script>
        $(document).ready(function(){
            $('#ecocash').show();
            $('#paynow').hide();
            $('#phone').show();

            $('#ecocash_image').show();
            $('#ecocash_button').hide();
            $('#paynow_image').hide();
            $('#paynow_button').show();
        });

        function pay_method(method)
        {
            if (method == 'ecocash')
            {
                $('#ecocash').show();
                $('#paynow').hide();
                $('#phone').show();
                $('#payment_type').val('ecocash');

                $('#ecocash_image').show();
                $('#ecocash_button').hide();
                $('#paynow_image').hide();
                $('#paynow_button').show();
            }
            else
            {
                $('#ecocash').hide();
                $('#paynow').show();
                $('#phone').hide();
                $('#payment_type').val('paynow');

                $('#ecocash_image').hide();
                $('#ecocash_button').show();
                $('#paynow_image').show();
                $('#paynow_button').hide();
            }

        }
    </script>

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