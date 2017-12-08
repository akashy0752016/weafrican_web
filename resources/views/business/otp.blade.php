@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
        @include('notification')
        <div class="panel panel-default otp_box">
            <div class="panel-heading">Enter Otp to continue</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('check-otp') }}">
                    {{ csrf_field() }}

                     <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                        <label for="otp" class="col-md-2 col-sm-4 col-xs-3 control-label otp_label">Otp</label>

                        <div class="col-md-10 col-sm-6 col-xs-7">
                            <input id="otp" type="text" class="form-control" name="otp" value="{{ old('otp') }}" autofocus>

                            @if ($errors->has('otp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('otp') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Continue
                            </button>

                            <a class="btn btn-link" href="{{ url('resend-otp') }}">
                                Resend Otp
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <label>
                                <!-- <a class="btn btn-link" href="{{ url('change-mobile/') }}">Change Mobile Number</a> -->
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- after registration pop up -->
<div class="modal fade" id="registerMessage" role="dialog">
    <div class="modal-dialog modal-sm premium-popup">
        <div class="modal-content">
            <div class="modal-header">Message:</div>
            <div class="modal-body">
              <p>Your submission is currently receiving attention. </p>
               <p> You can confirm your “Business Status” in your “Business Dashboard” after 24 hours.
               If your business is still “not live” after 24 hours.</p><p> please contact support with your business ID @ <a href="mailto:support@weafricans.com">support@weafricans.com</a> or the click <a href="#">HELP</a> button at the home page and chat with our customer executive.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn_colr" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
        $value = '{{Session::has("registerMessage")}}';
        if ($value) {
            $('#registerMessage').modal('show');
            $i= $i+1;
            $value = '{{Session::forget("registerMessage")}}';
        }
</script>
@endsection

