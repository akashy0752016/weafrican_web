@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="business-event_slider_section">
    <div id="da-slider" class="da-slider">
            <div class="da-slide">
               <div class="container">
                   <div class="slider_content">
                        <h5>Business Category Ads Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="para-title">Join Top Winners and Scale Your Business To The Top Most</p>
                        
                   </div>

                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
                <div class="da-slide">
                    <div class="container">
                      <div class="slider_content">
                        <h5>Business Category Ads Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="para-title">Join Top Winners and Scale Your Business To The Top Most</p>
                        
                   </div>

                   <!--  <div class="da-img"><img src="images/service_top_banner_mobile_image.png" alt="image01" /></div> -->
                </div>
            </div>
             <div class="da-slide">
            <div class="container">
               <div class="slider_content">
                        <h5>Business Category Ads Packages</h5>
                    <h5 class="h5-heading">Advertise in your local area, city, nationwide, or even internationally!</h5>
                    <p class="para-title">Join Top Winners and Scale Your Business To The Top Most</p>
                        
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
<section class="business-market">
<div class="container">
 <div class="business-market-heading">
        <h5 class="pri-menber-heading"> Do you want to dominate your market and fast track your business? </h5>
          <p class="pri-desi text-center">Get guaranteed visibility with category ads on weafricans app and boost your business.  </p>
      </div>
<div class="event_detail">
  <div class="col-md-4 col-sm-4">
  <div class="wraps_event">
    
    <div class="event_text">
      <h6>MAXIMIZE YOUR BUSINESS</h6>
      <p>Maximize your business leads with an ad featuring your logo, website link and promo text. It's a great opportunity for you, to let the people looking for your product and services know about you. You can also geographically localize to the target audience. </p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4">
  <div class="wraps_event">
    
    <div class="event_text">
      <h6>GET SEEN AT THE TOP</h6>
      <p>Just choose category / sub category for your business and get seen at the top or at your desired location. This is a well-organized interface with thousand of searches every day. </p>
    </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4">
  <div class="wraps_event">
   
    <div class="event_text">
      <h6>DISPLAY YOUR AD</h6>
      <p>All ads display and search top plan in this package runs within the categories only. You can use your existing business banner or choose different banner that specifies your business details and services.You can choose different location as well as different category or sub category as per your suitability and your budget to display your ads. </p>
    </div>
    </div>
  </div>
</div>
</div>
</section>
<section class="package_detail">
<div class="container">
       <h5>In this package we offer 4 types of ads, all are well organize and structured according to your suitability and requirements.</h5>
<div class="wrap_feature">
    <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="row mobile_fimage">
            <img src="images/weafricans-africans-go-global-ads-image.png">
            </div>
    </div>
    <div class="col-md-7 col-sm-7 col-xs-12 feature_usertext">
        <div class="row">
            <div class="wrap_listdiv">
            <div class="common_div">
            <div class="text_div">
                <h6>ELITE BUSINESS</h6>
                <p>Elite Business displays your ads in a selected category or subcategory and make it visible nationwide within the selected country. Example If you are a music artist, your category is entertainment and your subcategory is music artist. Your banner will be visible on top of all music artist subcategory within the selected country. This package is very good for businesses or services that wishes to target a huge number of targeted users within the country under a specific category.</p>
            </div>
            </div>
                <div class="common_div">
                <div class="text_div">
                    <h6>PROFESSIONAL BUSINESS</h6>
                    <p>Professional Business is almost the same with the elite business but the difference is that the visibility is tailored within the selected state. All other features remain the same. This package is good for businesses that are interested to only the customers within the selected state of the selected category / subcategory.</p>
                </div>
                </div>
                <div class="common_div">
               
                <div class="text_div">
                    <h6>STANDARD BUSINESS</h6>
                    <p>Basic Business is also almost the same with the “Professional Business” the only difference is that it run within the selected city only. This ads package is good and suitable for business or services that do not wish to attract users outside the city.</p>
                </div>
                </div>
                <div class="common_div">
                <div class="text_div">
                    <h6>TOP BUSINESS SEARCH</h6>
                    <p>Top Business Search ads are different ads. This is not a banner ads. This is a search package. Get your business on top position of the weafricans search results and give it the sponsor label. Businesses or services with top search package are 10 times more likely to be seen during search. This package is good for businesses or services that want to put their businesses on top of the search engine of weafricans app. Your business will be on top of your selected category or sub category listing page as well. </p>
                </div>
            </div>
            </div>
        </div>
    </div>
 </div>
 </div>
