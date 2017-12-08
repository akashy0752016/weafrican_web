@extends('admin.layouts.adminapp')
@section('title', $pageTitle)

@section('styles')
<link href="{{ asset('css/lightgallery/lightgallery.css')}}" rel="stylesheet">
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);

.list-unstyled>li.featured_image{
            display: block;
        }
        .list-unstyled>li{
        display:none;
   }
/* written by riliwan balogun http://www.facebook.com/riliwan.rabo*/
.board{
width: 80%;
margin-left: 20px;
margin-right:20px;
height: 500px;
background: #fff;
/*box-shadow: 10px 10px #ccc,-10px 20px #ddd;*/
}
.board .nav-tabs {
    position: relative;
    /* border-bottom: 0; */
    /* width: 80%; */
    margin: 40px auto;
    margin-bottom: 0;
    box-sizing: border-box;

}

.board > div.board-inner{
    background: #fafafa url(http://subtlepatterns.com/patterns/geometry2.png);
    background-size: 30%;
}

p.narrow{
    width: 60%;
    margin: 10px auto;
}

.liner{
    height: 2px;
    background: #ddd;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    /* background-color: #ffffff; */
    border: 0;
    border-bottom-color: transparent;
}

span.round-tabs{
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: white;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}

span.round-tabs.one{
    color: rgb(34, 194, 34);border: 2px solid rgb(34, 194, 34);
}

li.active span.round-tabs.one{
    background: #fff !important;
    border: 2px solid #ddd;
    color: rgb(34, 194, 34);
}

span.round-tabs.two{
    color: #febe29;border: 2px solid #febe29;
}

li.active span.round-tabs.two{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #febe29;
}

span.round-tabs.three{
    color: #3e5e9a;border: 2px solid #3e5e9a;
}

li.active span.round-tabs.three{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #3e5e9a;
}

span.round-tabs.four{
    color: #f1685e;border: 2px solid #f1685e;
}

li.active span.round-tabs.four{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #f1685e;
}

span.round-tabs.five{
    color: #999;border: 2px solid #999;
}

li.active span.round-tabs.five{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #999;
}

.nav-tabs > li.active > a span.round-tabs{
    background: #fafafa;
}
.nav-tabs > li {
    width: 20%;
}
li:after {
    content: " ";
    position: absolute;
    left: 45%;
   opacity:0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #ddd;
    transition:0.1s ease-in-out;
    
}
li.active:after {
    content: " ";
    position: absolute;
    left: 45%;
   opacity:1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #ddd;
    
}
.nav-tabs > li a{
   width: 70px;
   height: 70px;
   margin: 20px auto;
   border-radius: 100%;
   padding: 0;
}

.nav-tabs > li a:hover{
    background: transparent;
}

.tab-content{
}
.tab-pane{
   position: relative;
padding-top: 50px;
}
.tab-content .head{
    font-family: 'Roboto Condensed', sans-serif;
    font-size: 25px;
    text-transform: uppercase;
    padding-bottom: 10px;
}
.btn-outline-rounded{
    padding: 10px 40px;
    margin: 20px 0;
    border: 2px solid transparent;
    border-radius: 25px;
}

.btn.green{
    background-color:#5cb85c;
    color: #ffffff;
}

