<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php  echo $this->lang->line('admin_manage_stat');?></h2>
	</div>

	<!-- onSubmit="return valid_formate(); -->
	<table  cellspacing="5" cellpadding="5" width="70%" align="center">
		<tr>
			<td>	
			<img src="<?php echo ADMINIMG?>icons/user_group_new.png" title="<?php echo $this->lang->line('admin_stat_user');?>" class="tooltipClass" onClick="user_stat()">
			<br ><h2><?php echo $this->lang->line('admin_users')." ".$this->lang->line('admin_stats');?></h2></td>

			<td>
			<a href="<?php echo BASEURL?>manage_country_stats"><img src="<?php echo ADMINIMG?>icons/country_icon.png" title="<?php echo $this->lang->line('admin_stat_country');?>" class="tooltipClass"> <!--onClick="country_stat()"--> </a>
			<br><h2><?php echo $this->lang->line('admin_country')." ".$this->lang->line('admin_stats');?></h2></td>
		</tr>

	</table>
	
</div>
