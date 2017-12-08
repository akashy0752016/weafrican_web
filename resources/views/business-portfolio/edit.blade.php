@extends('layouts.app')
@section('title', $pageTitle)

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fineuploader/fine-uploader.css') }}"/>
    <link href="{{ asset('css/lightgallery/lightgallery.css')}}" rel="stylesheet">
    <style>
        .list-unstyled>li.featured_image{
            display: block;
        }
        .list-unstyled>li{
        display:none;
    }
    </style>
@endsection

@section('content')
<div class="container row_pad">
    <div class="col-md-12">
    <div class="row">
        <h5 class="text-left">Edit Business Portfolio</h5>
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
        <div class="panel panel-default document table_set">
            <form id="register-form" class="form-horizontal" action="{{ url('portfolio/'.$businessPorfolio->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="col-md-12">
                <div class="row">
                    <label for="maritial_status" class="col-md-2 control-label required">Marital Status:</label>
                    <div class="col-md-4 form-group">
                        <select name="maritial_status" id="maritial_status" class="form-control selectpicker">
                           <option value="">Select One</option>
                           <option @if($businessPorfolio->maritial_status=="married") selected="selected" @endif value="married">Married</option>
                           <option @if($businessPorfolio->maritial_status=="single") selected="selected" @endif value="single">Single</option>
                           <option @if($businessPorfolio->maritial_status=="divorced") selected="selected" @endif value="divorced">Divorced</option>
                           <option @if($businessPorfolio->maritial_status=="separated") selected="selected" @endif value="separated">Separated</option>
                        </select>
                        @if ($errors->has('maritial_status'))
                            <span class="help-block">
                            <strong>{{ $errors->first('maritial_status') }}</strong>
                            </span>
                        @endif
                    </div>
                    <label for="occupation" class="col-md-2 control-label required">Occupation:</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" value="{{$businessPorfolio->occupation}}" name="occupation" id="occupation">
                        @if ($errors->has('occupation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('occupation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="acadmic" class="col-md-2 control-label">Academic Status:</label>
                    <div class="col-md-4 form-group">
                        <select name="acedimic_status" id="acedimic_status" class="form-control selectpicker">
                           <option value="">Select One</option>
                           <option @if($businessPorfolio->acedimic_status=="10") selected="selected" @endif value="10">10</option>
                           <option @if($businessPorfolio->acedimic_status=="10+2") selected="selected" @endif value="10+2">10+2</option>
                           <option @if($businessPorfolio->acedimic_status=="Diploma") selected="selected" @endif value="Diploma">Diploma</option>
                           <option @if($businessPorfolio->acedimic_status=="Graduate") selected="selected" @endif value="Graduate">Graduate</option>
                           <option @if($businessPorfolio->acedimic_status=="Post Graduate") selected="selected" @endif value="Post Graduate">Post Graduate</option>
                        </select>
                        @if ($errors->has('acedimic_status'))
                            <span class="help-block">
                            <strong>{{ $errors->first('acedimic_status') }}</strong>
                            </span>
                        @endif
                    </div>
                
                    <label for="key_skills" class="col-md-2 control-label required">Key Skills:</label>
                    <div class="col-md-4 form-group">
                        <input type="text" class="form-control" name="key_skills" value="{{$businessPorfolio->key_skills}}" id="key_skills">
                        @if ($errors->has('key_skills'))
                            <span class="help-block">
                            <strong>{{ $errors->first('key_skills') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @if($category_check==1)
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Experience</label>
                        <div class="col-md-2 form-group">
                            <select class="form-control" id="experience_years" name="experience_years">
                                <option value="">Select Years</option>
                                @for($i=0;$i<=30;$i++)
                                    <option @if($businessPorfolio->experience_years==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('experience_years'))
                                <span class="help-block">
                                <strong>{{ $errors->first('experience_years') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" id="experience_months" name="experience_months">
                                <option value="">Select Months</option>
                                @for($i=0;$i<=12;$i++)
                                    <option @if($businessPorfolio->experience_months==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('experience_months'))
                                <span class="help-block">
                                <strong>{{ $errors->first('experience_months') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="name" class="col-md-2 required control-label">Height</label>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="height_feets">
                                <option value="">Feets</option>
                                @for($i=0;$i<=30;$i++)
                                    <option @if($businessPorfolio->height_feets==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('height_feets'))
                                <span class="help-block">
                                <strong>{{ $errors->first('height_feets') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control" name="height_inches">
                                <option value="">inches</option>
                                @for($i=0;$i<=12;$i++)
                                    <option @if($businessPorfolio->height_inches==$i) selected="selected" @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @if ($errors->has('height_inches'))
                                <span class="help-block">
                                <strong>{{ $errors->first('height_inches') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Hair type</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="hair_type">
                                <option value="">Select Hair type</option>
                                <option @if($businessPorfolio->hair_type=="Long") selected="selected" @endif value="Long">Long</option>
                                <option @if($businessPorfolio->hair_type=="Medium") selected="selected" @endif value="Medium">Medium</option>
                                <option @if($businessPorfolio->hair_type=="Short") selected="selected" @endif value="Short">Short</option>
                                <option @if($businessPorfolio->hair_type=="Curly") selected="selected" @endif value="Curly">Curly</option>
                                <option @if($businessPorfolio->hair_type=="Bald") selected="selected" @endif value="Bald">Bald</option>
                            </select>
                            @if ($errors->has('hair_type'))
                                <span class="help-block">
                                <strong>{{ $errors->first('hair_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="category" class="col-md-2 required control-label">Hair Colour</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="hair_color">
                                <option value="">Select Hair Color</option>
                                <option @if($businessPorfolio->hair_color=="Red") selected="selected" @endif value="Red">Red</option>
                                <option @if($businessPorfolio->hair_color=="Black/Brown") selected="selected" @endif value="Black/Brown">Black/Brown</option>
                                <option @if($businessPorfolio->hair_color=="Blonde") selected="selected" @endif value="Blonde">Blonde</option>
                                <option @if($businessPorfolio->hair_color=="Silver/Grey") selected="selected" @endif value="Silver/Grey">Silver/Grey</option>
                                <option @if($businessPorfolio->hair_color=="Coloured") selected="selected" @endif value="Coloured">Coloured</option>
                            </select>
                            @if ($errors->has('hair_color'))
                                <span class="help-block">
                                <strong>{{ $errors->first('hair_color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="category" class="col-md-2 required control-label">Skin Colour</label>
                        <div class="col-md-4 form-group">
                            <select class="form-control" name="skin_color">
                                <option value="">Select Hair type</option>
                                <option @if($businessPorfolio->skin_color=="Light") selected="selected" @endif value="Light">Light</option>
                                <option @if($businessPorfolio->skin_color=="Dusky") selected="selected" @endif value="Dusky">Dusky</option>
                                <option @if($businessPorfolio->skin_color=="Wheatish") selected="selected" @endif value="Wheatish">Wheatish</option>
                                <option @if($businessPorfolio->skin_color=="Mix") selected="selected" @endif value="Mix">Mix</option>
                            </select>
                            @if ($errors->has('skin_color'))
                                <span class="help-block">
                                <strong>{{ $errors->first('skin_color') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="checkbox" class="col-md-2 control-label">Professional Training </label>
                        <div class="col-md-10 form-group">
                            <input name="professional_training" id="professional_training" value="1" type="checkbox" @if($businessPorfolio->professional_training==1) checked="checked" @endif > I have professional training from institute
                            @if ($errors->has('professional_training'))
                                <span class="help-block">
                                <strong>{{ $errors->first('professional_training') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row" id="institute" @if($businessPorfolio->professional_training!=1) style="display: none;" @endif >
                        <label for="checkbox" class="col-md-2 required control-label">Institute Name</label>
                        <div class="col-md-4 form-group">
                            <input type="text" id="institute_name" data-bv-notempty="false" class="form-control" required="required" name="institute_name" value ="{{ $businessPorfolio->institute_name }}">
                            @if ($errors->has('institute_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('institute_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-right ">
                        <button type="submit" class="btn btn-primary">
                        Submit
                        </button>
                    </div>
                </div>
                </form>
                <div class="portfolio_head">
                    <legend>Portfolio Image</legend>
                </div>
                <!-- Basic User Condition -->
                @if(Auth::user()->user_role_id == 3 && count($portfolio_images) == 5)
                    <p class="text-left">You have created all portfolio's.</p> 
                @endif
                @if(Auth::user()->user_role_id == 3 && count($portfolio_images) < 5)
                    <p class="text-left">You can create Upto 5 portfolio's. You have {{5-count($portfolio_images)}} portfolio left.</p> 
                @endif
                <!-- Premium User Condition -->
                @if(Auth::user()->user_role_id == 5)
                    <p class="text-left">You can creat unlimited portfolio's.</p> 
                @endif
                <!-- Add portfolio condition for basic and premium user -->
                <div class="text-right add-button">
                @if(Auth::user()->user_role_id == 3 && count($portfolio_images) < 5)
                    <a type="button" class="btn btn-info" href="{{ url('portfolio/create')}}">Add Portfolio</a>
                @endif
                @if(Auth::user()->user_role_id == 5)
                    <a type="button" class="btn btn-info" href="{{ url('portfolio/create')}}">Add Portfolio</a>
                @endif
                </div>

                <div class="panel panel-default table_set">
                <div class="all_content">
                    <table class="table portfolio_table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if(isset($portfolio_images) and count($portfolio_images)>0)
                                @foreach($portfolio_images as $key => $portfolio)
                                <tr>
                                <td>

                                <div class="demo-gallery"> 
                                @if(isset($portfolio->featured_image) && $portfolio->featured_image != null)
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#lightgallery-{{++$key+1}}').lightGallery();
                                        });
                                    </script>
                                    <ul id="lightgallery-{{++$key}}" class="list-unstyled row">
                                    
                                    @foreach($portfolio->images() as $key => $image)
                                        @if($portfolio->featured_image == $image)
                                        <li class="col-xs-6 col-sm-4 col-md-3 featured_image" data-responsive="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$portfolio->title}}</h4><p>{{$portfolio->description}}</p>">
                                            <img class="img-responsive" src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}">
                                              <i title="view image" class="fa fa-arrow-circle-o-right fa-lg" aria-hidden="true"></i>
                                        </li>
                                        @else
                                        <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$portfolio->title}}</h4><p>{{$portfolio->description}}</p>">
                                            <img class="img-responsive" src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}">
                                        </li>
                                        @endif
                                    @endforeach
                                   

                                    </ul>
                                    
                                     @else
                                    No Image found
                                    @endif
                                </div>
                                
                                </td>

                                <td>{{ $portfolio->title }}</td>
                                <td>{{ $portfolio->description }}</td>
                                <td><ul class="list-inline portfolio_list">
                                <li>
                                    <a href="{{url('portfolio/'.$portfolio->id.'/edit')}}"><button type="button" class="btn btn-default btn_fix" title="Edit Portfolio"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <form action="{{url('portfolio/'.$portfolio->id)}}" method="POST" onsubmit="deletePortfolio('{{$portfolio->id}}', '{{$portfolio->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Portfolio"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </li>
                            <ul></td>
                                </tr>
                                @endforeach    
                            @else
                                <tr>
                                    <td>No data found !</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
            </div>
        </div>
                
            
        </div>
        </div>
    </div>
    <!-- Light Box -->
<div id="myModal" class="modal">
</div>
<!--  -->
</div>




@endsection
@section('header-scripts')
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{ asset('js/lightgallery/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('js/lightgallery/lib/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css">
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    $(document).ready(function() {

        $('.table').DataTable({
            responsive: true
        });
        $('.table').css("width","100%");

        // The maximum number of options
        var MAX_OPTIONS = 5;
        $('#register-form').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                maritial_status: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Maritial Status.'
                        }
                    }
                },acedimic_status: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Academic.'
                        }
                    }
                },
                experience_years: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Exp. Year.'
                        }
                    }
                },
                experience_months: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Exp. months.'
                        }
                    }
                },
                height_feets: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Your Height in feets.'
                        }
                    }
                },
                height_inches: {
                    validators: {
                        notEmpty: {
                            message: 'Please select Your Height in inches.'
                        }
                    }
                },
                hair_type: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your hair type.'
                        }
                    }
                },
                hair_color: {
                    validators: {
                        notEmpty: {
                            message: 'Please select hair color'
                        }
                    }
                },
                skin_color: {
                    validators: {
                        notEmpty: {
                            message: 'Please select skin color.'
                        }
                    }
                },
                institute_name: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter your Institute Name'
                        }
                    }
                },
                occupation: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter your Occupation'
                        }
                    }
                },
                key_skills: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter your Key Skills'
                        }
                    }
                },
            }
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'portfolio_title[]') {
                if ($('#register-form').find(':visible[name^="portfolio_title["]').length >= MAX_OPTIONS) {
                    $('#register-form').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'portfolio_title[]') {
                if ($('#register-form').find(':visible[name^="portfolio_title["]').length < MAX_OPTIONS) {
                    $('#register-form').find('.addButton').removeAttr('disabled');
                }
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template);

            // Add new fields
            // Note that we DO NOT need to pass the set of validators
            // because the new field has the same name with the original one
            // which its validators are already set
            $("#featured_image option:not(:first)").remove();
            for(var i=1; i<=$('#register-form').find(':visible[name^="portfolio_title["]').length; i++)
            {
                $('#featured_image').append('<option value="'+i+'">'+i+'</option>');
            }
            $('#register-form')
                .formValidation('addField', $clone.find('[name="portfolio_image[]"]'))
                .formValidation('addField', $clone.find('[name="portfolio_title[]"]'))
                .formValidation('addField', $clone.find('[name="portfolio_description[]"]'))
                .formValidation('revalidateField', 'featured_image');
            var i=1;
            /*$('.featured_image').each(function(){
                if ($('#register-form').find(':visible[name=^"portfolio_title["]').length < MAX_OPTIONS) {
                    var $row = $(this).closest('.form-group');
                    $row.find('[name="featured_image"]').attr('value',i);
                    i++;
                }
            });*/
            /*$('#register-form').formValidation('revalidateField', 'featured_image');*/
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row = $(this).closest('.form-group');

            // Remove fields
            $('#register-form')
                .formValidation('removeField', $row.find('[name="portfolio_image[]"]'))
                .formValidation('removeField', $row.find('[name="portfolio_title[]"]'))
                .formValidation('removeField', $row.find('[name="portfolio_description[]"]'))
                .formValidation('revalidateField', 'featured_image');

            // Remove element containing the fields
            $row.remove();
            var i=1;
            /*$('.featured_image').each(function(){
                if ($('#register-form').find(':visible[name^="portfolio_title["]').length < MAX_OPTIONS) {
                    var $row = $(this).closest('.form-group');
                    $row.find('[name="featured_image"]').attr('value',i);
                    i++;
                }
            });*/
            /*$('#register-form').formValidation('revalidateField', 'featured_image');*/
        })
        .on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        });

        $('#institute')[$("#professional_training").is(':checked') ? "show" : "hide"]();
        if ($("#professional_training").is(':checked')){
            $('#register-form').formValidation('enableFieldValidators', 'institute_name', true);
        }else
        {
            $('#register-form').formValidation('enableFieldValidators', 'institute_name', false);
        }
        
    });

    $('#professional_training').click(function() {
      $('#institute')[this.checked ? "show" : "hide"]();
      if(this.checked)
      {
        $('#institute_name').val("");
        $('#register-form').formValidation('enableFieldValidators', 'institute_name', true);
      }else
      {
        $('#institute_name').val("");
        $('#register-form').formValidation('enableFieldValidators', 'institute_name', false);
      }
       
    });

    function deletePortfolio(id, title, event,form) {   
    
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You want to delete "+title,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel pls!",
            closeOnConfirm: false,
            closeOnCancel: false,
            allowEscapeKey: false,
        },
        function(isConfirm){
            if(isConfirm) {
                $.ajax({
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    type: 'DELETE',
                    success: function(data) {
                        data = JSON.parse(data);
                        if(data['status']) {
                            swal({
                                title: data['message'],
                                text: "Press ok to continue",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false,
                                allowEscapeKey: false,
                            },
                            function(isConfirm){
                                if(isConfirm) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            swal("Error", data['message'], "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", title+"'s record will not be deleted.", "error");
            }
        });
    }
    

</script>
@endsection