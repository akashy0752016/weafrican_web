@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>Bank Account Details</h5>
	<hr>
	@include('notification')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="wrap_container">
	@include('includes.side-menu')
		<div class="col-md-9 col-sm-9">
			<div class="all_content">
				<p class="text-right"><a href="{{ url('account-details/'.$account->id.'/edit') }}" type="button" class="btn btn-danger" title="Unblock">Edit Bank Details</a></p>
				<div class="panel panel-info">
					    <div class="panel-heading">Bank Account Details</div>
					    <div class="panel-body">
					    	 <div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Account Holder Name :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $account->account_holder_name }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-text_spacing4 col-sm-4 col-xs-6 profile_left">
								<label>Account Number:</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $account->account_number }}
							</div>
						</div>
						<div class="row text_spacing">
							<div class="col-md-4 col-sm-4 col-xs-6 profile_left">
								<label>Bank Name :</label>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-6 profile_right">
								{{ $account->bank_name }}
							</div>
						</div>
					    </div>
				</div>
			</div>
		</div>	
	</div>
</div>
@endsection
