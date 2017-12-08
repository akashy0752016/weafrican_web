@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
        @include('notification')
        <div class="panel panel-default otp_box">
            <div class="panel-heading">Security Question</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('check-securityans') }}">
                    {{ csrf_field() }}
                    <div class="form-group"> 
                    <label for="ans" class="col-md-3 control-label">Question:</label> 
                    <div class="col-md-6">  
                        <label for="ans"> {{ $security->question }}</label>
                    </div>
                    </div>
                    <div class="form-group{{ $errors->has('ans') ? ' has-error' : '' }}">
                        <label for="ans" class="col-md-3 control-label">Answer:</label>

                        <div class="col-md-6">
                            <input id="ans" type="text" class="form-control" name="ans" value="{{ old('ans') }}" autofocus>

                            @if ($errors->has('ans'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ans') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Continue
                            </button>
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
@endsection
