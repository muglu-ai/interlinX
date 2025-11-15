<div class="col-md-3">

    <a href="<?php echo base_url('messages/compose');?>" class="btn btn-primary1 btn-block mb-3 bg-maroon">Compose</a>

    <div class="card">

    	<?php /*<div class="card-header">

    		<h3 class="card-title">Folders</h3>

    		<div class="card-tools">

    			<button type="button" class="btn btn-tool" data-card-widget="collapse">

    			<i class="fas fa-minus"></i>

    			</button>

    		</div>

    	</div>*/?>

    	<div class="card-body p-0">

    		<ul class="nav nav-pills flex-column">

    			<li class="nav-item active">

    				<a href="<?php echo base_url('messages/inbox');?>" class="nav-link <?php if($submenu == 'inbox') {echo 'active';}?>">

    					<i class="fas fa-inbox"></i> Inbox <span class="badge bg-primary float-right tej-msg-count"></span>

    				</a>

    			</li>

    			<li class="nav-item">

    				<a href="<?php echo base_url('messages/sent');?>" class="nav-link <?php if($submenu == 'outbox') {echo 'active';}?>">

    					<i class="far fa-envelope"></i> Sent

    				</a>

    			</li>

    		</ul>

    	</div>

    	<!-- /.card-body -->

    </div>

    <!-- /.card -->

</div>

<!-- /.col -->