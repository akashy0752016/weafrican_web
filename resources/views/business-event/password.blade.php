@extends('layouts.app')
@section('title', 'Add Event Password')
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
    <div class="row">
        <h5 class="text-left">Create Event Password</h5>
        <hr>
        @include('notification')
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <p>First create event password then you can add your new event.</p>
        <div class="panel panel-default document">
            <form id="register-form" class="form-horizontal" action="{{ url('add/event-password') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group ">
                    <label for="category" class="col-md-3 col-sm-3 required control-label">Event Password</label>
                    <div class="col-md-9 col-sm-9">
                        <input type="password" class="form-control" name="event_password" value="{{ old('event_password') }}" required>
                        @if($errors->has('event_password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('event_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Confirm Event Password</label>
                    <div class="col-md-9 col-sm-9">
                        <input type="password" class="form-control" name="confirm_password" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                        Submit
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
    //Bootstarp validation on form
    $(document).ready(function() {
        $('#register-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                event_password: {
                        validators: {
                        stringLength: {
                            min: 6,
                            max: 16,
                            message: 'The  event password length must be between 6-16 charcters long'
                        },
                        identical: {
                            field: 'confirm_password',
                            message: 'Confirm your event password below - type same event password please'
                        }
                    }
                },
                confirm_password: {
                    validators: {
                        identical: {
                            field: 'event_password',
                            message: 'The event password and its confirm are not the same'
                        }
                    }
                },
            }
        });
    });
</script>
@endsection