<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	//echo '<pre />';print_r($data);
	$thumbImage = addThumbFolder($data['filePath'].$data['fileName'],'_m');							
	$productFinalImg = getImage($thumbImage,$defaultProfileImage);
	$recordDetailUrl = base_url(lang().'/productshowcase/viewproject/'.$data['tdsUid'].'/'.$data['productId']);
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
                
                	<div class="bannertop_headingbg">
                    	<div class="Fleft ml32 width_345 mt20"><img alt="atopcravedproduct" src="<?php echo base_url('images/frontend/atopcravedproduct.png');?>"></div>
                    </div>
                    
                    <div class="slider_contentbg assciate_professionalbg">
                    
                    	<div class="banner_heading_Mid mt20 Fleft width_345 ml32"><?php echo $creative_name; ?></div>
                        <div class="clear"></div>
						<div class="seprator_24"></div>
                    	<div class="contentbg_container clr_d9d9d9 font_size13 ml32 width_345">
                        	<?php echo getSubString($data['productOneLineDesc'],180); ?>
                        </div>

                    <div class="slider_bottomdiv">
						<div class="fl font_arial font_size11 clr_eee ml34">
							<div class="slider_review cell pr16 pl20"><span><?php echo $data['reviewCount'];?></span></div>
							<div class="slider_view cell  pr16 pl20"><span><?php echo $data['viewCount'];?></span></div>
							<div class="slider_crave cell  pr16 pl20"><span><?php echo $data['craveCount'];?></span></div>
						</div>
						
						<div class="fr mr70 mt10"> <img alt="product" src="<?php echo base_url('images/frontend/products.png');?>"></div>
                    </div>
                    </div>
					<div class="slider_img_shedow bdr_white bannerPRODUCTbg">
							<div class="AI_table">
							  <div class="AI_cell">
							  <img src="<?php echo $productFinalImg;?>" class=" maxW254_maxH174 slider_img_shedow BdrW_trans">
							</div>
						</div>
					</div>
			
                </div>
                </a>
</li>
