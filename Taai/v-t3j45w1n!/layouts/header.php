<div class="d-head">
	<div class="col-md-12">
		<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-white p-md-3">
			<ul class="navbar-nav">
				<li><img src="<?php echo base_url(PROJECT_LOGO);?>" width="125" class="img-fluid"></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li>
					<img src="<?php echo base_url(INTERLINX_LOGO_LINK);?>" width="120" class="img-fluid">
				</li>
			</ul>
		</nav>
	</div>
</div>
<nav class="main-header navbar navbar-expand navbar-white navbar-dark bg-dark n-back">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item d-sm-block d-lg-none">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-md-inline-block">
			<a href="<?php echo base_url('home');?>" class="nav-link">Home</a>
		</li>
		<li class="nav-item dropdown d-none d-md-inline-block">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Profile</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li><a href="<?php echo base_url('personal-detail');?>" class="dropdown-item">View self profile</a></li>
				<li><a href="<?php echo base_url('personal-detail/update');?>" class="dropdown-item">Edit Profile</a></li>
				<li><a href="<?php echo base_url('my-industry-sectors');?>" class="dropdown-item">My Industry Sectors</a></li>
			</ul>
		</li>
		<li class="nav-item dropdown d-none d-md-inline-block">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Messages</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li><a href="<?php echo base_url('messages/inbox');?>" class="dropdown-item">Inbox <span class="badge badge-danger navbar-badge tej-mesp" style="top: 15px;font-size: 15px;"><span class="tej-msg-count float-right"></span></span></a></li>
				<li><a href="<?php echo base_url('messages/sent');?>" class="dropdown-item">Sent</a></li>
				<li><a href="<?php echo base_url('messages/compose');?>" class="dropdown-item">Compose</a></li>
			</ul>
		</li>
		<li class="nav-item dropdown d-none d-md-inline-block">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">My Product/Services</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li><a href="<?php echo base_url('product-services/add');?>" class="dropdown-item">Product add</a></li>
				<li><a href="<?php echo base_url('product-services/list');?>" class="dropdown-item">Product view</a></li>
			</ul>
		</li>
		<li class="nav-item dropdown d-none d-md-inline-block">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Looking for</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li><a href="<?php echo base_url('industry-sectors');?>" class="dropdown-item">Looking for Industry Sectors</a></li>
				<li><a href="<?php echo base_url('looking-for');?>" class="dropdown-item">I am looking For</a></li>
			</ul>
		</li>
		<li class="nav-item dropdown d-none d-md-inline-block">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Schedule</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li><a href="<?php echo base_url('my-calendar');?>" class="dropdown-item">My Calender</a></li>
				<li><a href="<?php echo base_url('sent-meeting-request');?>" class="dropdown-item">Sent Request</a></li>
				<li><a href="<?php echo base_url('received-meeting-request');?>" class="dropdown-item">Received Request&emsp;<span class="badge badge-danger navbar-badge tej-reqp" style="top: 78px;font-size: 15px;"><span class="tej-meet-count float-right tej-req"></span></span></a></li>
				<li><a href="<?php echo base_url('edit-my-calendar');?>" class="dropdown-item">Edit My Schedule</a></li>
				<li><a href="<?php echo base_url('export');?>" class="dropdown-item">Export Schedule</a></li>
			</ul>
		</li>
	</ul>
	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Navbar Search -->
		<li class="nav-item">
			<a class="nav-link" data-widget="navbar-search" href="#" role="button">
			<i class="fas fa-search"></i>
			</a>
			<div class="navbar-search-block col-sm-12 offset-md-6 col-md-6 float-right">
				<form class="form-inline" action="<?php echo base_url('search-redirect');?>" method="get" id="tej-search">
					<input type="hidden" id="type" name="type" value="default"/>
					<div class="input-group input-group-sm">
						<input class="form-control form-control-navbar search-a col-md-12" name="search" id="search" type="search" placeholder="Search here..." aria-label="Search" data-toggle="dropdown" required="required" autocomplete="off">
						<div class="input-group-append">
							<button class="btn btn-navbar search-a" type="button" data-toggle="dropdown">
							<i class="fas fa-angle-down"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu">
								<a class="dropdown-item tej-cursor" onclick="chnageValue('name');">Search By Name</a>
								<a class="dropdown-item tej-cursor" onclick="chnageValue('industry');">Search By Industry Sector</a>
								<a class="dropdown-item tej-cursor" onclick="chnageValue('org');">Search By Organisation</a>
								<a class="dropdown-item tej-cursor" onclick="chnageValue('country');">Search By Country</a>
								<a class="dropdown-item tej-cursor" onclick="chnageValue('keywords');">Search By Keywords</a>
								<a class="dropdown-item tej-cursor" onclick="chnageValue('turn');">Search By Turn Over</a>
							</div>
							<button class="btn btn-navbar search-a" type="submit">
								<i class="fas fa-search"></i>
							</button>
							<button class="btn btn-navbar search-a" type="button" data-widget="navbar-search">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</li>
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="far fa-bell"></i>
			<span class="badge badge-danger navbar-badge" style="top: 2px; font-size: 12px;"><span class="tej-total-count"></span></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header"><span class="tej-total-count"></span> Notifications</span>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url('messages/inbox');?>" class="dropdown-item">
				<i class="fas fa-envelope mr-2"></i><span class="tej-msg-count"></span> New Message(s)
				<span class="float-right text-muted text-sm">View</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url('received-meeting-request');?>" class="dropdown-item">
				<i class="fas fa-users mr-2"></i><span class="tej-meet-count"></span> New Meeting(s)
				<span class="float-right text-muted text-sm">View</span>
				</a>
			</div>
		</li>
		<!-- Notifications Dropdown Menu ends-->
		<!-- login Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="far fa-user"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="<?php echo base_url('personal-detail');?>" class="dropdown-item">Profile</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url('change-password');?>" class="dropdown-item">Change password</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url('logout');?>" class="dropdown-item">Logout</a>
			</div>
		</li>
		<!-- login Menu ends-->
	</ul>
