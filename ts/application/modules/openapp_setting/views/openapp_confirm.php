<div class="confirm_box">
	<div class="confirm_text"><?php echo $this->lang->line('confirm_delete')?></div>
	<div class="con_button">
		<button class="botton" onClick="delete_points(<?php echo $app_id;?>); triggerClose(); ">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('delete_button')?></span>
			</span>
		</button>

		<button class="button" onClick="triggerClose();">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('cancel_button')?></span>
			</span>
		</button>
	</div>
</div>
