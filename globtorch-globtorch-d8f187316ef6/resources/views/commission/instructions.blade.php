@extends('layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>Commissions</h4>
                            <p>Our commissions model enables every user registered on our system to earn some money.
                                To get started simply share the referral link and get your friends to join the platform.
                                <br /><br />
                                For every purchase that is made in the first 3 months after registration, you will get 20% of the product sold as your commission.
                                This commission is paid out to you at the end of each month. It could be also processed immediately depending on the number of transactions that need to be processed.
                            </p>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="por-title">Referral Link</h4>
                                    <input type="text" class="form-control"
                                        value="{{ route('register', ['ref' => Auth::user()->school_id]) }}" />
                                    <a href="http://www.facebook.com/sharer.php?caption=[Simple%20and%20Fast%20Registration]&description=[Follow%20this%20linnk%20to%20register%20to%20Globtorch%20academy]&u={{ route('register', ['ref' => Auth::user()->school_id]) }}"
                                        target="_blank">
                                        <img src="{{ URL::to('images/facebook.png') }}" alt="Facebook" />
                                    </a>
                                    <a href="https://twitter.com/share?url={{ route('register', ['ref' => Auth::user()->school_id]) }}&amp;text=Simple%20And%20Fast%20Registration&amp;hashtags=Globtorch"
                                        target="_blank">
                                        <img src="{{ URL::to('images/twitter.png') }}" alt="Twitter" />
                                    </a>
                                    <a href="whatsapp://send?text=Simple and Fast Registration, follow this link {{ route('register', ['ref' => Auth::user()->school_id]) }}"
                                        target="_blank">
                                        <img src="{{ URL::to('images/whatsapp.png') }}" alt="Whatsapp" />
                                    </a>
                                    <br />
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </div>
@endsection