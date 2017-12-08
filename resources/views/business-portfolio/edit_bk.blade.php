@extends('layouts.app')
@section('title', $pageTitle)
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"/>
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
                <div class="portfolio_head">
                    <legend>Portfolio Image</legend>
                </div>
                @if(count($portfolio_images)>0)
                @foreach($portfolio_images as $key => $portfolio_image)
                    @if($key==0)
                        <div class="form-group colm_margin">
                            <input type="hidden" class="portfolio_image_id" name="portfolio_image_id[]" value="{{$portfolio_image->id}}">

                            <div class="col-md-1 col-sm-1 col-xs-6">
                            <label class="control-label">Upload Image</label>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 has-feedback">
                                <label class="btn-bs-file btn btn-info">Browse
                                <input type="file" class="form-control portfolio_image" accept="image/*" name="portfolio_image[{{$portfolio_image->id}}]" value="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'.$portfolio_image->image) }}" 
                                onchange="previewImg(this)" />
                                </label>

                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 ">
                            <div class="profile_img">
                                <img src="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'.$portfolio_image->image) }}" alt="" id="preview">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 ">
                                <input type="text" class="form-control" name="portfolio_title[{{$portfolio_image->id}}]" placeholder="Title" value="{{$portfolio_image->title}}" />
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input type="text" class="form-control" name="portfolio_description[{{$portfolio_image->id}}]" placeholder="Description" value="{{$portfolio_image->description}}" />
                            </div>
                            <!-- <div class="col-md-2 col-sm-2 col-xs-6">
                                <div class="radio">
                                  <label><input type="radio" class="featured_image" name="featured_image" @if($portfolio_image->featured_image==1) checked="checked" @endif value="{{$key+1}}" />Featured Image</label>
                                </div>
                            </div> -->
                            <div class="col-md-1 col-sm-1 col-xs-6">
                                <button type="button" class="btn btn-default addButton">Add more images</button>
                            </div>
                        </div>
                    @else
                        <div class="form-group colm_margin">

                            <input type="hidden" class="portfolio_image_id" name="portfolio_image_id[]" value="{{$portfolio_image->id}}">
                            <div class="col-md-1 col-sm-1 col-xs-6">
                            <div class="upld_hide">
                            <label class="control-label">Upload Image</label>
                            </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <label class="btn-bs-file btn btn-info">Browse
                                <input type="file" class="form-control portfolio_image" accept="image/*" name="portfolio_image[{{$portfolio_image->id}}]" value="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'.$portfolio_image->image) }}" onchange="previewImg(this)" />
                                </label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <div class="profile_img">
                                <img src="{{ asset(config('image.portfolio_image_url').'thumbnails/small/'.$portfolio_image->image) }}" alt="" id="preview">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <input type="text" class="form-control" name="portfolio_title[{{$portfolio_image->id}}]" placeholder="Title" value="{{$portfolio_image->title}}" />
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <input type="text" class="form-control" name="portfolio_description[{{$portfolio_image->id}}]" placeholder="Description" value="{{$portfolio_image->description}}" />
                            </div>
                            <!-- <div class="col-md-2 col-sm-2 col-xs-6">
                                <div class="radio">
                                  <label><input type="radio" class="featured_image" name="featured_image" @if($portfolio_image->featured_image==1) checked="checked" @endif value="{{$key+1}}" />Featured Image</label>
                                </div>
                            </div> -->
                            <div class="col-md-1 col-sm-1 col-xs-6">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>

                        </div>
                    @endif
                @endforeach
                @else
                    <div class="form-group colm_margin">
                    <div class="col-md-1 col-sm-1 col-xs-6">
                        <div class="upld_hide">
                        <label class="control-label">Upload Image</label>
                        </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 portfolio_upld_btn">
                            <label class="btn-bs-file btn btn-info">Browse
                            <input type="file" class="form-control" accept="image/*" name="portfolio_image[]" onchange="previewImg(this)" />
                            </label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="profile_img">
                            <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <input type="text" class="form-control" name="portfolio_title[]" placeholder="Title" />
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <input type="text" class="form-control" name="portfolio_description[]" placeholder="Description" />
                        </div>
                        <!-- <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="radio">
                              <label><input type="radio" class="featured_image" name="featured_image" checked="checked" value="1" /><br>Featured Image</label>
                            </div>
                        </div> -->
                        <div class="col-md-1 col-sm-1 col-xs-6">
                            <button type="button" class="btn btn-default addButton">Add more images</button>
                        </div>
                    </div>
                @endif
                <!-- The template for adding new field -->
                <div class="form-group hide colm_margin" id="bookTemplate">
                <div class="col-md-1 col-sm-1 col-xs-6">
                <div class="upld_hide">
                        <label class="control-label">Upload Image</label>
                        </div>
                        </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <label class="btn-bs-file btn btn-info">Browse
                        <input type="file" class="form-control portfolio_image" accept="image/*" name="portfolio_image[]" onchange="previewImg(this)" />
                        </label>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="profile_img">
                        <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <input type="text" class="form-control" name="portfolio_title[]" placeholder="Title" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <input type="text" class="form-control" name="portfolio_description[]" placeholder="Description" />
                    </div>
                    <!-- <div class="col-md-2 col-sm-2 col-xs-6">
                        <div class="radio">
                          <label><input type="radio" class="featured_image" name="featured_image" value="1" />Featured Image</label>
                        </div>
                    </div> -->
                    <div class="col-md-1 col-sm-1 col-xs-6">
                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
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
@endsection
@section('header-scripts')
<style type="text/css">
    .mb-1 {margin-bottom: 20px;}
