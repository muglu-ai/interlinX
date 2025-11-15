<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1>Edit My Calender</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<?php if($this->session->flashdata('is_error') != '') {?>
			<div class="alert alert-danger tej-alert-dismiss">
				<?php echo $this->session->flashdata('is_error');$this->session->unset_userdata('is_error');?>
			</div>
		<?php }?>
		<?php if($this->session->flashdata('is_success') != '') {?>
			<div class="alert alert-success tej-alert-dismiss">
				<?php echo $this->session->flashdata('is_success');$this->session->unset_userdata('is_success');?>
			</div>
		<?php }?>
		<form action="<?php echo base_url('make-free');?>" method="post" name="form_12" id="form_12" onsubmit="return disp_confirm()">
			<div class="row">
    			<?php $make_busy = $make_free = array();$i = 0;
    			   for($i_days_cnt=0;$i_days_cnt<EVENT_INTERLINX_NO_OF_DAYS;$i_days_cnt++) { 
    			    $temp_dmY_date = date("d-m-Y",strtotime($EVENT_INTERLINX_DATE_ARR[$i_days_cnt]));
    			    $temp_dmY_day = date("l",strtotime($EVENT_INTERLINX_DATE_ARR[$i_days_cnt]));?>
            			<div class="col-md-12">
            				<div class="card">
            					<div class="card-header bg-info pt-1 pb-0">
            						<div class="float-left">
            							<h5 class="font-weight-bold"><?php echo $temp_dmY_date."&nbsp;|&nbsp;".$temp_dmY_day;?></h5>
            						</div>
            						<div class="card-tools">
            							<button type="button" class="btn btn-tool" data-card-widget="collapse">
            							<i class="fas fa-minus"></i>
            							</button>
            						</div>
            					</div>
            					<div class="card-body table-responsive p-0 bg-light">
            						<table class="table projects">
            							<thead>
            								<tr>
            									<th width="100%" class="text-left pb-0" colspan="4">
            										<?php foreach($schedule_list[$i_days_cnt] as $res_sch) {?>
            											<?php if(($res_sch['status'] == "Accepted" ) && (($res_sch['sender_id'] == '' ) || ($res_sch['sender_id'] == $res_sch['receiver_id'] ) )) {?>
            												<button class="btn btn-success btn-sm mb-2" type="submit">Make Free</button>
            											<?php break;}?>
            										<?php }?>
            									</th>
            									<th width="100%" class="text-right pb-2" colspan="3">
            										<span class="bg-grn mr-3">
            										<i class="fas fa-circle"></i> Available
            										</span>
            										<span class="bg-rd">
            										<i class="fas fa-circle"></i> Busy
            										</span>
            									</th>
            								</tr>
            								<tr class="bg-secondary">
            									<th style="width: 5%"></th>
            									<th style="width: 5%"></th>
            									<th style="width: 23%">Time Slot</th>
            									<th style="width: 20%">Client Name</th>
            									<th style="width: 20%">Organisation </th>
            									<th style="width: 10%">Make Busy</th>
            									<th style="width: 10%">Make Free</th>
            								</tr>
            							</thead>
            							<tbody>
            								<?php foreach($schedule_list[$i_days_cnt] as $res_sch) {?>
                								<tr class="<?php if( ($res_sch['status'] == "Accepted" )  ) {?>busy<?php } else{?>grn<?php }?>">
                									<td>
                										<?php if(($res_sch['status'] == "Accepted" ) && (($res_sch['sender_id'] == '' ) || ($res_sch['sender_id'] == $res_sch['receiver_id'] ) )) {
                										    $i++;?>
                											<input name="asc_<?php echo $i;?>" class="mr-2" type="checkbox" id="asc_<?php echo $i;?>" value="<?php echo $res_sch['no'];?>"/>
                										<?php }?>
                									</td>
                									<td>
                										<?php if( ($res_sch['status'] == "Accepted" )  ) {
                										    $accepted_meet[] = $res_sch;?>
                											<div class="box-red"></div>
                										<?php } else {?>
                											<div class="box-green"></div>
                										<?php }?>
                									</td>
                									<td><?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?></td>
                									<td class="pt-3 pb-3">
														<?php if($res_sch['sender_fname'] != "")
                        									{
                        										echo $res_sch['sender_title']. $res_sch['sender_fname']." ". $res_sch['sender_lname']; 
                        									}
                        									else
                        									{
                        										echo "-";
                        									}?>
													</td>
                									<td>
                										<?php if($res_sch['sender_org'] != "")
                        									{
                        										echo $res_sch['sender_org']; 
                        									}
                        									else
                        									{
                        										echo "-";
                        									}?>
                									</td>
                									<td class="project-actions">
                										<?php if( ($res_sch['status'] != "Accepted" )  ) {
                										    $make_busy[] = $res_sch;?>
                    										<a class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal-lg<?php echo $res_sch['no'];?>">
                    											<i class="fas fa-pencil-alt"></i> Edit
                    										</a>
                    									<?php } else {?>
                    										<span class="btn btn-danger btn-sm mb-2" type="button" style="cursor: default;">Busy</span>
                    									<?php }?>
                									</td>
                									<td class="project-actions text-center">
                										<?php if(($res_sch['status'] == "Accepted" ) && (($res_sch['sender_id'] == '' ) || ($res_sch['sender_id'] == $res_sch['receiver_id'] ) )) {?>
                										    <a onclick="make_free('asc_<?php echo $i;?>');" style="cursor: pointer;">
                										        <i class="fas fa-times black bg-rd"></i>
                										        </a>
                										    <?php } else if( ($res_sch['status'] != "" )  ) {
                										    $make_free[] = $res_sch;?>
                											<a data-toggle="modal" data-target="#modal-lgfree<?php echo $res_sch['no'];?>" style="cursor: pointer;">
                    											<i class="fas fa-times black bg-rd"></i>
                    										</a>
                										<?php } else {?>
                											-
                											<?php //<i class="fas fa-times black"></i>?>
                										<?php }?>
                									</td>
                								</tr>
                							<?php }?>
            							</tbody>
            						</table>
            					</div>
            				</div>
            			</div>
    			<?php }?>
			</div>
			<input name="count" id="count" type="hidden" value="<?php echo $i;?>" />
		</form>
	</div>
