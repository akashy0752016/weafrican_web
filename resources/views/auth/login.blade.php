@extends('layouts.app')
@section('title', 'Weafricans - login')
@section('content')
<div class="container row_pad ">
    <div class="col-md-12">
        @include('notification')
        <div class="panel panel-default otp_box login_panel_section">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form id="form" class="form-horizontal login-form"  method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="m-10 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-12 col-sm-12 control-label">Email</label>

                        <div class="col-md-12 col-sm-12">
                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="m-20 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-12 col-sm-12 control-label">Business Password</label>

                        <div class="col-md-12 col-sm-12">
                            <input id="password" type="password" class="form-control" name="password">
                            <button type="button" id="eye" class="text-right" title="Show Password">
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
                        <div class="col-md-12 col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Login <i class="fa fa-sign-in" aria-hidden="true"></i>
                            </button>
                            <a class="btn btn-link forget-pass" href="{{ url('/password/reset') }}">
                                Forgot Your Business Password?
                            </a>   
                        </div>
                    </div>
                   

                    <hr class="seprator" />
                     
                    <div class="form-group">
                        <div class="multiple_login social-disabled" id="social-login">
                        <a href="" class="btn btn-facebook" id="social-facebook"><i class="fa fa-facebook"></i> Login With Facebook</a>
                            <a href="{{ url('/auth/google') }}" class="btn btn-google" id="social-google"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign in With Google+</a>
                            
                        </div>
                    </div>
                     <div class="form-group m-20 ">
                        <div class="col-md-12">
                            <div class="checkbox">
                                    <input name="is_agree_to_terms" id="termsChkbx" value="" type="checkbox" required> I hereby declare, that I have read and accepted the <a href="" data-toggle="modal" data-target="#terms">Terms &amp; Conditions.</a>
                            </div>
                        </div>
                    </div>
                  </form>   
                
            </div>
        </div>
    </div>
</div>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="terms" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Terms & Conditions</h5>
            </div>
            <div class="modal-body">
            @foreach($cmsPages as $term)
                @if($term->slug == 'terms-and-conditions')
                    @if(isset($term->content) and $term->content)
                        {!! $term->content !!}
                    @else
                        <p class="text-center">{{ $term->title }}'s page content is still being prepared.</p>
                    @endif
                @endif
            @endforeach

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="social-popup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content login_message_popup">
      <div class="modal-header condition_message">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Message !!</h4>
      </div>
      <div class="modal-body">
        <p>Please read terms & condition before proceed and check the term & conditions checkbox to continue with social login .</p>
      </div>
    </div>

  </div>
</div>

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


    var checkFlag = false;
    document.getElementById('termsChkbx').onchange = function() {
        if ( document.getElementById('termsChkbx').checked === true ) {
            $("#social-login").removeClass("social-disabled");
            checkFlag = true;
            document.getElementById('social-facebook').href = "{{ url('/auth/facebook') }}";
            document.getElementById('social-google').href = "{{ url('/auth/google') }}";
        } else {
            $("#social-login").addClass("social-disabled");
            checkFlag = false;
        }
    }
  
    $('#social-facebook').click(function (event) {
        if(!checkFlag){
            $('#social-popup').modal('show');
            return false;
        }
        return true;
    });
    $('#social-google').click(function (event) {
        if(!checkFlag){
            $('#social-popup').modal('show');
            return false;
        }
        return true;
    });
  
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
                    email: {
                        validators: {
                            notEmpty: {
                            message: 'Please enter email address'
                            },
                            emailAddress: {
                                message: 'Please supply a valid email address'
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
                    is_agree_to_terms:{
                        validators:{
                            notEmpty:{
                                message:'Please agree to terms & conditions'
                            }
                        }
                    } 
                }  
            });
        });
</script>
@endsection 
