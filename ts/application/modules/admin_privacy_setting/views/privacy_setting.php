<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_privacy_setting_heading')?></h2>
	</div>
	<div class="contentbox">
		<form name="customForm" action="<?php echo BASEURL.'admin_privacy_setting';?>" method="post" >
			<table width="100%">
				<thead>
					<tr>
						<!--<th width="40px">S.No.</th>-->
						<th width="130px"><?php echo $this->lang->line('admin_privacy_setting_group_head')?></th>
						<th class="admin_section_div"><?php echo $this->lang->line('admin_privacy_setting_sesction_head')?></th>
					</tr>
				</thead>
				<?php 
				if(count($user_type_list)>0){
						foreach($user_type_list as $key=>$user_type){ ?>
						<tr class="dividerRow">
							<!--<td><?php echo $key+1;?></td>-->
							<td><b><?php echo $user_type->user_type;?></b></td>
							<td>
								<?php
									if(count($admin_section_list)>0){
										foreach($admin_section_list as $section){ ?>
											<div class="user_section_box">
												<div class="fLeft">
													<?php 													
													$checkedStatus ="";		
													if(isset($user_account_setting['previous_setting'][$user_type->role_id][$section->section_id])){
														$checkedStatus ="checked";
													}												
													
													?>
													<input type="checkbox" <?php echo $checkedStatus;?> name="section[<?php echo $user_type->role_id;?>][<?php echo $section->section_id;?>]" />
												</div>
												<div class="fLeft"><?php echo $section->title;?></div>
												<div class="clear"></div>
											</div>

								<?php	}	
									}
								?>
							
							</td>
						</tr>					
				<?php	}	
				}
				?>
				<tr>
					<td colspan="3">
						<div class="fRight">
							<input type="submit" value="Save" name="saveUserSetting" />
						</div>
					</td>
				</tr>
			</table>
		</form>
		</div>
</div>
