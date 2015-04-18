<div class="confirm_box">
	<div class="confirm_text"><?php if(!empty($point_id)){ echo $this->lang->line('update_points');}
				else{echo $this->lang->line('add_reward');}?></div>
	<div class="update_point_box">
		<div class="fleft padding label"><?php echo $this->lang->line('points')?></div>
		<div class="fleft"><input type="text" id="update_point" name="update_point" value="<?php if(!empty($current_point)){ echo $current_point;}?>"></div>
<div class="clear"></div>
<div class="required"></div>
	</div>
	<div class="clear"></div>
	<div class="con_button">
		<?php if(!empty( $point_id)){?>
		<button class="botton" onClick="update_points(<?php echo $point_id;?>); update_total_point('<?php echo $user_id;?>');">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('update_button')?></span>
			</span>
		</button>
		<?php }else{?>
		<button class="botton" onClick="insert_reward_points(<?php echo $user_id;?>); update_total_point('<?php echo $user_id;?>');">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('insert_reward_button')?></span>
			</span>

		</button>
		<?php }?>

		<button class="button" onClick="triggerClose();">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('cancel_button')?></span>
			</span>
		</button>
	</div>
</div>
