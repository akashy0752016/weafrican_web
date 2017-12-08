@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5>Subscription History</h5>
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
    @include('includes.side-menu')
    <div class="col-md-9 col-sm-9">
        <div class="panel panel-default table_set">
            <div class="all_content">
            <table class="table" id="subscription_list">
                <thead>
                    <tr>
                        <th>Subscription Plan Name</th>
                        <th>Coverage</th>
                        <th>keywords Limit</th>
                        <th>Price</th>
                        <th>Purchased Date</th>
                        <th>Expired Date</th>
                    </tr>
                </thead>
                <tbody>
                @if($plans->count()) 
                    @foreach($plans as $plan)
                        <tr>
                            <td>{{$plan->title}}</td>
                            <td>{{$plan->coverage}}</td>
                            <td>@if($plan->keywords_limit){{ $plan->keywords_limit}} @else NA @endif</td>
                            <td>{{$plan->price}}</td>
                            <td>{{date('d M,Y', strtotime($plan->subscription_date))}}</td>
                            <td>{{date('d M,Y', strtotime($plan->subscription_date .'+'. $plan->validity_period.'days')) }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No subscription plan Purchased</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">

    $(document).ready( function () {
        $('#subscription_list').DataTable();
        $('#business_list').DataTable();
        $('#event_list').DataTable();
    } );
</script>
@endsection