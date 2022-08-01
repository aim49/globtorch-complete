@extends('layout.master') 
@section('content')
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Your Courses</h3>
        </div>
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Purchase Course</h3>
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
                        <h2>Accept payment for a course</h2>
                    </div>
                    <div class="card-body">
                        <br />
                        {!! Form::open(['action' => 'PaymentController@accept_manual_payment', 'method'=>'POST']) !!}
                            <div class="form-group row">
                                {{Form::label('user_id', 'User ID', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('user_id', null, ['id'=>'user_id', 'class'=>'form-control col-lg-5', 'onChange'=>'get_user()','required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('course_code', 'Course Code', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('course_code', null, ['id'=>'course_code', 'class'=>'form-control col-lg-5', 'onChange'=>'get_course()', 'required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('payment_date', 'Payment Date: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::date('payment_date', \Carbon\Carbon::now(), ['class' => 'form-control col-lg-5', 'required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('start_date', 'Start Date: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::date('start_date', \Carbon\Carbon::now(), ['class' => 'form-control col-lg-5', 'required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('method', 'Payment Method', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::select('method', ['Free' => 'Free', 'Cash'=>'Cash', 'Ecocash'=>'Ecocash', 'Bank Transfer'=>'Bank Transfer'], null, ['class'=>'col-lg-5 form-control', 'placeholder'=>'Select...', 'required'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('price', 'Price: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::number('price', null, ['id' => 'price', 'class' => 'form-control col-lg-5', 'step'=>'0.01', 'readonly'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('period', 'Number of months: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::number('period', 1, ['id'=>'period', 'class' => 'form-control col-lg-5', 'min'=>'1','onChange'=>'set_price()'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('total_price', 'Total Amount: ', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::number('total_price', null, ['id' => 'total_price', 'class' => 'form-control col-lg-5', 'step'=>'0.01', 'readonly'])}}
                            </div>
                            <div class="form-group row">
                                {{Form::label('ref', 'Reference (if any)', ['class'=>'col-lg-4 col-form-label'])}}
                                {{Form::text('ref', null, ['class'=>'form-control col-lg-5'])}}
                            </div>
                            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraJS')
    <script>
        function get_user()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/user/search') }}",
                method: 'get',
                data: {
                    user_id: jQuery('#user_id').val()
                },
                success: function(result){
                    if (result != '')
                        alert('User: ' + result['name'] + ' ' + result['surname']);
                    else
                        alert('user not found!');
                }
            });
        }

        function get_course()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/course/search') }}",
                method: 'get',
                data: {
                    course_code: jQuery('#course_code').val()
                },
                success: function(result){
                    if (result != '')
                    {
                        alert('course: ' + result['name'] + ', price: $' + result['price']);
                        $('#price').val(result['price']);
                    }
                    else
                    {
                        alert('course not found!');
                        $('#price').val(0);
                    }
                    
                    set_price();
                }
            });
        }

        function set_price()
        {
            price = $('#price').val();
            period = $('#period').val();
            $('#total_price').val(price * period); 
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