</section>
<!-- /.content -->

<?php if(!empty($make_busy)) {
    foreach ($make_busy as $res_sch) {
        $temp_dmY_date = date("d-m-Y",strtotime($res_sch['meeting_date']));
        $temp_dmY_day = date("l",strtotime($res_sch['meeting_date']));?>
    <div class="modal fade" id="modal-lg<?php echo $res_sch['no'];?>">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header bg-info">
    				<h5 class="modal-title">Meeting Date : <?php echo $temp_dmY_date;?> | Time: <?php echo $res_sch['meeting_time_start'] . ' - ' . $res_sch['meeting_time_end'];?></h5>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    				<!-- Main content -->
    				<section class="content">
    					<div class="container">
    						<form action="<?php echo base_url('edit-my-calendar');?>" method="post" name="edit_my_schedule<?php echo $res_sch['no'];?>" id="edit_my_schedule<?php echo $res_sch['no'];?>" onsubmit="return chk_val_edit_my_schedule_fun('<?php echo $res_sch['no'];?>')">
        						<input type="hidden" name="meeting_date_txt" id="meeting_date_txt" value="<?php echo $res_sch['meeting_date'];?>" />
                                <input type="hidden" name="meeting_start_time_txt" id="meeting_start_time_txt"  value="<?php echo $res_sch['meeting_time_start'];?>"/>
                                <input type="hidden" name="meeting_End_time_txt" id="meeting_End_time_txt" value="<?php echo $res_sch['meeting_time_end'];?>" />
                                <input type="hidden" name="meeting_status_txt" id="meeting_status_txt" value="<?php echo $res_sch['status'];?>" />
        						<div class="row">
        							<div class="col-12">
        								<div class="card">
        									<!-- /.card-header -->
        									<div class="card-body">
        										<div class="form-horizontal col-md-12">
        											<div class="form-row">
        												<div class="form-group col-md-6">
        													<label for="inputName" class="font-weight-bold">Skip Client Info</label><br>
        													<label><input type="checkbox" name="block_info" id="block_info<?php echo $res_sch['no'];?>" value="block_cl_info" onclick="clr_edit_sch_fields_fun('<?php echo $res_sch['no'];?>')" class="mr-2"> Send Blank Request to block current slot</label>
        												</div>
        												<div class="form-group col-md-6">
        													<label for="inputlink" class="font-weight-bold"> Client Name Title<span class="tej-required"> *</span></label>
        													<select name="cl_title_txt" id="cl_title_txt<?php echo $res_sch['no'];?>" class="form-control">
    															<option value="">Choose...</option>
                                                                  <option value="Mr.">Mr.</option>
                                                                  <option value="Mrs.">Mrs.</option>
                                                                  <option value="Miss.">Miss.</option>
                                                                  <option value="Dr.">Dr.</option>
                                                                  <option value="Prof.">Prof.</option>
        													</select>
        												</div>
        											</div>
        											<div class="form-row">
        												<div class="form-group col-md-6">
        													<label for="inputilink" class="font-weight-bold"> Client First Name<span class="tej-required"> *</span></label>
        													<input name="cl_fname_txt" type="text" id="cl_fname_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        												<div class="form-group col-md-6">
        													<label for="inpuvtlink" class="font-weight-bold">Client Last Name<span class="tej-required"> *</span></label>
        													<input name="cl_lname_txt" type="text" id="cl_lname_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        											</div>
        											<div class="form-row">
        												<div class="form-group col-md-6">
        													<label for="inputKeywords" class="font-weight-bold">Client Email</label>
        													<input name="cl_email_txt" type="email" id="cl_email_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        												<div class="form-group col-md-6">
        													<label for="inputDescription" class="font-weight-bold">Organisation<span class="tej-required"> *</span></label>
        													<input name="cl_org_txt" id="cl_org_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        											</div>
        											<div class="form-row">
        												<div class="form-group col-md-6">
        													<label for="inputKeywords" class="font-weight-bold">Designation</label>
        													<input name="cl_desig_txt" type="text" id="cl_desig_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        												<div class="form-group col-md-6">
        													<label for="inputDescription" class="font-weight-bold">Organisation Profile</label>
        													<input name="cl_org_profile_txt" type="text" id="cl_org_profile_txt<?php echo $res_sch['no'];?>" class="form-control">
        												</div>
        											</div>
        											<div class="form-row">
        												<div class="form-group col-md-12">
        													<label for="inputDescription" class="font-weight-bold">Message<span class="tej-required"> *</span></label>
        													<textarea name="cl_msg_txt" id="cl_msg_txt<?php echo $res_sch['no'];?>" class="form-control"></textarea>
        												</div>
        											</div>
        											<div class="form-group row justify-content-center">
        												<button type="submit" class="btn btn-info btn-md">Submit</button>
        											</div>
        										</div>
        									</div>
        								</div>
        							</div>
        							<!-- /.card-body -->
        						</div>
        						<!-- /.card -->
    						</form>
    					</div>
    					<!-- /.col -->
    					<!-- /.container-fluid -->
    				</section>
    			</div>
    		</div>
    		<!-- /.modal-content -->
    	</div>
    	<!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php }
}?>

