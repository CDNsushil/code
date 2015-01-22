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
        <div class="fans_box bg_fff display_table mb15 width100_per  pb15 ">
            <?php /*
                if(strpos($thumbFinalImg, $defaultProfileImage) === false){
                    echo '<img class="tem_img" alt="" src="'.$thumbFinalImg.'">';
                } */
            ?>
            <div class="fans_title open_sans fs20 mb15 pl22 pt22 pr20"><?php echo getSubString($userFullName,40);?></div>
            <div class="fans_cuntry open_sans fs15 pl22 lineH30 bg_f2f2 height30 bl_F1592A red"> <?php echo $data->countryName;?></div>
            <div class="sap_15"></div>
            <div class="head_list fr pr18">
            <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
            </div>
            <!--overlay -->
            <div class="fans_ovelay">
            <div class="display_table height100per">
                <div class="table_cell opens_light fs24" ><?php echo $this->lang->line('VIEWCRAVESnPLAYLISTS');?></div>
            </div>
            </div>
        </div>
    </a> <?php
}
