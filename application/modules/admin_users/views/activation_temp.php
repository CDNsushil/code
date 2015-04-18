<div class="contentcontainer">
	<form method="post" name="deact_form" id="deact_form" action="<?php echo BASEURL?>admin_users/update_deactication">
	<table>
			<?php if($activation_val==0) { ?>
			<tr><td><input type="radio" name="deactivate" id="deactivate" value="1" >Activate</td>
			<?php } ?>
		<tr>
			<td><input type="radio" name="deactivate" id="deactivate" value="3" >Permanent Deactivation</td>
		</tr>
		<tr>
			<td><input type="radio" name="deactivate" id="deactivate" value="2" >Temporary Deactivation</td>
	       </tr>
	   <tr>
		 <td>
			<input type="submit" name="update" id="update" value="Update Status">
		 </td>
	   </tr>
	</table>
	<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
	</form>
</div>
