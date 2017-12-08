@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-history" aria-hidden="true"></i> Transaction History</h2>
	<hr>
	@include('notification')
	<br>
	<div class="all-content">

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab">Subscription Plan History</a></li>
	    <li role="presentation"><a href="#event" aria-controls="event" role="tab" data-toggle="tab">Event Booking History</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane fade in active" id="subscription">
	    	<div class="subscription_list_wrapper">
	    		<table class="table dt_table">
	    			<thead> 
	    				<tr> 
	    					<th>#</th> 
	    					<th>User Name</th> 
	    					<th>Subscription Plan</th>
	    					<th>Plan Price</th>
	    					<th>User Price</th>
	    					<th>Reference Id</th> 
	    					<th>Purchased Date</th>
	    					<th>Expired Date</th> 
	    					<th>Status</th>
	    				</tr> 
	    			</thead> 
	    			<tbody> 
	    				@php $i=1; @endphp
	    				@if(isset($subscriptions))
		    				@foreach($subscriptions as $value)
		    					<tr> 
			    					<td>{{ $i }}</td> 
			    					<td>{{ $value->first_name }} {{ $value->last_name }}</td> 
			    					<td>{{ $value->subscription->title }}</td> 
			    					<td>{{ $value->amount.' '.$value->currency }}</td> 
			    					<td>{{ $value->user_amount.' '.$value->user_currency }}</td> 
			    					<td>{{ $value->reference_id }}</td> 
			    					<td>{{date('d-m-Y',strtotime($value->transaction_date))}}</td>
			    					<td>{{date('d-m-Y',strtotime($value->expired_date))}}</td>
	                                <td>{{$value->status}}</td>
			    				</tr>
			    				@php $i++; @endphp
		    				@endforeach
		    			@endif
	    			</tbody> 
	    		</table>
	    	</div>
	    </div>
	    <div role="tabpanel" class="tab-pane fade" id="event">
	    	<div class="subscription_list_wrapper">
	    		<table class="table dt_table" width="100%">
	    			<thead> 
	    				<tr> 
	    					<th>#</th> 
	    					<th>User Name</th> 
	    					<th>Event Name</th>
	    					<th>Total Tickets Booked</th>
	    					<th>Total Amount</th>
	    					<th>User Total Amount</th>
	    					<th>Reference Id</th> 
	    					<th>Purchase Date</th> 
	    					<th>Status</th> 
	    				</tr> 
	    			</thead> 
	    			<tbody> 
	    				@php $i=1; @endphp
	    				@if(isset($eventBookings))
		    				@foreach($eventBookings as $value)
		    					<tr> 
			    					<td>{{ $i }}</td> 
			    					<td>{{ $value->user->first_name }} {{ $value->user->last_name }}</td>
			    					<td>@if(isset($value->event))
			    						{{ $value->event->name }} @endif</td>
			    					<td>{{ $value->total_seats_buyed }}</td>
			    					<td>{{ $value->amount.' '.$value->currency }}</td>
			    					<td>{{ $value->user_amount.' '.$value->user_currency }}</td>
			    					<td>{{ $value->reference_id }}</td>
			    					<td>{{date('d-m-Y',strtotime($value->transaction_date))}}</td>
			    					<td>{{$value->status}}</td> 
			    				</tr> 
		    					@php $i++; @endphp
		    				@endforeach
		    			@endif
	    			</tbody> 
	    		</table>
	    	</div>
	    </div>
	  </div>

	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
	    $('.dt_table').DataTable();
	} );
</script>
@endsection