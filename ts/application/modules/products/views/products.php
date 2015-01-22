<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
    
<?php 	

	//Common Banner
	$topCravedArray = array('entityId'=>$productEntityId,'projectType'=>'product');
	

	$topCravedData['data'] = topCraved($topCravedArray);
	
	if(is_array($topCravedData['data']) && count($topCravedData['data'])>0){	
		if($topCravedData['data']['catId']==1)
			$topCravedData['defaultProfileImage'] = $this->config->item('defaultProductForSale_m');
		else if($topCravedData['data']['catId']==3)
			$topCravedData['defaultProfileImage']= $this->config->item('defaultProductFree');
		else
			$topCravedData['defaultProfileImage'] = $this->config->item('defaultProductWanted_m');
			
		$topCravedHtml = $this->load->view('common/top_craved_product',$topCravedData,true);
	}
	else
		$topCravedHtml = '';
				
	$bannerarray['imgarray'] = array('banner_front_products_trading-post_HR.jpg','banner_front_products_trash-treasure_HR.jpg');
	$bannerarray['topCravedHtml'] = $topCravedHtml;
	
	echo $this->load->view('common/common_banner',$bannerarray); //common view for image banner placed in main view folder

	$openLi ='<li>';
	$closeLi ='</li>';
	$currentMethod = $this->router->class;	
	
	$loggedInUser = isLoginUser();
	$goToSectionUrl = '/'.$this->config->item($currentMethod.'_dashboard');
	
	$goToNewsUrl = '/'.$this->config->item('news_dashboard');
	$goToReviewsUrl = '/'.$this->config->item('review_dashboard');
	$href = 'javascript://void(0);'; 
	if(isset($loggedInUser) && $loggedInUser>0) {
		$dashboardSectionUrl = "goTolink('','".base_url(lang().$goToSectionUrl)."')";	
		$dashboardNewsUrl = "goTolink('','".base_url(lang().$goToNewsUrl)."')";
		$dashboardReviewUrl = "goTolink('','".base_url(lang().$goToReviewsUrl)."')";
		$cssLogin="mt7";
	}
	else{
		$cssLogin="mt7";
		
		$dashboardSectionUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->config->item($currentMethod)).".')";
		$dashboardNewsUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('article')).".')";
		$dashboardReviewUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('Reviews')).".')";	
	}
	
	$addNewsButton = 	 anchor($href,$this->lang->line('addArticle'),array('onclick'=>$dashboardNewsUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));    
	$addReviewsButton =  anchor($href,$this->lang->line('addReview'),array('onclick'=>$dashboardReviewUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  		    
	$addSectionButton = 	 anchor($href,$this->lang->line('uploadButtonAdvertise'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  
	
	$mlClass="ml40";

if((isset($news_array) && is_array($news_array) && count($news_array) > 0 ) || (isset($reviews_array) && is_array($reviews_array) && count($reviews_array) > 0 )){?>
	<div class="row">
		
			<?php 
			$newsReview['addNewsButton'] =  $addNewsButton;
			$newsReview['openLi'] =  $openLi;
			$newsReview['closeLi'] =  $closeLi;
			$newsReview['addReviewsButton'] =  $addReviewsButton;
			$newsReview['main_div_class'] =  "cell bdr_naviBlue10 global_shadow bg_white ml40 width_420";
			$newsReview['first_li_class'] =  "wp_tab width_80 wp_tab_selected clr_1d2f80 dash_link_hover";
			$newsReview['second_li_class'] =  "wp_tab width_100 clr_1d2f80 dash_link_hover";
			$newsReview['slider1_main_class'] =  "slider MA_news_scroll_btn_box";
			$newsReview['slider2_main_class'] =  "slider MA_news_scroll_btn_box";
			
			echo $this->load->view('common/news_reviews_landing',$newsReview); 
			?>  
			
            </div>
     <?php
     
    $mlClass="ml20"; 
	}?>
            <!--news_and_review_wp-->
            <?php if(!empty($product_array)){?>
            <div class="cell bdr_naviBlue10 global_shadow bg_white <?php echo  $mlClass; ?> width_420">
               <div class="wp_project_heading ml11 clr_1d2f80">Latest Products</div>
                <div class="seprator_3"></div>
                <div class="slider MA_news_scroll_btn_box mt_minus30" id="slider3">
					<div class="position_relative mr10">
						<div class="z_index_2 position_relative">
							<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						
						<?php echo $addSectionButton;?>
						
					</div>
                  <div class="viewport wp_news_scroll_container ml10">
                    <ul class="overview" style="width: 800px; left: 0px;">
                      <?php
						
						$productCounter = 0;
						$liCounter = 0;
						$openDiv = '<div>';
						$closeDiv = '</div>';
					
						foreach($product_array as $countproduct => $productDetail){ 
						//echo '<pre />';print_r($productDetail);
						
						
						if($productDetail->catId==1){
							$productType =$this->lang->line('forsale');
						} elseif(@$productDetail->catId==2){
							$productType = $this->lang->line('wanted');
						} else {
							$productType = $this->lang->line('freeStuff');
						}						
						
						$productDetailUrl = base_url(lang().'/productshowcase/viewproject/'.$productDetail->tdsUid.'/'.$productDetail->productId);	
						//$productDetailUrl = base_url(lang().'/productshowcase/viewproject/'.$productType.'/'.$productDetail->tdsUid.'/'.$productDetail->productId);	
						
						$productUserInfo = showCaseUserDetails($productDetail->tdsUid);
						
						if($productDetail->catId==1)
							$defaultImage = $this->config->item('defaultProductForSale_m');
						else if($productDetail->catId==3)
							$defaultImage = $this->config->item('defaultProductFree');
						else
							$defaultImage = $this->config->item('defaultProductWanted_m');
							
						$thumbImage = addThumbFolder(@$productDetail->filePath.@$productDetail->fileName,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$defaultImage);
						
						//$thumbFinalImg = getImage(@$productDetail->filePath.@$productDetail->fileName,$defaultImage);
						
						$productCounter++;$liCounter++;
						
						if($liCounter==1) echo $openLi; 
						
						if($productCounter==1) {echo $openDiv;}
						if($productCounter<3) {$mr8='mr8';}else $mr8='';
						?>
                        <!--box start-->
                   <a href="<?php echo $productDetailUrl;?>" target="_blank" >     
                        <div class="wp_project_box <?php echo $mr8;?> height226px">
							<div class="dash_link_hover">
								<div class="wp_project_thumb">
									<div class="AI_table">
										<div class="AI_cell"><img class="max_w105_h83" src="<?php echo $thumbFinalImg;?>" ></div>
									</div>
								</div>
								<div class="ml13 font_size11"><b><?php echo getSubString($productUserInfo['userFullName'],15);?></b></div>
							</div>	
                          <div class="bdr_BorangeLight ml9 mr9 mt7 "></div>
                          <p class="AP_project_box_txt ml13 mr10 mt11"><?php echo getSubString($productDetail->productTitle,100);?></p>
                           <div class="seprator_10"></div>
                           <?php
									$cravedALL='';
									$countProductResult = 0;
									$loggedUserId=isloginUser();
									if($loggedUserId > 0){
									
										$whereProduct=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$productEntityId,
										'elementId'=>$productDetail->productId
										);
										
										$countProductResult=countResult('LogCrave',$whereProduct);
										$cravedALL=($countProductResult>0)?'cravedALL':'';
										
									}
									else{
										$cravedALL='';
									}
							?>
                          
                          <div class="row ml9 mr10">
							   <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $productEntityId.''.$productDetail->productId;?> <?php echo $cravedALL;?>">
								  <?php echo $countProductResult;?>
							   </div>
							   <?php $this->load->view('rating/ratingAvg',array('elementId'=>$productDetail->productId,'entityId'=>$productEntityId,'ratingClass'=>'cell ml14 mt6 Fright'));?>
							  </div>
                               
                          </div>
                  </a>
                      <?php
						if($productCounter==count($product_array)) echo $closeDiv.$closeLi;
						else if($productCounter==3 && $countproduct<count($product_array) && $countproduct%9!=0) 
						{
							$productCounter=0;
							echo '<div class="clear"></div>';	
							echo $closeDiv;
							echo '<div class="seprator_15"></div>';	
						}	
						if($liCounter==6) {$liCounter=0;echo $closeLi;}
						//else  {  $productCounter=0;echo $closeDiv;}							
					}
                        
                    ?> 
                    </ul>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
            </div>
			<?php } ?>         
          <div class="row seprator_40"></div>
        <div class="clear"></div> 
        
<script type="text/javascript">

/* */


$('#tab01').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#tab1').css('display','block');
		$('#tab2').css('display','none');
	
		
		 })


$('#tab02').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#tab1').css('display','none');
		$('#tab2').css('display','block');
	
		
		 })
</script>
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel();	
			$('#slider2').tinycarousel();
			$('#slider3').tinycarousel();
			$('#slider4').tinycarousel();
			$('#slider5').tinycarousel();
			
		});
</script>
