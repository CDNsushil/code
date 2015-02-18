<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    $recordDetailUrl = base_url(lang().'/mediafrontend/educationdetails/'.$data->tdsUid.'/'.$data->projId);
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
        $thumbFinalImg = getProjectCoverImage($data->projId,'_lp');
    }else{
        $thumbFinalImg = getImage('',$this->config->item($projectType.'Image_lp'));
    }?>
    <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
        <div class="cnt_box  bg_fff  ">
            <div class="display_table m_auto position_relative">
                <img src="<?php echo $thumbFinalImg;?>" alt="" />
                <div class="hover_collection "><span class="display_cell text_alighC  fs20 opens_light"><?php echo $this->lang->line('LP_ViewMsgcat'.$data->projCategory)?></span></div>
            </div>
            <div class="pl15 pr15 pt12 pb15">
                <h4 class="fs17 font_bold  lineH20"><?php echo getSubString($data->projName,40);?></h4>
                <hr class="bbf9b8a4" />
                <div class="red"><?php echo getSubString($userFullName,60);?></div>
                <div class="pt20 pb10"><?php echo limit_words($data->projShortDesc,'40');?></div>
            </div>
            <div class="bg_f9f9f9 fl width100_per c_1">
                <div class="head_list fl">
                    <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                    <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                    <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" /></div>
                    <div class="btn_share_icon icon_so"><?php echo $reviewCount;?></div>
                </div>
                <span class="fr pb3 blue"> View Content > </span>
            </div>
        </div>
    </a>
    <?php  
} ?>  
