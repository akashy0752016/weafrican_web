@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-comments" aria-hidden="true"></i> Business Reviews</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Reviews Count</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($businesses as $business)
			<tr>
				<td><a href="{{ url('admin/business/'.$business->id) }}">{{ $business->business_id}}</a></td>
				<td>{{ $business->title}}</td>
				<td>{{ $business->getReviews()}}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/reviews/'.$business->id) }}">
			                    <button type="button" class="btn btn-default btn_fixes" title="View Reviews"><i class="fa fa-eye"></i></button>
			                </a>
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
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection