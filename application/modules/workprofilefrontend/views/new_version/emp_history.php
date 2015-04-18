<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Workprofile left content area
	$this->load->view('new_version/workprofile_left');?>
	
	
	<div class="fl  right_box">
		<ul class="port_nav fr pt10 open_sans">
			<?php if( isset($empHistory) && !empty($empHistory) ) { ?>
				<li id="employmentLi" class="active"><a onclick="manageEduNEmp(1)">Employment</a></li>
			<?php } ?>
			<li id="educationLi" class="" ><a onclick="manageEduNEmp(2)">Education</a></li>
		</ul>
		<div class="sap_25"></div>
		<!-- Education details right content area-->
		<div class="right_profile fl dn" id="educationDiv">
			<!-- Education Detail Box-->
			<?php if(!empty($education)){ ?>
				<h3 class="fs18 red lineH14"><?php echo $this->lang->line('education');?></h3>
				<div class="sap_40"></div>
				<ul class="listpb20">
					<?php foreach ($education as $edu) { ?>
						<li>
							<span class="fl arialbold width126">
								<?php echo $edu->year_from .' - '.$edu->year_to ?>
							</span>
							 <span class="fl">
								 <p><?php echo $edu->degree;?></p>
								<p><?php echo $edu->university;?></p> 
							</span>
						</li>
					<?php }?>
				</ul>

			<div class="sap_50"></div>
			<?php } ?>
			<!-- Achievements $ Awards Box-->
			<?php if(!empty($workDetail->achievmentsAndAwards)) { ?>
				<div class="fs18 red">Achievements & Awards</div>
				<div class="sap_25"></div>
				<?php echo $workDetail->achievmentsAndAwards;
			}?>	
		</div>
	
		<!-- Employment details right content area-->
		<div class="right_profile fl " id="employmentDiv">
			<h3 class="fs18 red lineH14"><?php echo $this->lang->line('employment');?></h3>
			<?php  
			if( isset($empHistory) && !empty($empHistory) ) {				  
				foreach($empHistory as $history) { ?>
					<div class="sap_40"></div>
					<div class="clearbox">
						<div class="bb_c2c2 clearbox pb6 mb10">
							<span class="arialbold width192 fl">
								<?php
								if($history->empEndDate == '0') { 
									$endDate = 'Present';
								} else {
									$endDate .= dateFormatView($history->empEndDate,'F Y');
								}
								echo  dateFormatView($history->empStartDate,'F Y') .' - '.$endDate;?>
							</span>
							<span class="fl"> <?php if(isset($history->empDesignation)) echo $history->empDesignation ?> </span>
						</div>
						<p class="arialbold"><?php if(isset($history->compName))echo $history->compName ?></p>	
						<p><?php if(!empty($history->compCity) && (!empty($history->compCountry))) { echo $history->compCity .' , '.getCountry($history->compCountry);} ?></p>
						<div class="sap_20"></div>
						
						<?php if(isset($history->empAchivments) && !empty($history->empAchivments) ) { ?>
							<p><?php echo $history->empAchivments;?></p>
							<div class="sap_15"></div>
						<?php } ?>
						
						<div class="clearbox bg_f8f8f8 pt4 pb4 pl10 pr10">
							<span class="arialbold width192 fl">Notice Period	</span>
							<span class="fl"> 3 months</span>
						</div>
						<div class="sap_30"></div>
					</div>
				<?php 
				}
			} ?>	
		</div>
	</div>	
    <!--content_wrapper-->
    <script>
		// Manage Employment or Education box availability
		function manageEduNEmp(sectionType) {
			if(sectionType == 1) {
				$('#employmentDiv').show();
				$('#educationDiv').hide();
				$('#employmentLi').addClass('active');
				$('#educationLi').removeClass('active');
			} else {
				$('#employmentDiv').hide();
				$('#educationDiv').show();
				$('#employmentLi').removeClass('active');
				$('#educationLi').addClass('active');
			}
		}
    </script>
