@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
<h2>View User Business Event</h2>
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
		<div class="panel-body event_pannel">
			<div class="form-group">
				<label class="control-label col-md-2">Category:</label>
				<div class="col-md-4">
				{{ $event->category->title  }}
					
				</div>
				<label class="control-label col-md-2">Name Of Event</label>
				<div class="col-md-4">
				{{ $event->name }}
					
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Event Keywords:</label>
				<div class="col-md-4">
				{{ $event->keywords  }}
					
				</div>
				
				<label class="control-label col-md-2">Organizer Name</label>
				<div class="col-md-4">
					{{ $event->organizer_name }}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Event Description:</label>
				<div class="col-md-10">
				{{ $event->description  }}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Event Start Date &amp; Time :</label>
				<div class="col-md-4">
					{{date('m/d/Y h:i A', strtotime($event->start_date_time))}}
				</div>
				<label class="control-label col-md-2">Event End Date &amp; Time :</label>
				<div class="col-md-4">
					{{date('m/d/Y h:i A', strtotime($event->end_date_time))}}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Address</label>
				<div class="col-md-4">
					{{ $event->address }}
				</div>
				<label class="control-label col-md-2">City:</label>
				<div class="col-md-4">
					{{ $event->city }}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">State</label>
				<div class="col-md-4">
					{{ $event->state }}
				</div>
				<label class="control-label col-md-2">Country:</label>
				<div class="col-md-4">
					{{ $event->country }}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Pin code:</label>
				<div class="col-md-4">
					{{ $event->pin_code }}
				</div>
				<label class="control-label col-md-2">Event Log Id:</label>
				<div class="col-md-4">
					{{ $event->event_log_id }}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Event Banner:</label>
				<div class="col-md-10">
					<div class="banner_images"> 
			    	@if($event->banner)
                    	<img src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
                    @else
                    	<p>No Banner Found</p>
                    @endif
                    </div>
                </div>
			</div>
			@if(isset($event->total_seats) and ($event->total_seats!="" or $event->total_seats=0))
				<fieldset>
	                <legend>Event Seating Plan</legend>
	            </fieldset>
	            <div class="form-group form_pad">
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label">Total Seats :</label>
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label align-left">{{ $event->total_seats }}</label>
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label">Total Seats Buyed :</label>
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label align-left">{{ $event->soldEventTickets->sum('total_tickets_buyed') }}</label>
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label">Total Seats Left :</label>
                	<label class="col-md-2 col-sm-2 col-xs-6 control-label align-left">{{ $event->total_seats- $event->soldEventTickets->sum('total_tickets_buyed') }}</label>
                </div>
                @if(count($eventSeatingPlans)>0)
                    @foreach($eventSeatingPlans as $eventSeatingPlans)
                        <div class="form-group form_pad">
                            <label class="col-md-2 col-sm-2 col-xs-6 control-label">
                            @if($eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!="" and $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!=NULL)
                            	{{ $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id) }} 
                            @else
                            	{{$eventSeatingPlans->title}}
                            @endif Seats :</label>
                            	@if($eventSeatingPlans->getEventPlanSeats($event->id, $eventSeatingPlans->id))
                            		<label class="col-md-2 col-sm-2 col-xs-6 control-label align-left">{{$eventSeatingPlans->getEventPlanSeats($event->id, $eventSeatingPlans->id)}}</label>
                            	@else
                            		<label class="col-md-2 col-sm-2 col-xs-6 control-label align-left"></label>
                            	@endif
                            <label class="col-md-2 col-sm-2 col-xs-6 control-label">
                            @if($eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!="" and $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id)!=NULL)
                            	{{ $eventSeatingPlans->getEventPlanAlias($event->id, $eventSeatingPlans->id) }} 
                            @else
                            	{{$eventSeatingPlans->title}}
                            @endif
                             Per Ticket Price :</label>
                            <label class="col-md-2 col-sm-2 col-xs-6 control-label align-left">{{ $eventSeatingPlans->getEventPlanSeatsPrice($event->id, $eventSeatingPlans->id) }}</label>
                        </div>
                    @endforeach
                @endif
                <fieldset>
                    <legend>User Buyed Event Tickets</legend>
                </fieldset>
                @if(isset($soldEventTickets) and count($soldEventTickets)>0)
                	<div class="form-group">
                		<div class="col-md-12">
	                		<table class="table">
							  <thead class="thead-default">
							    <tr>
							      <th>#</th>
							      <th>UserName</th>
							      <th>Tickets Buyed</th>
							      <th>Total Cost<small>Excluding Tax</small></th>
							      <th>Buyed On</th>
							    </tr>
							  </thead>
							  <tbody>
						      @foreach($ticket_details as $key => $ticket_detail)
						      	<tr>
						      		<td>{{$key+1}}</td>
						      		<td>{{$ticket_detail->first_name}} {{$ticket_detail->last_name}}</td>
						      		<td>
						      		@foreach(explode(',',$ticket_detail->seating_plans) as $seating_plan)
						      			{{ $event->seatingPlan($seating_plan,$event->id) }} : {{ $event->soldTicket($ticket_detail->user_id,$ticket_detail->business_event_id,$ticket_detail->event_transaction_id,$seating_plan)->total_tickets_buyed }}&nbsp;&nbsp;
						      		@endforeach
						      		</td>
						      		<!-- <td>{{ $ticket_detail->totalprice }} {{ $ticket_detail->currency }}</td> -->
						      		<td>{{ $ticket_detail->totalprice }} NGN</td>
						      		<td>{{ date('m/d/Y h:i A', strtotime($ticket_detail->created_at)) }}</td>
						      	</tr>
						      @endforeach
							  </tbody>
							</table>
						</div>
                	</div>
                @else
	                <div class="form-group">
	                	<label class="col-md-2 control-label">No Records Found</label>
	                </div>
                @endif
            @else
            <div class="form-group">
                <label class="col-md-5 control-label">Seating Plan is not added</label>
            </div>
            @endif
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