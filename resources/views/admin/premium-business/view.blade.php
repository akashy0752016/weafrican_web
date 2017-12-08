@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<h2>View Premium User Business</h2>
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
	<div class="panel panel-default">
		<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-md-2">Business Title:</label>
					<div class="col-md-4">
					{{ $business->title  }}
						
					</div>
					<label class="control-label col-md-2">Category</label>
					<div class="col-md-4">
					{{ $business->category->title}}
						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Business keywords:</label>
					<div class="col-md-4">
					{{ $business->keywords  }}
						
					</div>
					
					<label class="control-label col-md-2">Website</label>
					<div class="col-md-4">
						{{ $business->website or old('website') }}
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
					{{ $business->user->country or old('country') }}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Pin code:</label>
					<div class="col-md-4">
						{{ $business->user->pin_code or old('pin_code') }}
					</div>
					<label class="control-label col-md-2">Email:</label>
					<div class="col-md-4">
					{{ $business->user->email or old('email') }}
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
				<div class="form-group">
					<label class="control-label col-md-12 label-success" style="color:#fff">Business events</label>
					@if(count($business->events)>0)
						<div>
							<table class="table table-bordered">
							    <thead>
							      <tr>
							        <th>Event Name</th>
							        <th>Event Description</th>
							        <th>Event Start Date</th>
							        <th>Event End Date</th>
							        <th>Total Seats</th>
							        <th>Total Seats Left</th>
							        <th>Event Banner</th>
							      </tr>
							    </thead>
							    @foreach($business->events as $event)
							    	<tr>
							    		<td>{{ $event->name }}</td>
							    		<td>{{ $event->description }}</td>
							    		<td>{{ date_format(date_create($event->start_date_time), 'd M,Y') }}</td>
							    		<td>{{ date_format(date_create($event->end_date_time), 'd M,Y') }}</td>
							    		<td>{{ $event->total_seats }}</td>
							    		<td>{{ $event->total_seats- $event->soldEventTickets->sum('total_tickets_buyed') }}</td>
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
							    	</tr>
								@endforeach
							</table>
						</div>
					@else
						<div class="col-md-12">
							No Event has been added by this user.
						</div>
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-md-12 label-success" style="color:#fff">Business Products</label>
					@if(count($business->products)>0)
						<div>
							<table class="table table-bordered">
							    <thead>
							      <tr>
							        <th>Product Name</th>
							        <th>Product Description</th>
							        <th>Product Price</th>
							        <th>Product Images</th>
							      </tr>
							    </thead>
							    @foreach($business->products as $product)
							    	<tr>
							    		<td>{{ $product->title }}</td>
							    		<td>{{ $product->description }}</td>
							    		<td>{{ $product->price }} {{ $business->currency }}</td>
							    		<td>
							    			 @if(count($product->business_product_images)>0)
					                            @foreach($product->business_product_images as $product_image)
					                                @if($product_image->featured_image==1)
						                                <div class="profiles_images">
						                                    <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image)}}" class="event_img" />
						                                </div>
					                                @endif
					                            @endforeach
											@else
												No Image found for this product
											@endif
							    		</td>
							    	</tr>
								@endforeach
							</table>
						</div>
					@else
						<div class="col-md-12">
							No Product has been added by this user.
						</div>
					@endif
				</div>
				<div class="form-group">
					<label class="control-label col-md-12 label-success" style="color:#fff">Business Services</label>
					@if(count($business->services)>0)
						<div>
							<table class="table table-bordered">
							    <thead>
							      <tr>
							        <th>Service Title</th>
							        <th>Service Description</th>
							        <th>Service Slug</th>
							        <th>Service Created on</th>
							      </tr>
							    </thead>
							    @foreach($business->services as $service)
							    	<tr>
							    		<td>{{ $service->title }}</td>
							    		<td>{{ $service->description }}</td>
							    		<td>{{ $service->slug }}</td>
							    		<td>{{ date_format(date_create($service->created_at), 'd M,Y') }}</td>
							    	</tr>
								@endforeach
							</table>
						</div>
					@else
						<div class="col-md-12">
							No Services has been added by this user.
						</div>
					@endif
				</div>
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
	</div>
<style>
.form-group {
  overflow: hidden;
}
</style>
@endsection
@section('styles')
<style type="text/css">
	.comment-section.col-md-12 {
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
</style>
@endsection
@section('header-scripts')
<script src="{{ asset('js/lightbox.js') }}"></script>
@endsection
@section('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('css/lightbox.css') }}">
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
@endsection