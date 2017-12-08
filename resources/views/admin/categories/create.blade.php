@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-th-large" aria-hidden="true"></i> Add New Category</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/bussiness/category') }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Category Name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
						@if($errors->has('title'))
							<span class="help-block">
								<strong>{{ $errors->first('title') }}</strong>
							</span>
						@endif
					</div>
					<label class="control-label col-md-2">Selet Parent Category</label>
					<div class="col-md-4">
						<select class="form-control" name="parent_id" id="parent_id">
							<option value="0">None</option>
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->title}}</option>
							@endforeach
						</select>
						@if($errors->has('parent_id'))
							<span class="help-block">
								<strong>{{ $errors->first('parent_id') }}</strong>
							</span>
						@endif
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-md-2">Description</label>
					<div class="col-md-10">
						<textarea required class="form-control" name="description" ></textarea>
						@if($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Image</label>
					<div class="col-md-10">
						 <input type="file" name="category_image" id="category_image" required>
						@if($errors->has('category_image'))
							<span class="help-block">
								<strong>{{ $errors->first('category_image') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<fieldset class="col-md-12 ">
						<legend>Image Preview</legend>
						<div class="profiles_images">
							<img src="{{asset('images/no-image.jpg')}}" class="previewImg admin_image_preview" alt="" id="preview">
						</div>
					</fieldset>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success btn_fix" id="btn-login">Create Category</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
	<script type="text/javascript">

    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#category_image").change(function(){
        readURL(this);
    });
    $(document).ready(function() {
    	$('#category-form').bootstrapValidator({
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
                            message:'Title should not be less than 5 or greater than 35 characters'
                        },
                            notEmpty: {
                            message: 'Please supply your Category Title'
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your Category Description'
                        }
                    }
                },
                category_image: {
                	validators: {
	                    file: {
	                        extension: 'jpeg,png,jpg',
	                        type: 'image/jpeg,image/png,image/jpg',
	                        maxSize: 500 * 400,
	                        message: 'The selected file is not valid and image size should be 500*400 px'
	                    },
	                    notEmpty: {
                            message: 'Please select your category image'
                        }
	                }
                }
            }
    	});
    });
	</script>
@endsection
