<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('update_support_answer')?></h2>
	</div>
	<div class="confirm_text"><?php echo $this->lang->line('update_support_answer')?></div>
	<div class="update_point_box">
		<form method="post" action="">
		<div class="fleft padding label"><?php echo $this->lang->line('question')?></div>
		<div class="fleft"><?php echo $question;?></div>
		<div class="clear"></div>
		<div class="fleft padding label"><?php echo $this->lang->line('answer')?></div>
		<div class="fleft"><textarea name="support_ans_update" id="support_ans_update"><?php echo $answer;?>
		</textarea>
		<div id="required"><div><?php echo $this->session->flashdata('message');?></div><input type="hidden" value="<?php echo $a_id;?>" name="update_answer_id"></div></div>
	</div>
	<div class="clear"></div>
	<div class="con_button">
		<input type="submit" name="update" value="Update"  class="botton">
		<input type="submit" name="cancel" value="Cancel"  class="botton">
	</div>
	</form>
</div>
