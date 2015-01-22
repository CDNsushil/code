<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="seprator_10"></div>
<?php
$isAnyItemBlocked=isAnyItemBlocked($usedContainer,true);
if($isAnyItemBlocked==true){
	$this->load->view('common/illegalMsg');
}
if($containerType != 'freeContainer'){?>
<div class="dast_container_outer pl5 pr5 pt0 pb0 dashfvslider" id="FVcontainerSlider">
	 <a class="buttons prev" href="#"></a>
	 <div class="viewport dashvf_container height_495">
		<ul class="overview"><?php
}
			$countUC = count($usedContainer);
			$currentDate = date("Y-m-d H:i:s");
			$edit_label = $this->lang->line('edit');
			foreach($usedContainer as $k=>$pkg){
				$isBlocked=$pkg->isBlocked;
				$redBorder3px=($isBlocked == 't')?'redBorder3px':'';
			
				$containerTitle=$pkg->title;
				$dirname=$dirUploadMedia;
				if(!empty($pkg->expiryDate) && $currentDate <= $pkg->expiryDate) {
					$expire_clr = 'clr_f1592a';
					$expire_label = $this->lang->line('toolExpires');
					$toolExpiredRenewed = '';
					$height_165 = '';
				} else {
					$expire_clr = 'clr_red';
					$expire_label = $this->lang->line('toolExpired');
					$toolExpiredRenewed = $this->lang->line('toolExpiredRenewed');
					$height_165 = 'height_165';
				}
				
				if($containerType != 'freeContainer'){
					
					if(isset($selectProjectType) || $pkg->pkgSections == '{16:1}'){
						if($pkg->work_type != '' && $pkg->work_type != null){
							$dirname=$dirname.$pkg->work_type.'/';
							$projectLink=$AdministrationSectionLink.'/'.$pkg->work_type;
							//create a link for edit dashboard page based on type
							$projectDashboardLink = $AdministrationSectionLink.'/'.$pkg->work_type.'/'.$pkg->elementId.'/description';
						}elseif(strstr($pkg->categoryid, "product") ) {
							$dirname=$dirname.$pkg->category.'/';
							$projectLink=$AdministrationSectionLink.'/'.$pkg->category;
							//create a link for edit dashboard page based on type
							$projectDashboardLink = $AdministrationSectionLink.'/'.$pkg->category.'/'.$pkg->elementId.'/description';
						}
						elseif($pkg->pkgSections == '{9:1}'){
							$projectLink=$AdministrationSectionLink.'/eventnotifications/notificationslist';
							//create a link for edit dashboard page based on type
							$projectDashboardLink = $AdministrationSectionLink.'/eventnotifications/eventform/'.$pkg->elementId;
							
						}
						elseif($pkg->pkgSections == '{9:2}'){
							$projectLink=$AdministrationSectionLink.'/events/eventdetail/'.$pkg->elementId;
							$projectDashboardLink = $AdministrationSectionLink.'/events/eventform/'.$pkg->elementId;
						}
						elseif($pkg->pkgSections == '{9:3}'){
							$projectLink=$AdministrationSectionLink.'/launch/launchdetail/'.$pkg->elementId;
							$projectDashboardLink = $AdministrationSectionLink.'/launch/launcheventform/'.$pkg->elementId;
						}
						elseif($pkg->pkgSections == '{9:4}'){
							
							$LaunchEventData=getDataFromTabel('LaunchEvent', 'LaunchEventId',  array('EventId'=>$pkg->elementId), '', '', '', 1 );
							if(isset($LaunchEventData[0]->LaunchEventId) && $LaunchEventData[0]->LaunchEventId >0){
								$dirUploadLaunch=$dirUploadLaunch.$LaunchEventData[0]->LaunchEventId;
							}
							
							$projectLink=$AdministrationSectionLink.'/eventwithlaunch/eventwithlaunchdetail/'.$pkg->elementId;
							$projectDashboardLink = $AdministrationSectionLink.'/eventwithlaunch/eventform/'.$pkg->elementId;		
						}
						elseif($pkg->pkgSections == '{16:1}'){
							
							$projectLink= base_url(lang().'/competition/competitionentrylist/'.$pkg->elementId);
							$projectDashboardLink =base_url(lang().'/competition/competitionentryedit/'.$pkg->elementId);
						}
						else{
							echo  $projectLink=$AdministrationSectionLink;	  
						}
					}else{
						
						$projectLink=$AdministrationSectionLink.'/'.$pkg->elementId;
						
					}
					
					if(isset($edit_dashboard_link) && isset($pkg->elementId)){
						//create a link for edit dashboard page based on type
						$projectDashboardLink = $edit_dashboard_link.'/'.$pkg->elementId;	
					}
					$title='<a class="font_opensansSBold font_size13 clr_444" href="'.$projectLink.'">'.$pkg->projectTitle.'</a>';
					
					if(isset($projectDashboardLink)){
						//Add Edit dashbord link
						$dashbordEditLink = '<div class="tds-button-top modifyBtnWrapper">
						<a class="formTip fr mr8" href="'.$projectDashboardLink.'" title="'.$edit_label.'">
						<div class="projectEditIcon width_20"></div>
						</a></div>';
					}
					$headingClass='org_anchor_hover';
					
					echo '<li class="'.$height_165.'">';
				}else{
					$headingClass='font_museoSlab font_size20 clr_D45730';
					if(isset($edit_dashboard_link)){
						
						//Add Edit dashbord link
						$dashbordEditLink = '<div class="tds-button-top modifyBtnWrapper"> 
						<a class="formTip fr mr8" href="'.$edit_dashboard_link.'" title="'.$edit_label.'">
						<div class="projectEditIcon width_20"></div>
						</a></div>';
						$title='<a class="font_museoSlab clr_D45730" href="'.$edit_dashboard_link.'">'.$pkg->title.'</a>';
					
						if((isset($edit_dashboard_type)) && ($edit_dashboard_type == 'showcase_dashboard')){
							$dashbordShowcaseEditLink = '<div class="tds-button-top modifyBtnWrapper"> 
							<a class="formTip fr mr8" href="'.$edit_dashboard_link.'" title="'.$edit_label.'">
							<div class="projectEditIcon width_20"></div>
							</a></div>';
						}
					}else{
						$title=$pkg->title;
					}
					echo '<div class="dast_container_outer pall5">';
				}
				
				$continerSize=(isset($pkg->containerSize) && $pkg->containerSize > 0)?$pkg->containerSize:$this->config->item('defaultContainerSize');
				
				$sectionArrayToDirect=array('{13}','{14}','{6,7,8}','{6}','{7}','{8}');
				
				if(!in_array($pkg->pkgSections,$sectionArrayToDirect)){
					$dirname=$dirname.$pkg->elementId;
				}
				
				$dirSize=getFolderSize($dirname);
				
				if(isset($dirUploadLaunch) && is_dir($dirUploadLaunch)){
					// in case of launch with event also get used size of associted launch
					$dirSize=($dirSize+getFolderSize($dirUploadLaunch));
				}
				
				if($dirSize >= $continerSize){
					$dirSize = $continerSize;
					$reminingSize = 0;
				}else{
					$reminingSize=($continerSize-$dirSize);
				}
				
				if($continerSize < 1073741824){
					$continerSize=bytestoMB($continerSize,'mb');
					$continerSizeString=number_format($continerSize,0).' '.$this->lang->line('mb');
					$usedSpaced=bytestoMB($dirSize,'mb');
					$usedSpacedString=number_format($usedSpaced,2).' '.$this->lang->line('mb');
					$reminingSize=bytestoMB($reminingSize,'mb');
					$reminingSizeString=number_format($reminingSize,2).' '.$this->lang->line('mb');
				}else{
					$continerSize=bytestoMB($continerSize,'gb');
					$continerSizeString=number_format($continerSize,0).' '.$this->lang->line('gb');
					$usedSpaced=bytestoMB($dirSize,'gb');
					$usedSpacedString=number_format($usedSpaced,2).' '.$this->lang->line('gb');
					$reminingSize=bytestoMB($reminingSize,'gb');
					$reminingSizeString=number_format($reminingSize,2).' '.$this->lang->line('gb');
				}
				
				?>
				<div class="Members-Buy-Tools_shedow mt0 pr15 ml0">
					<div class="dash_Atool_list_box min_h142 ml5 <?php echo $redBorder3px;?>">
						<div class="dash_headgrad pt7 pb8 pl20 <?php echo $headingClass;?>">
						<?php echo html_entity_decode($title);
						if(isset($dashbordEditLink) && ($isBlocked != 't') && ($currentDate <= $pkg->expiryDate || empty($pkg->expiryDate)))echo $dashbordEditLink ? $dashbordEditLink:'';
						elseif((isset($dashbordShowcaseEditLink)) && ($edit_dashboard_type == 'showcase_dashboard'))echo $dashbordShowcaseEditLink ? $dashbordShowcaseEditLink:'';
						
						?>
						</div>
						<div class="seprator_15"></div>
						<div class="pl20 pr5">
							<div class="row"> 
								<div class="fl width_73 text_alignR font_opensans font_size12 clr_555"><?php echo $this->lang->line('FirstSaved');?></div>
								<div class="fl width_130 font_opensansSBold font_size12 clr_555 ml15"><?php echo dateFormatView($pkg->startDate,'d F Y');?></div>
								<div class="fl width_80 font_opensans font_size12 clr_555 ml10"><?php echo $this->lang->line('used');?></div>
								<div class="fl width_73 font_opensansSBold font_size12 clr_555 ml10"><?php echo $usedSpacedString;?></div>
								<div class="clear"></div>
							</div>
							<div class="seprator_3"></div>
							<div class="row"> 
								<div class="fl width_73 text_alignR font_opensans font_size12 clr_555">
									<?php  if($pkg->expiryDate != null && $pkg->expiryDate != '') echo $expire_label; else echo '&nbsp;';?>
								</div>
								<div class="fl width_130 font_opensansSBold font_size12 ml15 <?php echo $expire_clr;?>">
									<?php  if($pkg->expiryDate != null && $pkg->expiryDate != '') echo dateFormatView($pkg->expiryDate,'d F Y'); else echo '&nbsp;';?>
								</div>
								<div class="fl width_80 font_opensans font_size12 clr_555 ml10"><?php echo $this->lang->line('free');?></div>
								<div class="fl width_73 font_opensansSBold font_size12 clr_555 ml10"><?php echo $reminingSizeString;?></div>
								<div class="clear"></div>
							</div>
							<div class="seprator_16"></div>
							<div class="row">
								
								<?php  
								if(isset($selectProjectType)){
									$type='';
									if($pkg->work_type != '' && $pkg->work_type != null){
										$type='work'.$pkg->work_type;
										if($pkg->is_experience_work=='t'){
											$type = 'experience'.$type;
										}
										if($pkg->is_urgent_work=='t'){
											$type = 'urgent'.$type;
										}
									}
									elseif( strstr($pkg->categoryid, "product_") ) {
										$type = 'products'.$pkg->category;
									}
									elseif($pkg->pkgSections == '{9:1}'){
										$type = 'eventNotification';
									}
									elseif($pkg->pkgSections == '{9:2}'){
										$type = 'event';
									}
									elseif($pkg->pkgSections == '{9:3}'){
										$type = 'launch';
									}
									elseif($pkg->pkgSections == '{9:4}'){
										$type = 'eventwithLaunch';
									}
									$type=$this->lang->line($type);
									$mt=(strlen($type) > 20)?'mt3':'mt5';
									?>
									<div class="fl font_museoSlab font_size17 clr_D45730 ml5 wordWrap width_216 lineH20 <?php echo $mt;?>"><?php echo $type;?></div>
									<?php
								}
								
								if($pkg->userContainerId>0){
								   $pkgContainerId = $pkg->userContainerId;							
								} else {								
								   $pkgContainerId ='';
								}

								
								
								if($pkg->expiryDate != null && $pkg->expiryDate != '' && !isset($renewNotRequired)){?>
									<div class="tds-button fr"> <a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" href="<?php echo base_url(lang().'/membershipcart/renewCart/'.$pkgContainerId);?>"><span class="font_size12 font_opensansSBold width_63 dash_link_hover" ><?php echo $this->lang->line('Renew');?></span></a> </div>
									<?php
								}?>
							
								
								<div class="tds-button fr mr5"> <a href="<?php echo base_url(lang().'/membershipcart/addspace/'.$pkgContainerId);?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_63 dash_link_hover" ><?php echo $this->lang->line('addSpace');?></span></a> </div>								
								<!--<div class="tds-button fr mr5"> <a href="javascript:void:none" class="comingSoon" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" style="background-position: 0px -38px;"><span class="font_size12 font_opensansSBold width_63" style="background-position: right -38px;"><?php //echo $this->lang->line('addSpace');?></span></a> </div>-->		
								<?php if(!empty($toolExpiredRenewed) && !empty($pkg->expiryDate)) {?>
									<div class="row ml5 font_opensans font_size11"><?php echo $toolExpiredRenewed;?></div>
									<div class="clear"></div>
								<?php }?>
							</div>
						</div>
					</div>  
				</div>
				
				<?php
				if($containerType != 'freeContainer'){
					echo '</li>';
				}
				else{
					//
					if(isset($containermultiType) && !empty($containermultiType) && $section=='Showcase Homepage'){
						echo '<div class="seprator_20"></div>';
						$this->load->view('multilangualContainer', array('userShowcaseMultiLang'=>$userShowcaseMultiLang));
					}
					echo '</div><div class="clear"> </div>';
				
					
					
					if($countUC < ($k+1)){
						echo '<div class="seprator_14"></div>';
					}
				}
			}
if($containerType != 'freeContainer'){
			?>
		</ul>
	</div>
	<a class="buttons next" href="#"></a>
</div>

	<?php
}
?>
<script type="text/javascript">
	/*tab function*/
	$(document).ready(function(){
		if($('#FVcontainerSlider'))	
		$('#FVcontainerSlider').tinycarousel({ axis: 'y', display: 3});	
	});
</script>

