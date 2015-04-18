<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//add preview word if preview mode is active
$previewWord= (previewModeActive())?"/preview":"";

if(!empty($collectionMediaList)){ 
                    
        foreach($collectionMediaList as $collectionMedia){
        
    $title                  =    (!empty($collectionMedia['title']))?$collectionMedia['title']:'';
    $craveCount             =    (!empty($collectionMedia['craveCount']))?$collectionMedia['craveCount']:'0'; 
    $viewCount              =    (!empty($collectionMedia['viewCount']))?$collectionMedia['viewCount']:'0'; 
    $elementType            =    (!empty($collectionMedia['elementType']))?$collectionMedia['elementType']:''; 
    $elementId              =   (!empty($collectionMedia['elementId']))?$collectionMedia['elementId']:'0'; 
    $eleMediaFileType       =   (!empty($collectionMedia['mediaFileType']))?$collectionMedia['mediaFileType']:'0'; 
    $isPrice                =   (!empty($collectionMedia['isPrice']))?$collectionMedia['isPrice']:'t'; 
    $isDownloadPrice        =   (!empty($collectionMedia['isDownloadPrice']))?$collectionMedia['isDownloadPrice']:'t'; 
    $fileLength            =   (!empty($collectionMedia['fileLength']))?$collectionMedia['fileLength']:'0'; 
    
    
    //1:Image, 2:video, 3:Audio, 4:Text,Document
    $fileTypeText = '';
    switch($eleMediaFileType){
        case '2'://video
            if($isDownloadPrice=="t"){
                $fileTypeText = 'Video File';
            }elseif($isPrice=="t"){
                $fileTypeText = 'DVD';
            }
        break;
        
        case '3'://audio
             if($isDownloadPrice == "t"){
                 $fileTypeText = 'Audio File';
            }elseif($isPrice == "t"){
                 $fileTypeText = 'CD';
            }
        break;
        
        case '4'://text
            if($isDownloadPrice == "t"){
                 $fileTypeText = 'Text File';
            }elseif($isPrice == "t"){
                 $fileTypeText = 'Text';
            }
        break;
    }
    
    //------get user craved data ------//
    $cravedALL='';
    if(!empty($loggedUserId)){
        $where          =   array(
        'tdsUid'        =>  $loggedUserId,
        'entityId'      =>  $elementEntityId,
        'elementId'     =>  $elementId
        );
         
        $countResult    =   countResult('LogCrave',$where);
        $cravedALL      =   ($countResult>0)?'cravedALL':'';
    }

    $elementPageLink       =     'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId.'/'.$elementId.$previewWord
 
    ?>
       
       
   <div class="list_sambox ptr" onclick="window.location='<?php echo $elementPageLink; ?>'">
      <div class="clearb pt8 pb5 pl10 lett4">
          
           <?php if($elementType=="1" || $elementType=="2"){ ?>
            <b class="red">SAMPLE</b>
            <span class="pl15 "><?php echo showString($title,30); ?></span>
           <?php }else{ ?> 
            <?php echo showString($title,30); ?>
           <?php } ?> 
        </div>
      <div class="bg_e9e9 clearbox pt5 pb4 ">
         <span class="green font_bold fl pl10 width_80"><?php echo $fileTypeText; ?></span>
          <?php if($eleMediaFileType=="2" || $eleMediaFileType=="3"){ ?>
            <span class="red pl8 fl width100"> <?php echo playlistFileLength($fileLength); ?></span> 
          <?php } ?> 
         <span class="head_list fr pr15">
            <div class="icon_view3_blog  pr5 icon_so"><?php echo $viewCount; ?></div>
            <div class="icon_crave4_blog icon_so <?php echo $cravedALL; ?>"><?php echo $craveCount; ?></div>
         </span>
      </div>
   </div>
   <div class="sap_15 pt3 bb_d4d4d4"></div>
   <?php } ?>
  
   <div class="nav_creave mediacollection mt3 fr ">
      <?php
        //add preview word if preview mode is active
        $url =base_url()."en/mediafrontend/collectionmedialist/".$frentendUserId."/".$projectId.$previewWord;
        if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
                    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showCollection","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>false,'isBorder'=>false,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
        <?php } ?> 
   </div>
   
    
    
<?php } ?> 
