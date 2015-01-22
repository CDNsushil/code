<div class="contentcontainer">
	<div class="fLeft">
	<h2 class="heading_statistics"><?php  echo $this->lang->line('manage_statistics_user_stats');?></h2>
	<!-- onSubmit="return valid_formate(); -->
	<table  cellspacing="5" cellpadding="5" width="70%" align="center">
		<tr>
			<td><h3><?php echo $this->lang->line('admin_user_reg_today');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/today"><?php echo $user_count_arr['today'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_week');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/week"><?php echo $user_count_arr['week'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_month');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/month"><?php echo $user_count_arr['month'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_year');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/year"><?php echo $user_count_arr['year'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('amin_user_reg_all');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users"><?php echo $user_count_arr['all'];?></a>	</h3></td>
		</tr>
	</table>
	</div>
		<div class="fLeft">
		<h2 class="heading_statistics"><?php  echo $this->lang->line('manage_statistics_user_age_stats');?></h2>
	<!-- onSubmit="return valid_formate(); -->
	<table  cellspacing="5" cellpadding="5" width="100%" align="center">
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_under_20');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/under20"><?php $user20 = get_count_user_detail();if(!empty($user20)){print_r(count($user20['dob']['under20']));}?></a></h3></td>
		</tr>
		<tr>
			<td><h3>20&nbsp;<?php echo $this->lang->line('to');?>&nbsp;29</h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/20to29"><?php  $user30 = get_count_user_detail();if(!empty($user30)){echo count($user30['dob']['under30']);}?></a></h3></td>
		</tr>
		<tr>
			<td><h3>30&nbsp;<?php echo $this->lang->line('to');?>&nbsp;39</h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/30to39"><?php  $user40 = get_count_user_detail();if(!empty($user40)){echo count($user40['dob']['under40']);}?></a></h3></td>
		</tr>
		<tr>
			<td><h3>40&nbsp;<?php echo $this->lang->line('to');?>&nbsp;49</h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/40to49"><?php  $user50 = get_count_user_detail();if(!empty($user50)){echo count($user50['dob']['under50']);}?></a></h3></td>
		</tr>
		<tr>
			<td><h3>50&nbsp;<?php echo $this->lang->line('to');?>&nbsp;59</h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/50to59"><?php $user60 = get_count_user_detail();if(!empty($user60)){echo count($user60['dob']['under60']);}?></a>	</h3></td>
		</tr>
		<tr>
			<td><h3>60&nbsp;<?php echo $this->lang->line('to');?>&nbsp;69</h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/60to69"><?php $user70 = get_count_user_detail();if(!empty($user70)){echo count($user70['dob']['under70']);}?></a>	</h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_70_over');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/over70"><?php $over70 = get_count_user_detail();if(!empty($over70)){echo count($over70['dob']['over70']);}?></a>	</h3></td>
		</tr>
	</table>
	</div>
	
	<div class="fLeft">
	<h2 class="heading_statistics"><?php  echo $this->lang->line('manage_statistics_user_gender_stats');?></h2>
	
	<table  cellspacing="5" cellpadding="5" width="70%" align="center">
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_male');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/male"><?php $male = get_count_user_detail();echo $male['male'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_female');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/female"><?php $female = get_count_user_detail();echo $female['female'];?></a></h3></td>
		</tr>
		<tr>
			<td><h3><?php echo $this->lang->line('manage_statistics_users_other');?></h3></td>
			<td><h3><a href="<?php echo BASEURL?>admin_users/index/other"><?php $other = get_count_user_detail();echo $other['other'];?></a></h3></td>
		</tr>
	</table>
	</div>
	<div class="clear"></div>

</div>
