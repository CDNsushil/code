<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    
    $recordDetailUrl = base_url(lang().'/mediafrontend/mediagallery/'.$data->tdsUid.'/'.$data->projId);
   
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
    
    
    if(isset($data->projId)){
        $thumbFinalImg = getProjectCoverImage($data->projId,'_lp');
    }else{
        $thumbFinalImg = getImage('',$this->config->item($projectType.'Image_lp'));
    }
        ?>
        <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >

            <div class="cnt_box  bg_fff  ">
              <h5  class="lp_title"><?php echo getSubString(ucwords($userFullName),40);?></h5>
              <div class="display_table m_auto position_relative">
                 <img src="<?php echo $thumbFinalImg;?>" alt="" />
                 <div class="hover_collection "><span class="display_cell text_alighC  fs20 opens_light">
                     <?php echo $this->lang->line('LP_ViewMsgcat'.$data->projCategory);?></span></div>
              </div>
              <div class="p15">
                 <h4 class="land_suptitile"><?php echo getSubString($data->projName,40);?></h4>
                 <p><?php echo $data->projShortDesc;?> 
                 </p>
              </div>
              <div class="bg_f3f3f3 fl width100_per c_1">
                 <div class="head_list fl">
                    <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                    <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" /></div>
                    <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                 </div>
                <span class="fr open_sans"> 
                    <?php 
                        $string = '';
                        if(isset($fileType_dwnld) && is_array($fileType_dwnld) && !empty($fileType_dwnld)){
                            foreach($fileType_dwnld as $key=>$type){
                                if(isset($data->$key) && ((int)$data->$key > 0)){
                                  $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                  if(!empty($string)){
                                      $string.='<span class="pl7 pr7">|</span>';
                                  }
                                  $string.='<span><b class="red pr7">'.$data->$key.'</b>'.$type.'</span>';
                                }
                            }
                        }
                        if(isset($data->projSellstatus) && $data->projSellstatus == 't'){
                           if(isset($fileType_shipd) && is_array($fileType_shipd) && !empty($fileType_shipd)){
                                foreach($fileType_shipd as $key=>$type){
                                    if(isset($data->$key) && ((int)$data->$key > 0)){
                                      $type = ((int)$data->$key > 1) ? $type.'s': $type;
                                      if(!empty($string)){
                                          $string.='<span class="pl7 pr7">|</span>';
                                      }
                                      $string.='<span><b class="red pr7">'.$data->$key.'</b>'.$type.'</span>';
                                    }
                                }
                            } 
                        }elseif(isset($data->projSellstatus) && $data->projSellstatus != 't'){
                            if(!empty($string)){
                                  $string.='<span class="pl7 pr7">|</span>';
                             }
                              $string.='<span class="red">FREE</span>';
                        }
                        echo $string;
                    ?>
                     
                </span> 
              </div>
            </div>
            
            
            
        </a> 
    <?php  
}   ?>  
