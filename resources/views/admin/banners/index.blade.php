@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-picture-o" aria-hidden="true"></i> Banners</h2>
	<hr>
	
	@include('notification')
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#home">Home Banners</a></li>
		<li><a data-toggle="tab" href="#menu1">Business Banners</a></li>
		<li><a data-toggle="tab" href="#menu2">Event Banners</a></li>
	</ul>
  	<div class="tab-content">
    	<div id="home" class="tab-pane fade in active">
    	<div class="all_content">
	      	<table id="subscription_list" class="display">
				<thead>
					<tr>
						<th>Business ID</th>
						<th>Business name</th>
						<th>Subscription Plan</th>
						<th>Banner</th>
						<th>Country</th>
						<th>State</th>
						<th>City</th>
						<th>Created On</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($homeBanners as $banner)
					<tr>
						<td><a href="{{ url('admin/business/'.$banner->business->id) }}">{{ $banner->business->business_id }}</a></td>
						<td>{{ $banner->business->title }}</td>
						<td>{{ $banner->userSubscriptionPlan->subscription->title }}</td>
						<td>
							<div class="profiles_images">
							@if($banner->is_selected==1)
								@if($banner->business->banner!="")
									<img class="" src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->business->banner) }}"/>
								@else
									<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
								@endif
							@elseif($banner->is_selected==2)
								@if($banner->businessEvent)
									@if($banner->businessEvent->banner!="" and $banner->businessEvent->banner!=NULL)
										<img src="{{ asset(config('image.banner_image_url').'event/thumbnails/small/'.$banner->businessEvent->banner) }}"/>
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
								@else
									<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
								@endif
							@else
								@if($banner->image!="")
									<img src="{{ asset(config('image.banner_image_url').'home/thumbnails/small/'.$banner->image) }}"/>
								@else
									<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
								@endif
							@endif
							</div>
						</td>
						<td>@if($banner->country != NULL && $banner->country != "") {{ $banner->country }} @else - @endif</td>
						<td>@if($banner->state != NULL && $banner->state != "") {{ $banner->state }} @else - @endif</td>
						<td>@if($banner->city != NULL && $banner->city != "") {{ $banner->city }} @else - @endif</td>
						<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
						<td>
							<ul class="list-inline">
								<li>
									<a href="{{ URL::to('admin/home/banner/block/'.$banner->id) }}">
					                    @if ($banner->is_blocked)
					                    	<button type="button" class="btn btn-danger btn_fixes" title="UnBlock"><i class="fa fa-unlock"></i></button>
				                    	@else
				                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
			                    		@endif
					                </a>
								</li>
								<li>
									<form action="{{ url('admin/banner/'.$banner->id) }}" method="POST" onsubmit="deleteHomeBanner('{{$banner->id}}', '{{$banner->userSubscriptionPlan->subscription->title }}', event,this)">
										{{csrf_field()}}
										<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
    	</div>
	    <div id="menu1" class="tab-pane fade">
	    <div class="all_content">
	      	<table id="business_list" class="display">
				<thead>
					<tr>
						<th>Business ID</th>
						<th>Business name</th>
						<th>Subscription Plan</th>
						<th>Banner</th>
						<th>Category</th>
						<th>Sub-Category</th>
						<th>Country</th>
						<th>State</th>
						<th>City</th>
						<th>Created On</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($businessBanners as $banner)
					<tr>
						<td><a href="{{ url('admin/business/'.$banner->business->id) }}">{{ $banner->business->business_id}}</a></td>
						<td>{{ $banner->business->title}}</td>
						<td>{{ $banner->userSubscriptionPlan->subscription->title}}</td>
						<td>@if($banner->userSubscriptionPlan->subscription->id!=6)
								<div class="profiles_images"> 
								@if($banner->is_selected==1)
									@if($banner->business->banner!="")
										<img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->business->banner) }}"/>
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
								@elseif($banner->image!="")
									<img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->image) }}"/>
								@else
									<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
								@endif
								</div>
							@else
							No Banner is needed for Top/Search Plan
							@endif
						</td>
						<td>@if(isset($banner->category->title) && $banner->category->title != NULL && $banner->category->title != ""){{$banner->category->title }} @else No category selected @endif</td>
						<td>@if(isset($banner->subcategory->title) && $banner->subcategory->title != NULL && $banner->subcategory->title != ""){{$banner->subcategory->title }} @else No sub-category selected @endif</td>
						<td>@if($banner->country != NULL && $banner->country != "") {{ $banner->country }} @else - @endif</td>
						<td>@if($banner->state != NULL && $banner->state != "") {{ $banner->state }} @else - @endif</td>
						<td>@if($banner->city != NULL && $banner->city != "") {{ $banner->city }} @else - @endif</td>
						<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
						<td>
							<ul class="list-inline">
								<li>
									<a href="{{ URL::to('admin/business/banner/block/'.$banner->id) }}">
					                    @if ($banner->is_blocked)
					                    	<button type="button" class="btn btn-danger btn_fixes" title="UnBlock"><i class="fa fa-unlock"></i></button>
				                    	@else
				                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
			                    		@endif
					                </a>
								</li>
								<li>
									<form action="{{ url('admin/business/banner/'.$banner->id) }}" method="POST" onsubmit="deleteBusinessBanner('{{$banner->id}}', '{{$banner->userSubscriptionPlan->subscription->title}}', event,this)">
										{{csrf_field()}}
										<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
	    </div>
	    <div id="menu2" class="tab-pane fade">
	    <div class="all_content">
			<table id="event_list" class="display">
				<thead>
					<tr>
						<th>Business ID</th>
						<th>Business Name</th>
						<th>Subscription Plan</th>
						<th>Banner</th>
						<th>Event Name</th>
						<th>Catgeory</th>
						<th>Country</th>
						<th>State</th>
						<th>City</th>
						<th>Created On</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($eventBanners as $banner)
					<tr>
						<td><a href="{{ url('admin/business/'.$banner->business->id) }}">{{ $banner->business->business_id}}</a></td>
						<td>{{ $banner->business->title}}</td>
						<td>{{ $banner->userSubscriptionPlan->subscription->title}}</td>
						<td>
							<div class="profiles_images"> 
								@if($banner->is_selected==2)
									@if($banner->businessEvent)
										@if($banner->businessEvent->banner!="" and $banner->businessEvent->banner!=NULL)
											<img src="{{ asset(config('image.banner_image_url').'event/thumbnails/small/'.$banner->businessEvent->banner) }}"/>
										@else
											<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
										@endif
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
								@elseif($banner->is_selected==1)
									@if($banner->business->banner!="")
										<img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->business->banner) }}"/>
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
								@else
									@if($banner->image!="")
										<img src="{{ asset(config('image.banner_image_url').'event/thumbnails/small/'.$banner->image) }}"/>
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
								@endif
							</div>
						</td>
						<td>@if(isset($banner->businessEvent->name) && $banner->businessEvent->name != NULL) {{$banner->businessEvent->name}} @else - @endif</td>
						<td>@if(isset($banner->category->title) && $banner->category->title != NULL && $banner->category->title != ""){{$banner->category->title }} @else No category selected @endif</td>
						<td>@if($banner->country != NULL && $banner->country != "") {{ $banner->country }} @else - @endif</td>
						<td>@if($banner->state != NULL && $banner->state != "") {{ $banner->state }} @else - @endif</td>
						<td>@if($banner->city != NULL && $banner->city != "") {{ $banner->city }} @else - @endif</td>
						<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
						<td>
							<ul class="list-inline">
								<li>
									<a href="{{ URL::to('admin/event/banner/block/'.$banner->id) }}">
					                    @if ($banner->is_blocked)
					                    	<button type="button" class="btn btn-danger btn_fixes" title="UnBlock"><i class="fa fa-unlock"></i></button>
				                    	@else
				                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
			                    		@endif
					                </a>
								</li>
								<li>
									<form action="{{ url('admin/event/banner/'.$banner->id) }}" method="POST" onsubmit="deleteEventBanner('{{$banner->id}}', '{{$banner->userSubscriptionPlan->subscription->title}}', event,this)">
										{{csrf_field()}}
										<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
	    </div>
	</div>
@endsection
<style type="text/css">
	#event_list,#business_list{width: 100%!important;}
</style>
@section('scripts')
	<script type="text/javascript">

		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		    $('#business_list').DataTable();
		    $('#event_list').DataTable();
		} );

		function deleteHomeBanner(id, title, event, form)
		{
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

		function deleteBusinessBanner(id, title, event,form)
		{
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

		function deleteEventBanner(id, title, event,form)
		{
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