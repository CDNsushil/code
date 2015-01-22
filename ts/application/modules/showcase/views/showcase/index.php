<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$ratingAvg=roundRatingValue($showcaseData->ratingAvg);
$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
$craveCount                 =   (!empty($showcaseData->craveCount))?$showcaseData->craveCount:'0';
$viewCount                  =   (!empty($showcaseData->viewCount))?$showcaseData->viewCount:'0';
$ratingAvg                  =   (!empty($showcaseData->ratingAvg))?$showcaseData->ratingAvg:'0';
$reviewCount                =   (!empty($showcaseData->reviewCount))?$showcaseData->reviewCount:'0';
$showcaseId                 =   (!empty($showcaseData->showcaseId))?$showcaseData->showcaseId:'0';
$tdsUid                     =   (!empty($showcaseData->tdsUid))?$showcaseData->tdsUid:'0';
$entityId                   =   (!empty($showcaseData->entityId))?$showcaseData->entityId:'0';
$creative                   =   (!empty($showcaseData->creative))?$showcaseData->creative:'f';
$associatedProfessional     =   (!empty($showcaseData->associatedProfessional))?$showcaseData->associatedProfessional:'f';
$enterprise                 =   (!empty($showcaseData->enterprise))?$showcaseData->enterprise:'f';
$fans                 =   (!empty($showcaseData->fans))?$showcaseData->fans:'f';

$showcaseIndustry = '';
if($creative=="t"){
    $showcaseIndustry = $this->lang->line('Creatives');
}elseif($associatedProfessional=="t"){
    $showcaseIndustry = $this->lang->line('Enterprises');
}elseif($enterprise=="t"){
    $showcaseIndustry = $this->lang->line('associated_professional');
}elseif($fans=="t"){
    $showcaseIndustry = $this->lang->line('fans');
}
   
$cravedALL                  =   '';
$craveDivAction             =   'craveDiv'.$entityId.''.$showcaseId;
$rateDivAction              =   'rateDiv'.$entityId.''.$showcaseId;


//---------check craved by loggedUserId------------//
$loggedUserId = isLoginUser();
if(!empty($loggedUserId)){
    $where=array(
        'tdsUid'        =>   $loggedUserId,
        'entityId'      =>   $entityId,
        'elementId'     =>   $showcaseId
    );
    
    $countResult    =   countResult('LogCrave',$where);
    $cravedALL      =   ($countResult>0)?'cravedALL':'';
}else{
    $cravedALL='';
}
?>
<div class="bg_f1f1f1 cerative_title clearbox">
    <h1 class="opens_light fs30 fl <?php echo $SHC;?>"><?php echo $sectionHeading;?></h1>
    <div class="head_list fr pt27 pr25">
        <div class="icon_view3_blog fs11 icon_so"><?php echo $viewCount;?></div>
        <div class="icon_crave4_blog fs11 icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
        <div class="rating fl pr3 pt6 <?php echo  $rateDivAction; ?>"> <img class="max_w29" alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
        <div class="btn_share_icon fs11 icon_so"><?php echo $reviewCount;?></div>
    </div>
</div>
        
<!--  content wrap  start end -->

<div class=" clearbox aboutme_cnt "> <?php
    if(isset($topHeader) && !empty($topHeader)){
        $this->load->view($topHeader);
    }else{ ?>
        <div class="sap_65"></div>
        <?php  
    } ?>
    <div class="content_creave display_table  pl20 pr20 <?php echo (isset($topHeader) && !empty($topHeader))?'pt18':''; ?>  clearb">
        <?php 
        $sendData = array('projectId'=>$showcaseId,'entityId'=>$entityId,'ownerId'=>$tdsUid,'industryType'=>$showcaseIndustry,'isPublished'=>'t');
        $this->load->view('showcase/showcase/left_nvigation',$sendData);
        if($innerPageData && !empty($innerPageData)){
            echo $innerPageData;
        } ?>
    </div>
    
    <?php 
    if($fans != 't'){ //News Reviews Recomendations
        echo '<div class="sap_60"></div>';
        $this->load->view('showcase/showcase/news_reviews_recomendations');
    }else{
        echo '<div class="sap_65"></div>';
    }?>
</div>
