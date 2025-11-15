<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Product/Services</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body table-responsive p-0">
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
						<table class="table table-striped projects">
							<thead>
								<tr class="bg-secondary">
									<th style="width: 7%" class="pt-2 pb-2">Sr No</th>
									<th style="width: 10%;" class="pt-2 pb-2">Type</th>
									<th style="width: 30%;" class="pt-2 pb-2">Product/Services Name</th>
									<th style="width: 10%" class="text-center pt-2 pb-2">Image</th>
									<th style="width: 10%" class="text-center pt-2 pb-2">Link </th>
									<th style="width: 25%" class="text-center pt-2 pb-2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;foreach($product_list as $product) {?>
    								<tr>
    									<td><?php echo $i++;?></td>
    									<td><?php echo $product['product_type'];?></td>
    									<td><?php echo $product['product_title'];?></td>
    									<td class="pt-3 pb-3 text-center"><img src="<?php echo $product['product_image'];?>" width="60" class="border img-fluid"></td>
    									<td class="text-center">
    										<a class="btn btn-outline-primary btn-xs" href="<?php echo $product['product_link'];?>" target="_blank">
    										<i class="fas fa-eye"></i> View Link</a>
    									</td>
    									<td class="project-actions text-right">
    										<a class="btn btn-success btn-sm mb-2" type="button" data-toggle="modal" data-target="#modal-lg<?php echo $product['srno'];?>">
    										<i class="fas fa-eye"></i> View
    										</a>
    										<a class="btn btn-info btn-sm mb-2" href="<?php echo base_url('product-services/update/' . $product['srno']);?>">
    										<i class="fas fa-pencil-alt"></i> Edit
    										</a>
    										<a class="btn btn-danger btn-sm mb-2" href="<?php echo base_url('product-services/delete/' . $product['srno']);?>" >
    										<i class="fas fa-trash"></i> Delete
    										</a>
    									</td>
    								</tr>
    							<?php }?>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

<?php $i = 1;foreach($product_list as $product) {?>
    <div class="modal fade" id="modal-lg<?php echo $product['srno'];?>">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header bg-info">
    				<h4 class="modal-title">Product View</h4>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body">
    				<!-- Main content -->
    				<section class="content">
    					<div class="container">
    						<div class="row">
    							<div class="col-12">
    								<div class="card">
    									<!-- /.card-header -->
    									<div class="card-body">
    										<div class="table-responsive">
    											<table class="table table-borderless">
    												<tbody>
    													<tr>
    														<td width="22%" rowspan="7" class="text-center pt-3">
    															<?php if($product['product_image'])	{?>
    																<img src="<?php echo $product['product_image'];?>" class="img-fluid">
    															<?php }?>
    														</td>
    														<td width="25%" class="font-weight-bold w-one">Type</td>
    														<td width="2%">:</td>
    														<td width="30%" class="w-two"><?php echo $product['product_type'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold w-one">Name</td>
    														<td>:</td>
    														<td class="w-two"><?php echo $product['product_title'];?></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Product Link</td>
    														<td>:</td>
    														<td><a class="btn btn-outline-primary btn-xs" href="<?php echo $product['product_link'];?>" target="_blank">
    														<i class="fas fa-eye"></i> View Link</a></td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Product Video Link</td>
    														<td>:</td>
    														<td>
    															<?php 
    															     $temp_multi_video_link_array = explode(";",$product['product_video_link']);
                                									foreach($temp_multi_video_link_array as $temp_multi_video_link_array_val){
                                										echo "<a href='$temp_multi_video_link_array_val' target='_blank' class='gray_text_no_bold_ht_align'>$temp_multi_video_link_array_val</a><br />";
                                									}
                                									
                                									?>
    														</td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Product Keywords</td>
    														<td>:</td>
    														<td>
    															<?php 
                            									  $prod_key="";
                            									  for($i_key=1;$i_key<=10;$i_key++)
                            									  {
                            									      if($product['prod_key_'.$i_key])
                            										{
                            											if($prod_key)
                            											{
                            												$prod_key = $prod_key.";";
                            											}
                            											$prod_key = $prod_key.$product['prod_key_'.$i_key];
                            										}
                            									  }
                            									  echo $prod_key;
                            									  ?>
    														</td>
    													</tr>
    													<tr>
    														<td class="font-weight-bold">Product Description </td>
    														<td>:</td>
    														<td><?php echo $product['product_details'];?></td>
    													</tr>
    												</tbody>
    											</table>
    										</div>
    									</div>
    								</div>
    								<!-- /.card-body -->
    							</div>
    							<!-- /.card -->
    						</div>
    						<!-- /.col -->
    					</div>
    					<!-- /.row -->
    			</div>
    			<!-- /.container-fluid -->
    			</section>
    		</div>
    		<!-- /.modal-content -->
    	</div>
    	<!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php }?>