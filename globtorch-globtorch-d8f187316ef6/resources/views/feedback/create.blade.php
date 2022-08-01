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
                        @if ($user->feedback == null)
                            <p>Please leave us your feedback. We will use it to improve our system. Thank you!</p>
                        @else
                            <p>Please update your feedback if your experience changed. We will use it to improve our system. Thank you!</p>
                        @endif
                        {!!Form::open(['action' => 'FeedbacksController@store', 'method' => 'POST'])!!}
                            {{Form::textarea('feedback', $user->feedback, ['placeholder' => 'Feedback', 'required'])}}<br />
                            @if ($user->feedback == null)
                                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                            @else
                                {{Form::submit('Update', ['class' => 'btn btn-primary'])}}
                            @endif
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection