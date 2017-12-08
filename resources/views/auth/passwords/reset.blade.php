@extends('layouts.app')

@section('content')
<div class="main-container row">
    <div class="col-md-8 col-md-offset-2">
        @include('notification')
        <div class="panel panel-default">
            <div class="panel-heading">Reset Password</div>

            <div class="panel-body">
                <form id="form" class="form-horizontal login-form" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ base64_decode(Request::get('id')) }}" readonly="readonly" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">
                            <button type="button" id="eye" class="text-right" title="Show Password">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>

    <script type="text/javascript">

    function show() {
        var p = document.getElementById('password');
        p.setAttribute('type', 'text');
        $('#eye').html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
        $('#eye').attr('title', 'Hide Password');

    }

    function hide() {
        var p = document.getElementById('password');
        p.setAttribute('type', 'password');
        $('#eye').html('<i class="fa fa-eye" aria-hidden="true"></i>');
        $('#eye').attr('title', 'Show Password');

    }

    var pwShown = 0;

    document.getElementById("eye").addEventListener("click", function () {
        if (pwShown == 0) {
            pwShown = 1;
            show();
        } else {
            pwShown = 0;
            hide();
        }
    }, false);

        $(document).ready(function() {
            
            $('#form').bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        validators: {
                            emailAddress: {
                                message: 'Please supply a valid email address'
                            },
                            notEmpty: {
                                message: 'Please supply email.'
                            }
                        }
                    },
                    password: {
                        validators: {
                            stringLength: {
                                min: 6,
                                max: 16,
                                message: 'The  password length must be between 6-16 charcters long'
                            },
                            notEmpty: {
                                message: 'Please supply password.'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            identical: {
                                field: 'password',
                                message: 'The password and its confirm are not the same'
                            },
                            identical: {
                                field: 'password',
                                message: 'Confirm your password - type same password please'
                            },
                             notEmpty: {
                                message: 'Please supply confirm passwordSS.'
                            }
                        }
                    },
                }
            }).on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');
            });
        });
    </script>
@endsection
