<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Product/Services Add</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="card card-primary card-outline">
				<div class="card-body align-self-center col-md-12">
					<form action="<?php echo base_url('product-services/add');?>" class="form-horizontal col-md-12 pl-lg-3 pr-lg-3 pt-2" method="post" name="form1" id="form1" onsubmit="return validate_product_info()">
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
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputName" class="col-form-label">Type<span class="tej-required"> *</span></label>
								<select name="product_type" id="product_type" class="form-control" required="required">
									<option value="">-- Choose Type --</option>
									<option value="Product">Product</option>
									<option value="Services">Services</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="inputName" class="col-form-label">Product/Services Name<span class="tej-required"> *</span></label>
								<input name="product_title" type="text" id="product_title" class="form-control" required="required">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputlink" class="col-form-label">Link<span class="tej-required"> *</span></label>
								<input name="product_link" type="text" id="product_link" class="form-control" required>
								<span class="e-name">http://www.example.com</span>
							</div>
							<div class="form-group col-md-6">
								<label for="inputilink" class="col-form-label">Image Link</label>
								<input name="product_image" type="text" id="product_image" class="form-control">
								<span class="e-name">http://www.example.com</span>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inpuvtlink" class="col-form-label">Video Link</label>
								<input name="product_video_link" type="text" id="product_video_link" class="form-control">
								<span class="e-name">e.g. http://www.youtube.com/watch?v=Uiz7pfuCayM; http://www.youtube.com/watch?v=6wyZojTIlu4 you can enter multiple links eparated by semicolon [ ; ]</span>
							</div>
							<div class="form-group col-md-6">
								<label for="inputKeywords" class="col-form-label">Keywords</label>
								<input name="product_keywords" id="product_keywords" class="form-control">
								<span class="e-name">you can enter 10 keyword eparated by semicolon [ ; ]</span>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="inputDescription" class="col-form-label">Description<span class="tej-required"> *</span></label>
								<textarea class="form-control" name="product_details" id="product_details" rows="5" required></textarea>
							</div>
						</div>
    					<div class="form-group row justify-content-center">
    						<button type="submit" class="btn btn-info btn-md">Save Changes</button>
    					</div>
					</form>
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</section>
<script type="text/javascript">
    function validate_product_info()
    {
    	if(document.getElementById("product_type").value == "")
    	{
    		alert("Please select type.");
    		document.getElementById("product_type").focus();
    		return false;
    		
    	}
    	if(document.getElementById("product_title").value == "")
    	{
    		alert("Please Enter Product Title");
    		document.getElementById("product_title").focus();
    		return false;
    		
    	}
    	if(document.getElementById("product_link").value == "")
    	{
    		alert("Please Enter Product Link");
    		document.getElementById("product_link").focus();
    		return false;
    		
    	}
    	/*if(document.getElementById("product_image").value == "")
    	{
    		alert("Please Enter Product Image");
    		document.getElementById("product_image").focus();
    		return false;
    		
    	}*/
    	var prod_dtails = tinyMCE.get("product_details").getContent();
    //alert(prod_dtails);
    
    	if(prod_dtails == "")
    	{
    		alert("Please Enter Product Details");
    		document.getElementById("product_details").focus();
    		return false;
    		
    	}
    	document.prod_form.submit();
    	return true;
    	
    	
    }
</script>