@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('styles')
    <link href="{{ asset('css/lightgallery/lightgallery.css')}}" rel="stylesheet">
    <style>
        .list-unstyled>li:first-child{
            display: block;
        }
        .list-unstyled>li{
        display:none;
    }
    </style>
@endsection
@section('content')
	<h2><i class="fa fa-shopping-cart" aria-hidden="true"></i> Products</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th title="Serial Number">#</th>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Image</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $key => $product) 
			<tr>
				<td> {{ ++$key }}</td>
				<td><a href="{{ url('admin/business/'.$product->business_id) }}">{{ $product->businessId}}</a></td>
				<td>{{ $product->business_name}}</td>
				<td>{{ $product->title}}  </td>
				<td>{{ $product->description}}</td>
                <td>{{ $product->price}}</td>
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
                            	@if($product->business_product_images_featured_image == $image)
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
				<td>{{ date_format(date_create($product->created_at), 'd M,Y') }}</td>
				<td>
					<a href="{{ URL::to('admin/product/block/'.$product->id) }}">
	                    @if($product->is_blocked)
	                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
	        		<form class="form_inline" action="{{ url('admin/product/'.$product->id) }}" method="POST" onsubmit="deleteProduct('{{$product->id}}', '{{$product->title}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash-o"></i></button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{ asset('js/lightgallery/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('js/lightgallery/lib/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
    	$('#lightgallery').lightGallery();
	}); 
		function deleteProduct(id, title, event,form)
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