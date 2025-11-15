<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Received Message(s)</h1>

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

			<div class="col-md-9">

				<div class="card card-primary card-outline">

					<!-- /.card-header -->

					<div class="card-body pt-4 pb-4">

						<div class="table-responsive mailbox-messages">

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

							<table class="table table-hover table-striped1">

								<tbody>

									<?php if(!empty($messagesList)) {?>

										<?php foreach ($messagesList as $row) {?>

        									<tr>

        										<td class="mailbox-name" width="25%">

        											<a href="<?php echo base_url('delegate-personal-detail/' . $row['sender_id']);?>" class="font-indigo">

        												<?php if($row['read_flag'] == "False" || empty($row['read_flag'])) {?>

	        												<strong><?php echo $row['sender_title']." ".$row['sender_fname']." ".$row['sender_lname']; ?></strong>

	        											<?php } else {?>

	        												<?php echo $row['sender_title']." ".$row['sender_fname']." ".$row['sender_lname']; ?>

	        											<?php }?>

        											</a>

        										</td>

        										<td class="mailbox-subject pb-0" width="53%">

        											<div class="in2 pb-0">

            											<a href="<?php echo base_url('messages/read/' . $row['msg_id']);?>" class="font-indigo" title="<?php echo $row['msg_subject']; ?>">

                											<?php if($row['read_flag'] == "False" || empty($row['read_flag'])) {?>

                												<strong><?php echo $row['msg_subject']; ?></strong>

                											<?php } else {?>

                												<?php echo $row['msg_subject']; ?>

                											<?php }?>

                										</a>

                									</div>

        										</td>

        										<td class="mailbox-date" width="22%">

        											<a href="<?php echo base_url('messages/read/' . $row['msg_id']);?>" class="font-indigo">

            											<?php if($row['read_flag'] == "False" || empty($row['read_flag'])) {?>

            												<strong style="font-size: 15px;"><?php echo date('h:i A', strtotime($row['msg_time']))."  | ".$row['msg_date']; ?></strong>

            											<?php } else {?>

            												<?php echo date('h:i A', strtotime($row['msg_time']))."  | ".$row['msg_date']; ?>

            											<?php }?>

            										</a>

        										</td>

        									</tr>

        								<?php }?>

        							<?php } else {?>

    									<tr>

    										<td colspan="3">

    											<div class="alert alert-info">No message yet...</div>

    										</td>

    									</tr>

    								<?php }?>

								</tbody>

							</table>

							<!-- /.table -->

						</div>

						<!-- /.mail-box-messages -->

					</div>

					<!-- /.card-body -->

					<?php if(!empty($pagination)) {?>

    					<div class="card-footer p-0">

    						<div class="mailbox-controls">

    							<div class="float-right">

    								<nav aria-label="...">

    									<?php echo $pagination;?>

    								</nav>

    								<!-- /.btn-group -->

    							</div>

    							<!-- /.float-right -->

    						</div>

    					</div>

    				<?php }?>

				</div>

				<!-- /.card -->

			</div>

			<!-- /.col -->

		</div>

		<!-- /.row -->

	</div>

</section>

<!-- /.content -->

<script language="javascript">



</script>