<fieldset id="filters">

	<legend><?php echo lang('global:filters') ?></legend>
	
	<?php echo form_open('') ?>
	<?php echo form_hidden('f_module', $module_details['slug']) ?>
		<ul>
			<li>
				<?php echo lang('user:active', 'f_active') ?>
				<?php echo form_dropdown('f_active', array(0 => lang('global:select-all'), 1 => lang('global:yes'), 2 => lang('global:no') ), array(0)) ?>
			</li>

			<li>
				<?php echo lang('user:group_label', 'f_group') ?>
				<?php echo form_dropdown('f_group', array(0 => lang('global:select-all')) + $groups_select) ?>
			</li>
			
			<li>
				<div class="search_key">
					<span class="chosen_sprite "></span>
					<?php echo form_input('f_keywords','','class="" placeholder="Enter Email"'); ?>
				</div>
				<div class="filter_reset_btn">
					<?php echo anchor(current_url(), lang('global:reset'), 'class="cancel"') ?>
					</div>
				<div class="export_btn">
					<?php echo anchor(current_url().'/exportUserCSV', 'Export CSV', 'class="cancel "') ?>
				</div>
			</li>
		
		
				
		</ul>
	<?php echo form_close() ?>
</fieldset>
