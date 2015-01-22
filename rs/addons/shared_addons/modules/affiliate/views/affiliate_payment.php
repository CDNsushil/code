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
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 320px;">
					<?php echo lang('affiliate:product'); ?>
					
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 130px;">
				<?php echo lang('affiliate:paid_on'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 100px;">
				<?php echo lang('global:amount'); ?>
			</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 160px;">
				<?php echo lang('affiliate:referral_point'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 150px;">
				<?php echo lang('global:status'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 60px;">
				<?php echo lang('global:view'); ?>
			</th>
			</tr>
   
	</thead>
		<tbody >
		
	<?php if(isset($products) && !empty($products)): ?>
			<?php foreach($products as $product):?>
			<tr>
				
				<td>
					<?php $bannerImage= ($product->upload_type==0)?$product->image_url:base_url().$product->upload_path.$product->upload_image_name;?>
					<a href="<?php echo base_url().'affiliate/payment/view/'.encode($product->request_id); ?>"><img src="<?php echo $bannerImage; ?>" height="30" width="50"> </a>
				</td>
				
				<td><?php echo $product->banner_name;?></td>
				<td><?php echo date('d M Y',strtotime($product->transaction_date));?></td>
				<td><?php echo $product->referral_commission.' '.$product->currency;?></td>
				
				<td><?php echo $product->referral_point;?></td>
			
				<td>
					<input type="hidden" class="request_data" value='<?php echo json_encode($product);?>'>
						paid!!
				</td>
				<td>
					
					<a href="<?php echo base_url().'affiliate/payment/view/'.encode($product->request_id) ;?>" > 

						<button type="button" class="btn btn-default btn-success">
							<i class="fa fa-eye fa-fw fa-1x"></i>
						</button>
					 </a>
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
	<!--/END OF DEMO TABLE CONTENT/-->
								
	<?php echo form_close(); ?> 

	</div>
	<!--/END OF PRODUCT BANNER CONTENT/-->  
