<!-- Working Hours Modal -->
<div id="working_hours_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg work_container">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Working Hours</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="working_hours" class="control-label">
                            Monday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[0]" value="0" checked="checked" id="open_0_radio" class="opt_day" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[0]" value="1" class="opt_day" id="close_0_radio" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[0]" value="2" class="opt_day" id="hour24_0_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[0]" disabled="" id="open_0" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[0]" disabled="" id="close_0" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="working_hours" class="control-label">
                            Tuesday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[1]" value="0" checked="checked" id="open_1_radio" class="opt_day" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[1]" value="1" class="opt_day" id="close_1_radio" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[1]" value="2" class="opt_day" id="hour24_1_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5  col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[1]" id="open_1" disabled="" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[1]" disabled="" id="close_1" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="working_hours" class="control-label">
                            Wednesday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12 ">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[2]" value="0" checked="checked" id="open_2_radio" class="opt_day" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[2]" value="1" class="opt_day" id="close_2_radio" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[2]" value="2" class="opt_day" id="hour24_2_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[2]" disabled="" id="open_2" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[2]" disabled="" id="close_2" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="working_hours" class="control-label">
                            Thursday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[3]" value="0" checked="checked" id="open_3_radio" class="opt_day" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[3]" value="1" class="opt_day" id="close_3_radio" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[3]" value="2" class="opt_day" id="hour24_3_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[3]" disabled="" id="open_3" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[3]" disabled="" id="close_3" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="working_hours" class="control-label">
                            Friday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[4]" value="0" checked="checked" id="open_4_radio" class="opt_day" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[4]" value="1" class="opt_day" id="close_4_radio" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[4]" value="2" class="opt_day" id="hour24_4_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[4]" disabled="" id="open_4" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[4]" disabled="" id="close_4" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12 ">
                        <label for="working_hours" class="control-label">
                            Saturday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[5]" value="0" class="opt_day" id="open_5_radio" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[5]" value="1" checked="checked" id="close_5_radio" class="opt_day" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input name="option_day[5]" value="2" class="opt_day" id="hour24_5_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[5]" disabled="" id="open_5" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[5]" disabled="" id="close_5" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 comn_space">
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <label for="working_hours" class="control-label">
                            Sunday:
                        </label>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="row first_row">
                            <div class="col-md-4 col-sm-4">
                                <input name="option_day[6]" value="0" class="opt_day" id="open_6_radio" type="radio">&nbsp;Open
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input name="option_day[6]" value="1" checked="checked" id="close_6_radio" class="opt_day" type="radio">&nbsp;Closed
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input name="option_day[6]" value="2" class="opt_day" id="hour24_6_radio" type="radio">&nbsp;24 Hours Open
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Opening Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="open[6]" disabled="" id="open_6" class="form-control" value="10:00 AM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mobile_margin">
                                <label for="working_hours" class="col-md-5 col-sm-5 col-xs-6 control-label">
                                    Closing Time: 
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-6">
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text' name="close[6]" disabled="" id="close_6" class="form-control" value="6:00 PM" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn_colr" id="modal_submit">Submit</button>
        <button type="button" class="btn btn-default btn_colr" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
