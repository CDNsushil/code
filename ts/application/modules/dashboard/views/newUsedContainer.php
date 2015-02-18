<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="seprator_10"></div>
<?php
$isAnyItemBlocked=isAnyItemBlocked($usedContainer,true);
if($isAnyItemBlocked==true){
	$this->load->view('common/illegalMsg');
}
if($containerType != 'freeContainer'){?>
<div id="FVcontainerSlider" class="pl5 pr5 pt0 pb0 dashfvslider position_relative">
    <a href="#" class="buttons prev position_absolute right0 z_index_3 disable"></a>
    <div class="viewport dashvf_container sufordash_slider height450">
        <ul class="overview" style="height: 900px; top: 0px;">
<?php
}
	$countUC = count($usedContainer);
	$currentDate = date("Y-m-d H:i:s");
	$edit_label = $this->lang->line('edit');
	if(!isset($viewLabel)) {
		$viewLabel = $this->lang->line('preview');
	}
	//echo "<pre>";
	//print_r($usedContainer);die;
	foreach($usedContainer as $k=>$pkg){
		//echo "<pre>";
		//print_r($pkg);
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
					$dashbordAddLink = '';
					$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
					if($projectData[0]->isPublished=='t') {
						$previewSectionLink = base_url(lang().'/eventfrontend/eventnotification/'.$pkg->tdsUid.'/'.$pkg->elementId);
						$viewLabel = $this->lang->line('view');
					}else{
						$previewSectionLink = base_url(lang().'/eventfrontend/preview/'.$pkg->tdsUid.'/'.$pkg->elementId.'/eventnotification');
						$viewLabel = $this->lang->line('preview');
					}
				}
				elseif($pkg->pkgSections == '{9:2}'){
					$projectLink=$AdministrationSectionLink.'/events/eventdetail/'.$pkg->elementId;
					$projectDashboardLink = $AdministrationSectionLink.'/events/eventform/'.$pkg->elementId;
					
					$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
					if($projectData[0]->isPublished=='t') {
						$previewSectionLink = base_url(lang().'/eventfrontend/event/'.$pkg->tdsUid.'/'.$pkg->elementId);
						$viewLabel = $this->lang->line('view');
					}else{
						$previewSectionLink = base_url(lang().'/eventfrontend/preview/'.$pkg->tdsUid.'/'.$pkg->elementId.'/event');
						$viewLabel = $this->lang->line('preview');
					}
				}
				elseif($pkg->pkgSections == '{9:3}'){
					$projectLink=$AdministrationSectionLink.'/launch/launchdetail/'.$pkg->elementId;
					$projectDashboardLink = $AdministrationSectionLink.'/launch/launcheventform/'.$pkg->elementId;
					$dashbordAddLink = '';
					$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
					if($projectData[0]->isPublished=='t') {
						$previewSectionLink = base_url(lang().'/eventfrontend/eventlaunch/'.$pkg->tdsUid.'/'.$pkg->elementId);
						$viewLabel = $this->lang->line('view');
					}else{
						$previewSectionLink = base_url(lang().'/eventfrontend/preview/'.$pkg->tdsUid.'/'.$pkg->elementId.'/eventlaunch');
						$viewLabel = $this->lang->line('preview');
					}
				}
				elseif($pkg->pkgSections == '{9:4}'){
					
					$LaunchEventData=getDataFromTabel('LaunchEvent', 'LaunchEventId',  array('EventId'=>$pkg->elementId), '', '', '', 1 );
					if(isset($LaunchEventData[0]->LaunchEventId) && $LaunchEventData[0]->LaunchEventId >0){
						$dirUploadLaunch=$dirUploadLaunch.$LaunchEventData[0]->LaunchEventId;
					}
					
					$projectLink=$AdministrationSectionLink.'/eventwithlaunch/eventwithlaunchdetail/'.$pkg->elementId;
					$projectDashboardLink = $AdministrationSectionLink.'/eventwithlaunch/eventform/'.$pkg->elementId;	
					$dashbordAddLink = '';	
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
			
			$title='<a class="font_opensansSBold font_size13 clr_444" href="'.$projectLink.'">'.getSubString($pkg->projectTitle,55).'</a>';
			
			if(isset($projectDashboardLink)){
				if($pkg->entityId==9 && $pkg->pkgSections=='{9:2}') {
					$dashbordAddLink = base_url(lang().'/event/events/eventsession/'.$pkg->elementId);
				}
				//Add Edit dashbord link
				$dashbordEditLink = '<div class="fr mr3 tt"><div class="tds-button-top modifyBtnWrapper">
				<a class="formTip fr" href="'.$projectDashboardLink.'" title="'.$edit_label.'">
				<div class="projectEditIcon width_20"></div>
				</a></div></div>';
			}
			$headingClass='org_anchor_hover';
			
			//echo '<li class="'.$height_165.'">';
			echo '<li>';
		}else{
			$headingClass='font_museoSlab font_size20 clr_D45730';
			if(isset($edit_dashboard_link)){

				//Add Edit dashbord link
				$dashbordEditLink = '<div class="fr mr3"><div class="tds-button-top modifyBtnWrapper"> 
				<a class="formTip fr" href="'.$edit_dashboard_link.'" title="'.$edit_label.'">
				<div class="projectEditIcon width_20"></div>
				</a></div></div>';
				$title='<a class="font_museoSlab clr_D45730" href="'.$edit_dashboard_link.'">'.$pkg->title.'</a>';
			
				if((isset($edit_dashboard_type)) && ($edit_dashboard_type == 'showcase_dashboard')){
					$dashbordShowcaseEditLink = '<div class="fr mr3"><div class="tds-button-top modifyBtnWrapper"> 
					<a class="formTip fr" href="'.$edit_dashboard_link.'" title="'.$edit_label.'">
					<div class="projectEditIcon width_20"></div>
					</a></div></div>';
					$previewSectionLink = $showcaseSectionLink;
				}
			}else{
				$title=$pkg->title;
			}
			echo '<div class="">';
		}
		//Manage preview url
		if($pkg->pkgSections=='{17}' && isset($pkg->elementId)) {
			$previewSectionLink = $previewSectionLink.'/'.$pkg->elementId;
		}
		
		if(isset($pkg->entityId) && !empty($pkg->entityId) && isset($pkg->elementId)) {
		switch($pkg->pkgSections) {
			case '{1}':
			case '{2}':
			case '{3}':
			case '{4}':
			case '{5}':
			case '{10}':
				$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
				$dashbordAddLink = base_url(lang().'/media/'.$mediaAddSection.'/editProject/uploadMedia/'.$pkg->elementId);
				if($projectData[0]->isPublished=='t') {
					$previewSectionLink = base_url(lang().'/mediafrontend/'.$mediaSection.'/'.$pkg->tdsUid.'/'.$pkg->elementId);
					$viewLabel = $this->lang->line('view');
				}else{
					$previewSectionLink = base_url(lang().'/mediafrontend/preview/'.$pkg->tdsUid.'/'.$pkg->elementId.'/'.$mediaSection);
					$viewLabel = $this->lang->line('preview');
				}
				break;
			case '{11}':
				$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
				if($projectData[0]->isPublished=='t') {
					$previewSectionLink = base_url(lang().'/workshowcase/works/'.$pkg->tdsUid.'/'.$pkg->elementId);
					$viewLabel = $this->lang->line('view');
				}else{
					$previewSectionLink = base_url(lang().'/workshowcase/preview/'.$pkg->tdsUid.'/'.$pkg->elementId);
					$viewLabel = $this->lang->line('preview');
				}
			break;	
			case '{12:1}':
			case '{12:3}':
				$projectData = getProjectDataStatus($pkg->entityId,$pkg->elementId,$pkg->tdsUid);
				if($projectData[0]->isPublished=='t') {
					$previewSectionLink = base_url(lang().'/productshowcase/products/'.$pkg->tdsUid.'/'.$pkg->elementId);
					$viewLabel = $this->lang->line('view');
				}else{
					$previewSectionLink = base_url(lang().'/productshowcase/preview/'.$pkg->tdsUid.'/'.$pkg->elementId);
					$viewLabel = $this->lang->line('preview');
				}
			break;
			default:
				$projectData = '';
			}
		}
		
		//echo $pkg->pkgSections;
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
        	<div class="dash_headgrad font_opensansSBold font_size13 clr_444 pt7 pb8 pl20 <?php echo $headingClass;?>">
				<?php echo html_entity_decode($title);
				
				if($isBlocked != 't' && ($currentDate <= $pkg->expiryDate || empty($pkg->expiryDate))) {
					
					if((isset($dashbordShowcaseEditLink) || isset($dashbordEditLink)) && !empty($previewSectionLink)) { ?>   
					<div class="fr mr8">
						<div class="tds-button-top modifyBtnWrapper"> 
						<a original-title="<?php echo $viewLabel;?>" class="formTip fr ml2" href="<?php echo $previewSectionLink;?>">
						<div class="projectPreviewIcon"></div>
						</a></div>
					</div>
					<?php }
					
					if(isset($dashbordEditLink))echo $dashbordEditLink ? $dashbordEditLink:'';
					elseif((isset($dashbordShowcaseEditLink)) && ($edit_dashboard_type == 'showcase_dashboard'))echo $dashbordShowcaseEditLink ? $dashbordShowcaseEditLink:'';
					
					if(isset($dashbordAddLink) && !empty($dashbordAddLink)) { ?>  
					<div class="fr">
						<div class="tds-button-top modifyBtnWrapper"> 
						<a original-title="Add" class="formTip fr ml2" href="<?php echo $dashbordAddLink;?>">
						<div class="projectAddIcon"></div>
						</a></div>
					</div>    
					<?php 
					}				
				}?>       
            </div>
           
        <div class="seprator_5"></div>
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
            <div class="fl width_73 text_alignR font_opensans font_size12 clr_555"> <?php  if($pkg->expiryDate != null && $pkg->expiryDate != '') echo $expire_label; else echo '&nbsp;';?></div>
            <div class="fl width_130 font_opensansSBold font_size12 clr_f1592a ml15 <?php echo $expire_clr;?>"> <?php  if($pkg->expiryDate != null && $pkg->expiryDate != '') echo dateFormatView($pkg->expiryDate,'d F Y'); else echo '&nbsp;';?></div>
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
				<div class="tds-button fr mr5"> <a href="<?php echo base_url(lang().'/membershipcart/addspace/'.$pkgContainerId);?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_65 dash_link_hover" ><?php echo $this->lang->line('addSpace');?></span></a> </div>
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
			if(isset($containermultiType) && !empty($containermultiType) && $section=='Showcase Homepage'){
				echo '<div class="seprator_20"></div>';
				$this->load->view('multilangualContainer', array('userShowcaseMultiLang'=>$userShowcaseMultiLang));
			}
			echo '</div><div class="clear"> </div>';
			if($countUC < ($k+1)){
				echo '<div class="seprator_20"></div>';
			}
		}
	}
	if($containerType != 'freeContainer'){ ?>
	</ul>
	</div>
	<a class="buttons next mr-2" href="#"></a>
</div>
	<?php } ?>
<script type="text/javascript">
	/*tab function*/
	$(document).ready(function(){
		if($('#FVcontainerSlider'))	
		$('#FVcontainerSlider').tinycarousel({ axis: 'y', display: 3});	
	});
</script>
