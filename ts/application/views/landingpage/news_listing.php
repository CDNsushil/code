<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    $recordDetailUrl=base_url(lang().'/mediafrontend/searchresult/'.$data->projuserid.'/'.$data->projectid.'/'.$data->elementId.'/news');
    if($data->enterprise=='t'){
        $userFullName = $data->enterpriseName;
    }else{
        $userFullName = $data->firstName.' '.$data->lastName;
    }
    
    $userShowcaseImage='';
    if(!empty($data->imagePath)){
        $userShowcaseImage = $data->imagePath;
    }
    
    //----------make element default project image code start---------//
    $thumbImage = addThumbFolder($userShowcaseImage,'_s');			
    
    $userDefaultImage=($data->creative=='t')?$this->config->item('defaultCreativeImg_s'):(($data->associatedProfessional=='t')?$this->config->item('defaultAssProfImg_s'):(($data->enterprise=='t')?$this->config->item('defaultEnterpriseImg_s'):''));
    
    //default member image		
    if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_s'); 
    
    $thumbFinalImg = getImage($thumbImage,$userDefaultImage);
    
    $craveCount = is_numeric($data->craveCount)?$data->craveCount:0;
    $ratingAvg = $data->ratingAvg;
    $viewCount = is_numeric($data->viewCount)?$data->viewCount:0;
    $reviewCount = ($data->reviewCount)?$data->reviewCount:'0';
    
    
    if(isset($data->craveId) && ($data->craveId > 0)){
        $cravedALL='cravedALL';
    }else{
        $cravedALL='';
    }
    
    $ratingAvg=roundRatingValue($ratingAvg);
    $ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';	
    ?>
    <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
        <div class="<?php echo $border;?> bg_fff shadow_ldown width100_per display_inline_block mb20">
            <div class="fl width100_per display_table position_relative pt17">
                <div class="table_cell text_alighL width600 pl20 fl mb30">
                    <h4 class="fs17 font_bold pb12 lineH20">
                        <?php echo $data->title;?>
                    </h4>
                    <div class="lineH16 mb20">
                        <?php 
                          $showDetail = (isset($data->description) && strlen($data->description) > 5)?$data->description:$data->projshortdesc;
                          echo limit_words($showDetail,'40');
                        ?>
                    </div>
                </div>
                <span class="table_cell text_alignR fr pr10 width205 pb10 position_relative zindex9" >
                <img src="<?php echo $thumbFinalImg;?>" alt="" class="maxw205"  /></span>
                <div class="bg_f6f6f6 position_absolute width100_per lb0 pt8 pb8 zindex8">
                    <div class="width600 pl20 fl "> 
                        <div class="fl">	<span class="red">News Article by:</span> <span class="font_bold"><?php echo getSubString($userFullName, 60);?></span></div>
                        <div class="head_list fr pr10">
                            <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                            <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                            <div class="rating fl pt6">
                                <img alt="" src="<?php echo $ratingImg;?>" />
                            </div>
                            <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a><?php
}  ?>
