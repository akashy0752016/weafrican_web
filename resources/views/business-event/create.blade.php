@extends('layouts.app')
@section('title', $pageTitle)
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
@endsection
@section('content')
<div class="container row_pad">
    <div class="col-md-12">
    <div class="row">
        <h5 class="text-left">Add Event</h5>
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
            <form id="register-form" class="form-horizontal" action="{{ url('business-event') }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="col-md-12">
                 <div class="row">
                    <label class="col-md-2 control-label required">Select Category:</label>
                    <div class="col-md-4 form-group">
                        <select required name="event_category_id" class="form-control" required>
                            <option value="" selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" >{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('event_category_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('event_category_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label required"> Name of Event</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="name" placeholder="Event Name" value="{{ old('name') }}" required>
                        @if($errors->has('name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Event Keywords</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" placeholder="Event Keywords" name="keywords" value="{{ old('keywords') }}" id="keywords" required>
                        @if($errors->has('keywords'))
                            <span class="help-block">
                            <strong>{{ $errors->first('keywords') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label">Organizer Name</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" placeholder="Organizer Name" name="organizer_name" value="{{ $business->title or old('organizer_name')}}" required>
                        @if($errors->has('organizer_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('organizer_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Description</label>
                    <div class="col-md-10 form-group">
                        <textarea required class="form-control" placeholder="Description" name="description"></textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Event Start Date</label>
                    <div class="col-md-4 form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" id='datetimepicker1' name="start_date_time" value="{{ old('start_date_time') }}" />
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        @if($errors->has('start_date_time'))
                            <span class="help-block">
                            <strong>{{ $errors->first('start_date_time') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label">Event End Date</label>
                    <div class="col-md-4 form-group">
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' class="form-control" id='datetimepicker2' name="end_date_time" value="{{ old('end_date_time')}}" />
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                        @if($errors->has('end_date_time'))
                            <span class="help-block">
                            <strong>{{ $errors->first('end_date_time') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Location:</label>
                        <div class="col-md-10 map_location">
                        <div class="row">
                            <!-- <input type="text" class="form-control" id="location-text-box" placeholder="Serech Location" /> -->
                            <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="latitude" class="form-control" name="latitude" value ="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" class="form-control" name="longitude" value ="{{ old('longitude') }}">
                 <div class="row">
                    <label class="col-md-2 required control-label">Street Address</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" id="location-text-box" name="address" value="{{ old('address')}}" placeholder="Search Your Location" required>
                        @if($errors->has('address'))
                            <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 required control-label">House No./Block No.:</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" placeholder="House No./Block No." id="house" name="house" value="{{ old('house')}}" required>
                        @if($errors->has('house'))
                            <span class="help-block">
                            <strong>{{ $errors->first('house') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                  <div class="row">
                        <label class="col-md-2 control-label required">City:</label>
                        <div class="col-md-4 form-group ">
                            <input type="text" class="form-control" placeholder="City" id="city" name="city" value="{{ old('city') }}">
                            @if ($errors->has('city'))
                                <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-md-2 required control-label">State:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" placeholder="State" id="state" name="state" value="{{ old('state') }}">
                            @if ($errors->has('state'))
                                <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                      <div class="row">
                        <label class="col-md-2 control-label required">Country:</label>
                        <div class="col-md-4 form-group">
                            <input type="text" class="form-control" placeholder="Country" id="country" name="country" value="{{ old('country') }}">
                            @if ($errors->has('country'))
                                <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="col-md-2 required control-label">Pin Code: (format:110075)</label>
                        <div class="col-md-4 form-group">
                            <input required type="text" pattern="" placeholder="PinCode" id="pin_code" class="form-control" name="pin_code" value="{{ old('pin_code') }}">
                            @if ($errors->has('pin_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('pin_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                 <div class="row">
                    <label class="col-md-2 required control-label">Banner Image</label>
                    <div class="col-md-4 form-group banner_upld">
                        <label class="btn-bs-file btn btn-info">Browse
                        <input type="file" name="banner" id="banner" required accept="image/jpg,image/jpeg,image/png">
                        </label>
                        @if($errors->has('banner'))
                            <span class="help-block">
                            <strong>{{ $errors->first('banner') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label class="col-md-2 control-label">Banner Preview</label>
                    <div class="col-md-4">
                    <div class="profile_img">
                        <img src="{{asset('images/no-image.jpg')}}" alt=""  id="preview">
                    </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 required control-label">Event Type</label>
                    <div class="col-md-4 form-group ">
                        <input type="radio" name="eventType" id="eventType" value="free" checked>Free
                        <input type="radio" name="eventType" id="eventType" value="paid">Paid
                    </div>
                    <div class="col-md-12" style="margin-bottom: 20px;">Note: Setting the plan type to 'Free' is permanent. You cannot change it back to 'Paid' again after submission.</div>
                </div>

                @if(count(Auth::user()->account) > 0)
                @else
                 <div class="bank-details" id="bank-details">
                     For paid event please enter your bank details. Then only you can enter ticket price.
                     <a href="{{ url('account-details') }}" class="btn btn-success">Add Bank Details</a>
                 </div>
                @endif

                <div class="paid" id="paidEvent">
                <fieldset>
                    <legend>Event Seating Plan</legend>
                </fieldset>
                
                <div class="col-md-12" style="margin-bottom: 20px;">Please add your Seating plans if have any, cause once the event is created you will not be able to add or update seating plans.</div>
                <div class="col-md-12">
                <div class="row">
                <div class="form-group touchspin_input">
                    <label class="col-md-3 control-label">Total Number Of Seats</label>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input type="text" value="" placeholder="Total Number Of Seats" name="total_seats" id="total_seats" class="form-control input-sm">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                <div class="row">
                @if(count($seatingplans)>0)
                    @foreach($seatingplans as $seatingplan)
                        <div class="form-group colm_margin">
                            <div class="col-md-3">
                                <div class="checkbox">
                                  <label class="control-label"><input type="checkbox" id="seating_plan_id_{{$seatingplan->id}}" disabled="disabled" value="">{{ $seatingplan->title }}</label>
                                </div>
                            </div>
                            <div class="col-md-3" class="control-label">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="seating_plan_alias[{{ $seatingplan->id }}]" disabled="disabled" value="{{ $seatingplan->title }}" placeholder="Seating Plan Alias">
                                <span class="input-group-addon">Plan Alias</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" disabled="disabled" value="" name="seating_plan[{{ $seatingplan->id }}]" id="seating_plan[{{ $seatingplan->id }}]" class="form-control input-sm seatingplan_touchspin">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" disabled="disabled" class="form-control seatingplan_price" name="seating_plan_price[{{ $seatingplan->id }}]" placeholder="Per Ticket Price">
                                    <span class="input-group-addon">Price (in NGN)</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
                </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                        Publish
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('header-scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}">
    <script src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    
   
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
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
    
    $("#banner").change(function(){
        readURL(this);
    });

    //Bootstarp validation on form
        $(document).ready(function() {
            $('#paidEvent').hide();
            $('#bank-details').hide();
            $('#register-form #eventType').on('change', function() {
                if ($('input[name=eventType]:checked', '#register-form').val() == "paid"){
                    @if(count(Auth::user()->account) > 0)
                        $('#paidEvent').show();
                    @else
                        $('#bank-details').show();
                    @endif
                } else {
                    $('#paidEvent').hide();
                }
            });

            $('#datetimepicker1').datetimepicker({
                minDate: new Date(),
            });
            $('#datetimepicker2').datetimepicker({
                minDate: new Date(),
            });

            $("#datetimepicker1").on("dp.change", function (e) {
                $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
                $('#register-form').data('bootstrapValidator').resetForm();
                $('#register-form').bootstrapValidator('revalidateField', $("#datetimepicker1"));
            });
            $("#datetimepicker2").on("dp.change", function (e) {
                //$('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
                $('#register-form').data('bootstrapValidator').resetForm();
                $('#register-form').bootstrapValidator('revalidateField', $("#datetimepicker2"));
            });
            $('#register-form').bootstrapValidator({
                // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                                stringLength: {
                                min: 5,
                            },
                                notEmpty: {
                                message: 'Please fill your Event name'
                            }
                        }
                    },
                    house: {
                        validators: {
                            stringLength: {
                                max: 8,
                                message: 'House number should be max 8 char in length'
                            },
                            notEmpty: {
                                message: 'Please supply your house number'
                            }
                        }
                    },
                    keywords: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your event keywords'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event Description'
                            }
                        }
                    },
                    start_date_time: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event Start Time'
                            },
                            date: {
                                format: 'MM/DD/YYYY h:m A',
                                message: 'The value is not a valid date'
                            }
                        }
                    },
                    end_date_time: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your Event End Time'
                            },
                            date: {
                                format: 'MM/DD/YYYY h:m A',
                                message: 'The value is not a valid date'
                            }
                        }
                    },
                    city: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your city'
                            },
                            regexp: {
                                regexp: /^[ A-Za-z_@./#&+-]*$/,
                                message: 'The city name should only contain alphabets'
                            },
                            
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
                    pin_code: {
                        validators: {
                            notEmpty: {
                                message: 'Please supply your pin code'
                            }
                        }
                    },
                    total_seats:
                    {
                        validators:{
                            callback: {
                                message: 'The sum of all the seats in seating plan must be equal to Total Seats',
                                callback: function(value, validator, $field) {
                                    var total = 0;
                                    $(".seatingplan_touchspin").each(function() {
                                        if($(this).val()!="")
                                        {
                                            total = total + parseInt($(this).val());
                                        }else
                                        {
                                            total = total + 0;
                                        }
                                    });
                                    if (total === parseInt($("#total_seats").val())) {
                                        /*validator.updateStatus(total_seats, 'VALID', 'callback');*/
                                        return true;
                                    }
                                    return false;
                                }
                            }
                        }
                    },
                    @if(count($seatingplans)>0)
                        @foreach($seatingplans as $seatingplan)
                            'seating_plan_price[{{$seatingplan->id}}]':{
                                validators: {
                                    notEmpty: {
                                        message: 'Please supply your Per Ticket Price'
                                    },
                                    numeric: {
                                        message: 'The price must be a number'
                                    }
                                }
                            },
                            'seating_plan_alias[{{$seatingplan->id}}]':{
                                validators: {
                                    notEmpty: {
                                        message: 'Please supply your Per Ticket Price'
                                    }
                                }
                            },
                        @endforeach
                    @endif
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
            var bootstrapValidator = $('#register-form').data('bootstrapValidator');
            bootstrapValidator.enableFieldValidators('total_seats', false);
            @if(count($seatingplans)>0)
                @foreach($seatingplans as $seatingplan)
                bootstrapValidator.enableFieldValidators('seating_plan_price[{{$seatingplan->id}}]', false);
                @endforeach
            @endif
            $("input[name='total_seats']").TouchSpin({
                postfix: "Seats",
                postfix_extraclass: "btn btn-default",
                min: 0,
                max: 5000,
                step: 1,
            }).on('change touchspin.on.min touchspin.on.max',function(e){
                if($(this).val()=="" || parseInt($(this).val())==0)
                {
                    $('input[id^="seating_plan_id_"]').each(function(i){
                        $(this).removeAttr('checked');
                        var input = $(this).attr("id");
                        $('input[id="'+input+'"]').attr('disabled','disabled');
                    });
                   $('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_alias[')>-1))
                       {
                            $('input[name="'+input+'"]').val("");
                       }
                       $('input[name="'+input+'"]').attr('disabled','disabled');
                       $('i[data-bv-icon-for="'+input+'"]').css('display', 'none');
                       $('small[data-bv-validator-for="'+input+'"]').css('display', 'none');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-error');
                       $('input[name="'+input+'"]').closest( 'div[class^="form-group"]' ).removeClass('has-success');

                    });
                    bootstrapValidator.enableFieldValidators('total_seats', false);
                }else
                {
                    $('input[id^="seating_plan_id_"]').each(function(i){
                        var input = $(this).attr("id");
                        if(!(input.indexOf('seating_plan_price[')>-1))
                        {
                            $('input[id="'+input+'"]').removeAttr('disabled');
                        }
                    });
                    /*$('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_price[')>-1))
                       {
                            $('input[name="'+input+'"]').removeAttr('disabled');
                       }
                    });*/
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }
                //$('#register-form').bootstrapValidator('validateField', 'total_seats');
            }).end();
            $(".seatingplan_touchspin").TouchSpin({
                postfix: "Seats",
                postfix_extraclass: "btn btn-default",
                min: 0,
                max: 5000,
                step: 1,
            }).on('change touchspin.on.min touchspin.on.max', function(e) {
                var row  = $(this).parents('.form-group');
                var name = $(this).parent().parent().parent().find('.seatingplan_price').attr('name');
                if($(this).val()!="" && parseInt($(this).val())!==0)
                {
                    $('input[name="'+name+'"]').removeAttr('disabled');
                    bootstrapValidator.enableFieldValidators(name, true);
                }else
                {
                    $('input[name="'+name+'"]').val("");
                    $('input[name="'+name+'"]').attr('disabled','disabled');
                    bootstrapValidator.enableFieldValidators(name, false);
                }
                bootstrapValidator.enableFieldValidators('total_seats', true);
            }).end();
        
            $('input[id^="seating_plan_id_"]').click(function(e){
                if($(this).is(':checked'))
                {
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan_alias"]').removeAttr('disabled');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan["]').removeAttr('disabled');
                    /*$('input[name^="seating_plan"]').each(function(i){
                       var input = $(this).attr("name");
                       if(!(input.indexOf('seating_plan_price[')>-1))
                       {
                            $('input[name="'+input+'"]').removeAttr('disabled');
                       }
                    });*/
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }else
                {
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan["]').val('');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan_price["]').val('');
                    $(this).closest('div[class^="form-group"]').find('input[name^="seating_plan"]').attr('disabled','disabled');
                    /*$(this).closest('i[data-bv-icon-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest('small[data-bv-validator-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest('input[name="seating_plan_price["]').closest( 'div[class^="form-group"]' ).removeClass('has-error');*/
                    $(this).closest( 'div[class^="form-group"]' ).removeClass('has-success');
                    $(this).closest( 'div[class^="form-group"]' ).removeClass('has-error');
                    $(this).closest( 'div[class^="form-group"]' ).find('i[data-bv-icon-for^="seating_plan_price["]').css('display', 'none');
                    $(this).closest( 'div[class^="form-group"]' ).find('small[data-bv-validator-for^="seating_plan_price["]').css('display', 'none');
                    bootstrapValidator.enableFieldValidators('total_seats', true);
                }
            });
        });
    $('#keywords').tooltip({'trigger':'focus', 'title': 'Please use as many of keywords , this will help user to find your event during search more visiblility in search result more customer.'});
    $('#house').tooltip({'trigger':'focus', 'title': 'Please input house number or office number only. E.g  45B/ 34 or 46A or 46. Do not include your street address in this box.'});

    /////////////////////////////////////////////////////////////////////////
    var map;
        var marker;

        function initialize() {
          var mapOptions = {
            zoom: 5
          };
          map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

          // Get GEOLOCATION
          
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);
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

                        updateAddress(results,pos,1);
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
            (
              document.getElementById('location-text-box'));


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

            }else
            {
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
        //Update Address input fields
        //console.log(results);
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
                         var k=0;
                         var l=0;
                         /*console.log(data.results[0]);*/
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
                                    /*getCurrencyAndCode();*/
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
                                    l++;
                                }
                                if(l==0)
                                {
                                    $('#city').val("");
                                }

                                if (y.types[0] == 'postal_code') {
                                    $("#pin_code").val(y.long_name);
                                }
                            }else
                            {
                                return 0;
                            }
                            k++;
                            //return false;
                        });
                     }
            });
        });
        
        
        $("#register-form").data('bootstrapValidator').resetForm();
        //$('#location-text-box').val("");
    }



        }

        //google.maps.event.addDomListener(window, 'load', initialize);

</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVusRctxw1eB0esgPlwglfML6zWrAVj9A&libraries=places&callback=initialize" async defer></script>
<style>
#register-form .touchspin_input .form-control-feedback {
    right: -15px;
}
</style>
@endsection
