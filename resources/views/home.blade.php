@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
@if (Session::has('premiumPlan'))
@endif
<div class="slider_section">
    <div id="da-slider" class="da-slider">
            <div class="da-slide">
                <div class="container">
                   <div class="slider_content">
                        <h5>WeAfricans Marketplace</h5>
                    <h5>Your Go -To App for anything you need</h5>
                    <p>The geoloaction feature of our app will allow you to find the service that you need which is the closest to your place of residence.</p>
                   </div>
                    <div class="da-img"><img src="images/mobile_2.png" alt="image01" /></div>
                </div>
            </div>
                <div class="da-slide">
                <div class="container">
                   <div class="slider_content">
                        <h5>WeAfricans Marketplace</h5>
                    <h5>Your Go -To App for anything you need</h5>
                    <p>The geoloaction feature of our app will allow you to find the service that you need which is the closest to your place of residence.</p>
                   </div>
                    <div class="da-img"><img src="images/mobile_2.png" alt="image01" /></div>
                </div>
            </div>
             <div class="da-slide">
            <div class="container">
               <div class="slider_content">
                    <h5>WeAfricans Marketplace</h5>
                <h5>Your Go -To App for anything you need</h5>
                <p>The geoloaction feature of our app will allow you to find the service that you need which is the closest to your place of residence.</p>
               </div>
                <div class="da-img"><img src="images/mobile_2.png" alt="image01" /></div>
            </div>
        </div>
          
           
            <nav class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>
            </nav>
        </div>
</div>
<section class="first_section">
    <div class="container">
        <h5>A must App for All <span>businesses and services</span></h5>
        <div class="inner_first_container">
            <div class="col-md-6 pull-right">
            <div class="right_image">
                <img src="images/sec2img.png">
                </div>
            </div>
            <div class="col-md-6 content_text">
                <p>If you need to download one app for the year,</p>
                <h4>download weafricans app</h4>
                <div class="store_image">
                    <a href="https://play.google.com/store/apps/details?id=com.weafricans&hl=en" target="_blank"><img src="images/apple-store.png"></a>
                    <img src="images/play-store.png">
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="second_section">
        <div class="container">
        <h5>an easy solution for <span>everything you need</span></h5>
        <div class="wrap_text">

            <p>Are you in need of emergency plumbing services? Do you need a carpenter to fix your broken
            furniture? Or you need to find businesses like restaurants, manufacturers, suppliers, importer &
            exporters, or require a freelancer like a professional make up artist, models, graphic designer, or in
            need of an entertainment professionals like a professional film makers, cinematographer, sound
            designer, music artist, actors, actreses or even want to sell tickets for your events or book ticket for
            your favourite show?</p>
            <p class="color_para">If yes, then pick up your phone and download the Weafricans Marketplace app
            today.</p>
            <div class="dwnld_btn">
            <a href="https://play.google.com/store/apps/details?id=com.weafricans&hl=en" target="_blank"><button type="button" class="btn btn-default">download</button></a>
            </div>
            </div>
        </div>
    </section>
    <section class="fourth_section">
            <div class="container">
            <h5>a great benefit <span>for event organizers</span></h5>
            <div class="wrap_feature">
                <div class="col-md-6 col-sm-6 col-xs-12 center_div">
                    <img src="images/event_iphone_in_hand.png">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                <div class="text_wrap">
                    <p>Event organizers can benefit greatly from our app. Are you looking for the perfect platform to sell
                    tickets for your seminar, for your new movie, for your exhibition or for any events that require either
                    tracking the number of attendee or sell tickets for the events. Our app got you covered. You can use our
                    check-in App to scan ticket’s bar code and allow the visitors to enter into the event. You could also
                    manually type in the booking ID to confirm tickets. You will also be able to use our website to log into
                    the system with your event ID and access the list of your visitors and check them in before the event.
                    This will ensure that there is no confusion at the entrance.</p>
                    <p>Our app allows you to receive your payment within 24 - 48 hours of a customer booking their tickets. </p>
                    <p>Are you looking for the perfect venue to host your events? Find venue owners on our app. </p>
                    <p>there's more! <span><a href="{{url('services')}}">check our service page</a></span></p>
                    </div>
                    <div class="store_image">
                    <a href="https://play.google.com/store/apps/details?id=com.weafricans&hl=en" target="_blank"><img src="images/apple-store.png"></a>
                    <a href=""><img src="images/play-store.png"></a>
                    </div>
                </div>
            </div>
            </div>
    </section> 
    <section class="tab_section">
        <h5>awsome <span>features</span></h5>
        <div class="container">
         <ul class="nav nav-tabs responsive-tabs">
    <li class="active"><a data-toggle="tab" href="#business"><img src="images/icon-connecting-bus.png"> <h6> connecting business</h6><p>The best thing about our app is that it allows users to network with people in and around Africa and
    abroad. You can share your work experience, photos of your past work, a list of skill sets and more. </p></a></li>
    <li><a data-toggle="tab" href="#creation"><img src="images/icon-recreation.png"> <h6>find your next source of new creation</h6><p>The Weafricans Marketplace app is ideal to find the hottest and most happening places and tickets
    within your area, in Africa or outside Africa.</p></a></li>
    <li><a data-toggle="tab" href="#menu3"><img src="images/icon-africa.png"> <h6>to africa and beyond</h6><p>Our app not only covers places, businesses and people within Africa, but we also cater to users who are
    looking for African businesses abroad.</p></a></li>
  </ul>
  <div class="tab-content">
    <div id="business" class="tab-pane fade in active">
    <div class="wrap_tabpanel">
    <div class="col-md-9 col-sm-9">
    <p>The Weafricans Marketplace app is the best platform for you to promote your business and acquire new
