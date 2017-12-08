@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-ban" aria-hidden="true"></i> Unapproved Business</h2>
	<hr>
	@include('notification')
	<br>
	
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th title="Serial Number">#</th>
				<th title="Business ID">BID</th>
				<th>Name</th>
				<th>Business Name</th>
				<th>Mobile Number</th>
				<th>Document Verified</th>
				<!-- <th>Likes</th>
				<th>Dislikes</th>
				<th>Favourites</th>
				<th>Followers</th>
				<th>Ratings</th> -->
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($businesses as $key => $business)
			<tr>
				<td>{{ ++$key }}</td>
				<td><a href="{{ url('admin/business/'.$business->id) }}">{{ $business->business_id}}</a> </td>
				<td> @if($business->user) {{$business->user->first_name }} {{ $business->user->last_name }} @endif</td>
				<td>{{ $business->title}} </td>
				
				<td>@if($business->user){{ $business->user->mobile_number}} @endif</td>
				<td>
					@if($business->is_identity_proof_validate==1)
						Identity Proof: Approved
					@else
						Identity Proof: Unapproved
					@endif
					<br>
					@if($business->is_business_proof_validate==1)
						Business Proof: Approved
					@else
						Business Proof: Unapproved
					@endif
				</td>
				<!-- <td>{{ $business->getLikes()}}</td>
				<td>{{ $business->getDislikes()}}</td>
				<td>{{ $business->getFavourites()}}</td>
				<td>{{ $business->getFollowers()}}</td>
				<td>{{ (int)$business->getRatings()}}</td> -->
				<td>{{ date_format(date_create($business->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						<!-- <li>
							<a href="{{ URL::to('admin/business/block/'.$business->id) }}">
			                    @if($business->is_blocked)
			                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
						<li>
							<a class="btn btn-warning btn_fixes" href="{{ url('admin/business/'.$business->id.'/edit') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li> -->
						<li>
							<a class="btn btn-default btn_fixes" href="{{ url('admin/business/'.$business->id) }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
</a>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		
	</script>
	<script type="text/javascript">
		
	</script>
@endsection
@section('scripts')
<style type="text/css">
	.error {
	    color: red;
	}
</style>
<script type="text/javascript">
	$(document).ready( function () {
	    $('#categories_list').DataTable();
	});
</script>
@endsection
