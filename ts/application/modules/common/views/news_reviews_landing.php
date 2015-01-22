<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="<?php echo $main_div_class; ?>">
              <ul id="tabs_link" class="wp_news_tab">
				 <?php if(!empty($news_array)){?>
                <li id="tab01" class="<?php echo $first_li_class ?>"><?php echo $this->lang->line('News');?> </li>
                <!--news_box_tab-->
                <?php } ?>
                <?php if(!empty($reviews_array)){?>
                <li id="tab02" class="<?php echo $second_li_class; ?>"> <?php echo $this->lang->line('Reviews');?> </li>
                <?php } ?>
                <!--review_box_tab-->
              </ul>
              
                <div class="news_content_wp" id="tab_content">
              <!--news_content_box-->
              <div class="pl10 pr10 pb10 pt5" id="tab1" >
                  <div id="slider2" class="<?php echo $slider2_main_class; ?>"> 
                 	<div class="position_relative">
						<div class="z_index_2 position_relative">
							<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						<?php echo $addNewsButton;?>
					</div>
                    <div class="viewport wp_news_scroll_container">
                      <ul class="overview">
						
						<?php
						//print_r($news_array);die;
						$newsCounter =0;
						foreach($news_array as $countNews => $newsDetail){ 						
						
						$userInfo = showCaseUserDetails($newsDetail->projuserid);													
													
						$thumbImage = addThumbFolder(@$newsDetail->imagePath,'_s');				
						$thumbFinalImg = getImage(@$thumbImage,$this->config->item('defaultNewsImg_s'));
						//echo '<pre />';print_r($newsDetail);
						$newsLink=base_url(lang().'/mediafrontend/searchresult/'.$newsDetail->projuserid.'/'.$newsDetail->projectid.'/'.$newsDetail->elementId.'/news');

						$newsCounter++;
						if($newsCounter ==1) echo $openLi;
						switch ($newsCounter)
						{
						  case 1:					  
						 
						  ?>
							  <div class="wp_news_top_box">
							  <div class="wp_news_heading_first"><a target="_blank" href="<?php echo $newsLink;?>" class="wp_news_heading_first dash_link_hover"><?php echo getSubString($newsDetail->title,25);?></a></div>
							  <div class="wp_news_thumb Fleft"><div class="AI_table">
								  <div class="AI_cell"><a target="_blank" href="<?php echo $newsLink;?>"><img class="max_w138_h96" src="<?php echo $thumbFinalImg;?>" /></a></div></div></div>
							  <div class="width_252 Fleft ml8">
								<div class="wp_news_postedby mt_minus_2"><?php echo $userInfo['userFullName'];?></div>
								<div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->createdDate));?></div>
								<div class="clr_555"><?php echo changeToUrl(getSubString($newsDetail->description,100));?></div>
							  </div>
							  
							  </div>
							   <div class="clear seprator_5"></div>
						  <?php
						  break;
						  case 2:
						  
						  ?>
						  <div class="cell bdr_Rgrey20per pr10">
                            	<div class="wp_news_left_box bdr_Bgrey20per">
                                <div class="wp_news_heading_second"><a target="_blank" href="<?php echo $newsLink;?>" class="wp_news_heading_second dash_link_hover"><?php echo getSubString($newsDetail->title,30);?></a></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt8"><?php echo changeToUrl(getSubString($newsDetail->description,100));?></div></div>
                                <div class="seprator_5"></div>
                            
						  <?php
						  break;
						  case 3:
						  
						  ?>
						   <div class="wp_news_left_box">
                                <div class="wp_news_heading_second"><a target="_blank" href="<?php echo $newsLink;?>" class="wp_news_heading_second dash_link_hover"><?php echo getSubString($newsDetail->title,30);?></a></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt8"><?php echo changeToUrl(getSubString($newsDetail->description,100));?></div></div>
                            </div>
						  <?php
						break;
						case 4:
						
						//$imgDetail = getMediaDetail(@$newsDetail->fileId);				
						
						
						?>
						<div class="cell pl13">
                            	<div class="wp_news_right_box ">
                                <div class="wp_news_heading_second"><a target="_blank" href="<?php echo $newsLink;?>" class="wp_news_heading_second dash_link_hover"><?php echo getSubString($newsDetail->title,30);?></a></div>
 
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date pb18"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="wp_news_thumb_right"><div class="AI_table">
                              <div class="AI_cell"><a target="_blank" href="<?php echo $newsLink;?>"><img class="max_w171_h107" src="<?php echo $thumbFinalImg;?>" /></a></div></div></div>
                                <div class="clr_555 pt15"><?php echo changeToUrl(getSubString($newsDetail->description,100));?></div></div>
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
                  <div id="slider1" class="<?php echo $slider1_main_class ?>">
					<div class="position_relative">
					<div class="z_index_2 position_relative">
							<a href="#" class="buttons next"></a><a href="#" class="buttons prev mr3 disable"></a>
						</div>
						<!--FAKEDIV-->
						<div class="fakebtn z_index_1">
							<span class="buttons next"></span><span class="buttons prev mr3"></span>
						</div>
						<?php echo $addReviewsButton;?>
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
						$reviewsLink=base_url(lang().'/mediafrontend/searchresult/'.$reviewsDetail->projuserid.'/'.$reviewsDetail->projectid.'/'.$reviewsDetail->elementId.'/reviews');
						
						$reviewsCounter++;
						if($reviewsCounter==1) echo $openLi;
						?>
						
                          <div class="wp_new_box">
                            <div class="cell width_114">
                              <div class="blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><a target="_blank" href="<?php echo $reviewsLink;?>"><img src="<?php echo $thumbFinalImg;?>" class="review_thumb" /></a></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name"><?php echo $reviewUserInfo['userFullName'];?></div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_252 ml10">
                              <div class="clr_555 lineH13 org_anchor_hover"><b><a target="_blank" href="<?php echo $reviewsLink;?>"><?php echo getSubString($reviewsDetail->title,40);?></a></b></div>
                              <div class="wp_blog_profile_date"><?php echo date("d F Y", strtotime($reviewsDetail->modifyDate));?></div>
                              <div class="clr_555">
								  <?php 
									  $showDetail = @$reviewsDetail->article;
									  if(@$showDetail == '') $showDetail = @$reviewsDetail->description;
									  echo changeToUrl(getSubString($showDetail,125));
								  ?>
                              </div>
                              <!--status bar-->
                             <?php
									
									$cravedALL='';
									$countReviewResult=0;
									$loggedUserId=isloginUser();
									
									if($loggedUserId > 0)
									{
										$where=array(
										'tdsUid'=>$loggedUserId,
										'entityId'=>$reviewEntityId,
										'elementId'=>$reviewsDetail->elementId
										);
										$countReviewResult=countResult('LogCrave',$where);
										$cravedALL=($countReviewResult>0)?'cravedALL':'';
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
                         
                          <!--news_box_cell-->
                        
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
        <?php 
        if(empty($news_array) && !empty($reviews_array) ){ ?>
			<script>
				$(document).ready(function(){
					$('#tab02').click();
				});
			</script>
		<?php
		}
