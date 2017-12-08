@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-list" aria-hidden="true"></i> Event Categories List</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th>Title</th>
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
					<img class="event_img" src="{{ asset(config('image.event_category_image_url').'thumbnails/small/'.$category->image) }}" class="responsive">
				</td>
				<td>{{ date_format(date_create($category->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/category/event/block/'.$category->id) }}">
			                    @if($category->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
						<li>
							<a class="btn btn-warning btn_fixes" href="{{ url('admin/category/event/'.$category->id.'/edit') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li>
						<li>
							<form action="{{ url('admin/category/event/'.$category->id) }}" method="POST" onsubmit="deleteCategory('{{$category->id}}', '{{$category->title}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash-o"></i></button>
							</form>
						</li>
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