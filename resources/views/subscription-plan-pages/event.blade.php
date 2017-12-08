@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="eventadd_slider_section">
    <div id="da-slider" class="da-slider">
            <div class="da-slide">
               <div class="container">
                   <div class="slider_content">
                        <h5>Do you wish to create a massive awareness of your upcoming events? </h5>
                    <h5 class="h5-heading">Draw the best crowd from any part of the country down to your event with our advance campaign packages.</h5>
                    <p class="text-title">You will never worry anymore of empty seats in your event.</p>
                        
                   </div>
 
                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
                <div class="da-slide">
                    <div class="container">
                       <div class="slider_content">
                          <h5>Do you wish to create a massive awareness of your upcoming events?</h5>
                    <h5 class="h5-heading">Draw the best crowd from any part of the country down to your event with our advance campaign packages.</h5>
                    <p class="text-title">You will never worry anymore of empty seats in your event.</p>
                       </div>

                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
             <div class="da-slide">
            <div class="container">
               <div class="slider_content">
                   <h5>Do you wish to create a massive awareness of your upcoming events?</h5>
                    <h5 class="h5-heading">Draw the best crowd from any part of the country down to your event with our advance campaign packages.</h5>
                    <p class="text-title">You will never worry anymore of empty seats in your event.</p>
               </div>

                <!-- <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
            </div>
        </div>
          
           
            <nav class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>
            </nav>
        </div>
</div>
<section class="weafrican_event eventad_package">
<div class="container">
<h5>EVENTS AD PACKAGES</h5>
    <div class="comn_textpara">
        <p>Banner advertising is a form of advertising that consists of a graphic, attempting to attract visitors or traffic to your weafricans business detail page.</p>
    </div>
<div class="eventpackage_detail">
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/event-icon-1.png">
    </div>
    <div class="event_text">
      <h6>UNIQUE EVENTS CAMPAIGNS</h6>
      <p>Weafricans comes to you with a unique events campaign solutions.  A best combinations which suits any acquisition strategy and goals with just about any events.</p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/event-icon-2.png">
    </div>
    <div class="event_text">
      <h6>PROMOTE EVENTS ACROSS WORLD</h6>
      <p>From promoting your events within your city to all the nations and even outside the country as it suit your requirements.</p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/event-icon-3.png">
    </div>
    <div class="event_text">
      <h6>BE ON TOP OF THE CATAGORY</h6>
      <p>Ads will be place as a banner on top of the chosen category within the any region as per your selection. </p>
    </div>
    </div>
  </div>
</div>
</div>
</section>
<section class="package_categories">
<div class="container">
<h5>Our ads packages are group into four categories </h5>
<div class="wrap_package">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="row">
    <div class="leftwrap_package">
      <div class="col-md-12">
        <div class="row">
          <h6>ELITE EVENT ADS</h6>
          <p><span class="grey_text">With this package you are assured that your event banner will be display on top of the selected category / subcategory in the selected country.</span> For instance, if your selected location is Zambia, and your selected category or subcategory is Corporate Seminar, your event banner would be shown at the top of the Corporate Seminar event category listing page for all the users in Zambia. This way all the targeted audience in Zambia that visited the Corporate Seminar category in our app will be able to view your banner instantly, which will definitely increase the of the number of attendees.</p>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <h6>STANDARD EVENT ADS</h6>
          <p><span class="grey_text">This is a city package. Ads will be display as per the selected city/town.</span></p>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="row">
    <div class="rightwrap_package">
       <div class="col-md-12">
        <div class="row">
          <h6>PROFESSIONAL SPONSOR</h6>
          <p><span class="grey_text">This package is similar to the elite events ads, in this package the event banner would be shown in the selected state only.</span> For instance, Event banner will be shown to Lusaka audience or Copperbelt audience or Muchinga audience. As per your selected state only.</p>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <h6>TOP EVENT LISTING</h6>
          <p><span class="grey_text">Your event will be listed on top event listing page in the selected category. And also will be listed on the top list when a user search for events that suits your listed event as per keyword.</span> For instance: If you listed your event in the corporate seminar category with keywords like, startup conference, business talk, business event. Any user that searches for business event will see your event on top of the search results. </p>
        </div>
      </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</section>
<section class="eventparty_images">
  <img src="images/weafricans-africans-go-global-event-big-image.png" alt="weafricans-africans-go-global-event-big-image.png">
