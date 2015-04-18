<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Workprofile left content area
	$this->load->view('new_version/workprofile_left');
	?>		
	<!-- Workprofile right content area-->
	<div class="right_profile fl ">
		<h3 class="fs18 red lineH14">Personal Details</h3>
		<div class="sap_45"></div>
		<ul class="port_detail_list">
			<?php if(!empty($profileLanguages)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Languages	</span>	
					<span class="fl width385">
						<?php foreach($profileLanguages as $profileLanguage) { ?>
							<span class="gray_bg">	<?php echo getLanguage($profileLanguage->langId).' '.$profileLanguage->fluencyType;?></span>
						<?php } ?>
					</span>
				</li>
			<?php } 
			if(!empty($workDetail->nationality)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Nationality </span>
					<span class="fl width385">
						<span class="gray_bg"> <?php echo $workDetail->nationality;?></span>
					</span>
				</li>
			<?php } 
			if(!empty($WorkProfileVisa) && is_array($WorkProfileVisa)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Work Visas	</span>
					<span class="fl width385">	
						<?php foreach($WorkProfileVisa  as $visaTypeData) { ?>
							<span class="gray_bg">	<?php echo getCountry($visaTypeData->countryId).' '.$visaTypeData->visaType;?></span>
						<?php } ?>
					</span>
				</li>
			<?php } 
			if(isset($workDetail->dateOfBirth) && !empty($workDetail->dateOfBirth)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Date of Birth</span>	
					<span class="fl width385">	
						<span class="gray_bg">	<?php echo date('d F Y',strtotime($workDetail->dateOfBirth));?> </span>
					</span> 
				</li>
			<?php  } 
			if(isset($workDetail->interests) && !empty($workDetail->interests)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Interests	</span>		
					<span class="fl width385">	
						<span class="gray_bg">
							<?php echo $workDetail->interests;?>
						</span>
					</span>
				</li>
			<?php }
			if(isset($workDetail->otherInterest) && !empty($workDetail->otherInterest)) { ?>
				<li>
					<span class="fl arialbold width_180">Other</span>			
					<span class="fl width385">
						<span class="gray_bg">	<?php echo $workDetail->otherInterest;?></span>
					</span> 
				</li>
			<?php } ?>
		</ul>
		<div class="sap_45"></div>

		<h3 class="fs18 red lineH14">Type of Work Sort</h3>
		<div class="sap_45"></div>
		<ul class="port_detail_list">
			<?php if(!empty($workDetail->remunerationRequired)) { 
				// get user currency
				$seller_currency = LoginUserDetails('seller_currency');
				// set users currency
				$currency = '€';
				if($seller_currency == 1) {
					$currency = '$';
				}
				?>
				<li>
					<span class="fl arialbold pt4 width_180">Desired Renumeration	</span>	
					<span class="fl width385">
						<span class="gray_bg">	
							<?php
							$remunerationRate = '';
							if($workDetail->remunerationRate==1){
								$remunerationRate = 'per annum';
							}
							else if($workDetail->remunerationRate==2){
								$remunerationRate = 'per month';
							}
							else if($workDetail->remunerationRate==3){
								$remunerationRate = 'per week';
							}
							else if($workDetail->remunerationRate==4){
								$remunerationRate = 'per hour';
							}
							echo $currency.$workDetail->remunerationRequired.' '.$remunerationRate;
							?>
						</span>
					</span>
				</li>
			<?php }
			if(!empty($workDetail->availability)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Prefered Type </span>
					<span class="fl width385">
						<span class="gray_bg"> 
							<?php echo $availability=($workDetail->availability =='freelance')?$this->lang->line('freelance'):($workDetail->availability=='fullTime'?$this->lang->line('fullTime'):($workDetail->availability=='partTime'?$this->lang->line('partTime'):($workDetail->availability=='casual'?$this->lang->line('casual'):'')));?>
						</span>
					</span>
				</li>
			<?php } 
			if(!empty($workDetail->minContractMonth) && !empty($workDetail->maxContractMonth) && $workDetail->isContractWork == 't') { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Available for Contract Work	</span>
					<span class="fl width385">	
						<span class="gray_bg">	From <?php echo $workDetail->minContractMonth;?> to <?php echo $workDetail->maxContractMonth;?> months</span>
					</span>
				</li>
			<?php }
			if(!empty($locationList)) { ?>
				<li>
					<span class="fl arialbold pt4 width_180">Prefered Locations	</span>		
					<span class="fl width385">
						<?php foreach($locationList as $location) { ?>
							<span class="gray_bg"><?php echo getWorkLocation($location->workLocationType,$location->locationId);?></span>
						<?php } ?>
					</span>
				</li>	
			<?php } ?>
		</ul>
	</div>
	<!--content_wrapper-->
