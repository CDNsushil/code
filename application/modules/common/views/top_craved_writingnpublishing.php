<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['projBaseImgPath'],'_m');				
	$projFinalImg = getImage($thumbImage,$defaultProfileImage);	
	$recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data['tdsUid'].'/'.$data['projId'].'/writingpublishing');
	$userInfo =showCaseUserDetails($data['tdsUid']);
	if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
		$creative_name= $userInfo['enterpriseName'];
	}else{
		$creative_name= $userInfo['userFullName'];
	}
if(isset($data)&&count($data)>0){
?>
<li class="dn ptr" >

<div class="worpsliderbg" onclick="gotourl('<?php echo $recordDetailUrl;?>',1);">
	<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow mt7 ml20 p10 width257px height260 bannerWPbg">		
		<img alt="slider" src="<?php echo $projFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">			
	</div>
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 ml314 font_opensansSBold ml340"><img alt="topcraved" src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>"></div>
			<div class="clear"></div>
		<div class="orangeheading_Mid mt20 ml340 width_304"><?php echo $creative_name; ?></div>
	</div>
	
	<div class="slider_contentbg bg_474747">
	
		<div class="banner_heading_Mid mt20 Fleft ml340 width_304">
			<?php echo getSubString($data['projName'],25);?>
		</div>
		<div class="clear"></div>
		<div class="seprator_20"></div>
		
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo getSubString($data['projShortDesc'],140); ?>
		</div>
		
		<div class="ml314 pl25 mt15">			
			<div class="fl mt-5">
				<a href="javascript:void(0);" onmousedown="mousedown_readnow(this)" onmouseup="mouseup_readnow(this)" class="readnow">Read Now</a>
			</div>
			<img class="ml10 mt5 fl" alt="performance" src="<?php echo base_url('images/frontend/writingandpublishing.png');?>">
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
	$elementDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$elementData['tdsUid'].'/'.$elementData['projId'].'/'.$elementData['elementId'].'/writingpublishing');
?>
<li class="dn ptr" >

<div class="worpsliderbg" onclick="gotourl('<?php echo $elementDetailUrl;?>',1);">
	<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow mt7 ml20 p10 width257px height260 bannerWPbg">		
		<img alt="slider" src="<?php echo $elementFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">			
	</div>
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 ml314 font_opensansSBold ml340"><img alt="topcraved" src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>"></div>
			<div class="clear"></div>
		<div class="orangeheading_Mid mt20 ml340 width_304"><?php echo $element_creative_name; ?></div>
	</div>
	
	<div class="slider_contentbg bg_474747">
	
		<div class="banner_heading_Mid mt20 Fleft ml340 width_304">
			<?php echo getSubString($elementData['title'],25);?>
		</div>
		<div class="clear"></div>
		<div class="seprator_20"></div>
		
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo changeToUrl(getSubString($elementData['description'],140)); ?>
		</div>
		
		<div class="ml314 pl25 mt15">			
			<div class="fl mt-5">
				<a href="javascript:void(0);" onmousedown="mousedown_readnow(this)" onmouseup="mouseup_readnow(this)" class="readnow">Read Now</a>
			</div>
			<img class="ml10 mt5 fl" alt="performance" src="<?php echo base_url('images/frontend/writingandpublishing.png');?>">
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

</li>
<?php } ?>
