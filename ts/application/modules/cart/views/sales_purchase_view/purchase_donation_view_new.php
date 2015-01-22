<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 red lineH30  bb_F1592A font_bold"> Donation</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Seller</span><span class="font_bold"><a href="<?php echo base_url_lang('showcase/index/'.$purchaseData->sellerId); ?>" target="_blank"><?php echo ucwords($purchaseData->firstName.' '.$purchaseData->lastName); ?></a></span></div>
       <div class="sale_btnwrap">
          <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank"> 
            <button class="sale_btn white_button" type="button">Sales Record</button>
          </a>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="sap_10"></div>
    </div>
</div>
