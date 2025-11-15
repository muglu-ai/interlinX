<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Accepted Meeting Request</h1>

			</div>

		</div>

	</div>

	<!-- /.container-fluid -->

</section>

<!-- Main content -->

<section class="content">

	<div class="container">

		<div class="row">

			<?php if(!empty($meeting_list)) {?>

				<?php $i = $offset;foreach ($meeting_list as $met_req_rec_row) {?>

        			<div class="col-md-6">

        				<div class="card card-primary card-outline">

        					<div class="card-body">

        						<div class="table-responsive">

        							<table class="table table-borderless">

        								<tbody>

        									<tr>

        										<td width="10%" rowspan="10"><?php echo ++$i;?>.</td>

        										<td width="35%" class="font-weight-bold">Receiver Name</td>

        										<td width="">:</td>

        										<td width="55%"><?php echo $met_req_rec_row['receiver_title'].$met_req_rec_row['receiver_fname']." ".$met_req_rec_row['receiver_lname'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Receiver Organisation</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['receiver_org'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Receiver Organisation Profile</td>

        										<td>:</td>

        										<td>

													<?php $temp_org_profile = $met_req_rec_row['receiver_org_profile']; 

														  

														  echo substr($temp_org_profile, 0, 200);

														  if(strlen($temp_org_profile) > 200){

														      echo "...<a href='" . base_url('delegate-personal-detail/' . $met_req_rec_row['receiver_user_id']) . "' target='_blank'>more</a>";

														  }?>

												</td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Receiver Designation</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['receiver_desig'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Meeting Date</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['meeting_date'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Meeting Time slot</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['meeting_time_start']." - ".$met_req_rec_row['meeting_time_end'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Message</td>

        										<td>:</td>

        										<td><?php echo nl2br($met_req_rec_row['messege']);?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Meeting Request Status</td>

        										<td>:</td>

        										<td>

        											<div class="col-lg-3 row">

        												<?php if($met_req_rec_row['status'] == "Accepted"){?>

        													<span class="badge bg-success p-2"><?php echo $met_req_rec_row['status'];?></span>

        												<?php }?>

        												<?php if($met_req_rec_row['status'] == "Pending"){?>

        													<span class="badge bg-warning p-2"><?php echo $met_req_rec_row['status'];?></span>

        												<?php }?>

        												<?php if($met_req_rec_row['status'] == "Rejected"){?>

        													<span class="badge bg-danger p-2"><?php echo $met_req_rec_row['status'];?></span>

        												<?php }?>

        											</div>

        										</td>

        									</tr>

        									<?php if($met_req_rec_row['status'] == "Accepted" && date('Y-m-d') >= ZOOM_MEETING_ACTIVATE_DATE){?>

            									<tr>

            										<td class="font-weight-bold">Zoom Meeting Link</td>

            										<td>:</td>

            										<td><a href="<?php echo $met_req_rec_row['zoom_host_link'];?>" target="_blank" class="btn btn-sm bg-blue">JOIN NOW</a></td>

            									</tr>

            									<tr>

            										<td class="font-weight-bold">Zoom Meeting Password</td>

            										<td>:</td>

            										<td><?php echo $met_req_rec_row['password'];?></td>

            									</tr>

            								<?php }?>

        								</tbody>

        							</table>

        						</div>

        					</div>

        				</div>

        			</div>

				<?php }?>

			<?php } else {?>

				<div class="col-md-12">

					<div class="card card-primary card-outline">

						<div class="card-body">

							<div class="alert alert-info">No meetings yet...</div>

						</div>

					</div>

				</div>

			<?php }?>

			<!-- /.col -->

			<?php if(!empty($pagination)) {?>

    			<div class="col-md-12">

    				<div class="card">

    					<div class="card-footer p-0">

    						<div class="mailbox-controls">

    							<div class="float-right">

    								<nav aria-label="...">

    									<?php echo $pagination;?>

    								</nav>

    								<!-- /.btn-group -->

    							</div>

    							<!-- /.float-right -->

    						</div>

    					</div>

    				</div>

    			</div>

    		<?php }?>

		</div>

		<!-- /.row -->

	</div>

	<!-- /.container-fluid -->

</section>

<!-- /.content -->