<?php if(!empty($make_free)) {
    foreach ($make_free as $res_sch) {
        $temp_dmY_date = date("d-m-Y",strtotime($res_sch['meeting_date']));
        $temp_dmY_day = date("l",strtotime($res_sch['meeting_date']));?>
        <div class="modal fade" id="modal-lgfree<?php echo $res_sch['no'];?>">
            <div class="modal-dialog modal-lg">
            	<div class="modal-content">
            		<div class="modal-header bg-info">
            			<h5 class="modal-title">Cancelling Meeting Scheduled on Date : <?php echo $temp_dmY_date;?> | Time: <?php echo $res_sch['meeting_time_start'] . ' - ' . $res_sch['meeting_time_end'];?></h5>
            			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            			<span aria-hidden="true">&times;</span>
            			</button>
            		</div>
            		<div class="modal-body">
            			<!-- Main content -->
            			<section class="content">
            				<div class="container">
            					<div class="row">
            						<div class="col-12">
            							<div class="card">
            								<!-- /.card-header -->
            								<div class="card-body">
            									<form action="<?php echo base_url('cancel-my-schedule');?>" method="post" name="cancel_my_schedule" id="cancel_my_schedule" onsubmit="return val_can_my_schedule_fun('<?php echo $res_sch['no'];?>')">
            										<input name="can_meeting_date_txt1" id="can_meeting_date_txt<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_date'];?>" />
                                				  <input name="can_meeting_start_time_txt1" id="can_meeting_start_time_txt<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_time_start'];?>"  />
                                				  <input name="can_meeting_End_time_txt1" id="can_meeting_End_time_txt<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_time_end'];?>"  />
                                				  <input name="can_meeting_status_txt1" id="can_meeting_status_txt<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['status'];?>"  />
                                				   <input name="can_meeting_client_id_txt1" id="can_meeting_client_id_txt<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['sender_id'];?>"  />
            										<div class="form-group col-md-12">
            											<label for="inputDescription" class="font-weight-bold">Message For Client *</label>
            											<textarea class="form-control" name="can_cl_msg_txt1" id="can_cl_msg_txt<?php echo $res_sch['no'];?>"></textarea>
            										</div>
            										<div class="form-group row justify-content-center">
            											<button type="submit" class="btn btn-info btn-md">Submit</button>
            										</div>
            									</form>
            								</div>
            							</div>
            							<!-- /.card-body -->
            						</div>
            						<!-- /.card -->
            					</div>
            					<!-- /.col -->
            				</div>
            				<!-- /.row -->
            			</section>
            		</div>
            		<!-- /.modal-content -->
            	</div>
            </div>
            <!-- /.modal-dialog -->
        </div>
<?php }
}?>

