@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
	<div class="container row_pad">
		<h5>{{ $subscriptPlan->title }} Subscription Plan</h5>
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
	    	<form id="register-form" class="form-horizontal" action="{{ url('/pay') }}" method="POST">
	    		{{csrf_field()}}
                <input type="hidden" name="subscription_plan_id" value="{{$subscriptPlan->id}}">
                <input type="hidden" name="amount" value="{{$price->price}}.00">
                <input type="hidden" name="user_amount" value="{{$subscriptPlan->price}}">
                <input type="hidden" name="currency" value="NGN">
                <input type="hidden" name="paystack-reference" value=""> {{-- required --}}
            	<input type="hidden" name="channels" value="'bank','card'">
                
                <div class="form-group">
                    <label for="service_name" class="col-md-2 required control-label">First Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" required>
                        @if($errors->has('first_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="service_name" class="col-md-2 required control-label">Last Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" required>
                        @if($errors->has('last_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="service_name" class="col-md-2 required control-label">Email</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" readonly="readonly" name="email" id="email" value="{{Auth::user()->email}}" required>
                        @if($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="mobile_number" class="col-md-2 required control-label">Mobile Number:(format:99-99-999999)</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control code" id="country_code" name="country_code" value="{{Auth::user()->country_code}}" readonly="readonly" />

                        <input  type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" class="form-control mobile" name="mobile_number" readonly="readonly" value="{{Auth::user()->mobile_number}}" required>
                          <span class="help-block">
                            <strong>Please enter mobile no. with country code</strong>
                        </span>
                        @if ($errors->has('mobile_number'))
                            <span class="help-block">
                            <strong>{{ $errors->first('mobile_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_name" class="col-md-2 required control-label">Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="address" id="address" value="{{Auth::user()->address}}" required>
                        @if($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="service_name" class="col-md-2 required control-label">City</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="city" id="city" value="{{Auth::user()->city}}" required>
                        @if($errors->has('city'))
                            <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="service_name" class="col-md-2 required control-label">State</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="state" id="state" value="{{Auth::user()->state}}" required>
                        @if($errors->has('state'))
                            <span class="help-block">
                            <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="service_name" class="col-md-2 required control-label">Country</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="country" id="country" value="{{Auth::user()->country}}" required>
                        @if($errors->has('country'))
                            <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                	<div class="col-md-12">
                	<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th class="product-name">Subscription Plan</th>
								<th class="product-total">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr class="cart_item">
								<td class="product-name">
									{{$subscriptPlan->title}}&nbsp;<strong class="product-quantity">× 1</strong>													</td>
								<td class="product-total">
									<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$subscriptPlan->currency.'  '.round($subscriptPlan->price, 2)}}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr class="cart-subtotal">
								<th>Subtotal</th>
								<td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$subscriptPlan->currency.'  '.round($subscriptPlan->price, 2)}}</td>
							</tr>
							<tr class="order-total">
								<th>Total</th>
								<td><strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$subscriptPlan->currency.'  '.round($subscriptPlan->price, 2)}}</strong> </td>
							</tr>
						</tfoot>
					</table>
					</div>
                </div>
                <div class="row">
                    <label for="checkbox" class="col-md-2 control-label"></label>
                    <div class="col-md-10 form-group">
                        <input name="is_agree_to_terms" value="" type="checkbox" required> I hereby declare, that I have read and accepted the <a href="#">Billing terms & condition.</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12" align="right">
                        <button class="btn btn-success btn-lg" type="submit"  value="Pay Now!">
			            	<i class="fa fa-plus-circle fa-lg"></i> Pay Now!
			            </button>
                    </div>
                </div>
            </form>
             
            <script>

            </script>
	    </div>
	</div>
@endsection
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
    //Bootstarp validation on form
    $(document).ready(function() {
        var i=0;
        $('#register-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                first_name: {
                    validators: {
                            stringLength: {
                            min: 2,
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'The first name can only consist of alphabetical and space'
                        },
                            notEmpty: {
                            message: 'Please supply your first name'
                        }
                    }
                },
                last_name: {
                    validators: {
                            stringLength: {
                            min: 2,
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'The last name can only consist of alphabetical and space'
                        },
                            notEmpty: {
                            message: 'Please supply your last name'
                        }
                    }
                },
                address: {
                    validators: {
                         stringLength: {
                            min: 8,
                        },
                        notEmpty: {
                            message: 'Please supply your address'
                        }
                    }
                },
                city: {
                    validators: {
                         stringLength: {
                            min: 4,
                        },
                        notEmpty: {
                            message: 'Please supply your city'
                        }
                    }
                },
                state: {
                    validators: {
                         stringLength: {
                            min: 4,
                        },
                        notEmpty: {
                            message: 'Please supply your state'
                        }
                    }
                },
                country: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your country'
                        }
                    }
                },
                country_code: {
                    validators: {
                        numeric: {
                            message: 'The country code can consist only numbers.'
                        },
                        notEmpty: {
                            message: 'Please supply country code.'
                        }
                    }
                },
                mobile_number: {
                    validators: {
                        numeric: {
                            message: 'The mobile number can consist only numbers.'
                        },
                        notEmpty: {
                            message: 'Please supply mobile number.'
                        }
                    }
                }, 
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your email address'
                        },
                        emailAddress: {
                            message: 'Please supply a valid email address'
                        }
                    }
                },
                is_agree_to_terms: {
                    validators: {
                        notEmpty: {
                            message: 'Please agree to terms & conditions'
                        },
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#register-form').data('bootstrapValidator').resetForm();

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