@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Add New Subscription Plan</h2>
	<hr>
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<p class="bold">Create New Subscription Plan</p>
		</div>
		<div class="panel-body">
			<form  id="category-form" action="{{ url('admin/subscription/plan') }}" method="POST" class="form-horizontal">
				{{csrf_field()}}
				<div class="form-group">
					<label class="control-label col-md-2">Subscription Plan Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
						@if($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Product Limit</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="product_limit" value="{{old('product_limit')}}" required >
						@if($errors->has('product_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('product_limit') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Service Limit</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="service_limit" value="{{old('service_limit')}}" required >
						@if($errors->has('service_limit'))
							<span class="help-block">
								<strong>{{ $errors->first('service_limit') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2">Price(monthly)</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="price" value="{{old('price')}}" required >
						@if($errors->has('price'))
							<span class="help-block">
								<strong>{{ $errors->first('price') }}</strong>
							</span>
						@endif
					</div>
				</div>							
				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default col-md-offset-2" id="btn-login">Create Subscription</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
        $(document).ready(function() {
			$('#category-form').submit(function(event) {
				event.preventDefault();
				var actionUrl = $(this).attr('action');
				$.ajax({
					type: 'POST',
					url: actionUrl,
					data: $(this).serialize(),
					success: function(data) {
						var data = JSON.parse(data);
						if(data.status == 'success') {
							swal({
									title: "Done",
									text: "The Subscription Plan has been saved. Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location = data.url;
									}
							});
						} else {
							swal({
									title: "Opppsss",
									text: data.response,
									type: "error",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
								},
								function() {
									window.location.reload();
							});
						}
					}
				});
			});
        });
	</script>
@endsection