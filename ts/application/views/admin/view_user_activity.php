<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('user_activity')?></h2>
	</div>
	<div id="main">
	<form action="" method="get">
		<table class="fright">
			<tr>
				<td><?php echo $this->lang->line('f_by_username')?></td>
				<td>
					<select name="user">
						<option value="">--select--</option>
						<?php foreach($all_users as $all_users1):?>
						<?php if($all_users1->username!=''):?>
						<option  <?php if($user_filter_name==$all_users1->user_id){?> selected="selected"<?php }?> value="<?php echo $all_users1->user_id;?>">
						<?php echo $all_users1->firstname;?>&nbsp;<?php echo $all_users1->lastname;?>
						</option>
						<?php endif?>
						<?php endforeach?>
				    	</select>
				</td>
				<td><?php echo $this->lang->line('f_by_activity')?></td>
				<td>
					<select name="activity">
						<option value="">--select--</option>
						<?php foreach($all_activity_names as $all_activity_names1):?>
						<option <?php if($activity_filter_name==$all_activity_names1->activity_id){?> selected="selected"<?php }?> value="<?php echo $all_activity_names1->activity_id;?>">
						<?php echo $all_activity_names1->activity_name;?>
						</option>
						<?php endforeach?>	
				    	</select>
				</td>
				<td class="tooltipClass fLeft">
					<input width="15px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">
				</td>
			</tr>				
		<table>	
	</form>
	<table width="100%">
			<thead>
				<th><?php echo $this->lang->line('s_no')?></th>
				<th><?php echo $this->lang->line('user_name')?></th>
				<th><?php echo $this->lang->line('user_activity')?></th>
				<th><?php echo $this->lang->line('user_points')?></th>
				<th><?php echo $this->lang->line('date')?></th>
				<th><?php echo $this->lang->line('admin_points')?></th>
			</thead>
	<?php if($this->input->get('per_page')){$i=(($this->input->get('per_page')-1)*10)+1;}
			else{$i=1;}
	foreach($result as $result1):?>
		<tbody id="state_list">
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo "<a href='".BASEURL."admin_users/user_profile/".$result1->user_id."'>".ucfirst($result1->firstname);?>&nbsp;<?php echo $result1->lastname."</a>";?></td>
				<td><?php echo ucfirst($result1->activity_name);?></td>
				<td><?php echo $result1->point;?></td>
				<td><?php echo date("d F,Y h:i:s",strtotime($result1->datetime));?></td>
				<td><a href="<?php echo BASEURL?>admin/admin/manage_user_activity_points/<?php echo $result1->user_id;?>"><div class="view_user_point tooltipClass" title="Manage <?php echo ucfirst($result1->firstname).' '.$result1->lastname;?> point"></div></a></td>
			</tr>
		</tbody>	
	<?php endforeach?>
	</table>
	</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>
