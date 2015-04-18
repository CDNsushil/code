<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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
    
    
    //get product image
    $getImage = getImageInfo($entityId,$elementId,$sectionId);

?>
<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 green lineH30  bb_F1592A font_bold"><?php echo $fileTextName; ?> Sale</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Buyer</span><span class="font_bold"><a target="_blank" href="<?php echo base_url_lang('showcase/index/'.$purchaseData->customerUid)?>"><?php echo ucwords($buyerName); ?></a></span></div>
       <div class="sale_btnwrap">
            <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
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
            
          <button class="light_btn <?php echo $disabledClass; ?>"  <?php echo $disabled; ?> type="button" onclick="openLightBox('popupBoxWp','popup_box','/cart/buyercomments','<?php echo $purchaseData->itemId; ?>');" >Buyer’s Comment</button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="sap_30"></div>
       <div class="lettsp3 pb8">The buyer can access the file via download until</div>
       <div  class="lettsp3 lineH14"><b class="red date_sale"><?php echo date("d F Y",strtotime($purchaseData->dwnDate)); ?></b> <b class="time"><?php echo date("H:i",strtotime($purchaseData->dwnDate)); ?></b>  Luxembourg Time</div>
       <div class="sap_20"></div>
       <div class="sale_thum">
          <img src="<?php echo $getImage; ?>" alt="" />
       </div>
    </div>
 </div>

