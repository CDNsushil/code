<div class="confirm_box">
	<div class="confirm_text"><?php echo $this->lang->line('message_post_confirm_text')?></div>
	<div class="con_button">
		<button class="report" onClick="delete_message(<?php echo $msg_id;?>);triggerClose(); ">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('wall_yes_label')?></span>
			</span>
		</button>

		<button class="report" onClick="triggerClose();">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('wall_no_label')?></span>
			</span>
		</button>
	</div>
</div>
