<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to  banners ?>
<?php
	$userId=is_logged_in();
	
?>

<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">

<!--/DEMO TABLE CONTENT/-->	
<div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	<table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr role="row">
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 50px;">
					<?php echo lang('global:image'); ?>
					
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 280px;">
					<?php echo lang('affiliate:product'); ?>
					
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 120px;">
				<?php echo lang('affiliate:order_date'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 130px;">
				<?php echo lang('affiliate:order_price'); ?>
			</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 170px;">
				<?php echo lang('affiliate:referral_point'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 230px;">
				<?php echo lang('affiliate:payment_request'); ?>
			</th>
			</tr>
   
	</thead>
		<tbody >
		
	<?php if(isset($products) && !empty($products)): ?>
			<?php foreach($products as $product):?>
			<tr>
				
				<td>
					<?php 
						$bannerUrl=base_url().'affiliate/request/view/'.encode($product->payment_id);
						if($product->payment_status!=''){ $bannerUrl=base_url().'affiliate/payment/view/'.encode($product->request_id); }
					?>
					<?php $bannerImage= ($product->upload_type==0)?$product->image_url:base_url().$product->upload_path.$product->upload_image_name;?>
					<a href="<?php echo $bannerUrl; ?>"><img src="<?php echo $bannerImage; ?>" height="30" width="50"> </a>
				</td>
				
				<td><?php echo $product->banner_name;?></td>
				<td><?php echo date('d M Y',strtotime($product->order_time));?></td>
				<td><?php echo $product->amount.' '.$product->currency;?></td>
				
				<td><?php echo $product->referral_point;?></td>
				<?php 
				$diff =  strtotime(date('Y-m-d H:i:s'))-strtotime($product->order_time);
				$total_date_diff = round($diff/3600/24);
				?>
				<td>
				
					<?php if($product->payment_status==="0"){
						?>
						
						<button type="button" class="btn btn-default pending_btn" title="Request Pending!" data-toggle="tooltip" data-placement="left" name="button">Pending!!</button>

					<?php
					}
					else{
						if($total_date_diff>30)
						{
							$extra = "id='payment_request' class='btn payment_request'";
						}
						else
						{
							$extra = "class='btn btn-default' title='You can request for payment after 30 days of product purchase!'";
						}	
						?>
							<input type="hidden" class="request_data" value='<?php echo json_encode($product);?>'>
							
							<button type="button" <?php echo $extra;?> data-toggle="tooltip" data-placement="left" name="button">Payment Request</button>
					<?php } ?>
					<?php 
						if($product->payment_status==''){
							
						?>
								<a href="<?php echo base_url().'affiliate/request/view/'.encode($product->payment_id) ;?>" > 
									<button type="button" class="btn btn-default btn-success">
										<i class="fa fa-eye fa-fw fa-1x"></i>
									</button>
								</a>
						<?php
						}else{
					?>
							<a href="<?php echo base_url().'affiliate/payment/view/'.encode($product->request_id) ;?>" > 
								<button type="button" class="btn btn-default btn-success">
									<i class="fa fa-eye fa-fw fa-1x"></i>
								</button>
							</a>
					<?php } ?>
					</td>
			</tr>
	<?php endforeach;?>

		<?php else :  ?>	
		<tr><td colspan="6"><?php echo lang('global:no_record_found');?></td>	
		<?php endif; ?>	

		</tbody>
	</table>
	
	 <table class="border_none">
			<tr class="">
					<td colspan="6" class="border_none">
					<div class="col-md-6 ShowingEntries">	
						<div class="referral_point">
							<?php if(isset($config) && !empty($config)):
							
							echo "Note :".' 1 Referral Point ='.$config->referral_point_amt.' '.$config->currency.'.';
							?>
								
							<?php else: "Note : 1 Referral Point = 5 USD."?>
							<?php endif;?>
							
						</div>
						<div class="dataTables_info" id="example_info" role="status" aria-live="polite">  </div>
						</div>
						<div class="col-md-6 Paginations">
			
							<div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
													
						<?php if(isset($links)) : echo $links; endif; ?>								
						</div>
					</div>
					</td>
				</tr>
	</table>
	
	</div>
	</div>
	<div id="dialog-confirm"></div>
</div>

								
	<?php echo form_close(); ?> 

	</div>
	<!--/END OF PRODUCT BANNER CONTENT/-->  