</style>
    <script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datepicker/bootstrap-datetimepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css">
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript">

    function previewImg(img)
    {
        var id = img.id[img.id.length -1];
        if (img.files && img.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(img).closest('.form-group').find("img").attr('src', e.target.result);
            }
            reader.readAsDataURL(img.files[0]);
        }
    }

    $(document).ready(function() {
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
                'portfolio_image[]': {
                    row: '.col-xs-3',
                    validators: {
                        notEmpty: {
                            message: 'Please choose a product image'
                        },
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpg,image/png,image/x-png,image/x-jpg,image/jpeg',
                            maxSize: 10 * 1024 * 1024, // 2048 * 1024
                            message: 'Please choose a image file with a size less than 10M.',
                        },
                    }
                },
                'portfolio_title[]': {
                    row: '.col-xs-2',
                    validators: {
                        notEmpty: {
                            message: 'The title required and cannot be empty'
                        }
                    }
                },
                'portfolio_description[]': {
                    row: '.col-xs-3',
                    validators: {
                        notEmpty: {
                            message: 'The description required and cannot be empty'
                        }
                    }
                },
                featured_image: {
                    validators:{
                    notEmpty: {
                            message: 'Please select a featured image'
                        }
                    }
                },
                @foreach($portfolio_images as $portfolio_image)
                    'portfolio_image[{{$portfolio_image->id}}]':{
                        row: '.col-xs-3',
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpg,image/png,image/x-png,image/x-jpg,image/jpeg',
                                maxSize: 10 * 1024 * 1024, // 2048 * 1024
                                message: 'Please choose a image file with a size less than 10M.',
                            },
                        }
                    },'portfolio_title[{{$portfolio_image->id}}]':{
                        row: '.col-xs-2',
                        validators: {
                            notEmpty: {
                                message: 'The title required and cannot be empty'
                            }
                        }
                    },'portfolio_description[{{$portfolio_image->id}}]':{
                        row: '.col-xs-3',
                        validators: {
                            notEmpty: {
                                message: 'The description required and cannot be empty'
                            }
                        }
                    },
                @endforeach
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
    

</script>
@endsection