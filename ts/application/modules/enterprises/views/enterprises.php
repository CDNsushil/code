<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
		$topCravedArray = array('entityId'=>$showcaseEntityId,'projectType'=>'enterprises');
		
		//echo '<pre/ >';print_r($topCravedData);die;
		$topCravedData['defaultProfileImage'] = $this->config->item('defaultEnterpriseImg_m');	
		$topCravedData['data'] = topCraved($topCravedArray);	
		if(is_array($topCravedData['data']) && count($topCravedData['data'])>0)	
			$topCravedHtml = $this->load->view('common/top_craved_enterprise',$topCravedData,true);	
		else
			$topCravedHtml = '';
				
		$bannerarray['imgarray']=array('banner_front_enterprises_help-clients-find-you_HR.jpg','banner_front_enterprises_find-enterprise-best-suits_HR.jpg');
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
		$addSectionButton = 	 anchor($href,$this->lang->line('uploadButtonCreate'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  
		
		$mlClass="ml40";
		
		if((isset($news_array) && is_array($news_array) && count($news_array) > 0 ) || (isset($reviews_array) && is_array($reviews_array) && count($reviews_array) > 0 )){ ?>

          <div class="row">
          
           <?php 
			$newsReview['addNewsButton'] =  $addNewsButton;
			$newsReview['openLi'] =  $openLi;
			$newsReview['closeLi'] =  $closeLi;
			$newsReview['addReviewsButton'] =  $addReviewsButton;
			$newsReview['main_div_class'] =  "cell bdr_lightorange10 global_shadow bg_white ml40 width_420";
			$newsReview['first_li_class'] =  "wp_tab width_80 wp_tab_selected orange_clr_imp gray_clr_hover";
			$newsReview['second_li_class'] =  "wp_tab width_100 orange_clr_imp gray_clr_hover";
			$newsReview['slider1_main_class'] =  "slider AP_news_scroll_btn_box";
			$newsReview['slider2_main_class'] =  "slider AP_news_scroll_btn_box";
			
			echo $this->load->view('common/news_reviews_landing',$newsReview); 
			?>
           
            </div>
			<?php
			
			$mlClass="ml20";
		}?> 
           <!--news_and_review_wp-->
            <?php if(!empty($member_array)){?>
            <div class="cell bdr_lightorange10 global_shadow bg_white <?php echo $mlClass; ?> width_420">
               <div class="wp_project_heading ml11 orange_clr_imp">  <?php echo $this->lang->line('LatestMembers');?></div>
                <div class="seprator_3"></div>
                <div class="slider AP_news_scroll_btn_box mt_minus30" id="slider3">
					<div class="position_relative  mr10">
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
						
						$memberCounter = 0;
						$liCounter = 0;
						$openDiv = '<div>';
						$closeDiv = '</div>';
						
						
					
						foreach($member_array as $countmember => $memberDetail){ 
						
						$memberDetailUrl = base_url(lang().'/showcase/index/'.$memberDetail->tdsUid);
						
						
						if($memberDetail->stockImageId > 0)
						{
							$userImage = $memberDetail->stockImgPath.'/'.$memberDetail->stockFilename;					
						}
						else
						{
							$profileImagePath  = 'media/'.$memberDetail->username.'/profile_image/';
							$userImage = $profileImagePath.$memberDetail->profileImageName;	
						}						
														
						$defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');															
						//$thumbFinalImg = getImage(@$memberUserInfo['userImage'],$this->config->item('defaultWPImg'));
						$thumbImage = addThumbFolder($userImage,'_s');				
						$thumbFinalImg = getImage($thumbImage,$defaultProfileImage);
						
						$userFullName=$memberDetail->firstName.' '.$memberDetail->lastName;
						
						$memberCounter++; $liCounter++;
						if($liCounter==1) echo $openLi; 
						
						if($memberCounter==1) {echo $openDiv;}
						if($memberCounter<3) {$mr8='mr8';} else $mr8='';
						
						?>
                        <!--box start-->
                        
                        <a target="_blank" href="<?php echo $memberDetailUrl;?>">
							<div class="wp_project_box <?php echo $mr8;?> height226px ptr">
								<div class="dash_link_hover">
									<div class="wp_project_thumb">
										<div class="AI_table">
											<div class="AI_cell"><img class="max_w105_h83" src="<?php echo $thumbFinalImg;?>"></div>
										</div>
									</div>
									<div class="ml13 font_size11 dash_link_hover"><b><?php echo substr_unicode($memberDetail->enterpriseName,0,15);?></b></div>
								</div>	
							  <div class="bdr_BorangeLight ml9 mr9 mt7 "></div>
							  <p class="AP_project_box_txt ml13 mr10 mt11"><?php echo getSubString($memberDetail->optionAreaName,100);?></p>
							   <div class="seprator_10"></div>
							  <?php
										$cravedALL='';
										$countResult=0;
										$loggedUserId=isloginUser();
										if($loggedUserId > 0){
										$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$showcaseEntityId,
										'elementId'=>$memberDetail->showcaseId
										);
										$countResult=countResult('LogCrave',$where);
										$cravedALL=($countResult>0)?'cravedALL':'';
										}else{
										$cravedALL='';
										}
										$ratingAvg=roundRatingValue($memberDetail->ratingAvg);
										$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
								?>
							  
							  <div class="row ml9 mr10">
								   <div class="cell blogS_crave_btn min_w20 <?php echo $cravedALL;?>">
									  <?php echo $memberDetail->craveCount;?>
								   </div>
									 <div class="cell ml10 mt6 Fright">
										<img src="<?php echo $ratingImg;?>">
									</div>
							  </div>
						   </div>
                        </a>
                        
                      <?php
						if($memberCounter==count($member_array)) echo $closeDiv.$closeLi;
						else if($memberCounter==3 && $countmember<count($member_array) && $countmember%9!=0) 
						{
							$memberCounter=0;
							echo '<div class="clear"></div>';	
							echo $closeDiv;
							echo '<div class="seprator_15"></div>';	
						}	
						if($liCounter==6) {$liCounter=0;echo $closeLi;}
						//else  {  $memberCounter=0;echo $closeDiv;}							
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

/**/


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
