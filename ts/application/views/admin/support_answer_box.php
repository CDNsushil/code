<div class="confirm_box">
	<div class="confirm_text"><?php echo $this->lang->line('ans_to_q')?></div>
	<div class="update_point_box">
		<div class="fleft padding label"><?php echo $this->lang->line('question')?></div>
		<div class="fleft"><?php echo $question;?></div>
		<div class="clear"></div>
		<div class="fleft padding label"><?php echo $this->lang->line('answer')?></div>
		<div class="fleft"><textarea name="support_ans" id="support_ans"></textarea><div id="required"></div></div>
	</div>
	<div class="clear"></div>
	<div class="con_button">
		<button class="botton" onClick="insert_support_a(<?php echo $q_id;?>,'<?php echo $email;?>','<?php echo $username;?>','<?php echo $user_id;?>','<?php echo trim($question);?>'); ">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('ok')?></span>
			</span>
		</button>

		<button class="button" onClick="triggerClose();">
			<span class="button next_bt">
				<span><?php echo $this->lang->line('cancel_button')?></span>
			</span>
		</button>
	</div>
</div>
