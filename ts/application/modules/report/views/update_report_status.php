<div class="confirm_box">
	<input type="hidden" name="report_id" value="<?php echo $report_id;?>" id="report_id" />
	<div class="head-box">	
		<div>	
			<div class="name_box_wrapper fLeft">
					<div class="user_box">
						<img src="<?php  echo getimage('user', 2,$report_info[0]->user_id);?>" width="40px" height="40px" />
					</div><!--user_box-->
					
					<div class="user_name-box">
						<?php echo $report_info[0]->firstname." ".$report_info[0]->lastname; ?>
					</div>
			</div><!--name_box_wrapper-->
			<div class="fRight">
					Date : <?php echo date("d F, Y",strtotime($report_info[0]->report_date)); ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="div-title-text">Issue : <?php echo $report_info[0]->action_name; ?></div>
		<div class="div-title-text">Issue Type : <?php echo $report_info[0]->report_type; ?></div>
		<div class="div-title-text">Report Comment : <?php echo $report_info[0]->report_comment; ?></div>
	</div>
	
	<div class="div-title-text">
	<?php if($report_info[0]->action_name == 'Image'){ 
		?>
		<div style="float:left;margin-right:10px;"><?php echo $report_info[0]->action_name.': '; ?></div><div> <img height="50" width="50" src="<?php echo getimage('media', 5, $report_info[0]->post_user_id, $report_info[0]->media_name, '', '', $report_info[0]->album_id) ?>" alt="" /></div>
	<?php } ?>
	<?php if($report_info[0]->action_name == 'Status Update'){ ?>		
		<div><?php echo $report_info[0]->action_name.': '; ?> <?php echo $report_info[0]->wall_content; ?></div>
	<?php } ?></div><div class="div-title-text">
	<?php 
		
	if($logged_user_role==1){?>
	
		<div class="fLeft div-coloum">
			<div class="div-title-text">Assign to</div>
			<div>
				<select name="issued_to" id="report_issued_to" >
					<?php 
					if(count($user_roll)>0){
						foreach($user_roll AS $roll){ ?>
								<option value="<?php echo $roll->role_id;?>"><?php echo $roll->user_type;?> </option>
					<?php	}
					}
					?>				
				</select>
			</div>	
		</div>
	
	<?php } ?>
		<div class="div-coloum fLeft">
			<div class="div-title-text">Issued Status</div>
			<div>
				<select name="issued_status" id="report_issued_status" >
						<option value="0">New</option>				
						<option value="1">Open</option>				
						<option value="2">Accepted</option>				
						<option value="3">Assigned</option>				
						<option value="4">Replied</option>				
						<option value="5">Resolved</option>				
						<option value="6">Closed</option>									
				</select>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="div-title-text">
		<div class="button-div">
			<div class="fLeft">
				<button class="report1" onClick="triggerClose();update_report();">
					<span class="button next_bt">
						<span><?php echo $this->lang->line('wall_submit_label')?></span>
					</span>
				</button>
			</div>
			<div class="fLeft">
				<button class="report" onClick="triggerClose();">
					<span class="button next_bt">
						<span><?php echo $this->lang->line('wall_cancel_label')?></span>
					</span>
				</button>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
