@extends('layouts.event-app')

@section('content')
<div class="container row_pad">
<div class="error-box">
<div class="sad_icon text-center">
	<img src="images/sad.png">
</div>
<p>{{$message}}</p>
<a href="{{ url('/') }}" class="btn btn-danger btn-lg hvr-icon-pulse"><i class="fa fa-home"></i>&nbsp;Go to HomePage</a>
</div>
</div>
@endsection
