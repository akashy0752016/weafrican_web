@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <div class="register-business upld_reg">
        <h5 class="text-left">Please upload documents </h5>
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
        <div class="panel panel-default document">
            <form id="register-form" class="form-horizontal" action="{{ url('upload-document') }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="col-md-6 col-sm-6 form-group upld_id">
                    <label>Please upload Identity Proof here</label>
                    <label class="btn-bs-file btn btn-info">Browse
                    <input required type="file" name="identity_proof" id="identity_proof">
                    </label>
                    @if($errors->has('identity_proof'))
                    <span class="help-block">
                    <strong>{{ $errors->first('identity_proof') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-6 col-sm-6 form-group upld_id">
                    <label>Please upload Business Proof here</label>
                    <label class="btn-bs-file btn btn-info">Browse
                    <input required type="file" name="business_proof" id="business_proof">
                    </label>
                    @if($errors->has('business_proof'))
                    <span class="help-block">
                    <strong>{{ $errors->first('business_proof') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">
                <div class="col-md-12 text-right">
                <div class="form-group sub_later">
                        <button type="submit" class="btn btn-default btn_colr">Submit</button>
                    </div>
                    <div class="form-group sub_later">
                        <a class="btn btn-default btn_colr" href="{{ url('register-business/'.Auth::id()) }}">
                            
                            Later
                        </a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