</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 n-back">
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<!-- Sidebar user panel start -->
			<div class="mt-3 pb-3 mb-3 text-center" >
				<div class="image">
					<img src="<?php echo base_url($this->userauth->get_userdata('photo')); ?>" class="img-circle elevation-2" width="60">
				</div>
				<div class="info mt-2">
					<h6 class="d-block text-white"><?php echo $this->userauth->get_userdata('title') . ' ' . $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname'); ?></h6>
				</div>
			</div>
			<!-- Sidebar user panel ends -->
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo base_url('home');?>" class="nav-link">
						<i class="nav-icon fas fa-home"></i>
						<p>
							Home
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-comments"></i>
						<p>
							Profile
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('personal-detail');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>View self profile</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('personal-detail/update');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Edit Profile</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('my-industry-sectors');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>My Industry Sectors</p>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-comments"></i>
						<p>
							Messages
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('messages/inbox');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Inbox</p>
								<span class="badge badge-danger navbar-badge tej-mesp" style="top: 8px;font-size: 15px;"><span class="tej-msg-count float-right"></span></span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('messages/sent');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Sent</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('messages/compose');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Compose</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-industry"></i>
						<p>
							My Product/Services
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('product-services/add');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Product add</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('product-services/list');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Product view</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-industry"></i>
						<p>
							Looking for
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('industry-sectors');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Looking for Industry Sectors</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('looking-for');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p> I am looking For</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-calendar"></i>
						<p>
							Schedule
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('my-calendar');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>My Calender</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('sent-meeting-request');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Sent Request</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('received-meeting-request');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Received Request</p>
								<span class="badge badge-danger navbar-badge tej-reqp" style="top: 8px;font-size: 15px;"><span class="tej-meet-count float-right"></span></span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('edit-my-calendar');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Edit My Schedule</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('export');?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Export Schedule</p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>



<?php /*if($this->userauth->is_user_logged_in()) {?>
<div class="sub-header-mobile-2 d-block d-lg-none">
	<div class="header__tool">
		<div class="account-wrap">
			<div class="account-item account-item--style2 clearfix js-item-menu">
				<div class="image">
					<img src="<?php echo base_url($this->userauth->get_userdata('photo')); ?>" alt="<?php //echo $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname'); ?>" />
				</div>
				<div class="content">
					<a class="js-acc-btn" href="#"><?php echo $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname'); ?></a>
				</div>
				<div class="account-dropdown js-dropdown">
					<div class="info clearfix">
						<div class="image">
							<a href="#">
							<img src="<?php echo base_url($this->userauth->get_userdata('photo')); ?>" alt="<?php //echo $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname'); ?>" />
							</a>
						</div>
						<div class="content">
							<h5 class="name">
								<a href="#"><?php echo $this->userauth->get_userdata('fname') . ' ' . $this->userauth->get_userdata('lname'); ?></a>
							</h5>
							<span class="email"><?php echo $this->userauth->get_userdata('email'); ?></span>
						</div>
					</div>
					<div class="account-dropdown__body">
						<div class="account-dropdown__item">
							<a href="<?php echo base_url('change-password');?>">
							<i class="zmdi zmdi-key"></i>Change Password</a>
						</div>
					</div>
					<div class="account-dropdown__footer">
						<a href="<?php echo base_url('logout');?>">
						<i class="zmdi zmdi-power"></i>Logout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END HEADER MOBILE -->
<?php }*/?>