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
       <div class="fs18 red lineH30 bb_F1592A font_bold"><?php echo $purchaseData->category; ?> Auction</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Seller</span><span class="font_bold"><a href="<?php echo base_url_lang('showcase/index/'.$purchaseData->sellerId); ?>" target="_blank"><?php echo ucwords($purchaseData->firstName.' '.$purchaseData->lastName); ?></a></span></div>
       <div class="sale_btnwrap">
          <button class="sale_btn opacityP5" type="button">Sales Record</button>
          <button class="sale_btn contact_buyer white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/sellerInfoNew','<?php echo $purchaseData->itemId; ?>');"  type="button">Contact Seller</button>
          <button class="sale_btn opacityP5" type="button">
			  Comment on Purchase
			  
			  </button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="fs18 red lineH30 mb12 font_bold">You won the Auction, so you now need to Pay.</div>
       <div class="sap_65"></div>
       <p>You have won the Auction. You have <?php echo  $daysRemaining; ?> Days to pay.</p>
       <div class="sap_35"></div>
       <p>You can also pay from your <a href="<?php echo base_url_lang('cart/mywishlist'); ?>">Whish List.</a>			</p>
        <a href="<?php echo base_url_lang('cart/auctionpurcahse/').base64_encode($purchaseData->itemId); ?>">
           <button class="fr mt8 paynow_btn bg_f1592a bdr_aca height32">
           <span class="pay_text ">Pay Now</span>|<span class="pay_price "><?php echo $selectCurrency.' '.$itemPrice; ?></span>
           </button>
        </a>
        
    </div>
 </div>
