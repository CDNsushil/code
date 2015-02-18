<div class="contentcontainer">
	
	<h1><?php  echo $this->lang->line('admin_manage_stat');?></h1>
	
	
	<form name="country_statistics" id="country_statistics" method="post" action="<?php echo BASEURL?>admin_users/index/country_stat">
	<table  cellspacing="5" cellpadding="5" width="70%" align="center">
		<tr>
			<td><h3><?php echo $this->lang->line('admin_country');?></h3></td>
			<td>
				<select name="country" id="country" size="1">
					<option>-Select-</option>
					<?php foreach($country as $clist) { ?>
						<option value="<?php echo $clist->country_id?>"><?php echo $clist->country_name;?></option>
					<?php }  ?>
				</select>
		</tr>

		<tr>
			<td><h3><?php echo $this->lang->line('admin_user_gender');?></h3></td>
			<td>
				<select name="gender" id="gender" size="1">
					<option value="">-Select-</option>
					<option value="2"><?php echo $this->lang->line('admin_all_user');?></option>
					<option value="1"><?php echo $this->lang->line('admin_user_male');?></option>
					<option value="0"><?php echo $this->lang->line('admin_user_female');?></option>
				</select>
			</td>
		</tr>

		<tr>
			<td></td>
			<td><input type="submit" name="search" id="search" value="Search"></td>
		</tr>
	</table>
	</form>
	
</div>
