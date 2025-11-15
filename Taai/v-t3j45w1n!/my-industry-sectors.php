<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>My Industry Sector</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
    	<div class="row">
    		<div class="col-12">
    			<form action="<?php echo base_url('my-industry-sectors');?>" method="post" name="form1" id="form1" onsubmit="return validate_step_comm_2()">
        			<div class="card card-primary card-outline">
        				<!-- /.card-header -->
        				<div class="card-body col-md-12">
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
        						<?php $ind_sec_count = 1; foreach ($industry_sector_list as $industry_sector) {
									if($industry_sector['comm_name'] == 'Top management') { continue;}?>
            						<div class="col-md-3 col-sm-3 col-xs-6">
    									<label>
    										<input type="checkbox" name="intr[]" id="intr<?php echo $ind_sec_count;?>" value="<?php echo $industry_sector['comm_name'];?>" class="mr-2 mt-3" <?php if(isset($my_industries['tej_' . $industry_sector['comm_name']])) { echo 'checked="checked"';  }?>>
    										<?php echo $industry_sector['comm_name'];?>
    									</label> 
        							</div>
        						<?php $ind_sec_count++;}
								
								$data = explode('#', $resmy_industries);
								$other = '';
								if(isset($data[1])) {
									$other = str_replace('Other-', '', $data[1]);
								}
								?>
        						<div class="col-md-3 col-sm-3">
    								<label><input type="checkbox" name="intr<?php echo $ind_sec_count;?>" id="intr40" value="OTHER" class="mr-2 mt-3"  <?php if(!empty($other)) { echo 'checked="checked"';  }?>>Other</label> 
    								<div class="col-md-12" id="specify_other_div">
    									<input type="text" id="specify_other" name="specify_other" value="<?php echo $other;?>" class="form-control">
    								</div>
    							</div>
        					</div>
    					</div>
    					<div class="form-group text-md-center">
    						<div class="col-md-12">
    							<button type="submit" class="btn btn-info btn-sm">Save Changes</button>
    						</div>
    					</div>
        			</div>
    			    <!-- /.card-body -->
				</form>
    		</div>
    		<!-- /.card -->
    	</div>
    	<!-- /.col -->
	</div>
</section>

<script>
	$(function() {
    	// Get the form fields and hidden div
    	var checkbox = $("#intr40");
    	var hidden = $("#specify_other_div");
    	
    	<?php if(!empty($other)){ ?>
    		hidden.show();
    	<?php } else{?>
    		hidden.hide();
    	<?php }?>
    	
    	checkbox.change(function() {
        	if (checkbox.is(':checked')) {
            	// Show the hidden fields.
            	hidden.show();
        	} else {
        		hidden.hide();
        		//$("#hidden_field").val("");
        	}
    	});
	});
</script>
		
<script type="text/javascript">
    function validate_step_comm_2()
	{
		//alert('test');
		var cnt_nt_sele_assoc=0;
	 	var cnt_assoc;
		for(cnt_assoc=1;cnt_assoc<=<?php echo count($industry_sector_list);?>;cnt_assoc++)
		{
			if(document.getElementById("intr"+cnt_assoc).checked == false)
			{
				cnt_nt_sele_assoc++;
			}	
		}
			
		if((cnt_nt_sele_assoc >= <?php echo count($industry_sector_list);?>) && (document.getElementById("intr40").checked == false))
		{		
			alert("Please Select Atleast One Industry Sector");
			return false;
		}
		/* if(document.getElementById("intr40").checked == true)
		{
			if(document.getElementById("specify_other").value == "")
			{
				alert("Please Enter Other Industry Sector Name");
				document.getElementById("specify_other").focus();
				return false;
			}
		} */
		
		//document.form1.submit();
		return true;
	}	
</script>