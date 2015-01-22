<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//get the project categoryId
$categoryId = (!empty($getProjectDetails->projCategory))?$getProjectDetails->projCategory:'3';
?>
<div class="poup_bx music_popup shadow">
   <div class="close_btn big_close position_absolute" onClick="$(this).parent().trigger('close')"></div>
   <div class="music_pop_cnt pl8 ">
      <h2 class="opens_light lineH50 pt30 pb18 fs33 lett2p_5"><?php echo $this->lang->line('musicNaudio_media_listing_'.$categoryId); ?></h2>
      
        <?php
            if(!empty($elementDataList)){
            
            foreach($elementDataList as $elementData){
                
            $elementTitle           =    (!empty($elementData['title']))?$elementData['title']:0;
            $craveCount             =    (!empty($elementData['craveCount']))?$elementData['craveCount']:'0'; 
            $viewCount              =    (!empty($elementData['viewCount']))?$elementData['viewCount']:'0'; 
            $elementId              =    (!empty($elementData['elementId']))?$elementData['elementId']:'0'; 
            $frentendUserId         =    (!empty($elementData['tdsUid']))?$elementData['tdsUid']:'0'; 
            $fileLength             =    (!empty($elementData['fileLength']))?$elementData['fileLength']:'0'; 
            $fileId                 =    (!empty($elementData['fileId']))?$elementData['fileId']:'0'; 
            
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
            
            //crave div action
            $craveDivAction             =   'craveDiv'.$elementEntityId.''.$elementId;
        ?>
           
                <div class="muct_p_list width385">
                 <div class="bt_d4d4d4 pt12 pb15 clearbox">
                    <div class="sep fl pl5 pr25"><img src="<?php echo base_url('templates/new_version/images'); ?>/spet.png" alt="" /></div>
                    <div class="wid340 fl">
                        <a href="<?php echo base_url('mediafrontend/tracklist/'.$frentendUserId.'/'.$projectId.'/'.$elementId) ?>">
                            <div class="font_bold lineH18 letter_spP7 pb5 row red fl fs16"><?php echo $elementTitle; ?></div>
                        </a>
                       <div class="fr">
                          <div class="head_list fl ">
                             <div class="icon_view3_blog icon_so"><?php echo $viewCount ; ?></div>
                             <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo $craveCount ; ?></div>
                          </div>
                          <div class="red fr pr10 width90 pt3 text_alignR"> <?php echo playlistFileLength($fileLength); ?> </div>
                       </div>
                    </div>
                 </div>
                </div>
           
    
        <?php }  }?>
    
   </div>
</div>
