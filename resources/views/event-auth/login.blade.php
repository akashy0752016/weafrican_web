@extends('layouts.event-app')
@section('title', 'We African - Event Login')
@section('content')
<div class="main-container row">
    <div class="col-md-6 col-md-offset-3">
        @include('notification')
        <div class="panel panel-default">
            <div class="panel-heading">Event Login</div>
            <div class="panel-body">
                <form id="form" class="form-horizontal login-form" method="POST" action="{{ url('event-login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('eventId') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Event ID</label>

                        <div class="col-md-6">
                            <input id="eventId" type="text" class="form-control" name="eventId" value="{{ old('eventId') }}" autofocus>

                            @if ($errors->has('eventId'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('eventId') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Event Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">
                            <button type="button" id="eye">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
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
                                Login
                            </button>   
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('header-scripts')

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
 
    //Bootstarp validation on form
    $(document).ready(function() {

        $('#form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                    eventId: {
                        validators: {
                            notEmpty: {
                            message: 'Please enter correct Event Id'
                            }
                        }
                    },
                    password: {
                        validators: {
                            stringLength: {
                                min: 3,
                                max:20,
                                message: 'Password should be greater than 3 digits'
                            },
                            notEmpty: {
                                message: 'Please enter password'
                            }
                        }
                    },
                }
            })
            .on('success.form.bv', function(e) {
                $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                    $('#form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    console.log(result);
                }, 'json');
            });
        });
</script>

@endsection
