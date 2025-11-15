<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Change Password</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<section class="content-header">
	<!-- /.col -->
	<div class="container">
		<div class="card card-primary card-outline">
			<!-- /.card-header -->
			<div class="card-body">
				<form action="<?php echo base_url('change-password');?>" method="post" name="form1" id="form1" onsubmit="return validate()">
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
    				<div class="form-group">
    					<input class="form-control" placeholder="Old Password" name="old_pass" type="password" id="old_pass">
    				</div>
    				<div class="form-group">
    					<input class="form-control" placeholder="New Password" name="pass1" type="password" id="pass1">
    				</div>
    				<div class="form-group">
    					<input class="form-control" placeholder="Confirm Password" name="pass2" type="password" id="pass2">
    				</div>
    				<div class="form-group">
    					<button type="submit" class="btn btn-primary btn-md">Save Changes</button>
    				</div>
    			</form>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.col -->
	<!-- /.container-fluid -->
</section>
<script language="javascript">
function validate()
{
	if(document.getElementById("old_pass").value == "")
	{
		alert("Please fill your old Password");
		document.getElementById("old_pass").focus();
		return false;
	}
	
	if(document.getElementById("pass1").value == "")
	{
		alert("Please fill Password");
		document.getElementById("pass1").focus();
		return false;
	}
	else if(document.getElementById("pass1").value!="") 
	{
		var len1 = document.getElementById("pass1").value.length;
		if(len1 <= 5)
		{
			alert("Please fill atleast 6 digit password");
			document.getElementById("pass1").value = "";
			document.getElementById("pass2").value = "";
			document.getElementById("pass1").focus();
			return false;
		}
	}
	if(document.getElementById("pass2").value == "")
	{
		alert("Please fill Alternate Password");
		document.getElementById("pass2").focus();
		return false;
	}
	if(!(document.getElementById("pass1").value == document.getElementById("pass2").value)) 
	{
		alert("Passwords not match. Please fill both passwords again");
		document.getElementById("pass1").value = "";
		document.getElementById("pass2").value = "";
		document.getElementById("pass1").focus();
		return false;
	}
	document.form1.submit();
}
</script>