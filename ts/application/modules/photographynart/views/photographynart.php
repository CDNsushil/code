<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 	
//Common Banner
	$topCravedArray = array('entityId'=>$projectEntityId,'projectType'=>'photographyNart');
	$topCravedElementArray = array('entityId'=>47,'projectType'=>'photographyNart');
	$topCravedData['defaultProfileImage'] = $this->config->item('photographyNartImage_m');	
	$topCravedData['data'] = topCraved($topCravedArray);
	$topCravedData['elementData'] = topCravedElement($topCravedElementArray);
	
	if(is_array($topCravedData['data']) && count($topCravedData['data'])>0)		
		$topCravedHtml = $this->load->view('common/top_craved_photographynart',$topCravedData,true);
	else
		$topCravedHtml = '';
	
	$bannerarray['imgarray']=array("banner_front_photography-and-art_gallery.jpg","banner_front_photography-and-art_what's-on-wall_HR.jpg");
	$bannerarray['topCravedHtml'] = $topCravedHtml;
	
	echo $this->load->view('common/common_banner',$bannerarray); //common view for image banner placed in main view folder
	//echo $this->load->view('top_banner'); //common view for image banner placed in main view folder

	$openLi ='<li>';
	$closeLi ='</li>';
	$currentMethod = $this->router->class;
	
	$loggedInUser = isLoginUser();
	$goToSectionUrl = '/'.$this->config->item($currentMethod.'_dashboard');
	$goToUpcomingUrl = '/'.$this->config->item('upcoming_dashboard');
	$goToNewsUrl = '/'.$this->config->item('news_dashboard');
	$goToReviewsUrl = '/'.$this->config->item('review_dashboard');
	$href = 'javascript://void(0);'; 
	if(isset($loggedInUser) && $loggedInUser>0) {
		$dashboardSectionUrl = "goTolink('','".base_url(lang().$goToSectionUrl)."')";
		$dashboardUpcomingUrl = "goTolink('','".base_url(lang().$goToUpcomingUrl)."')";
		$dashboardNewsUrl = "goTolink('','".base_url(lang().$goToNewsUrl)."')";
		$dashboardReviewUrl = "goTolink('','".base_url(lang().$goToReviewsUrl)."')";
		$cssLogin="mt7";
	}
	else{
		$cssLogin="mt7";
		
		$dashboardSectionUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->config->item($currentMethod)).".')";
		$dashboardNewsUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('article')).".')";
		$dashboardReviewUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('Reviews')).".')";
		$dashboardUpcomingUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('upcoming')).".')";
	}
	
	$addNewsButton = 	 anchor($href,$this->lang->line('addArticle'),array('onclick'=>$dashboardNewsUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));    
	$addReviewsButton =  anchor($href,$this->lang->line('addReview'),array('onclick'=>$dashboardReviewUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  		    
	$addSectionButton = 	 anchor($href,$this->lang->line('uploadCommonMedia'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  
	$addUpcomingButton = 	 anchor($href,$this->lang->line('promote_upcoming'),array('onclick'=>$dashboardUpcomingUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  
		
		$mlClass="ml40";
		
		if((isset($news_array) && is_array($news_array) && count($news_array) > 0 ) || (isset($reviews_array) && is_array($reviews_array) && count($reviews_array) > 0 )){?>
          <div class="row">
			  
			<?php 
			$newsReview['addNewsButton'] =  $addNewsButton;
			$newsReview['openLi'] =  $openLi;
			$newsReview['closeLi'] =  $closeLi;
			$newsReview['addReviewsButton'] =  $addReviewsButton;
			$newsReview['main_div_class'] =  "cell bdr_lightgreen10 global_shadow bg_white ml40 width_420";
			$newsReview['first_li_class'] =  "wp_tab width_80 wp_tab_selected dash_link_hover";
			$newsReview['second_li_class'] =  "wp_tab width_100 dash_link_hover";
			$newsReview['slider1_main_class'] =  "slider PA_news_scroll_btn_box";
			$newsReview['slider2_main_class'] =  "slider PA_news_scroll_btn_box";
			
			echo $this->load->view('common/news_reviews_landing',$newsReview); 
			?>  
			  
           
            </div>
            <?php
            $mlClass="ml20";
		}?>
            <!--news_and_review_wp-->
            
            <div class="cell">
				<?php if(!empty($proj_array)){?>
              <div class="bdr_lightgreen10 global_shadow bg_white <?php echo $mlClass; ?> width_420">
                <div class="wp_project_heading ml11 clr_666"><?php echo $this->lang->line('LatestProjects');?></div>
                <div class="seprator_3"></div>
                <div id="slider3" class="slider PA_news_scroll_btn_box mt_minus30">
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
                  <div class="viewport wp_project_scroll_container ml10">
                    <ul class="overview">
                       <?php
						//echo '<pre />';
						//print_r($reviews_array);
						$projCounter =0;
						//echo '$proj_array:'.count($proj_array);
						foreach($proj_array as $countproj => $projDetail){ 
						
						$recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$projDetail->tdsUid.'/'.$projDetail->projId.'/photographyart');	
						
						$projUserInfo = showCaseUserDetails($projDetail->tdsUid);
													
						//$thumbFinalImg = getImage(@$projDetail->projBaseImgPath,$this->config->item('photographyNartImage_s'));
						$thumbImage = addThumbFolder(@$projDetail->projBaseImgPath,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$this->config->item('photographyNartImage_s'));
							
						$projCounter++;
						if($projCounter==1) echo $openLi;
						?>
                   
                        <!--box start-->
                       <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >  
                        <div class="wp_project_box">
							<div class="dash_link_hover">
								<div class="wp_project_thumb">
									<div class="AI_table">
									  <div class="AI_cell mediacontainer_img"><img src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
									</div>
								  </div>
								  <div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($projUserInfo['userFullName'],15);?></b></div>
							</div>
                          <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($projDetail->projName,30);?></p>
                          <div class="seprator_16"></div>
                         <?php
									$cravedALL='';
									$countPAResult = 0;
									
									$craveCount=0;
									$ratingAvg=0;
										$LogSummarywhere=array(
											'entityId'=>$projectEntityId,
											'elementId'=>$projDetail->projId
										);
										$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
										if($resLogSummary)
										{
											$resLogSummary = $resLogSummary[0];											
											$craveCount = $resLogSummary->craveCount;
											$ratingAvg = $resLogSummary->ratingAvg;
										}else
										{										
											$craveCount=0;
											$ratingAvg=0;
										}
									$loggedUserId=isloginUser();
									if($loggedUserId > 0){
										$where=array(
											'tdsUid'=>$loggedUserId,
											'entityId'=>$projectEntityId,
											'elementId'=>$projDetail->projId
										);
										$countPAResult=countResult('LogCrave',$where);
										$cravedALL=($countPAResult>0)?'cravedALL':'';
									}else{
										$cravedALL='';
									}
									
									$ratingAvg=roundRatingValue($ratingAvg);
									$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
							?>
                          
                          <div class="row ml9 mr10">
							   <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $projectEntityId.''.$projDetail->projId;?> <?php echo $cravedALL;?>">
								  <?php echo $craveCount;?>
							   </div>
							   <div class="cell ml14 mt6 Fright"><img src="<?php echo $ratingImg;?>" /></div>
                               
                          </div>
                        </div>
                   </a>   
                     
                    <?
						if($projCounter==count($proj_array)) echo $closeLi;
						else if($projCounter==3 && $countproj<count($proj_array)) {  $projCounter=0;echo $closeLi.$openLi;}	
						else  {  $projCounter=0;echo $closeLi;}	
							
					}
                        
                    ?>  
                    </ul>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
              </div>
              <div class="seprator_20"></div>
              <?php 
              } 
              
              if(!empty($upcoming_array)){
			  ?>
              <div class="bdr_lightgreen10 global_shadow bg_white <?php echo $mlClass; ?> width_420">
                <div class="wp_project_heading ml11 clr_666"><?php echo $this->lang->line('LatestUpcomingProjects');?></div>
                <div class="seprator_3"></div>
                <div id="slider4" class="slider PA_news_scroll_btn_box mt_minus30">
				<div class="position_relative mr10">
                	<div class="z_index_2 position_relative">
                 		<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
                 	</div>
                 	<!--FAKEDIV-->
                 	<div class="fakebtn z_index_1">
                 		<span class="buttons next"></span><span class="buttons prev mr3"></span>
                 	</div>
                 	<?php echo $addUpcomingButton;?>
                </div>
                  <div class="viewport wp_project_scroll_container ml10">
                    <ul class="overview">
						<?php
						//echo '<pre />';
						//print_r($reviews_array);
						$upcomingCounter =0;
						//echo '$proj_array:'.count($proj_array);
						foreach($upcoming_array as $countupcoming => $upcomingDetail){ 
						
						$upcomingDetailUrl = base_url(lang().'/upcomingfrontend/viewproject/'.$upcomingDetail['tdsUid'].'/'.$upcomingDetail['projId'].'/photographyart');
							
						$upcomingUserInfo = showCaseUserDetails($upcomingDetail['tdsUid']);
													
						//$thumbFinalImg = getImage(@$upcomingDetail['filePath'].@$upcomingDetail['fileName'],$this->config->item('defaultUpcomingImg_s'));
						$thumbImage = addThumbFolder(@$upcomingDetail['filePath'].@$upcomingDetail['fileName'],'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$this->config->item('defaultUpcomingImg_s'));	
						
						$upcomingCounter++;
						if($upcomingCounter==1) echo $openLi;
						?>
                   
                        <!--box start-->
                       <a href="<?php echo $upcomingDetailUrl;?>" target="_blank" > 
                         <div class="wp_project_box">
							<div class="dash_link_hover">
								<div class="wp_project_thumb">
									<div class="AI_table">
									  <div class="AI_cell mediacontainer_img"><img src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
									</div>
								  </div>
								  <div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($upcomingUserInfo['userFullName'],15);?></b></div>
							</div>
                          <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($upcomingDetail['projTitle'],30);?></p>
                          <div class="seprator_16"></div>
                           <?php
									
									$cravedALL='';
									$countUpcomingResult=0;
									
									$craveUpcomingCount=0;
									$ratingAvg=0;
										$LogSummarywhere=array(
											'entityId'=>$upcomingEntityId,
											'elementId'=>$upcomingDetail['projId']
										);
										$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
										if($resLogSummary)
										{
											$resLogSummary = $resLogSummary[0];											
											$craveUpcomingCount = $resLogSummary->craveCount;
											$ratingAvg = $resLogSummary->ratingAvg;
										}else
										{										
											$craveUpcomingCount=0;
											$ratingAvg=0;
										}
										
									$loggedUserId=isloginUser();
									
									if($loggedUserId > 0)
									{
										$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$upcomingEntityId,
										'elementId'=>$upcomingDetail['projId']
										);
										$countUpcomingResult=countResult('LogCrave',$where);
										$cravedALL=($countUpcomingResult>0)?'cravedALL':'';
									}
									else
									{
										$cravedALL='';
									}
									$ratingAvg=roundRatingValue($ratingAvg);
									$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
							?>
                          <div class="row ml9 mr10">
                            <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $upcomingEntityId.''.$upcomingDetail['projId'];?> <?php echo $cravedALL;?>">
								 <?php echo ($craveUpcomingCount?$craveUpcomingCount:'0');?>
							 </div>
							 <div class="cell ml14 mt6 Fright"><img src="<?php echo $ratingImg;?>" /></div>                      
                          </div>
                        </div>
                    </a>    
                     
                    <?
						if($upcomingCounter==count($upcoming_array)) echo $closeLi;
						else if($upcomingCounter==3 && $countupcoming<count($upcoming_array)) {  $upcomingCounter=0;echo $closeLi.$openLi;}	
						else  {  $upcomingCounter=0;echo $closeLi;}	
						
							
					}
                        
                    ?>
                     
                      
                    </ul>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
              </div>
            <?php 
              } 
			?>
            </div>
            <!--latest_project_and_upcoming_wp-->
			
         
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
