@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="main-container row">
    <div class="col-md-8 col-md-offset-2">
        @include('notification')
        <div class="panel panel-default">
            <div class="panel-heading">Verify Mobile VIA OTP</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('check-mobile-otp') }}">
                    {{ csrf_field() }}

                     <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                        <label for="otp" class="col-md-4 control-label">Otp</label>

                        <div class="col-md-6">
                            <input id="otp" type="text" class="form-control" name="otp" value="{{ old('otp') }}" autofocus>

                            @if ($errors->has('otp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('otp') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Continue
                            </button>

                            <a class="btn btn-link" href="{{ url('resend-mobile-otp') }}">
                                Resend Otp
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <label>
                                <a class="btn btn-link" href="{{ url('change-mobile/') }}">Change Mobile Number</a>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
