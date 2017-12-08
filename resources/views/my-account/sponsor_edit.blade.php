@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>Sponsor Banner List</h5>
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
	@include('includes.side-menu')
	<div class="col-md-9 col-sm-9">
		<div class="panel panel-default table_set">
			<div class="all_content">
            <form id="register-form" class="form-horizontal" action="{{ url('sponsor-banner/'.$homeBanner->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="choose-banner" class="col-md-3 control-label">Choose Banner</label>
                    <div class="col-md-9">
                        <label class="radio-inline">
                          <input type="radio" name="is_selected" id="is_selected" @if($homeBanner->is_selected==1) checked="checked" @endif value="1">Uploaded Business Banner
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="is_selected" id="is_selected" @if($homeBanner->is_selected==0) checked="checked" @endif value="0">Add New Sponsor Banner
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="is_selected" id="is_selected" @if($homeBanner->is_selected==2) checked="checked" @endif value="2">Select Event Banner
                        </label>
                    </div>
                </div>
                <div class="form-group" id="upload_banner" @if($homeBanner->is_selected!=0) style="display:none" @endif>
                    <label for="description" class="col-md-3 control-label">Upload Banner</label>
                    <div class="col-md-6">
                        <label class="btn-bs-file btn btn-info">Browse
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                        </label>
                    </div>
                    <div class="col-xs-3">
                        <div class="profiles_images">
                        @if($homeBanner->image!="")
                            <img src="{{ asset(config('image.banner_image_url').'home/thumbnails/small/'.$homeBanner->image) }}" alt="" id="preview">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                        @endif
                        </div>
                    </div>
                </div>
                <div class="form-group" id="event_banner" @if($homeBanner->is_selected!=2) style="display:none" @endif>
                    <label for="description" class="col-md-3 control-label">Select Event</label>
                    <div class="col-md-6">
                        <select class="form-control" required="required" @if($homeBanner->is_selected!=2) disabled="disabled" @endif name="business_event_id" id="business_event_id">
                            <option value="">Select Event</option>
                            @if(isset($events))
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" @if($homeBanner->business_event_id==$event->id) selected="selected" @endif>{{ $event->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xs-3">
                    <div class="profiles_images">
                        @if($homeBanner->businessEvent)
                            @if($homeBanner->businessEvent->banner!="" and $homeBanner->businessEvent->banner!=NULL)
                                <img src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$homeBanner->businessEvent->banner)}}" alt="" id="event_preview">
                            @else
                                <img src="{{asset('images/no-image.jpg')}}" alt="" id="event_preview">
                            @endif
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" id="event_preview">
                        @endif
                        </div>
                        <span class="help-block" id="msg"></span>
                    </div>
                </div>
                <div class="form-group" id="business_banner" @if($homeBanner->is_selected!=1) style="display:none" @endif>
                    <label for="description" class="col-md-3 control-label"></label>
                    <div class="col-md-6">
                        <div class="profiles_images">
                         @if($homeBanner->business->banner!="")
                            <img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$homeBanner->business->banner) }}" alt="" id="preview">
                        @else
                            <img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
                        @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="service_name" class="col-md-3 control-label">Subscription Plan</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="{{ $homeBanner->userSubscriptionPlan->subscription->title }}" disabled="disabled">
                    </div>
                </div>
                @if($homeBanner->userSubscriptionPlan->subscription->id==1 or $homeBanner->userSubscriptionPlan->subscription->id==2)
                <div class="form-group">
                    <label for="service_name" class="col-md-3 control-label">Select Country</label>
                    <div class="col-md-6">
                        <select class="form-control" id="country" @if($homeBanner->country!="" or $homeBanner->country!=NULL) disabled="disabled" @endif name="country" required="required">
                            <option value="">Select Country</option>
                            @foreach($countries as $value)
                                <option @if($homeBanner->country==$value->country or $value->country==$homeBanner->user->country) selected="selected" @endif value="{{$value->country}}">{{$value->country}}</option>
                            @endforeach
                        </select>
                    	@if ($errors->has('country'))
	                        <span class="help-block">
	                        <strong>{{ $errors->first('country') }}</strong>
	                        </span>
	                    @endif
                    </div>
                </div>
                @endif
                @if($homeBanner->userSubscriptionPlan->subscription->id==2)
	                <div class="form-group">
	                    <label for="service_name" class="col-md-3 control-label">Select State</label>
	                    <div class="col-md-6">
                            <select class="form-control" id="state" name="state" @if($homeBanner->state!="" or $homeBanner->state!=NULL) disabled="disabled" @endif required="required">
                                <option value="">Select State</option>
                                @foreach($states as $value)
                                    <option @if($homeBanner->state==$value->state or $value->state==$homeBanner->user->state) selected="selected" @endif value="{{ $value->state }}">{{ $value->state }}</option>
                                @endforeach
                            </select>
	                    	@if ($errors->has('state'))
		                        <span class="help-block">
		                        <strong>{{ $errors->first('state') }}</strong>
		                        </span>
		                    @endif
	                    </div>
	                </div>
	            @endif
                <div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-6">
                        <input type='hidden' value='0' name='is_blocked'>
                        <input type="checkbox" name="is_blocked" required="required" value="1"  @if($homeBanner->is_blocked==1)checked="checked"@endif data-toggle="toggle" data-on="Unblock" data-off="Block">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 text-right">
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
@endsection
@section('header-scripts')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css">

