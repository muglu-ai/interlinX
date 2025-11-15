<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1>Schedule of <a href="<?php echo base_url('delegate-personal-detail/' . $dup_dele_row_ans['user_id']);?>" target="_blank"><?php echo $dup_dele_row_ans['title'].$dup_dele_row_ans['fname']." ".$dup_dele_row_ans['lname'];?></a></h1>
			</div>
			<div class="col-md-6">
				<div class="float-right bg-white p-2">
					<div class="breadcrumb">
						<div class="bg-grn mr-3">
							<i class="fas fa-circle"></i> Available
						</div>
						<div class="bg-rd">
							<i class="fas fa-circle"></i> Busy
						</div>
					</div>
				</div>
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
		<div class="row">
			<?php $accepted_meet = array();//print_r($dup_dele_row_ans);
			   for($i_days_cnt=0;$i_days_cnt<EVENT_INTERLINX_NO_OF_DAYS;$i_days_cnt++) { 
			    $temp_dmY_date = date("d-m-Y",strtotime($EVENT_INTERLINX_DATE_ARR[$i_days_cnt]));
			    $temp_dmY_day = date("l",strtotime($EVENT_INTERLINX_DATE_ARR[$i_days_cnt]));?>
    			<div class="col-md-12">
    				<div class="card">
    					<div class="card-header bg-info pt-1 pb-1">
    						<div class="float-left">
    							<h5 class="font-weight-bold"><?php echo $temp_dmY_date."&nbsp;|&nbsp;".$temp_dmY_day;?></h5>
    						</div>
    						<div class="card-tools">
    							<button type="button" class="btn btn-tool" data-card-widget="collapse">
    							<i class="fas fa-minus"></i>
    							</button>
    						</div>
    					</div>
    					<div class="card-body table-responsive p-0">
    						<table class="table projects">
    							<thead>
    								<tr class="bg-secondary">
    									<th style="width: 10%"></th>
    									<th style="width: 30%;">Time Slot</th>
    									<th style="width: 30%;">Date</th>
    									<th style="width: 30%;">Meeting Status</th>
    									<?php /*?><th style="width: 20%">Client Name</th>
    									<th style="width:25%" class="text-center">Organisation </th>
    									<th style="width: 15%" class="text-right">Details</th>*/?>
    								</tr>
    							</thead>
    							<tbody>
    								<?php foreach($schedule_list[$i_days_cnt] as $res_sch) {?>
        								<tr class="<?php if( ($res_sch['status'] == "Accepted" )  ) {?>busy<?php } else{?>grn<?php }?>">
        									<td>
        										<?php if( ($res_sch['status'] == "Accepted" )  ) {?>
        											<div class="box-red"></div>
        										<?php } else {?>
        											<div class="box-green"></div>
        										<?php $accepted_meet[] = $res_sch;}?>
        									</td>
        									<td>
        										<?php /*if( ($res_sch['status'] == "Accepted" )  ) {?>
            										<a data-toggle="modal" data-target="#modal-lg<?php echo $res_sch['no'];?>" href="javascrip:;">
            											<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?>
    												</a>
    											<?php } else {?>
    												<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?>
    											<?php }*/?>
    											<?php if( ($res_sch['status'] == "Accepted" )  ) {?>
    												<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?>
    											<?php } else {?>
    												<a data-toggle="modal" data-target="#modal-lg<?php echo $res_sch['no'];?>" href="javascrip:;">

            											<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end']?>
    												</a>
    											<?php }?>
        									</td>
        									<td><?php echo $temp_dmY_date;?></td>
        									<td>
        										<?php if( $res_sch['status'] == "Accepted" ) {?>
        											<span class="badge bg-danger p-2">Busy</span>
        										<?php } else {?>
        											<span class="badge bg-success p-2">Available</span>
        										<?php }?>
        									</td>
        									<?php /*<td class="pt-3 pb-3 <?php if( ($res_sch['sender_id'] !="") && ($res_sch['read_flag'] !="True") && ($res_sch['status']=="Accepted") ){ echo 'font-weight-bold';}?>">
        										<?php if($res_sch['sender_fname'] != "")
                									{
                									    if($res_sch['sender_fname'] != "Self")
                										{
                										    if($res_sch['sender_id'] != 'XXX') {
                										      echo "<a href='" . base_url('delegate-personal-detail/' . $res_sch['sender_id']) . "' target='_blank'>".$res_sch['sender_title']. $res_sch['sender_fname']." ". $res_sch['sender_lname']."</a>";
                										    } else {
                										        echo '<a data-toggle="modal" data-target="#modal-lg' . $res_sch['no'] . '" href="javascrip:;">' . $res_sch['sender_title']. $res_sch['sender_fname']." ". $res_sch['sender_lname'] . '</a>';
                										    }
                										}
                										else
                										{
                										    echo '<a data-toggle="modal" data-target="#modal-lg' . $res_sch['no'] . '" href="javascrip:;">Self</a>';
                										}	
                									}
                									else
                									{
                										echo "--";
                									}?>
        									</td>
        									<td class="text-center <?php if( ($res_sch['sender_id'] !="") && ($res_sch['read_flag'] !="True") && ($res_sch['status']=="Accepted") ){ echo 'font-weight-bold';}?>">
        										<?php 
                									if($res_sch['sender_org'] != "")
                									{
                									    echo '<a data-toggle="modal" data-target="#modal-lg' . $res_sch['no']. '" href="javascrip:;">' . $res_sch['sender_org'] . '</a>'; 
                									}
                									else
                									{
                										echo "--";
                									}?>
        									</td>
        									<td class="project-actions text-right">
        										<?php if( ($res_sch['status'] == "Accepted" )  ) {?>
            										<a class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modal-lg<?php echo $res_sch['no'];?>">
            											<i class="fas fa-eye"></i> View
            										</a>
            									<?php } else {?>
            										--
            									<?php }?>
        									</td>*/?>
        								</tr>
        							<?php }?>
    							</tbody>
    						</table>
    					</div>
    				</div>
    			</div>
    		<?php }?>
		</div>
	</div>
