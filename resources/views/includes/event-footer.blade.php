<footer>
		<div class="container">
			<div class="col-md-8 text-left col-sm-6 col-xs-12 all_about">
				<p>2016 - {{ date('Y')}} © Copyright your company. All Rights Reserved</p>
			</div>
			<div class="col-md-4 text-right col-sm-6 col-xs-12">
				<div class="row">
					<!-- <p>available on</p> -->
					<ul class="list-inline image_sep">
						<li> <a href="#"><img src="{{asset('images/apple-store.png')}}"></a> </li>
					    <li> <a href="#"><img src="{{asset('images/play-store.png')}}"></a> </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="col-md-12 text-left col-sm-12 col-xs-12">
				
			</div>
		</div>
	<script>

	if ($(window).width() <=767) {
	   		 $(".subscript").click(function(){
	    	$(".dropdown-menu.subsplan").slideToggle();
	    });
}

</script>
</footer>