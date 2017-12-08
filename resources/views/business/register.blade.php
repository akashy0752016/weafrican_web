@extends('layouts.app')
@section('header-scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pwstrength.js') }}" type="text/javascript"></script>
@endsection

@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
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
        <div class="multiple_login">
                        <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook" id="social-facebook"><i class="fa fa-facebook"></i> Sign up With Facebook</a>
                            <a href="{{ url('/auth/google') }}" class="btn btn-google" id="social-google"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign up With Google+</a>
                            <p class="text-center">OR</p>
                        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Register Your Business for Free</div>
            <div class="panel-body">
                <form id="register-form" class="form-horizontal" role="form" method="POST" action="{{ url('/register-business') }}" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="row">
                        <label for="name" class="col-md-2 control-label required">Full Name:</label>
                        <div class="col-md-1 form-group salute no_padd">
                            <select name="salutation" id="salutation" class="form-control selectpicker" required style="padding-right:0px;">
                                <option value="Mr">Mr.</option>
                                <option value="Ms">Ms.</option>
                                <option value="Mrs">Mrs.</option>
                            </select>
                            @if ($errors->has('salutation'))
                                <span class="help-block">
                                <strong>{{ $errors->first('salutation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3 no_padd form-group">
                            <input required type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" maxlength="15" pattern="^[a-zA-Z\s]+$" autofocus placeholder="First Name">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3 no_padd form-group">
                            <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" autofocus  pattern="^[a-zA-Z\s]+$" maxlength="15" placeholder="Middle Name">
                            @if ($errors->has('middle_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('middle_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-3 form-group">
                            <input required type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" maxlength="15" pattern="^[a-zA-Z\s]+$" autofocus placeholder="Last Name">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="gender" class="col-md-2 control-label required">Gender:</label>
                        <div class="col-md-4 form-group top_pad">
                            <div class="col-md-12">
                                <div class="radio-inline">
                                    <input required type="radio" class="" name="gender"
                                    @if(old('gender')!='female')
                                        checked="checked"
                                    @endif
                                    value="male">&nbsp;<label>Male</label>
                                </div>
                                <div class="radio-inline gend">
                                    <input required type="radio" class="" name="gender" 
                                    @if(old('gender')=='female')
                                        checked="checked"
                                    @endif 
                                    value="female">&nbsp;<label>Female</label>
                                </div>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="category" class="col-md-2 control-label required">Category:</label>
                        <div class="col-md-4 form-group">
                            <select name="bussiness_category_id" id="bussiness_category_id" class="form-control selectpicker" required>
                                <option value="" selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('bussiness_category_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('bussiness_category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div id="subcategory" style="display: none;">
                            <label for="subcategory" class="col-md-2 control-label required">Sub Category:</label>
                            <div class="col-md-4 form-group">
                                <select name="bussiness_subcategory_id" id="bussiness_subcategory_id" class="form-control selectpicker">
                                    <option value="" selected>Select Sub Category</option>
                                </select>
                                @if ($errors->has('bussiness_subcategory_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('bussiness_subcategory_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <div class="form-group">
                        <label for="address" class="col-md-2 control-label">Location:</label>
                        <div class="col-md-10 map_location">
                             <!-- <input type="text" class="form-control" id="location-text-box" /> -->
                              <div id="map"></div>
                        </div>
                    </div>
                    </div>

                     <!-- <input type="text" name="street_address" id="pac-input" class="controls" placeholder="Enter a Location*" value="{{ old('street_address') }}" required placeholder="Address*">
                                    <div id="map"></div> -->

                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">

                    <div class="row">
                        <label for="address" class="col-md-2 control-label required">Street Address:</label>
                        <div class="col-md-4  form-group">
                           <!--  <input type="text" id="address" class="form-control" name="address" value="{{ old('address') }}"> -->
                           <input type="text" id="location-text-box" name="address" id="pac-input" class="form-control" placeholder="Enter a Location*" value="{{ old('address') }}" required placeholder="Address*">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="house" class="col-md-2 control-label required">House No./Block No.:</label>
                        <div class="col-md-4  form-group">
                           <!--  <input type="text" id="address" class="form-control" name="address" value="{{ old('address') }}"> -->
                           <input type="text" id="house" name="house" class="form-control" value="{{ old('house') }}" required placeholder="House No./ Block No.*">
                            @if ($errors->has('house'))
                                <span class="help-block">
                                <strong>{{ $errors->first('house') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <label for="city" class="col-md-2 control-label required">City:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" id="city" name="city"  value="{{ old('city') }}" required>
                            @if ($errors->has('city'))
                                <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="state" class="col-md-2 control-label required">State:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" readonly>
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="country" class="col-md-2 control-label required">Country:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" readonly="readonly" >
                            @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="pin_code" class="col-md-2 required control-label">Pin Code: (format:110075)</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}" maxlength="10">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <label for="mobile_number" class="col-md-2 required control-label">Mobile Number:(format:99-99-999999)</label>
                        <div class="col-md-4 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-3 country_code_div form-group">
                                <input type="text" class="form-control" id="country_code" name="country_code" maxlength="4" value="{{ old('country_code') }}" />    
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9 mobile_number_div form-group">
                                <input  type="text"  pattern="[0-9]" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" required>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <span class="help-block">
                                        <strong>Please enter mobile no. with country code</strong>
                                    </span>
                                </div>
                            </div>
                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="about_us" class="col-md-2 col-xs-12 currency-text control-label">Currency</label>
                        <div class="col-md-4 col-xs-12 form-group">
                            <input type="text" maxlength="5" id="currency" class="form-control" name="currency" value="{{ old('currency') }}" required readonly>
                            @if ($errors->has('currency'))
                                <span class="help-block">
                                <strong>{{ $errors->first('currency') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <legend>Business Information</legend>
                    </div>
                    <div class="row">
                        <label for="title" id="business_title_lable" class="col-md-2 control-label required">Business Name:</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" class="form-control" placeholder="Business Name" name="title" id="business_title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="keywords" id="business_keyword_lable" class="col-md-2 required control-label">Business Keywords:</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" class="form-control" id="business_keywords" name="keywords" placeholder="Ex. Software developer, Gas Supplier , Baby Cloths, Electronics" value="{{ old('keywords') }}">
                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                <strong>{{ $errors->first('keywords') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="website" class="col-md-2 control-label{{ $errors->has('website') ? ' has-error' : '' }}"">Website:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" placeholder="Website" name="website" value="{{ old('website') }}">
                            @if ($errors->has('website'))
                                <span class="help-block">
                                <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <label for="about_us" id="about_us_lable" class="col-md-2 control-label">About us:</label>
                        <div class="col-md-4 form-group">
                            <textarea class="form-control" name="about_us" placeholder="About Us" rows="11" ></textarea>
                            @if ($errors->has('about_us'))
                                <span class="help-block">
                                <strong>{{ $errors->first('about_us') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="working_hours" class="col-md-2 control-label">
                        Working Hours:
                        </label>
                        <div class="col-md-4 form-group">
                            <div class="table-responsive working_hours_table" style="width: 100%">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Timing</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tab_body">
                                        <tr>
                                            <td>MON</td>
                                            <td>10:00 AM to 06:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td>TUE</td>
                                            <td>10:00 AM to 06:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td>WED</td>
                                            <td>10:00 AM to 06:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td>THU</td>
                                            <td>10:00 AM to 06:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td>FRI</td>
                                            <td>10:00 AM to 06:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td>SAT</td>
                                            <td>Closed</td>
                                        </tr>
                                        <tr>
                                            <td>SUN</td>
                                            <td>Closed</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <textarea style="display: none;" class="form-control" name="working_hours" id="working_hours" rows="8" readonly="readonly" onclick="javascript:$('#working_hours_modal').modal('show')" >
MON  :   10:00 AM to 06:00 PM
TUE  :   10:00 AM to 06:00 PM
WED  :   10:00 AM to 06:00 PM
THU  :   10:00 AM to 06:00 PM
FRI  :   10:00 AM to 06:00 PM
SAT  :   Closed
SUN  :   Closed
</textarea><!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#working_hours_modal" onclick="javascript:checkWorkingHours();">Add Working Hours</button>
                            @if ($errors->has('working_hours'))
                                <span class="help-block">
                                <strong>{{ $errors->first('working_hours') }}</strong>
                                </span>
                            @endif
                            
                        </div>
                    </div>

                    <div class="row">
                        <label for="business_logo" id="business_logo_lable" class="col-md-2 control-label">Business Logo:</label>
                        <div class="col-md-4 form-group">
                            <label class="btn-bs-file btn btn-info">Browse
                            <input type="file" name="business_logo" id="business_logo" accept="image/jpg,image/jpeg,image/png" />
                            </label>
                            @if ($errors->has('business_logo'))
                                <span class="help-block">
                                <strong>{{ $errors->first('business_logo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="logo_preview" class="col-md-2 control-label">
                        Preview:
                        </label>
                        <div class="col-md-4">
                        <div class="profile_img">
                            <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                            </div>
                        </div>
                    </div>
                    <div id="entertaintment" style="display: none">
                        <div>
                            <legend>Entertaintment Information</legend>
                        </div>
                    </div>
                    <div id="skilled_professional" style="display: none">
                        <div>
                            <legend>Skilled Professional Information</legend>
                        </div>
                    </div>
                    <div id="common" style="display: none">
                        <div class="row">
                            <label for="maritial_status" class="col-md-2 control-label required">Maritial Status:</label>
                            <div class="col-md-4 form-group">
                                <select name="maritial_status" id="maritial_status" class="form-control selectpicker">
                                   <option value="">Select One</option>
                                   <option value="married">Married</option>
                                   <option value="single">Single</option>
                                   <option value="divorced">Divorced</option>
                                   <option value="separated">Separated</option>
                                </select>
                                @if ($errors->has('maritial_status'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('maritial_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="occupation" class="col-md-2 control-label required">Occupation:</label>
                            <div class="col-md-4 form-group">
                                <input type="text" class="form-control" name="occupation" id="occupation">
                                @if ($errors->has('occupation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('occupation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <label for="acadmic" class="col-md-2 control-label required">Academic Status:</label>
                            <div class="col-md-4 form-group">
                                <select name="acedimic_status" id="acedimic_status" class="form-control selectpicker">
                                   <option value="">Select One</option>
                                   <option value="10">10</option>
                                   <option value="10+2">10+2</option>
                                   <option value="Graduate">Graduate</option>
                                   <option value="Post Graduate">Post Graduate</option>
                                   <option value="Diploma">Diploma</option>
                                </select>
                                @if ($errors->has('academic'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('academic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <label for="key_skills" class="col-md-2 control-label required">Key Skills:</label>
                            <div class="col-md-4 form-group">
                                <input type="text" class="form-control" name="key_skills" id="key_skills">
                                @if ($errors->has('key_skills'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('key_skills') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <legend>Login Information</legend>
                    </div>

                     <div class="row">
                        <label for="email" class="col-md-2 control-label required">Email:</label>
                        <div class="col-md-4 form-group">
                            <input required type="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row" id="pwd-container">
                        <label for="password" class="col-md-2 control-label required">Business Password:</label>
                        <div class="col-md-4 form-group">
                            <input required type="password" class="form-control" id="password" name="password" value="">
                            <button type="button" id="eye" class="text-right" title="Show Password">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <div class="" style="margin-top: 20px;width: 100%;">
                                <div class="pwstrength_viewport_progress" style="display: none;"></div>
                            </div>
                        </div>

                        <label for="confirm_password" class="col-md-2 control-label required">Confirm Business Password:</label>
                        <div class="col-md-4 form-group">
                            <input required type="password" class="form-control" name="confirm_password" value="">
                            @if ($errors->has('confirm_password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkbox" class="col-md-2 control-label required">Security Question</label>
                        <div class="col-md-10 form-group">
                            <select name="security_question_id" id="security_question_id" class="form-control selectpicker" required="required">
                                <option value="">Select Security Question</option>
                                @foreach($securityquestions as $securityquestion)
                                    <option value="{{ $securityquestion->id }}"
                                    @if(old('security_question_id')==$securityquestion->id)
                                        selected="selected"
                                    @endif
                                    >{{ $securityquestion->question }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('security_question_id'))
                                <span class="help-block">
                                <strong>{{ $errors->first('security_question_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkbox" class="col-md-2 control-label required">Answer</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" class="form-control" name="security_question_ans" placeholder="Answer" id="security_question_ans" value="{{ old('security_question_ans') }}">
                            @if ($errors->has('security_question_ans'))
                                <span class="help-block">
                                <strong>{{ $errors->first('security_question_ans') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row error_right">
                        <label for="checkbox" class="col-md-2 control-label"></label>
                        <div class="col-md-10 form-group">
                            <input name="is_agree_to_terms" value="" type="checkbox" required> I hereby declare, that I have read and accepted the <a href="" data-toggle="modal" data-target="#myModal">Terms &amp; Conditions.</a>
                        </div>
                    </div>

                    <div class="row">
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

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Terms & Conditions</h5>
            </div>
            <div class="modal-body">
                @if(isset($term->content) and $term->content)
                    {!! $term->content !!}
                @else
                    <p class="text-center">{{ $term->title }}'s page content is still being prepared.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('sections.business_hours')
@endsection

@section('scripts')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVusRctxw1eB0esgPlwglfML6zWrAVj9A&libraries=places&callback=initialize" async defer></script>
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

    //Image preview jQuery
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#password").bind("keyup change", function(e){
        if(this.value!="")
        {
            $('.pwstrength_viewport_progress').fadeIn();
        }else
        {
            $('.pwstrength_viewport_progress').fadeOut();
        }
    });

    $("#business_logo").change(function(){
        readURL(this);
    });

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
                    first_name: {
                        validators: {
                                stringLength: {
                                min: 2,
                            },
                            regexp: {
                                regexp: /^[a-zA-Z\s]+$/,
                                message: 'The Full name can only consist of alphabetical and space'
                            },
                                notEmpty: {
                                message: 'Please supply your First name'
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
                                message: 'The Lats name can only consist of alphabetical and space'
                            },
                                notEmpty: {
                                message: 'Please supply your Last name'
                            }
                        }
                    },
                    title: {
                        validators: {
                            stringLength: {
                                min: 2,
                                max:20
                            },
                            notEmpty: {
                                message: 'Please supply your business name'
                            }
                        }
                    },
                    bussiness_category_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your category'
                            }
                        }
                    },
                    bussiness_subcategory_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your sub-category'
                            }
                        }
                    },
                    keywords: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your business keywords'
                            }
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your address'
                            }
                        }
                    },
                    city: {
                        validators: {
                            regexp: {
                                regexp: /^[ A-Za-z_@./#&+-]*$/,
                                message: 'The city name should only contain alphabets'
                            },
                            notEmpty: {
                                message: 'Please supply your city'
                            }
                        }
                    },
                    state: {
                        validators: {
                            regexp: {
                                regexp: /^[ A-Za-z_@./#&+-]*$/,
                                message: 'The state name should only contain alphabets'
                            },
                            notEmpty: {
                                message: 'Please supply your state'
                            }
                        }
                    },
                    country: {
                        validators: {
                            regexp: {
                                regexp: /^[ A-Za-z_@./#&+-]*$/,
                                message: 'The country name should only contain alphabets'
                            },
                            notEmpty: {
                                message: 'Please supply your country'
                            }
                        }
                    },
                    currency: {
                        validators: {
                            stringLength: {
                                max: 10,
                            },
                            regexp: {
                                regexp: /^[ A-Za-z_@./#&+-]*$/,
                                message: 'The currency code should only contain alphabets'
                            },
                            notEmpty: {
                                message: 'Please supply your country currency'
                            }
                        }
                    },
                    pin_code: {
                        validators: {
                            stringLength: {
                                max: 10,
                                message: 'Pincode max length can be 10 characters only'
                            },
                            notEmpty: {
                                message: 'Please supply your pin code'
                            }
                        }
                    },
                    house: {
                        validators: {
                            stringLength: {
                                max: 50,
                                message: 'House number should be max 50 char in length'
                            },
                            notEmpty: {
                                message: 'Please supply your house number'
                            }
                        }
                    },
                    country_code: {
                        validators: {
                            numeric: {
                                message: 'The country code can consist only numbers.'
                            },
                            stringLength: {
                                max: 4,
                                message: 'The country code max 4 char in length'
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
                            stringLength: {
                                max: 50,
                                message: 'The  email length must be less than 50 charcters long'
                            },
                            notEmpty: {
                                message: 'Please supply your email address'
                            },
                            emailAddress: {
                                message: 'Please supply a valid email address'
                            }
                        }
                    },                  
                    password: {
                        validators: {
                            stringLength: {
                                min: 6,
                                max: 16,
                                message: 'The  password length must be between 6-16 charcters long'
                            },
                            identical: {
                                field: 'confirm_password',
                                message: 'Confirm your password below - type same password please'
                            }
                        }
                    },
                    confirm_password: {
                        validators: {
                            identical: {
                                field: 'password',
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                    maritial_status: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your maritial status'
                            }
                        }
                    },
                    key_skills: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter your key skills'
                            }
                        }
                    },
                    acedimic_status: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your Academic Status'
                            }
                        }
                    },
                    occupation: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your occupation'
                            }
                        }
                    },
                    security_question_id: {
                        validators: {
                            notEmpty: {
                                message: 'Please select your Security Question'
                            }
                        }
                    },
                    security_question_ans: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Security Question Answer'
                            }
                        }
                    },
                }
            })
            .on('success.form.bv', function(e) {
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

        function checkWorkingHours()
        {  
            var days = new Array();

            days[0] = document.querySelector('input[name="option_day[0]"]:checked').value;
            days[1] = document.querySelector('input[name="option_day[1]"]:checked').value;
            days[2] = document.querySelector('input[name="option_day[2]"]:checked').value;
            days[3] = document.querySelector('input[name="option_day[3]"]:checked').value;
            days[4] = document.querySelector('input[name="option_day[4]"]:checked').value;
            days[5] = document.querySelector('input[name="option_day[5]"]:checked').value;
            days[6] = document.querySelector('input[name="option_day[6]"]:checked').value;

            for(var i=0;i<days.length;i++)
            {
                if (days[i]!=0) {
                    document.getElementById("open_"+i).setAttribute('disabled', true);
                    document.getElementById("close_"+i).setAttribute('disabled', true);
                } else {
                    document.getElementById("open_"+i).removeAttribute('disabled');
                    document.getElementById("close_"+i).removeAttribute('disabled');
                }
            }
        }

    $(document).ready(function() {

        $('input[type=radio][class=opt_day]').change(function() {
            checkWorkingHours();
        });

        $('#modal_submit').click(function() {

            var days = new Array();

            days[0] = document.querySelector('input[name="option_day[0]"]:checked').value;
            days[1] = document.querySelector('input[name="option_day[1]"]:checked').value;
            days[2] = document.querySelector('input[name="option_day[2]"]:checked').value;
            days[3] = document.querySelector('input[name="option_day[3]"]:checked').value;
            days[4] = document.querySelector('input[name="option_day[4]"]:checked').value;
            days[5] = document.querySelector('input[name="option_day[5]"]:checked').value;
            days[6] = document.querySelector('input[name="option_day[6]"]:checked').value;
            var text = "";
            var tab = "";
            for(var i=0;i<days.length;i++)
            {
                if(i==0)
                {
                    tab = tab + '<tr><td>MON</td>';
                    text = text + "MON  :   ";
                }else if(i==1)
                {
                    tab = tab + '<tr><td>TUE</td>';
                    text = text + "TUE  :   ";
                }else if(i==2)
                {
                    tab = tab + '<tr><td>WED</td>';
                    text = text + "WED  :   ";
                }else if(i==3)
                {
                    tab = tab + '<tr><td>THU</td>';
                    text = text + "THU  :   ";
                }else if(i==4)
                {
                    tab = tab + '<tr><td>FRI</td>';
                    text = text + "FRI  :   ";
                }else if(i==5)
                {
                    tab = tab + '<tr><td>SAT</td>';
                    text = text + "SAT  :   ";
                }else if(i==6)
                {
                    tab = tab + '<tr><td>SUN</td>';
                    text = text + "SUN  :   ";
                }
                if(days[i]==0)
                {
                    tab = tab + '<td>' + convertTime($('#open_'+i).val()) + " to " + convertTime($('#close_'+i).val()) + '</td></tr>';
                    text = text + convertTime($('#open_'+i).val()) + " to " + convertTime($('#close_'+i).val());
                }else if(days[i]==1)
                {
                    tab = tab + '<td>Closed</td></tr>';
                    text = text + "Closed";
                }else if(days[i]==2)
                {
                    tab = tab + '<td>24 Hours Open</td></tr>';
                    text = text + "24 Hours Open";
                }
                text = text + "\n";
            }
            //alert(tab);
            $("#tab_body").html(tab);
            $("#working_hours").val(text);
            $('#working_hours_modal').modal('hide');
        });
    });

    function convertTime(str)
    {
        var temp = str.split(":");
        temp[0] = parseInt(temp[0]);
        if(temp[0]<10)
        {
            temp[0] = "0" + temp[0];
        }
        return temp.join(":");
    }

    $(function () {
        $('.date').datetimepicker({
            format: 'LT'
        });
    });

    setTimeout(function () {
      //getCurrencyAndCode();
    }, 3000);

    //window.onload = getCurrencyAndCode();

    $("#country").change(function(){
        
        getCurrencyAndCode();
    });

    function getCurrencyAndCode()
    {
        $.ajax({
            type: "POST",
            url: '{{ url("country-details") }}',
            data: {
                _token: "{{ csrf_token() }}",
                country : $("#country").val(),
            },success:function(response){
                if(response!="")
                {
                    var result = JSON.parse(response);
                    $("#country_code").val(result.country_code);
                    $("#currency").val(result.currency);
                }else
                {
                     $("#currency").val("NGN");
                     $("#country_code").val("234");
                }
            }
        });
    }

    $('#bussiness_category_id').on('change', function() {
        var bootstrapValidator = $('#register-form').data('bootstrapValidator');
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
                        bootstrapValidator.enableFieldValidators('bussiness_subcategory_id', true);
                    }else
                    {
                        $('#subcategory').hide();
                        bootstrapValidator.enableFieldValidators('bussiness_subcategory_id', false);
                    }
                }
            });
            var selected = $('#bussiness_category_id option:selected').val();
            console.log($('#bussiness_category_id option:selected').val());
            if(selected==1)
            {
                $('#entertaintment').show();
                $('#skilled_professional').hide();
                $('#business_logo_lable').text("Profile Pic :");
                $('#about_us_lable').text("Description :");
                $('#business_title_lable').removeClass("required");
                $('#business_title').attr('required', false);
                /*$('#business_keyword_lable').removeClass("required");
                $('#business_keywords').attr('required', false);*/
                $('#common').show();
                $('#maritial_status').attr('required', true);
                $('#occupation').attr('required', true);
                $('#key_skills').attr('required', true);
                $('#occupation_skill').attr('required', false);
                $('#key_skills_skill').attr('required', false);
                bootstrapValidator.enableFieldValidators('title', false);
                /*bootstrapValidator.enableFieldValidators('keywords', false);*/
            }else if(selected==2)
            {
                $('#skilled_professional').show();
                $('#business_logo_lable').text("Profile Pic :");
                $('#about_us_lable').text("Description :");
                $('#business_title_lable').removeClass("required");
                $('#business_title').attr('required', false);
                /*$('#business_keyword_lable').removeClass("required");
                $('#business_keywords').attr('required', false);*/
                $('#entertaintment').hide();
                $('#common').show();
                $('#maritial_status').attr('required', false);
                $('#occupation').attr('required', false);
                $('#key_skills').attr('required', false);
                $('#occupation_skill').attr('required', true);
                $('#key_skills_skill').attr('required', true);
                bootstrapValidator.enableFieldValidators('title', false);
                /*bootstrapValidator.enableFieldValidators('keywords', false);*/
            }else
            {
                $('#skilled_professional').hide();
                $('#business_logo_lable').text("Business Logo :");
                $('#about_us_lable').text("About us :");
                $('#business_title_lable').addClass("required");
                $('#business_title').attr('required', true);
                /*$('#business_keyword_lable').addClass("required");
                $('#business_keywords').attr('required', true);*/
                $('#entertaintment').hide();
                $('#common').hide();
                $('#maritial_status').attr('required', false);
                $('#occupation').attr('required', false);
                $('#key_skills').attr('required', false);
                $('#occupation_skill').attr('required', false);
                $('#key_skills_skill').attr('required', false);
                bootstrapValidator.enableFieldValidators('title', true);
                /*bootstrapValidator.enableFieldValidators('keywords', true);*/
            }
        }else
        {
            $('#bussiness_subcategory_id').find('option').not(':first').remove();
            $('#bussiness_subcategory_id').attr('required', false);
            $('#subcategory').hide();
        }
    });

    $('#business_keywords').tooltip({'trigger':'focus', 'title': 'Please use as many of keywords , this will help user to find your business during search more visiblility in search result more customer.'});
    $('#house').tooltip({'trigger':'focus', 'title': 'Please input house number or office number only. E.g  45B/ 34 or 46A or 46. Do not include your street address in this box.'});
    $('#key_skills').tooltip({'trigger':'focus', 'title': 'Provide more business/professional skills you have apart from your occupation. It is important to list your skills to enable users connect with you for multiple purposes.'});

    jQuery(document).ready(function () {
        "use strict";
        var options = {};
        options.ui = {
            container: "#pwd-container",
            showVerdictsInsideProgressBar: true,
            viewports: {
                progress: ".pwstrength_viewport_progress"
            }
        };
        options.common = {
            debug: true,
            onLoad: function () {
                $('#messages').text('Start typing password');
            }
        };
        $('#password').pwstrength(options);
    });


    /////////////////////////////////////////////////////////////////////////
        var map;
        var marker;

        function initialize() {

            var mapOptions = {
                center : {lat: 9.072801, lng: 7.402073},
                zoom: 5
            };

            map = new google.maps.Map(document.getElementById('map'),mapOptions);    

            // Get GEOLOCATION
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                    //console.log(pos);
                    map.setCenter(pos);
                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        draggable: false
                    });

                    marker.setIcon( /** @type {google.maps.Icon} */ ({
                        url: "{{ asset('images/map-marker.png') }}",
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(35, 35)
                    }));

                    var geocoder = new google.maps.Geocoder;
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    geocoder.geocode({'location': pos}, function(results, status) { 
                        if (status === 'OK') {
                            if (results[1]) {

                                updateAddress(results,pos,0);
                               /* infowindow.setContent(results[1].formatted_address);
                                infowindow.open(map, marker);
                                marker.setPosition(pos);
                                map.setCenter(pos);*/

                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                }, function() {
                        handleNoGeolocation(true);
                });
            } else {
                    // Browser doesn't support Geolocation
                    handleNoGeolocation(false);
            }

            function handleNoGeolocation(errorFlag) {
                if (errorFlag) {
                    var content = 'Error: The Geolocation service failed.';
                } else {
                    var content = 'Error: Your browser doesn\'t support geolocation.';
                }

                var options = {
                    map: map,
                    position: new google.maps.LatLng(9.072801, 7.402073),
                    content: content
                };

                map.setCenter(options.position);
                marker = new google.maps.Marker({
                    position: options.position,
                    map: map,
                    draggable: false
                });

                marker.setIcon( /** @type {google.maps.Icon} */ ({
                    url: "{{ asset('images/map-marker.png') }}",
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
            }

            // get places auto-complete when user type in location-text-box
            var input = /** @type {HTMLInputElement} */
            (document.getElementById('location-text-box'));

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();

            marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                draggable: false
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function(event) {
                this.setOptions({scrollwheel:true});
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    window.alert('No results found');
                  return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(5); // Why 17? Because it looks good.
                }

                marker.setIcon( /** @type {google.maps.Icon} */ ({
                    url: "{{ asset('images/map-marker.png') }}",
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var address = '';

                //updateAddress(place.address_components,place.geometry.location)
                if (place.address_components) {
                    address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');

                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    infowindow.open(map, marker);

                    var geocoder = new google.maps.Geocoder;
                    geocoder.geocode({'location': place.geometry.location}, function(results, status) {
                        if (status === 'OK') {
                            if (results[1]) {
                                updateAddress(results, place.geometry.location,0);
                                //infowindow.setContent(results[1].formatted_address);
                                //infowindow.open(map, marker);
                            } else {
                                infowindow.close();
                                window.alert('No results found');
                            }
                        } else {
                            infowindow.close();
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                } else {
                    infowindow.close();
                    window.alert('No results found');
                }
            });

            map.addListener('click',function(event) {
            //console.log(marker);
            marker.setIcon( /** @type {google.maps.Icon} */ ({
                url: "{{ asset('images/map-marker.png') }}",
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));

            marker.setVisible(true);
            this.setOptions({scrollwheel:true});
            marker.setPosition(event.latLng);

            var geocoder = new google.maps.Geocoder;
            var latlng = {lat: event.latLng.lat(), lng: event.latLng.lng()};

            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[1]) {
                        updateAddress(results, latlng,1);
                        infowindow.setContent(results[1].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        infowindow.close();
                        window.alert('No results found');
                    }
                } else {
                    infowindow.close();
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        });

        function updateAddress(results,pos,stat) {
            results.forEach(function(x) {/*
                $('#latitude').val();
                $('#longitude').val();*/
                if(jQuery.type( pos.lat ) === "number")
                {
                    $('#latitude').val(pos.lat);
                }else
                {
                    $('#latitude').val(pos.lat());
                }
                if(jQuery.type( pos.lng ) === "number")
                {
                    $('#longitude').val(pos.lng);
                }else
                {
                    $('#longitude').val(pos.lng());
                }
                $.ajax({ url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+$('#latitude').val()+','+$('#longitude').val()+'&sensor=true',
                         success: function(data){
                             //console.log(data.results[0].address_components);
                             var k=0;
                             var l=0;
                             data.results[0].address_components.forEach(function(y) {
                                 /*or you could iterate the components for only the city and state*/
                                 if(k<=9)
                                 {
                                    if($('#location-text-box').val()!="" && stat==0)
                                    {
                                        $('#location-text-box').val($('#location-text-box').val());
                                    }else
                                    {
                                        $('#location-text-box').val(results[0].formatted_address);
                                    }
                                    //console.log(y.types[0]==='country');
                                    if (y.types[0]==='country') {
                                        $('#country').val(y.long_name);
                                        getCurrencyAndCode();
                                    }else
                                    {
                                        //$('#country').val("");
                                    }

                                    if (y.types[0] === 'administrative_area_level_1') {
                                        $('#state').val(y.long_name);
                                    }else
                                    {
                                        //$('#state').val("");
                                    }
                                    if (typeof(y.types[0]) != "undefined" && y.types[0] == 'locality') {
                                        $('#city').val(y.long_name);
                                        $("#city").attr("readonly", true);
                                        l++;
                                    }
                                    if(l==0)
                                    {
                                        $('#city').val("");
                                        $("#city").attr("readonly", false);
                                    }
                                    //console.log(y.types[0]);
                                    //console.log(y.long_name);
                                    if (y.types[0] == 'postal_code') {
                                        $("#pin_code").val(y.long_name);
                                    }
                                }else
                                {
                                    return 0;
                                }
                                k++;
                            });
                         }
                });
                
            });
            
            $("#register-form").data('bootstrapValidator').resetForm();
            }
        }
    </script>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAVusRctxw1eB0esgPlwglfML6zWrAVj9A&libraries=places&callback=initialize" async defer></script>   

@endsection