</section>
<!-- /.content -->
<?php if(!empty($accepted_meet)) {
    foreach ($accepted_meet as $res_sch) {
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
    						<form id="schedule_meeting" name="schedule_meeting" method="post" action="<?php echo base_url('view-schedule/' . $dup_dele_row_ans['dup_user_id']);?>" onSubmit="return check_schedule_meeting_form('<?php echo $res_sch['no'];?>')">
        						<input name="met_date" id="met_date<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_date'];?>" />
        						<input name="met_time" id="met_time<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_time_start'];?>" />
        						<input name="dele_dup_user_id" id="dele_dup_user_id<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $dup_dele_row_ans['dup_user_id'];?>" />
        						<input name="met_time_end" id="met_time_end<?php echo $res_sch['no'];?>" type="hidden" value="<?php echo $res_sch['meeting_time_end'];?>" />
        						<div class="row">
        							<div class="col-12">
        								<div class="card">
        									<!-- /.card-header -->
        									<div class="card-body">
                    							<div class="">
                    								<p><span class="font-weight-bold">Name:</span> <?php echo $dup_dele_row_ans['title'].$dup_dele_row_ans['fname']." ".$dup_dele_row_ans['lname'];?></p>
                    							</div>
                    							<div class="">
                    								<p><span class="font-weight-bold">Organisation:</span> <?php echo $dup_dele_row_ans['org_name'];?></p>
                    							</div>
                    							<div class="">
                    								<p><span class="font-weight-bold">Designation:</span> <?php echo $dup_dele_row_ans['desig'];?></p>
                    							</div>
                    							<div class="form-group col-md-12">
        											<label for="inputDescription" class="font-weight-bold">Request Messege *</label>
        											<textarea class="form-control" name="msg" id="msg<?php echo $res_sch['no'];?>" re></textarea>
        										</div>
        										<div class="form-group row justify-content-center">
        											<button type="submit" class="btn btn-info btn-md">Send Meeting Request</button>
        										</div>
        									</div>
        								</div>
        								<!-- /.card-body -->
        							</div>
        							<!-- /.card -->
        						</div>
        						<!-- /.col -->
        					</form>
    					</div>
    					<!-- /.row -->
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

<script type="text/javascript">
function check_schdule_meeting_form_validate(i)
	{
		//alert("form checking");
		if(document.getElementById("msg" + i).value == "")
		{
			alert("Please Enter Message For Receiver user");
			document.getElementById("msg" + i).focus();
			return false;
		}
		return true;
	}
function check_schedule_meeting_form(i)
	{
		
		if( check_schdule_meeting_form_validate(i) )
		{
			//document.schedule_meeting.submit();
			return true;
		}
		else
		{
		return false;
		}
	}
</script>