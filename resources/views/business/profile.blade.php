@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
/* USER PROFILE PAGE */
 .card {
    margin-top: 20px;
    padding: 30px;
    background-color: rgba(214, 224, 226, 0.2);
    -webkit-border-top-left-radius:5px;
    -moz-border-top-left-radius:5px;
    border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-top-right-radius:5px;
    border-top-right-radius:5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.card.hovercard {
    position: relative;
    padding-top: 0;
    overflow: hidden;
    text-align: center;
    background-color: #fff;
    background-color: rgba(255, 255, 255, 1);
}
.card.hovercard .card-background {
    height: 130px;
}
.card-background img {
    /*-webkit-filter: blur(25px);
    -moz-filter: blur(25px);
    -o-filter: blur(25px);
    -ms-filter: blur(25px);
    filter: blur(25px);*/
    margin-left: -100px;
    margin-top: -200px;
    min-width: 130%;
}
.card.hovercard .useravatar {
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
}
.card.hovercard .useravatar img {
    width: 100px;
    height: 100px;
    max-width: 100px;
    max-height: 100px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.5);
}
.card.hovercard .card-info {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
}
.card.hovercard .card-info .card-title {
    padding:0 5px;
    font-size: 20px;
    line-height: 1;
    color: #262626;
    background-color: rgba(255, 255, 255, 0.1);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.card.hovercard .card-info {
    overflow: hidden;
    font-size: 12px;
    line-height: 20px;
    color: #737373;
    text-overflow: ellipsis;
}
.card.hovercard .bottom {
    padding: 0 20px;
    margin-bottom: 17px;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}
.tab-content>.active {
    display: inline-block;
    width: 100%;
}


</style>
<div class="container row_pad">
	<h5 class="text-left">Business Profile</h5>
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

    	@if($business)
	    <div class="row">
	    	<div class="col-md-9">
	    		@if($business->is_update==1)
	    			<div class="notifications">
					    <div class="alert alert-warning alert-block">
					        <button type="button" class="close" data-dismiss="alert">×</button>
					        <p><strong>Update Your Portfolio</strong></p>
						</div>
					</div>
	    		@endif
	    		@if(count($business->services) == 0)
	    			<div class="notifications">
					    <div class="alert alert-warning alert-block">
					        <button type="button" class="close" data-dismiss="alert">×</button>
					        <p><strong>Please Add atlest one service.</strong></p>
						</div>
					</div>
	    		@endif
	    	</div>
	    	<div class="col-md-3">
	    		<p class="text-right"><a href="{{url('register-business/'.$business->id.'/edit')}}"><button type="button" class="btn btn-info">Edit Business Profile</button> </a> </p>
	    	</div>
	    </div>
	    <!-- New Design -->
    	<div class="col-lg-12 col-sm-12 col-md-12">
		    <div class="card hovercard">
		        <div class="card-background">
		            <!-- <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/9/"> -->
		            @if($business->banner != NULL)
	    				<img class="card-bkimg" alt="banner" src="{{asset(config('image.banner_image_url').'business/'.$business->banner)}}"/>
	    			@else
	            		<img class="card-bkimg" alt="Banner" src="{{asset('images/blank-image.jpeg')}}">
            		@endif
		        </div>
		        <div class="useravatar">
		        	@if($business->business_logo != NULL)
						<img src="{{asset(config('image.logo_image_url').'thumbnails/small/'.$business->business_logo)}}"/>
					@else
						<img src="{{asset('images/no-uploaded.png')}}"/>
					@endif
		        </div>
		        <div class="card-info"> <span class="card-title">{{ Auth::user()->first_name.' '.Auth::user()->middle_name.' '.Auth::user()->last_name }}</span>

		        </div>
		    </div>
			<div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
			    <div class="btn-group" role="group">
			        <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			            <div class="hidden-xs">Business Profile</div>
			        </button>
			    </div>
			    <div class="btn-group" role="group">
			        <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			            <div class="hidden-xs">Business Status</div>
			        </button>
			    </div>
			     @if($category_check==1 or $category_check==2)
			    <div class="btn-group" role="group">
			        <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			            <div class="hidden-xs">Portfolio Details</div>
			        </button>
			    </div>
			    @endif
			</div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
        	<div class="col-md-12 col-sm-6">
          		<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Business ID :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{$business->business_id}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Business name :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{$business->title}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Category :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->category->title}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Bussiness keywords :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->keywords }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>About Us :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->about_us }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Address :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->address }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>City :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->city }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>State :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->state }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Country :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->country }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Pin code :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->pin_code }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Email :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right mail_text">
						{{ $business->user->email }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Mobile Number :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->mobile_number }} &nbsp;&nbsp;&nbsp;
				        @if($business->user->mobile_verified==0)
				        <a class="btn-danger label" href="{{ url('mobileVerify/') }}"><label >Not Verified</label></a>
				        @else
				        <label class="btn-success label">Verified</label>
				        @endif
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Website :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->website }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Working Hours :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12 profile_right">
					@if(count(preg_split("/\\r\\n|\\r|\\n/", trim($business->working_hours)))==7)
						<div class="table-responsive working_hours_table @if($category_check==1 or $category_check==2) working_hours_full @else working_hours_half @endif">
						  <table class="table table-striped table-bordered">
						    <thead>
						    	<tr>
						    		<th>Day</th>
						    		<th>Timing</th>
						    	</tr>
						    </thead>
						    <tbody>
						    	@foreach(preg_split("/\\r\\n|\\r|\\n/", trim($business->working_hours)) as $value)
						    		@if(stripos($value, "Closed"))
						    		<tr style="color: red">
						    		@else
						    		<tr>
						    		@endif
						    			<td>{{trim(explode(':',$value,2)[0])}}</td>
						    			<td>{{trim(explode(':',$value,2)[1])}}</td>
						    		</tr>
								@endforeach
						    </tbody>
						  </table>
						</div>
						
					@else
						{!! nl2br(e($business->working_hours)) !!}
					@endif
					</div>
				</div>
			</div>
			 <div class="comment-section col-md-12">
		    	<div class="row">
		    		<div class="icons_section">
		    		@if(Auth::user()->user_role_id == 5)
				    	<div class="col-md-2 col-sm-2 col-xs-2 like item">
				        	<a href="{{url('business-follower')}}"><span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidiven="true"></i></span>
				        	<span class="badge">{{$business->getLikes()}}</span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 dislike item">
							<a href="{{url('business-follower')}}"><span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidiven="true">
							<span class="badge">{{$business->getDislikes()}}</span></i></span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 rating item">
							<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidiven="true">
							<span class="badge">{{(int)$business->getRatings()}}</span></i></span>
							
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 favourite item">
							<a href="{{url('business-follower')}}"><span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidiven="true">
							<span class="badge">{{$business->getFavourites()}}</span></i>
							</span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 followers item">
							<a href="{{url('business-follower')}}"><span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidiven="true">
							<span class="badge">{{$business->getFollowers()}}</span></i></span></a>
						</div>
					@else
						<div class="col-md-2 col-sm-2 col-xs-2 like item">
				        	<span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidiven="true"></i></span>
				        	<span class="badge">{{$business->getLikes()}}</span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 dislike item">
							<span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidiven="true">
							<span class="badge">{{$business->getDislikes()}}</span></i></span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 rating item">
							<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidiven="true">
							<span class="badge">{{(int)$business->getRatings()}}</span></i></span>
							
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 favourite item">
							<span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidiven="true">
							<span class="badge">{{$business->getFavourites()}}</span></i>
							</span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 followers item">
							<span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidiven="true">
							<span class="badge">{{$business->getFollowers()}}</span></i></span>
						</div>
					@endif
					</div>
				</div>
			</div>
        </div>
        <div class="tab-pane fade in" id="tab2">
          <div class="col-md-12 col-md-6">
          	<div class="row">
				<div class="col-md-12">
				
					@if($business->is_identity_proof_validate && $business->is_business_proof_validate)
						<div class="sep_id">
							@if($business->business_proof)
								<div class="col-md-4 col-xs-6">Business Proof</div>
						        <div class="col-md-8 col-xs-6">
						        	@if($business->business_proof)
						            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							@if($business->identity_proof)
								<div class="col-md-4 col-xs-6">Identity Proof</div>
						        <div class="col-md-8 col-xs-6">
						        	@if($business->identity_proof)
						            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							<div class="col-md-4 col-xs-6">Publish Status:</div>
					        <div class="col-md-8 col-xs-6">
					        	<span class="verified btn-success label"><i class="fa fa-check" aria-hidiven="true"></i>
						            Live</span>
					        </div>
					    </div>
					@else
						<div class="sep_id">
							@if($business->business_proof)
								<div class="col-md-4 col-xs-6">Business Proof</div>
						        <div class="col-md-8 col-xs-6">
						        	@if($business->business_proof)
						            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							@if($business->identity_proof)
								<div class="col-md-4 col-xs-6">Identity Proof</div>
						        <div class="col-md-8 col-xs-6">
						        	@if($business->identity_proof)
						            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							<div class="col-md-4 col-xs-6">Publish Status:</div>
					        <div class="col-md-8 col-xs-6">
					        	<span class=" btn-danger label">Not Live</span>
					        </div>
					    </div>
					    <div class="sep_id">
					        <div class="col-md-4 col-xs-6">Edit Document</div>
					        <div class="col-md-8 col-xs-6"><a href="{{url('upload')}}"><button class="btn_upd">Upload Document</button></a></div>
					    </div>
					@endif
			        </div>
				</div>
          </div>
        </div>
         @if($category_check==1 or $category_check==2)
        <div class="tab-pane fade in" id="tab3">
          <div class="col-md-12 col-sm-6">
          	<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Maritial Status :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->maritial_status }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-text_spacing4 col-sm-4 col-xs-6 profile_left">
							<label>Ocupation :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->occupation }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Academic Status :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->acedimic_status }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Key Skills :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->key_skills }}
						</div>
					</div>
					@if(isset($category_check) and $category_check==1)
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Experience :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->experience_years }} Years {{ $business->portfolio->experience_months }} months
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Height :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->height_feets }} feet {{ $business->portfolio->height_inches }} inches
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Hair Type :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->hair_type }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Hair Color :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->hair_color }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Skin Color :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								
								{{ $business->portfolio->skin_color }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Professional Training :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								@if($business->portfolio->professional_training) Yes @else No @endif
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Institute Name :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->institute_name }}
							</div>
						</div>
					@endif
          </div>
        </div>
        @endif
      </div>
    </div>
    
    </div>
            
    
	    <!--  -->
	    <!-- <div class="panel panel-default ">
	    	@if($business->banner != NULL)
	    		<img class="banner_image" src="{{asset(config('image.banner_image_url').'business/'.$business->banner)}}"/>
	    	@else
	            <img class="banner_image" src="{{asset('images/blank-image.jpeg')}}">
            @endif
	    </div>
		<div class="business-profile">
		@if($category_check==1 or $category_check==2)
		<div class="col-md-6 col-sm-6">
		@else
		<div class="col-md-12 col-sm-6">
		@endif
		 	<div class="panel panel-primary business-left">
			      <div class="panel-heading">Business Profile Details</div>
			      <div class="panel-body">
			      	<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						@if($category_check==1 or $category_check==2)
			    			<label>Profile Pic :</label>
			    		@else
			    			<label>Business Logo :</label>
			    		@endif
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right profile_img">
						@if($business->business_logo != NULL)
				            <img src="{{asset(config('image.logo_image_url').'thumbnails/small/'.$business->business_logo)}}"/>
			            @else
				            <img src="{{asset('images/no-uploaded.png')}}"/>
			            @endif
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Name :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ Auth::user()->first_name.' '.Auth::user()->last_name}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Business ID :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{$business->business_id}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Business name :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{$business->title}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Category :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->category->title}}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Bussiness keywords :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->keywords }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>About Us :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->about_us }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Address :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->address }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>City :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->city }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>State :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->state }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Country :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->country }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Pin code :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->pin_code }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Email :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right mail_text">
						{{ $business->user->email }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Mobile Number :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->user->mobile_number }} &nbsp;&nbsp;&nbsp;
				        @if($business->user->mobile_verified==0)
				        <a class="btn-danger label" href="{{ url('mobileVerify/') }}"><label >Not Verified</label></a>
				        @else
				        <label class="btn-success label">Verified</label>
				        @endif
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Website :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
						{{ $business->website }}
					</div>
				</div>
				<div class="row text_spacing">
					<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
						<label>Working Hours :</label>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12 profile_right">
					@if(count(preg_split("/\\r\\n|\\r|\\n/", trim($business->working_hours)))==7)
						<div class="table-responsive working_hours_table @if($category_check==1 or $category_check==2) working_hours_full @else working_hours_half @endif">
						  <table class="table table-striped table-bordered">
						    <thead>
						    	<tr>
						    		<th>Day</th>
						    		<th>Timing</th>
						    	</tr>
						    </thead>
						    <tbody>
						    	@foreach(preg_split("/\\r\\n|\\r|\\n/", trim($business->working_hours)) as $value)
						    		@if(stripos($value, "Closed"))
						    		<tr style="color: red">
						    		@else
						    		<tr>
						    		@endif
						    			<td>{{trim(explode(':',$value,2)[0])}}</td>
						    			<td>{{trim(explode(':',$value,2)[1])}}</td>
						    		</tr>
								@endforeach
						    </tbody>
						  </table>
						</div>
						
					@else
						{!! nl2br(e($business->working_hours)) !!}
					@endif
					</div>
				</div>
			      </div>
		    </div>
		    </div>
			   @if($category_check==1 or $category_check==2)
			<div class="col-md-6 col-sm-6">
				<div class="panel panel-primary">
				    <div class="panel-heading">User Portfolio Details</div>
				    <div class="panel-body">
				    <div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Maritial Status :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->maritial_status }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-text_spacing4 col-sm-4 col-xs-6 profile_left">
							<label>Ocupation :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->occupation }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Academic Status :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->acedimic_status }}
						</div>
					</div>
					<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label>Key Skills :</label>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
							{{ $business->portfolio->key_skills }}
						</div>
					</div>
					@if(isset($category_check) and $category_check==1)
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Experience :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->experience_years }} Years {{ $business->portfolio->experience_months }} months
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Height :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->height_feets }} feet {{ $business->portfolio->height_inches }} inches
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Hair Type :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->hair_type }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Hair Color :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->hair_color }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Skin Color :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								
								{{ $business->portfolio->skin_color }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Professional Training :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								@if($business->portfolio->professional_training) Yes @else No @endif
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Institute Name :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $business->portfolio->institute_name }}
							</div>
						</div>
					@endif
					<div class="row text_spacing">
						<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
							<label></label>
						</div>
					</div>
					<div class="col-md-12 profile_right image_profile">
					<div class="row text_spacing">
						
						</div>
					</div>
				    </div>
			    </div>
   			</div>
			    
				 
		    @endif
		  <div class="business-right col-md-12">
		  <div class="row">
				<div class="col-md-12">
				
					@if($business->is_identity_proof_validate && $business->is_business_proof_validate)
						<div class="sep_id">
							@if($business->business_proof)
								<div class="col-md-2 col-xs-6">Business Proof</div>
						        <div class="col-md-10 col-xs-6">
						        	@if($business->business_proof)
						            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							@if($business->identity_proof)
								<div class="col-md-2 col-xs-6">Identity Proof</div>
						        <div class="col-md-10 col-xs-6">
						        	@if($business->identity_proof)
						            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							<div class="col-md-2 col-xs-6">Publish Status:</div>
					        <div class="col-md-10 col-xs-6">
					        	<span class="verified btn-success label"><i class="fa fa-check" aria-hidiven="true"></i>
						            Live</span>
					        </div>
					    </div>
					@else
						<div class="sep_id">
							@if($business->business_proof)
								<div class="col-md-2 col-xs-6">Business Proof</div>
						        <div class="col-md-10 col-xs-6">
						        	@if($business->business_proof)
						            <a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							@if($business->identity_proof)
								<div class="col-md-2 col-xs-6">Identity Proof</div>
						        <div class="col-md-10 col-xs-6">
						        	@if($business->identity_proof)
						            <a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
						            <i class="fa fa-file-text fa-2x" aria-hidiven="true" title="see document"></i> </a>
						            @endif
						        </div>
							@endif
						</div>
						<div class="sep_id">
							<div class="col-md-2 col-xs-6">Publish Status:</div>
					        <div class="col-md-10 col-xs-6">
					        	<span class=" btn-danger label">Not Live</span>
					        </div>
					    </div>
					    <div class="sep_id">
					        <div class="col-md-2 col-xs-6">Edit Document</div>
					        <div class="col-md-10 col-xs-6"><a href="{{url('upload')}}"><button class="btn_upd">Upload Document</button></a></div>
					    </div>
					@endif
			        </div>
				</div>
		    </div>

		    <div class="comment-section col-md-12">
		    	<div class="row">
		    		<div class="icons_section">
		    		@if(Auth::user()->user_role_id == 5)
				    	<div class="col-md-2 col-sm-2 col-xs-2 like item">
				        	<a href="{{url('business-follower')}}"><span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidiven="true"></i></span>
				        	<span class="badge">{{$business->getLikes()}}</span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 dislike item">
							<a href="{{url('business-follower')}}"><span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidiven="true">
							<span class="badge">{{$business->getDislikes()}}</span></i></span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 rating item">
							<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidiven="true">
							<span class="badge">{{(int)$business->getRatings()}}</span></i></span>
							
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 favourite item">
							<a href="{{url('business-follower')}}"><span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidiven="true">
							<span class="badge">{{$business->getFavourites()}}</span></i>
							</span></a>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 followers item">
							<a href="{{url('business-follower')}}"><span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidiven="true">
							<span class="badge">{{$business->getFollowers()}}</span></i></span></a>
						</div>
					@else
						<div class="col-md-2 col-sm-2 col-xs-2 like item">
				        	<span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidiven="true"></i></span>
				        	<span class="badge">{{$business->getLikes()}}</span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 dislike item">
							<span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidiven="true">
							<span class="badge">{{$business->getDislikes()}}</span></i></span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 rating item">
							<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidiven="true">
							<span class="badge">{{(int)$business->getRatings()}}</span></i></span>
							
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 favourite item">
							<span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidiven="true">
							<span class="badge">{{$business->getFavourites()}}</span></i>
							</span>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-2 followers item">
							<span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidiven="true">
							<span class="badge">{{$business->getFollowers()}}</span></i></span>
						</div>
					@endif
					</div>
				</div>
			</div>
		</div>  -->

    @else
        <p>Could not find any profile</p>
    @endif	
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
	$(".btn-pref .btn").click(function () {
	    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
	    // $(".tab").addClass("active"); // instead of this do the below 
	    $(this).removeClass("btn-default").addClass("btn-primary");   
	});
	});
	</script>
@endsection