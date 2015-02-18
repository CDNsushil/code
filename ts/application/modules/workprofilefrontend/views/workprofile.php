<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$accessUserProfile = (isset($accessUserProfile) && ($accessUserProfile!='')) ? $accessUserProfile :''; ?>
    
			<div class="content_wrapper_front">
				<div class="seprator_9"></div>
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td valign="top" class="left_coloumn_profile">							
								<?php 
								  $buttonArray['accessUserProfile'] = $accessUserProfile; 
								  $this->load->view('portfolio_common_button',$buttonArray); 
								?>						
							</td>
							
							<td valign="top" class="right_coloumn_profile rc_black_profile" >	
								<div class="position_relative">
									<div class="strip_absolute_right_profile">
										<!-- <img src="images/strip_blog.png"  border="0"/>-->
										<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
												<tr>
													<td height="66px">&nbsp;</td>
												</tr>
												<tr>
													<td class="dot_mid">&nbsp;</td>
												</tr>
												<tr>
													<td height="30px">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
									
									<div class="orange_strip"></div>
									<div class="seprator_62"></div>
									
									<div class="row">
										<div class="cell width_243 font_opensans pb20 break_word">
											<div class="font_size18 text_alignR pr32 pb18 mt_minus4">
											 <?php 
											
												 if(isset($workDetail->profileFName) && isset($workDetail->profileLName)) 
												 {
													echo $workDetail->profileFName .' '.$workDetail->profileLName; 
												 }
													
												 $mediaDetail = getMediaDetail($workDetail->fileId);
												 if(is_array($mediaDetail) && !empty($mediaDetail))
												 {
													$profileImgPath = $mediaDetail[0]->filePath;
													$profileImgName = $mediaDetail[0]->fileName;
												 }
												 else
												 {
													$profileImgPath = '';
													$profileImgName = '';
												 }
													
												$workProfileThumbImage = addThumbFolder(@$profileImgPath.$profileImgName,'_s');														
												$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" class="bdr_white max_h170_w172 left_colum_thumb" />';												   
												
											?>
											</div>
											<div class="pr32 fRight">
												<?php echo $workProfileSrc; ?>
											</div>	
																						
											<div class="seprator_20 clear"></div>
											<div class="seprator_40"></div>
											<div class="pr32 clr_898989 text_alignR font_size13">
												<?php if(isset($workDetail->profileAdd) && (trim($workDetail->profileAdd)!='')) echo $workDetail->profileAdd.'<br/>'; ?>
												<?php if(isset($workDetail->profileStreet) && (trim($workDetail->profileStreet)!=''))  echo $workDetail->profileStreet.'<br/>'; ?>
												<?php if(isset($workDetail->profileCity) && (trim($workDetail->profileCity)!=''))  echo $workDetail->profileCity.'<br/>'; ?>
												<?php if(isset($workDetail->profileState) && (trim($workDetail->profileState)!=''))  echo $workDetail->profileState.'<br/>'; ?>
												<?php if(isset($workDetail->profileZip) && (trim($workDetail->profileZip)!=''))  echo $workDetail->profileZip.'<br/>'; ?>
												<?php if(isset($workDetail->profileCountry) && ($workDetail->profileCountry!='')) echo getCountry($workDetail->profileCountry)?>
												<div class="seprator_25"></div>
												<?php if(isset($workDetail->profilePhone) && ($workDetail->profilePhone!='')) echo '+'.$workDetail->profilePhone ?><br />
												<?php if(isset($workDetail->profileEmail) && ($workDetail->profileEmail!='')) echo $workDetail->profileEmail ?> </div>
										  </div>
										<div class="cell">
										<!--box01-->
										<div class="width_506 pl25">
										<!-- Summary Box-->
										<?php if(!empty($workDetail->synopsis)) { ?>
										<div class="pb50">
										<div class="orange_clr_imp font_opensans font_size18 mt_minus4"><?php echo $this->lang->line('summary');?></div>
										<p class="pt20"><?php echo $workDetail->synopsis;?> </p>
										</div>
										<?php }?>
										<!-- Persnol Detail Box-->

										<?php if($workDetail->languagesKnown !='' || $workDetail->nationality !='' || $workDetail->visaAvailable !='' || $workDetail->availability!='' || $workDetail->noticePeriod !='' || $workDetail->remunerationRequired!=''){ ?>
										<div class="pb50">
										<div class="orange_clr_imp font_opensans font_size18 mt_minus4"><?php echo $this->lang->line('personalDetails');?></div>
										<div class="pt20">
										<?php if(!empty($workDetail->availability)) { ?>
										<div class="row">
										<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('availability');?></div>
										<div class="cell font_opensans font_size13"><?php //echo $workDetail->availability;
										echo $availability=($workDetail->availability =='freelance')?$this->lang->line('freelance'):($workDetail->availability=='fullTime'?$this->lang->line('fullTime'):($workDetail->availability=='partTime'?$this->lang->line('partTime'):($workDetail->availability=='casual'?$this->lang->line('casual'):'')));
										?></div>
										<div class="clear"></div>
										</div>
										<?php if(!empty($workDetail->minContractMonth) && !empty($workDetail->maxContractMonth) && $workDetail->isContractWork=='t') { ?>
										<div class="row">
											<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('interestedContractWork');?></div>
											<div class="cell font_opensans font_size13"><?php echo 'From '.$workDetail->minContractMonth .' to '. $workDetail->maxContractMonth .'  months';?></div>
											<div class="clear"></div>
										</div>
                                        <?php } }?>
                                        <?php if(!empty($workDetail->noticePeriod)) { ?>
										<div class="row">
										<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('noticePeriod');?></div>
										<div class="cell font_opensans font_size13"><?php echo $workDetail->noticePeriod ?></div>
										<div class="clear"></div>
										</div>
										<?php }?>
										
										 <?php 
										 
										 $workDetail->remunerationRequired='';
										 if(!empty($workDetail->remunerationRequired)) { ?>
										<div class="row">
										<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('remuneration');?></div>
										<div class="cell font_opensans font_size13">

										<?php //echo $workDetail->remunerationRequired.' per annum.' 
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
											if(isset($workDetail->remunerationRequired) && $workDetail->remunerationRequired!='')
											echo $workDetail->remunerationRequired.' '.$remunerationRate;
											//else echo 'N/A';
										?>
										</div>

										<div class="clear"></div>
										</div>
										<div class="seprator_10"></div>  
										<?php }?>
										
										
										<?php if(!empty($workDetail->languagesKnown)) { ?>
										<div class="row">
										<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('languages');?></div>
										<div class="cell font_opensans font_size13"><?php echo $workDetail->languagesKnown ?></div>
										<div class="clear"></div>
										</div>
										<?php }?>
										
										<?php if(!empty($workDetail->nationality)) { ?>
										<div class="row">
										<div class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('nationality');?></div>
										<div class="cell font_opensans font_size13"><?php echo $workDetail->nationality ?></div>
										<div class="clear"></div>
										</div>
										<?php }?>
										
										<?php if(!empty($WorkProfileVisa) && is_array($WorkProfileVisa)) { ?>
										<div class="row">      
										<span class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('visas');?></span>
										<span class="cell font_opensans font_size13"><?php if(!empty($WorkProfileVisa) && is_array($WorkProfileVisa)){
												
										echo "<ul>";
										foreach($WorkProfileVisa  as $visaTypeData)
										{
										//print_r($visaTypeData);
										echo '<li>'.$visaTypeData->visaType.', &nbsp'.getCountry($visaTypeData->countryId)."</li>";
										}
										echo "</ul>";
										}else
										{ echo "N/A";}?></span>

										</div>     
										<?php }?>
										<?php if(!empty($InterestedCountry) && is_array($InterestedCountry)) { ?>	
											<div class="row">	
												<span class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('countryIntrestedwork');?></span>	
												<span class="cell font_opensans font_size13">
													<?php																			
													for($i=0;$i<count($InterestedCountry);$i++){
														if($i!=0) {
															if($i==1) {
																echo getCountry($InterestedCountry[$i]);
															} else {
																echo ', '.getCountry($InterestedCountry[$i]);
															}
														}
													}
													?>
												</span>	
											</div>		 
										<?php } else { ?>	
										<div class="row">	
												<span class="cell clr_888888 width160px font_opensansSBold font_size13"><?php echo $this->lang->line('countryIntrestedwork');?></span>	
												<?php echo $this->lang->line('allCountrywork');?>
												<span class="cell font_opensans font_size13">
											
												</span>	
											</div>
										<?php }?>				
</div>
</div>

										
<?php } //end if for personal detail ?>
										<!-- Education Detail Box-->
										<?php if(!empty($education)){ ?>
										<div class="pb50">
										<div class="row font_opensans font_size13 pt15 lineH16">
											</div>
										<div class="orange_clr_imp font_opensans font_size18 mt_minus4"><?php echo $this->lang->line('education');?></div>
										<p class="pt20"></p>
										<?php foreach ($education as $edu) {   ?>
										<div class="row pb10">
										<div class="cell width160px"><?php echo $edu->year_from .' - '.$edu->year_to ?></div>
										<div class="cell width_333"><?php echo $edu->degree .' - '.$edu->university ?></div>
										<div class="clear"></div>
										</div>
										<?php } ?>
										</div>
										<?php }?>									
										<!-- Achievements $ Awards Box-->
										<?php if(!empty($workDetail->achievmentsAndAwards)){ ?>
										<div class="pb50">
										<div class="orange_clr_imp font_opensans font_size18 mt_minus4"><?php echo $this->lang->line('achievmentsAndAwards');?></div>
										<div class="pt20 NIC">

										<?php echo $workDetail->achievmentsAndAwards; ?>

										</div>
										</div>
										<?php }?>	
										</div>
										</div>
										<div class="clear"></div>
								</div>
								<div class="seprator_10"></div>
								</div>


							</td>
						</tr>
					</table>
				<div class="seprator_5"></div>
			</div>
			<!--content_wrapper-->

