<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['projBaseImgPath'],'_m');				
	$projFinalImg = getImage($thumbImage,$defaultProfileImage);
	$recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data['tdsUid'].'/'.$data['projId'].'/educationmaterial');
	$userInfo =showCaseUserDetails($data['tdsUid']);
	if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
		$creative_name= $userInfo['enterpriseName'];
	}else{
		$creative_name= $userInfo['userFullName'];
	}
if(isset($data)&&count($data)>0){
?>
<li class="dn ptr">
		<a href="<?php echo $recordDetailUrl;?>"  target="_blank">
<div class="worpsliderbg">
	<div class="photoart_imgcont slider_img_shedow bdr_white bannerEMbg top12">
			<div class="AI_table">
			  <div class="AI_cell">
				<img alt="slider" src="<?php echo $projFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans" >
				</div>
			</div>
	</div>   
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 font_opensansSBold ml340">
			<img alt="topcraved" src="<?php echo base_url('images/frontend/topcravedlesson.png');?>">
		</div>
		<div class="clear"></div>
		<div class="orangeheading_Mid mt20 ml340 width_304">
			<?php echo $creative_name; ?>
		</div>
	</div>
	
	<div class="slider_contentbg bg_474747">
	
		<div class="banner_heading_Mid mt20 Fleft ml340 width_304">
			<?php echo getSubString($data['projName'],25);?>
		</div>
		<div class="clear"></div>
		<div class="seprator_20"></div>
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo getSubString($data['projShortDesc'],180); ?>
		</div>
		
		<div class="ml314 pl128 mt15">                          
			<img  alt="education_material" src="<?php echo base_url('images/frontend/education_material.png');?>">
		</div>                    
	
		<div class="slider_bottomdiv">
			<div class="fr font_arial font_size11 clr_eee">
				<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
				<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
				<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
			</div>
		</div>	
	</div> 
</div>
</a>
</li>
<?php
} 
if(isset($elementData) && $elementData!=''){
	$elementUserInfo =showCaseUserDetails($elementData['tdsUid']);
	if(isset($elementUserInfo['enterprise']) && $elementUserInfo['enterprise'] == 't'){
		$element_creative_name= $elementUserInfo['enterpriseName'];
	}else{
		$element_creative_name= $elementUserInfo['userFullName'];
	}
	
	if(isset($elementData['imagePath']) && $elementData['imagePath']!='')
		$elementImg = $elementData['imagePath'];
	else 
		$elementImg = '';
		
	$thumbImage = addThumbFolder($elementImg,'_m');				
	$elementFinalImg = getImage($thumbImage,$defaultProfileImage);
	$elementDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$elementData['tdsUid'].'/'.$elementData['projId'].'/'.$elementData['elementId'].'/educationmaterial');
?>
<li class="dn ptr">
<a href="<?php echo $elementDetailUrl;?>"  target="_blank">
<div class="worpsliderbg">
	<div class="photoart_imgcont slider_img_shedow bdr_white bannerEMbg top12">
			<div class="AI_table">
			  <div class="AI_cell">
				<img alt="slider" src="<?php echo $elementFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans" >
				</div>
			</div>
	</div>   
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 font_opensansSBold ml340">
			<img alt="topcraved" src="<?php echo base_url('images/frontend/topcravedlesson.png');?>">
		</div>
		<div class="clear"></div>
		<div class="orangeheading_Mid mt20 ml340 width_304">
			<?php echo $element_creative_name; ?>
		</div>
	</div>
	
	<div class="slider_contentbg bg_474747">
	
		<div class="banner_heading_Mid mt20 Fleft ml340 width_304">
			<?php echo getSubString($elementData['title'],25);?>
		</div>
		<div class="clear"></div>
		<div class="seprator_20"></div>
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo changeToUrl(getSubString($elementData['description'],180)); ?>
		</div>
		
		<div class="ml314 pl128 mt15">                          
			<img  alt="education_material" src="<?php echo base_url('images/frontend/education_material.png');?>">
		</div>                    
	
		<div class="slider_bottomdiv">
			<div class="fr font_arial font_size11 clr_eee">
				<div class="slider_review cell pr16 pl20"><span><?php echo $elementData['reviewCount'];?></span></div>
				<div class="slider_view cell  pr16 pl20"><span><?php echo $elementData['viewCount'];?></span></div>
				<div class="slider_crave cell  pr16 pl20"><span><?php echo $elementData['craveCount'];?></span></div>
			</div>
		</div>	
	</div> 
</div>
</a>
</li>
<?php } ?>
