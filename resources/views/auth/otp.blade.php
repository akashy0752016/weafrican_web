@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="main-container row">
    <div class="col-md-8 col-md-offset-2">
        @include('notification')
        <div class="panel panel-default">
            <div class="panel-heading">Enter Otp to continue</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/otp') }}">
                    {{ csrf_field() }}

                     <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                        <label for="otp" class="col-md-4 control-label">Name</label>

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
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                Resend Otp
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
