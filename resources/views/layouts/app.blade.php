<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
@if(isset($flag) and $flag==0)
<body>
@elseif(isset($flag) and $flag==1)
<body class="fixed_header_layout">
@endif
<div class="preloader">
<div class="pre_img">
<div class="sk-circle">
  <div class="sk-circle1 sk-child"></div>
  <div class="sk-circle2 sk-child"></div>
  <div class="sk-circle3 sk-child"></div>
  <div class="sk-circle4 sk-child"></div>
  <div class="sk-circle5 sk-child"></div>
  <div class="sk-circle6 sk-child"></div>
  <div class="sk-circle7 sk-child"></div>
  <div class="sk-circle8 sk-child"></div>
  <div class="sk-circle9 sk-child"></div>
  <div class="sk-circle10 sk-child"></div>
  <div class="sk-circle11 sk-child"></div>
  <div class="sk-circle12 sk-child"></div>
</div>
<img src="{{asset('images/logo.png')}}">
</div>
</div>
    <div class="top-container container-fluid">
    @if(isset($cmsFlag) && $cmsFlag == 1)
    @else
		  @include('includes.header')
    @endif
		    @include('includes.top-menu')
            	<div class="@if(isset($cmsFlag) && $cmsFlag ==1) cms-content @else main-content @endif">
            		@yield('content')
            	</div>
              @if(isset($cmsFlag) && $cmsFlag == 1)
              @else
                @include('includes.footer')
            @endif
        @yield('scripts')
    </div>
</body>
<script>
     $(document).ready(function() {
    //Preloader
    $(window).load(function() {
       preloaderFadeOutTime = 1000;
    function hidePreloader() {
    var preloader = $('.preloader');
    preloader.fadeOut(preloaderFadeOutTime);
    }
    hidePreloader();
     new WOW().init();
    });

  });
     
</script>
</html>