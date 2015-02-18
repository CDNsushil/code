<div class="contentcontainer">
	<div class="headings altheading">
		<h2>States</h2>
	</div>
	<div class="contentbox">
		<div class="fRight">
			<div class="fLeft">
				<?php
				$attributes = array('method' => 'post', 'name' => 'state_form');
				echo form_open('admin/admin/manage_states',$attributes);
				foreach($country as $clist){
							$options[$clist->country_id] = ucwords($clist->country_name);
						}
						$js = 'onchange="form.submit();"';						
						echo form_dropdown('country',$options,$country_id,$js);?>
			</div>
			<div title="Search" class="tooltipClass fLeft">
				<input type="image" src="<?php echo ADMINIMG."search.jpg";?>"  alt="Search" width="18px" />
			</div>
				
				<?php
						echo form_close();
				?>	

			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<table width="100%">
			<thead>
				<tr>
					<th>Sr.No.</th>
					<th>State Name</th>
					<th><?php echo $this->lang->line('table_action')?></th>
					<th><?php echo $this->lang->line('admin_age_limit');?></th>

				</tr>
			</thead>
			
			<tbody id="state_list">
				<?php
				if($states !=false){
					foreach($states as $state){?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php  echo $state->state_name ?></td>
							<td>
								<?php if($state->is_under_incentive_program==0){?>				
									<div id="<?php echo $state->state_id; ?>">								
										<a style="margin-left:20px" onclick="update_state(<?php echo $state->state_id ?>,<?php echo 1 ?>)" href="javascript:void(0)">
											<span id="<?php echo $state->state_id;?>">Activate</span>
										</a>
									</div>
								<?php 
									}else{?>
									<div id="<?php echo $state->state_id; ?>">
										<a style="margin-left:20px" onclick="update_state(<?php echo $state->state_id ?>,<?php echo 0 ?>)" href="javascript:void(0)">
											 <span id="<?php echo $state->state_id;?>">Deactivate</span>
										</a>
									</div>	
									<?php }
								?>
							</td>
							<td><?php echo $state->age_limit;?>
							
							<a href="javascript:void(0)" onclick="age_update_box('<?php echo $state->state_id;?>','<?php echo $state->age_limit;?>','<?php echo $state->state_name;?>');" title="Update age for <?php echo ucfirst($state->state_name);?>" class="tooltipClass">
							<div class="edit_icon"></div>
							</a>
							
							</td>
						</tr>
					<?php 
					 $i++; 
					 }
				 }
				 else echo "<tr><td>No States For this country</td></tr>"; 
				?>
			</tbody>
		</table>
	</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>
