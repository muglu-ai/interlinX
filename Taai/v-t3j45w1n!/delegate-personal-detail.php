<?php require_once 'db_con.php'?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Details of <?php echo $qr_uid_search_res['title']." ".$qr_uid_search_res['fname']." ".$qr_uid_search_res['lname']; ?></h1>

			</div>

		</div>

	</div>

	<!-- /.container-fluid -->

</section>

<!-- Main content -->

<section class="content">

	<div class="container">

		<div class="row">

			<div class="col-md-12 col-sm-12 col-xs-12">

				<!-- /.card -->

				<div class="card">

					<div class="card-body bg-light">

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

							<!-- /.col -->

							<div class="col-md-12">

								<!-- Widget: user widget style 1 -->

								<div class="card card-widget widget-user-2">

									<!-- Add the bg color to the header using any of the bg-* classes -->

									<div class="widget-user-header1 bg-info">

										<div class="widget-user-image p-4">

											<?php if(file_exists($qr_uid_search_res['photo'])) {?>

												<img class=" elevation-2 img-fluid mr-3" src="<?php echo base_url($qr_uid_search_res['photo']);?>" />

											<?php } else {?>

												<img class=" elevation-2 img-fluid mr-3" src="<?php echo base_url('uploads/default_file.jpg');?>" />

											<?php }?>

										</div>

										<!-- /.widget-user-image -->

									</div>

									<div class="card-body pt-5">

										<div class="col-md-12">

											<div class="table-responsive">

												<table class="table table-borderless">

													<tbody>

														<tr>

															<td width="5%" class="font-weight-bold w-one">Name</td>

															<td width="2%">:</td>

															<td width="30%" class="w-two"><?php echo $qr_uid_search_res['title']." ".$qr_uid_search_res['fname']." ".$qr_uid_search_res['lname']; ?></td>

														</tr>

														<tr>

															<td class="font-weight-bold">Designation</td>

															<td>:</td>

															<td><?php echo $qr_uid_search_res['desig']; ?></td>

														</tr>

														<tr>

															<td class="font-weight-bold">Organisation Name</td>

															<td>:</td>

															<td><?php echo $qr_uid_search_res['org_name']; ?></td>

														</tr>

														<?php if(!empty($qr_uid_search_res['org_profile'])) {?>

														<tr>

															<td class="font-weight-bold">Organisation Profile</td>

															<td>:</td>

															<td><?php

                                                                $pro = mysqli_escape_string($dbConn, $qr_uid_search_res['org_profile']);



                                                                echo $pro; ?></td>

														</tr>

														<?php }?>

														<tr>

															<td class="font-weight-bold">My Industry Sectors</td>

															<td>:</td>

															<td><?php echo str_replace(';'," | ",$qr_uid_search_res['my_industries']); ?></td>

														</tr>

														<?php if(!empty($qr_uid_search_res['city'])) {?>

														<tr>

															<td class="font-weight-bold">City</td>

															<td>:</td>

															<td><?php echo $qr_uid_search_res['city']; ?></td>

														</tr>

														<?php } if(!empty($qr_uid_search_res['state'])) {?>

														<tr>

															<td class="font-weight-bold">State</td>

															<td>:</td>

															<td><?php echo $qr_uid_search_res['state']; ?></td>

														</tr>

														<?php } if(!empty($qr_uid_search_res['country'])) {?>

														<tr>

															<td class="font-weight-bold">Country</td>

															<td>:</td>

															<td><?php echo $qr_uid_search_res['country']; ?></td>

														</tr>

														<?php }if($qr_uid_search_res['web_site'] != ""){?>

    														<tr>

    															<td class="font-weight-bold">Website</td>

    															<td>:</td>

    															<td><?php if(stristr($qr_uid_search_res['web_site'],"http://") != "")

                                            							{

                                            							    echo '<a href="' . $qr_uid_search_res['web_site'] . '" target="_blank">' . $qr_uid_search_res['web_site'] . '</a>';

                                            							}

                                            							else

                                            							{

                                            							    echo '<a href="http://' . $qr_uid_search_res['web_site'] . '" target="_blank">http://' . $qr_uid_search_res['web_site'] . '</a>';

                                            							}?>

                                        						</td>

    														</tr>

    													<?php } if(!empty($qr_key_search_ans)) {?>

														<tr>

															<td class="font-weight-bold">Keywords</td>

															<td>:</td>

															<td><?php if(!empty($qr_key_search_ans))

                                        							{

                                        								$i_key=1;

                                        								for($i_key=1;$i_key<=10;$i_key++)

                                        								{

                                        									if($qr_key_search_ans['key_'.$i_key] != "")

                                        									{

                                        										echo $qr_key_search_ans['key_'.$i_key].", ";

                                        									}

                                        								}

                                        							}?>

															</td>

														</tr>

														<?php }?>

														<tr>

															<td class="font-weight-bold">I am looking for:</td>

															<td>:</td>

															<td><?php $intr_usr = "";

																		for($i_intr_usr=1;$i_intr_usr<=39;$i_intr_usr++)

																		{

																			if(isset($qr_uid_search_res['intr'.$i_intr_usr]) && $qr_uid_search_res['intr'.$i_intr_usr] != "")

																			{

																				if($intr_usr)

																				{

																					$intr_usr = $intr_usr." | ";

																				}

																				$intr_usr = $intr_usr.$qr_uid_search_res['intr'.$i_intr_usr];

																			}

																		}

																	

																   echo $intr_usr;?>

															</td>

														</tr>

														<?php if($qr_uid_search_res['org_video_links'] != ""){?>

    														<tr>

    															<td class="font-weight-bold">Video Link</td>

    															<td>:</td>

    															<td>

    																<?php $temp_multi_video_link_array = explode(";",$qr_uid_search_res['org_video_links']);

                                        									foreach($temp_multi_video_link_array as $temp_multi_video_link_array_val){

                                        										echo "<a href='";

                                        										if(stristr($temp_multi_video_link_array_val,"http://") != "")

                                        										{

                                        											echo $temp_multi_video_link_array_val;

                                        										}

                                        										else

                                        										{

                                        											echo "http://".$temp_multi_video_link_array_val;

                                        										}	 

                                        										echo "' target='_blank'>VIEW VIDEO</a><br />";

                                        									}?>

    															</td>

    														</tr>

    													<?php }?>

    													<?php if($qr_uid_search_res['file_org_prodct_profile'] != ""){?>

    														<tr>

    															<td class="font-weight-bold">Product Brief</td>

    															<td>:</td>

    															<td><strong><a href="<?php echo base_url($qr_uid_search_res['file_org_prodct_profile']); ?>">Click Here</a> to Download  Organisation/ Product Brief </strong></td>

    														</tr>

    													<?php }?>

    													<?php if(!empty($qr_prod_dtails_list)) {?>

    														<tr>

    															<td class="font-weight-bold">Product/Services </td>

    															<td>:</td>

    															<td>

    																<?php $usr_prod_cnt = 1;foreach ($qr_prod_dtails_list as $qr_prod_dtails_ans) {?>

    																	<table width="100%" border="0" cellspacing="1" cellpadding="0">

                                                                           <tr>

                                                                            <td align="center" valign="top" colspan="3" height="2"></td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td width="6%" rowspan="4" align="center" valign="top"><strong><?php echo $usr_prod_cnt++;?></strong></td>

                                                                            <td width="20%" rowspan="4" align="center" valign="middle"><img src="<?php echo $qr_prod_dtails_ans['product_image'];?>" width="50" height="50" border="0"></td>

                                                                            <td width="74%" align="left" valign="middle"><a href="<?php 

                                            								//echo $qr_prod_dtails_ans['product_link'];

                                            								if(stristr($qr_prod_dtails_ans['product_link'],"http://") != "")

                                            								{

                                            									echo $qr_prod_dtails_ans['product_link'];

                                            								}

                                            								else

                                            								{

                                            									echo "http://".$qr_prod_dtails_ans['product_link'];

                                            								}

                                            								?>" target="_blank">

                                            								<?php echo $qr_prod_dtails_ans['product_title'];?></a></td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td align="left" valign="middle"><strong>Type :</strong> <?php echo $qr_prod_dtails_ans['product_type'];?></td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td align="left" valign="middle"><strong>Video Link : </strong>

                                            								<?php

                                            								//echo $qr_prod_dtails_ans['product_video_link'];

                                            								echo "<a href='";

                                            								if(stristr($qr_prod_dtails_ans['product_video_link'],"http://") != "")

                                            								{

                                            									echo $qr_prod_dtails_ans['product_video_link'];

                                            								}

                                            								else

                                            								{

                                            									echo "http://".$qr_prod_dtails_ans['product_video_link'];

                                            								}	 

                                            								echo "' target='_blank'>".$qr_prod_dtails_ans['product_video_link']."</a><br />";

                                            								?>								</td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td align="left" valign="middle"><strong>Keywords : </strong>

                                                                           <?php $intr_usr_prod_key = "";

                                                                				for($i_intr_usr_prod_key=1;$i_intr_usr_prod_key<=10;$i_intr_usr_prod_key++)

                                                                				{

                                                                					if($qr_prod_dtails_ans['prod_key_'.$i_intr_usr_prod_key] != "")

                                                                					{

                                                                						if($intr_usr_prod_key)

                                                                						{

                                                                							$intr_usr_prod_key = $intr_usr_prod_key.", ";

                                                                						}

                                                                						$intr_usr_prod_key = $intr_usr_prod_key.$qr_prod_dtails_ans['prod_key_'.$i_intr_usr_prod_key];

                                                                					}

                                                                				}

                                            			

                                            	                               echo $intr_usr_prod_key;	?>                                

                                            	                             </td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td align="center" valign="top">&nbsp;</td>

                                                                            <td align="center" valign="top"><strong>Details :</strong></td>

                                                                            <td align="left" valign="top"><?php echo $qr_prod_dtails_ans['product_details'];?></td>

                                                                          </tr>

                                                                          <tr>

                                                                            <td align="center" valign="top" colspan="3" height="1" bgcolor="#999999"></td>

                                                                          </tr>

                                                                        </table>

    																<?php }?>

    															</td>

    														</tr>

														<?php }?>

													</tbody>

												</table>

											</div>

										</div>

										<div class="clearfix border-top border-bottom bg-light pt-2 pb-2 ">

											<div class="row">

												<div class="col-lg-4 mb-1 text-center">

													<?php if(empty($data_short)) {?>

														<a href="<?php echo base_url('add-friend/' . $qr_uid_search_res['dup_user_id']);?>" class="btn btn-block btn-success btn-md">Shortlist Partner</a>

													<?php } else {?>

														<span class="badge bg-success p-2 mt-2"><strong>Already Shortlisted</strong></span>

													<?php }?>

												</div>

												<div class="col-lg-4 mb-1">

													<a href="#" data-toggle="modal" data-target="#modal-lg" class="btn btn-block bg-yellow-gold btn-md">Send Message</a>

												</div>

												<div class="col-lg-4 mb-1">

													<a href="<?php echo base_url('view-schedule/' . $qr_uid_search_res['dup_user_id']);?>" class="btn btn-block btn-info btn-md">Request Meeting</a>

												</div>

											</div>

										</div>

										<!-- /.row -->

									</div>

								</div>

								<!-- /.widget-user -->

							</div>

							<!-- /.col -->

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- /.col -->

	</div>

	<!-- /.row -->

	<!-- /.container-fluid -->

