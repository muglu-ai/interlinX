<!-- Content Header (Page header) -->

<section class="content-header">

	<div class="container">

		<div class="row mb-2">

			<div class="col-sm-6">

				<h1>Sent Message(s)</h1>

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

        											<a href="<?php echo base_url('messages/read/' . $row['msg_id'] . '/tej');?>" class="font-indigo">

        												<?php echo $row['receiver_title']." ".$row['receiver_fname']." ".$row['receiver_lname']; ?>

        											</a>

        										</td>

        										<td class="mailbox-subject" width="53%">

        											<a href="<?php echo base_url('messages/read/' . $row['msg_id'] . '/tej');?>" class="font-indigo">

            											<?php echo $row['msg_subject']; ?>

            										</a>

        										</td>

        										<td class="mailbox-date" width="22%">

        											<a href="<?php echo base_url('messages/read/' . $row['msg_id'] . '/tej');?>" class="font-indigo">

            											<?php echo date('h:i A', strtotime($row['msg_time']))."  | ".$row['msg_date']; ?>

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