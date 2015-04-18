<div class="contentcontainer">
	<h1>Send Email to <?php echo ucfirst($user_type);?></h1>	

	<form name="user_update" id="user_update" method="post" action="<?php echo BASEURL?>admin_mail/admin_mail_send">
		<table width="60%">
			<tr>
				 <td><b>Send to all</b></td>
				 <td><input type="radio" name="send_type" id="send_type" value="all" onClick="send_msg_type('all')"></td>
			</tr>

			<tr>
				 <td><b>Send to custom</b></td>
				 <td><input type="radio" name="send_type" id="send_type" value="custom" onClick="send_msg_type('custom')"></td>
			</tr>

				<tr>
					<td id="send_id" style="display:none"></td>
				</tr>
			</div>
		</table>
		<input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>">
	</form>

	
</div>
