@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
    <h2><i class="fa fa-database" aria-hidden="true"></i> Notification</h2>
    <hr>
    <div class="col-md-7 fcm-section">
        <section class="fcm_users" required>
            <header class="panel-heading"><strong>Select Users to whom you want to send Notification</strong> </header>
            <select class="form-control" id="select_type" name="select_action" required="">
                    <option value="" > Select </option>
                    <option value="3">Business users</option>
                    <option value="4">End Users</option>
                    <option value="1">All Users</option>
            </select>
        </section>
        <section class="fcm_users" id="error" style="display: none">
        </section>
        <section class="fcm_users" id="my-country" style="display: none">
            <header class="panel-heading"><strong>Select Country to whom you want to send Notification</strong> </header>
            <select class='form-control' id='select_country' name='select_country' required>
                <option value='' selected>Select Country</option>
            </select>
        </section>
        <section class="fcm_users" id="my-state" style="display: none">
            <header class="panel-heading"><strong>Select State to whom you want to send Notification</strong> </header>
            <select class='form-control' id='select_state' name='select_state' required>
                <option value='' selected>Select State</option>
            </select>
        </section>
        <section class="fcm_users" id="my-city" style="display: none">
            <header class="panel-heading"><strong>Select State to whom you want to send Notification</strong> </header>
            <select class='form-control' id='select_city' name='select_city' required>
                <option value='' selected>Select City</option>
            </select>
        </section>
    </div>
    <div class="col-md-5 message-section">
        <section class="fcm_users" id="my-category" style="display: none">
            <header class="panel-heading"><strong>Select Category to whom you want to send Notification</strong> </header>
            <select class='form-control' id='select_category' name='select_category' required>
                <option value='' selected>Select Category</option>
            </select>
        </section>
        <section class="fcm_users" id="my-subcategory" style="display: none">
            <header class="panel-heading"><strong>Select Sub-Category to whom you want to send Notification</strong> </header>
            <select class='form-control' id='select_subcategory' name='select_subcategory' required>
                <option value='' selected>Select Category</option>
            </select>
        </section>
        <p class="header">Type your message</p>
        <textarea cols="15" rows="5" value="txtarea"></textarea>
        <button class="btn btn-success btn_fix" onclick="sendMsg()">Send Message</button>
    </div>
    <div class="col-md-12 serverresponse hidediv">

        <center><button id="sendmsg">Send Message Again</button></center>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#users_list').DataTable();
        } );
    </script>
