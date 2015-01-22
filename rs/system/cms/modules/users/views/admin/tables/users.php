<h4>
	<a href="<?php echo base_url().'admin/users/create'; ?>" rel="" class="button add_btn">Add Users</a>
</h4>
<?php if (!empty($users)):   ?>
	<table border="0" class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('user:name_label');?></th>
				<th class="collapse"><?php echo lang('user:email');?></th>
				<th><?php echo lang('user:group_label');?></th>
				<th class="collapse"><?php echo lang('user:active') ?></th>
				<th class="collapse"><?php echo lang('user:joined_label');?></th>
				<th class="collapse"><?php echo lang('user:user_block');?></th>
				<th width="150"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php $link_profiles = Settings::get('enable_profiles') ?>
			<?php foreach ($users as $member): ?>
				<tr>
					<td class="align-center"><?php echo form_checkbox('action_to[]', $member->id, '','class="check_actionto"') ?></td>
					<td>
					<?php if ($link_profiles) : ?>
						<?php echo  $member->first_name; ?>
					<?php else: ?>
						<?php echo $member->first_name ?>
					<?php endif ?>
					</td>
					<td class="collapse"><?php echo $member->email; ?></td>
					<td><?php echo $member->group_name; ?></td>
					<td class="collapse"><?php echo $member->active ? lang('global:yes') : lang('global:no')  ?></td>
					<td class="collapse"><?php echo date('d M Y', $member->created_on); ?></td>
					<td ><?php echo (($member->user_block==0)?lang('user:no'):lang('user:yes')); ?></td>
					<td class="actions">
						<?php echo anchor('admin/users/edit/' . $member->id, lang('global:edit'), array('class'=>'button edit')) ?>
						<?php echo anchor('admin/users/delete/' . $member->id, lang('global:delete'), array('class'=>'confirm button delete')) ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<span class="pagination">
		   <?php if(!empty($pagination)){ echo $pagination; } ?>
		 </span> 
<?php endif ?>

<script>
	var msg='<?php echo lang('user:confirm_block_msg'); ?>';
	var smsg='<?php echo lang('user:select_user_msg'); ?>';
	$('.user_block').click(function(){
		var check=$('.check_actionto:enabled:checked').val();
		if(!check){
			alert(smsg);	
			return false;
		}
		var con=confirm(msg);
		if(con){
			return true;
		}
		return false;
	});
</script>
