@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="sponser_slider_section">
    <div id="da-slider" class="da-slider">
            <div class="da-slide">
               <div class="container">
                   <div class="slider_content">
                        <h5>Banner Sponsorship Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="text-title">Join Top Winners and Scale Your Business To The Top Most</p>
                        
                   </div>
 
                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
                <div class="da-slide">
                    <div class="container">
                       <div class="slider_content">
                          <h5>Banner Sponsorship Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="text-title">Join Top Winners and Scale Your Business To The Top Most</p>
                       </div>

                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
             <div class="da-slide">
            <div class="container">
               <div class="slider_content">
                   <h5>Banner Sponsorship Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="text-title">Join Top Winners and Scale Your Business To The Top Most</p>
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
<h5>BANNER SPONSORSHIP PACKAGES</h5>
    <div class="comn_textpara">
        <p>Banner advertising is a form of advertising that consists of a graphic, attempting to attract visitors or traffic to your weafricans business detail page.</p>
    </div>
<div class="eventpackage_detail">
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/view_icon.png">
    </div>
    <div class="event_text">
      <h6>GET HIGHER VISIBILITY</h6>
      <p>Banner ads with us help you stand out of the crowd and get higher visibility. </p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/data_icon.png">
    </div>
    <div class="event_text">
      <h6>REACH MORE VIEWERS</h6>
      <p>You can reach thousand of viewers every month with banner advertising on weafricans app. </p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-12 event_margin">
  <div class="wrap_event">
    <div  class="events_image">
      <img src="images/list_icon.png">
    </div>
    <div class="event_text">
      <h6>GIVES BETTER LISTING</h6>
      <p>It gives you a better listing than your competitors. All our banner ads campaigns are always display at the top of the app regardless of the category. </p>
    </div>
    </div>
  </div>
</div>
</div>
</section>
<section class="package_categories offer_sponser">
<div class="container">
<h5>We offer two packages in this section; “Elite Sponsor” and “Professional sponsor”  </h5>
<div class="wrap_package">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="row">
    <div class="leftwrap_package">
      <div class="col-md-12">
        <div class="row">
          <h6>ELITE SPONSOR</h6>
        <p>Elite sponsor display ads campaign on top of the app home page. 
            All weafricans app users in the selected country will be able to view this ads. This is the highest level of banner ads campaign we are offering at the moment. </p>
        <p>This package is good for businesses or services that which to increase the awareness of their brand as it does not have any specific targeted audience. 
        </p>
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
          <p>Professional Sponsor is almost the same with the elite sponsor but the difference is that it displays ads campaign on top of the apps home page to users in a selected state. </p>
          <p>This package is good for business or/ and services that wishes to promote their business to a particular state in a country.</p>
        </div>
      </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</section>
<section class="packages_categories sponser_packages">
<div class="container">
  <div class="pri-member-section2">
            <div class="pri-outerbox">
            @php
              $i=0
            @endphp
            @if(isset($plans) && count($plans) > 0)
            @foreach($plans as $plan)
            @if ($i == 0)
                <div class="col-md-6 col-sm-6 col-xs-12 ticket_margin">
                   <div class="ticket_box">
                    <div class="price_div" style="background-color: #137ea9;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2)}}<span class="down_Pay">/mo</span></h6></div>
                      <ul>
                        <li class="check">Display Ads Nationwide</li>
                        <li class="check">Display Ads all over the selected state</li>
                        <li class="check">Display Ads all over the City</li>
                        <li class="lightgrey_text">Display Ads within the Catagory</li>
                        
                      </ul>
                      <div class="signup_butn">
                    @if(!Auth::check())
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
                    @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
                    @else
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
                    @endif
                    </div>
                  </div>
                </div>
            @else
                <div class="col-md-6 col-sm-6 col-xs-12 ticket_margin">
                  <div class="ticket_box">
                    <div class="price_div" style="background-color: #06cc68;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2)}}<span class="down_Pay">/mo</span></h6></div>
            <ul>
              <li class="lightgrey_text">Display Ads Nationwide</li>
              <li class="check">Display Ads all over the selected state</li>
              <li class="check">Display Ads all over the City</li>
              <li class="lightgrey_text">Display Ads within the Catagory</li>
           
            </ul>
            <div class="signup_butn">
                    @if(!Auth::check())
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
                    @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
                    @else
                      <a href="{{url('sponsor/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
                    @endif
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
</div>
</section>

<section class="weafrican_link">
    <div class="container">
        <div class="ico_payment">
            <img src="images/weafricans-africans-go-global-flower-weafrican.png">
        </div>
         <p>Get your banner hosted at <a>weafricans.com</a> and we promise that you will soon feel the difference.</p>   
    </div>
</section>

 <section class="register_section sponser_register">
    <div class="container">
        <h5>Transform, Engage & Grow Your Business Today, It's Free.</h5>
        <p>Africans Business Solution For All Industries.</p>
        <div class="start_btn">
            <a href="{{ url('register-business/create') }}" type="button" class="btn btn-default">get started</a>
        </div>
        </div>
    </section>
    <section class="video_section sponser_register">
        <h5>featured <span>video</span></h5>
        <div class="container">
        <div class="youtube_video embed-responsive embed-responsive-16by9">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/-qzsO76k540" frameborder="0" allowfullscreen></iframe>
        </div>
        </div>
    </section>
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