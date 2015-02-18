<!-- contant div -->
<div  class="Contantpanel">
	<div class="left_panel"></div>
	<!-- register box start-->
	<div class="right_register_panel">
	
		<div class="sprint2_top_crn">
			<p class="sprint_heading2"><?php echo $this->lang->line('create_profile_create_profile');?></p>
			<p class="sprintspace"></p>
		</div>
		
		<?php if(isset($mails)){ ?><div class="success_msg"><?php echo $mails; ?></div><?php }?>
		<?php if(isset($success)){ ?><div class="success_msg"><?php echo $success; ?></div><?php }?>
		
		<div class="sprint2_mid_crn">
			<p class="sprintspace12">&nbsp;</p>
			<div class="clear"></div>
		</div>
		<div class="sprint4_bottom_crn">
			<p class="sprintspace7_step4">&nbsp;</p>
			<div class="Followmessenger">
			</div>
			<div class="clear"></div>
			<div class="spacebar22"></div>
			<!-- paging nation div -->
			<div class="pagingbox2 page_button_top_margin"  style="margin-top:90px;">
				<!-- pageing bullet close -->
				<div class="pagebuttons1">
					<button class="reset" onClick="javascript:window.location.href='<?php echo BASEURL;?>profile'"><span class="button"><span><?php echo $this->lang->line('create_profile_view_profile');?></span></span></button>
				</div>
				<div class="clear"></div>
			</div>
			<!-- close paging nation div-->
		</div>
		<!-- right register buttom corner end-->
	</div>
</div>
