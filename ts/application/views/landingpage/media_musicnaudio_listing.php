<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    
    $recordDetailUrl = base_url(lang().'/mediafrontend/aboutalbum/'.$data->tdsUid.'/'.$data->projId);
    
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
        $thumbFinalImg = getProjectCoverImage($data->projId,'_ms');
    }else{
        $thumbFinalImg = getImage('',$this->config->item($projectType.'Image_ms'));
    }
        ?>
        <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
         <!-- collection box   -->
           <div class="cnt_box width_280 pb10 fl mb25 shadow bg_fff  ">
              <div class="inner_music   position_relative">
                 <div class="top_header position_absolute display_table top0 left0 width100_per zindex9 ">
                    <h5 class="fs17 table_cell width100_per opensans_semi "><?php echo getSubString($userFullName,40);?></h5>
                 </div>
                 <div class="display_table m_auto  position_relative height278">
                    <div class="table_cell "><img src="<?php echo $thumbFinalImg;?>" alt="" /></div>
                    <div class="hover_collection "><span class="display_cell text_alighC  fs20 opens_light"><?php echo $this->lang->line('LP_ViewMsgcat'.$data->projCategory);?></span></div>
                 </div>
                 <div class="bg_444 clr_fff font_bold pl20 pr25 pt5 pb10"><?php echo getSubString($data->projName,40);?>
                 </div>
                 <div class="pl20 pt20 pr20">
                    <div class="bb_c6c6c5 pb5">
                        <span class="fs16">	
                            <?php echo $this->lang->line('media_cat'.$data->projCategory);?>
                        </span> 
                        <?php if(isset($data->projSellstatus) && $data->projSellstatus != 't'){ ?>
                             <span class="red fs13 fr"> FREE </span>
                        <?php }?>
                     </div>
                    
                     <?php 
                        $mt15="";
                    if((int)$data->audioFileCount > 0 || (int)$data->cdCount > 0){ ?>
                        <div class="pt20 pb5 bb_c6c6c5 mb15 pl33 pr20">
                           <div class="pb10 font_bold"><?php echo $this->lang->line('contents_cat'.$data->projCategory);?></div>
                           
                            <?php if(!empty($data->audioFileCount) && (int)$data->audioFileCount > 0){ 
                                $fileType = ((int)$data->audioFileCount > 1) ? $this->lang->line('musicFiles'): $this->lang->line('musicFile');
                                ?>
                                <div class="pb10"><b class="red minw_20 pr5 fl"><?php echo $data->audioFileCount; ?></b>  <?php echo $fileType;?></div>
                            <?php  } ?>
                            <?php if(!empty($data->cdCount) && ((int)$data->cdCount > 0) && ($data->projSellstatus == 't')){
                                $fileType = ((int)$data->cdCount > 1) ? $this->lang->line('CDs'): $this->lang->line('CD');?>
                                <div class="pb10"><b class="red minw_20 pr5 fl"><?php echo $data->cdCount; ?></b>    <?php echo $fileType;?></div>
                            <?php  } ?>
                        </div>
                        <?php
                    }else{
                            $mt15="mt15";
                    } ?>
                    
                    <div class=" width100_per <?php echo $mt15; ?> c_1">
                       <div class="head_list fr pb5">
                          <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                          <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                          <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" /></div>
                          <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                       </div>
                    </div>
                 </div>
              </div>
              <!-- collection box   -->
           </div>
           <!-- collection box   -->
        </a> 
    <?php  
}   ?>  
