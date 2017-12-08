@if ($message = Session::get('success'))

<div class="notifications">
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>SUCCESS</h4>
        @if(is_array($message))
            @foreach ($message as $m)
                {{ $m }}
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('error'))

<div class="notifications">
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Error</h4>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="notifications">
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Warning</h4>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Info</h4>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
@elseif(Session::get('banner')!= null)
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title popup_title">@if(isset(Session::get('banner')->userSubscriptionPlan->subscription->id) and Session::get('banner')->userSubscriptionPlan->subscription->id==6) Top Business Listing Plan updated Successfully @elseif(isset(Session::get('banner')->userSubscriptionPlan->subscription->id) and Session::get('banner')->userSubscriptionPlan->subscription->id==10) Top Event Listing Plan Updated Successfully @else Banner Updated Successfully @endif</h4>
      </div>
      <div class="modal-body modal_popup">
        <p>
            <ul>
                <li>@if(isset(Session::get('banner')->userSubscriptionPlan->subscription->id) and Session::get('banner')->userSubscriptionPlan->subscription->id==6)
                    Your Business is live under
                    @elseif(isset(Session::get('banner')->userSubscriptionPlan->subscription->id) and Session::get('banner')->userSubscriptionPlan->subscription->id==10) Your event is live under @else Your Banner is live under @endif @if(isset(Session::get('banner')->event_category_id) and Session::get('banner')->event_category_id!=null) {{Session::get('banner')->category->title}} @endif @if(isset(Session::get('banner')->business_category_id) and Session::get('banner')->business_category_id!=null) {{Session::get('banner')->category->title}} @endif @if(isset(Session::get('banner')->business_subcategory_id) and Session::get('banner')->business_subcategory_id!=null) , {{Session::get('banner')->subcategory->title}} @endif @if(isset(Session::get('banner')->country) and Session::get('banner')->country!=null) , {{Session::get('banner')->country}} @endif @if(isset(Session::get('banner')->state) and Session::get('banner')->state!=null) , {{Session::get('banner')->state}} @endif @if(isset(Session::get('banner')->city) and Session::get('banner')->city!=null) , {{Session::get('banner')->city}} @endif</li>
                <li>To edit @if(Session::get('banner')->userSubscriptionPlan->subscription->type=="business") <a href="{{ url('business-banner/'.Session::get('banner')->id.'/edit/') }}"> @elseif(Session::get('banner')->userSubscriptionPlan->subscription->type=="event") <a href="{{ url('event-banner/'.Session::get('banner')->id.'/edit/') }}"> @else <a href="{{ url('sponsor-banner/'.Session::get('banner')->id.'/edit/') }}"> @endif Click here</a></li>
                <li>To purchase additional plan then <a href="{{url('subscription')}}">click here</a></li>
            </ul>
        </p>
      </div>
      <div class="modal-footer modal_foter">
        <button type="button" class="btn btn-default btn_colr" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $('#myModal').modal('show'); 
</script>
@endif