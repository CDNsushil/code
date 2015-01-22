<div class="contentcontainer">
	
	<h1><?php echo $this->lang->line('admin_send_mail');?></h1>
	

	<table  cellspacing="5" cellpadding="5">
		<tr>
			<td>
				<img src="<?php echo ADMINIMG?>icons/send_email.png" width="30%" alt="Active" onClick="create_message('users')" style="cursor:pointer;" class="tooltipClass" title="Send Email to Users" />
			<h3><?php echo $this->lang->line('admin_send_user');?></h3>
			</td>

			<td>
				<img src="<?php echo ADMINIMG?>icons/send_email.png" width="30%" alt="Active" onClick="create_message('employee')" style="cursor:pointer;" class="tooltipClass"  title="Send Email to Employee"/>
				<h3><?php echo $this->lang->line('admin_send_employee');?></h3>
			</td>

			<td>
				<a href="<?php BASEURL?>admin_mail/admin_mailing_creat"><img src="<?php echo ADMINIMG?>icons/mailing_list.png" width="60%" alt="Active"  class="tooltipClass" title="Members Mailing List"/></a>
				<h3><?php echo $this->lang->line('admin_mailing_list');?></h3>
			</td>
		</tr>
		<tr>
			<td>
				<a href="<?php BASEURL?>admin_mail/qualified_members_list"><img src="<?php echo ADMINIMG?>icons/send_email.png" width="30%" alt="Active"  class="tooltipClass" title="Members Mailing List"/></a>
				<h3> Qualified Members Mailing List</h3>
			</td>
			
				<td>
				<a href="<?php BASEURL?>admin_mail/nonqualified_members_list"><img src="<?php echo ADMINIMG?>icons/send_email.png" width="30%" alt="Active"  class="tooltipClass" title="UnQualified Members List"/></a>
				<h3> UnQualified Members Mailing List</h3>
			</td>
		</tr>
	</table>
	
</div>
