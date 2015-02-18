<div id="divCounter<?php echo $divCounter; ?>" class="<?php echo ($divCounter=="1")?'':'dn'; ?>" >

  <h3 class="red  fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('pack_refund_upcoming_heading'); ?></h3>

  <?php 
    if(!empty($projectDataList)) { 
    
    foreach($projectDataList as $projectdata){
      
      $industryType               =  (!empty($projectdata['containertype']))?$projectdata['containertype']:'0';
      
      if($industryType==$sectionname){
      
      $userContainerId            =  (!empty($projectdata['userContainerId']))?$projectdata['userContainerId']:'0';
      $projectId                  =  (!empty($projectdata['elementId']))?$projectdata['elementId']:'0';
      $projectTitle               =  (!empty($projectdata['projTitle']))?$projectdata['projTitle']:'';
      $viewCount                  =  (isset($projectdata['viewCount']))?$projectdata['viewCount']:'0';
      $reviewCount                =  (isset($projectdata['craveCount']))?$projectdata['reviewCount']:'0';
      $craveCount                 =  (isset($projectdata['craveCount']))?$projectdata['craveCount']:'0';
      $ratingAvg                  =  (isset($projectdata['ratingAvg']))?$projectdata['ratingAvg']:'0';
      $projPublisheDate           =  (!empty($projectdata['projPublisheDate']))?$projectdata['projPublisheDate']:'';
      $userDefaultTsProductId     =  (isset($projectdata['userDefaultTsProductId']))?$projectdata['userDefaultTsProductId']:'0';
      $countryName                =  (isset($projectdata['countryName']))?$projectdata['countryName']:'0';
      $industryName               =  (isset($projectdata['IndustryName']))?$projectdata['IndustryName']:'';
      $IndustryId                 =  (!empty($projectdata['IndustryId']))?$projectdata['IndustryId']:'0';
      
      // get ratting image
      $ratingAvg = roundRatingValue($ratingAvg);
      $ratingImg = 'templates/new_version/images/rating/rating_0'.$ratingAvg.'.png';
      
      // check container is free or paid
      if( $userDefaultTsProductId > 0){
         $containerPrice         = '0';
      }else{
        $containerPrice         =  (isset($projectdata['price']))?$projectdata['price']:'0';
      }
      
      // get used space of container
      $dirname               =   'media/'.LoginUserDetails('username').'/upcomingProjects/'.$projectId.'/';
      $usedSpaceSizeInBytes  =   getFolderSize($dirname);
      $usedSpaceSize         =   bytestoMB($usedSpaceSizeInBytes,'mb');
      $usedSpaceSize         =   number_format($usedSpaceSize,2);
      
      //get extra space array  
      $extraSpaceArray       =  packageContainerPrice($usedSpaceSizeInBytes); 
      $isExtraSpace          =  $extraSpaceArray['isExtraSpace'];
      $ExtraSpaceSize        =  $extraSpaceArray['usedExtraSpace'];
      $ExtraSpaceTotalPrice  =  $extraSpaceArray['usedExtraSpacePrice'];
      
      //calculate container total price
      $containerTotalPrice    =  $containerPrice +  $ExtraSpaceTotalPrice; 
      
      //get upcoming album content 
      $upcomingMediaList      =  getUpcomingMediaList($projectId);
      
      $videosCount   =  0;
      $imageCount    =  0;
      $audioCount    =  0;
      $textCount     =  0;
      
     //count calculate of video and extract
      if(!empty($upcomingMediaList)){
        foreach($upcomingMediaList as $upcomingMedia){
          if($upcomingMedia['mediaType']=="1"){
            $imageCount++;
          }elseif($upcomingMedia['mediaType']=="2"){
            $videosCount++;
          }elseif($upcomingMedia['mediaType']=="3"){
            $audioCount++;
          }elseif($upcomingMedia['mediaType']=="4"){
            $textCount++;
          }
        }
      }
    
    // get project image
    $projectImage = getPackageProjectImage($projectdata,$elementEntityId);
  ?>

    <div class=" width100_per mt60 defaultP">
     <input type="checkbox" id="containerId_<?php echo $userContainerId; ?>" name="selectedContainerId[]" value="<?php echo $userContainerId; ?>" />
     <div class="collaborat_wrap pl15 pr15 pt8 pb15 fr width_545 shadow_light bdr_c3c3c3">
        <div class="bb_F1592A display_block width100_per fl  mb5 pb4">
           <h4 class="font_museoSlab fl mt6"><?php echo $projectTitle; ?></h4>
           <div class=" fr text_alignR fs13 font_weight lineH20 ">
              <span> UPCOMING <span class="red"> <?php echo $industryName; ?> Collection</span> </span>
              <p><?php echo $countryName; ?></p>
           </div>
        </div>
        <div class="collbartion_box fl width100_per  pt5 lineH14 fs11 ">
           <div class="fr color_666">
              <div class="eye_view icon_so"><?php echo $viewCount; ?></div>
              <div class="blog_view icon_so"><?php echo $craveCount; ?></div>
              <div class="rating_view icon_so"> 
               <img  src="<?php echo base_url($ratingImg);?>" />
              </div>
              <div class="share_view icon_so pr0"><?php echo $reviewCount; ?></div>
           </div>
        </div>
        <ul  class=" fs13 collabration_wrap pt18 clearb fl width100_per">
           <li class="width_141"> <span class="pb9">Published<br />
             <?php echo dateFormatView($projPublisheDate,'d F Y'); ?>  </span> <span class="pb9">Pricing<br />
              <b class="red"><?php echo ($containerPrice > 0)?'Paid':'FREE'; ?> </b> </span> <span class="">Storage Space Used <b class="red"><?php echo $usedSpaceSize; ?> MB</b> </span>
           </li>
           <li class="width152 bdrR_c3c3c3 bdrL_c3c3c3">
             <b class="fs14 fl pb10 clearb">Album Contents</b> 
             <span > <b class="red fs14"><?php echo $videosCount;  ?></b> Videos</span> 
             <span > <b class="red fs14"><?php echo $audioCount;  ?></b> Audio </span> 
             <span > <b class="red fs14"><?php echo $imageCount;  ?></b> Image </span> 
             <span > <b class="red fs14"><?php echo $textCount;  ?></b> Writting </span> 
             
             </li>
           <li class="pr0 width180 pl0  mr-15 text_alignC bdr_non"><img src="<?php echo $projectImage; ?>" alt="" class="maxWidth165px maxHeight113px" /></li>
        </ul>
     </div>
     <div class="display_table fr width_545 pr10 red fs16">
       <ul class="display_block collb_list pt25">
           <li><span class="fl">Media Showcase per annum</span> <span class="fr"> 
             <?php 
                echo (0< $containerPrice)?'€ '.number_format($containerPrice,'2'):"FREE";
              ?>
             </span></li>
           <?php if($isExtraSpace){ ?>
              <li><span class="fl"><?php echo bytestoMB($ExtraSpaceSize,'mb'); ?> MB Extra Storage Space</span> <span class="fr">€ <?php echo number_format($ExtraSpaceTotalPrice,'2'); ?></span></li>
              <li class=" BT_dadada pt8 mt5"> <span class="fr">  <?php echo (0< $containerPrice)?'€ '.number_format($containerTotalPrice,'2'):''; ?></span></li>
           <?php }else{ ?>
              <li class=" BT_dadada pt8 mt5"> <span class="fr">  &nbsp;</span></li>
            <?php } ?>
        </ul>
     </div>
    </div>
    
    <input type="hidden" name="<?php echo $userContainerId; ?>_containerPrice"  value="<?php echo  $containerPrice; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_extraSpacePrice" value="<?php echo  $ExtraSpaceTotalPrice; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_extraSpaceSize"  value="<?php echo  $ExtraSpaceSize; ?>">
    
    <input type="hidden" name="<?php echo $userContainerId; ?>_industrySection" value="UPCOMING <?php echo $industryName; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_title" value="<?php echo $projectTitle; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_price" value="<?php echo $containerTotalPrice?>">
    <input type="hidden" name="containerId[]" value="<?php echo $userContainerId?>">

  <?php } } } ?>

</div>
