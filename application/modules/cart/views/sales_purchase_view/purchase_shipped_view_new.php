<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    
    //get media industry Id
    $IndustryId         =   (!empty($purchaseData->IndustryId))?$purchaseData->IndustryId:0;
    $shpStatus          =   (!empty($purchaseData->shpStatus))?$purchaseData->shpStatus:0;
    $entityId           =   (!empty($purchaseData->entityId))?$purchaseData->entityId:0;
    $elementId          =   (!empty($purchaseData->elementId))?$purchaseData->elementId:0;
    $sectionId          =   (!empty($purchaseData->sectionId))?$purchaseData->sectionId:0;
    $itemId             =   (!empty($purchaseData->itemId))?$purchaseData->itemId:0;
    $shippingDetails    =   (!empty($purchaseData->shippingDetails))?$purchaseData->shippingDetails:'';
    
    //shipping status wise message show
    //0:Not shipped,1:shipped,2:Recived
    switch($shpStatus){
        case "0":
            $shippingMessage = 'The Seller has not shipped the <span class="clr_444">'.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
        break;
        
        case "1":
            $shippingMessage = 'The Seller has shipped the <span class="clr_444">'.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
        break;
        
        case "2":
            $shippingMessage = 'The buyer has recieved the goods.';
        break;
    }
    
    
    //get product image
    $getImage = getImageInfo($entityId,$elementId,$sectionId);

    
?>

<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 red lineH30  bb_F1592A font_bold"><?php echo $this->lang->line('physical_industry_'.$IndustryId); ?> Purchase</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Seller</span><span class="font_bold"><a href="<?php echo base_url_lang('showcase/index/'.$purchaseData->sellerId); ?>" target="_blank"><?php echo ucwords($purchaseData->firstName.' '.$purchaseData->lastName); ?></a></span></div>
       <div class="sale_btnwrap">
           <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
            <button class="sale_btn white_button" type="button">Sales Record</button>
          </a>
          <button class="sale_btn contact_buyer white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/sellerInfoNew','<?php echo $purchaseData->itemId; ?>');" type="button">Contact Seller</button>
          <button class="light_btn white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/commentonpurchase','<?php echo $purchaseData->entityId; ?>','<?php echo $purchaseData->elementId; ?>','<?php echo $purchaseData->ordId; ?>','<?php echo $purchaseData->itemId; ?>','<?php echo $purchaseData->sellerId; ?>');" id="Purchase<?php echo $purchaseData->itemId; ?>" type="button"><?php if($purchaseData->buyercommentsid == ""){ echo "Comment on Purchase"; }else{ echo "Edit your Comment"; } ?></button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
        
        
       <div class="fs18 red lineH30   font_bold">
          <?php echo $shippingMessage; ?> 
       </div>
       
        <?php
            if($shpStatus=="1" || $shpStatus=="2"){
            echo form_open('cart/shipping_details_submit/', 'class="form" id="shipping_details'.$formId.'" name="shipping_details'.$formId.'"'); 
        ?>
       
            <textarea type="text" id="shipdetails_<?php echo $formId; ?>"  name="shipdetails_<?php echo $formId; ?>"  class="mt15 width382 heightauto bg-non required"><?php echo $shippingDetails; ?></textarea>
                <div class="sap_10"></div>
                <div class="sale_thum">
                    <img src="<?php echo $getImage; ?>" alt="" />
               </div>
            <?php 
                if($shpStatus=="1"){
            ?>
                <div class="fl pt10 received_<?php echo $formId; ?>">
                  <p class="fs12">Let the seller know you recieved the item.</p>
                </div>
                <button type="submit" onclick="shippingdetailssubmit('<?php echo $formId; ?>')" id="button_<?php echo $formId; ?>" class="bg_f1592a fr bdr_aca height32 min_width114  received_<?php echo $formId; ?>">Received</button>
                <input type="hidden" name="item_id_<?php echo $formId; ?>" id="item_id_<?php echo $formId; ?>" value="<?php echo $itemId;  ?>">
            <?php }  ?>
           <?php echo form_close(); ?>
       
       <?php } ?>
       
    </div>
</div>
