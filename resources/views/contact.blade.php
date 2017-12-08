@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<section class="banner_section">
<div class="container">
<div class="contact_detail">
	<h5>contact us for help</h5>
	<p>Please call or complete the form and someone will be in touch with you shortly</p>
	<div class="num_box">
		<p>+234 8033120398</p>
	</div>
	</div>
</div>
</section>
<section class="mail_section">
	
	<div class="container"> 
	<h5>send us an email</h5>
	<p>drop us a line by using below form</p>
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
	
	<div class="form_wrp">
		<div class="row">
			<div class="col-md-12">
			 <form id="contact-form" action="{{ url('contact') }}" method="POST">
                {{csrf_field()}}
				<div class="col-md-4">
					<div class="form-group">
							 <label for="usr">FULL NAME</label>
							<input type="text" class="form-control" name="full_name" value="" id="usr">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
							 <label for="usr">PHONE</label>
							<input type="text" class="form-control" name="phone" value="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
							 <label for="usr">EMAIL</label>
							<input type="email" class="form-control" name="email" value="">
					</div>
				</div>
				<div class="col-md-12 space_content">
					<div class="form-group">
							 <label for="usr">SUBJECT</label>
							<input type="text" class="form-control" name="subject" value="">
					</div>
				</div>
				<div class="col-md-12 space_content">
					<div class="form-group">
							<label for="comment">MESSAGE</label>
							 <textarea class="form-control" rows="5" name="message"></textarea>
					</div>
				</div>
				<div class="col-md-12 submit_btn">
					<button type="submit" class="btn btn-default">submit</button>
				</div>
			</form>
			</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
    //Bootstarp validation on form
    $(document).ready(function() {
        $('#contact-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                full_name: {
                    validators: {
                            stringLength: {
                            min: 5,
                            message: 'Full name should be greater then 5 characters'
                        },
                            notEmpty: {
                            message: 'Please fill your full name'
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'Please fill your phone number'
                        },
                        numeric: {
                                message: 'The phone number can consist only numbers.'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please fill email address'
                        },
                        emailAddress: {
                                message: 'Please fill a valid email address'
                        }
                    }
                },
                subject: {
                    validators: {
                            stringLength: {
                            min: 5,
                            message: 'Subject should be greater then 5 characters'
                        },
                            notEmpty: {
                            message: 'Please fill your subject'
                        }
                    }
                },
                message: {
                    validators: {
                            stringLength: {
                            min: 20,
                            max:200,
                            message: 'Message should be greater then 20 and less than 200 characters'
                        },
                            notEmpty: {
                            message: 'Please fill your message'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection