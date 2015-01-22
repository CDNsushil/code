<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
 
//Common Banner
	$topCravedArray = array('entityId'=>$workEntityId,'projectType'=>'work');
	$topCravedData['data'] = topCraved($topCravedArray);
	//$topCravedData['data'] = '';
	if(is_array($topCravedData['data']) && count($topCravedData['data'])>0){	
		if(strcmp($topCravedData['data']['workType'],'wanted')==0)
			$topCravedData['defaultProfileImage'] = $this->config->item('defaultWorkWanted_m');
		else
			$topCravedData['defaultProfileImage'] = $this->config->item('defaultWorkOffered_m');
			
		$topCravedHtml = $this->load->view('common/top_craved_work',$topCravedData,true);
	}
	else
		$topCravedHtml = '';
				
	$bannerarray['imgarray']=array('banner_front_work_find-colleagues_HR.jpg','banner_front_work_get-working-copy_HR.jpg');
	$bannerarray['topCravedHtml'] = $topCravedHtml;
	
	echo $this->load->view('common/common_banner',$bannerarray); //common view for image banner placed in main view folder

$currentMethod = $this->router->class;
	
	
	$loggedInUser = isLoginUser();
	$goToSectionUrl = '/'.$this->config->item($currentMethod.'_dashboard');
	
	$href = 'javascript://void(0);'; 
	if(isset($loggedInUser) && $loggedInUser>0) {
		$dashboardSectionUrl = "goTolink('','".base_url(lang().$goToSectionUrl)."')";		
		$cssLogin="mt7";
	}
	else{
		$cssLogin="mt7";		
		$dashboardSectionUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->config->item($currentMethod)).".')";	
	}
	
	$addSectionButton = 	 anchor($href,$this->lang->line('uploadButtonAdvertise'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn'));  

       //  echo '<pre />';
        // print_r($workWanted_array);die;
         $openLi ='<li>';
		 $closeLi ='</li>';
         $urgent_array =array();
         $exp_array =array();
         $normal_array =array();
         $wanted_urgent_array =array();
         $wanted_exp_array =array();
         $wanted_normal_array =array();
         
         foreach($workOffered_array as $k => $workDetail)
         {			 
			if($workDetail->isUrgent=='t'){
				$urgent_array[]=$workDetail;
			}	 
			else if($workDetail->workExperiece=='t'){
				$exp_array[]=$workDetail;
			}	 
			else if ($workDetail->isUrgent=='f' && $workDetail->workExperiece=='f'){
				$normal_array[]=$workDetail;
			}	 
		}
		
         foreach($workWanted_array as $k => $workWantedDetail)
         {
			if($workWantedDetail->workExperiece=='t') $wanted_exp_array[]=$workWantedDetail;
			else $wanted_normal_array[]=$workWantedDetail;			 
		 }
		//echo '<pre />';print_r($urgent_array);
		//echo '<pre />';print_r($exp_array);
		//echo '<pre />';print_r($normal_array);
	   //$urgent_array =array();
      // $exp_array =array();
     //  $normal_array =array();
       //$wanted_urgent_array =array();
       //$wanted_exp_array =array();
      // $wanted_normal_array =array();
        ?>
        <div class="row">
        <div class="cell">
		<?php if(!empty($urgent_array) && !empty($normal_array)){ ?>
			<div class="bdr_Dgreen10 global_shadow bg_white ml40 width_420">

			<ul id="tabs_link" class="wp_news_tab work_tab_box">
			<?php if(!empty($urgent_array)){ ?>
			<li id="tab01" class="wp_tab width_80 wp_tab_selected clr_Dgreen dash_link_hover"><?php echo $this->lang->line('Urgent');?></li>
			<!--news_box_tab-->
			<?php } if(!empty($normal_array)){ ?>
			<li id="tab02" class="wp_tab width_100 clr_Dgreen min_w200 dash_link_hover"><?php echo $this->lang->line('LatestWorkOffered');?></li>
			<!--review_box_tab-->
			<?php } ?>
			</ul>
			<!--<div class="wp_project_heading ml11 clr_Dgreen font_opensans" id="tabs_link"><a id="tab01" class="clr_Dgreen font_opensans font_opensansSBold">Urgent</a> <a class="ml30 clr_Dgreen font_opensans" id="tab02">Latest Work Offered</a></div>-->
			<div class="seprator_3"></div>

			<div class="news_content_wp" id="tab_content">
				<?php if(!empty($urgent_array)){ ?>
				<div id="tab1">
					 <div id="slider1" class="slider work_project_scroll_btn_box mt_minus30">
						
				 <div class="position_relative">
					<div class="z_index_2 position_relative">
						<a class="buttons next" href="#"></a><a class="buttons prev mr3 disable" href="#"></a>
					</div>
					<!--FAKEDIV-->
					<div class="fakebtn z_index_1">
						<span class="buttons next"></span><span class="buttons prev mr3"></span>
					</div>
					
					<?php //echo $addSectionButton;?>
					
				</div>
				  <div class="viewport wp_project_scroll_container ml10">
					<ul class="overview">
					<?php
					//echo '<pre />';
				
					$urgentCounter =0;
					//echo '$urgent_array:'.count($urgent_array);
					
					foreach($urgent_array as $counturgent => $urgentDetail){ 
					//echo '<pre />';print_r($urgentDetail);die;
					$urgentDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$urgentDetail->tdsUid.'/'.$urgentDetail->workId);
					
					$urgentUserInfo = showCaseUserDetails($urgentDetail->tdsUid);
					
					if(strcmp(@$urgentDetail->workType,'wanted')==0)
					$default_urgent_Image = $this->config->item('defaultWorkWanted_s');
					else
					$default_urgent_Image = $this->config->item('defaultWorkOffered_s');
						
					$thumbImage = addThumbFolder(@$urgentDetail->filePath.@$urgentDetail->fileName,'_s');				
					$thumbFinalImg = getImage(@$thumbImage,$default_urgent_Image);
					//$thumbFinalImg = getImage(@$urgentDetail->filePath.@$urgentDetail->fileName,$default_urgent_Image);
					$urgentCounter++;
					//if($urgentCounter==1) echo $openLi;
					echo $openLi;
					?>
						<!--box start-->
					<a href="<?php echo $urgentDetailUrl;?>" target="_blank">    
						<div class="wp_project_box">
							<div class="dash_link_hover">
								<div class="wp_project_thumb">
									<div class="AI_table">
										<div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
									</div>
								</div>
								<div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($urgentUserInfo['userFullName'],15);?></b></div>
							</div>
						  <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($urgentDetail->workTitle,25);?></p>
						  <div class="seprator_10"></div>
						 <?php
								
							$cravedALL='';
							$countWorkResult = 0;		
							$work_craveCount=0;
							$work_ratingAvg=0;
							
							$LogSummarywhere=array(
								'entityId'=>$workEntityId,
								'elementId'=>$urgentDetail->workId
							);
							
							$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
							
							if($resLogSummary)
							{
								$resLogSummary = $resLogSummary[0];											
								$work_craveCount = $resLogSummary->craveCount;
								$work_ratingAvg = $resLogSummary->ratingAvg;
							}else
							{										
								$work_craveCount=0;
								$work_ratingAvg=0;
							}
								
							$loggedUserId = isloginUser();
							
							if($loggedUserId > 0)
							{
								$whereWork=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$urgentDetail->workId
								);
								$countWorkResult=countResult('LogCrave',$whereWork);
								$cravedALL=($countWorkResult>0)?'cravedALL':'';
							}
							else
							{
								$cravedALL='';
							}
							
							$work_ratingAvg=roundRatingValue($work_ratingAvg);
							$work_ratingImg=base_url().'images/rating/rating_0'.$work_ratingAvg.'.png';
						?>
						<div class="row ml9 mr10">
							<div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $workEntityId.''.$urgentDetail->workId;?> <?php echo $cravedALL;?>">
							  <?php echo $work_craveCount;?>
						 </div>
						  <div class="cell ml10 mt6 Fright"><img src="<?php echo $work_ratingImg;?>" />  
						</div>
						</div>
					</div>
				   </a>     
					 <?
					 echo $closeLi;
					 
					//if($urgentCounter<3) echo '<div class="seprator_10"></div>';
					//if($urgentCounter==count($urgent_array)) echo $closeLi;
					//if($urgentCounter==3 && $counturgent<count($urgent_array)) {  $urgentCounter=0;echo $closeLi;}						
						
					}                        
					?>
					</ul>
				  </div>
				</div>
				</div>
				</div>
				<?php } if(!empty($normal_array)){?>
				<div id="tab2" style="display:none">
				 <div id="slider5" class="slider work_project_scroll_btn_box mt_minus30">
							
				 <div class="position_relative">
					<div class="z_index_2 position_relative">
						<a class="buttons next" href="#"></a><a class="buttons prev mr3 disable" href="#"></a>
					</div>
					<!--FAKEDIV-->
					<div class="fakebtn z_index_1">
						<span class="buttons next"></span><span class="buttons prev mr3"></span>
					</div>
					
					
					<?php //echo $addSectionButton;?>
					
				</div>
				
			  <div class="viewport wp_project_scroll_container ml10">
				<ul class="overview">
				  
					 <?php
					//echo '<pre />';
					//print_r($reviews_array);
					$normalCounter =0;
					//echo '$normal_array:'.count($normal_array);
					foreach($normal_array as $countnormal => $normalDetail){ 
					
					$normalDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$normalDetail->tdsUid.'/'.$normalDetail->workId);
						
					$normalUserInfo = showCaseUserDetails($normalDetail->tdsUid);
						
					if(strcmp(@$expDetail->workType,'wanted')==0)
					$default_normal_Image = $this->config->item('defaultWorkWanted_s');
					else
					$default_normal_Image = $this->config->item('defaultWorkOffered_s');
					
					$thumbImage = addThumbFolder(@$normalDetail->filePath.@$normalDetail->fileName,'_s');				
					$thumbFinalImg = getImage(@$thumbImage,$default_normal_Image);
					
					//$thumbFinalImg = getImage(@$normalDetail->filePath.@$normalDetail->fileName,$default_normal_Image);
					
					$normalCounter++;
					//if($normalCounter==1) echo $openLi;
					echo $openLi;
					?>
						<!--box start-->
					<a href="<?php echo $normalDetailUrl;?>" target="_blank">    
						<div class="wp_project_box">
							<div class="dash_link_hover">
								<div class="wp_project_thumb">
									<div class="AI_table">
										<div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
									</div>
								</div>
								<div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($normalUserInfo['userFullName'],15);?></b></div>
							</div>
						  <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($normalDetail->workTitle,25);?></p>
						  <div class="seprator_10"></div>
						  <?php									
							$countWorkResult = 0;
							$cravedALL = '';
							$work_craveCount=0;
							$work_ratingAvg=0;
							
							$LogSummarywhere=array(
								'entityId'=>$workEntityId,
								'elementId'=>$normalDetail->workId
							);
							
							$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
							
							if($resLogSummary)
							{
								$resLogSummary = $resLogSummary[0];											
								$work_craveCount = $resLogSummary->craveCount;
								$work_ratingAvg = $resLogSummary->ratingAvg;
							}else
							{										
								$work_craveCount=0;
								$work_ratingAvg=0;
							}
								
							$loggedUserId = isloginUser();
							
							if($loggedUserId > 0)
							{
								$whereWork=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$normalDetail->workId
								);
								$countWorkResult=countResult('LogCrave',$whereWork);
								$cravedALL=($countWorkResult>0)?'cravedALL':'';
							}
							else
							{
								$cravedALL='';
							}
							
							$work_ratingAvg=roundRatingValue($work_ratingAvg);
							$work_ratingImg=base_url().'images/rating/rating_0'.$work_ratingAvg.'.png';
							
						?>
						<div class="row ml9 mr10">
							<div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $workEntityId.''.$normalDetail->workId;?> <?php echo $cravedALL;?>">
							  <?php echo $work_craveCount;?>
						 </div>
						  
						 <div class="cell ml10 mt6 Fright"><img src="<?php echo $work_ratingImg;?>" /> </div>
						</div>
						</div>
					</a>    
					 <?
					 echo $closeLi;
					//if($normalCounter<3) echo '<div class="seprator_10"></div>';
					//if($normalCounter==count($normal_array)) echo $closeLi;
					//if($normalCounter==3 && $countnormal<count($normal_array)) {  $normalCounter=0;echo $closeLi;}	
						
					}
											
					?>
					</ul> </div>
			</div>
				 </div>
				<?php } ?>
			


			<div class=" clear seprator_10"></div>
			<!--latest_project_slider_heading-->
			</div>
		
              <div class="seprator_20"></div>
           <?php } if(!empty($exp_array)){?>
              <div class="bdr_Dgreen10 global_shadow bg_white ml40 width_420">
                <div class="wp_project_heading ml11 clr_Dgreen"><?php echo $this->lang->line('LatestWorkExperienceOffered');?></div>
                <div class="seprator_3"></div>
                <div id="slider2" class="slider work_project_scroll_btn_box mt_minus30"> 
                	
					 <div class="position_relative">
						<div class="z_index_2 position_relative">
							<a class="buttons next" href="#"></a><a class="buttons prev mr3 disable" href="#"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						
						
						<?php //echo $addSectionButton;?>
						
					</div>
					
                  <div class="viewport wp_project_scroll_container ml10">
                    <ul class="overview">
                        <?php
						//echo '<pre />';
						//print_r($reviews_array);
						$expCounter =0;
						//echo '$exp_array:'.count($exp_array);
						foreach($exp_array as $countexp => $expDetail){ 
						
						$expDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$expDetail->tdsUid.'/'.$expDetail->workId);
							
						$expUserInfo = showCaseUserDetails($expDetail->tdsUid);
						
							
						if(strcmp(@$expDetail->workType,'wanted')==0)
						$default_ex_Image = $this->config->item('defaultWorkWanted_s');
						else
						$default_ex_Image = $this->config->item('defaultWorkOffered_s');
						
						$thumbImage = addThumbFolder(@$expDetail->filePath.@$expDetail->fileName,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$default_ex_Image);	
						//$thumbFinalImg = getImage(@$expDetail->filePath.@$expDetail->fileName,$default_ex_Image);
						$expCounter++;
						//if($expCounter==1) echo $openLi;
						echo $openLi;
						?>
                            <!--box start-->
                        <a href="<?php echo $expDetailUrl;?>" target="_blank">    
                            <div class="wp_project_box">
								<div class="dash_link_hover">
									<div class="wp_project_thumb">
										<div class="AI_table">
											<div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
										</div>
									</div>
									<div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($expUserInfo['userFullName'],15);?></b></div>
								</div>
                              <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($expDetail->workTitle,25);?></p>
                              <div class="seprator_10"></div>
                             <?php
									
							$countWorkResult = 0;
							$cravedALL = '';
							$work_craveCount=0;
							$work_ratingAvg=0;
							
							$LogSummarywhere=array(
								'entityId'=>$workEntityId,
								'elementId'=>$expDetail->workId
							);
							
							$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
							
							if($resLogSummary)
							{
								$resLogSummary = $resLogSummary[0];											
								$work_craveCount = $resLogSummary->craveCount;
								$work_ratingAvg = $resLogSummary->ratingAvg;
							}else
							{										
								$work_craveCount=0;
								$work_ratingAvg=0;
							}
								
							$loggedUserId = isloginUser();
							
							if($loggedUserId > 0)
							{
								$whereWork=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$expDetail->workId
								);
								$countWorkResult=countResult('LogCrave',$whereWork);
								$cravedALL=($countWorkResult>0)?'cravedALL':'';
							}
							else
							{
								$cravedALL='';
							}
							
							$work_ratingAvg=roundRatingValue($work_ratingAvg);
							$work_ratingImg=base_url().'images/rating/rating_0'.$work_ratingAvg.'.png';
							
							
							?>
                            <div class="row ml9 mr10">
                                <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $workEntityId.''.$expDetail->workId;?> <?php echo $cravedALL;?>">
								  <?php echo $work_craveCount;?>
							 </div>
                             <div class="cell ml10 mt6 Fright"><img src="<?php echo $work_ratingImg;?>" /> </div>
                            </div>
                            </div>
                      </a>
                     <?						
						 echo $closeLi;
						 //if($expCounter==count($exp_array)) echo $closeLi;
						//else if($expCounter==1 && $countexp<count($exp_array)) {  $expCounter=0;echo $closeLi.$openLi;}	
						//else  {  $expCounter=0;echo $closeLi;}	
							
					}
                        
                    ?>
                    </ul>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
              </div>
            <?php } ?> 
          </div>
          
            <div class="cell">
				  <?php if(!empty($wanted_normal_array)){?>
              <div class="bdr_Dgreen10 global_shadow bg_white ml20 width_420">
                <div class="wp_project_heading ml11 clr_Dgreen"><?php echo $this->lang->line('LatestWorkWanted');?></div>
                <div class="seprator_3"></div>
                <div id="slider3" class="slider work_project_scroll_btn_box mt_minus30">
						
					 <div class="position_relative">
						<div class="z_index_2 position_relative">
							<a class="buttons next" href="#"></a><a class="buttons prev mr3 disable" href="#"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						
						
						<?php //echo $addSectionButton;?>
						
					</div>
					
                  <div class="viewport wp_project_scroll_container ml10">
                    <ul class="overview">
                        <?php
						//echo '<pre />';
						//print_r($reviews_array);
						$wanted_normalCounter =0;
						//echo '$wanted_normal_array:'.count($wanted_normal_array);
						foreach($wanted_normal_array as $countwanted_normal => $wanted_normalDetail){ 
						
						$wanted_normalDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$wanted_normalDetail->tdsUid.'/'.$wanted_normalDetail->workId);
							
						$wanted_normalUserInfo = showCaseUserDetails($wanted_normalDetail->tdsUid);
							
						if(strcmp(@$wanted_normalDetail->workType,'wanted')==0)
						$default_wa_nor_Image = $this->config->item('defaultWorkWanted_s');
						else
						$default_wa_nor_Image = $this->config->item('defaultWorkOffered_s');
						
						$thumbImage = addThumbFolder(@$wanted_normalDetail->filePath.@$wanted_normalDetail->fileName,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$default_wa_nor_Image);	
						
						//$thumbFinalImg = getImage(@$wanted_normalDetail->filePath.@$wanted_normalDetail->fileName,$default_wa_nor_Image);
						$wanted_normalCounter++;
						//if($wanted_normalCounter==1) echo $openLi;
						echo $openLi;
						?>
                            <!--box start-->
                        <a href="<?php echo $wanted_normalDetailUrl;?>" target="_blank">    
                            <div class="wp_project_box">
								<div class="dash_link_hover">
									<div class="wp_project_thumb">
										<div class="AI_table">
											<div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
										</div>
									</div>
									<div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($wanted_normalUserInfo['userFullName'],15);?></b></div>
								</div>
                              <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($wanted_normalDetail->workTitle,25);?></p>
                              <div class="seprator_10"></div>
                                <?php
									
							$countWorkResult = 0;
							$cravedALL = '';
							$work_craveCount=0;
							$work_ratingAvg=0;
							
							$LogSummarywhere=array(
								'entityId'=>$workEntityId,
								'elementId'=>$wanted_normalDetail->workId
							);
							
							$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
							
							if($resLogSummary)
							{
								$resLogSummary = $resLogSummary[0];											
								$work_craveCount = $resLogSummary->craveCount;
								$work_ratingAvg = $resLogSummary->ratingAvg;
							}else
							{										
								$work_craveCount=0;
								$work_ratingAvg=0;
							}
								
							$loggedUserId = isloginUser();
							
							if($loggedUserId > 0)
							{
								$whereWork=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$wanted_normalDetail->workId
								);
								$countWorkResult=countResult('LogCrave',$whereWork);
								$cravedALL=($countWorkResult>0)?'cravedALL':'';
							}
							else
							{
								$cravedALL='';
							}
							
							$work_ratingAvg=roundRatingValue($work_ratingAvg);
							$work_ratingImg=base_url().'images/rating/rating_0'.$work_ratingAvg.'.png';
							
							?>
                            <div class="row ml9 mr10">
                                <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $workEntityId.''.$wanted_normalDetail->workId;?> <?php echo $cravedALL;?>">
								  <?php echo $countWorkResult;?>
							 </div>
                              <?php $this->load->view('rating/ratingAvg',array('elementId'=>$wanted_normalDetail->workId,'entityId'=>$workEntityId,'ratingClass'=>'cell ml10 mt6 Fright'));?>
                            </div>
                            </div>
                        </a>    
                         <?
						//if($wanted_normalCounter<2) echo $closeLi;
						if($wanted_normalCounter==count($wanted_normal_array)) echo $closeLi;
						if($wanted_normalCounter==1 && $countwanted_normal<count($wanted_normal_array)) {  $wanted_normalCounter=0;echo $closeLi;}	
							
					}
                    ?>
                    </ul>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
              </div>
              <div class="seprator_20"></div>
                <?php }if(!empty($wanted_exp_array)){?>
              <div class="bdr_Dgreen10 global_shadow bg_white ml20 width_420">
                <div class="wp_project_heading ml11 clr_Dgreen"><?php echo $this->lang->line('LatestWorkExperienceWanted');?></div>
                <div class="seprator_3"></div>
                <div id="slider4" class="slider work_project_scroll_btn_box mt_minus30">
						
					 <div class="position_relative">
						<div class="z_index_2 position_relative">
							<a class="buttons next" href="#"></a><a class="buttons prev mr3 disable" href="#"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						
						<?php //echo $addSectionButton;?>
					</div>
					
                  <div class="viewport wp_project_scroll_container ml10">
                   <?php
						//echo '<pre />';
						//print_r($reviews_array);
						
						$wanted_expCounter =0;
						//echo '$wanted_exp_array:'.count($wanted_exp_array);
						foreach($wanted_exp_array as $countwanted_exp => $wanted_expDetail){ 
						
						$wanted_expDetailUrl = base_url(lang().'/workshowcase/viewproject/'.$wanted_expDetail->tdsUid.'/'.$wanted_expDetail->workId);
							
						$wanted_expUserInfo = showCaseUserDetails($wanted_expDetail->tdsUid);
						
						if(strcmp(@$wanted_expDetail->workType,'wanted')==0)
						$default_wa_ex_Image = $this->config->item('defaultWorkWanted_s');
						else
						$default_wa_ex_Image = $this->config->item('defaultWorkOffered_s');
						
						
						$thumbImage = addThumbFolder(@$wanted_expDetail->filePath.@$wanted_expDetail->fileName,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$default_wa_ex_Image);	
							
						//$thumbFinalImg = getImage(@$wanted_expDetail->filePath.@$wanted_expDetail->fileName,$default_wa_ex_Image);
						$wanted_expCounter++;
						//if($wanted_expCounter==1) echo $openLi;
						echo $openLi;
						?>
                            <!--box start-->
                        <a href="<?php echo $wanted_expDetailUrl;?>" target="_blank">    
                            <div class="wp_project_box ml10">
								<div class="dash_link_hover">
									<div class="wp_project_thumb">
										<div class="AI_table">
											<div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="max_w105_h83" /></div>
										</div>
									</div>
									<div class="ml13 font_size11 dash_link_hover"><b><?php echo getSubString($wanted_expUserInfo['userFullName'],15);?></b></div>
								</div>
                              <p class="ml13 mr10 lineH13 font_size11 mt7 minMaxHeight27px"><?php echo getSubString($wanted_expDetail->workTitle,25);?></p>
                              <div class="seprator_10"></div>
                              <?php
									
									$countWorkResult = 0;
							$cravedALL = '';
							$work_craveCount=0;
							$work_ratingAvg=0;
							
							$LogSummarywhere=array(
								'entityId'=>$workEntityId,
								'elementId'=>$wanted_expDetail->workId
							);
							
							$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
							
							if($resLogSummary)
							{
								$resLogSummary = $resLogSummary[0];											
								$work_craveCount = $resLogSummary->craveCount;
								$work_ratingAvg = $resLogSummary->ratingAvg;
							}else
							{										
								$work_craveCount=0;
								$work_ratingAvg=0;
							}
								
							$loggedUserId = isloginUser();
							
							if($loggedUserId > 0)
							{
								$whereWork=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$wanted_expDetail->workId
								);
								$countWorkResult=countResult('LogCrave',$whereWork);
								$cravedALL=($countWorkResult>0)?'cravedALL':'';
							}
							else
							{
								$cravedALL='';
							}
							
							$work_ratingAvg=roundRatingValue($work_ratingAvg);
							$work_ratingImg=base_url().'images/rating/rating_0'.$work_ratingAvg.'.png';
							
							?>
                            <div class="row ml9 mr10">
                                <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $workEntityId.''.$wanted_expDetail->workId;?> <?php echo $cravedALL;?>">
								  <?php echo $work_craveCount;?>
							 </div>
                                <div class="cell ml10 mt6 Fright"><img src="<?php echo $work_ratingImg;?>" /> </div>
                            </div>
                            </div>
                        </a>    
                        <?
						if($wanted_expCounter==count($wanted_exp_array)) echo $closeLi;
						else if($wanted_expCounter==1 && $countwanted_exp<count($wanted_exp_array)) {  $wanted_expCounter=0;echo $closeLi.$openLi;}	
						else  {  $wanted_expCounter=0;echo $closeLi;}	
						
							
					}
                        
                    ?>
                  </div>
                </div>
                <div class=" clear seprator_10"></div>
                <!--latest_project_slider_heading-->
              </div>
           <?php } ?>
            </div>
            <!--latest_project_and_upcoming_wp-->
            <div class="clear"></div>
          </div>
          <div class="seprator_40"></div>
              
<script type="text/javascript">

$("#show_searchbox").click(function () {

});
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
