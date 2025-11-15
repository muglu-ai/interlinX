<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Received Meeting Request</h1>

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

			<?php if(!empty($meeting_list)) {?>

				<?php $i = $offset;$j=1;foreach ($meeting_list as $met_req_rec_row) {?>

        			<div class="col-md-6">

        				<div class="card card-primary card-outline">

        					<div class="card-body">

        						<div class="table-responsive">

        							<table class="table table-borderless">

        								<tbody>

        									<tr>

        										<td width="10%" rowspan="10"><?php echo ++$i;?>.</td>

        										<td width="35%" class="font-weight-bold">Sender Name</td>

        										<td width="">:</td>

        										<td width="55%">

        											<a href="<?php echo base_url('delegate-personal-detail/' . $met_req_rec_row['sender_user_id']);?>" target="_blank"><?php echo $met_req_rec_row['sender_title'].$met_req_rec_row['sender_fname']." ".$met_req_rec_row['sender_lname'];?></a>

        											<?php /*if($met_req_rec_row['read_flag'] != 'True') {?>

        												<span class="text-danger" style="float: right;">New</span>

        											<?php }*/?>

        										</td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Sender Organisation</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['sender_org'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Sender Organisation Profile</td>

        										<td>:</td>

        										<td>

													<?php $temp_org_profile = strip_tags($met_req_rec_row['sender_org_profile'], '<p>'); 

														  

														  echo substr($temp_org_profile, 0, 200);

														  if(strlen($temp_org_profile) > 200){

														      echo "...<a href='" . base_url('delegate-personal-detail/' . $met_req_rec_row['sender_user_id']) . "' target='_blank'>more</a>";

														  }?>

												</td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">Sender Designation</td>

        										<td>:</td>

        										<td><?php echo $met_req_rec_row['sender_desig'];?></td>

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

        										<td><?php echo $met_req_rec_row['messege'];?></td>

        									</tr>

        									<tr>

        										<td class="font-weight-bold">

        											<?php if($met_req_rec_row['status'] == "Pending") {?>

        												Set Request Status

        											<?php } else {?>

        												Meeting Status

        											<?php }?>

        										</td>

        										<td>:</td>

        										<td>

        											<div class="col-lg-3 row">

        												<?php if($met_req_rec_row['status'] == "Accepted") {?>

        													<span class="badge bg-success p-2"><?php echo $met_req_rec_row['status'];?></span>

        												<?php }?>

        												<?php /*if($met_req_rec_row['status'] == "Pending"){?>

        													<span class="badge bg-warning p-2"><?php echo $met_req_rec_row['status'];?></span>

        												<?php }*/?>

        												<?php if($met_req_rec_row['status'] == "Rejected" || $met_req_rec_row['status'] == "Cancelled") {?>

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

											<?php if($met_req_rec_row['table_no'] != ""){?>

            									<tr>

            										<td class="font-weight-bold">Table No.</td>

            										<td>:</td>

            										<td><?php echo $met_req_rec_row['table_no'];?></td>

            									</tr>

											<?php }?>

        								</tbody>

        							</table>

        						</div>

        						<?php if($met_req_rec_row['status'] == "Pending") {?>

            						<div class="clearfix border-top border-bottom bg-light pt-2 pb-2 mt-3">

    									<div class="">

    										<div class="row">

    											<div class="col-lg-4 m-0">

    												<a href="<?php echo base_url('set-meeting-status/' . $met_req_rec_row['messege_id'] . '/Accepted');?>" class="btn btn-block btn-success btn-md">Accept</a>

    											</div>

    											<div class="col-lg-4 m-0">

    												<a href="<?php echo base_url('set-meeting-status/' . $met_req_rec_row['messege_id'] . '/Rejected');?>" class="btn btn-block bg-yellow-gold btn-md">Reject</a>

    											</div>

    											<div class="col-lg-4 m-0">

    												<a href="#" class="btn btn-block btn-info btn-md" data-toggle="modal" data-target="#modal-lg<?php echo $j++;?>">Send Message</a>

    											</div>

    										</div>

    									</div>

    								</div>

    							<?php }?>

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



<?php if(!empty($meeting_list)) {

    $is_sendmsg = false;?>

	<?php $i = 1;foreach ($meeting_list as $met_req_rec_row) {?>

		<?php if($met_req_rec_row['status'] == "Pending") {

		    $is_sendmsg = true;?>

            <div class="modal fade" id="modal-lg<?php echo $i;?>">

                <div class="modal-dialog modal-lg">

                	<div class="modal-content">

                		<div class="modal-header bg-info">

                			<h4 class="modal-title">Send Message</h4>

                			<button type="button" class="close" data-dismiss="modal" aria-label="Close">

                			<span aria-hidden="true">&times;</span>

                			</button>

                		</div>

                		<div class="modal-body">

                			<!-- Main content -->

                			<section class="content">

                				<!-- /.col -->

                				<div class="container">

                					<div class="card ">

                						<form action="<?php echo base_url('messages/compose');?>" method="post" name="form1" id="form<?php echo $i;?>" onsubmit="return val_compose_msg_form('<?php echo $i;?>')">

                							<input name="frnd_lst" id="frnd_lst<?php echo $i;?>" type="hidden" value="<?php echo $met_req_rec_row['sender_user_id'];?>"  />

                							<input name="is_meeting_send" type="hidden" value="true"  />

                    						<!-- /.card-header -->

                    						<div class="card-body">

                    							<div class="mailbox-read-info">

                    								<p><span class="font-weight-bold">Name:</span> <?php echo $met_req_rec_row['sender_title']." ".$met_req_rec_row['sender_fname']." ".$met_req_rec_row['sender_lname']; ?></p>

                    							</div>

                                    			<div class="form-group">

                                    				<label for="inputName" class="col-form-label">Subject</label>

                                    				<input class="form-control" placeholder="Subject" name="msg_subject" type="text" id="msg_subject<?php echo $i;?>">

                                    			</div>

                                    			<div class="form-group">

                                    				<label for="inputName" class="col-form-label">Message</label>

                                    				<textarea class="form-control" name="msg_txt" id="msg_txt<?php echo $i++;?>"></textarea>

                                    			</div>

                    						</div>

                    						<!-- /.card-body -->

                    						<div class="card-footer">

                    							<div class="float-right">

                    								<button type="submit" class="btn btn-primary btn-sm"><i class="far fa-envelope"></i> Send</button>

                    							</div>

                    						</div>

                    						<!-- /.card-footer -->

                    					</form>

                					</div>

                					<!-- /.card -->

                				</div>

                				<!-- /.col -->

                			</section>

                		</div>

                	</div>

                	<!-- /.modal-content -->

                </div>

                <!-- /.modal-dialog -->

            </div>

            <!-- /.modal -->

		<?php }?>

	<?php }?>

<?php }?>

<?php if(isset($is_sendmsg) && $is_sendmsg) {?>

    <link href="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.css')?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            <?php if(!empty($meeting_list)) {?>

            	<?php $i = 1;foreach ($meeting_list as $met_req_rec_row) {?>

            		<?php if($met_req_rec_row['status'] == "Pending") {?>

                     	$('#msg_txt<?php echo $i++;?>').summernote({

                            //tabsize: 2,

                            height: 160,

                            toolbar: [

                              ['style', ['bold', 'italic', 'underline', 'clear']],

                              ['para', ['paragraph', 'ul', 'ol']],

                              ['font', ['strikethrough', 'superscript', 'subscript']],

                              //['color', ['color']],

                              //['table', ['table']],

                             // ['insert', ['link', 'picture', 'video']],

                              //['view', ['fullscreen', 'codeview', 'help']]

                            ]

                          });

    				<?php }?>

    			<?php }?>

    		<?php }?>

        });

        

        function val_compose_msg_form(i)

        {		

        	if(document.getElementById("frnd_lst" + i).value == "")

        	{

        	

        		alert("Please Recepient to send message");

        		document.getElementById("frnd_lst" + i).focus();

        		return false;

        	}

        	

        	if(document.getElementById("msg_subject" + i).value == "")

        	{

        	

        		alert("Please Enter Subject");

        		document.getElementById("msg_subject" + i).focus();

        		return false;

        	}

        

        	if(document.getElementById("msg_txt" + i).value == "")

        	{	

        		alert("Please Enter Message");

        		document.getElementById("msg_txt" + i).focus();

        		return false;

        	}

        	

        	return true;

        }

        </script>

<?php }?>