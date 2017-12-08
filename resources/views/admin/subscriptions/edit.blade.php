@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<h2>Edit {{ $subscription->title }} Subscription Plan</h2>
<hr>
@include('notification')
<div class="panel panel-default edit_plan">
    <div class="panel-body">
        <form id="subscription-form" action="{{ url('admin/subscription/plan/'.$subscription->id) }}" method="POST" class="form-horizontal">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label class="control-label col-md-2">Plan Name</label>
                <div class="col-md-6{{ $errors->has('title') ? ' has-error' : '' }}">
                    <input required type="text" class="form-control" name="title" value="{{ $subscription->title }}" >
                    @if($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Coverage</label>
                <div class="col-md-2">
                    {{ $subscription->coverage }}
                </div>
                <label class="control-label col-md-2">Type</label>
                <div class="col-md-2">
                    {{ $subscription->type }}
                </div>
            </div>
            @if($subscription->keywords_limit)
            <div class="form-group">
                <label class=" required control-label col-md-2">keywords Limit</label>
                <div class="col-md-6{{ $errors->has('keywords_limit') ? ' has-error' : '' }}">
                    <input required type="text" min="1" class="form-control" name="keywords_limit" value="{{ $subscription->keywords_limit }}" >
                    @if($errors->has('keywords_limit'))
                    <span class="help-block">
                    <strong>{{ $errors->first('keywords_limit') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            @endif
            <div class="form-group">
                <label class="control-label col-md-2">Price(per month)</label>
                <div class="col-md-6{{ $errors->has('price') ? ' has-error' : '' }}">
                    <input required type="text" class="form-control" name="price" value="{{ $subscription->price }}" >
                    @if($errors->has('price'))
                    <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Validity Period (in days)</label>
                <div class="col-md-6{{ $errors->has('validity_period') ? ' has-error' : '' }}">
                    <input required type="text" class="form-control" name="validity_period" id="validity_period" value="{{ $subscription->validity_period }}" >
                    @if($errors->has('validity_period'))
                    <span class="help-block">
                    <strong>{{ $errors->first('validity_period') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success" id="btn-login">Update Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#subscription-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                            stringLength: {
                            min: 2,
                        },
                            notEmpty: {
                            message: 'Please supply your Subscription Plan Title'
                        }
                    }
                },
                keywords_limit: {
                    validators: {
                        integer: {
                            message: 'The value is not an integer'
                        },
                        notEmpty: {
                            message: 'Please enter keywords limit'
                        }
                    }
                },
                price: {
                    validators: {
                        notEmpty: {
                            message: 'The price is required'
                        },
                        numeric: {
                            message: 'The price must be a number'
                        }
                    }
                },
                validity_period: {
                    validators: {
                        integer: {
                            message: 'The value is not an integer'
                        },
                        notEmpty: {
                            message: 'Please enter validity period limit'
                        }
                    }
                }
            }
        });
    });
    </script>
@endsection