<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    $recordDetailUrl = base_url(lang().'/mediafrontend/writinggallery/'.$data->tdsUid.'/'.$data->projId.'/');
    if($data->enterprise=='t'){
        $userFullName = $data->enterpriseName;
    }else{
        $userFullName = $data->firstName.' '.$data->lastName;
    }
    
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

    if(isset($data->projId)){
        $thumbFinalImg = getProjectCoverImage($data->projId,'_ms');
    }else{
        $thumbFinalImg = getImage('',$this->config->item($projectType.'Image_ms'));
    }?>
    
    <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
        <div class="cnt_box  display_table bg_fff mb15">
              <div class="clearb ">
                 <h4 class="land_suptitile pl10 pr10 pb10"><?php echo getSubString($data->projName,40);?></h4>
                 <div class="display_table">
                    <div class="display_table fl  text_alighL ">
                       <div class="table_cell "><img src="<?php echo $thumbFinalImg;?>" alt="" class="max_188X284" /></div>
                    </div>
                    <div class="width210 position_relative verti_top  table_cell">
                       <h5  class="lp_title pr15 width100_per text_alignR pt8 pb8 bg_f3f3f3 fr"> <?php echo getSubString($userFullName,20);?></h5>
                       <div class="  position_absolute lb0">
                          <div class="fr text_alignR open_sans  letter_spP7 pr15 mt18">
                              
                            <?php 
                            $string = '';
                            $isSperator = false;
                            if(isset($fileType_dwnld) && is_array($fileType_dwnld) && !empty($fileType_dwnld)){
                                foreach($fileType_dwnld as $key=>$type){
                                    if(isset($data->$key) && ((int)$data->$key > 0)){
                                      $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                      $string.='<span class="green pr7">'.$data->$key.'</span>'.$type;
                                       $isSperator = true;
                                    }
                                }
                            }
                            if(isset($data->projSellstatus) && $data->projSellstatus == 't'){
                               if(isset($fileType_shipd) && is_array($fileType_shipd) && !empty($fileType_shipd)){
                                    foreach($fileType_shipd as $key=>$type){
                                        if(isset($data->$key) && ((int)$data->$key > 0)){
                                          $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                          
                                            if($isSperator){
                                                $string.='<span class="pl10 pr10">|</span>';
                                            }
                                            $string.=' <span class="green pr7">'.$data->$key.'</span>'.$type.' </span>';
                                        }
                                    }
                                } 
                            }
                            /*elseif(isset($data->projSellstatus) && $data->projSellstatus != 't'){
                                $string.='<div class="clearb lineH23"><span class="red font_bold pr7">'.$this->lang->line('FREE').'</span></div>';
                            }*/
                            echo $string;
                        ?>  
                              
                          </div>
                          <div class=" bg_f3f3f3 fl mt10 width100_per pt8 pb8  box_siz  ">
                             <div class="head_list fr pl10 pr10 ">
                                <div class="icon_view3_blog fs11 icon_so"><?php echo $viewCount;?></div>
                                <div class="icon_crave4_blog fs11 icon_so"><?php echo $craveCount;?></div>
                                <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" class="max_w29" /></div>
                                <div class="btn_share_icon fs11 icon_so"><?php echo $reviewCount; ?></div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="clearbox p20">
                 <p><?php echo limit_words($data->projShortDesc,'40');?>
                 </p>
              </div>
           </div>
    </a> <?php  
}   ?>  