customers. You can engage with them through real-time updates by using our in-app messaging
service. Your customers can follow you and get updates about any new product or service that you
introduce on the platform.</p>

     <p>Getting business in this competitive marketplace is hard. Weafricans Marketplace allows service
providers and service seekers to meet each other. From movie directors to restaurateurs, you will be
able to find the business you are looking for.</p>
    
     </div>
     <div class="col-md-3 col-sm-3">
        <div class="right_image">
            <img src="images/feature_image.png">
        </div>
     </div>
     </div>
    </div>
    <div id="creation" class="tab-pane fade">
    <div class="wrap_tabpanel">
    	<div class="col-md-9 col-sm-9">
       <p>Do you want to attend the music concert by your favourite band, attend play concert, attend seminar,
got to movie theatre for the threading movie or even attend a hi-fi party? Book your tickets on the app
at the click of a button. You never have to worry about payment and booking hassles with our app.
Easy and efficient payment gateways will allow you to book your tickets with ease. An immediate
confirmation will be sent to you once your booking has been made. Gone are the days of printing
papers, just show the ticket barcode directly from the mobile to the event organizer and vuuuuum ! you
are good to go! Alternatively, you can show the ticket id from your mobile and gain entry at a twinkle
of an eye.</p>
  
       </div>
     <div class="col-md-3 col-sm-3">
        <div class="right_image">
            <img src="images/Recreation.png">
        </div>
     </div>
     </div>
    </div>
    <div id="menu3" class="tab-pane fade">
       <div class="wrap_tabpanel">
       <div class="col-md-9 col-sm-9">
       <p>Are you craving to indulge in traditionally-made African food? Download our app and find African
restaurants in the foreign country you are currently residing in. Do you need the services of an African
seamstress for your upcoming wedding? You are sure to find her on our app. From baby saloon, hair
dressers, freelancers to caterers, models, film actors, music artist, you can easily find African-owned
businesses on our app.</p>
      <p>Event organisers who wish to organise events in foreign countries can use our app to find suppliers,
business partners and customers. You also have the option to sell the tickets via the app and receive
money in your local account.</p>
<p>With so many services available at just the swipe of a finger, you no longer need to be worried about
finding the things you want. Download our app today and experience its many benefits.</p>
  
      </div>
      <div class="col-md-3 col-sm-3">
        <div class="right_image">
            <img src="images/image2.png">
        </div>
     </div>
      </div>
    </div>
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
        <iframe width="560" height="315" src="https://www.youtube.com/embed/G4PQLyeJKY8" frameborder="0" allowfullscreen></iframe>
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
