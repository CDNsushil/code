<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//get purchase count days
$daysRemaining       =   daycountdown($purchaseData->ordDateComplete,"7");

$itemValue           =   (!empty($purchaseData->itemValue))?$purchaseData->itemValue:0;
$itemPrice           =   number_format($itemValue,2);
$ordCurrency         =   (!empty($purchaseData->ordCurrency))?$purchaseData->ordCurrency:0;
$selectCurrency      =   ($ordCurrency==1)?'$':'€';

?>

<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 green lineH30  bb_F1592A font_bold"><?php echo $purchaseData->category; ?>   Auction</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Buyer</span><span class="font_bold"><a target="_blank" href="<?php echo base_url_lang('showcase/index/'.$purchaseData->customerUid)?>"><?php echo ucwords($buyerName); ?></a></span></div>
       <div class="sale_btnwrap">
          <button class="sale_btn white_button opacityP5" type="button">Sales Record</button>
          <button class="sale_btn contact_buyer white_button" onClick="openLightBox('popupBoxWp','popup_box','/cart/buyerInfoNew','<?php echo $purchaseData->itemId; ?>');"  type="button">Contact Buyer</button>
          <button class="light_btn opacityP5" type="button">Buyer’s Comment</button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="fs18 red lineH30  lettsp1_5 font_bold">
            Waiting for Payment.
       </div>
    </div>
 </div>
  
