<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_report'); ?></h2>
	</div>
	
	<div class="contentbox">
		
		<div class="fRight">
			<form name="customform" action="" method="post" > 
				<div class="fLeft">
					<select name="searchIssue_type" >
						<option value="">Issue Type</option>
						<?php 
						if(count($report_type_list)>0){
							foreach($report_type_list AS $type){ ?>
									<option value="<?php echo $type->report_type_id;?>"  <?php echo ($issue_type==$type->report_type_id?'Selected':'');?>><?php echo $type->report_type;?> </option>
						<?php	}
						}
						?>				
					</select>
				</div>
				<div class="fLeft">
					<select name="issued_to" >
						<option value="">Issue To</option>
						<?php 
						if(count($user_roll)>0){
							foreach($user_roll AS $roll){ ?>
									<option value="<?php echo $roll->role_id;?>" <?php echo ($assign_to==$roll->role_id?'Selected':'');?>><?php echo $roll->user_type;?> </option>
						<?php	}
						}
						?>				
					</select>
				</div>
				<div class="fLeft">
						<select name="searchReportType">
							<option value="">Report Status</option>
							<option value="">ALL</option>
							<option value="0" <?php echo ($searchReportType==0?'Selected':'');?>>New</option>
							<option value="1" <?php echo ($searchReportType==1?'Selected':'');?>>Open</option>
							<option value="2" <?php echo ($searchReportType==2?'Selected':'');?>>Accepted</option>
							<option value="3" <?php echo ($searchReportType==3?'Selected':'');?>>Assigned</option>
							<option value="4" <?php echo ($searchReportType==4?'Selected':'');?>>Replied</option>
							<option value="5" <?php echo ($searchReportType==5?'Selected':'');?>>Resolved</option>
							<option value="6" <?php echo ($searchReportType==6?'Selected':'');?>>Closed</option>								
						</select>
				</div>
				
				<div class="fLeft">
						<input defaultvalue="Enter Member Name" type="text" name="searchTxt"  onfocus="if(this.value==this.defaultvalue){ this.value=''; }" onblur="if(this.value==''){ this.value = this.defaultvalue; }"  value="<?php echo (@$searchTxt==''?'Enter Member Name':@$searchTxt);?>" />
				</div>
				<div title="Search" class="tooltipClass fLeft">
					<input type="image" src="<?php echo ADMINIMG."search.jpg";?>"  alt="Search" width="15px" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
		
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_srno'); ?></th>
					<th><?php echo $this->lang->line('admin_report_id'); ?></th>
					<th><?php echo $this->lang->line('admin_report_type'); ?></th>
					<th><?php echo $this->lang->line('admin_report_username'); ?></th>
					<th><?php echo $this->lang->line('admin_report_for_type'); ?></th>
					<th><?php echo $this->lang->line('admin_report_date'); ?></th>					
				<!--	<th><?php echo $this->lang->line('admin_report_assign_to'); ?></th> -->	
					<th><?php echo $this->lang->line('admin_report_status'); ?></th>					
					<th>Spam Status</th>				
					<th></th>					
				</tr>
			</thead>
			
			<tbody>
				<?php 
				if($reports!=false){
					foreach($reports as $key=>$report){?>
						<tr>
							<td><?php echo $key+1;?></td>
							<td><?php echo $report->report_id;?></td>
							<td><?php echo ucfirst($report->report_type); ?></td>
							<td>
								<a href="<?php echo BASEURL?>admin/admin/user_profile/<?php echo $report->user_id?>" >
									<?php echo ucfirst($report->firstname." ".$report->lastname); ?></td>
								</a>
							<td><?php echo ucfirst($report->action_name); ?></td>
							<td><?php echo date('d F, Y',strtotime($report->report_date)) ?></td>
							<!-- <td><div id="reportAssign<?php echo $report->report_id; ?>">
								<?php //echo ($report->issue_to==0?"":$report->user_type); ?></div>
							</td> -->
							<td>
								<div id="reportStatus<?php echo $report->report_id; ?>">
								<?php
									switch($report->issue_status){
										case 0:
											echo "New";
											break;
										case 1:
											echo "Open";
											break;
										case 2:
											echo "Accepted";
											break;
										case 3:
											echo "Assigned";
											break;
										case 4:
											echo "Replied";
											break;
										case 5:
											echo "Resolved";
											break;
										case 6:
											echo "Closed";
											break;
									}								
							?>
								</div>
							</td>
							<td>
							
							<?php if(trim($report->report_type) == 'spam') {
								if($report->spam_status==0) { ?>
							<a href="#" id="report_id_<?php echo $report->report_id;?>" onClick="spam_request('<?php echo $report->report_id; ?>');"><b>Request</b></a>
							<?php } else {
								echo "<b style='color:green;'>Hidden</b>";
								} 
							}?>
							</td>
							<td><div class="edit_item tooltipClass" title="Assign Report" onclick="update_report_status(<?php echo $report->report_id; ?>)"></div></td>
						</tr>
				<?php  }
				 }
				?>
			</tbody>
		</table>
	</div>
	<div class="fRight"><?php echo $pagging;?></div>
</div>

