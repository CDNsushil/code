<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(isset($data) && is_object($data) && count($data) > 0){
    
    if($frontendMathod=='filmvideo'):
         $recordDetailUrl = base_url(lang().'/mediafrontend/mediadetails/'.$data->tdsUid.'/'.$data->projId.'/'.$data->elementId);
    else:
        $recordDetailUrl = base_url(lang().'/mediafrontend/searchresult/'.$data->tdsUid.'/'.$data->projId.'/'.$frontendMathod);
    endif;
    
    if($data->enterprise=='t'){
        $userFullName = $data->enterpriseName;
    }else{
        $userFullName = $data->firstName.' '.$data->lastName;
    }
    //----------make element default project image code start---------//
    
    
    $craveCount = is_numeric($data->craveCount)?$data->craveCount:0;
    $ratingAvg = $data->ratingAvg;
    $reviewCount = ($data->reviewCount)?$data->reviewCount:'0';
    $viewCount = is_numeric($data->viewCount)?$data->viewCount:0;
    
    
    if(isset($data->craveId) && ($data->craveId > 0)){
        $cravedALL='cravedALL';
    }else{
        $cravedALL='';
    }
    
    $ratingAvg=roundRatingValue($ratingAvg);
    $ratingImg=base_url().'templates/new_version/images/rating/rating_0'.$ratingAvg.'.png';	
    
    //----------make element default project image code start---------//
    //-----------get image width by remove absulte path------------//
    
    $thumbFinalImg = getElementImage($data->displayImageType,$data->imagePath,$projectType,'_m');
    ?>
        <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
            <div class="border_cacaca bg_fff width850 shadow_down mb15 display_table position_relative">
               <span class="table_cell width322 bg_f6f6f6" > <img src="<?php echo $thumbFinalImg;?>" alt="" class="max_wh322x218"  /></span>
               <div class="table_cell text_alighL fr cnt_lppeces">
                  <div class="clearbox bbf47a55 pb6">
                     <h4 class="opensans_semi fl clr_666"><?php echo getSubString($userFullName,60);?></h4>
                     <div class="head_list pr5  fr">
                        <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                        <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                        <div class="rating fl pt6">
                           <img alt="" src="<?php echo $ratingImg;?>" />
                        </div>
                        <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                     </div>
                  </div>
                  <div class="clearbox minH103">
                     <div class="sap_15"></div>
                     <div class=" font_bold">
                            <?php echo limit_words($data->title,20);?>
                     </div>
                     <div class="sap_25"></div>
                     
                     <div class="fs20 red open_sans">
                        <?php 
                            if (!in_array($projectType, array('musicNaudio','photographyNart','educationMaterial'))){
                                echo $data->projectTypeName;
                            }
                            if(isset($data->Genre) && !empty($data->Genre)){?>
                                <span class="green pl10"><?php echo $data->Genre;?></span>
                                <?php
                            }
                        ?>
                     </div>
                     
                     
                  </div>
                  <div class="sap_15"></div>
                  <div class="clearbox"><div class="fr pb3 font_bold">
                  <?php 
                    if(isset($data->projGenreFree) && !empty($data->projGenreFree)){?>
                        <?php echo $data->projGenreFree;?>
                        <?php
                    }else echo '&nbsp;';?>
                    </div></div> 
                  <div class=" font_bold pt8 BT_dadada">
                      <?php 
                        $string = '';
                        if(isset($fileType_shipd) && isset($fileType_dwnld)){
                            if($data->isShippable == 't' && $data->projSellstatus == 't'){
                                $type = $fileType_shipd;
                            }else{
                                $type = $fileType_dwnld;
                            }
                            $string.='<span><b class="red pr15 ">'.$type.'</b> ';
                            if($data->projSellstatus == 'f'){
                                $string.=$this->lang->line('FREE');
                            }
                            $string.='</span>';
                        }
                        echo $string;
                    ?>
                      <span class="fr clr_777"><?php echo $industry;?></span> </div>
               </div>
            </div>
        </a> 
    <?php  
}   ?>  
