<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	// Workprofile left content area
	$this->load->view('new_version/workprofile_left');?>
	
	<div class="fl  right_box">
		<ul class="port_nav fr pt10 open_sans">
			<?php if( isset($refrences) && !empty($refrences) ) { ?>
				<li id="referenceLi" class="active"><a onclick="manageRefNRec(1)">References</a></li>
			<?php } ?>
			<li id="recommendationLi" class="" ><a onclick="manageRefNRec(2)">Recommendations</a></li>
		</ul>
		<div class="sap_25"></div>
		<!-- References details right content area-->
		<div class="right_profile fl" id="referenceDiv">
			<!-- References Detail Box-->
			<h3 class="fs18 red lineH14"> References </h3>
			<?php 
			if(isset($refrences) && !empty($refrences) ) {
				foreach($refrences as $ref) { ?>
					<div class="sap_45"></div>
					<div class="clearbox bc2c2c2 open_sans pt15  mb15 pl33 pr30">
						<ul class="listpb15">
							<li>    
								<span class="width_180 fl"><?php echo $this->lang->line('name');?></span>    
								<span class="font_bold">
									<?php 
									$refFName = (!empty($ref->refFName)) ? $ref->refFName : '';
									$refLName = (!empty($ref->refLName)) ? $ref->refLName : '';
									echo $refFName .' '. $refLName; ?>
								</span>
							</li>
							<?php if(!empty($ref->refCompName) || !empty($ref->refEmail) || !empty($ref->refContact)) { ?>
								<li>
									<span class="width_180 fl"> Company</span>
									<span class="p_b8" > 
										<?php 
										if(!empty($ref->refCompName)) {?>
											<p class="red"><?php echo $ref->refCompName;?></p>	
										<?php } 
										if(!empty($ref->refEmail)) { ?>	
											<p><?php echo $ref->refEmail;?></p>
										<?php } 
										if(!empty($ref->refContact)) { ?>
											<p><?php echo '+'.$ref->refContact;?></p>
										<?php } ?>	
									 </span>
								 </li>
							 <?php } ?>
						</ul>
					</div>
				<?php 
				}
			}?>
			<div class="sap_50"></div>
		</div>
	
		<!-- Recommendations details right content area-->
		<div class="right_profile fl dn" id="recommendationDiv">
			<h3 class="fs18 red lineH14">Recommendations from Toadsquare members</h3>
			<?php  
			if(isset($recomends) && !empty($recomends) ) {  			  
				foreach($recomends as $recomend) {
					// set user's showcase url
					$showcaseUrl = '/showcase/index/'.$recomend->tdsUid;
					// get showcase details
					$getUserShowcase = showCaseUserDetails($recomend->tdsUid);
					// set user's profile image
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
					if($getUserShowcase['userImage']!='') {
						 $userImage=$getUserShowcase['userImage'];
					}
					$userImage=addThumbFolder($userImage,$suffix='_m',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
					?>
					<div class="sap_45"></div>
					<div class="clearbox ptr" onclick="gotourl('<?php echo $showcaseUrl;?>')">
						<div class="profile_box fl">
							<div class="about_profile width166 text_alignC pr15 fl">
								<div class="pro_img ">
									<img src="<?php echo $userImage; ?>">
								</div>
								<h4 class=" condenser_light   mt10 fs20">
								 <?php if(isset($recomend->firstName)) echo $recomend->firstName .' '.$recomend->lastName; ?>
								</h4>
							</div>
						</div>
						<div class="width357 tab_cnt  heightauto open_sans fl pl25 ">
						<p class="lineH23 mt-4"> 
							<?php if(isset($recomend->recommendations)) echo $recomend->recommendations; ?>
						</p>
						<span class="red pt5"><?php echo dateFormatView($recomend->created_date,'F Y') ?></span>
					</div>
				</div>  
			<?php 
			}
		} ?>	
	</div>
</div>	
    <!--content_wrapper-->
    <script>
		// Manage References or Recommendations box availability
		function manageRefNRec(sectionType) {
			if(sectionType == 1) {
				$('#referenceDiv').show();
				$('#recommendationDiv').hide();
				$('#referenceLi').addClass('active');
				$('#recommendationLi').removeClass('active');
			} else {
				$('#referenceDiv').hide();
				$('#recommendationDiv').show();
				$('#referenceLi').removeClass('active');
				$('#recommendationLi').addClass('active');
			}
		}
    </script>
