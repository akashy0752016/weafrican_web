@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Edit - {{$cmsPage->title}}</h2>
	<hr>
	@include('notification')
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="{{ url('admin/cms/'.$cmsPage->id) }}" method="POST">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="put" />
				<div class="form-group">
					<textarea class="form-control" name="content" rows="15">{{ $cmsPage->content ? $cmsPage->content : old('content') }}</textarea>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Show in App</label>
                    <div class="col-md-4">
                        <input type="checkbox" name="is_show_on_mobile" value="{{ $cmsPage->is_show_on_mobile}}" {{ $cmsPage->is_show_on_mobile ? "checked" : "" }}>

                    </div>
				</div>
				<div class="form-group">
					<div class="ol-md-4">
						<button type="submit" class="btn btn-success btn_right" id="btn-login">Update Content</button>
					</div>
				</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			menu: {
				view: {title: 'Enter Code', items: 'code'}
			},
			plugins: 'code, textpattern, textcolor',
			toolbar: [
				'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright alignjustify | fontselect | forecolor | backcolor'
			],
			theme_advanced_fonts: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
		});
	</script>
@endsection