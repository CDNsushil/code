<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$sectionId=isset($sectionId)?$sectionId:0;
$formNameId=str_replace(':','_',$sectionId);
$section=(isset($section)?$section:$this->lang->line('section'.$formNameId));
$sectionImage=isset($sectionImage)?$sectionImage:$this->config->item('sectionIdImage'.$formNameId);
$edit_label = $this->lang->line('edit');
if(isset($edit_dashboard_link) && isset($containers[0]->elementId) && $containers[0]->elementId > 0){
	if(isset($viewLabel) && !empty($viewLabel)) {
		$viewLabel = $viewLabel;
	}else{
		$viewLabel = $this->lang->line('view');
	}
	//Add Edit dashbord link
	$dashbordEditLink = '<div class="tds-button-top modifyBtnWrapper">
	<a class="formTip fr mr8" href="'.$edit_dashboard_link.'" title="'.$edit_label.'">
	<div class="projectEditIcon width_20"></div>
	</a></div>';
	$section = '<a class="font_museoSlab clr_D45730" href="'.$edit_dashboard_link.'">'.$section.'</a>';
	if(!empty($showcaseSectionLink) && ($sectionId==13 || (isset($isProjectPublished) && $isProjectPublished=='t'))) {
		$showcasePreview = 	'<div class="fr">
					<div class="tds-button-top modifyBtnWrapper"> 
					<a original-title="'.$viewLabel.'" class="formTip fr ml2" href="'.$showcaseSectionLink.'">
					<div class="projectPreviewIcon"></div>
					</a></div>
				</div>';
	}
	if(isset($newElementUrl) && !empty($newElementUrl)) {
		$addNewElement = 	'<div class="fr mr3">
					<div class="tds-button-top modifyBtnWrapper"> 
					<a original-title="Add" class="formTip fr ml2" href="'.$newElementUrl.'">
					<div class="projectAddIcon"></div>
					</a></div>
				</div>';
	}
	
}else{
	
	if(isset($edit_dashboard_container_link) && isset($containers[0]->elementId) && $containers[0]->elementId > 0){
		if(isset($dashboardCollection) && !empty($dashboardCollection)){
			$edit_container_link = $edit_dashboard_container_link.'/'.$containers[0]->elementId;
		}else{
			$edit_container_link = $edit_dashboard_container_link;
		}
		$dashbordEditLink = '<div class="tds-button-top modifyBtnWrapper">
		<a class="formTip fr mr8" href="'.$edit_container_link.'" title="'.$edit_label.'">
		<div class="projectEditIcon width_20"></div>
		</a></div>';
	}
	$section = $section;
}
if(isset($submitBtnclass) && !empty($submitBtnclass)) {
	$submitBtnclass = $submitBtnclass;
}else{
	$submitBtnclass='';
}
?>
<!--<div class="dast_container_outer pall0">-->
	<div>
	<div class="dash_boxgradient min_h142">
		<div class="dash_Atool_leftbox heightAuto width_100 pt17 pb17 fl mt8">
			<div class=" height_112">
				<div class="AI_table">
					<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/'.$sectionImage);?>" alt="News" class="bdr_white max_w81_h128 dashbox-shedow"> </div>
				</div>
			</div>
		</div>
		<div class="dash_headgrad pt7 pb8 pl145"><samp class="font_museoSlab font_size20 pl-2 ml34 clr_D45730">
			<?php echo $section;
			if(isset($dashbordEditLink))echo $dashbordEditLink ? $dashbordEditLink:'';
			if(isset($showcasePreview))echo $showcasePreview ? $showcasePreview:'';
			if(isset($addNewElement))echo $addNewElement ? $addNewElement:'';?></samp></div>
		
		<div class="seprator_15"></div>
		<div class="pl20 pr20">         
			<div class="dash_Atool_text pl0 pb5 pr2 fl ml160 min_height64">
				<?php 
				if(isset($containers[0])){
				$formAttributes = array(
					'name'=>'selectContainerFrom'.$formNameId,
					'id'=>'selectContainerFrom'.$formNameId
				);
				echo form_open($formSubmitUrl,$formAttributes);
					$i=0;
					
					//foreach($containers as $k=>$pkg){
						$pkg=$containers[0];
						if(!isset($sectionId)) {
							$sectionId = '';
						}
						
						$dirname=$dirUploadMedia;
						$dirname=$dirname.$pkg->elementId;
						$dirSize=getFolderSize($dirname);
						if($dirSize >= $pkg->containerSize){
							$dirSize = $pkg->containerSize;
							$reminingSize = 0;
						}else{
							$reminingSize=($pkg->containerSize-$dirSize);
						}
						
						$i++;
						$userContainerId=isset($pkg->userContainerId)?$pkg->userContainerId:0;
						$containerTitle=$pkg->title;
						$selected=($i==1)?'checked':'';
						if($pkg->containerSize < 1073741824){
							$size=bytestoMB($pkg->containerSize,'mb');
							$size=number_format($size,0);
							$sizeString=number_format($size,0).' '.$this->lang->line('mb');
							
							$usedSpaced=bytestoMB($dirSize,'mb');
							$usedSpacedString=number_format($usedSpaced,2).' '.$this->lang->line('mb');
							$reminingSize=bytestoMB($reminingSize,'mb');
							$reminingSizeString=number_format($reminingSize,2).' '.$this->lang->line('mb');
						}else{
							$size=bytestoMB($pkg->containerSize,'gb');
							$size=number_format($size,0);
							$sizeString=number_format($size,0).' '.$this->lang->line('gb');
							
							$usedSpaced=bytestoMB($dirSize,'gb');
							$usedSpacedString=number_format($usedSpaced,2).' '.$this->lang->line('gb');
							$reminingSize=bytestoMB($reminingSize,'gb');
							$reminingSizeString=number_format($reminingSize,2).' '.$this->lang->line('gb');
						}
				
						?>
						<div class="fl width_240 minH66">
							<div class="row">
								
								<?php if($pkg->pkgSections!='{3:1}' && $pkg->pkgSections!='{3:2}' && $sectionId!='12:3' && $sectionId!='9:1') {?>
								<div class="price_trans_wp">
									<div class=" font_opensans font_size13 fl pt5 width_130 pl10"><?php echo $this->lang->line('space');?></div>
									<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml20 clr_818181 font_size12"><?php echo $sizeString;?></div>
									<?php } else {?>
									<div>
										<div class="font_opensans font_size13 fl pt5 width_130 pl10"><?php echo $this->lang->line('used');?></div>
										<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml20 clr_818181 font_size12"><?php echo $usedSpacedString;?></div>
										<div class=" font_opensans font_size13 fl pt5 width_130 pl10"><?php echo $this->lang->line('free');?></div>
										<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml20 clr_818181 font_size12"><?php echo $reminingSizeString;?></div>
									<?php
									}
									if($userContainerId > 0 && (isset($pkg->elementId) && $pkg->elementId == 0)){ ?>
										<input type="hidden" name="userContainerId" <?php echo $selected;?> value="<?php echo $userContainerId;?>">
										<?php
									}elseif(isset($pkg->userDefaultTsProductId)&& $pkg->userDefaultTsProductId > 0 ){ ?>
										<input type="hidden" name="userDefaultTsProductId" <?php echo $selected;?> value="<?php echo $pkg->userDefaultTsProductId;?>">
										<?php
									}
									?>
								</div>
								<div class="clear"></div>
								<div class="seprator_10"></div>
							</div>
						</div>
						<?php
					//}
					?>
					<input type="hidden" name="sectionId" value="<?php echo $sectionId;?>">
					<div class="clear"></div>
					<?php if(isset($countElementResult) && !empty($countElementResult)){
						if($pkg->pkgSections=='{13}') {
							$topPosition = 'mt-35 price_trans_wp';
						}else{
							$topPosition = 'mt-15';
						}
						?>
					<div class="fl width_240 mb10 <?php echo $topPosition;?>">
						<div class="row">
								<div class=" font_opensans font_size13 fl pt5 width_130 pl10"><?php echo $elementCountLabel;?></div>
								<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml20 clr_818181 font_size12"><?php echo $countElementResult;?></div>
						</div>
					</div>
					
					<?php } ?>
					<?php						
						if($pkg->userContainerId>0){
							$pkgContainerId = $pkg->userContainerId;							
						} else {								
							$pkgContainerId ='';								
						} ?>
					                     
					<div class="tds-button fr ml20 container_box"> <a href="<?php echo base_url(lang().'/membershipcart/addspace/'.$pkgContainerId);?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold"><?php echo $this->lang->line('addSpace');?></span></a> </div>

					<?php
					if(isset($pkg->elementId) && $pkg->elementId > 0 && isset($newElementUrl)){
						if($pkg->entityId!=97)
						$newElementUrl=$newElementUrl.'/'.$pkg->entityId;
						?>
						<div class="tds-button fr ml10 mr-15"><a href="<?php echo $newElementUrl;?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold <?php echo $submitBtnclass;?>"><?php echo $submitButton;?></span></a></div>
						<?php
					}elseif(!isset($notAllowtoDirectUse)){ 
						$submitButton=(isset($submitButton))?$submitButton:$this->lang->line('use');
						?>
						<div class="tds-button fr ml10 mr-15"><a onclick="$('#selectContainerFrom<?php echo $formNameId;?>').submit();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold clr_f1592a gray_clr_hover"><?php echo $submitButton;?></span></a></div>
						<?php	
					}
					?>
					<?php
				echo form_close(); 
				}?>
			</div> 
			<div class="clear"></div>
		</div>
		<div class="seprator_5"></div>
	</div>
</div>
