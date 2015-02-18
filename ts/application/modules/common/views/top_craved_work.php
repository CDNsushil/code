<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$thumbImage = addThumbFolder($data['filePath'].$data['fileName'],'_m');					
	$workFinalImg = getImage($thumbImage,$defaultProfileImage);
	$recordDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$data['tdsUid'].'/'.$data['workId']);
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
	<div class="photoart_imgcont slider_img_shedow bdr_595959 worksliderbg_grad bdr_fff top12">
			<div class="AI_table">
			  <div class="AI_cell">
				<img alt="slider" src="<?php echo $workFinalImg;?>" class="maxW254_maxH174 slider_img_shedow BdrW_trans" >
				</div>
			</div>
	</div>   
	<div class="bannertop_headingbg">
		<div class="mt24 Fleft font_size32 font_opensansSBold ml340">
			<img alt="topcraved" src="<?php echo base_url('images/frontend/topcraved_work.png');?>">
		</div>
		<div class="clear"></div>
		
	</div>
	
	<div class="slider_contentbg bg_474747">
	
		<div class="banner_heading_Mid mt20 Fleft ml340 width_304">
			<?php echo $creative_name; ?>
		</div>
		<div class="clear"></div>
		<div class="seprator_20"></div>
		<div class="contentbg_container clr_d9d9d9 font_size13 ml340 height_68">
			<?php echo getSubString($data['workShortDesc'],180); ?>
		</div>
		 
		 <div class="slider_bottomdiv">
				<div class="fl font_arial font_size11 clr_eee ml34">
					<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
					<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
					<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
				</div>
				
				<div class="fr mr70 mt10"> <img alt="product" src="<?php echo base_url('images/frontend/work.png');?>"></div>
			</div>
          </div>

</div>
</a>
</li>
