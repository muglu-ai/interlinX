<link href="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.css')?>" rel="stylesheet">

<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-12">

				<h1>Send Message</h1>

				<p><small>(Using Compose Message you can send messages to your InterlinX Collaborators only)</small></p>

			</div>

		</div>

	</div>

	<!-- /.container-fluid -->

</section>

<!-- /.col -->

<div class="container">

	<div class="card card-primary card-outline">

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

		<form id="compose_msg_form" name="compose_msg_form" method="post" action="<?php echo base_url('messages/compose');?>" onsubmit="return val_compose_msg_form()">

    		<!-- /.card-header -->

    		<div class="card-body">

    			<div class="form-group">

    				<label for="inputName" class="col-form-label">Select Name</label>

    				<select name="frnd_lst" id="frnd_lst" class="form-control">

    					<option value="">-- Select Name --</option>

    					<?php foreach ($friendsList as $res_frnds_temp) {?>

    						<option value="<?php echo $res_frnds_temp['frnd_id']; ?>"><?php echo $res_frnds_temp['frnd_title']. ' ' . $res_frnds_temp['frnd_fname']." ".$res_frnds_temp['frnd_lname']; ?> </option>

    					<?php }?>

    				</select>

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

    			<a href="<?php echo base_url('messages/inbox');?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Discard</a>

    		</div>

    		<!-- /.card-footer -->

    	</form>

	</div>

	<!-- /.card -->

</div>

<!-- /.col -->



<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>

    <script type="text/javascript">

    $(document).ready(function() {

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

    });

    

    function val_compose_msg_form()

    {		

    	if(document.getElementById("frnd_lst").value == "")

    	{

    	

    		alert("Please Select at least 1 Recepient");

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