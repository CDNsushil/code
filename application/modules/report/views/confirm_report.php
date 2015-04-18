<div class="confirm_box">
	<div class="confirm_text">Enter your comment</div>
	
	<textarea class="report_text" cols="44" id="report_comment<?php echo $post_id; ?>"></textarea>
	<div class="con_button">
		<button class="report" onClick="triggerClose();submit_report(<?php echo $report_type_id; ?>);">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('wall_submit_label')?></span>
			</span>
		</button>

	<button class="report" onClick="triggerClose();">
		<span class="button next_bt">
			<span><?php echo $this->lang->line('wall_cancel_label')?></span>
		</span>
		</button>
	</div>
</div>
