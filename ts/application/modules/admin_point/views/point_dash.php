<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_point_activities');?></h2>
	</div>

	<!-- onSubmit="return valid_formate(); -->
	<table  cellspacing="5" cellpadding="5" width="70%" align="center">
		<tr>
			<td>	
			<a href="<?php echo BASEURL?>admin_point/point_activity/activity">			
			<img src="<?php echo ADMINIMG?>icons/Fast-Points_icon.png" title="<?php echo $this->lang->line('admin_point_activity_title');?>" class="tooltipClass">	</a>
			<br ><h3><?php echo $this->lang->line('admin_activity');?></h3></td>

			<td>
			<a href="<?php echo BASEURL?>admin_point/point_activity/point_distribution">			
			<img src="<?php echo ADMINIMG?>icons/Fast-Points_icon.png" title="<?php echo $this->lang->line('admin_point_distribution_title');?>" class="tooltipClass" onClick="">
			</a>
			<br><h3><?php echo $this->lang->line('admin_point_distribution');?></h3></td>
		</tr>

	</table>
	
</div>
