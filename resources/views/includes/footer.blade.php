<footer>
		<div class="container">
		<div class="row">
			<div class="col-md-7 text-left col-sm-7 col-xs-12 all_about">
			<div class="row">
				<ul class="footer-linkss list-inline">
                    <li class="{{ strpos(Request::path(), 'about') !== false ? 'active' : '' }}"><a href="{{url('about')}}">About Us</a></li>
					@foreach($cmsPages as $cms)
                        @if($cms->slug!='about-us')
    					   <li> <a href="{{url('cms/'.$cms->slug)}}">{{$cms->title}}</a> </li>
                        @endif
					@endforeach
			 	</ul>
			</div>
			</div>
			<div class="col-md-5  text-right col-sm-5 col-xs-12 app_store">
				<div>
					<!-- <p>available on</p> -->
					<ul class="list-inline image_sep">
						<li class="app_img"> <a href="https://play.google.com/store/apps/details?id=com.weafricans&hl=en" target="_blank"><img src="{{asset('images/apple-store.png')}}"></a> </li>
					    <li class="store_img"> <a href="#"><img src="{{asset('images/play-store.png')}}"></a> </li>
					</ul>
				</div>
			</div>
			</div>
		</div>
		<div class="container">
		<div class="row">
			<div class="col-md-6 text-left col-sm-6 col-xs-12 copyright_text">
			<div class="row">
				<p>copyright @ Weafricans Digital Technologies Limited. All Rights Reserved</p>
			</div>
			</div>
            <div class="social_icon col-md-6 col-sm-6 col-xs-12">
                <ul>
                    <li><a href="https://www.facebook.com/weafricansapp/" target="_blank" class="fb"></a></li>
                    <li><a href="https://twitter.com/Weafricansapp" target="_blank" class="twt"></a></li>
                    <li><a href="#" class="link"></a></li>
                    <!-- <li><a href="#" class="pin"></a></li> -->
                    <li><a href="https://plus.google.com/107943245633477453175" target="_blank" class="gplus"></a></li>
                    <li><a href="https://www.instagram.com/weafricansapp/" target="_blank" class="insta"></a></li>
                </ul>
            </div>
		</div>
		</div>
         
        <!-- BEGIN JIVOSITE CODE {literal} -->
        <script type='text/javascript'>
        (function(){ var widget_id = 'NAsE2OI4Bh';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
        <!-- {/literal} END JIVOSITE CODE -->
    
		<link href="https://vtimbuc.github.io/bootstrap-responsive-tabs/dist/css/bootstrap-responsive-tabs.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="https://vtimbuc.github.io/bootstrap-responsive-tabs/dist/js/jquery.bootstrap-responsive-tabs.min.js"></script>
        <style type="text/css">

</style>
	<script>
    $('.responsive-tabs').responsiveTabs({
	  accordionOn: ['xs', 'sm'] // xs, sm, md, lg
	});

	
	   		 $("#event_toggle").click(function(){
	    	$(" #event_slide").slideToggle();

	    });
/*             $('.responsive-tabs').responsiveTabs({
      accordionOn: ['xs', 'sm'] // xs, sm, md, lg
    });*/
             $("#subscription_toggle").click(function(){
            $(" #subscription_slide").slideToggle();
             });
/*scripr for about us page*/
$(document).ready(function(){
	if($(window).width() >= 768){
	$(".first_content_dasktop").hide();
	var isShow = false;
    $(".find").click(function(){

$(".secnd_content_dasktop").hide();
$(".third_content_dasktop").hide();
$(".fourth_content_dasktop").hide();

    	
    	if(isShow){
    		$(".first_content_dasktop").slideUp(function(){
                $('.find').first().show();
    			
    			isShow = false;
    			var height = $(this).css('height');
    			    			 $( ".separate_botm" ).css("margin-bottom","0px");


    			 $( ".separate_box" ).css("margin-bottom","0px");
    		});

    	} else {
    		$(".first_content_dasktop").slideDown(function(){
                 $('.find').first().hide();
                 $('.find2').first().show();
               $('.find3').first().show();
               $('.find4').first().show();
    			
    			isShow = true;
    			/*var height = $(this).css('height');
               
    			 $( ".separate_botm" ).css("margin-bottom","0px");
    			$( ".separate_box" ).css("margin-bottom",height);*/
    		});
    	}
    
  // .toggleClass( "big-blue", 1000, "easeOutSine" );
    	
    });
}
 if($(window).width() <= 767){
	$(".first_content_mobile").hide();
	var isShow = false;
    $(".find").click(function(){
    	
       if(isShow){
       	isShow = false;
    		$(".first_content_mobile").slideUp();

    	} else {
    		isShow = true;
    		
    		$(".first_content_mobile").slideDown();
          
    	}
    
    });
};   
});


$(document).ready(function(){

	if($(window).width() >= 768){
	$(".secnd_content_dasktop").hide();
	var isShow = false;
    $(".find2").click(function(){
    	$(".first_content_dasktop").hide();
		$(".third_content_dasktop").hide();
		$(".fourth_content_dasktop").hide();
    	
       if(isShow){
    		$(".secnd_content_dasktop").slideUp("fast",function(){
    			            $('.find2').first().show();

    			isShow = false;
    			var height = $(this).css('height');
    			    			 $( ".separate_botm" ).css("margin-bottom","0px");

    			 $( ".separate_box" ).css("margin-bottom","0px");
    		});

    	} else {
    		$(".secnd_content_dasktop").slideDown("900",function(){
    	       $('.find2').first().hide();
               $('.find').first().show();
               $('.find3').first().show();
               $('.find4').first().show();
    			isShow = true;
    			/*var height = $(this).css('height');

    			 $( ".separate_botm" ).css("margin-bottom","0px");

    			$( ".separate_box" ).css("margin-bottom",height);*/
    		});
    	}
    
    });
};
	if($(window).width() <= 767){
	$(".secnd_content_mobile").hide();
	var isShow = false;
    $(".find2").click(function(){
    	
       if(isShow){
       	isShow = false;
    		$(".secnd_content_mobile").slideUp();
                       /* $(this).first().show();*/


    	} else {
    		isShow = true;

            /*$(this).first().hide();*/
    		$(".secnd_content_mobile").slideDown();
    	}
    
    });
};
});
$(document).ready(function(){
	if($(window).width() >= 768){
	$(".third_content_dasktop").hide();
	var isShow = false;
    $(".find3").click(function(){
    	$(".first_content_dasktop").hide();
		$(".secnd_content_dasktop").hide();
		$(".fourth_content_dasktop").hide();

    	if(isShow){

    		$(".third_content_dasktop").slideUp("900",function(){
                 $('.find3').first().show();
    			
    			isShow = false;
    			/*var height = $(this).css('height');
    			    			 $( ".separate_box" ).css("margin-bottom","0px");

    			 $( ".separate_botm" ).css("margin-bottom","0px");*/
    		});

    	} else {
    		$(".third_content_dasktop").slideDown("900",function(){
                 $('.find3').first().hide();
                 $('.find').first().show();
               $('.find2').first().show();
               $('.find4').first().show();
    			
    			isShow = true;
    			/*var height = $(this).css('height');
    			$( ".separate_box" ).css("margin-bottom","0px");

    			$( ".separate_botm" ).css("margin-bottom",height);*/
    		});
    	}
    	
    });
}
if($(window).width() <= 767){
	$(".third_content_mobile").hide();
	var isShow = false;
    $(".find3").click(function(){
    	
       if(isShow){
       	isShow = false;
    		$(".third_content_mobile").slideUp();

    	} else {
    		isShow = true;

    		$(".third_content_mobile").slideDown();
    	}
    
    });
};
});
$(document).ready(function(){
	if($(window).width() >= 768){
		$(".fourth_content_dasktop").hide();
		var isShow = false;
    $(".find4").click(function(){
    	$(".first_content_dasktop").hide();
		$(".third_content_dasktop").hide();
		$(".secnd_content_dasktop").hide();

    	if(isShow){
    		$(".fourth_content_dasktop").slideUp("900",function(){
                 $('.find4').first().show();
    			    			 $( ".separate_box" ).css("margin-bottom","0px");

    			isShow = false;
    		/*	var height = $(this).css('height');
    			
    			 $( ".separate_botm" ).css("margin-bottom","0px");*/
    		});

    	} else {
    		$(".fourth_content_dasktop").slideDown("900",function(){
                 $('.find4').first().hide();
                 $('.find').first().show();
               $('.find3').first().show();
               $('.find2').first().show();
    			
    			isShow = true;
    		/*	var height = $(this).css('height');
    			$( ".separate_box" ).css("margin-bottom","0px");
    			$( ".separate_botm" ).css("margin-bottom",height);*/
    		});
    	}
    
    });
}
if($(window).width() <= 767){
	$(".fourth_content_mobile").hide();
	var isShow = false;
    $(".find4").click(function(){
    	
       if(isShow){
       	isShow = false;
    		$(".fourth_content_mobile").slideUp();

    	} else {
    		isShow = true;

    		$(".fourth_content_mobile").slideDown();
    	}
    
    });
};
});
 $(document).ready(function(){ 
            $(window).scroll(function(){ 
                var window_top = $(window).scrollTop() + 0; // the "12" should equal the margin-top value for nav.stick
                var div_top = $('.main-content').offset().top; 
                if (window_top > div_top) { 
                    $('.header_section').addClass('stick_menu');
                } else {
                    $('.header_section').removeClass('stick_menu'); 

                } 
            }); 
        });


</script>
<script type="text/javascript">
        $('.continue').click(function(){
  $('.nav-tabs > .active').next('li').find('a').trigger('click');
});
$('.back').click(function(){
  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
});
    </script>

</footer>
