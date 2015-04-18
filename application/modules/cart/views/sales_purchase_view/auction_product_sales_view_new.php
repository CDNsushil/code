<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//get purchase order date
    $ordDateComplete           =     strtotime($purchaseData->ordDateComplete);
    
    //auction product use date
    $auctionProductUseDate     =    strtotime("+7 day", $ordDateComplete);
    $productUseData            =    date('d F Y',$auctionProductUseDate);
    $productUseTime            =    date('H:i',$auctionProductUseDate);
    $IndustryId                =    $purchaseData->IndustryId;
    
    //get details of data
    $IndustryId             =   (!empty($purchaseData->IndustryId))?$purchaseData->IndustryId:0;
    $shpStatus              =   (!empty($purchaseData->shpStatus))?$purchaseData->shpStatus:0;
    $entityId               =   (!empty($purchaseData->entityId))?$purchaseData->entityId:0;
    $elementId              =   (!empty($purchaseData->elementId))?$purchaseData->elementId:0;
    $sectionId              =   (!empty($purchaseData->sectionId))?$purchaseData->sectionId:0;
    $itemId                 =   (!empty($purchaseData->itemId))?$purchaseData->itemId:0;
    $shippingDetails        =   (!empty($purchaseData->shippingDetails))?$purchaseData->shippingDetails:'';
    $imageFileCount         =   (!empty($purchaseData->imageFileCount))?$purchaseData->imageFileCount:0;
    $videoFileCount         =   (!empty($purchaseData->videoFileCount))?$purchaseData->videoFileCount:0;
    $audioFileCount         =   (!empty($purchaseData->audioFileCount))?$purchaseData->audioFileCount:0;
    $docFileCount           =   (!empty($purchaseData->docFileCount))?$purchaseData->docFileCount:0;
    $cdCount                =   (!empty($purchaseData->cdCount))?$purchaseData->cdCount:0;
    $dvdCount               =   (!empty($purchaseData->dvdCount))?$purchaseData->dvdCount:0;
    $printCount             =   (!empty($purchaseData->printCount))?$purchaseData->printCount:0;
    $docCount               =   (!empty($purchaseData->docCount))?$purchaseData->docCount:0;
    
    $mediaFileCount     =   '';
    $physicalFileCount  =   '';
    //get media file by industry type
    switch($IndustryId){
        
        case "1": // film & video
            $mediaFileCount     = $videoFileCount;
            $physicalFileCount  = $dvdCount;
            $fileTextName       = 'Video Files';
        break;
        
        case "2": // music & audio
            $mediaFileCount     = $audioFileCount;
            $physicalFileCount  = $cdCount;
            $fileTextName       = 'Audio Files';
        break;
        
        case "3": // writting & publishing
            $mediaFileCount     = $docFileCount;
            $physicalFileCount  = $docCount;
            $fileTextName       = 'Text Files';
        break;
        
        case "4": // photography & art
            $mediaFileCount     = $imageFileCount;
            $physicalFileCount  = $printCount;
            $fileTextName       = 'Image Files';
        break;
        
        case "10": // educational material
            
        break;
    }
    
    //shipping status wise message show
    //0:Not shipped,1:shipped,2:Recived
    switch($shpStatus){
        case "0":
            $shippingMessage = 'You need to ship <span class="clr_444">'.$physicalFileCount.' '.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
        break;
        
        case "1":
            $shippingMessage = 'You have shipped  <span class="clr_444">'.$physicalFileCount.' '.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
        break;
        
        case "2":
            $shippingMessage = 'The buyer has recieved the goods.';
        break;
    }
    
    
    //get purchase mode type
    $isProductAuction = (!empty($purchaseData->isProductAuction))?$purchaseData->isProductAuction:'f';
    
    if($isProductAuction=="t"){
        $projPurchase   = 'Auction';
    }else{
        $projPurchase   = 'Purchase';
    }
    
    $dwnMaxday = $purchaseData->dwnMaxday;
    
    $expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='d F Y H:i:s');
