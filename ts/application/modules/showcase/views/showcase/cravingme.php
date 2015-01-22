<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="right_box pl34 fl  width688">
    <?php
    if(is_array($craves) && !empty($craves)){
        foreach($craves as $k=>$dt){
            $craveCount = is_numeric($dt->craveCount)?$dt->craveCount:0;
            $reviewCount = ($dt->reviewCount)?$dt->reviewCount:'0';
            $viewCount = is_numeric($dt->viewCount)?$dt->viewCount:0;
            $ratingImg=ratingImagePath($dt->ratingAvg);
            $userFullName = ($dt->enterprise=='t')?$dt->enterpriseName:$dt->firstName.' '.$dt->lastName;
            if($dt->creative=='t'){
               $defaultImage = $this->config->item('defaultCreativeImg_ms');
               $st = $this->lang->line('creative');
               $stc = 'red';
            }elseif($dt->associatedProfessional=='t'){
               $defaultImage = $this->config->item('defaultAssoProfImg_ms');
               $st = $this->lang->line('professional');
               $stc = 'green';
            }elseif($dt->enterprise=='t'){
               $defaultImage = $this->config->item('defaultEnterpriseImg_ms');
               $st = $this->lang->line('business');
               $stc = 'clr_004a80';
            }else{
               $defaultImage = $this->config->item('defaultFansImg_ms');
               $st = $this->lang->line('fan');
               $stc = 'green';
            }
            if($dt->stockImageId > 0){
                $userImage=$dt->stockImgPath.'/'.$dt->stockFilename;					
            }else{
                $profileImagePath  = 'media/'.$dt->username.'/profile_image/';
                $userImage=$profileImagePath.$dt->profileImageName;	
            }
            
            $thumbImage = addThumbFolder($userImage,'_ms');				
            $thumbFinalImg = getImage($thumbImage,$defaultImage);
            $recordDetailUrl = base_url(lang().'/showcase/index/'.$dt->tdsUid);
            ?>
            <a href="<?php echo $recordDetailUrl;?>">
                <div class="border_cacaca width100_per shadow_down mb15 display_table position_relative">
                     <?php
                     if($dt->enterprise=='t'){?>
                         <span class="table_cell width_235 text_alighC busniess_w" ><img src="<?php echo $thumbFinalImg;?>" alt=""  /></span>
                         <?php
                     }else{ ?>
                         <div class="table_cell  text_alighC profesinal_w" >
                            <span class="blur_profile bulr_box"><img src="<?php echo $thumbFinalImg;?>"  /> </span>
                            <span class="img_box zindex_999 position_relative " ><img src="<?php echo $thumbFinalImg;?>"  /></span>
                         </div>
                        <?php
                     }?>
                     <div class="table_cell text_alighL fr cnt_crev ">
                        <div class="clearbox bbf47a55">
                           <h4 class="font_bold fl clr_666"><?php echo getSubString($userFullName,25);?></h4>
                           <div class="head_list pr5  fr">
                              <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                              <div class="icon_crave4_blog icon_so"><?php echo $craveCount; ?></div>
                              <div class="rating fl pt6">
                                 <img alt="" src="<?php echo $ratingImg;?>" />
                              </div>
                              <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                           </div>
                        </div>
                        <div class="minH148 lineH20 fs13">
                           <div class="sap_25"></div>
                           <?php echo limit_words($dt->promotionalsection, 50);?>
                        </div>
                        <div class=" font_bold pt7 BT_dadada pr3"> <span class="opens_light fs23 lineH16 <?php echo $stc;?>"><?php echo $st;?> </span> <span class="fr"><?php echo $dt->IndustryName;?></span> </div>
                     </div>
                </div>
            </a>
            <?php
        }
    }else{
        echo '<p>No Record Found.</p>';
        
    }?>
</div>
            
 
