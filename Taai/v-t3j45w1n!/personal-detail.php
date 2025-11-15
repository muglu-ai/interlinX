<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profile</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('profile-pic');?>
			<div class="col-md-9">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active">View Profile</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url('personal-detail/update');?>">Edit Profile</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url('my-industry-sectors');?>">Edit My Industry Sector</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url('industry-sectors');?>">Edit Interested Industry Sector</a></li>
						</ul>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<div class="active tab-pane" id="view">
								<!-- Post -->
								<div class="">
									<!-- /.card-header -->
									<div class="card-body profile-i">
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
											<div class="col-lg-5"><i class="fas fa-user mr-1"></i><strong>Name</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['title']." ".$res['fname']." ".$res['lname'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-envelope mr-1"></i> Primary Email</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['pri_email'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-phone mr-1"></i> Mobile/Tel.</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo "+".$res['mob_cntry_code']."-".$res['mob_number'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-briefcase mr-1"></i>Designation</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['desig'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-sitemap mr-1"></i>Organisation</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['org_name'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-sitemap mr-1"></i>Organisation Profile</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php
                									 $temp_org_profile = stripslashes($res['org_profile']);
                									 echo $temp_org_profile;
                									 
                									 ?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row" style="display: none;">
											<div class="col-lg-5"><strong><i class="fas fa-coins mr-1"></i>Organisation Turnover</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['org_turn_over_unit']." ".$res['org_turn_over'];?>
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-file-alt mr-1"></i> Website</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['web_site'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-pencil-alt mr-1"></i>Keywords</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $qr_key_search_user_ans_keys;?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row"  style="display: none;">
											<div class="col-lg-5"><strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['addr1'] . ' ' . $res['addr2'];?>
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-map-marker-alt mr-1"></i> City/Town</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['city'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-map-marker-alt mr-1"></i> State</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['state'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-map-marker-alt mr-1"></i> Country</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['country'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-map-marker-alt mr-1"></i> Zip/Postal Code</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo $res['pin'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-phone mr-1"></i> Tele. Number</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php echo "+".$res['hm_ph_cntry_code']."-".$res['hm_ph_area_code']."-".$res['hm_ph_number'];?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-file-alt mr-1"></i> Organisation/Product Brief Profile</strong>
											</div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php if($res['file_org_prodct_profile'] != "") {?>
														<a href="<?php echo $res['file_org_prodct_profile'];?>" target="_blank">Click Here</a> to View  Organisation/Product Brief<br/>
														Delete already uploaded Organisation/Product Brief file&nbsp;
														<a href="<?php echo base_url('delete-organisation-file');?>" title="Delete File" class="font-red"><i class="fas fa-times"></i></a>
													<?php }?>
												</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-5"><strong><i class="fas fa-file-alt mr-1"></i> Shared Video Links</strong></div>
											<div class="col-lg-7">
												<p class="text-muted">
													<?php 
                    									$temp_multi_video_link_array = explode(";",$res['org_video_links']);
                    									foreach($temp_multi_video_link_array as $temp_multi_video_link_array_val){
                    										echo "<a href='$temp_multi_video_link_array_val' target='_blank'>$temp_multi_video_link_array_val</a><br />";
                    									}?>
												</p>
											</div>
										</div>
									</div>
									<!-- /.card-body -->
								</div>
							</div>
							<!-- /.tab-pane -->
						</div>
						<!-- /.tab-content -->
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
	function showFileBox() {
		var fileupload = document.getElementById("photo");
		var button = document.getElementById("btnup");
        button.onclick = function () {
            fileupload.click();
        };
	}
	
	function stat_val_photo()
    {
    	if(document.getElementById("photo").value == "")
    	{
    		alert("Please Select Photo to upload");
    		document.getElementById("photo").focus();
    		return false;
    	}
    	else
    	{
    		return true;
    	}
    }
    
    function val_photo()
    {
    	
    	if(stat_val_photo())
    	{
    		document.form_upload_photo.submit();
    		return true;
    	}
    	else
    	{
    		return false;	
    	}
    	
    }
</script>