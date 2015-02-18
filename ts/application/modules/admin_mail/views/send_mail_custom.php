<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo ucfirst($user_type);?> List</h2>
	</div>
	<?php
	 $arr_user = array("A","B","C","D","E","F","G",
			   "H","I","J","K","L","M","N","O",
			   "P","Q","R","S","T","U","V","W",
			   "X","Y","Z");
	?>
	<div class="contentbox">
			<?php echo $this->session->flashdata('error_message'); ?>

		<table width="100%">
			<thead>
				<tr>
					<th>
						<?php 
							foreach($arr_user as $user)
							{
							  echo "<a href='".BASEURL."admin_mail/search_members/".$user_type."/".$user["value"]."' class='tooltipClass' title='".$this->lang->line('admin_search_by_user')." ".$user['value']."'>".$user["value"]."</a> | ";
							}
						?>
					</th>
				</tr>
			</thead>
			
			
		</table>
	<?php if($user_type!="Mailing")  { 			
	$action = BASEURL."admin_mail/send_mail_user";
	 ?>
	<form name="mail_form" id="mail_form" method="post" action="<?php echo $action?>" onSubmit="return valid_check();">
	<?php } else { 
	$action = BASEURL."admin_mail/create_mailing_list"; ?>
	<form name="mail_form" id="mail_form" method="post" action="<?php echo $action?>" onSubmit="return valid_mailing();">
	<?php }  ?>


		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_userid');?></th>
					<th><?php echo $this->lang->line('admin_user_name');?></th>
					<th><?php echo $this->lang->line('admin_user_email');?></th>
					<th><input type="checkbox" name="chkall" id="chkall" onClick="check_all()" ></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				if($users!=false){
					foreach($users as $users){?>
						<tr>
							<td><?php echo $users->user_id;?></td>
							<td><?php echo "<a href='".BASEURL."admin_users/user_profile/".$users->user_id."' class='user_css_rm'>".ucfirst($users->firstname)." ".$users->lastname."</a>";?></td>
							<td><?php echo $users->email;?></td>
							<td><input class="chk_user" type="checkbox" name="chk[]" value="<?php echo $users->user_id?>" ></td>
						</tr>
				<?php $i++; }
				 }
				?>
			</tbody>
		</table>

	</div>
	<?php if($user_type=="Mailing") { ?> 
		<input type="submit" name="send_type" id="send_type" value="CSV" class='tooltipClass' title="Export E-mail as CSV">
		<input type="submit" name="send_type" id="send_type" value="XLS" class='tooltipClass' title="Export E-mail as XLS">
		<input type="submit" name="send_type" id="send_type" value="Txt" class='tooltipClass' title="Export E-mail as Txt">
	<?php } else { 	?>
		<input type="submit" name="send" id="send" value="SEND" class='tooltipClass' title="Send mail">
	<?php } ?>
	</form>
<div id="pagination">
		<?php echo $paging; ?>
	</div>
</div>
