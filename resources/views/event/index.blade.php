@extends('layouts.event-app')

@section('content')
<h2>Event Details</h2>

<div class="panel panel-default">
    <div class="panel-heading">{{$event->name}}</div>
    <div class="panel-body">
    <div class="body_content">
	    <div class="col-md-12">
		    <div class="row">
		    <div class="banner_content">
		    	<div class="col-md-3 col-sm-3 col-xs-6"><label>Banner Image : </label></div>
			    	<div class="col-md-9 col-sm-9 col-xs-6 ">
			    	<div class="banner_images"> 
				    	@if($event->banner)
	                    	<img src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
	                    @else
	                    	<p>No Banner Found</p>
	                    @endif
	                    </div>
                    </div>
		    </div>
		    

			    	<div class="col-md-6 col-sm-6">
					    	<div class="row">
						    	<div class="col-md-6 col-sm-6 col-xs-6"><label>Category : </label></div>
						    	<div class="col-md-6 col-sm-6 col-xs-6">{{$event->category->title}}</div>
					    	</div>
					    	<div class="row">
						    	<div class="col-md-6 col-sm-6 col-xs-6"><label>Event Keywords : </label></div>
						    	<div class="col-md-6 col-sm-6 col-xs-6">{{$event->keywords}}</div>
					    	</div>
			    	</div>
			    	<div class="col-md-6 col-sm-6">
				    	<div class="row">
					    	<div class="col-md-6 col-xs-6"><label>Name of Event :  </label></div>
					    	<div class="col-md-6 col-xs-6">{{$event->name}}</div>
				    	</div>
				    	<div class="row">
				    		<div class="col-md-6 col-xs-6"><label>Organizer Name :  </label></div>
				    		<div class="col-md-6 col-xs-6">{{$event->organizer_name}}</div>
				    	</div>
			    	</div>
			    	<div class="descript_section">
				    	<div class="col-md-3 col-sm-3 col-xs-6"><label>Description :</label></div>
				    	<div class="col-md-9 col-sm-9 col-xs-6">{{$event->description}}</div>
			    	</div>

			    	<div class="col-md-6 col-sm-6">
				    	<div class="row">
					    	<div class="col-md-6 col-sm-6 col-xs-6"><label>Event Start Date &amp; Time: </label></div>
					    	<div class="col-md-6 col-sm-6 col-xs-6">{{date('m/d/Y h:i A', strtotime($event->start_date_time))}}</div>
				    	</div>
				    	<div class="row">
					    	<div class="col-md-6 col-sm-6 col-xs-6"><label>Address : </label></div>
					    	<div class="col-md-6 col-sm-6 col-xs-6">{{$event->address}}</div>
				    	</div>
				    	<div class="row">
					    	<div class="col-md-6 col-sm-6 col-xs-6"><label>Pincode : </label></div>
					    	<div class="col-md-6 col-sm-6 col-xs-6">{{$event->pin_code}}</div>
				    	</div>
				    	<div class="row">
				    		<div class="col-md-6 col-sm-6 col-xs-6"><label>Country : </label></div>
				    		<div class="col-md-6 col-sm-6 col-xs-6">{{$event->country}}</div>
				    	</div>
			    	</div>

			    	<div class="col-md-6 col-sm-6">
			    	<div class="row">
			    		<div class="col-md-6 col-sm-6 col-xs-6"><label>Event End Date &amp; Time</label></div>
			    		<div class="col-md-6 col-sm-6 col-xs-6">{{date('m/d/Y h:i A', strtotime($event->end_date_time))}}</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-md-6 col-sm-6 col-xs-6"><label>City : </label></div>
			    		<div class="col-md-6 col-sm-6 col-xs-6">{{$event->city}}</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-md-6 col-sm-6 col-xs-6"><label>State : </label></div>
			    		<div class="col-md-6 col-sm-6 col-xs-6">{{$event->state}}</div>
			    	</div>
			    </div>

			   

			</div>
		</div>
		</div>
	</div>
</div>
@endsection
