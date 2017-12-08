@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-money" aria-hidden="true"></i> Subscription Plans</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Name</th>
				<th>Coverage</th>
				<th>Type</th>
				<th>Keywords limit</th>
				<th>Price (per month)</th>
				<th>Validity Period (in days)</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($subscriptions as $subscription)
			<tr>
				<td>{{ $subscription->title}}</td>
				<td>{{ $subscription->coverage}}</td>
				<td>{{ ucfirst($subscription->type)}}</td>
				<td>@if($subscription->keywords_limit){{ $subscription->keywords_limit}} @else NA @endif</td>
                <td>{{ $subscription->price}}</td>
                <td>{{ $subscription->validity_period }}</td>
				<td>{{ date_format(date_create($subscription->created_at), 'd M,Y') }}</td>
				<td>
					<a class="btn btn-info btn_fixes" href="{{ url('admin/subscription/plan/'.$subscription->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil"></i></a>
					<a href="{{ URL::to('admin/subscription/plan/block/'.$subscription->id) }}">
	                    @if($subscription->is_blocked)
	                    	<button type="button" class="btn btn-danger" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable({
		        "pageLength": 12,
		    });
		} );
	</script>
@endsection