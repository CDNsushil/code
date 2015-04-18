<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Workprofile left content area
	$this->load->view('new_version/workprofile_left'); ?>		
	
	<!-- Workprofile right content area-->
	<div class="fl  right_box">
		<div class="sap_25"></div>
		<div class="right_profile">
			<!-- Summary Box-->
			<?php if(!empty($workDetail->synopsis)) { ?>
				<h3 class="fs18 red lineH14">
					<?php echo $this->lang->line('professionalSummary');?>
				</h3>
				<div class="sap_30"></div>
				<p class="lineH20">
					<?php echo $workDetail->synopsis;?></p>
				<div class="sap_45"></div>
			<?php } ?>
			
			<!-- Skills and Qualification Box-->
			<?php if(!empty($workDetail->skills)) { ?>
				<h3 class="fs18 red lineH14">
					<?php echo $this->lang->line('skillQualifications');?>
				</h3>
				<div class="sap_30"></div>
				<p class="lineH20">
					<?php echo $workDetail->skills;?></p>
				<div class="sap_45"></div>
			<?php } ?>
		</div>
	</div>	
	<!--content_wrapper-->
