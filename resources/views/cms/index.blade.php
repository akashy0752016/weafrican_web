@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
	<div class="container @if(isset($cmsFlag) && $cmsFlag ==1) @else row_pad @endif">
		@if(isset($cmsFlag) && $cmsFlag ==1)
		@else
		<h3 class="about_head">{{ $cmsPage->title }}</h3>
		@endif
		<div class="col-md-12">
		<div class="row privacy_page"> 
			@if($cmsPage->content)
			{!! $cmsPage->content !!}
			@else
				<p class="text-center">{{ $cmsPage->title }}'s page content is still being prepared.</p>
			@endif
			</div>
		</div>
	</div>
@endsection

