@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit Banner</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="banner-form" action="{{ url('admin/banner/'.$banner->id) }}" method="POST" class="form-horizontal">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Banner Title</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="title" value="{{ $banner->title or old('title') }}" >
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">Banner Description</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="description" value="{{ $banner->description or old('description') }}" >
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
					<label class="control-label col-md-2">City</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="city" value="{{ $banner->city}}" >
						@if($errors->has('city'))
							<span class="help-block">
								<strong>{{ $errors->first('city') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-me-4">
						<button type="submit" class="btn btn-success">Update Banner</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#banner-form').bootstrapValidator({
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
                        message: 'Please supply your Banner Title'
                    }
                }
            },
            description: {
            	validators: {
            		notEmpty: {
            			message: 'Please enter your banner description'
            		}
            	}
            },
            city: {
            	validators: {
            		notEmpty: {
            			message: "Please enter your City"
            		}
            	}
            }
        }
	});
});
</script>
@endsection