</section>

<!-- /.row -->



<div class="modal fade" id="modal-lg">

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

    						<form action="<?php echo base_url('messages/compose');?>" method="post" name="form1" id="form1" onsubmit="return val_compose_msg_form()">

    							<input name="frnd_lst" id="frnd_lst" type="hidden" value="<?php echo $qr_uid_search_res['user_id']; ?>"  />

    							<input name="is_meeting_send" type="hidden" value="true"  />

        						<!-- /.card-header -->

        						<div class="card-body">

        							<div class="mailbox-read-info">

        								<p><span class="font-weight-bold">Name:</span> <?php echo $qr_uid_search_res['title'].$qr_uid_search_res['fname']." ".$qr_uid_search_res['lname']; ?></p>

        							</div>

                        			<div class="form-group">

                        				<label for="inputName" class="col-form-label">Subject</label>

                        				<input class="form-control" placeholder="Subject" name="msg_subject" type="text" id="msg_subject">

                        			</div>

                        			<div class="form-group">

                        				<label for="inputName" class="col-form-label">Message</label>

                        				<textarea class="form-control" name="msg_txt" id="msg_txt"></textarea>

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



<link href="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.css')?>" rel="stylesheet">

<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>

<script type="text/javascript">

	$('#msg_txt').summernote({

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

      

      function val_compose_msg_form()

        {		

        	if(document.getElementById("frnd_lst").value == "")

        	{

        	

        		alert("Please Recepient to send message");

        		document.getElementById("frnd_lst").focus();

        		return false;

        	}

        	

        	if(document.getElementById("msg_subject").value == "")

        	{

        	

        		alert("Please Enter Subject");

        		document.getElementById("msg_subject").focus();

        		return false;

        	}

        

        	if(document.getElementById("msg_txt").value == "")

        	{	

        		alert("Please Enter Message");

        		document.getElementById("msg_txt").focus();

        		return false;

        	}

        	

        	return true;

        }

</script>