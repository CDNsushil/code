<div class="contentcontainer">
	<div class="headings altheading">
		<h2>Global Settings</h2>
	</div>
	<div class="contentbox">
		<form name="customForm" id="customForm" class="customForm" action="<?php echo BASEURL.'admin_global_setting/set_global_settings';?>" method="post">
			<table width="100%">
				<thead>
					<tr>
						<th width="40%">Option</th>
						<th width="60%">Value</th>
					</tr>
				</thead>
				<tr><td colspan="2"><span style="color:#0a0;"><?php echo $this->session->flashdata('global_setting_saved');?></span></td></tr>
				<?php 
				if(count($settings)>0){
						foreach($settings as $value){ 
						if($value->option == '__cloud_front_url__') $class_url = ' url'; else $class_url = '';
						?>
						<tr class="dividerRow">
							<td width="40%"><b><?php echo $value->option;?></b></td>
							<td width="60%">
								<div class="user_section_box">
									<div class="fLeft">
										<input type="text" class="required <?php echo $class_url;?>" name="<?php echo $value->option;?>" value="<?php echo $value->value;?>" size="60" />
									</div>
									<div class="clear"></div>
								</div>
								
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
<script type="text/javascript" src="<?php echo ADMINJS;?>jquery.validate.js"></script>
<script language="javascript">
$(document).ready(function(){
    $(".customForm").validate();
});
</script>