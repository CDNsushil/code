
<div>
	<form name="customForm" action="<?php echo BASEURL.'openapp_setting/save_user_setting';?>" method="post" >
	<div class=" notification-panel">
		<div class="">
			<table>
			<?php 
			//print_r($user_app_setting);
					if(count($user_app_setting)>0){
							foreach($user_app_setting as $user_app_setting){?>
							<tr class='openapp_setting'>
										<td width='100px' class='cell'>
												<div class="app-element">							
												<img src='<?php echo $user_app_setting->thumbnail;?>' width='100' height='50'/>								
												</div>
										</td>
										<td width='150px' class='cell'>
												<div class="app-element app_title">
												<?php echo $user_app_setting->title;?>
												</div>
										</td>
										
										<td width='100px' class='cell'>
											<div class="app-element"><?php echo $this->lang->line('profile_data');?></div>
												<div class="app-element">
													<input type="hidden" class="" value="<?php echo $user_app_setting->app_id;?>" name='app_id[<?php echo $user_app_setting->app_id;?>]'>							
													<input type="checkbox" class="notification_group radiobtn" title="notification_group<?php echo $user_app_setting->profile_data;?>" <?php echo $checked = ($user_app_setting->profile_data == 1)? 'checked' : '' ; ?> name="profile_data[<?php echo $user_app_setting->app_id;?>]" value="1">							
											</div>
										</td>
										<td width='100px' class='cell'>
											<div>
												<div class="app-element"><?php echo $this->lang->line('friend_data');?></div>
												<div class="app-element"> 
													<input type="checkbox"  class="notification_group<?php echo $user_app_setting->app_id;?> radiobtn"  <?php echo $checked =  ($user_app_setting->friend_data == 1)? 'checked' : '' ;?> name="friend_data[<?php echo $user_app_setting->app_id;?>]" value="1">
												</div>
												<div class="clear"></div>
											</div>
										</td>
										<td width='100px' class='cell'>
											<div>
												<div class="app-element"><?php echo $this->lang->line('wall_data');?></div>
												<div class="app-element"> 
													<input type="checkbox" class="notification_group<?php echo $user_app_setting->app_id;?> radiobtn"   <?php echo $checked = ($user_app_setting->wall_data == 1)? 'checked' : '' ;?> name="wall_data[<?php echo $user_app_setting->app_id;?>]" value="1">
												</div>
											</div>
											<div class="clear"></div>
										</td>
										</tr>	
								
					<?php	}	
					}
					?>
					</table>
					<div class="inputbox266 fRight"> 
								<span class="saveChange"> 
									<button class="reset" type="submit" name="saveNotificationSetting" value="saveNotificationSetting">
										<span class="button next_bt text_caseL">
											<span class="width_85px" id="save_image">Save</span>
										</span>
									</button>
								</span>
							</div>
		</div>
		<div class="clear"></div>
	</div>
	</form>
</div>

