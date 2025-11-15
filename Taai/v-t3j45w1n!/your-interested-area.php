<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css');?>"/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>I am Looking For</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline">
					<form class="form-horizontal col-md-12 pl-lg-5 pr-lg-5 pt-2" method="post" action="<?php echo base_url('looking-for');?>">
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
						<div class="card-body align-self-center col-md-12">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="inputArea" class="font-weight-bold">Specify Your Interested Area</label>
									<input type="text" name="my_keywords" id="my_keywords" class="form-control" value="<?php echo $my_keywords;?>" required="required">
									<small>you can enter multiple keywords seperated by semicolon [ ; ]</small>
								</div>
							</div>
						</div>
						<div class="form-group row justify-content-center">
							<button type="submit" class="btn btn-info btn-md">Save Changes</button>
						</div>
					</form>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</div>
</section>
<!-- /.content -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/tags-input.js');?>"></script>
<script type="text/javascript">
$(function() {
	$('#my_keywords').tagsInput({
		'placeholder': 'Add keywords'
	});
});
</script>