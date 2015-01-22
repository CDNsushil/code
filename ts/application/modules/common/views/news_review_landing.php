<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
 <div class="row">
            <div class="cell bdr_fv10 global_shadow bg_white ml40 width_420">
              <ul id="tabs_link" class="wp_news_tab">
                <li id="tab01" class="wp_tab width_80 wp_tab_selected clr_666"> <?php echo $this->lang->line('News');?></li>
                <!--news_box_tab-->
                <li id="tab02" class="wp_tab width_100 "> <?php echo $this->lang->line('Reviews');?> </li>
                <!--review_box_tab-->
              </ul>
                <div class="news_content_wp" id="tab_content">
              <!--news_content_box-->
              <div class="pl10 pr10 pb10 pt5" id="tab1" >
                  <div id="slider2" class="slider wp_news_scroll_btn_box fv_btn_box"> 
                 <div class="position_relative">
                	<div class="z_index_2 position_relative">
                 		<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
                 	</div>
                 	<!--FAKEDIV-->
                 	<div class="fakebtn z_index_1">
                 		<span class="buttons next"></span><span class="buttons prev mr3"></span>
                 	</div>
                </div>
                    <div class="viewport wp_news_scroll_container">
                      <ul class="overview">						
						<?php
						//print_r($news_array);die;
						$newsCounter =0;
						$openLi ='<li>';
						$closeLi ='</li>';
						foreach($news_array as $countNews => $newsDetail){ 
						
						$userInfo = showCaseUserDetails($newsDetail->projuserid);						
						$thumbImage = addThumbFolder(@$newsDetail->imagePath,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$this->config->item('defaultNewsImg_s'));
						
										 
						$newsDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$newsDetail->projuserid.'/'.$newsDetail->projectid.'/'.$newsDetail->elementId.'/news/filmNvideo/piece');
						
						$newsCounter++;
						if($newsCounter ==1) echo $openLi;
						switch ($newsCounter)
						{
						  case 1:					  
						 
						  ?>
							  <div class="wp_news_top_box">
							  <div class="wp_news_heading_first"><a href="<?php echo $newsDetailUrl;?>" target="_blank" class="wp_news_heading_first"><?php echo getSubString($newsDetail->title,25);?></a></div>
							  <div class="wp_news_thumb Fleft"><div class="AI_table">
								  <div class="AI_cell"><a href="<?php echo $newsDetailUrl;?>" target="_blank" ><img class="max_w138_h96" src="<?php echo $thumbFinalImg;?>" /></a></div></div></div>
							  <div class="width_252 Fleft ml8">
								<div class="wp_news_postedby mt_minus_2"><?php echo $userInfo['userFullName'];?></div>
								<div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->createdDate));?></div>
								<div class="clr_555">
									<?php  if(($newsDetail->description ==null || empty($newsDetail->description)) && isset($newsDetail->article) ){ echo changeToUrl(getSubString($newsDetail->article,100)); }else{ echo changeToUrl(getSubString($newsDetail->description,100)); }?>
								</div>
							  </div>
							  
							  </div>
							   <div class="clear seprator_10"></div>
						  <?php
						  break;
						  case 2:
						  
						  ?>
						  <div class="cell bdr_Rgrey20per pr10">
                            	<div class="wp_news_left_box bdr_Bgrey20per">
                                <div class="wp_news_heading_second"><a  href="<?php echo $newsDetailUrl;?>" target="_blank" class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></a></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt15">
									<?php 
									if(($newsDetail->description ==null || empty($newsDetail->description)) && isset($newsDetail->article) ){
										echo changeToUrl(getSubString($newsDetail->article,100));
									}else{
										echo changeToUrl(getSubString($newsDetail->description,100));
									}
									?>
									
							    </div></div>
                                <div class="seprator_10"></div>
                            
						  <?php
						  break;
						  case 3:
						  
						  ?>
						   <div class="wp_news_left_box">
                                <div class="wp_news_heading_second"><a  href="<?php echo $newsDetailUrl;?>" target="_blank"  class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></a></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt15">
									<?php 
									if(($newsDetail->description ==null || empty($newsDetail->description)) && isset($newsDetail->article) ){
										echo changeToUrl(getSubString($newsDetail->article,100));
									}else{
										echo changeToUrl(getSubString($newsDetail->description,100));
									}
									?>
									
								</div></div>
                            </div>
						  <?php
						break;
						case 4:
						
						$imgDetail = getMediaDetail(@$newsDetail->fileId);						
						
						?>
						<div class="cell pl13">
                            	<div class="wp_news_right_box ">
                                <div class="wp_news_heading_second"><a href="<?php echo $newsDetailUrl;?>" target="_blank"  class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></a></div>
 
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date pb18"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="wp_news_thumb_right"><div class="AI_table">
                              <div class="AI_cell"><a href="<?php echo $newsDetailUrl;?>" target="_blank" ><img class="max_w171_h107" src="<?php echo $thumbFinalImg;?>"/></a></div></div></div>
                                <div class="clr_555 pt15">
									
									<?php 
									if(($newsDetail->description ==null || empty($newsDetail->description)) && isset($newsDetail->article) ){
										echo changeToUrl(getSubString($newsDetail->article,100));
									}else{
										echo changeToUrl(getSubString($newsDetail->description,100));
									}
									?>
									
								</div></div>
                                <div class="seprator_10"></div>
                                
                            </div>                     
                         <div class="clear"></div>
						<?php
						break;
						
						}
						if(($newsCounter > 4) || ($newsCounter == count($news_array))) {$newsCounter=0;echo $closeLi;}		
					}
					?>
					</ul>
					</div><!-- End viewport wp_news_scroll_container-->
				</div><!-- End slider2 -->
			 </div><!-- End tab1 -->
		</div><!-- End news_content_wp -->
                <!--reviews_content_box-->
                <div class="pl10 pr10 pb10 pt5" id="tab2" style="display:none;">
                  <div id="slider1" class="slider wp_news_scroll_btn_box fv_btn_box">
				<div class="position_relative">
                	<div class="z_index_2 position_relative">
                 		<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
                 	</div>
                 	<!--FAKEDIV-->
                 	<div class="fakebtn z_index_1">
                 		<span class="buttons next"></span><span class="buttons prev mr3"></span>
                 	</div>
                </div>
                    <div class="viewport wp_news_scroll_container">
                      <ul class="overview">
                       <?php
						//echo '<pre />';
						//print_r($reviews_array);
						$reviewsCounter =0;
						//echo '$reviews_array:'.count($reviews_array);
						$countReview = count($reviews_array);
						$revCount =1;
						foreach($reviews_array as $countreviews => $reviewsDetail){ 
						
						$revCount;
						$reviewUserInfo = showCaseUserDetails($reviewsDetail->projuserid);
							
						$thumbImage = addThumbFolder(@$reviewsDetail->imagePath,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$this->config->item('defaultReviewsImg_s'));	
						
						$reviewsCounter++;
						$reviewsDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$reviewsDetail->projuserid.'/'.$reviewsDetail->projectid.'/'.$reviewsDetail->elementId.'/reviews/filmNvideo/piece');
						if($reviewsCounter==1) echo $openLi;
						?>
						<a href="<?php echo $reviewsDetailUrl;?>" target="_blank" >
                          <div class="wp_new_box">
                            <div class="cell width_114">
                              <div class="blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img  src="<?php echo $thumbFinalImg;?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name"><?php echo getSubString($reviewUserInfo['userFullName'],15);?></div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_252 ml10">
                              <div class="clr_555 lineH13"><b><?php echo getSubString($reviewsDetail->title,40);?></b></div>
                              <div class="wp_blog_profile_date"><?php echo date("d F Y", strtotime($reviewsDetail->modifyDate));?></div>

                              <div class="clr_555 minH50">
								  <?php if(($reviewsDetail->description ==null || empty($reviewsDetail->description)) && isset($reviewsDetail->article) ){ echo changeToUrl(getSubString($reviewsDetail->article,100));}else{echo changeToUrl(getSubString($reviewsDetail->description,100));}?>
								  </div>

                              <!--status bar-->
                                <?php
									
									$cravedALL='';
									$countResult=0;
									$loggedUserId=isloginUser();
									
									if($loggedUserId > 0)
									{
										$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$reviewEntityId,
										'elementId'=>$reviewsDetail->elementId
										);
										$countResult=countResult('LogCrave',$where);
										$cravedALL=($countResult>0)?'cravedALL':'';
									}
									else
									{
										$cravedALL='';
									}
							?>

                              <div class="row pt15 font_size10">
								
								  <div class="cell blogS_crave_btn min_w20 craveDiv<?php echo $reviewEntityId.''.$reviewsDetail->elementId;?> <?php echo $cravedALL;?>">
									<?php echo ($reviewsDetail->craveCount?$reviewsDetail->craveCount:'0');?>
								  </div>                    
                                 
                                  <?php $this->load->view('rating/ratingAvg',array('elementId'=>$reviewsDetail->elementId,'entityId'=>$reviewEntityId,'ratingClass'=>'cell mt5 mr20 '));?>                             
                                <span class=" cell blogS_view_btn"><?php echo ($countCrave = ($reviewsDetail->viewCount)?$reviewsDetail->viewCount:'0');?></span> <span class="Fright"><?php echo $revCount .' / '. $countReview ?></span> </div>

                            </div>
                            <div class="clear"></div>
                          </div>
                        </a>    
						<?
						if($reviewsCounter<3) echo '<div class="seprator_10"></div>';
						if($reviewsCounter==count($reviews_array)) echo $closeLi;
						if($reviewsCounter==3 && $countreviews<count($reviews_array)) {  $reviewsCounter=0;echo $closeLi;}	
						
						$revCount++;
						}                        
						?>                                             
                      </ul>
                    </div>
                  </div>
                </div>
                
              </div>
              
            </div>
           
           
