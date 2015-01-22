<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show all memberships?>
<?php
	$payStatus=(isset($pay_status)?$pay_status:'0');
	$userId=is_logged_in();
	$sortOption=array(''=>'Reset','0'=>'Un-paid','1'=>'Paid');

?>
<section class="title">
	<h4>
	
		<?php echo lang('request:manage_affi_request'); ?>
	</h4>
	
		<div class="sort_status"> 
			<div class="filter_title">Filter</div>
		<?php  echo form_dropdown('sort_payment_status',$sortOption,$payStatus,'class="pay_status"') ?>
		</div>
</section>
	<div class="content">

			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('global:affiliate') ?></th>
						<th><?php echo lang('request:banner_name') ?></th>
						<th><?php echo lang('request:product_price') ?></th>
					
						<th><?php echo lang('global:currency') ?></th>
							<th>Status</th>
						<th><?php echo lang('request:request_date') ?></th>
						<th></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="7">
							<div class="inner"><?php $this->load->view('admin/partials/pagination');  ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php if(isset($requests) && !empty($requests)): ?>
				<?php foreach ($requests as $request):?>
					<tr>
						<td width="150"><?php echo $request->first_name; ?></td>
						<td width="150"><?php echo $request->banner_name; ?></td>
						<td width="150"><?php echo $request->product_price; ?></td>
						
						<td width="150"><?php echo $request->currency_type; ?></td>
						<td width="150">
							
							<?php  
									if($request->payment_status==1){
										echo "Paid";
									}else{
										echo "Pending";
									}
							
							?>
						
						</td>
						<td width="150"><?php echo date('d M Y',strtotime($request->created_at)); ?></td>
						<td width="150">
						
							<?php echo anchor('admin/request/viewRequest/'.$request->request_id, lang('global:view'), 'class="button status"'); ?>
					
						</td>
						
					</tr>
				<?php endforeach;?>
					<?php else: ?>
					<tr><td colspan="7"><?php echo lang('global:no_record_found');?></td></tr>
				<?php endif;?>
				</tbody>
				
			</table>
			

		
		<span class="pagination">
		   <?php echo $links; ?>
		 </span>
	</div>


<script>
	jQuery(document).delegate('.pay_status','change',function(){
		var value=$(this).val();
		 window.location = '<?php echo base_url().'admin/request/index/'; ?>'+value;
	});
</script>