@endsection
@section('scripts')
<script>

	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $('#select_type').on('change', function() {
        if(this.value==3 || this.value==4)
        {
            $.ajax({
                type:'POST',
                url: '{{ url("country") }}',
                data:{
                    user_role : this.value,
                },success:function(response)
                {
                    $('#my-country').find('option').not(':first').remove();
                    $('#my-state').find('option').not(':first').remove();
                    $('#my-city').find('option').not(':first').remove();
                    $('#my-category').find('option').not(':first').remove();
                    $('#my-subcategory').find('option').not(':first').remove();

                    var list = JSON.parse(response);
                    /*console.log(list.length);*/
                    if(list.length>=1)
                    {
                        for(var ob in list)
                        {
                            if(ob==0)
                            {
                                var country = list[ob];
                                if((Object.keys(country).length)>0)
                                {
                                    for(key in country){
                                        $('#select_country').append($("<option></option>").attr("value",key).text(key));
                                    }
                                    $('#my-country').show();
                                    $('#error').hide();
                                    $('#my-state').hide();
                                    $('#my-city').hide();
                                }else
                                {
                                    $('#error').html("No Country Found for Selected User");
                                    $('#error').show();
                                    $('#my-country').hide();
                                    $('#my-state').hide();
                                    $('#my-city').hide();
                                }
                            }else
                            {
                                var catgory = list[ob];
                                if((Object.keys(catgory).length)>0)
                                {
                                    for(key in catgory){
                                        $('#select_category').append($("<option></option>").attr("value",catgory[key]).text([key]));
                                    }
                                    $('#my-category').show();
                                }else
                                {
                                    $('#my-category').hide();
                                }
                            }
                        }
                    }else{
                        $('#error').html("No Country Found for Selected User");
                        $('#error').show();
                        $('#my-country').hide();
                        $('#my-state').hide();
                        $('#my-city').hide();
                        $('#my-category').hide();
                    }
                }
            });
        }else
        {
            $('#my-country').hide();
            $('#error').hide();
            $('#my-state').hide();
            $('#my-city').hide();
            $('#my-category').hide();
            $('#my-subcategory').hide();
        }
    });

    $('#select_country').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("state") }}',
                data:{
                    user_role : $("#select_type option:selected").val(),
                    country : this.value,
                },success:function(response)
                {
                    $('#my-state').find('option').not(':first').remove();
                    $('#my-city').find('option').not(':first').remove();
                    var state = JSON.parse(response);
                    if(state.length>0)
                    {
                        for (var x = 0; x < state.length; x++) {
                            $('#select_state').append($("<option></option>").attr("value",state[x]).text(state[x]));
                        }
                        $('#my-state').show();
                        $('#error').hide();
                        $('#my-city').hide();
                    }else
                    {
                        $('#error').html("No State Found for Selected Country");
                        $('#error').show();
                        $('#my-state').hide();
                        $('#my-city').hide();
                    }
                }
            });
        }else
        {
            $('#my-state').hide();
            $('#my-city').hide();
        }
    });

    $('#select_state').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("city") }}',
                data:{
                    user_role : $("#select_type option:selected").val(),
                    country : $("#select_country option:selected").val(),
                    state : $("#select_state option:selected").val(),
                },success:function(response)
                {
                    $('#my-city').find('option').not(':first').remove();
                    var city = JSON.parse(response);
                    if(city.length>0)
                    {
                        for (var x = 0; x < city.length; x++) {
                            $('#select_city').append($("<option></option>").attr("value",city[x]).text(city[x]));
                        }
                        $('#my-city').show();
                        $('#error').hide();
                    }else
                    {
                        $('#error').html("No City Found for Selected State");
                        $('#error').show();
                        $('#my-city').hide();
                    }
                }
            });
        }else
        {
            $('#my-city').hide();
        }
    });

    $('#select_category').on('change', function() {
        if(this.value!=""){
            $.ajax({
                type:'POST',
                url: '{{ url("subcategory") }}',
                data:{
                    user_role : $("#select_type option:selected").val(),
                    category : this.value,
                },success:function(response)
                {
                    $('#my-subcategory').find('option').not(':first').remove();
                    var subcategory = JSON.parse(response);
                    if(Object.keys(subcategory).length>0)
                    {
                        for(key in subcategory){
                            $('#select_subcategory').append($("<option></option>").attr("value",key).text(subcategory[key]));
                        }
                        $('#my-subcategory').show();
                    }else
                    {
                        $('#my-subcategory').hide();
                    }
                }
            });
        }else
        {
            /*$('#my-city').hide();*/
        }
    });

	
    function sendMsg(){
        var msgLength = $.trim($("textarea").val()).length;
        if(msgLength == 0){
        	alert("You left the message field blank, please fill it");
        }else{
            var cus = document.getElementById('select_type');
            var custid = cus.options[cus.selectedIndex].value;
        	var formData = $(".wrapper").find("input").serialize() + "&message=" + $("textarea").val() + "&type=" +custid + "&country=" +$("#select_country option:selected").val()+ "&state=" +$("#select_state option:selected").val()+ "&city=" + $("#select_city option:selected").val()+ "&category=" + $("#select_category option:selected").val()+ "&subcategory=" + $("#select_subcategory option:selected").val();	
        	$.ajax({type: "POST",data: formData, url: "{{url('admin/send/notification')}}", success:function(res){
        		$(".greetblock").slideUp(1000);
        		$(".serverresponse").prepend(res).hide().fadeIn(2000);
        	}});
        }
    }
    $(function(){
    	$(".serverresponse").hide()
    	$("input[type='checkbox']").click(function(){
    		if($(this).is(':checked')){
    			$(this).parent().css("border","3px solid red");
    		}else{
    			$(this).parent().css("border","0px");
    		}
    	});
    	
    	$("div.leftdiv, div.rightdiv").hover(function(){
    		$(this).css("background","#FAFAFA");
    	},function(){
    		$(this).css("background","#fff");
    	});
    	
    	$("#festival").change(function(){
    		$("img").attr("src",$(this).val());
    	});
    	
    	$("#sendmsg").click(function(){
    		$(".serverresponse").fadeOut(300,function(){
    			$(".greetblock").fadeIn(1000);
    		});		
    	});
    });
</script>
@endsection