</section>

<section class="packages_categories business_priceplanning">
<div class="container">
  <h5>Plans & <span> Pricing </span></h5>
  <p class="text-center plan_price">Kindle view and compare all business ads packages as listed below</p>
  <div class="wrap_tickets">
    @php
      $i=0
    @endphp
    @if(isset($plans) && count($plans) > 0)
    @foreach($plans as $plan)
      @if($i == 0)
      <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
        <div class="row">
          <div class="ticket_box">
            <div class="price_div" style="background-color: #f7931d;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2) }}<span class="down_Pay">/mo</span></h6></div>
             <div class="text-center middle_text">
              <p>Banner Display</p>
              <p><span class="lightgrey_text">Display in the</span> Subcatagory <span class="lightgrey_text"> witin the </span> Nation, State, City</p>
              <p class="lightgrey_text">Business on top of search results and listing in the subcatagory</p>
            </div>
              <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      @elseif($i == 1)
      <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
        <div class="row">
          <div class="ticket_box">
          <div class="price_div" style="background-color: #7ead41;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2) }}<span class="down_Pay">/mo</span></h6></div>
            <div class="text-center middle_text">
              <p>Banner Display</p>
              <p><span class="lightgrey_text">Display in the</span> Subcatagory <span class="lightgrey_text"> witin the </span><span class="lightgrey_text"> Nation, </span>State, City</p>
              <p class="lightgrey_text">Business on top of Search Results and Listing in the subcatagory</p>
            </div>
              <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
              </div>
          </div>
        </div>
      </div>
      @elseif($i == 2)
      <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
        <div class="row">
          <div class="ticket_box">
          <div class="price_div" style="background-color: #137ea9;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2) }}<span class="down_Pay">/mo</span></h6></div>
            <div class="text-center middle_text">
              <p>Banner Display</p>
              <p ><span class="lightgrey_text">Display in the </span> subcatagory <span class="lightgrey_text"> witin the </span><span class="lightgrey_text"> Nation, State, </span>City</p>
              <p class="lightgrey_text">Business on top of search Results and Listing in the subcatagory</p>
            </div>
              <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @endif
              </div>
          </div>
        </div>
      </div>
      @else
      <div class="col-md-3 col-sm-3 col-xs-12 ticket_margin">
        <div class="row">
          <div class="ticket_box">
          <div class="price_div" style="background-color: #b21856;"><p>{{ $plan->title }}</p><h6><span class="currency_up">{{ $plan->currency }}</span>{{ round($plan->price, 2) }}<span class="down_Pay">/mo</span></h6></div>
            <div class="text-center middle_text">
              <p class="lightgrey_text">No Banner Display</p>
              <p ><span class="lightgrey_text">Display in the </span> subcatagory <span class="lightgrey_text"> witin the </span><span class="lightgrey_text"> Nation, State,</span> City</p>
              <p>Business on top of search Results and Listing in the subcatagory</p>
            </div>
              <div class="signup_butn">
              @if(!Auth::check())
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Sign up</a>
              @elseif(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
              @else
                <a href="{{url('business/banner/buy/'.$plan->id)}}" class="btn btn-default">Buy Now</a>
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
<section class="payment_section blog_section">
  <div class="container">
    <div class="ico_payment">
      <img src="images/weafricans-africans-go-global-speaker-image.png">
    </div>
    <p>Advertisement is an effective way to promote your business, gain global visibility and reach target audience across the world. Its a great chance for you to increase your brand awareness in an interesting & creative way and to stand unique among the competitors. Use Weafricans online advertising services to promote your business information such as news, press releases, articles, blogs, forum, trade show, products and services.</p>
    <p>Products and services are important things in a business. It is essential to make it strong as it is the foundation of a business. They have to be showcased in an attractive manner to gain the attention of the customers. Weafricans displays your business products & services in a beautiful and professional way along with the required details and image. This enables you to get more inquiries from the potential customers worldwide.</p>
    
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