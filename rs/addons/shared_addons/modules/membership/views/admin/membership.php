<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show all memberships?>
<section class="title">
	<h4>
		<?php echo lang('membership:manage_memberships');  ?>
		<?php echo anchor('admin/membership/add/', lang('membership:add_membership'), 'rel="" class="button add_btn"') ?>
	</h4>
</section>

<section class="item">
	<div class="content">
		<?php if(isset($memberships) && !empty($memberships)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th width="150"><?php echo lang('membership:title');?></th>
						<th width="100"><?php echo lang('membership:price');?> (In $)</th>
						<th width="100"><?php echo lang('membership:membership_days');?></th>
						<th ><?php echo lang('membership:description');?></th>
						<th width="60"><?php echo lang('membership:status');?></th>
						<th width="150"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="inner"><?php $this->load->view('admin/partials/pagination');  ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					
				<?php foreach ($memberships as $membership):?>
					<tr>
						<td ><?php echo $membership->membership_title; ?></td>
						<td ><?php echo $membership->membership_price; ?></td>
						<td ><?php echo $membership->membership_days; ?></td>
						<td ><?php echo $membership->membership_description; ?></td>
						<td ><?php 
						        $membershipStatus=lang('membership:enabled'); 
						        $status=$membership->membership_status;
						        if($status=='1')$membershipStatus=lang('membership:disabled'); 
						        echo $membershipStatus;
						     ?>
						</td>
						<td class="actions">
						<?php	echo anchor('admin/membership/edit/'.$membership->id, lang('buttons:edit'), 'class="button edit"'); ?>
						<?php 
							if($status==0){
						      echo anchor('admin/membership/membershipStatus/'.$membership->id, lang('membership:disabled'), 'class="button status"');
						    }else{
								echo anchor('admin/membership/membershipStatus/did_'.$membership->id, lang('membership:enabled'), 'class="button status"');
							}
						  ?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				
			</table>
		
		<?php else: ?>
			<section class="title">
				<p><?php echo lang('membership:no_membership');?></p>
			</section>
		<?php endif;?>
		<span class="pagination">
		   <?php if(!empty($links)) { echo $links; } ?>
		 </span>  
	</div>

</section>

