<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Shortlisted Partners</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<!-- /.card -->
				<div class="card">
					<div class="card-body bg-light">
						<div class="row">
							<!-- /.col -->
							<?php foreach ($shortlistPartners as $shortlistPartner) {?>
    							<div class="col-md-3">
    								<!-- Widget: user widget style 1 -->
    								<div class="card card-widget widget-user">
    									<!-- Add the bg color to the header using any of the bg-* classes -->
    									<div class="widget-user-header bg-info">
    									</div>
    									<div class="widget-user-image">
											<?php if(file_exists($shortlistPartner['photo'])) {?>
												<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url($shortlistPartner['photo']);?>" />
											<?php } else {?>
												<img class=" img-circle elevation-2 img-fluid" src="<?php echo base_url('uploads/default_file.jpg');?>" />
											<?php }?>
    									</div>
    									<div class="card-footer text-center">
    										<div class="col-md-12">
    											<h3 class="widget-user-username"><a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']);?>" target="_blank"><?php echo $shortlistPartner['title'] . ' ' . $shortlistPartner['fname'] . ' ' . $shortlistPartner['lname'];?></a></h3>
        											<h5 class="widget-user-desc two-lines tej-desig"><?php echo $shortlistPartner['desig'];?></h5>
        											<p class="two-lines tej-org"><?php echo $shortlistPartner['org_name'];?></p>
    										</div>
    										<div class="clearfix border-top border-bottom bg-light pt-2 pb-2 ">
    											<div class="row">
    												<div class="col-lg-12 m-0">
    													<a href="<?php echo base_url('delegate-personal-detail/' . $shortlistPartner['user_id']);?>" target="_blank" class="btn btn-block btn-info btn-md">View More</a>
    												</div>
    											</div>
    										</div>
    										<!-- /.row -->
    									</div>
    								</div>
    								<!-- /.widget-user -->
    							</div>
    						<?php }?>
						</div>
					</div>
				</div>
			</div>
    		<?php if(!empty($pagination)) {?>
    			<div class="col-12">
    				<div class="card">
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
    			</div>
    		<?php }?>
		</div>
		<!-- /.container-fluid -->
	</div>
</section>
 <!-- /.content -->
 
<script src="<?php echo base_url('assets/js/jquery.ellipsis.js');?>"></script>
<script>
	$('.two-lines').ellipsis({ lines: 2, responsive: true });
</script>