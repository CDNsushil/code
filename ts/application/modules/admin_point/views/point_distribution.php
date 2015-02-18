<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_points')." ".$this->lang->line('admin_activity');?> </h2>
	</div>

	<div class="contentbox">
		<table width="100%" >
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_parent_level');?></th>
					<th><?php echo $this->lang->line('admin_point');?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				if($data!=false){
					foreach($data as $val) { ?>
						<tr>
							<td><?php echo $val->parent_level;?></td>
							<td>
							    <?php echo $val->point;?>&nbsp;
							    <img src="<?php echo ADMINIMG.'icons/icon_edit.png';?>" title="Update <?php echo $val->point;?> activity user point" class="tooltipClass" onClick="update_activity_point('point_distribution','point','<?php echo $val->point;?>','point_distribution_id 	','<?php echo $val->point_distribution_id;?>')"></td>

						</tr>
				<?php $i++; }
				 }
				?>
			</tbody>
		</table>
	</div>

	
</div>
