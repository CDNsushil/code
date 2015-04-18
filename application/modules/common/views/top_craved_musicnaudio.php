<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['projBaseImgPath'],'_m');				
	$projFinalImg = getImage($thumbImage,$defaultProfileImage);
	$recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data['tdsUid'].'/'.$data['projId'].'/musicaudio');
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

	<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow ml20 width285px height260 bannerMAbg">
		<div class="AI_table">
			<div class="AI_cell">
				<img alt="album cover" src="<?php echo $projFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">
			</div>
		</div>
	</div>
	 
	<div class="bannertop_headingbg">
		<div class="fr mr200 mt15"><img alt="musicandaudio"  src="<?php echo base_url('images/frontend/musicandaudio.png');?>"></div>
		<div class="banner_heading_Mid Fleft mt-8 ml340"><?php echo $data['projName']; ?></div>
		<div class="clear"></div>
		<div class="orangeheading_Mid mt28 ml340"><?php echo $creative_name; ?></div>
	</div>
	
	<div class="slider_contentbg bg_474747">
		
		<div class=" seprator_18"></div>
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo $data['projShortDesc']; ?>
		</div>
		
		<div class="clear"></div>
		<div class="seprator_18"></div>
		
		<div class="ml340 width_345 pl46"> 
			<!--img alt="audio player"  src="<?php echo base_url('images/frontend/slider_audioplayer.png');?>"-->
		</div>

		<div class="slider_bottomdiv">
			<div class="fr font_arial font_size11 clr_eee ml34">
				<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
				<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
				<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
			</div>
			
		   <div class="fl ml46 mt4">
				<img  src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>" alt="top craved piece">
		   </div>
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
	$elementDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data['tdsUid'].'/'.$data['projId'].'/'.$elementData['elementId'].'/musicaudio');
?>

<li class="dn ptr">
	<a href="<?php echo $elementDetailUrl;?>"  target="_blank">
<div class="worpsliderbg">

	<div class="bannerleftimgbg bdr_white zindex_999 slider_img_shedow ml20 width285px height260 bannerMAbg">
		<div class="AI_table">
			<div class="AI_cell">
				<img alt="album cover" src="<?php echo $elementFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">
			</div>
		</div>
	</div>
	 
	<div class="bannertop_headingbg">
		<div class="fr mr200 mt15"><img alt="musicandaudio"  src="<?php echo base_url('images/frontend/musicandaudio.png');?>"></div>
		<div class="banner_heading_Mid Fleft mt-8 ml340"><?php echo getSubString($elementData['title'],50); ?></div>
		<div class="clear"></div>
		<div class="orangeheading_Mid mt28 ml340"><?php echo $element_creative_name; ?></div>
	</div>
	
	<div class="slider_contentbg bg_474747">
		<?php if( $elementData['description'] !='' ) { ?>		
			<div class=" seprator_18"></div>
			<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
				<?php echo changeToUrl(getSubString($elementData['description'],180)); ?>
			</div>
		<?php } ?>
		<div class="clear"></div>
		<div class="seprator_18"></div>
		
		<div class="ml340 width_345 pl46"> 
			<!--img alt="audio player"  src="<?php echo base_url('images/frontend/slider_audioplayer.png');?>"-->
		</div>

		<div class="slider_bottomdiv">
			<div class="fr font_arial font_size11 clr_eee ml34">
				<div class="slider_review cell pr16 pl20"><span><?php echo $elementData['reviewCount'];?></span></div>
				<div class="slider_view cell  pr16 pl20"><span><?php echo $elementData['viewCount'];?></span></div>
				<div class="slider_crave cell  pr16 pl20"><span><?php echo $elementData['craveCount'];?></span></div>
			</div>
			
		   <div class="fl ml46 mt4">
				<img  src="<?php echo base_url('images/frontend/atopcravedpiecs.png');?>" alt="top craved piece">
		   </div>
		</div>
	</div> 
</div>
</a>
</li>
<?php } ?>
