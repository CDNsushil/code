<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form for manage merchant banner?>
<?php
	$userId=is_logged_in();
?>



<div class="col-md-10 col-sm-9 content border_left">
<?php echo form_open(uri_string()); ?>

<div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	<div class="bnr_search">
				<input type="text" class="width200" id="search_word" name="search_word" placeholder="Banner Name"  >
				<button type="button" class="btn btn-default btn-success search_word">
							<?php echo lang('global:search');?>
				 </button>
				 <a href="<?php echo base_url().'merchant/sales';?>"> 
					  <button type="button" class="btn btn-default btn-success">
							<?php echo lang('global:reset');?>
					  </button>
					</a>
					 
				<span class="floatR">
					<a href="<?php echo base_url().'merchant/exportMerchantSalesCSV'?>">
					  <button type="button" class="btn btn-primary "> <i class="fa fa-file-excel-o fa-fw fa-1x"></i> <span>Export CSV</span> </button>
					 </a>
				</span>	
			</div>
	
	<table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr role="row">
		
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 200px;">
					<?php echo lang('merchant:banner'); ?>
					
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 300px;">
					<?php echo lang('merchant:banner_name'); ?>
					
			</th>
		
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 150px;">
				<?php echo lang('global:price'); ?>
			</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 50px;">
				<?php echo lang('global:quantity'); ?>
			</th>
			
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 236px;">
				<?php echo lang('global:affiliate'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 200px;">
				<?php echo lang('global:date'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 100px;">
				<?php echo lang('global:view'); ?>
			</th>
			</tr>
	
	</thead>

<tbody class="bodyContent">
  
	<?php if(isset($sales) && !empty($sales)): ?>
	
	<?php $class="even"; 
		foreach($sales as $sale):?>

		
		   <tr role="row" class="<?php echo $class; ?>">
				<td>
					<?php $bannerImage= ($sale->upload_type==0)?$sale->image_url:base_url().$sale->upload_path.$sale->upload_image_name;?>
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($sale->banner_id) ;?>" > 
						<img src="<?php echo $bannerImage;?>" width="50" height="30" >
					</a>
				</td>
				<td>
					<?php echo $sale->banner_name; ?>
				</td>
				<td><?php echo $sale->amount; ?> <?php echo $sale->currency; ?></td>
				
				<td><?php echo $sale->banner_quantity; ?></td>
				<td><?php echo $sale->first_name; ?></td>
				<td><?php echo date('d M Y', strtotime($sale->order_time)); ?></td>
				<td>
				   <div class="btn-group table_buttons">
				
					<a href="<?php echo base_url().'merchant/banner/view/'.encode($sale->banner_id) ;?>" > 

					  <button type="button" class="btn btn-default btn-success">
						<i class="fa fa-eye fa-fw fa-1x"></i>
					  </button>
					 </a>
				
					</div>
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
					<td colspan="7" class="border_none">
					<div class="col-md-6 ShowingEntries">
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

</div>
	<!--/END OF DEMO TABLE CONTENT/-->
								
	<?php echo form_close(); ?> 
		<div class="clearfix"></div>
	</div>

 <script>
$(document).ready(function(){

	$(".search_word").click(function(e) {
		var word=$('#search_word').val();
		if(word==''){
			return false;
		}
		$.ajax({
		  type: "POST",
		  url: baseUrl+'merchant/getSalesFilterBanner',
		  data: 'word='+word,
			success: function(data) {
				if(data!=''){
					$('tbody.bodyContent').html('');
					$('tbody.bodyContent').html(data);
					return true;
				}
				$('tbody.bodyContent').html("No record found!");
			}
		});
	});
	
});
</script>                        


