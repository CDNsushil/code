<div class="confirm_box">
	<div class="confirm_text"><?php echo $this->lang->line('admin_age_update')." ".ucfirst($state_name);?></div>
	<div class="update_point_box">
		<div class="fleft padding label"><?php echo $this->lang->line('admin_age_limit');?></div>
		<?php 
					$attributes = array('method' => 'post', 'name' => 'age_update');
				echo form_open('admin/admin/update_age_limit',$attributes);
		?>
		<input type="hidden" name="state_id" id="state_id" value="<?php echo $state_id;?>">
		<input type="hidden" name="age_limit" id="age_limit" value="<?php echo $age_limit;?>">
			
		<div class="fleft">
			<input type="text" id="update_age" name="update_age" value="<?php if(!empty($age_limit)){ echo $age_limit;}?>" maxlength="2"></div>
			
<div class="clear"></div>
<div class="required"></div>

	</div>
	<div class="clear"></div>
	<div class="con_button">
		<?php if(!empty( $state_id)){?>
		<button class="botton" onClick="update_age(<?php echo $state_id;?>);">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('update_button')?></span>
			</span>
		</button>
		<?php } ?>

		<button class="button" onClick="triggerClose();">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('cancel_button')?></span>
			</span>
		</button>
		
			
						
				<?php echo form_close(); ?>	
	</div>
</div>
