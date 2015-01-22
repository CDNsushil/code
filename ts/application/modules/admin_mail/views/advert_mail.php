<div class="report">	
	<table><tr><td>Email:</td><td> <input type="text" id="email" name="email" value="<?php echo $email_id; ?>" /></td></tr>
	<tr><td>Subject:</td><td> <input type="text" name="sub" id="sub" value="" /></td></tr>
	<tr><td>Message:</td><td> <textarea  name="msg" id="msg" rows="2" cols="16" ></textarea></td></tr>
</table>
<div class="div-title-text">
		<div class="button-div">
			<div class="fLeft">
				<button class="report" onClick="triggerClose();send_mail();">
					<span class="button next_bt">
						<span><?php echo $this->lang->line('admin_submit_label')?></span>
					</span>
				</button>
			</div>
			<div class="fLeft">
				<button class="report" onClick="triggerClose();">
					<span class="button next_bt">
						<span><?php echo $this->lang->line('admin_cancel_label')?></span>
					</span>
				</button>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
