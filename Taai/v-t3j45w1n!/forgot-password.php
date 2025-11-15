<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Interlinx B2B portal</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css');?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo base_url('assets/theme/css/adminlte.min.css');?>">
		<!-- colors style -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/color.css');?>">
		<!-- custom style -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/custom-style.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
		<?php /* <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">*/?>
	</head>
	<body class="layout-top-nav">
		<div class="wrapper">
			<!-- header -->
			<div class="container">
				<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-white p-md-3 p-sm-0 d-head">
					<ul class="navbar-nav">
						<li><a href="<?php echo EVENT_WEBSITE;?>" target="_blank"><img src="<?php echo base_url(PROJECT_LOGO);?>" width="120" class="img-fluid"></a></li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li>
							<a href="<?php echo EVENT_WEBSITE;?>" target="_blank"><img src="<?php echo base_url(INTERLINX_LOGO_LINK);?>" width="160" class="img-fluid"></a>
						</li>
					</ul>
				</nav>
			</div>
			<div  class="content-wrapper login-page pt-sm-3">
				<div class="login-box rounded">
					<!-- /.login-logo -->
					<div class="card card-primary ">
						<div class="card-header text-center h5 bg-blue-chambray p-2">
							<span class="l_head1 h6">Welcome to</span><br />
							<span class="l_head"><?php echo PROJECT_TITLE . ' ' . EVENT_YEAR; ?></span><br />
							Partnering tool - InterlinX
						</div>
						<div class="card-body">
							<p class="login-box-msg h5"><strong>Forgot Password</strong></p>
							<form action="<?php echo base_url('forgot-password');?>" method="post" name="formData">
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
								<div class="input-group mb-3">
									<input type="email" name="formData[email]" class="form-control" placeholder="Email">
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-envelope"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<!-- /.col -->
									<div class="col-12">
										<button type="submit" class="btn btn-primary btn-block">Submit</button>
									</div>
									<!-- /.col -->
								</div>
							</form>
							<p class="mb-1 mt-2">
								<a href="<?php echo base_url();?>">Login</a> | <a href="<?php echo EVENT_INTERLINX_REG_LINK;?>" target="_blank">Register</a>
							</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.login-box -->
			</div>
			<!-- /.content-wrapper -->
		</div>
		<!-- ./wrapper -->
        <footer class="main-footer text-center">
  			<strong>Copyright &copy; <?php echo date('Y');?> <a href="https://www.mmactiv.in" target="_blank">MMACTIV PVT. LTD.</a></strong>
 				 All rights reserved.
  			<div class="float-right d-none d-sm-inline-block"></div>
		</footer>
		<!-- jQuery -->
		<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<?php /*<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>*/?>
	</body>
</html>