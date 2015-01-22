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
					Media Exchange</div><!--tab_heading-->
			</div>
			<div class="cell tab_right">
				<div class="tab_btn_wrapper">
					<div class="tds-button-top"> 
						<!-- Post add Icon -->
						<a toggledivicon="collabToggleIcon" toggledivform="collaborationMediaFormDiv" toggledivid="collab-Content-Box" class="formTip formToggleIcon" id="AddLinkcollab">
							<span><div class="projectAddIcon" id="AddIconcollab"></div></span>
						</a>
						
						<a class="formTip" original-title="">
							<span><div toggledivid="collab-Content-Box" id="collabToggleIcon" class="projectToggleIcon toggle_icon" ></div></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div id="collab-Content-Box" class="form_wrapper toggle frm_strip_bg ">
			<div class="row"><div class="tab_shadow"></div></div>
			<?php
			
			if(isset($mediaForm) ){ 
				echo $mediaForm;
			}
			if(isset($mediaList) ){
				echo $mediaList;
			}?>
			
			<div class="row">
				<div class="tab_shadow"></div>
			</div>
		</div>
		
	</div>
</div>
