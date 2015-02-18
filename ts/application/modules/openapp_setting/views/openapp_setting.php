
<div class="toggleDiv">
	<form name="customForm" action="<?php echo BASEURL.'notification_setting';?>" method="post" >
	<div class=" notification-panel">
		<div class="notification-head-group">
			<div class="div-element"><b></b>Display Notification</b></div>
			<div class="fLeft">
					<div>
						<div class="div-element">YES</div>
						<div class="div-element"> 
							<input type="radio"  name="notificationDisplay" value="1" <?php echo ($this->session->userdata('is_notification_display')==1?'checked':'');?> />
						</div>
						<div class="div-element">NO</div>
						<div class="div-element"> 
							<input type="radio"  name="notificationDisplay" value="0" <?php echo ($this->session->userdata('is_notification_display')==0?'checked':'');?> /> 
						</div>
						<div class="clear"></div>
					</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="leftPart-notification">Notification</div>
		<div class="rightPart-notification">
			
				
					<?php
					if(count($user_notification_setting)>0){
							foreach($user_notification_setting as $key=>$obj){ ?>
							
								<?php if($key == 0 || $old_group != $obj->notification_group_id){
										$old_group = $obj->notification_group_id;
										echo "<div class='notification-group'>$obj->notification_group</div>";
									}					
									echo "<div class='notification-group-element'><table><tr><td class='fLeft' width='270px'>$obj->notification_type;</td>";
								?>
										<td width='100px'>
											<div class="div-element">							
													<input type="checkbox" class="notification_group" title="notification_group<?php echo $obj->notification_type_id;?>" <?php echo $checked = ($obj->status == 1)? 'checked' : '' ; ?> name="section[<?php echo $obj->notification_type_id;?>][1]" value="1">							
											</div>
										</td>
										<td width='100px'>
											<div>
												<div class="div-element">Email</div>
												<div class="div-element"> 
													<input type="checkbox"  class="notification_group<?php echo $obj->notification_type_id;?>"  <?php echo $checked =  ($obj->email == 1)? 'checked' : '' ;?> name="section[<?php echo $obj->notification_type_id;?>][2]" value="1">
												</div>
												<div class="clear"></div>
											</div>
										</td>
										<td width='100px'>
											<div>
												<div class="div-element">SMS</div>
												<div class="div-element"> 
													<input type="checkbox" class="notification_group<?php echo $obj->notification_type_id;?>"   <?php echo $checked = ($obj->sms == 1)? 'checked' : '' ;?> name="section[<?php echo $obj->notification_type_id;?>][3]" value="1">
												</div>
											</div>
											<div class="clear"></div>
										</td>							
										
									</tr>	
								</table>
							</div>				
					<?php	}	
					}
					?>
					<tr>
						<td clospan="3" align="right">
							<div class="inputbox266"> 
								<span class="saveChange"> 
									<button class="reset" type="submit" name="saveNotificationSetting" value="saveNotificationSetting">
										<span class="button next_bt text_caseL">
											<span class="width_85px" id="save_image">Save</span>
										</span>
									</button>
								</span>
							</div>
								
						</td>
					</tr>
				</table>
			
		</div>
		<div class="clear"></div>
	</div>
	</form>
</div>
<style>
.notification-panel{
	font-size:11px;
}
.leftPart-notification{
	width:100px;
	font-weight:bold;
	float:left;
}
.rightPart-notification{
	width:420px;
	float:right;
	
}
.notification-group{
	padding:5px 0;
	font-weight:bold;
	border-bottom:1px solid grey;
	float:left;
	width:100%;
}
.notification-group-element {
	padding:3px 0;	
	border-bottom:1px solid lightGrey;
	float:left;
}
.div-element{
	margin-right:5px;
	float:left;
}
.toggleDiv{
	margin:10px 0;
	display:none;
}
.notification-head-group{
	padding:10px 0;
	font-weight:bold;	
	float:left;
	width:100%;
}

</style>

<script>
$(".notification_group").live('change',function(){
		var group = this.title;
		var status = this.checked;
		if(status==true){
			$('.'+group).attr('checked','checked');	
		}else{
			$('.'+group).attr('checked',false);	
		}

});
</script>
