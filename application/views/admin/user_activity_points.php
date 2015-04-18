<div class="contentcontainer">
	<div class="headings altheading">
		<h2 class="fleft"><?php echo $this->lang->line('user_acitivity_points')?></h2>
		<div class="fright tooltipClass" title="Add Reward Points">
			<input type="image" src="<?php echo ADMINIMG.'icoGiftShop.jpg';?>"  alt="Gifts" width="30px" onclick="reward_point_box('<?php $res=$result;echo $res[0]->user_id;?>');"/>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="main">
		
			<div class="fLeft">
				<div class="name_box_wrapper ">
					<div class="user_box">
						<img src="<?php  echo getimage('user', 2,$res[0]->user_id);?>" width="40px" height="40px" />
					</div><!--user_box-->
					
					<div class="user_name-box">
						<?php echo ucfirst($res[0]->firstname." ".$res[0]->lastname); ?>
					</div>
					<div class="clear"></div>
				</div><!--name_box_wrapper-->				
				
				<div>
					<span><?php echo $this->lang->line('total_points')?> : </span>
					<span id="total_result"><?php if(!empty($res)){print_r( $total_point[0]->point);}?></span>
				</div>
			</div>	
				
			<div class="fRight">
				<form method="get" action="">
					<div class="fLeft">
						<select name="activity">
							<option value=""> Select user activity type </option>
								<?php foreach($all_activity_names as $all_activity_names1):?>
										<option <?php if($activity_filter_name==$all_activity_names1->activity_id){?> selected="selected"<?php }?> value="<?php echo $all_activity_names1->activity_id;?>">
											<?php echo ucfirst($all_activity_names1->activity_name);?>
										</option>
								<?php endforeach?>	
						</select>
					</div>
					<div class="tooltipClass fLeft" title="Search">
						<input width="16px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">
					</div>
					<div class="clear"></div>
				</form>
			</div>	
			<div class="clear"></div>
	</div>
	</div>
	<table width="100%">
			<thead>
				<th><?php echo $this->lang->line('s_no')?></th>
				<th><?php echo $this->lang->line('user_activity')?></th>
				<th><?php echo $this->lang->line('user_points')?></th>
				<th><?php echo $this->lang->line('date')?></th>
				<th colspan="2" width="50px"><?php echo $this->lang->line('table_action')?></th>
			</thead>
	<?php if($this->input->get('per_page')){$i=(($this->input->get('per_page')-1)*10)+1;}
			else{$i=1;} 
	foreach($result as $result1):?>
		<tbody id="state_list">
			<tr id="<?php echo $result1->point_id;?>">
				<td class="s_no"><?php echo $i++;?></td>
				<td><?php echo ucfirst($result1->activity_name);?></td>
				<td id="point<?php echo $result1->point_id;?>"><?php echo $result1->point;?></td>
				<td><?php echo  date("d F,Y h:i:s",strtotime($result1->datetime));?></td>
				<td>
					<a href="javascript:void(0)" onclick="point_update_box('<?php echo $result1->point_id;?>','<?php echo $result1->point;?>','<?php echo $result1->user_id;?>');" title="Update point for <?php echo ucfirst($res[0]->username);?>" class="tooltipClass">
						<div class="edit_icon"></div>
					</a>
				</td>
				<td>
					<a href="javascript:void(0)" title="Delete point for <?php echo $res[0]->username;?>" class="tooltipClass" onclick="confirm_delete('<?php echo $result1->point_id;?>','<?php echo $result1->user_id;?>');">
						<div class="delete_icon" ></div>
					</a>
				</td>
											
			</tr>
		</tbody>	
	<?php endforeach?>
	</table>
	</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>	
</div>
