<div class="contentcontainer">
	
		<h1><?php echo $this->lang->line('admin_send_mail');?></h1>
	

	<!-- onSubmit="return valid_formate(); -->
	<form name="mail_send" id="mail_send" method="post" action="<?php echo BASEURL?>admin/admin/send_mail_user" >
	<table  cellspacing="5" cellpadding="5">
		<tr>
			<td><?php echo $this->lang->line('admin_subject');?></td>
			<td><input type="text" name="subject" id="subject"></td>
		</tr>
		<tr>
			<td valign="top"><?php echo $this->lang->line('admin_message');?></td>
			<td><textarea rows="5" cols="40" name="msg" id="msg"></textarea></td>
		</tr>

		<tr>
			<td colspan="2"><input type="submit" name="email_send" id="email_send" value="<?php echo $this->lang->line('admin_send_mail');?>"></td>
		</tr>
	</table>
	<input type="hidden" id="email_ids" name="email_ids" value="<?php echo $email_ids?>">
	</form>
	
</div>