<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript">
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
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
        $('#register-form').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                image: {
                    validators: {
                        @if(!isset($homeBanner->image) or $homeBanner->image==NULL)
                        notEmpty: {
                            message: 'Please select your your Business Banner'
                        },
                        @endif
                        file: {
                            extension: 'jpeg,jpg,png',
                            type: 'image/jpg,image/png,image/x-png,image/x-jpg,image/jpeg',
                            maxSize: 10 * 1024 * 1024, // 2048 * 1024
                            message: 'Please choose a image file with a size less than 10M.',
                        },
                    }
                },
            }
        })
    });
    $('#select_category').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    category : this.value,
                },success:function(response)
                {
                    $('.subcategory').find('option').not(':first').remove();
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#select_subcategory').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                        $('.subcategory').show();
                    }else
                    {
                        $('.subcategory').hide();
                    }
                }
            });
        }else
        {
        	$('.subcategory').find('option').not(':first').remove();
            $('.subcategory').hide("slow");
        }
    });
    $('input[name=is_selected]:radio').click(function(e){
        if($('input[name=is_selected]:checked').val()==1)
        {   $('#business_banner').show("slow");
            $('#event_banner').hide("slow");
            $('#upload_banner').hide("slow");
            $('input[name=image]').attr('disabled','disabled');
            $('select[name=business_event_id]').attr('disabled','disabled');
        }else if($('input[name=is_selected]:checked').val()==2)
        {   $('#business_banner').hide("slow");
            $('#event_banner').show("slow");
            $('#upload_banner').hide("slow");
            $('input[name=image]').attr('disabled','disabled');
            $('select[name=business_event_id]').removeAttr('disabled');
        }else
        {
            $('#event_banner').hide("slow");
            $('#business_banner').hide("slow");
            $('#upload_banner').show("slow");
            $('input[name=image]').removeAttr('disabled');
            $('select[name=business_event_id]').attr('disabled','disabled');
        }
    });
    $('#business_event_id').change(function(e){
        if(this.value!="")
        {
            $.ajax({
                type:'POST',
                url: '{{ url("eventbanner") }}',
                data:{
                    business_event_id : this.value,
                }, success:function(response)
                {
                    var obj = JSON.parse(response);
                    if(obj.response=='success')
                    {
                        $('#event_preview').attr('src',obj.image);   
                        $('#msg').html("");
                    }else
                    {
                        $('#msg').html(obj.message);
                    }
                }
            });
        }else
        {
            $('#event_preview').attr('src',"{{asset('images/no-image.jpg')}}");
            $('#msg').html("");
        }
    });
    @if($homeBanner->userSubscriptionPlan->subscription->id==2)
        $('#country').change(function(e){
            if(this.value!="")
            {
                $('#state').find('option').not(':first').remove();
                $('#city').find('option').not(':first').remove();
                $.ajax({
                    type : 'POST',
                    url : '{{ url("/")."/api/get/subscription/state" }}',
                    data: {
                        country : this.value,
                    },
                    success:function(response)
                    {
                        if(response['status']=="success")
                        {
                            if(Object.keys(response['response']).length>0)
                            {
                                for(key in response['response']){
                                    $('#state').append($("<option></option>").attr("value",response['response'][key]['state']).text(response['response'][key]['state']));
                                }
                            }else
                            {
                                alert('No State found for this Country.Please select a different country.');
                            }
                        }else
                        {
                            alert('No State found for this Country.Please select a different country.');
                        }
                    }
                });
            }
        });
    @endif
</script>
@endsection