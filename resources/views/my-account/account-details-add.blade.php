@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5> Edit Bank Account Details</h5>
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

    <div class="wrap_container">
	@include('includes.side-menu')
		<div class="col-md-9 col-sm-9">
			<div class="all_content">
				<div class="panel panel-default">
				<div class="panel-heading"> Add Bank Account Details</div>
				<div class="panel-body">
            <form id="bankform" class="form-horizontal" action="{{ url('account-details') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group ">
                    <label for="category" class="col-md-3 col-sm-3 required control-label">Account Holder Name</label>
                    <div class="col-md-9 col-sm-9">
                        <input type="text" class="form-control" name="account_holder_name" value="{{ old('account_holder_name')}}" required>
                        @if($errors->has('account_holder_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('account_holder_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Account Number</label>
                    <div class="col-md-9 col-sm-9">
                    	<input type="number" class="form-control" min=1 name="account_number" value="{{old('account_number')}}" required>
                        @if($errors->has('account_number'))
                            <span class="help-block">
                            <strong>{{ $errors->first('account_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Re-enter Account Number</label>
                    <div class="col-md-9 col-sm-9">
                    	<input type="number" class="form-control" min=1 name="re_enter_account_number" value="" required>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Bank Name</label>
                    <div class="col-md-9 col-sm-9">
                    	<select required class="form-control" name="bank_name" required>
                            <option value="" selected>Select Bank Name</option>
                            @foreach($bankNames['data'] as $bankName)
                               <option value="{{ $bankName['name'] }}">{{ $bankName['name'] }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('bank_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('bank_name') }}</strong>
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
		</div>	
	</div>
</div>
@endsection
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
	$(document).ready( function () {
	            
	    $('#bankform').bootstrapValidator({
	        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            bank_name: {
	                validators: {
	                    notEmpty: {
	                        message: 'Please select title.'
	                    }
	                }
	            },
	            account_holder_name: {
	                validators: {
	                    stringLength: {
	                        min: 2,
	                        max: 30,
	                        message: 'The account holder name must be more than 2 and less than 30 characters long'
	                    },
	                    regexp: {
	                        regexp: /^[a-zA-Z\s]+$/,
	                        message: 'The account holder name can only consist of alphabetical and space'
	                    }, 
	                    notEmpty: {
	                        message: 'Please supply account holder name.'
	                    }
	                }
	            },
	            account_number: {
	                validators: {
	                    identical: {
	                        field: 're_enter_account_number',
	                        message: 'Confirm your account number below - type same account number please'
	                    },
	                    notEmpty: {
	                        message: 'Please supply account number.'
	                    },
	                    number : { 
	                    	min : 1,
            				message : 'Please enter valid account number ',
            			}
	                }
	            },
	            re_enter_account_number: {
	                validators: {
	                    identical: {
	                        field: 'account_number',
	                        message: 'The account number and its re-enter account number are not the same'
	                    },
	                    number : { 
	                    	min : 1,
            				message : 'Please enter valid account number ',			
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
