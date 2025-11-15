<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1>My Calender</h1>
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
		<div class="row">
			<?php $accepted_meet = array();
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
    									<th style="width: 20%">Client Name</th>
    									<th style="width:25%" class="text-center">Organisation </th>
    									<th style="width: 15%" class="text-right">Details</th>
    								</tr>
    							</thead>
    							<tbody>
    								<?php foreach($schedule_list[$i_days_cnt] as $res_sch) {?>
        								<tr class="<?php if( ($res_sch['status'] == "Accepted" )  ) {?>busy<?php } else{?>grn<?php }?>">
        									<td>
        										<?php if( ($res_sch['status'] == "Accepted" )  ) {
        										    $accepted_meet[] = $res_sch;?>
        											<div class="box-red"></div>
        										<?php } else {?>
        											<div class="box-green"></div>
        										<?php }?>
        									</td>
        									<td <?php if( ($res_sch['sender_id'] !="") && ($res_sch['read_flag'] !="True") && ($res_sch['status']=="Accepted") ){ echo 'class="font-weight-bold"';}?>>
        										<?php if( ($res_sch['status'] == "Accepted" )  ) {?>
            										<a data-toggle="modal" data-target="#modal-lg<?php echo $res_sch['no'];?>" href="javascrip:;">
            											<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?>
    												</a>
    											<?php } else {?>
    												<?php echo $res_sch['meeting_time_start']." - ".$res_sch['meeting_time_end'];?>
    											<?php }?>
        									</td>
        									<td class="pt-3 pb-3 <?php if( ($res_sch['sender_id'] !="") && ($res_sch['read_flag'] !="True") && ($res_sch['status']=="Accepted") ){ echo 'font-weight-bold';}?>">
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
    						<div class="row">
    							<div class="col-12">
    								<div class="card">
    									<!-- /.card-header -->
    									<div class="card-body">
    										<div class="table-responsive">
    											<table class="table table-borderless">
    												<tbody>
    													<tr>
    														<td width="25%" class="font-weight-bold w-one">Client Name</td>
    														<td width="2%">:</td>
    														<td width="30%" class="w-two"><?php echo $res_sch['sender_title'].$res_sch['sender_fname']." ".$res_sch['sender_lname'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Organisation</td>
    														<td>:</td>
    														<td><?php echo $res_sch['sender_org'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Designation</td>
    														<td>:</td>
    														<td><?php echo $res_sch['sender_desig'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Organisation Profile</td>
    														<td>:</td>
    														<td><?php
    														      echo substr($res_sch['sender_org_profile'], 0, 200);
    														     if(strlen($res_sch['sender_org_profile']) > 200){
    														         echo "...<a href='" . base_url('delegate-personal-detail/' . $res_sch['sender_id']) . "' target='_blank'>more</a>";
    														  }?>
    														</td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Meeting Date</td>
    														<td>:</td>
    														<td><?php echo $temp_dmY_date;?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Meeting Time</td>
    														<td>:</td>
    														<td><?php echo $res_sch['meeting_time_start'] . ' - ' . $res_sch['meeting_time_end'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Status</td>
    														<td>:</td>
    														<td>
    															<?php if($res_sch['status'] == "Accepted"){?>
                													<span class="badge bg-success p-2"><?php echo $res_sch['status'];?></span>
                												<?php }?>
                												<?php if($res_sch['status'] == "Pending"){?>
                													<span class="badge bg-warning p-2"><?php echo $res_sch['status'];?></span>
                												<?php }?>
                												<?php if($res_sch['status'] == "Rejected"){?>
                													<span class="badge bg-danger p-2"><?php echo $res_sch['status'];?></span>
                												<?php }?>
    														</td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Message</td>
    														<td>:</td>
    														<td><?php echo nl2br($res_sch['message']);?></td>
    													</tr>
    													<?php if(!empty($res_sch['global_meet_data'])) {?>
        													<tr>
        														<td class="font-weight-bold">Table</td>
        														<td>:</td>
        														<td><?php echo $res_sch['global_meet_data']['table_no'];?></td>
        													</tr>
        													<?php if($res_sch['status'] == "Accepted" && date('Y-m-d') >= ZOOM_MEETING_ACTIVATE_DATE) {?>
                            									<tr>
                            										<td class="font-weight-bold">Zoom Meeting Link</td>
                            										<td>:</td>
                            										<td><a href="<?php echo $res_sch['global_meet_data']['zoom_participant_link'];?>" target="_blank" class="btn btn-sm bg-blue">JOIN NOW</a></td>
                            									</tr>
                            									<tr>
                            										<td class="font-weight-bold">Zoom Meeting Password</td>
                            										<td>:</td>
                            										<td><?php echo $res_sch['global_meet_data']['password'];?></td>
                            									</tr>
                            								<?php }?>
                            							<?php }?>
    												</tbody>
    											</table>
    										</div>
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
    		</div>
    		<!-- /.modal-content -->
    	</div>
    	<!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php }
}?>