?>
<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 green lineH30  bb_F1592A font_bold"><?php echo $purchaseData->category.' '.$projPurchase; ?></div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Buyer</span><span class="font_bold"><a target="_blank" href="<?php echo base_url_lang('showcase/index/'.$purchaseData->customerUid)?>"><?php echo ucwords($buyerName); ?></a></span></div>
       <div class="sale_btnwrap">
          <a href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
            <button class="sale_btn white_button" type="button">Sales Record</button>
          </a>
          <button class="sale_btn contact_buyer white_button"  onclick="openLightBox('popupBoxWp','popup_box','/cart/buyerInfoNew','<?php echo $purchaseData->itemId; ?>');" type="button">Contact Buyer</button>
        
            <?php 
                    $disabled       =  "";
                    $disabledClass  =  "";
                    if(empty($purchaseData->buyercommentsid)){ 
                        $disabled       =  "disabled";
                        $disabledClass  =  "opacityP5";
                    }
            ?>
            
            <button class="light_btn <?php echo $disabledClass; ?>" <?php echo $disabled; ?> type="button"  onclick="openLightBox('popupBoxWp','popup_box','/cart/buyercomments','<?php echo $purchaseData->itemId; ?>');" >Buyer’s Comment</button>
            
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
        <?php   if($isProductAuction=="t"){ ?>
            <div class="fs18 red lineH30 mb12 lettsp1_5 bb2_8b9c00 font_bold">Payment Recieved. </div>
        <?php   }    ?>
       
       <div class="fs18 red lineH30 mb12 lettsp1_5 font_bold"> <?php echo $shippingMessage; ?> </div>
      
        <?php
            echo form_open('cart/shipping_details_submit/', 'class="form" id="shipping_details'.$formId.'" name="shipping_details'.$formId.'"'); 
        ?>
            <?php 
                if($shpStatus=="0"){
            ?>
           <p>Send the buyer additional shipping information e.g. a tracking
              number when you ship their goods
           </p>
           <?php } ?>
       
            <textarea type="text" id="shipdetails_<?php echo $formId; ?>"  name="shipdetails_<?php echo $formId; ?>"  class="mt15 width382 heightauto bg-non required"><?php echo $shippingDetails; ?></textarea>
                <div class="sap_10"></div>
             
            <?php 
                if($shpStatus=="0"){
            ?>
               
                <button type="submit" onclick="shipping_details_submit('<?php echo $formId; ?>')" id="button_<?php echo $formId; ?>" class="green_btn fr green_sale  received_<?php echo $formId; ?>">Goods Shipped</button>
                <input type="hidden" name="item_id_<?php echo $formId; ?>" id="item_id_<?php echo $formId; ?>" value="<?php echo $itemId;  ?>">
                <div class="sap_20"></div>
            <?php }  ?>
           <?php echo form_close(); ?>
       
       <hr class="bb2_8b9c00 pt23 mb15 clearb"  />
       <!---show files by industry--->
        <?php if($IndustryId!="10" && $mediaFileCount > 0){  ?>
           
            <div class="fs18 red lineH30 font_bold"><?php echo $mediaFileCount; ?> <span class="clr_444"> <?php echo $fileTextName; ?></span>.</div>
        
        <?php }elseif($IndustryId=="10"){ ?>
            <div class="fs18 red lineH30 font_bold"><?php echo $videoFileCount; ?> <span class="clr_444">Video Files</span>.</div>
            <div class="fs18 red lineH30 font_bold"><?php echo $audioFileCount; ?> <span class="clr_444">Audio Files</span>.</div>
            <div class="fs18 red lineH30 font_bold"><?php echo $docFileCount; ?> <span class="clr_444">Text Files</span>.</div>
        <?php } ?>
       <div class="sap_15"></div>
       <div class="lettsp3 pb8"> The buyer can taccess the files via download and/or Pay</div>
       <div  class="lettsp3 lineH14"> Per View until <b class="red date_sale"><?php echo  date("d F Y",strtotime($expiryDate)); ?></b> <b class="time"><?php echo date("H:i",strtotime($expiryDate)); ?></b>  Luxembourg Time</div>
       
       
    </div>
 </div>
