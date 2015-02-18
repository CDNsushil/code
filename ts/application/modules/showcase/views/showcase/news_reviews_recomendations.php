<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!empty($recommendationList) || !empty($reviewList) || !empty($externalNews)){
    ?>
    <div class="bg_f7f7f7 recomdation_wrap mt3 width100_per display_inline_block" >
        <ul id="tabs_nav" class="recom_list opens_light  fs21  width100_per fl">
        <?php if($showcaseData->recommendMe == 't'){?>
            <li><a href="javascript:void(0);" name="#tab1"  id="current">Recomendations</a></li>
        <?php }
            if($showcaseData->reviewMe == 't'){ ?>
            <li><a href="javascript:void(0);" name="#tab2">Reviews</a></li>
        <?php }
            if(!empty($externalNews)){ ?>
            <li><a href="javascript:void(0);" name="#tab3">News</a></li>
        <?php } ?>

        </ul>
        <div class="sap_30"></div>
        <!--=========== Step 3  inner tab content ========-->
        <div id="content_tabs" class=" recom_cnt  clearb ">
            <?php if($showcaseData->recommendMe == 't'){?>
                <div id="tab1">
                    <?php 
                    if($recommendationList && is_array($recommendationList) && count($recommendationList)>0){
                        $i=0;
                        foreach($recommendationList as $data){
                            if(!empty($data->recommendations) && strlen(trim($data->recommendations)) >= 2){
                                $i++;
                                if($i==1){
                                   echo '<div id="recommendationSlider" class="slider vertical_slide">'; 
                                   echo '<div class="viewport width100_per ">'; 
                                   echo '<a class="buttons next nav_btn next_r" href="#"></a>'; 
                                   echo '<ul class="overview">'; 
                                }
                                $showcaseUrl = base_url(lang().'/showcase/index/'.$data->from_userid);
                                $userImage='media/'.$data->username.'/profile_image/'.$data->profileImageName;
                                $userImage=(($data->stockImageId>0)?$data->stockImgPath.'/'.$data->stockFilename:$userImage);
                                
                                $writerName=$data->firstName.' '.$data->lastName;
                                
                                $thumbImage = addThumbFolder($userImage,'_s');	
                                if($data->enterprise=='t'){
                                    $defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');
                                    $writerName=$data->enterpriseName;
                                }
                                else if($data->associatedProfessional=='t'){
                                   $defaultProfileImage = $this->config->item('defaultAssoProfImg_s');
                                }
                                else{
                                   $defaultProfileImage = $this->config->item('defaultCreativeImg_s');
                                }
                                        
                                $thumbFinalImg = getImage($thumbImage,$defaultProfileImage);
                                
                                ?>
                                <li>
                                    <a href="<?php echo $showcaseUrl;?>">
                                        <div class="clearbox ">
                                            <div class="profile_box width278 fl">
                                                <div class="date pt10 fs13 open_sans clr_888 fl"><?php echo get_timestamp('F Y',$data->created_date) ;?></div>
                                                <div class="about_profile width166  text_alignC pr15 fl">
                                                    <div class="pro_img "> <img src="<?php echo $thumbFinalImg;?>"  alt="" /> </div>
                                                    <h4 class="open_conbold mt5 fs18"><?php echo getSubString($writerName,50);?></h4>
                                                </div>
                                            </div>
                                            <div class="width_478  tab_cnt mt8 open_sans  fl  pl30">
                                                <p class="lineH23 mt-4"> <?php echo nl2br($data->recommendations);?> </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        if($i>=1){
                           echo '</ul>'; 
                           echo '<a class="buttons prev nav_btn prev_r" href="#"></a>'; 
                           echo '</div>'; 
                           echo '</div>'; 
                        }
                    }
                    $this->load->view('recommendations/recommendations_view',array('userId'=>$showcaseData->tdsUid,'name'=>$enterPriseName,'is_show_in_showcase'=>'t'));
                    ?>
                </div>
                <?php 
            }
            if($showcaseData->reviewMe == 't'){?>
                <div id="tab2"><?php 
                    if($reviewList && is_array($reviewList) && count($reviewList)>0){ 
                        $i=0;
                        foreach($reviewList as $data){
                            if(!empty($data->description) && strlen(trim($data->description)) >= 2){
                                $i++;
                                if($i==1){
                                   echo '<div id="reviewSlider" class="slider vertical_slide">'; 
                                   echo '<div class="viewport width100_per ">'; 
                                   echo '<a class="buttons next nav_btn next_r" href="#"></a>'; 
                                   echo '<ul class="overview">'; 
                                }
                                $description=$data->description;
                                
                                $userImage='media/'.$data->username.'/profile_image/'.$data->profileImageName;
                                $userImage=(($data->stockImageId>0)?$data->stockImgPath.'/'.$data->stockFilename:$userImage);
                                
                                $writerName=$data->firstName.' '.$data->lastName;
                                
                                $thumbImage = addThumbFolder($userImage,'_s');	
                                if($data->enterprise=='t'){
                                    $defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');
                                    $writerName=$data->enterpriseName;
                                }
                                else if($data->associatedProfessional=='t')
                                    $defaultProfileImage = $this->config->item('defaultAssoProfImg_s');			
                                else
                                    $defaultProfileImage = $this->config->item('defaultCreativeImg_s');	
                                        
                                $thumbFinalImg = getImage($thumbImage,$defaultProfileImage);
                                
                                
                               // $href=base_url(lang().'/mediafrontend/searchresult/'.$data->userId.'/'.$data->projId.'/'.$data->elementId.'/reviews');
                                $target='target="_blank"';
                                
                                $showcaseLink = base_url('/showcase/index/'.$data->userId);
                                ?>
                                 <li>
                                     <a href="<?php echo $showcaseLink;?>">
                                         <div class="clearbox display_table">
                                            <div class="profile_box table_cell verti_bottom ">
                                               <div class="about_profile width166  text_alignC  fl">
                                                  <div class="pro_img "> <img src="<?php echo $thumbFinalImg;?>"  alt="" /> </div>
                                                  <h4 class=" mt5 green"><?php echo getSubString(ucwords($writerName),50);?></h4>
                                               </div>
                                            </div>
                                            <div class="width570 table_cell tab_reviwew mt8 open_sans text_alighL  ">
                                               <div class="fs16 mb8 mt-4 opensans_semi"><?php echo $data->title;?> </div>
                                               <p class="lineH21 "><?php echo limit_words($description,40);?></p>
                                            </div>
                                         </div>
                                        </a>
                                 </li>
                                <?php
                            }
                        }
                        if($i>=1){
                           echo '</ul>'; 
                           echo '<a class="buttons prev nav_btn prev_r" href="#"></a>'; 
                           echo '</div>'; 
                           echo '</div>'; 
                        }
                    }
                    $this->load->view('common/reviewme_button',array('elementId'=>$showcaseId,'entityId'=>$entityId,'section' =>$industryType,'industryId' =>0,'isPublished'=>$showcaseData->isPublished));	
                    ?>
                </div>
                <?php
            }
            if($externalNews && is_array($externalNews) && count($externalNews)>0){?>
                <div id="tab3"><?php 
                    $i=0;
                    foreach($externalNews as $data){
                        if(!empty($data->newsDescription) && strlen(trim($data->newsDescription)) >= 2){
                            $i++;
                            if($i==1){
                               echo '<div id="newsSlider" class="slider vertical_slide">'; 
                               echo '<div class="viewport width100_per ">'; 
                               echo '<a class="buttons next nav_btn next_r" href="#"></a>'; 
                               echo '<ul class="overview">'; 
                            }
                            if(isset($data->associatedNewsElementId) && $data->associatedNewsElementId >0){
                                $href=base_url(lang().'/mediafrontend/searchresult/'.$data->tdsUid.'/'.$data->projId.'/'.$data->associatedNewsElementId.'/news');
                                $target='target="_blank"';
                            }
                            elseif(!empty($data->newsExternalUrl)){
                                $externalUrl=$data->newsExternalUrl;
                                if(strstr($externalUrl,'+')){
                                    $externalUrl=urldecode($externalUrl); 
                                }
                                $href=$externalUrl;
                                $target='target="_blank"';
                            }
                            elseif(!empty($data->newsEmbed)){
                                $Embed=$data->newsEmbed;
                                if(strstr($Embed,'+')){
                                    $Embed=urldecode($Embed); 
                                }
                                $externalUrl=getUrl($Embed);
                                $externalUrl=urldecode($externalUrl);
                                $href=$externalUrl;
                                $target='target="_blank"';
                            }
                            else{
                                $href='#';
                                $target='';
                            }	
                            
                            $showcaseLink = base_url('/showcase/index/'.$data->tdsUid);
                            
                            if(empty($data->newsWriter)) {
                                //$userShowcase = showCaseUserDetails($data->tdsUid);
                                $data->newsWriter = $enterpriseName;
                            }
                            ?>
                            <li><a href="<?php echo $href;?>" <?php echo $target;?>>
                                <div class="clearbox display_table">
                                    <div class="width570 table_cell tab_news mt8 open_sans text_alighL  ">
                                       <div class="fs16 mb8 mt-4 opensans_semi"><?php echo getSubString($data->newsTitle,100);?></div>
                                       <p class="lineH21 ">
                                           <?php  $newsDescriptionShow=  nl2br(limit_words(string_replace($data->newsDescription),20));
                                                 echo  string_decode($newsDescriptionShow);
                                          ?></p>
                                    </div>
                                    <div class="profile_box table_cell verti_bottom ">
                                       <div class="about_profile width166  text_alignC  fr">
                                          <div class="pro_img "> <img src="<?php echo base_url('images/default_thumb/news_s.jpg');?>"  alt="" /> </div>
                                          <h4 class=" mt5 green"><?php echo getSubString($data->newsWriter,50);?></h4>
                                       </div>
                                    </div>
                                </div></a>
                            </li><?php
                        }
                    }
                    if($i>=1){
                       echo '</ul>'; 
                       echo '<a class="buttons prev nav_btn prev_r" href="#"></a>'; 
                       echo '</div>'; 
                       echo '</div>'; 
                    }?>
                </div><?php
            }?>
        </div>
        <div class="sap_30"></div>
    </div>
    <script type="text/javascript">
     $(document).ready(function(){
        $('#recommendationSlider').tinycarousel({ axis: 'y', display: 1});	
        $('#reviewSlider').tinycarousel({ axis: 'y', display: 1});	
        $('#newsSlider').tinycarousel({ axis: 'y', display: 1});	
     });
  </script><?php
} ?>
        
            
      
