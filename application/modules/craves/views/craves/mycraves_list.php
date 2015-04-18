<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
            <div class="row" id="removecrave_<?php echo $dt->craveId; ?>">
                <a class="fl" href="<?php echo $recordDetailUrl;?>">
                    <div class="border_cacaca shadow_down mb15 display_table position_relative width688">
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
                <div class="fl pt100 pl25 removeCrave" > 
                    <a href="javascript:void(0);">
                        <span onclick="unCrave('<?php echo $dt->entityId; ?>','<?php echo $dt->elementId; ?>','<?php echo $dt->tdsUid; ?>','<?php echo $dt->craveId;?>')">Remove</span>
                    </a>
                </div>
            </div>
            <?php
        }else{
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
                    
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/mediashowcases/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('FvElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/mediadetails/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                    
                break;
                
                case 'musicNaudio':
                    $ftString=$this->lang->line('musicFile');
                    $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                    $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                    $pstring='';
                    if($dt->audioFileCount > 0){
                        $fString=($dt->audioFileCount > 1)?$this->lang->line('musicFiles'):$this->lang->line('musicFile');
                        $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                    }
                    
                    if($dt->sell_option=='paid' && ($dt->cdCount > 0)){
                        $fString=($dt->cdCount > 1)?$this->lang->line('CDs'):$this->lang->line('CD');
                        $pstring.='<span> <b class="red pr7">'.$dt->videoFileCount.'</b>'.$fString.'</span>';
                    }
                    
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/aboutalbum/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('MaElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/tracklist/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
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
                    
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/writingdetails/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('WpElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/writingelement/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                break;
                
                case 'photographyNart':
                    $ftString=$this->lang->line('imageFile');
                    $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                    $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                    $pstring='';
                    if($dt->imageFileCount > 0){
                        $fString=($dt->imageFileCount > 1)?$this->lang->line('imageFiles'):$this->lang->line('imageFile');
                        $pstring.='<span class="pr7"><b class=" red pr7 ">'.$dt->imageFileCount.'</b>'.$fString.'</span>';
                    }
                    
                    if($dt->sell_option=='paid' && ($dt->printCount > 0)){
                        if($dt->categoryid == $this->config->item('PaAlbumCatId')){
                            $fString=($dt->printCount > 1)?$this->lang->line('prints'):$this->lang->line('print');
                        }else{
                           $fString=($dt->printCount > 1)?$this->lang->line('Arts'):$this->lang->line('Art');
                        }
                        $pstring.='<span> <b class="red pr7">'.$dt->printCount.'</b>'.$fString.'</span>';
                    }
                    
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/photoartdetails/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('PaElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/photoartelement/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                    
                break;
                
                case 'educationMaterial':
                    if($dt->projectid != $dt->elementid){
                        $ftString='';
                        if($dt->videoFileCount > 0){
                            $ftString=$this->lang->line('videoFile');
                        }elseif($dt->dvdCount > 0){
                            $ftString=$this->lang->line('DVD');
                        }elseif($dt->audioFileCount > 0){
                            $ftString=$this->lang->line('musicFiles');
                        }elseif($dt->cdCount > 0){
                            $ftString=$this->lang->line('CD');
                        }elseif($dt->docFileCount > 0){
                            $ftString=$this->lang->line('textFile');
                        }elseif($dt->docCount > 0){
                            $ftString=$this->lang->line('text');
                        }elseif($dt->imageFileCount > 0){
                            $ftString=$this->lang->line('imageFile');
                        }elseif($dt->printCount > 0){
                            $ftString=$this->lang->line('print');
                        }
                        $FREE = ($dt->sell_option=='free')?$this->lang->line('FREE'):'';
                        $estring='<span><b class="red pr7 ">'.$ftString.'</b>'.$FREE.'</span>';
                    }
                    $pstring='';
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/educationdetails/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('EmElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/educationelement/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                break;
                
                case 'news':
                    $estring='';
                    $pstring='';
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/newscollection/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('NewsElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/articledetails/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                break;
                
                case 'reviews':
                    $estring='';
                    $pstring='';
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = getProjectCoverImage($dt->projectid, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/reviewscollection/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = getMediaElementImage('ReviewsElement',$dt->elementid, $dt->projectType, '_m');
                        $recordDetailUrl = base_url(lang().'/mediafrontend/reviewsdetails/'.$dt->tdsUid.'/'.$dt->projectid.'/'.$dt->elementid);
                    }
                break;
                
                case 'blog':
                    $estring='';
                    $pstring='';
                    if(($dt->projectid == $dt->elementid)){ 
                        $thumbFinalImg = base_url($this->config->item('defaultBlogImg_ms'));
                        $recordDetailUrl = base_url(lang().'/blogshowcase/frontblog/'.$dt->tdsUid.'/'.$dt->projectid);
                    }else{
                        $thumbFinalImg = base_url($this->config->item('defaultBlogImg_ms'));
                        $recordDetailUrl = base_url(lang().'/blogshowcase/frontPostDetail/'.$dt->tdsUid.'/'.$dt->elementid);
                    }
                break;
                
                default: 
                    $estring='';
                    $pstring='';
                    $thumbFinalImg = '';
                    $recordDetailUrl ='#';
                break;
            } ?>
           <div class="row" id="removecrave_<?php echo $dt->craveId; ?>">
                <a class="fl" href="<?php echo $recordDetailUrl;?>">
                    <div class="border_cacaca width100_per shadow_down mb15 display_table position_relative width688">
                        <span class="table_cell width_235  bgf4f4f4 bre9e9e9" >
                            <img src="<?php echo $thumbFinalImg;?>" alt=""  />
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
                                    if(($dt->projectid == $dt->elementid) || in_array($dt->projectType, array('reviews','news','blog')) ){ ?>
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
                                    if($dt->projectid == $dt->elementid){
                                        echo $pstring;
                                    }else{ 
                                        echo $estring;
                                    }
                                }?>
                                <span class="fr"><?php echo $dt->industry;?></span>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="fl pt100 pl25 removeCrave"> 
                    <a href="javascript:void(0);">
                        <span onclick="unCrave('<?php echo $dt->entityId; ?>','<?php echo $dt->elementId; ?>','<?php echo $dt->tdsUid; ?>','<?php echo $dt->craveId; ?>')">Remove</span>
                    </a>
                </div>
            </div>
            <?php
        }
    }
    if($items_total >  $perPageRecord) { 
        echo '<div class="width688">';
        $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/craves/index/'),"divId"=>"searchResultDiv","formId"=>"craveSearchForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design ')); 
        echo '</div>';
    }
}
else{
    echo '<p>No Record Found.</p>';
    
}?>

        

