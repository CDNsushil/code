<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$userInfo = showCaseUserDetails($data['tdsUid']); 
	//echo '<pre />';print_r($userInfo);
	//echo '<pre />';print_r($data);
	$thumbImage = addThumbFolder($userInfo['userImage'],'_m');				
	$userFinalImg = getImage($thumbImage,$defaultProfileImage);
	$memberDetailUrl = base_url(lang().'/showcase/index/'.$data['tdsUid']);					
?>
<li class="dn ptr">
		<a href="<?php echo $memberDetailUrl;?>"  target="_blank">
	<div class="worpsliderbg">
		
		<div class="bannertop_headingbg">
			<div class="Fleft ml78 width_345 mt20">
				<img alt="atopcraved" src="<?php echo base_url();?>images/frontend/atopcravedcreative.png">
			</div>
		</div>

		<div class="slider_contentbg bg_474747">
			<div class="banner_heading_Mid mt20 Fleft width_345 ml32 clr_f1592a">
				<?php echo $userInfo['userFullName']; ?>
			</div>
			
			<div class="clear"></div>
			<div class="seprator_24"></div>
			
			<div class="contentbg_container clr_d9d9d9 font_size13 ml32 width_345 height_68">
				<?php echo getSubString($data['creativeFocus'],180); ?>
			</div>

			<div class="slider_bottomdiv">
				<div class="fr font_arial font_size11 clr_eee ml34">
					<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
					<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
					<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>	
				</div>
				<div class="fl ml32 mt8"><img alt="atopcraved" src="<?php echo base_url();?>images/frontend/creative.png"></div>
			</div>
		</div> 

		<div class="creative_imgcont slider_img_shedow">
			<div class="ml10 mt8">				
				<img src="<?php echo $userFinalImg;?>" class=" maxW_158_maxH238 slider_img_shedow BdrW_trans">
			</div>
		</div>
	</div>
	</a>
</li>
