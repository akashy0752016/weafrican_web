@extends('layouts.app')
@section('top-banner')
<div class="wrap">
	<div class="logo">
		<p>OOPS! - Could not Find it</p>
		<div class="sub">
		<p>500 ERROR - Page not found</p>
		<p>You are not on right path.</p>
		<p><a href="{{ url('/')}}" class="btn btn-sign">Go to HomePage </a></p>
		</div>
	</div>
 </div>	
<style type="text/css">	
.wrap{
	margin:0 auto;
	width:1000px;
}
.logo{
	text-align:center;
	margin-top:200px;
}
.logo p{
	color:#fff;
	font-size:40px;
	margin-top:1px;
}
.sub p{
	margin-top:5px;
	margin-bottom:5px;
}	
</style>
@endsection