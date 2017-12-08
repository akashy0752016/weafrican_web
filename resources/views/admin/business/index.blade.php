@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-briefcase" aria-hidden="true"></i> User Business (Total Business : {{count($businesses)}})</h2>
	
	<hr>
	@include('notification')
	<br>
	<form id="form1" action="{{ url('admin/getSearch/') }}" method="GET" class="form-horizontal">
	{{csrf_field()}}
	<input type="hidden" name="page" value="business">
	<div class="col-md-12" style="margin-bottom: 20px">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-4">
					<select class="form-control filter" id="select_country" name="country">
		                    <option value="" selected=""> Select Country </option>
		                    @if(isset($countries))
		                    	@foreach($countries as $key=>$country)
		                    		<option value="{{ $key }}" @if($input['country']==$key) selected="" @endif>{{ $key }}</option>
		                    	@endforeach
		                    @endif
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control filter" id="select_state" name="state">
		                    <option value="" selected=""> Select State </option>
		                    @if(isset($states))
								@foreach($states as $key=>$state)
									<option value="{{ $state }}" @if($input['state']==$state) selected="" @endif>{{ $state }}</option>
								@endforeach
							@endif
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control filter" id="select_city" name="city">
		                    <option value="" selected=""> Select City </option>
		                    @if(isset($cities))
		                    	@foreach($cities as $key=>$city)
		                    		<option value="{{ $city }}" @if($input['city']==$city) selected="" @endif>{{ $city }}</option>
		                    	@endforeach
		                    @endif
		            </select>
				</div>
			</div>
			<div class="row" style="margin-top: 10px">
				<div class="col-md-4">
					<select class="form-control filter" id="select_category" name="category">
		                    <option value="" selected=""> Select Category </option>
		                    @if(isset($cities))
		                    	@foreach($categories as $key=>$category)
		                    		<option value="{{ $category }}" @if($input['category']==$category) selected="" @endif>{{ $key }}</option>
		                    	@endforeach
		                    @endif
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control filter" id="select_subcategory" name="subcategory">
		                    <option value="" selected=""> Select Sub-Category </option>
		                    @if(isset($subcategories))
		                    	@foreach($subcategories as $key=>$subcategory)
		                    		<option value="{{ $subcategory }}" @if($input['subcategory']==$subcategory) selected="" @endif>{{ $key }}</option>
		                    	@endforeach
		                    @endif
		            </select>
				</div>
				<div class="col-md-4">
					<select class="form-control filter" id="status" name="status">
		                    <option value="" selected=""> Select Status </option>
		                    @if(isset($status))
			                    <option value="0" @if($input['status']==0) selected="" @endif>Unapproved</option>
			                    <option value="1" @if($input['status']==1) selected="" @endif>Approved</option>
		                    @else
		                    	<option value="0">Unapproved</option>
			                    <option value="1">Approved</option>
		                    @endif
		            </select>
				</div>
			</div>
			<div class="row" style="margin-top: 10px">
				<div class="col-md-4">
					<select class="form-control filter" id="type" name="type">
		                    <option value="" selected=""> Select User Type</option>
		                    @if(isset($type))
			                    <option value="3" @if($input['type']==3) selected="" @endif>Basic</option>
			                    <option value="5" @if($input['type']==5) selected="" @endif>Premium</option>
		                    @else
		                    	<option value="3">Basic</option>
			                    <option value="5">Premium</option>
		                    @endif
		            </select>
				</div>
			</div>
			<div class="row error" style="text-align: center;"></div>
		</div>
		<div class="col-md-3" style="vertical-align: center">
			<button class="btn btn-info filter_submit">Filter</button>
			<button class="btn btn-info" onclick="javascript:setSubmit()">CSV</button>
			<a href="{{ url('admin/business/') }}" class="btn btn-info">Reset</a>
		</div>
	</div>
	</form>
	<br><br>
	<table id="categories_list" class="display">
		<thead>
			<tr>
				<th title="Serial Number">#</th>
				<th title="Business ID">BID</th>
				<th>Name</th>
				<th title="Business Name">BName</th>
				<th>Mobile No.</th>
				<th>Category</th>
				<th>Sub-Catgeory</th>
				<th>Document Verified</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($businesses as $key => $business)
			<tr>
				<td>{{ ++$key}}</td>
				<td>{{ $business->business_id}} </td>
				<td>@if(isset($business->user)) {{$business->user->first_name }} {{ $business->user->last_name }} @endif</td>
				<td>{{ $business->title}} </td>
				
				<td>@if(isset($business->user)){{ $business->user->mobile_number}} @endif</td>
				<td>{{ $business->category->title }}</td>
				<td>@if($business->bussiness_subcategory_id){{ $business->subcategory->title}} @else - @endif
				<td>
					@if($business->is_identity_proof_validate==1)
						Identity Proof: Approved
					@else
						Identity Proof: Unapproved
					@endif
					<br>
					@if($business->is_business_proof_validate==1)
						Business Proof: Approved
					@else
						Business Proof: Unapproved
					@endif
				</td>
				<!-- <td>{{ $business->getLikes()}}</td>
				<td>{{ $business->getDislikes()}}</td>
				<td>{{ $business->getFavourites()}}</td>
				<td>{{ $business->getFollowers()}}</td>
				<td>{{ (int)$business->getRatings()}}</td> -->
				<td>{{ date_format(date_create($business->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/business/block/'.$business->id) }}">
			                    @if($business->is_blocked)
			                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
		                		@endif
		                    </a>
						</li>
						<li>
							<a class="btn btn-warning btn_fixes" href="{{ url('admin/business/'.$business->id.'/edit') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
						</li>
						<li>
							<a class="btn btn-default btn_fixes" href="{{ url('admin/business/'.$business->id) }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
</a>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		
	</script>
	<script type="text/javascript">
		
	</script>
@endsection
@section('scripts')
<style type="text/css">
	.error {
	    color: red;
	}
</style>
<script type="text/javascript">
	$(document).ready( function () {
	    $('#categories_list').DataTable();
		$(".filter_submit").click(function(e){
			var country = $('#select_country :selected').val();
			var state = $('#select_state :selected').val();
			var city = $('#select_city :selected').val();
			var category = $('#select_category :selected').val();
			var subcategory = $('#select_subcategory :selected').val();
			var status = $('#status :selected').val();
			var type = $('#type :selected').val();
			if(country!="" || state!="" || city!="" || category!="" || subcategory!="" || status!="" || type!="")
			{
				$(".error" ).text("");
				$('#form1').submit()
			}else
			{
				$(".error").animate({opacity:0},function(){
			        $(".error" ).text("Please Select altleast one value to filter")
			            .animate({opacity:1});  
			    })
				e.preventDefault();
			}
		});
	} );
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	@if(!isset($input['page']))
	$(document).ready( function () {
		$.ajax({
			type:'POST',
            url: '{{ url("category") }}',
            success:function(response)
            {
                var category = JSON.parse(response);
                if(Object.keys(category).length>0)
                {
                    for(key in category){
                        $('#select_category').append($("<option></option>").attr("value",key).text(category[key]));
                    }
                }
            }
        });
        $.ajax({
            type:'POST',
            url: '{{ url("country") }}',
            success:function(response)
            {console.log(response);
                var country = JSON.parse(response);
                if(Object.keys(country).length>0)
                {
                    for(key in country){
                        $('#select_country').append($("<option></option>").attr("value",key).text(key));
                    }
                }
            }
        });
	});
	@endif
	$('#select_category').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    category : this.value,
                },success:function(response)
                {
                    $('#select_subcategory').find('option').not(':first').remove();
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#select_subcategory').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                    }else
                    {
                    	$('#select_subcategory').find('option').not(':first').remove();
                    }
                }
            });
        }else
        {
            $('#select_subcategory').find('option').not(':first').remove();
        }
    });
    $('#select_country').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("state") }}',
                data:{
                    country : this.value,
                },success:function(response)
                {
                    $('#select_state').find('option').not(':first').remove();
                    $('#select_city').find('option').not(':first').remove();
                    var state = JSON.parse(response);
                    if(state.length>0)
                    {
                        for (var x = 0; x < state.length; x++) {
                            $('#select_state').append($("<option></option>").attr("value",state[x]).text(state[x]));
                        }
                    }else
                    {
                        $('#select_state').find('option').not(':first').remove();
                    	$('#select_city').find('option').not(':first').remove();
                    }
                }
            });
        }else
        {
            $('#select_state').find('option').not(':first').remove();
            $('#select_city').find('option').not(':first').remove();
        }
    });
    $('#select_state').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("city") }}',
                data:{
                	country : $("#select_country option:selected").val(),
                    state : this.value,
                },success:function(response)
                {
                    $('#select_city').find('option').not(':first').remove();
                    var city = JSON.parse(response);
                    if(city.length>0)
                    {
                        for (var x = 0; x < city.length; x++) {
                            $('#select_city').append($("<option></option>").attr("value",city[x]).text(city[x]));
                        }
                    }else
                    {
                    	$('#select_city').find('option').not(':first').remove();
                    }
                }
            });
        }else
        {
            $('#select_city').find('option').not(':first').remove();
        }
    });
    function setSubmit() {
	    $('#form1').attr('target','')
	    $('#form1').attr('action',"{{ url('admin/getCSV/') }}")
	    $('#form1').submit()
	}
</script>
@endsection
