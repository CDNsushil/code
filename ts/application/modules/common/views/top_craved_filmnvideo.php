<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['projBaseImgPath'],'_s');				
	$projFinalImg = getImage($thumbImage,$defaultProfileImage);
	$recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data['tdsUid'].'/'.$data['projId'].'/filmvideo');
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

		<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow mt65 ml23 width368px height210 bannerFVbg">
			<div class="AI_table">
			<div class="AI_cell">
				<img alt="craved piece video" src="<?php echo $projFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">
			</div>
			</div>
		</div>
		 
		<div class="bannertop_headingbg">
			<div class="Fleft ml46 width_345 mt20"> <img alt="topcravedpiece" src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>"></div>
			<div class="fr mr200 mt15"><img alt="filmovvideo" src="<?php echo base_url('images/frontend/filmorvideo.png');?>"></div>
			<div class="clear"></div>
			<div class="orangeheading_Mid mt28 ml440 width_245"><?php echo $creative_name; ?></div>
		</div>
		
	   
		
		<div class="slider_contentbg bg_474747">
			<div class="seprator_35"></div>
			<div class="contentbg_container clr_d9d9d9 font_size13 ml440 height_68 width_245">
				<?php echo getSubString($data['projShortDesc'],180); ?>
			</div>
			

		<div class="slider_bottomdiv">
				<div class="fr font_arial font_size11 clr_eee ml34">
					<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
					<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
					<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
				</div>
				
				<div class="fl ml32 font_opensansSBold font_size22 clr_e6e6e6 textS_slider"><?php echo getSubString($data['projName'],25);?></div>
		</div>
		
		
		</div> 
	</div>
	</a>
</li>
<?php } 
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
	$elementDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$elementData['tdsUid'].'/'.$elementData['projId'].'/'.$elementData['elementId'].'/filmvideo');
?>
<li class="dn ptr">
	<a href="<?php echo $elementDetailUrl;?>"  target="_blank">
	<div class="worpsliderbg">

		<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow mt65 ml23 width368px height210 bannerFVbg">
			<div class="AI_table">
			<div class="AI_cell">
				<img alt="craved piece video" src="<?php echo $elementFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">
			</div>
			</div>
		</div>
		 
		<div class="bannertop_headingbg">
			<div class="Fleft ml46 width_345 mt20"> <img alt="topcravedpiece" src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>"></div>
			<div class="fr mr200 mt15"><img alt="filmovvideo" src="<?php echo base_url('images/frontend/filmorvideo.png');?>"></div>
			<div class="clear"></div>
			<div class="orangeheading_Mid mt28 ml440 width_245"><?php echo $element_creative_name; ?></div>
		</div>
		
	   
		
		<div class="slider_contentbg bg_474747">
			<div class="seprator_35"></div>
			<div class="contentbg_container clr_d9d9d9 font_size13 ml440 height_68 width_245">
				<?php echo changeToUrl(getSubString($elementData['description'],180)); ?>
			</div>
			

		<div class="slider_bottomdiv">
				<div class="fr font_arial font_size11 clr_eee ml34">
					<div class="slider_review cell pr16 pl20"><span><?php echo $elementData['reviewCount'];?></span></div>
					<div class="slider_view cell  pr16 pl20"><span><?php echo $elementData['viewCount'];?></span></div>
					<div class="slider_crave cell  pr16 pl20"><span><?php echo $elementData['craveCount'];?></span></div>
				</div>
				
				<div class="fl ml32 font_opensansSBold font_size22 clr_e6e6e6 textS_slider"><?php echo getSubString($elementData['title'],30);?></div>
		</div>
		
		
		</div> 
	</div>
	</a>
</li>
<?php } ?>
