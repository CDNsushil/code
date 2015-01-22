<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="title">
	<h4>
		<?php echo lang('cms:manage_cms');  ?>
	</h4>
</section>

<section class="item">
	<div class="content">
		<?php if(isset($cms) && !empty($cms)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th width="300"><?php echo lang('cms:title');?></th>
						<th width="150"><?php echo lang('cms:date_created');?></th>
						<th width="150"><?php echo lang('cms:date_modified');?></th>
						<th width="150"><?php echo lang('cms:status');?></th>
						<th width="250"><?php echo lang('cms:action');?></th>
					</tr>
				</thead>
				
                <tbody>
				<?php foreach ($cms as $data):?>
					<tr>
						<td ><?php echo $data->title; ?></td>
						<td ><?php echo $data->date_created; ?></td>
						<td ><?php echo $data->date_modified; ?></td>
						<td ><?php 
						        $dataStatus=lang('cms:enabled'); 
						        $status=$data->status;
						        if($status=='1')$dataStatus=lang('cms:disabled'); 
						        echo $dataStatus;
						     ?>
						</td>
						<td class="actions">
						<?php	echo anchor('admin/cms/edit/'.$data->id, lang('buttons:edit'), 'class="button edit"'); ?>
						<?php 
							if($status==0){
						      echo anchor('admin/cms/status/'.$data->id, lang('cms:disabled'), 'class="button status"');
						    }else{
								echo anchor('admin/cms/status/'.$data->id, lang('cms:enabled'), 'class="button status"');
							}
						  ?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				
			</table>
		
		<?php else: ?>
			<section class="title nrf">
				<p><?php echo lang('cms:no_record');?></p>
			</section>
		<?php endif;?>
		<span class="pagination">
		   <?php echo $links; ?>
		 </span>  
	</div>

</section>

