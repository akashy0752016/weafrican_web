@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit User Business</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="category-form" action="{{ url('admin/business/'.$business->id) }}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				{{csrf_field()}}
				{{ method_field('PUT') }}
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness Title:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="title" value="{{ $business->title or old('title') }}" required>
						@if($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Category</label>
					<div class="col-md-4">
						<select required class="form-control" id="bussiness_category_id" name="bussiness_category_id" required>
							<option value="" selected>Select category</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" @if($business->category->title == $category->title){{ 'selected'}} @else @endif >{{ $category->title }}</option>
							@endforeach
						</select>
						@if($errors->has('bussiness_category_id'))
						<span class="help-block">
							<strong>{{ $errors->first('bussiness_category_id') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
				<div id="subcategory" @if(count($subCategories)<=0 and $business->bussiness_subcategory_id==0) style="display: none;" @endif>
                    <label for="subcategory" class="col-md-2 control-label required">Sub Category:</label>
                    <div class="col-md-4">
                        <select name="bussiness_subcategory_id" @if($business->bussiness_subcategory_id!="") required="required" @endif id="bussiness_subcategory_id" class="form-control selectpicker">
                            <option value="">Select Sub Category</option>
                            @foreach($subCategories as $subcategory)
								<option value="{{ $subcategory->id }}" @if($business->bussiness_subcategory_id == $subcategory->id) selected="selected" @endif >{{ $subcategory->title }}</option>
							@endforeach
                        </select>
                        @if ($errors->has('bussiness_subcategory_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('bussiness_subcategory_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-2">Bussiness keywords:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="keywords" value="{{ $business->keywords or old('keywords') }}" required>
						@if($errors->has('keywords'))
						<span class="help-block">
							<strong>{{ $errors->first('keywords') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">About Us:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="about_us" value="{{ $business->about_us or old('about_us') }}" >
						@if($errors->has('about_us'))
						<span class="help-block">
							<strong>{{ $errors->first('about_us') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Address:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="address" value="{{ $business->user->address or old('address') }}">
						@if($errors->has('address'))
						<span class="help-block">
							<strong>{{ $errors->first('address') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">City:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="city" value="{{ $business->user->city or old('city') }}" >
						@if($errors->has('city'))
						<span class="help-block">
							<strong>{{ $errors->first('city') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">State:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="state" value="{{ $business->user->state or old('state') }}">
						@if($errors->has('state'))
						<span class="help-block">
							<strong>{{ $errors->first('state') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Country:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="country" value="{{ $business->user->country or old('country') }}">
						@if($errors->has('country'))
						<span class="help-block">
							<strong>{{ $errors->first('country') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Pin code:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="pin_code" value="{{ $business->user->pin_code or old('pin_code') }}" >
						@if($errors->has('pin_code'))
						<span class="help-block">
							<strong>{{ $errors->first('pin_code') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Email:</label>
					<div class="col-md-4">
					<input type="text" class="form-control" name="email" value="{{ $business->user->email or old('email') }}" required>
						@if($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Primary Mobile Number:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="mobile_number" value="{{ $business->user->mobile_number or old('mobile_number') }}" required disabled >
						@if($errors->has('mobile_number'))
						<span class="help-block">
							<strong>{{ $errors->first('mobile_number') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-md-2">Website</label>
					<div class="col-md-4">
						<input type="text" class="form-control" name="website" value="{{ $business->website or old('website') }}">
						@if($errors->has('website'))
						<span class="help-block">
							<strong>{{ $errors->first('website') }}</strong>
						</span>
						@endif
					</div>
					<label class="control-label col-md-2">Working Hours</label>
					<div class="col-md-4">
						<textarea class="form-control" name="working_hours" value="{{ $business->working_hours or old('working_hours') }}" rows="9">{{ $business->working_hours or old('working_hours') }}</textarea>
						@if($errors->has('working_hours'))
						<span class="help-block">
							<strong>{{ $errors->first('working_hours') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<button type="submit" class="btn btn-success btn_right" id="btn-login">Update User Business</button>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
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
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your Business Title'
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
	$('#bussiness_category_id').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    _token: "{{ csrf_token() }}",
                    user_role : 3,
                    category : this.value,
                },success:function(response)
                {
                    $('#bussiness_subcategory_id').find('option').not(':first').remove();
                    $('#subcategory').show();
                    $('#bussiness_subcategory_id').attr('required', false);
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#bussiness_subcategory_id').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                        $('#subcategory').show();
                        $('#bussiness_subcategory_id').attr('required', true);
                    }else
                    {
                        $('#subcategory').hide();
                    }
                }
            });
            var selected = $('#bussiness_category_id option:selected').html();
            var bootstrapValidator = $('#category-form').data('bootstrapValidator');
        }else
        {
            $('#bussiness_subcategory_id').find('option').not(':first').remove();
            $('#bussiness_subcategory_id').attr('required', false);
            $('#subcategory').hide();
        }
    });
});
</script>
@endsection