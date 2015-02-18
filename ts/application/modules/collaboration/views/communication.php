<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(isset($header)){
		echo $header;
	}
?>
<div class="row form_wrapper">
	<div class="row position_relative">	
		<!-- Div start here for compose tmail form -->
		<div class="row ">
			<div class="cell tab_left">
				<div class="tab_heading">
					<?php echo $this->lang->line('PNB');?></div><!--tab_heading-->
				</div>
			<div class="cell tab_right">
				<div class="tab_btn_wrapper">
					<div class="tds-button-top"> 
						<!-- Post add Icon -->
						<a class="formTip" original-title="">
							<span><div toggledivid="collab-Content-Box" class="projectToggleIcon toggle_icon" id="compose_id"></div></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		<div id="collab-Content-Box" class="form_wrapper toggle frm_strip_bg ">
			<div class="row"><div class="tab_shadow"></div></div>
			<?php
			if(isset($communicationForm)) { 
				echo $communicationForm;
			}?>
			
		</div>
		
		<div class="row">
			<div class="tab_shadow"></div>
		</div>
		<!-- Div end here of compose tmail form -->
		
		
		<?php
		if(isset($communicationList)) { 
			echo $communicationList;
		}?>
		
	</div>
</div>