<script type="text/javascript">
	function make_free(cid) {
		var r=confirm("Are you sure you want to make this slot free?")
        if (r==true)
          {
          	document.getElementById(cid).checked = true;
          	document.form_12.submit();
          }
        else
          {
          return false;
          }
	}
	
    function disp_confirm()
    {	
    	var total_cnt = document.getElementById("count").value;
    	var sele_cnt = 0;
    	var cnt_temp=0;
    	
    	for(cnt_temp=1;cnt_temp<=total_cnt;cnt_temp++)
    	{
    		if(document.getElementById("asc_"+cnt_temp).checked == true)
    		{
    			sele_cnt++;
    			break;
    		}
    	}
    	/*alert("select count:- "+sele_cnt);
    	alert("temp count:- "+cnt_temp);
    	alert("total count:- "+total_cnt);*/
    	if((cnt_temp>=total_cnt) && (sele_cnt<=0))
    	{	
    		alert("Please select atleast one checkbox to free your busy slot which is not allocated to any other delegate.");
    		return false;
    	}
        var r=confirm("Are you sure you want to make checked slots free?")
        if (r==true)
          {
          	return make_free_multiple();
        	return true;
          }
        else
          {
          return false;
          }
    }
    
    function make_free_multiple()
    {
    	
        var total_cnt = document.getElementById("count").value;
    	var sele_cnt = 0;
    	var cnt_temp=0;
    	
    	for(cnt_temp=1;cnt_temp<=total_cnt;cnt_temp++)
    	{
    		if(document.getElementById("asc_"+cnt_temp).checked == true)
    		{
    			sele_cnt++;
    			break;
    		}
    	}
    	/*alert("select count:- "+sele_cnt);
    	alert("temp count:- "+cnt_temp);
    	alert("total count:- "+total_cnt);*/
    	if((cnt_temp>=total_cnt) && (sele_cnt<=0))
    	{	
    		alert("Please Select Atleast on check box to free your busy slot.");
    		return false;
    	}
    	return true;
    }
    
    function clr_edit_sch_fields_fun(i)
	{
			
		if(document.getElementById("block_info" + i).checked == true)
		{
			document.getElementById("cl_title_txt" + i).value = "";
			
			document.getElementById("cl_fname_txt" + i).value = "";
			
			document.getElementById("cl_lname_txt" + i).value = "";
			
			document.getElementById("cl_email_txt" + i).value = "";
			
			document.getElementById("cl_org_txt" + i).value = "";
			
			document.getElementById("cl_desig_txt" + i).value = "";
			
			document.getElementById("cl_org_profile_txt" + i).value = "";
			
			document.getElementById("cl_msg_txt" + i).value = "";
			document.getElementById("cl_title_txt" + i).disabled=true;
			
			document.getElementById("cl_fname_txt" + i).disabled=true;
			
			document.getElementById("cl_lname_txt" + i).disabled=true;
			
			document.getElementById("cl_email_txt" + i).disabled=true;
			
			document.getElementById("cl_org_txt" + i).disabled=true;
			
			document.getElementById("cl_desig_txt" + i).disabled=true;
			
			document.getElementById("cl_org_profile_txt" + i).disabled=true;
			
			document.getElementById("cl_msg_txt" + i).disabled=true;
			
		}
		else if(document.getElementById("block_info" + i).checked == false)
		{
			document.getElementById("cl_title_txt" + i).disabled=false;
			
			document.getElementById("cl_fname_txt" + i).disabled=false;
			
			document.getElementById("cl_lname_txt" + i).disabled=false;
			
			document.getElementById("cl_email_txt" + i).disabled=false;
			
			document.getElementById("cl_org_txt" + i).disabled=false;
			
			document.getElementById("cl_desig_txt" + i).disabled=false;
			
			document.getElementById("cl_org_profile_txt" + i).disabled=false;
			
			document.getElementById("cl_msg_txt" + i).disabled=false;
				
		}
	}
	
	function chk_val_edit_my_schedule_fun(i)
	{
		if(document.getElementById("block_info" + i).checked == true)
		{
			return true;
		}
		else
		{
			if(document.getElementById("cl_title_txt" + i).value == "")
			{
				alert("Please Select Client Name Title");
				document.getElementById("cl_title_txt" + i).focus();
				return false;
			}
			if(document.getElementById("cl_fname_txt" + i).value == "")
			{
				alert("Please Enter Client First Name ");
				document.getElementById("cl_fname_txt" + i).focus();
				return false;
			}
			if(document.getElementById("cl_lname_txt" + i).value == "")
			{
				alert("Please Enter Client Last Name ");
				document.getElementById("cl_lname_txt" + i).focus();
				return false;
			}
		/*	if(document.getElementById("cl_email_txt" + i).value == "")
			{
				alert("Please Enter Email Id");
				document.getElementById("cl_email_txt" + i).focus();
				return false;
			}
			
		*/	
			if(document.getElementById("cl_email_txt" + i).value != "") 
			{
				var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				var toArr= document.getElementById("cl_email_txt" + i).value.split(","); 			//split into array
				for (var j=0;j<toArr.length;j++) 				    					//loop array to validate correct address
				{
					if ( !toArr[j].match(reg) ) 										//if not match, alert and stop loop
					{	
						alert("Invalid Email address \n"+toArr[j]);
						document.getElementById("cl_email_txt" + i).focus();
						return false;
					}
				}
			}
			if(document.getElementById("cl_org_txt" + i).value == "")
			{
				alert("Please Enter Client Organisation Name ");
				document.getElementById("cl_org_txt" + i).focus();
				return false;
			}
			/*if(document.getElementById("cl_desig_txt" + i).value == "")
			{
				alert("Please Enter Client Designation");
				document.getElementById("cl_desig_txt" + i).focus();
				return false;
			}
			if(document.getElementById("cl_org_profile_txt" + i).value == "")
			{
				alert("Please Enter Client Organisation profile ");
				document.getElementById("cl_org_profile_txt" + i).focus();
				return false;
			}
			*/
			if(document.getElementById("cl_msg_txt" + i).value == "")
			{
				alert("Please Enter Message");
				document.getElementById("cl_msg_txt" + i).focus();
				return false;
			}
		
		}
	
		return true;
	}
	
	function chk_val_can_my_schedule_fun(i)
	{
		
		if(document.getElementById("can_meeting_client_id_txt" + i).value != "")
		{
			if(document.getElementById("can_cl_msg_txt" + i).value == "")
			{
				alert("Please Enter Message For Receiver user");
				document.getElementById("can_cl_msg_txt" + i).focus();
				return false;
			}
			else
			{				
				return true;	
			}
		
		}
		else
		{		
			return true;
		}
		
	}
	
	function val_can_my_schedule_fun(i)
	{
		if(chk_val_can_my_schedule_fun(i))
		{
			//document.cancel_my_schedule.submit();
			return true;
		}
		else
		{
			return false;
		}
	}
</script>