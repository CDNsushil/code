<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show all memberships?>
<?php

	$userId=is_logged_in();

?>
<section class="title">
	<h4>
		<?php echo lang('request:manage_merchant_payment'); ?>
	</h4>
		
</section>
	<div class="content">
		<?php if(isset($payments) && !empty($payments)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('global:merchant') ?></th>
						<th><?php echo lang('request:banner_name') ?></th>
						<th><?php echo lang('request:product_price') ?></th>
						<th><?php echo lang('request:quantity') ?></th>
					
						<th><?php echo lang('request:request_date') ?></th>
						<th><?php echo lang('global:status') ?></th>
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
				<?php foreach ($payments as $payment):?>
					<tr>
						<td width="150"><?php echo $payment->first_name; ?> </td>
						<td width="300"><?php echo $payment->banner_name; ?></td>
						<td width="150"><?php echo $payment->amount; ?> <?php echo $payment->currency; ?></td>
						<td width="150"><?php echo $payment->banner_quantity; ?></td>
						<td width="150"><?php echo date('d M Y',strtotime($payment->order_time)); ?></td>
						<td width="150">
						<?php 
							echo lang('global:paid');
						?>
						</td>
						<td>
								<?php echo anchor('admin/request/viewMerchantPayment/'.encode($payment->payment_id), lang('global:view'), 'class="button status"'); ?>

						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				
			</table>
			
				
			<?php else: ?>
			<section class="title">
				<p><?php echo lang('global:no_record_found');?></p>
			</section>
		<?php endif;?>
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

