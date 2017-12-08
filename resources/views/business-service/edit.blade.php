@extends('layouts.app')
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
        <h5 class="text-left">Edit Service</h5>
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
        <div class="panel panel-default document">
            <form id="register-form" class="form-horizontal" action="{{ url('business-service/'.$service->id) }}" method="POST">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="service_name" class="col-md-3 col-sm-3 required control-label">Service Name</label>
                    <div class="col-md-9 col-sm-9">
                        <input type="text" class="form-control" name="title" value="{{ $service->title }}" required>
                        @if($errors->has('title'))
                            <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Description</label>
                    <div class="col-md-9 col-sm-9">
                        <textarea required type="text" class="form-control" name="description">{{ $service->description }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
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
                title: {
                    validators: {
                        stringLength: {
                            min: 5,
                            max:35,
                            message:' Service Title should be greater than 5 or less than 35 characters'
                        },
                            notEmpty: {
                            message: 'Please fill your Service Title'
                        }
                    }
                },
                description: {
                    validators: {
                        stringLength: {
                            min: 10,
                            max: 100,
                            message:' Service description should be greater than 10 or less than 100 characters'
                        },
                        notEmpty: {
                            message: 'Please supply your Service descriptions'
                        }
                    }
                },
            }
        });
    });
</script>
@endsection