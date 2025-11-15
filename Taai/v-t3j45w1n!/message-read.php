<link href="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.css')?>" rel="stylesheet">

<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Message Detail</h1>

			</div>

		</div>

	</div>

	<!-- /.container-fluid -->

</section>

<!-- Main content -->

<section class="content">

	<div class="container">

		<div class="row">

			<?php $this->load->view('message-leftside');?>

			<!-- /.col -->

			<div class="col-md-9">

				<div class="card card-primary card-outline">

					<!-- /.card-header -->

					<div class="card-body p-2">

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

						<div class="mailbox-read-info">

							<span class="mailbox-date float-right"><?php echo date('h:i A', strtotime($messagesDetail['msg_time']))."  | ".$messagesDetail['msg_date']; ?></span>

							<p><span class="font-weight-bold">Name:</span> <?php echo $messagesDetail['sender_title']." ".$messagesDetail['sender_fname']." ".$messagesDetail['sender_lname']; ?> </p>

							<hr>

							<p><span class="font-weight-bold">Subject:</span> <?php echo $messagesDetail['msg_subject'];?> </p>

						</div>

						<div class="mailbox-read-message">

							<p><span class="font-weight-bold">Message:</span></p>

							<?php echo nl2br($messagesDetail['msg']);?>

							<hr>

						</div>

						<!-- /.mailbox-read-message -->

					</div>

					<!-- /.card-body -->

					<!-- /.card-footer -->

					<div class="card-footer pt-1">

						<?php if(empty($param)) {?>

    						<div class="float-right">

    							<a class="btn btn-info btn-sm" type="button"  data-toggle="modal" data-target="#modal-lg">

    							<i class="fas fa-reply"></i> Reply</a>

    						</div>

							<a href="<?php echo base_url('messages/inbox/delete/' . $messagesDetail['msg_id']);?>" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>

						<?php } else {?>

							<a href="<?php echo base_url('messages/sent/delete/' . $messagesDetail['msg_id']);?>" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>

						<?php }?>

					</div>

					<!-- /.card-footer -->

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

<?php if(empty($param)) {?>

    <div class="modal fade" id="modal-lg">

        <div class="modal-dialog modal-lg">

        	<div class="modal-content">

        		<div class="modal-header bg-info">

        			<h4 class="modal-title">Send Reply</h4>

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

        						<form action="<?php echo base_url('messages/send-reply');?>" method="post" name="form1" id="form1" onsubmit="return val_reply_msg()">

        							<input name="temp_msg_id" id="temp_msg_id" type="hidden" value="<?php echo $messagesDetail['msg_id'];?>"  />

            						<!-- /.card-header -->

            						<div class="card-body">

            							<div class="mailbox-read-info">

            								<span class="mailbox-date float-right"><?php echo date('h:i A', strtotime($messagesDetail['msg_time']))."  | ".$messagesDetail['msg_date']; ?></span>

            								<p><span class="font-weight-bold">Name:</span> <?php echo $messagesDetail['sender_title']." ".$messagesDetail['sender_fname']." ".$messagesDetail['sender_lname']; ?></p>

            								<hr>

            								<p><span class="font-weight-bold">Subject:</span> <?php echo $messagesDetail['msg_subject'];?></p>

            							</div>

            							<div class="form-group">

            								<textarea id="reply_msg_txt" name="reply_msg_txt" class="form-control"></textarea>

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

    

    <script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js');?>"></script>

    <script type="text/javascript">

    $(document).ready(function() {

     	$('#reply_msg_txt').summernote({

            //tabsize: 2,

            height: 120,

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

    

    function val_reply_msg() {

    	if(document.getElementById("reply_msg_txt").value == "")

    	{

    		alert("Please Enter Message");

    		document.getElementById("reply_msg_txt").focus();

    		return false;

    		

    	}

    	return true;

    }

    </script>

<?php }?>   