</section>
<section class="packages_categories">
<div class="container">
  <h5>Place your event infront of the right people</h5>
  <div class="wrap_tickets">
   @php
      $i=0
    @endphp
    @if(isset($plans) && count($plans) > 0)
    @foreach($plans as $plan)
    @if ($i == 0)
    <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
      <div class="row">
        <div class="ticket_box">
          <div class="price_div" style="background-color: #f7931d;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2) }}<span class="down_Pay">/mo</span></h6></div>
            <ul>
              <li class="check">Events Banner</li>
              <li class="check">Ads display nationwide within catagory</li>
              <li class="lightgrey_text">Ads show nationwide during search</li>
              <li class="check">Ads Display within state</li>
              <li class="check">Ads Display within the city</li>
              <li class="lightgrey_text">Event Listing on top of Event Catagory</li>
            </ul>
            <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(count(Auth::user()->events) == 0)
                <a href="" data-toggle="modal" data-target="#events" class="btn btn-default">Buy Now</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
          </div>
        </div>
      </div>
    </div>
    @elseif ($i == 1)
    <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
      <div class="row">
        <div class="ticket_box">
        <div class="price_div" style="background-color: #7ead41;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2)}}<span class="down_Pay">/mo</span></h6></div>
          <ul>
              <li class="check">Events Banner</li>
              <li class="lightgrey_text">Ads display nationwide within catagory</li>
              <li class="lightgrey_text">Ads show nationwide during search</li>
              <li class="check">Ads Display within state</li>
              <li class="check">Ads Display within the city</li>
              <li class="lightgrey_text">Event Listing on top of Event Catagory</li>
            </ul>
            <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(count(Auth::user()->events) == 0)
                <a href="" data-toggle="modal" data-target="#events" class="btn btn-default">Buy Now</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
            </div>
        </div>
      </div>
    </div>
    @elseif ($i == 2)
    <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
      <div class="row">
        <div class="ticket_box">
        <div class="price_div" style="background-color: #137ea9;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2)}}<span class="down_Pay">/mo</span></h6></div>
          <ul>
              <li class="check">Events Banner</li>
              <li class="lightgrey_text">Ads display nationwide within catagory</li>
              <li class="lightgrey_text">Ads show nationwide during search</li>
              <li class="lightgrey_text">Ads Display within state</li>
              <li class="check">Ads Display within the city</li>
              <li class="lightgrey_text">Event Listing on top of Event Catagory</li>
            </ul>
            <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(count(Auth::user()->events) == 0)
                <a href="" data-toggle="modal" data-target="#events" class="btn btn-default">Buy Now</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
            </div>
        </div>
      </div>
    </div>
    @else
    <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
      <div class="row">
        <div class="ticket_box">
        <div class="price_div" style="background-color: #b21856;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2)}}<span class="down_Pay">/mo</span></h6></div>
          <ul>
              <li class="lightgrey_text">Events Banner</li>
              <li class="lightgrey_text">Ads display nationwide within catagory</li>
              <li class="check">Ads show nationwide during search</li>
              <li class="lightgrey_text">Ads Display within state</li>
              <li class="check">Ads Display within the city</li>
              <li class="check">Event Listing on top of Event Catagory</li>
            </ul>
            <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(count(Auth::user()->events) == 0)
                <a href="" data-toggle="modal" data-target="#events" class="btn btn-default">Buy Now</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('event/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
            </div>
        </div>
      </div>
    </div>
    @endif
    @php
        $i++
        @endphp
    @endforeach
    @else
      <p> No Plans found </p>
    @endif
  </div>
</div>
</section>
 <section class="register_section">
    <div class="container">
        <h5>Transform, Engage & Grow Your Business Today, It's Free.</h5>
        <p>Africans Business Solution For All Industries.</p>
        <div class="start_btn">
            <a href="{{ url('register-business/create') }}" type="button" class="btn btn-default">get started</a>
        </div>
        </div>
    </section>
    <section class="video_section">
        <h5>featured <span>video</span></h5>
        <div class="container">
        <div class="youtube_video embed-responsive embed-responsive-16by9">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/-qzsO76k540" frameborder="0" allowfullscreen></iframe>
        </div>
        </div>
    </section>
<!-- show message Modal -->
    <div class="modal fade" id="events" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Message</h5>
            </div>
            <div class="modal-body">
              <p>Please create the event first.<p>
              <a href="{{url('business-event')}}" class="btn btn-warning text-center">Add Event<a>

            </div>
        </div>
    </div>
</div>
@endsection
@section('header-scripts')
    <link href="css/slider_css.css" rel="stylesheet" type="text/css">
    <noscript>
        <link rel="stylesheet" type="text/css" href="css/nojs.css" />
    </noscript>
    <script type="text/javascript" src="js/jquery.cslider.js"></script>
    <script type="text/javascript" src="js/Modernizr.js"></script>
    <script type="text/javascript">
        $(function() {
        
            $('#da-slider').cslider({
                autoplay    : true,
                bgincrement : 450
            });
          
        
        });
    </script>   


@endsection