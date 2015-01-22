<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    $recordDetailUrl = base_url(lang().'/mediafrontend/writingdetails/'.$data->tdsUid.'/'.$data->projId.'/');
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
        <div class="cnt_box  bg_fff mb15">
            <div class="clearb pl10 pr8">
                <h4 class="fs17 pb10 font_bold lineH20"><?php echo getSubString($data->projName,40);?></h4>
                <p><?php echo limit_words($data->projShortDesc,'40');?></p>
                <div class="pt8  c_1">
                    <b class="fl fs15 red"><?php echo getSubString($userFullName,20);?></b>
                    <div class="head_list fr pt3 pr20">
                        <div class="icon_view3_blog fs11 icon_so"><?php echo $viewCount;?></div>
                        <div class="icon_crave4_blog fs11 icon_so"><?php echo $craveCount;?></div>
                        <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" class="max_w29" /></div>
                        <div class="btn_share_icon fs11 icon_so"><?php echo $reviewCount; ?></div>
                    </div>
                </div>
            </div>
            <div class="sap_15"></div>
            <div class="bg_ecec pl10 pr10 width375 display_table clearb m_auto position_relative">
                <div class="display_table fl ">
                    <div class="table_cell height206 width_258"><img src="<?php echo $thumbFinalImg;?>" alt="" class="max_258X206" /></div>
                </div>
                <div class="fr pr10 letter_spP7 mt18">
                    <?php 
                        $string = '';
                        if(isset($fileType_dwnld) && is_array($fileType_dwnld) && !empty($fileType_dwnld)){
                            foreach($fileType_dwnld as $key=>$type){
                                if(isset($data->$key) && ((int)$data->$key > 0)){
                                  $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                  $string.='<div class="clearb"><span class="red font_bold pr7">'.$data->$key.'</span>'.$type.'</div>';
                                }
                            }
                        }
                        if(isset($data->projSellstatus) && $data->projSellstatus == 't'){
                           if(isset($fileType_shipd) && is_array($fileType_shipd) && !empty($fileType_shipd)){
                                foreach($fileType_shipd as $key=>$type){
                                    if(isset($data->$key) && ((int)$data->$key > 0)){
                                      $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                      $string.='<div class="clearb lineH23"><span class="red font_bold pr7">'.$data->$key.'</span>'.$type.'</div>';
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
            </div>
        </div>
    </a> <?php  
}   ?>  
