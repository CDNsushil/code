<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$shippingDetails = (!empty($purchaseData->shippingDetails))?$purchaseData->shippingDetails:'';
?>
<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 green lineH30 bb_F1592A font_bold"><?php echo getSectioName($purchaseData->sectionId) ?>  </div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Buyer</span><span class="font_bold"><a href=""><?php echo ucwords($buyerName); ?></a></span></div>
       <div class="sale_btnwrap">
            <a  href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
                <button class="sale_btn white_button" type="button">Sales Record</button>
            </a>
          <button class="sale_btn contact_buyer white_button"  onClick="openLightBox('popupBoxWp','popup_box','/cart/buyerInfoNew','<?php echo $purchaseData->itemId; ?>');" type="button">Contact Buyer</button>
          <button class="light_btn opacityP5" type="button">Buyer’s Comment</button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
        
        <!--item not shipped section-->
            <?php if($purchaseData->shpStatus=="0"){ ?>
             <?php
                echo form_open('cart/shipping_details_submit/', 'class="form" id="shipping_details'.$formId.'" name="shipping_details'.$formId.'"'); 
            ?>	    
                <div class="fs18 red lineH30 mb12 lettsp1_5  font_bold">You need to ship <span class="clr_444">3 Printss</span>.</div>
                <p>
                    Send the buyer additional shipping information 
                    e.g. a tracking number when you ship their goods
                </p>
                <textarea type="text"  id="shipping_details_data<?php echo $formId ?>" name="shipping_details_data" value="" onclick="placeHoderHideShow(this,'Additional Shipping Information','hide')" onblur="placeHoderHideShow(this,'Additional Shipping Information','show')" placeholder="Additional Shipping Information" class="mt15 width382 required"></textarea>
                <div class="sap_30"></div>
                <button class="green_btn fr green_sale" type="submit" onclick="shipping_details_submit('<?php echo $formId; ?>')">Goods Shipped</button>
                 <input type="hidden" name="item_id" id="item_id" value="<?php echo $purchaseData->itemId;  ?>">
             <?php echo form_close(); ?>
            <?php } ?>
        <!--item not shipped section-->
        
          <!--item not shipped section-->
            <?php if($purchaseData->shpStatus=="1" || $purchaseData->shpStatus=="2"){ ?>
                <div class="fs18 red lineH30  lettsp1_5 font_bold">
                  The buyer has <?php echo ($purchaseData->shpStatus=="1")?"not":"";?> recieved the goods.
                </div>
                <textarea type="text"  class="mt15 width382 bg-non"><?php echo $shippingDetails; ?></textarea>
                <div class="sap_15"></div>
                <div class="sale_thum">
                  <!--<img src="images/sale_thub4.jpg" alt="" />-->
                </div>
            <?php } ?>
        <!--item not shipped section-->
       
    </div>
    
    
    
</div>
