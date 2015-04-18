<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['filePath'].$data['fileName'],'_b');	
	$blogFinalImg = getImage($thumbImage,$defaultProfileImage);	
	$recordDetailUrl = base_url(lang().'/blogs/frontpost/'.$data['custId'].'/'.$data['postId']);
	$userInfo =showCaseUserDetails($data['custId']);
	if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
		$creative_name= $userInfo['enterpriseName'];
	}else{
		$creative_name= $userInfo['userFullName'];
	}
?>
<li class="dn ptr">
	<a href="<?php echo $recordDetailUrl;?>"  target="_blank">
	<div class="worpsliderbg">
	<div class="photoart_imgcont slider_img_shedow bdr_white width270px bannerBLOGbg top12">
	<div class="AI_table">
	  <div class="AI_cell">
		<img alt="slider" src="<?php echo $blogFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans" >
		</div>
	</div>
	</div>

	<div class="bannertop_headingbg">
	<div class="banner_heading_Mid mt28 Fleft"><?php echo getSubString($data['postTitle'],25);?></div>
	<div class="clear"></div>
	<div class="orangeheading_Mid mt27"><?php echo $creative_name; ?></div>
	</div>

	<div class="slider_contentbg">
	<div class="seprator_42"></div>
	<div class="contentbg_container clr_d9d9d9 font_size13 height_68">
		<?php echo getSubString($data['postOneLineDesc'],180); ?>
	</div>
	<div class="slider_bottomdiv">                    
	<div class="fl ml12 mt4">
	 <img alt="topcraved" src="<?php echo base_url('images/frontend/topcravedpost.png');?>">
	 </div>

	<div class="fr font_arial font_size11 clr_eee">
		<!--div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div-->
		<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
		<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
	</div>
	<div class="fr mr14 mt10"> <img alt="blogs" src="<?php echo base_url('images/frontend/blogs.png');?>"></div>			
	</div>	
	</div> 
	</div>
	</a>
</li>
