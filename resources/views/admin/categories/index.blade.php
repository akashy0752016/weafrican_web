@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-th-large" aria-hidden="true"></i> Categories</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
				<th>Parent Category</th>
				<th>Icon</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
			<tr>
				<td>{{ $category->title}}</td>
				<td>
				@if($category->parent['title']!="")
					{{$category->parent['title']}}
				@else
					None
				@endif
				</td>
				<td>
					<img class="event_img" src="{{ asset(config('image.category_image_url').'thumbnails/small/'.$category->image) }}" class="responsive">
				</td>
				<td>{{ date_format(date_create($category->created_at), 'd M,Y') }}</td>
				<td>	
					<ul class="list-inline">
						<li>
							<a class="btn btn-warning btn_fixes" href="{{ url('admin/bussiness/category/'.$category->id.'/edit') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li>

						@if($category->id!=1 and $category->id!=2)
						<li>
							<a href="{{ URL::to('admin/bussiness/category/block/'.$category->id) }}">
			                    @if($category->is_blocked)
			                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
	
						<li>
							<form action="{{ url('admin/bussiness/category/'.$category->id) }}" method="POST" onsubmit="deleteCategory('{{$category->id}}', '{{$category->title}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash-o"></i></button>
							</form>
						</li>
						@else
							You cannot block/delete this category
						@endif
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#categories_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteCategory(id, title, event,form)
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