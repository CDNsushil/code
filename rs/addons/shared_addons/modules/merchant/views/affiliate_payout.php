<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to  banners ?>
<?php
	$userId=is_logged_in();
	
?>

<?php if($userId):  ?>
	<?php if(isset($sidebarOptions)): echo $sidebarOptions; endif; ?>
<?php endif;  ?>



<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">

	
  <div class="clearfix"></div>
<!--/DEMO TABLE CONTENT/-->	
<div id="example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	<table id="example" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<thead>
		<tr role="row">
		
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Banner Name: activate to sort column ascending" style="width: 120px;">
					<?php echo lang('merchant:affiliate_id'); ?>
					
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Target URL: activate to sort column ascending" style="width: 150;">
				<?php echo lang('name_label'); ?>
			</th>
	
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 100px;">
				<?php echo lang('merchant:total_refers'); ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 200px;">
				<?php echo lang('merchant:total_commission').'(in $)'; ?>
			</th>
			<th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 200px;">
				 <?php echo lang('merchant:payment'); ?> 
			</th>
			</tr>
   
   
	</thead>
 
	<tbody>
		<?php if(isset($productsf) && !empty($products)): ?>

		<?php foreach($products as $product): ?>
			<tr  >

				<td><?php echo $product->affiliate_id; ?></td>
				<td><?php echo $product->first_name; ?></td>
				<td><?php echo $product->countProduct; ?></td>
				<td><?php echo $product->totalCommission; ?></td>
				<td>
					<?php echo anchor(uri_string(),'Continue To Pay','class=""'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php else : ?>	
			<tr>

				<td colspan="5"><?php echo lang('global:no_record_found'); ?></td>
				
			</tr>
		<?php endif;?>
	
				
		
 
		</tbody>


</table>
 
</div>

</div>

</div>
<!--/END OF DEMO TABLE CONTENT/-->
							
<?php echo form_close(); ?> 
	<div class="clearfix"></div>
</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  
				  

