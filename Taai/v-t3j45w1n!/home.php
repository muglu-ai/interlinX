<section class="content pt-4">

	<div class="container">

		<div class="row">

			<div class="col-12">

				<!-- /.card -->

				<div class="card">

					<div class="card-body">

						<div class="col-12">

							<div class="row">

								<div class="col-md-2 bg-olive p-2 text-center font-weight-bold">Announcements</div>

								<div class="col-md-10 p-2 mar bg-light">

									<marquee direction="left" behavior="scroll" scrollamount="4" class="a-main1">

										Welcome to <?php echo PROJECT_TITLE; ?> B2B Partnering Tool | Over 100+ meetings scheduled already! Don't delay, our tables are filling up quickly. | Opportunity knocking! Book your B2B meetings NOW and accelerate your business growth! Time's ticking & tables are filling up rapidly!

									</marquee>

								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- /.card -->

			</div>

			<!-- /.col -->

		</div>

		<div class="col-12 p-3 bg-white mb-3">

			<div class="row">

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-purple-seance-opacity">

						<div class="inner pt-3 pb-3">

							<h1 style="color:#f2f2f2;"><?php echo count($totalRegistration); ?></h1>

							<h5 style="color:#f2f2f2;">Latest Registrations</h5>

						</div>

						<div class="icon">

							<i class="ion ion-person-add"></i>

						</div>

						<a href="<?php echo base_url('latest-registration'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-blue-dark">

						<div class="inner pt-3 pb-3">

							<h1><?php echo count($shortlistPartners); ?></h1>

							<h5 style="color:#f2f2f2;">Shortlisted Partners</h5>

						</div>

						<div class="icon">

							<i class="ion ion-person-add"></i>

						</div>

						<a href="<?php echo base_url('shortlisted-partners'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<!-- ./col -->

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-success">

						<div class="inner pt-3 pb-3">

							<h1><?php echo count($matchedList); ?></h1>

							<h5 style="color:#f2f2f2;">Your Matched</h5>

						</div>

						<div class="icon">

							<i class="ion ion-person-add"></i>

						</div>

						<a href="<?php echo base_url('your-matched'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<!-- ./col -->

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-info">

						<div class="inner pt-3 pb-3">

							<h1><?php echo $acceptedMeetings; ?></h1>

							<h5 style="color:#f2f2f2;">Accepted Meetings</h5>

						</div>

						<div class="icon">

							<i class="ion ion-email"></i>

						</div>

						<a href="<?php echo base_url('accepted-meetings'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<!-- ./col -->

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-yellow-gold">

						<div class="inner pt-3">

							<h1><?php echo count($sentMeetingList); ?></h1>

							<h5 style="color:#f2f2f2;">Sent Meetings</h5>

						</div>

						<div class="icon">

							<i class="ion ion-email"></i>

						</div>

						<a href="<?php echo base_url('sent-meeting-request'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<!-- ./col -->

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-red-intense">

						<div class="inner pt-3">

							<h1><?php echo count($pendingMeetingsList); ?></h1>

							<h5 style="color:#f2f2f2;">Received Meetings</h5>

						</div>

						<div class="icon">

							<i class="ion ion-email-unread"></i>

						</div>

						<a href="<?php echo base_url('received-meeting-request'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

				<div class="col-lg-4 col-6">

					<!-- small box -->

					<div class="small-box bg-purple-soft">

						<div class="inner pt-3">

							<h1><?php echo count($messagesReceivedList); ?></h1>

							<h5 style="color:#f2f2f2;">Received Messages</h5>

						</div>

						<div class="icon">

							<i class="ion ion-email-unread"></i>

						</div>

						<a href="<?php echo base_url('messages/inbox'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

					</div>

				</div>

			</div>

			<!-- ./col -->

		</div>

		<!-- /.row -->

		<!-- shortlisted partner table -->

		<div class="row">

			<?php if (!empty($shortlistPartners)) { ?>

				<div class="col-md-12 col-sm-12 col-xs-12 mb-3">

					<!-- /.card -->

					<div class="card">

						<div class="card-header bg-blue-dark">

							<div class="float-left">

								<h3 class="card-title">Shortlisted Partners</h3>

							</div>

							<div class="card-tools">

								<button type="button" class="btn btn-tool" data-card-widget="collapse">

									<i class="fas fa-minus"></i>

								</button>

								<h3 class="card-title a-main"><a href="<?php echo base_url('shortlisted-partners'); ?>">View all <i class="far fa-eye fa-spin"></i></a></h3>

							</div>

						</div>

						<div class="card-body bg-light">

							<div class="row">

								<!-- /.col -->

								<?php $i = 1;

								foreach ($shortlistPartners as $shortlistPartner) {

									if ($i > 8) {

										break;

									} ?>

									<div class="col-md-3">

										<!-- Widget: user widget style 1 -->

										<div class="card card-widget widget-user">

											<!-- Add the bg color to the header using any of the bg-* classes -->

											<div class="widget-user-header bg-info">

											</div>

											<div class="widget-user-image">

												<?php if (file_exists($shortlistPartner['photo'])) { ?>

													<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url($shortlistPartner['photo']); ?>" />

												<?php } else { ?>

													<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url('uploads/default_file.jpg'); ?>" />

												<?php } ?>

											</div>

											<div class="card-footer text-center">

												<div class="col-md-12">

													<h3 class="widget-user-username"><a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']); ?>" target="_blank"><?php echo $shortlistPartner['title'] . ' ' . $shortlistPartner['fname'] . ' ' . $shortlistPartner['lname']; ?></a></h3>

													<h5 class="widget-user-desc two-lines tej-desig"><?php echo $shortlistPartner['desig']; ?></h5>

													<p class="two-lines tej-org"><?php echo $shortlistPartner['org_name']; ?></p>

												</div>

												<div class="clearfix border-top border-bottom bg-light pt-2 pb-2 ">

													<div class="row">

														<div class="col-lg-12 m-0">

															<a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']); ?>" target="_blank" class="btn btn-block btn-info btn-md">View More</a>

														</div>

													</div>

												</div>

												<!-- /.row -->

											</div>

										</div>

										<!-- /.widget-user -->

									</div>

								<?php $i++;

								} ?>

							</div>

						</div>

					</div>

				</div>

			<?php } ?>

			<!-- Your Matched table -->

			<div class="col-md-12 col-sm-12 col-xs-12">

				<!-- /.card -->

				<div class="card">

					<div class="card-header bg-success">

						<div class="float-left">

							<h3 class="card-title">Your Matched</h3>

						</div>

						<div class="card-tools">

							<button type="button" class="btn btn-tool" data-card-widget="collapse">

								<i class="fas fa-minus"></i>

							</button>

							<h3 class="card-title a-main"><a href="<?php echo base_url('your-matched'); ?>">View all <i class="far fa-eye fa-spin"></i></a></h3>

						</div>

					</div>

					<div class="card-body bg-light">

						<div class="row">

							<?php $i = 1;

							foreach ($matchedList as $shortlistPartner) {

								if ($i > 8) {

									break;

								} ?>

								<div class="col-md-3">

									<!-- Widget: user widget style 1 -->

									<div class="card card-widget widget-user">

										<!-- Add the bg color to the header using any of the bg-* classes -->

										<div class="widget-user-header bg-info">

										</div>

										<div class="widget-user-image">

											<?php if (file_exists($shortlistPartner['photo'])) { ?>

												<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url($shortlistPartner['photo']); ?>" />

											<?php } else { ?>

												<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url('uploads/default_file.jpg'); ?>" />

											<?php } ?>

										</div>

										<div class="card-footer text-center">

											<div class="col-md-12">

												<h3 class="widget-user-username"><a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']); ?>" target="_blank"><?php echo $shortlistPartner['title'] . ' ' . $shortlistPartner['fname'] . ' ' . $shortlistPartner['lname']; ?></a></h3>

												<h5 class="widget-user-desc two-lines tej-desig"><?php echo $shortlistPartner['desig']; ?></h5>

												<p class="two-lines tej-org"><?php echo $shortlistPartner['org_name']; ?></p>

											</div>

											<div class="clearfix border-top border-bottom bg-light pt-2 pb-2 ">

												<div class="row">

													<div class="col-lg-12 m-0">

														<a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']); ?>" target="_blank" class="btn btn-block btn-info btn-md">View More</a>

													</div>

												</div>

											</div>

											<!-- /.row -->

										</div>

									</div>

									<!-- /.widget-user -->

								</div>

							<?php $i++;

							} ?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

	<!-- /.container-fluid -->

</section>

<script src="<?php echo base_url('assets/js/jquery.ellipsis.js'); ?>"></script>

<script>

	$('.two-lines').ellipsis({

		lines: 2,

		responsive: true

	});

</script>