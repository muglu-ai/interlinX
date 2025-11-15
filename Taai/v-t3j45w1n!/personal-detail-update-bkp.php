<link href="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.css')?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css');?>"/>
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
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url('personal-detail');?>">View Profile</a></li>
							<li class="nav-item"><a class="nav-link active">Edit</a></li>
						</ul>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<!-- /.tab-pane -->
							<div class="active tab-pane" id="settings">
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
								<form action="<?php echo base_url('personal-detail/update');?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate_personal_info()">
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="inputEmail4" class="font-weight-bold">Name</label>
											<p class="text-muted font-weight-bold"><?php echo $res['title']." ".$res['fname']." ".$res['lname'];?></p>
										</div>
										<div class="form-group col-md-6">
											<label for="inputEmail4" class="font-weight-bold">Email</label>
											<p class="text-muted font-weight-bold"><?php echo $res['pri_email'];?></p>
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="org_edit" class="font-weight-bold">Organisation<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="org_edit" id="org_edit" value="<?php echo $res['org_name'];?>" placeholder="Organisation" required="required">
										</div>
										<div class="form-group col-md-6">
											<label for="org_profile" class="font-weight-bold">Organisation Profile<span class="tej-required"> *</span></label>
											<textarea class="form-control" name="org_profile" id="org_profile" placeholder="Organisation Profile"><?php echo $res['org_profile'];?></textarea>
											<small>(Organisation Profile should be less 500 characters)</small>
										</div>
									</div>
									<hr>
									<div class="form-row" style="display: none;">
										<div class="form-group col-md-6">
											<label for="org_turn_over" class="font-weight-bold">Organisation Turnover</label>
											<input type="text" class="form-control" name="org_turn_over" id="org_turn_over" value="<?php echo ($res['org_turn_over']);?>" placeholder="Turnover">
										</div>
										<div class="form-group col-md-6">
											<label for="org_turn_over_unit">&nbsp;</label>
											<select name="org_turn_over_unit" id="org_turn_over_unit" class="form-control">
												<option value="">-- Choose currency --</option>
												<option value="USD" <?php if($res['org_turn_over_unit'] == "USD"){?> selected="selected" <?php }?>>USD</option>
												<option value="INR" <?php if($res['org_turn_over_unit'] == "INR"){?> selected="selected" <?php }?>>INR</option>
											</select>
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="key" class="font-weight-bold">Keywords</label>
											<input type="text" class="form-control" name="key" id="key" value="<?php echo $qr_key_search_user_ans_keys;?>" placeholder="Keywords" >
											<label>you can enter 10 keyword seperated by semicolon [ ; ]</label>
										</div>
										<div class="form-group col-md-6">
											<label for="desig_edit" class="font-weight-bold">Designation<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="desig_edit" id="desig_edit" value="<?php echo $res['desig'];?>" placeholder="Designation" required="required">
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="addr_line1" class="font-weight-bold">Address Line 1 <span class="tej-required"> *</span></label>
											<textarea class="form-control" name="addr_line1" id="addr_line1" placeholder="Apartment, studio, or floor" required="required"><?php echo $res['addr1'];?></textarea>
										</div>
										<div class="form-group col-md-6">
											<label for="addr_line2" class="font-weight-bold">Address Line 2 </label>
											<textarea class="form-control" name="addr_line2" id="addr_line2" placeholder="Apartment, studio, or floor"><?php echo $res['addr2'];?></textarea>
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-4">
											<label for="city" class="font-weight-bold">City/Town<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="city" id="city" value="<?php echo $res['city'];?>" placeholder="City/Town" required="required">
										</div>
										<div class="form-group col-md-4">
											<label for="state" class="font-weight-bold">State<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="state" id="state" value="<?php echo $res['state'];?>" placeholder="State" required="required">
										</div>
										<div class="form-group col-md-4">
											<label for="country" class="font-weight-bold">Country<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="country" id="country" value="<?php echo $res['country'];?>" placeholder="Country" required="required">
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="pin_no" class="font-weight-bold">Zip/Postal Code<span class="tej-required"> *</span></label>
											<input type="text" class="form-control" name="pin_no" id="pin_no" value="<?php echo $res['pin'];?>" placeholder="Zip/Postal Code" required="required">
										</div>
										<div class="form-group col-md-6">
											<label for="website" class="font-weight-bold">Website</label>
											<input type="text" class="form-control" name="website" id="website" value="<?php echo $res['web_site'];?>" placeholder="www.abc.com">
											<lable>e.g. www.abc.com</lable>
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<div class="row">
												<div class="form-group col-md-4">
													<label for="mob_phone_cntry_code" class="font-weight-bold">Country Code<span class="tej-required"> *</span></label>
													<input type="number" class="form-control" name="mob_phone_cntry_code" id="mob_phone_cntry_code" maxlength="5" value="<?php echo $res['mob_cntry_code'];?>" placeholder="91" required="required">
												</div>
												<div class="form-group col-md-8">
													<label for="mob_phone_number" class="font-weight-bold">Mobile No.<span class="tej-required"> *</span></label>
													<input type="number" class="form-control" name="mob_phone_number" id="mob_phone_number" maxlength="15" value="<?php echo $res['mob_number'];?>" placeholder="" required="required">
												</div>
											</div>
										</div>
										<div class="form-group col-md-6">
											<div class="row">
												<div class="form-group col-md-3">
													<label for="home_phone_cntry_code" class="font-weight-bold">Country Code</label>
													<input type="number" class="form-control" name="home_phone_cntry_code" id="home_phone_cntry_code" maxlength="5" value="<?php echo $res['hm_ph_cntry_code'];?>" placeholder="+91">
												</div>
												<div class="form-group col-md-3">
													<label for="home_phone_area_code" class="font-weight-bold">Area Code</label>
													<input type="number" class="form-control" name="home_phone_area_code" id="home_phone_area_code" maxlength="7" value="<?php echo $res['hm_ph_area_code'];?>" placeholder="">
												</div>
												<div class="form-group col-md-6">
													<label for="home_phone_number" class="font-weight-bold">Telephone No.</label>
													<input type="number" class="form-control" name="home_phone_number" id="home_phone_number" maxlength="15" value="<?php echo $res['hm_ph_number'];?>" placeholder="">
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="profile_brief" class="font-weight-bold"> Upload Organisation/ Product Brief Profile</label>
											<div class="custom-file1 mb-3">
												<input name="profile_brief" id="profile_brief" class="custom-file-input1" type="file" >
												<br/><small>Note: Only PDF Filetype is Supported & File should be less than 2 MB</small>
												<?php if($res['file_org_prodct_profile'] != "") {?>
													<br/><a href="<?php echo $res['file_org_prodct_profile'];?>" target="_blank">Click Here</a> to View  Organisation/Product Brief<br/>
													Delete already uploaded Organisation/Product Brief file&nbsp;
													<a href="<?php echo base_url('delete-organisation-file');?>" title="Delete File" class="font-red"><i class="fas fa-times"></i></a>
												<?php }?>
											</div>
										</div>
										<?php /*<div class="form-group col-md-6">
											<label for="profile_brief" class="font-weight-bold"> Upload Organisation/ Product Brief Profile</label>
											<div class="custom-file mb-3">
												<input name="profile_brief" id="profile_brief" class="custom-file-input1" type="file" >
												<label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
												<small>Note: Only PDF Filetype is Supported & File should be less than 2 MB</small>
												<?php if($res['file_org_prodct_profile'] != "") {?>
													<br/><a href="<?php echo $res['file_org_prodct_profile'];?>" target="_blank">Click Here</a> to View  Organisation/Product Brief<br/>
													Delete already uploaded Organisation/Product Brief file&nbsp;
													<a href="<?php echo base_url('delete-organisation-file');?>" title="Delete File" class="font-red"><i class="fas fa-times"></i></a>
												<?php }?>
											</div>
										</div>*/?>
										<hr>
										<div class="form-group col-md-6">
											<label for="org_video_links" class="font-weight-bold">Shared Video Link</label>
											<input type="text" class="form-control" name="org_video_links" id="org_video_links" value="<?php echo $res['org_video_links'];?>" placeholder="http://www.youtube.com/watch?">
											<small>e.g. http://www.youtube.com/watch?v=Uiz7pfuCayM; http://www.youtube.com/watch?v=6wyZojTIlu4
											you can enter multiple links seperated by semicolon [ ; ]</small>
										</div>
									</div>
									<button type="submit" class="btn btn-primary">Submit</button>
								</form>
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
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>
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
    
    $(document).ready(function() {
     	$('#org_profile').summernote({
            //tabsize: 2,
            height: 80,
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
    });
    
    function check_email(dummy_id3)
    {
    	var email2 = document.getElementById(dummy_id3).value;
    	var f = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    	if(email2!="")
    	{
    		if (!f.test(email2)) 
    		{	
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
    //-------------------------------------------------------------------------------------------------------------------------	
    
    
    //-----------------------------Fucnction for checking Numbers only ------------------------------------------	
    
    function check_num_reg(dummy_id)
    {
    	var reg_exp=/^\d+$/;
    	var val=document.getElementById(dummy_id).value;
    	if(val!="")
    	{
    		if(!val.match(reg_exp))
    		{
    			return false;
    		}
    		else
    		{
    			return true;	
    		}
    	}
    
    }
    //-------------------------------------------------------------------------------------------------------------------------	
    
    
    //-----------------------------Fucnction for checking website validity only -------------------------	
    
    function check_website_reg(dummy_id6)
    {
    	var web=document.getElementById(dummy_id6).value;
    	var rf=/^(([w]+[w]+[w]+\.))+(([a-zA-Z0-9\-\_])+\.)+([a-zA-Z0-9{2,4}])+$/;
     
     	if(web!="")
    	{
    	
    		/*if(!rf.test(web))
    		{
    		alert("Invalid web address");
    		document.getElementById(dummy_id6).focus();
    		return false;
    		}*/
    	}
    	
    	return true;
    }	
    
    
    //-----------------------------Fucnction for checking video validity only -------------------------	
    
    function check_video_reg(dummy_id6)
    {
    	var web=document.getElementById(dummy_id6).value;
    	var rf=/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
     
     	if(web!="")
    	{
    	
    		if(!rf.test(web))
    		{
    		alert("Invalid web address");
    		document.getElementById(dummy_id6).focus();
    		return false;
    		}
    	}
    	
    	return true;
    }	

    function validate_personal_info()
	{
    	//alert("test");
    	if(document.getElementById("org_edit").value == "")
    	{
    		alert("Please Enter Organisation Name");
    		document.getElementById("org_edit").focus();
    		return false;
    	}
    	
    	if(document.getElementById("org_profile").value == "")
    	{
    		alert("Please Enter Organisation Profile");
    		document.getElementById("org_profile").focus();
    		return false;
    	}
    	
    	
    	if(document.getElementById("org_turn_over").value != "")
    	{
    	
    		if(document.getElementById("org_turn_over_unit").value == "")
    		{
    			alert("Please Select Organisation turn Over Unit");
    			document.getElementById("org_turn_over_unit").focus();
    			return false;
    		}
    		
    		if(!check_num_reg("org_turn_over"))
    		{
    					alert("Please Enter Numbers in  Organisation turn Over ");
    					document.getElementById("org_turn_over").value = "";
    					document.getElementById("org_turn_over").focus();
    					return false;
    		}
    		
    	}
    	
    	if(document.getElementById("org_turn_over_unit").value != ""){
    		
    		if(document.getElementById("org_turn_over").value == "")
    		{
    			alert("Please Enter Organisation turn Over");
    			document.getElementById("org_turn_over").focus();
    			return false;
    		}
    		
    	}
    	
    	/* if(document.getElementById("key").value == "")
    	{
    		alert("Please Enter Keyword");
    		document.getElementById("key").focus();
    		return false;
    	} */
    	if(document.getElementById("desig_edit").value == "")
    	{
    		alert("Please Enter Designation");
    		document.getElementById("desig_edit").focus();
    		return false;
    	}
    	if(document.getElementById("addr_line1").value == "")
    	{
    		alert("Please Enter Address");
    		document.getElementById("addr_line1").focus();
    		return false;
    	}
    	if(document.getElementById("city").value == "")
    	{
    		alert("Please Enter City");
    		document.getElementById("city").focus();
    		return false;
    	}
    	if(document.getElementById("state").value == "")
    	{
    		alert("Please Enter State");
    		document.getElementById("state").focus();
    		return false;
    	}
    	if(document.getElementById("country").value == "")
    	{
    		alert("Please Enter Country");
    		document.getElementById("country").focus();
    		return false;
    	}
    	
    	if(document.getElementById("mob_phone_cntry_code").value == "")
    	{
    		alert("Please Enter Mobile Country Code");
    		document.getElementById("mob_phone_cntry_code").focus();
    		return false;
    	}
    	if(document.getElementById("mob_phone_number").value == "")
    	{
    		alert("Please Enter Mobile Number");
    		document.getElementById("mob_phone_number").focus();
    		return false;
    	}
    			
    	if( (document.getElementById("mob_phone_cntry_code").value != "") || (document.getElementById("mob_phone_number").value != "") )
    	{
    			if(document.getElementById("mob_phone_cntry_code").value == "")
    			{
    					alert("Please Enter Correct Mobile Number");
    					document.getElementById("mob_phone_cntry_code").value = "";
    					document.getElementById("mob_phone_cntry_code").focus();
    					return false;
    			}
    			
    			if(document.getElementById("mob_phone_number").value == "")
    			{
    					alert("Please Enter Correct Mobile Number");
    					document.getElementById("mob_phone_number").value = "";
    					document.getElementById("mob_phone_number").focus();
    					return false;
    			}
    			
    			
    			if(document.getElementById("mob_phone_cntry_code").value != "")
    			{
    				if(!check_num_reg("mob_phone_cntry_code"))
    				{
    					alert("Please Enter Correct Mobile Number");
    					document.getElementById("mob_phone_cntry_code").value = "";
    					document.getElementById("mob_phone_cntry_code").focus();
    					return false;
    				}
    				
    			}
    			
    			if(document.getElementById("mob_phone_number").value != "")
    			{
    				if(!check_num_reg("mob_phone_number"))
    				{
    					alert("Please Enter Correct Mobile Number");
    					document.getElementById("mob_phone_number").value = "";
    					document.getElementById("mob_phone_number").focus();
    					return false;
    				}
    				
    			}
    	}
    
    	if(document.getElementById("city").value != "")
    	{
    		if(check_num_reg("city"))
    		{
    			alert("Please Correct City Name");
    			document.getElementById("city").value = "";
    			document.getElementById("city").focus();
    			return false;
    		}
    	}
    	
    	if(document.getElementById("state").value != "")
    	{
    		if(check_num_reg("state"))
    		{
    			alert("Please Correct State Name");
    			document.getElementById("state").value = "";
    			document.getElementById("state").focus();
    			return false;
    		}
    	}
    	
    	if(document.getElementById("country").value != "")
    	{
    		if(check_num_reg("country"))
    		{
    			alert("Please Correct Country Name");
    			document.getElementById("country").value = "";
    			document.getElementById("country").focus();
    			return false;
    		}
    	}
    	
    	
    	if(document.getElementById("website").value != "")
    	{
    		if(!(check_website_reg("website")))
    		{
    			return false;
    		}
    	}
    	if(document.getElementById("org_video_links").value != "")
    	{
    		if(!(check_website_reg("org_video_links")))
    		{
    			return false;
    		}
    	}
    	//document.form1.submit();
    	return true;
    }
</script>

<script src="<?php echo base_url('assets/js/jquery-ui.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/tags-input.js');?>"></script>
<script type="text/javascript">
$(function() {
	$('#key').tagsInput({
		'placeholder': 'Add keywords',
		'limit': 10
	});
});
</script>