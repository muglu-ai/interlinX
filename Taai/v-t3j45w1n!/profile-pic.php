<div class="col-md-3">
	<!-- Profile Image -->
	<div class="card card-primary card-outline">
		<div class="card-body box-profile">
			<?php if($this->session->flashdata('is_fileerror') != '') {?>
				<div class="alert alert-danger tej-alert-dismiss">
					<?php echo $this->session->flashdata('is_fileerror');$this->session->unset_userdata('is_fileerror');?>
				</div>
			<?php }?>
			<div class="text-center">
				<div class="profile-pic-wrapper">
					<div class="pic-holder" id="btnup" onclick="showFileBox();">
						<!-- uploaded pic shown here -->
						<img class="profile-user-img img-fluid img-circle" src="<?php echo base_url($this->userauth->get_userdata('photo')); ?>" width="100">
						<label for="newProfilePhoto" class="upload-file-block">
							<div class="text-center">
								<div class="mb-2">
									<i class="fa fa-camera fa-2x"></i>
								</div>
								<div class="text-uppercase">
									<form action="<?php echo base_url('upload-photo');?>" method="post" enctype="multipart/form-data" name="form_upload_photo" id="form_upload_photo" onsubmit="return val_photo()">
										<span>Upload <br /> Profile Photo <br />(100X100)</span>
										<input type="file" onchange="val_photo()" id="photo" name="photo" style="display: none;" />
									</form>
								</div>
							</div>
						</label>
						</label>
					</div>
				</div>
			</div>
			<h3 class="profile-username text-center"><?php echo $res['title'] . ' ' . $res['fname'] . ' ' . $res['lname'];?></h3>
			<p class="text-muted text-center"><?php echo $res['org_name'];?></p>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
	<!-- /.card -->
</div>
<!-- /.col -->