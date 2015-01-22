<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 

	$thumbImage = addThumbFolder($data['filePath'].$data['fileName'],'_l');				
	$eventFinalImg = getImage($thumbImage,$defaultProfileImage);
	$eventMathod=($data['NatureId']==1)?'notification':'event';
	$recordDetailUrl = base_url(lang().'/eventfrontend/events/'.$eventMathod.'/'.$data['tdsUid'].'/'.$data['EventId']);
	$userInfo =showCaseUserDetails($data['tdsUid']);
	if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
		$creative_name= $userInfo['enterpriseName'];
	}else{
		$creative_name= $userInfo['userFullName'];
	}
?>
<li class="dn ptr">
		<a href="<?php echo $recordDetailUrl;?>"  target="_blank">
<div class="worpsliderbg">
	<div class="event_img_box slider_img_shedow bannerPEbg">
		<div class="AI_table">
			<div class="AI_cell">
				<img alt="slider" src="<?php echo $eventFinalImg;?>"  class="max_w361_h240 slider_img_shedow BdrW_trans">
			</div>
		</div>
	</div>
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 font_opensansSBold ml340">
			<img alt="topcraved" src="<?php echo base_url('images/frontend/topcravedevent.png');?>">
		</div>
		<div class="clear"></div>
		<div class="orangeheading_Mid mt20 ml340 width_304"><?php echo $creative_name; ?></div>
	</div>

	<div class="slider_contentbg performance_eventbg">

	<div class="banner_heading_Mid mt20 Fleft ml340 width_304"><?php echo getSubString($data['Title'],25)?></div>
	
	<div class="clear"></div>
	<div class="seprator_20"></div>
	
	<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
		<?php echo getSubString($data['OneLineDescription'],185)?>
	</div>
	
	<div class="ml314 pl25 mt15">
		<img alt="performance" src="<?php echo base_url('images/frontend/performanceorevent.png');?>">
	</div>

	<div class="slider_bottomdiv">
		<div class="fr font_arial font_size11 clr_eee mr106">
			<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
			<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
			<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>	  
		</div>
	</div>

	</div> 
</div>
</a>
</li>
