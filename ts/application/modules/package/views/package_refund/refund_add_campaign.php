<div id="divCounter<?php echo $divCounter; ?>" class="<?php echo ($divCounter=="1")?'':'dn'; ?>">

  <h3 class="red  fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('pack_refund_addCampaigns_heading'); ?></h3>

  <?php 
    if(!empty($projectDataList)) { 
  ?>
    <div class="ad_camp"> 
     <ul class="  width100_per mt60 lineH20  defaultP">
  <?php
    foreach($projectDataList as $projectdata){
      
      $totalCampaignPrice         =  0;
      $userContainerId            =  (!empty($projectdata['userContainerId']))?$projectdata['userContainerId']:'0';
      $campaignTitle              =  (!empty($projectdata['campaignname']))?$projectdata['campaignname']:'0';
      $campaignDescription        =  (!empty($projectdata['comments']))?$projectdata['comments']:'';
      $campaignPrice              =  (!empty($projectdata['totalPrice']))?$projectdata['totalPrice']:'0';
      $totalCampaignPrice         =   $totalCampaignPrice + $campaignPrice;
    ?>
    <li>
       <input type="checkbox" id="containerId_<?php echo $userContainerId; ?>" name="selectedContainerId[]" value="<?php echo $userContainerId; ?>" />
       <span class="red pl5 width_115"><?php echo $campaignTitle; ?></span><span class="pl50">
       <?php echo $campaignDescription; ?>
       </span><b class="fr red">  <?php echo (0< $campaignPrice)?' &euro;'.$campaignPrice:'FREE'; ?></b>
       
        <input type="hidden" name="<?php echo $userContainerId; ?>_industrySection" value="Collaboration">
        <input type="hidden" name="<?php echo $userContainerId; ?>_title" value="<?php echo $campaignTitle; ?>">
        <input type="hidden" name="<?php echo $userContainerId; ?>_price" value="<?php echo $campaignPrice?>">
        <input type="hidden" name="containerId[]" value="<?php echo $userContainerId?>">
    
    </li>
    <?php  } if($totalCampaignPrice > 0){ ?> 
         <li class="bt_aeaeae pt20 mt38"><b class="fr fs16 red "> &euro; <?php echo number_format($totalCampaignPrice,2) ?></b></li>
    <?php } ?>      
       </ul>
     </div>
  <?php } ?>

</div>
