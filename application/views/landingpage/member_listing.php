<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
    $recordDetailUrl = base_url(lang().'/showcase/index/'.$data->tdsUid);
    if($data->enterprise=='t'){
        $userFullName = $data->enterpriseName;
    }else{
        $userFullName = $data->firstName.' '.$data->lastName;
    }
//----------make element default project image code start---------//
    if($data->stockImageId > 0){
        $userImage=$data->stockImgPath.'/'.$data->stockFilename;					
    }else{
        $profileImagePath  = 'media/'.$data->username.'/profile_image/';
        $userImage=$profileImagePath.$data->profileImageName;	
    }
    
    $thumbImage = addThumbFolder($userImage,'_ms');				
    $thumbFinalImg = getImage($thumbImage,$defaultProfileImage);
    
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
    
    ?>
    <a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
    
        <div class="fans_box bg_fff display_table mb15 width100_per ">
           <div class="fans_img text_alighC width100_per"> <img src="<?php echo $thumbFinalImg;?>" alt=""  /></div>
           <div class="sap_15"></div>
           <div class="pl22 pr20">
              <div class="ffans_title opens_light fs24 ">
                 <?php echo getSubString($userFullName,40);?>
                 <div class="fs16 red pt8"><?php echo getSubString($data->optionAreaName,40);?></div>
              </div>
              <div class="sap_15"></div>
              <div class="lp_c_text"><?php echo limit_words($data->creativeFocus,'40');?>
              </div>
              <div class="sap_20"></div>
           </div>
           <div class="fans_cuntry head_list open_sans fs15 pl22 lineH30 bg_f2f2 height30 bl_F1592A red">
              <div class="pt7 color_666">
                 <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                 <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                 <div class="rating fl pt6">
                    <img alt="" src="<?php echo $ratingImg;?>">
                 </div>
                 <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
              </div>
           </div>
           <!--overlay -->
           <div class="fans_ovelay">
              <div class="display_table height100per">
                 <div class="table_cell opens_light fs24" ><?php echo $this->lang->line('VIEWSHOWCASEHOMEPAGE');?>
                 </div>
              </div>
           </div>
           <!--overlay end--> 
        </div>
       
    </a> <?php
}