@media( max-width : 585px ){
    
    .board {
width: 90%;
height:auto !important;
}
    span.round-tabs {
        font-size:16px;
width: 50px;
height: 50px;
line-height: 50px;
    }
    .tab-content .head{
        font-size:20px;
        }
    .nav-tabs > li a {
width: 50px;
height: 50px;
line-height:50px;
}

li.active:after {
content: " ";
position: absolute;
left: 35%;
}

.btn-outline-rounded {
    padding:12px 20px;
    }
}
/*****/
comment-section.col-md-12 {
	    border-top: 1px solid #dadada;
	}
	.col-md-2.item {
	    padding: 15px;
	    width: 20%;
	    text-align: center;
	}
	.comment-section .item .label {
	    padding: 1.2em 3.6em 1.3em;
	}
	.comment-section .label .fa {
	    font-size: 22px;
	    vertical-align: middle;
	}
	.form-group {
  overflow: hidden;
}
.object-fit_cover { object-fit: cover ; height: 200px; background-color: #444; width:100%;}
.image {
  float: left;
  width: 100%;
  margin: 0 30px 20px 0;
  }
</style>
@endsection
@section('content')
<h2>View User Business - (Business Id - {{$business->business_id}})</h2>
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
<section>
    <div class="container">
        <div class="row">
            <div class="board">
                <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                <div class="board-inner">
                    <ul class="nav nav-tabs" id="myTab">
                        <div class="liner"></div>
                        <li class="active">
                            <a href="#home" data-toggle="tab" title="Business Profile">
                            <span class="round-tabs one">
                            <i class="glyphicon glyphicon-user"></i>
                            </span> 
                            </a>
                        </li>
                        <li><a href="#profile" data-toggle="tab" title="Business Events">
                            <span class="round-tabs two">
                            <i class="glyphicon glyphicon-calendar"></i>
                            </span> 
                            </a>
                        </li>
                        @if($business->category->id > 2)
                        <li><a href="#products" data-toggle="tab" title="Business Products">
                            <span class="round-tabs three">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            </span> </a>
                        </li>
                        @else
                        <li><a href="#portfolio" data-toggle="tab" title="Business Portfolio">
                            <span class="round-tabs three">
                            <i class="glyphicon glyphicon-camera"></i>
                            </span> </a>
                        </li>
                        @endif
                        <li><a href="#settings" data-toggle="tab" title="Business Services">
                            <span class="round-tabs four">
                           <i class="fa fa-building" aria-hidden="true"></i>
                            </span> 
                            </a>
                        </li>
                        <li><a href="#doner" data-toggle="tab" title="Business Videos">
                            <span class="round-tabs five">
                            <i class="glyphicon glyphicon-facetime-video"></i>
                            </span> </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="home">
                    	@if($business->banner)
                    	<div class="form-group">
                    		<div class="image">
								<img class="object-fit_cover" src="{{asset(config('image.banner_image_url').'business/'.$business->banner)}}">
							</div>
                    	</div>
                    	@endif
                    	<div class="form-group">
                    		<label class="control-label col-md-2">Business Logo:</label>
							<div class="col-md-4">
							@if($business->business_logo)
								<img src="{{asset(config('image.logo_image_url').'thumbnails/small/'.$business->business_logo)}}"/>
							@else
								<p>No logo uploaded</p>
							@endif	
							</div>
                    	</div>
                    	
                    	<div class="form-group">
							<label class="control-label col-md-2">Business User Name:</label>
							<div class="col-md-4">
							{{ $business->user->first_name  }}	
							</div>
							<label class="control-label col-md-2">Business Title:</label>
							<div class="col-md-4">
							{{ $business->title  }}
								
							</div>
							
						</div>
		                <div class="form-group">
							
							<label class="control-label col-md-2">Category</label>
							<div class="col-md-4">
							{{ $business->category->title}}
								
							</div>
							<label class="control-label col-md-2"> Sub-Category:</label>
							<div class="col-md-4">
							@if($business->bussiness_subcategory_id)
							{{ $business->subcategory->title  }}
							@else
							 -
							@endif
								
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Business keywords:</label>
							<div class="col-md-4">
							{{ $business->keywords  }}
								
							</div>
							
							<label class="control-label col-md-2">Website</label>
							<div class="col-md-4">
								{{ $business->website }}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Address:</label>
							<div class="col-md-4">
							{{ $business->user->address  }}
							</div>
							<label class="control-label col-md-2">City:</label>
							<div class="col-md-4">
								{{ $business->user->city  }}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">State:</label>
							<div class="col-md-4">
								{{ $business->user->state }}
							</div>
							<label class="control-label col-md-2">Country:</label>
							<div class="col-md-4">
							{{ $business->user->country }}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Pin code:</label>
							<div class="col-md-4">
								{{ $business->user->pin_code }}
							</div>
							<label class="control-label col-md-2">Email:</label>
							<div class="col-md-4">
							{{ $business->user->email }}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Mobile Number:</label>
							<div class="col-md-4">
								+{{ $business->user->country_code }}-{{ $business->user->mobile_number or old('mobile_number') }}
							</div>
							<label class="control-label col-md-2">Currency:</label>
							<div class="col-md-4">
							{{ $business->user->currency }}
							</div>
						</div>
						<div class="form-group">	
							<label class="control-label col-md-2">About Us:</label>
							<div class="col-md-4">
								{{ $business->about_us }}
							</div>
							<label class="control-label col-md-2">Working Hours</label>
							<div class="col-md-4">
								@if(count(preg_split("/\\r\\n|\\r|\\n/", trim($business->working_hours)))==7)
									<div class="table-responsive working_hours_table" style="width: 100%;" style="width: 50%;">
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
						@if($business->business_proof)
						<div class="form-group">	
							<label class="control-label col-md-2">Identity Proof</label>
							<div class="col-md-4">
								<a href="{{asset(config('image.document_url').$business->identity_proof)}}" target="_blank">	
									<i class="fa fa-file-text fa-2x" aria-hidden="true" title="see document"></i>
								</a>
								<div class="verified">
									<!-- <a href="{{ URL::to('admin/business/identity/proof/validate/'.$business->id) }}">
									@if($business->is_identity_proof_validate)
					                    <button type="button" class="btn btn-danger" title="Unverified">Unverified</button>
			                    	@else
			                    		<button type="button" class="btn btn-success" title="Verified">Verified</button>
			                		@endif
				                    </a> -->
			                    </div>
							</div>
							<label class="control-label col-md-2">Business Proof</label>
							<div class="col-md-4">
								<a href="{{asset(config('image.document_url').$business->business_proof)}}" target="_blank">	
									<i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
								</a>
								<div class="verified">
									<!-- <a href="{{ URL::to('admin/business/proof/validate/'.$business->id) }}">
				                    @if($business->is_business_proof_validate)
					                    <button type="button" class="btn btn-danger" title="Unverified">Unverified</button>
			                    	@else
			                    		<button type="button" class="btn btn-success" title="Verified">Verified</button>
				                		@endif
				                    </a> -->
			                    </div>
							</div>
							<div class="col-md-4 col-md-offset-4 center">
								@if($business->is_business_proof_validate and $business->is_identity_proof_validate)
									<!-- <a href="{{ URL::to('admin/business/user/validate/'.$business->id) }}">
										<button type="button" class="btn btn-danger btn-block" title="Unverified">Unverify User</button>
									</a> -->
									<span class="btn btn-success btn-block">Business Approved</span>
								@else
									<a href="{{ URL::to('admin/business/user/validate/'.$business->id) }}">
										<button type="button" class="btn btn-success btn-block" title="Verify">Apporve Business</button>
									</a>
								@endif
							</div>
						</div>
						@else
						<div class="form-group">
							<label class="control-label col-md-2">Business Proof</label>	
							<div class="col-md-4">
								<p>User does not upload Identity Proof yet.</p>
							</div>
							<label class="control-label col-md-2">Identity Proof</label>	
							<div class="col-md-4">
								<p>User does not upload Business Proof yet.</p>
							</div>
							<div class="col-md-4 col-md-offset-4 center">
								@if($business->is_business_proof_validate and $business->is_identity_proof_validate)
									<!-- <a href="{{ URL::to('admin/business/user/validate/'.$business->id) }}">
										<button type="button" class="btn btn-danger btn-block" title="Unverified">Unverify User</button>
									</a> -->
									<span class="btn btn-success btn-block">Business Approved</span>
								@else
									<a href="{{ URL::to('admin/business/user/validate/'.$business->id) }}">
										<button type="button" class="btn btn-success btn-block" title="Verify">Apporve Business</button>
									</a>
								@endif
							</div>
						</div>
						@endif
						<div class="comment-section col-md-12">
							<div class="icons_section">
						    	<div class="col-md-2 like item">
						        	<span class="label label-warning" title="Likes"><i class="fa fa-thumbs-o-up" aria-hidden="true"><span class="badge">{{$business->getLikes()}}</span></i></span>
								</div>

								<div class="col-md-2 dislike item">
									<span class="label label-primary" title="Dislikes"><i class="fa fa-thumbs-o-down" aria-hidden="true">
									<span class="badge">{{$business->getDislikes()}}</span></i></span>
								</div>

								<div class="col-md-2 rating item">
									<span class="label label-success" title="Ratings"><i class="fa fa-star-o" aria-hidden="true">
									<span class="badge">{{(int)$business->getRatings()}}</span></i>
									</span>
								</div>

								<div class="col-md-2 favourite item">
									<span class="label label-info" title="Favourites"><i class="fa fa-heart-o" aria-hidden="true">
									<span class="badge">{{$business->getFavourites()}}</span></i>
									</span>
								</div>

								<div class="col-md-2 followers item">
									<span class="label label-danger" title="Followers"><i class="fa fa-users" aria-hidden="true">
									<span class="badge">{{$business->getFollowers()}}</span></i></span>
								</div>
							</div>
						</div>
                    </div>
                    <div class="tab-pane fade" id="profile">
		                <div class="form-group business_success">
							<!-- <label class="control-label col-md-12 label-success" style="color:#fff">Business events</label> -->
							@if(count($business->events)>0)
								<div>
									<table class="table">
									    <thead>
									      <tr>
									      	<th>Event Banner</th>
									        <th>Event Name</th>
									        <th>Event Description</th>
									        <th>Event Start Date</th>
									        <th>Event End Date</th>
									        <th>Status</th>
									        <th>Total Seats</th>
									        <th>Total Seats Left</th>
									        
									      </tr>
									    </thead>
									    @foreach($business->events as $event)
									    	<tr>
									    		<td>
									    			<div class="profiles_images">
									    				@if($event->banner!="")
												    		<a class="example-image-link" href="{{asset(config('image.banner_image_url').'event/'.$event->banner)}}" data-lightbox="service_{{ $event->title }}">
																<img class="example-image previewImg" src="{{asset(config('image.banner_image_url').'event/'.'thumbnails/small/'.$event->banner)}}">
															</a>
														@else
															<img class="example-image previewImg" src="{{asset('images/no-image.jpg')}}">
														@endif
													</div>
									    		</td>
									    		<td>{{ $event->name }}</td>
									    		<td>{{ $event->description }}</td>
									    		<td>{{ date_format(date_create($event->start_date_time), 'd M,Y') }}</td>
									    		<td>{{ date_format(date_create($event->end_date_time), 'd M,Y') }}</td>
									    		@if(date('y m,d h:i A', strtotime($event->end_date_time)) > date('y m,d h:i A'))
						                        <td style="color:#18dd18">
						                         Active
						                         @else
						                         <td style="color:#D46752">
						                         Expired
						                         @endif
						                         </td>
									    		<td>{{ $event->total_seats }}</td>
									    		<td>{{ $event->total_seats- $event->soldEventTickets->sum('total_tickets_buyed') }}</td>
									    		
									    	</tr>
										@endforeach
									</table>
								</div>
							@else
								<div class="col-md-12">
								<div class="row">
									No Event has been added by this user.
									</div>
								</div>
							@endif
						</div>
                    </div>
                    <div class="tab-pane fade" id="products">
		                <div class="form-group business_success">
							<!-- <label class="control-label col-md-12 label-success" style="color:#fff">Business Products</label> -->
							@if(isset($business->products) && count($business->products)>0 )
								<div>
									<table class="table">
									    <thead>
									      <tr>
									      	<th>Product Images</th>
									        <th>Product Name</th>
									        <th>Product Description</th>
									        <th>Product Price</th>
									      </tr>
									    </thead>
									    @foreach($business->products as $key => $product)
									    	<tr>
									    		<td>
									    			@if(isset($product->business_product_images->featured_image))
                		<div class="demo-gallery product_gallery">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#lightgallery-{{++$key+1}}').lightGallery();
                                });
	                                    </script>
	                            <ul id="lightgallery-{{++$key}}" class="list-unstyled row">
                            @foreach($product->business_product_images->images() as $key => $image)
                            	@if($product->business_product_images->featured_image == $image)
                                <li class="col-xs-6 col-sm-4 col-md-3 featured_image" data-responsive="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$product->title}}</h4><p>{{$product->description}}</p>">
                                    <img class="img-responsive" src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </li>
                                @else
                                <li class="col-xs-6 col-sm-4 col-md-3 " data-responsive="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$product->title}}</h4><p>{{$product->description}}</p>">
                                    <img class="img-responsive" src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    @else
                		<img class="event_img previewImg" src="{{asset('images/no-image.jpg')}}"/>
                	@endif

									    		</td>
									    		<td>{{ $product->title }}</td>
									    		<td>{{ $product->description }}</td>
									    		<td>{{ $product->price }} {{ $business->currency }}</td>
									    	</tr>
										@endforeach
									</table>
								</div>
							@else
								<div class="col-md-12">
								<div class="row">
									No Product has been added by this user.
									</div>
								</div>
							@endif

						</div>
						</div>
						<div class="tab-pane fade" id="portfolio">
							@if(isset($business->portfolio) && count($business->portfolio)>0 )
							<div class="form-group">
								<label class="control-label col-md-2">Maritial Status :</label>
								<div class="col-md-4">
									{{ $business->portfolio->maritial_status }}
								</div>

								<label class="control-label col-md-2">Ocupation :</label>
								<div class="col-md-4">
									{{ $business->portfolio->occupation }}
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Academic Status :</label>
								<div class="col-md-4">
									{{ $business->portfolio->acedimic_status }}
								</div>

								<label class="control-label col-md-2">Key Skills :</label>
								<div class="col-md-4">
									{{ $business->portfolio->key_skills }}
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Experience :</label>
								<div class="col-md-4">
									{{ $business->portfolio->experience_years }} Years {{ $business->portfolio->experience_months }} months
								</div>

								<label class="control-label col-md-2">Hair Type :</label>
								<div class="col-md-4">
									{{ $business->portfolio->hair_type }}
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Hair Color :</label>
								<div class="col-md-4">
									{{ $business->portfolio->hair_color }}
								</div>

								<label class="control-label col-md-2">Skin Color :</label>
								<div class="col-md-4">
									{{ $business->portfolio->skin_color }}
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2">Professional Training :</label>
								<div class="col-md-4">
									@if($business->portfolio->professional_training) Yes @else No @endif
								</div>

								<label class="control-label col-md-2">Institute Name :</label>
								<div class="col-md-4">
									{{ $business->portfolio->institute_name }}
								</div>
							</div>
							@if(isset($business->portfolioImages))
								@foreach($business->portfolioImages as $key => $portfolio)
									<div class="demo-gallery portfolio_gallery"> 
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
                                    	<p>No Image found</p>
                                    @endif
                                </div>
								@endforeach
							@endif
							@else
								<div class="col-md-12">
								<div class="row">
									No Portfolio has been added by this user.
									</div>
								</div>
							@endif
                    </div>
                    <div class="tab-pane fade" id="settings">
		                <div class="form-group business_success">
							<!-- <label class="control-label col-md-12 label-success" style="color:#fff">Business Services</label> -->
							@if(count($business->services)>0)
								<div>
									<table class="table">
									    <thead>
									      <tr>
									        <th>Service Title</th>
									        <th>Service Description</th>
									        <th>Service Created on</th>
									      </tr>
									    </thead>
									    @foreach($business->services as $service)
									    	<tr>
									    		<td>{{ $service->title }}</td>
									    		<td>{{ $service->description }}</td>
									    		<td>{{ date_format(date_create($service->created_at), 'd M,Y') }}</td>
									    	</tr>
										@endforeach
									</table>
								</div>
							@else
								<div class="col-md-12">
								<div class="row">
									No Services has been added by this user.
									</div>
								</div>
							@endif
						</div>
                    </div>
                    <div class="tab-pane fade" id="doner">
                         <div class="form-group business_success">
							<!-- <label class="control-label col-md-12 label-success" style="color:#fff">Business Services</label> -->
							@if(count($business->videos)>0)
								<div>
									<table class="table">
									    <thead>
									      <tr>
									      	<th>Video Thumbnail</th>
									        <th>Video Title</th>
									        <th>Video Description</th>
									        
									      </tr>
									    </thead>
									    @foreach($business->videos as $video)
									    	<tr>
									    		<td class="video_play">
									    		@if(!empty($video->thumbnail_image && $video->embed_url))
													<img class="video-image" src="{{$video->thumbnail_image}}"><a data-toggle="modal" onclick="javascript:videoModal('{{ $video->title }}', '{{ $video->embed_url }}')"   title="Watch Video"> <i class="fa fa-play-circle-o" aria-hidden="true"></i></a>
												@else 
													<p>No video found</p>
												@endif </td>
									    		<td>{{ $video->title }}</td>
									    		<td>{{ $video->description }}</td>
									    	</tr>
										@endforeach
									</table>
								</div>
							@else
								<div class="col-md-12">
								<div class="row">
									No Videos has been added by this user.
									</div>
								</div>
							@endif
						</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
        </div>
    </div>
</section>  

<!-- Watch Video Modal -->
    <div class="modal fade" id="watchVideo" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="video-title"></h4>
                </div>
                <div class="modal-body">
                        <iframe id="video" width="870	" height="345" src="" frameborder="0" allowfullscreen>
                        </iframe>
                </div>
            </div>
        </div>
    </div>            
@endsection
@section('header-scripts')
<script src="{{ asset('js/lightbox.js') }}"></script>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{ asset('js/lightgallery/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('js/lightgallery/lib/jquery.mousewheel.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/lightbox.css') }}">
<script type="text/javascript">
    $(function(){
		$('a[title]').tooltip();
	});
	lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    });
    function videoModal (title, src) {
        var url = src +"?autoplay=1";

        $("#watchVideo").modal('show');

	    $("#watchVideo").on('shown.bs.modal', function(){
	        $('.video-title').html(title);

	        $("#video").attr('src', url);

	    });
    
	    $("#watchVideo").on('hide.bs.modal', function(){

	        $("#video").attr('src', '');

	    });
    }
</script>
@endsection
