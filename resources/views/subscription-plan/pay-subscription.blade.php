@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
	<div class="container row_pad">
		<h5>{{ $subscriptPlan->title }} Subscription Plan</h5>
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

	    <div class="panel panel-default document">
	    	    <form id="register-form" class="form-horizontal" action="{{ url('/payment') }}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="user_subscription_plan_id" value="{{$userSubscriptionPlan->id}}">
                <input type="hidden" name="amount" value="{{$subscriptPlan->price}}.00">
                <input type="hidden" name="currency" value="NGN">
                <input type="hidden" name="paystack-reference" value=""> {{-- required --}}
                <input type="hidden" name="channels" value="'bank','card'">
                <script src="https://js.paystack.co/v1/inline.js"></script>
                <div id="paystackEmbedContainer"></div>

                <script>
                  
                </script>
            </form>
             
            <script>

            </script>
	    </div>
	</div>
@endsection
@section('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
        
PaystackPop.setup({
   key: "{{ config('paystack.publicKey') }}",
   email: '{{Auth::user()->email}}',
   amount: '{{$subscriptPlan->price*100}}.00',
   container: 'paystackEmbedContainer',
   callback: function(response){
        $("input[name='paystack-reference']").val(response.reference);
        $( "#register-form" ).submit();
        //alert('successfully subscribed. transaction ref is ' + response.reference);
    },
  });
</script>
@endsection
