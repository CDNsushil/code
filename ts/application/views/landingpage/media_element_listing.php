<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
echo "<pre>";
print_r($data); die;*/

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
           <div class="cnt_box  bg_fff  ">
              <h5 class="fs16"><?php echo getSubString($userFullName,40);?></h5>
              <div class="display_table m_auto position_relative">
                 <img src="<?php echo $thumbFinalImg;?>" alt="" />
                 <div class="hover_collection"><div class="display_table"><span class="display_cell text_alighC  fs20 opens_light"><?php echo $this->lang->line('LP_ViewMsgcat'.$data->projCategory);?></span></div></div>
              </div>
              <div class="p15">
                 <h4 class="fs17 pt3 font_bold lineH20"> <?php echo getSubString($data->title,40);?></h4>
                 <p>
                     <?php 
                     if(!empty($data->description)){
                          echo $data->description;
                     }else{
                          //echo $data->projShortDesc;
                     }
                    ?> 
                 </p>
              </div>
              <div class="bg_f6f6f6 fl width100_per c_1">
                 <div class="head_list fl">
                    <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                    <div class="rating fl pt6"><img  src="<?php echo $ratingImg;?>" /></div>
                    <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                 </div>
                <div class="fr">
                    <?php 
                        $string = '';
                        if(isset($fileType_shipd) && isset($fileType_dwnld)){
                            if($data->isShippable == 't' && $data->projSellstatus == 't'){
                                $type = $fileType_shipd;
                            }else{
                                $type = $fileType_dwnld;
                            }
                            $string.='<span>'.$type.'</span>';
                            if($data->projSellstatus == 'f'){
                                $string.='<span class="pl7 pr7">|</span><span class="red">'.$this->lang->line('FREE').'</span>';
                            }
                        }
                        echo $string;
                    ?>
                </div>
              </div>
           </div>
        </a> 
    <?php  
}   ?>  
