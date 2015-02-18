<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<div class="right_box pl34 fl  width688">
    <?php
    if(is_array($craves) && !empty($craves)){
        foreach($craves as $k=>$dt){
            $craveCount = is_numeric($dt->craveCount)?$dt->craveCount:0;
            $reviewCount = ($dt->reviewCount)?$dt->reviewCount:'0';
            $viewCount = is_numeric($dt->viewCount)?$dt->viewCount:0;
            $ratingImg=ratingImagePath($dt->ratingAvg);
            $userFullName = ($dt->enterprise=='t')?$dt->enterpriseName:$dt->firstName.' '.$dt->lastName;
            
            if(in_array($dt->projectType, array('creatives','associatedprofessionals','enterprises','fans'))){ 
                
                if($dt->projectType=='creatives'){
                   $defaultImage = $this->config->item('defaultCreativeImg_ms');
                   $st = $this->lang->line('creative');
                   $stc = 'red';
                }elseif($dt->projectType=='associatedprofessionals'){
                   $defaultImage = $this->config->item('defaultAssoProfImg_ms');
                   $st = $this->lang->line('professional');
                   $stc = 'green';
                }elseif($dt->projectType=='enterprises'){
                   $defaultImage = $this->config->item('defaultEnterpriseImg_ms');
                   $st = $this->lang->line('business');
                   $stc = 'clr_004a80';
                }elseif($dt->projectType=='fans'){
                   $defaultImage = $this->config->item('defaultEnterpriseImg_ms');
                   $st = $this->lang->line('business');
                   $stc = 'clr_004a80';
                }
                $recordDetailUrl = base_url(lang().'/showcase/index/'.$dt->tdsUid);
                if($dt->stockImageId > 0){
                    $userImage=$dt->stockImgPath.'/'.$dt->stockFilename;					
                }else{
                    $profileImagePath  = 'media/'.$dt->username.'/profile_image/';
                    $userImage=$profileImagePath.$dt->profileImageName;	
                }
                $thumbImage = addThumbFolder($userImage,'_ms');				
                $thumbFinalImg = getImage($thumbImage,$defaultImage);
                ?>
                <a href="<?php echo $recordDetailUrl;?>">
                    <div class="border_cacaca width100_per shadow_down mb15 display_table position_relative">
                         <?php
                         if(in_array($dt->projectType, array('creatives','associatedprofessionals','fans'))){?>
                             <div class="table_cell  text_alighC profesinal_w" >
                                <span class="blur_profile bulr_box"><img src="<?php echo $thumbFinalImg;?>"  /> </span>
                                <span class="img_box zindex_999 position_relative " ><img src="<?php echo $thumbFinalImg;?>"  /></span>
                             </div>
                             <?php
                         }else{ ?>
                             <span class="table_cell width_235 text_alighC busniess_w" ><img src="<?php echo $thumbFinalImg;?>" alt=""  /></span>
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
                               <?php echo limit_words($dt->online_desctiption, 50);?>
                            </div>
                            <div class=" font_bold pt7 BT_dadada pr3"> <span class="opens_light fs23 lineH16 <?php echo $stc;?>"><?php echo $st;?> </span> <span class="fr"><?php echo $dt->industry;?></span> </div>
                         </div>
                    </div>
                </a>
                <?php
            }else{ ?>
                <a href="<?php echo $recordDetailUrl;?>">
                    <div class="border_cacaca width100_per shadow_down mb15 display_table position_relative">
                        <span class="table_cell width_235  bgf4f4f4 bre9e9e9" >
                            <img src="<?php echo TEMPLATE_IMG;?>crave_1.jpg" alt=""  />
                        </span>
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
                            
                            <div class="minH148">
                                <div class="title_box font_bold">
                                    <?php echo limit_words($dt->title,50);?>
                                </div>
                                <?php 
                                    if(($dt->projectid == $dt->elementid) || ($dt->projectType == 'blog')){ ?>
                                        <div class="clearbox pb18">
                                            <p class="fs13 "><?php echo limit_words($dt->online_desctiption, 50);?></p>
                                        </div>
                                        <?php
                                    }else{ ?>
                                        <div class="fs23 opens_light ">
                                            <span class="green pr10"><?php
                                                if (in_array($dt->projectType, array('filmNvideo','writingNpublishing'))){
                                                    echo $dt->type;
                                                }else{
                                                    echo '&nbsp;';
                                                }?>
                                            </span>
                                            <span class="red"> <?php
                                                if(isset($dt->genre) && !empty($dt->genre)){
                                                    echo $dt->genre;
                                                }else{
                                                    echo '&nbsp;';
                                                } ?>
                                            </span>
                                        </div>  <?php
                                   }?>
                                   
                            </div>
                            <div class=" font_bold pt7 BT_dadada pr3">
                                <?php
                                if (in_array($dt->projectType, array('filmNvideo','musicNaudio','photographyNart','writingNpublishing','educationMaterial'))){
                                   
                                    switch ($dt->projectType) {
                                           case 'filmNvideo':
                                                $ftString=$this->lang->line('videoFile');
                                                $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                                                $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                                                $pstring='';
                                                if($dt->videoFileCount > 0){
                                                    $fString=($dt->videoFileCount > 1)?$this->lang->line('videoFiles'):$this->lang->line('videoFile');
                                                    $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                                                }
                                                if($dt->sell_option=='paid' && ($dt->dvdCount > 0)){
                                                    $fString=($dt->dvdCount > 1)?$this->lang->line('DVDs'):$this->lang->line('DVD');
                                                    $pstring.='<span> <b class="red pr7">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                                                }
                                            break;
                                            
                                            case 'musicNaudio':
                                                $ftString=$this->lang->line('audioFile');
                                                $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                                                $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                                                $pstring='';
                                                if($dt->audioFileCount > 0){
                                                    $fString=($dt->audioFileCount > 1)?$this->lang->line('audioFiles'):$this->lang->line('audioFile');
                                                    $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                                                }
                                                
                                                if($dt->sell_option=='paid' && ($dt->cdCount > 0)){
                                                    $fString=($dt->cdCount > 1)?$this->lang->line('CDs'):$this->lang->line('CD');
                                                    $pstring.='<span> <b class="red pr7">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                                                }
                                            break;
                                            
                                            case 'writingNpublishing':
                                                $ftString=$this->lang->line('textFile');
                                                $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                                                $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                                                $pstring='';
                                                if($dt->docFileCount > 0){
                                                    $fString=($dt->docFileCount > 1)?$this->lang->line('textFiles'):$this->lang->line('textFile');
                                                    $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->docFileCount.'</b>'.$fString.'</span>';
                                                }
                                                
                                                if($dt->sell_option=='paid' && ($dt->docCount > 0)){
                                                    $fString=($dt->docCount > 1)?$this->lang->line('texts'):$this->lang->line('text');
                                                    $pstring.='<span> <b class="red pr7">'.$dt->docCount.'</b>'.$fString.'</span>';
                                                }
                                            break;
                                            
                                            case 'photographyNart':
                                                $ftString=$this->lang->line('imageFile');
                                                $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                                                $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                                                $pstring='';
                                                if($dt->docFileCount > 0){
                                                    $fString=($dt->imageFileCount > 1)?$this->lang->line('imageFiles'):$this->lang->line('imageFile');
                                                    $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->imageFileCount.'</b>'.$fString.'</span>';
                                                }
                                                
                                                if($dt->sell_option=='paid' && ($dt->printCount > 0)){
                                                    $fString=($dt->printCount > 1)?$this->lang->line('prints'):$this->lang->line('print');
                                                    $pstring.='<span> <b class="red pr7">'.$dt->printCount.'</b>'.$fString.'</span>';
                                                }
                                            break;
                                            
                                            case 'educationMaterial':
                                                $ftString=$this->lang->line('textFile');
                                                $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                                                $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                                                $pstring='';
                                                if($dt->docFileCount > 0){
                                                    $fString=($dt->docFileCount > 1)?$this->lang->line('textFiles'):$this->lang->line('textFile');
                                                    $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->docFileCount.'</b>'.$fString.'</span>';
                                                }
                                                
                                                if($dt->sell_option=='paid' && ($dt->docCount > 0)){
                                                    $fString=($dt->docCount > 1)?$this->lang->line('texts'):$this->lang->line('text');
                                                    $pstring.='<span> <b class="red pr7">'.$dt->docCount.'</b>'.$fString.'</span>';
                                                }
                                            break;
                                            
                                            
                                        }
                                    
                                    if($dt->projectid == $dt->elementid){
                                        echo $pstring;
                                    }else{ 
                                        echo $estring;
                                    }
                                }?>
                                <span class="fr"><?php echo $dt->industry;?></span> </div>
                        </div>
                    </div>
                </a>
                <?php
            }
        }
    }else{
        echo '<p>No Record Found.</p>';
        
    }?>
</div>
            
 
