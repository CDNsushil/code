<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show membership of all member?>


<section class="title">
	<h4>
		<?php echo lang('membership:membership_features');?> 
		<?php echo anchor('admin/membership/addfeature', lang('membership:add_feature'), 'rel="" class="button add_btn"') ?>
	</h4>
</section>

<section class="item">
	<div class="content">
		<?php if(isset($features) && !empty($features)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('membership:title');?></th>
						<th><?php echo lang('membership:description');?></th>
						<th><?php echo lang('membership:status');?></th>
						<th></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($features as $feature):?>
					<tr>
						<td width="200"><?php echo $feature->feature_title; ?></td>
						<td width="600"><?php echo $feature->feature_description; ?></td>
						<td width="200"><?php 
						        $featureStatus=lang('membership:enabled'); 
						        $status=$feature->feature_status;
						        if($status=='1')$featureStatus=lang('membership:disabled'); 
						        echo $featureStatus;
						     ?>
						</td>
						<td class="actions">
						<?php echo anchor('admin/membership/editfeature/'.$feature->id, lang('buttons:edit'), 'class="button edit"') ?>
						<?php
							if($status==0){
						      echo anchor('admin/membership/featureStatus/'.$feature->id, lang('membership:disabled'), 'class="button status"');
						    }else{
								echo anchor('admin/membership/featureStatus/did_'.$feature->id, lang('membership:enabled'), 'class="button status"');
							}
							?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		
		<?php else: ?>
			<section class="title">
				<p><?php echo lang('membership:no_feature');?></p>
			</section>
		<?php endif;?>
	</div>
</section>
