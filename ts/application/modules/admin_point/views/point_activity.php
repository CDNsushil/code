<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_points')." ".$this->lang->line('admin_activity');?> </h2>
	</div>

	<div class="contentbox">
		<table width="100%" >
			<thead>
				<tr>
					<th><?php echo $this->lang->line('filter_by_activity_name');?></th>
					<th><?php echo $this->lang->line('user_points');?></th>
					<th><?php echo $this->lang->line('admin_frequency');?></th>
					<th><?php echo $this->lang->line('admin_fr_per_day');?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				if($data!=false){
					foreach($data as $val) { ?>
						<tr>
							<td><?php echo ucfirst($val->activity_name);?></td>
							<td>
								<div class="fLeft point_div"><?php echo $val->point_for_user;?></div>
								<div title="Update <?php echo $val->point_for_user;?> activity user point" class="tooltipClass editImageDiv fLeft" onClick="update_activity_point('activity','point_for_user','<?php echo $val->point_for_user;?>','activity_id','<?php echo $val->activity_id;?>')"></div>
								<div class="clear"></div>
							</td>
							<td>
							    <div class="fLeft point_div"><?php echo $val->frequency;?></div>
							    <div title="Update <?php echo $val->frequency;?> activity user point" class="tooltipClass editImageDiv fLeft" onClick="update_activity_point('activity','frequency','<?php echo $val->frequency;?>','activity_id','<?php echo $val->activity_id;?>')"> </div>
								<div class="clear"></div>
							</td>								
							<td>
							   <div class="fLeft point_div"><?php echo $val->frequency_per_day;?></div>
							   <div title="Update <?php echo $val->frequency_per_day;?> activity user point" class="tooltipClass editImageDiv fLeft" onClick="update_activity_point('activity','frequency_per_day','<?php echo $val->frequency_per_day;?>','activity_id','<?php echo $val->activity_id;?>')"></div>
							   <div class="clear"></div>
							</td>
						</tr>
				<?php $i++; }
				 }
				?>
			</tbody>
		</table>
	</div>

	
</div>
