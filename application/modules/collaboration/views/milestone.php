<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(isset($header) ){
		echo $header;
	}
?>
	
<div class="row form_wrapper">
	<div class="row position_relative">	
		<div class="row ">
			<div class="cell tab_left">
				<div class="tab_heading">
					Milestones</div><!--tab_heading-->
			</div>
			<div class="cell tab_right">
				<div class="tab_btn_wrapper">
					<div class="tds-button-top"> 
						<!-- Post add Icon -->
						<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'create_milestone')){?>
						<a toggledivicon="collabToggleIcon" toggledivform="collaborationmilestoneFormDiv" toggledivid="collab-Content-Box" class="formTip formToggleIcon" id="AddLinkcollab">
							<span><div class="projectAddIcon" id="AddIconcollab"></div></span>
						</a>
						<?php }?>
						<!--<a class="formTip" original-title="">
							<span><div toggledivid="collab-Content-Box" id="collabToggleIcon" class="projectToggleIcon toggle_icon" ></div></span>
						</a>-->
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div id="collab-Content-Box" class="form_wrapper toggle frm_strip_bg ">
			<?php
			if(isset($milestoneForm) && ($userId==$ownerId || checkCollabAccess($userCollabAccess, 'create_milestone')) ){ 
				echo $milestoneForm;
			}?>
			
		</div>
		
		<?php 
			if(isset($milestoneList) ){
				echo $milestoneList;
			}
		?>
		
	</div>
</div>
