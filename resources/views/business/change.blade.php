@extends('layouts.app')
@section('title', 'We African - login')
@section('content')
<div class="main-container row">
    <div class="col-md-8 col-md-offset-2">
        @include('notification')
        <div class="panel panel-default">
            <div class="panel-heading">Enter New Mobile Number</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('update-mobile') }}">
                    {{ csrf_field() }}

                     <div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
                        <label for="mobile_number" class="col-md-4 control-label">New Mobile Number</label>
                        <div class="col-md-6">
                            <input id="mobile_number" type="text" class="form-control" maxlength="10" minlength="10" pattern="[0-9]{10}" name="mobile_number" value="{{ old('mobile_number') }}" autofocus required="">
                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="mobile_number" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" value="" autofocus required="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
