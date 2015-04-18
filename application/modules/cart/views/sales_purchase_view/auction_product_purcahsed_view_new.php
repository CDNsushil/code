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
            $shippingMessage = 'The Seller has not shipped the <span class="clr_444">'.$physicalFileCount.' '.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
        break;
        
        case "1":
            $shippingMessage = 'The Seller has shipped the <span class="clr_444">'.$physicalFileCount.' '.$this->lang->line('physical_industry_'.$IndustryId).'</span>.';
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
    
    //echo $expiryDate;
    $currentDate=date('Y-m-d');
    $traget='';
    if(strtotime($currentDate) > strtotime($expiryDate)){
        $disable='opacity_4';
    }else{
        $disable='';
        $userId=$purchaseData->userId;
        $ownerId=$purchaseData->ownerId;
        $entityId=$purchaseData->entityId;
        $elementId=$purchaseData->elementId;
        $projId=$purchaseData->projId;
        $sectionId=$purchaseData->sectionId;
        $dwnId=$purchaseData->dwnId;
        
        $isTableFound=true;
        switch($sectionId){
            case '1':
                $industryType='filmNvideo';
                $elementTable='FvElement';
            break;
            
            case '2':
                $industryType='musicNaudio';
                $elementTable='MaElement';
            break;
            
            case '3':
                $industryType='writingNpublishing';
                $elementTable='WpElement';
            break;
            
            case '3:1':
                $industryType='news';
                $elementTable='NewsElement';
            break;
            
            case '3:2':
                $industryType='reviews';
                $elementTable='ReviewsElement';
            break;
            
            case '4':
                $industryType='photographyNart';
                $elementTable='PaElement';
            break;
            
            case '5':
                $industryType='educationMaterial';
                $elementTable='EmElement';
            break;
                
            default:
                $isTableFound=false;
            break;
            
        }
        $downloadLink='javascript:void(0);';
        
        if($isTableFound){
            if($isElement==0){
                
                //download link here
                $downloadLink=$ownerId.'+'.$elementId.'+'.$industryType.'+'.$userId.'+'.$dwnId;
                $downloadLink=encode($downloadLink);
                $downloadLink=base_url(lang().'/mediafrontend/downloadfilenew/'.$downloadLink);
                $traget='target="_blank"';
                
                //pay per view link
                $ppvLink=$ownerId.'+'.$projId.'+'.$industryType.'+'.$projId.'+'.$userId.'+'.$dwnId;
                $ppvLink=encode($ppvLink);
                $ppvLink=base_url(lang().'/mediafrontend/ppvfile/'.$ppvLink);
            }
        }
    }
    
?>
 <div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 red lineH30  bb_F1592A font_bold"><?php echo $purchaseData->category.' '.$projPurchase; ?> </div>
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
        <?php   if($isProductAuction=="t"){ ?>
            <div class="fs18 red lineH30 mb12  bb2_F1592A font_bold">	You have Paid. </div>
        <?php   }    ?>
       <div class="fs18 red lineH30 mb12  font_bold"><?php echo $shippingMessage; ?></div>
       
      <?php
            if($shpStatus=="1" || $shpStatus=="2"){
            echo form_open('cart/shipping_details_submit/', 'class="form" id="shipping_details'.$formId.'" name="shipping_details'.$formId.'"'); 
        ?>
       
            <textarea type="text" id="shipdetails_<?php echo $formId; ?>"  name="shipdetails_<?php echo $formId; ?>"  class="mt15 width382 heightauto bg-non required"><?php echo $shippingDetails; ?></textarea>
                <div class="sap_10"></div>
            
            <?php 
                if($shpStatus=="1"){
            ?>
                <div class="fl pt10 received_<?php echo $formId; ?>">
                  <p class="fs12">Let the seller know you recieved the item.</p>
                </div>
                <button type="submit" onclick="shippingdetailssubmit('<?php echo $formId; ?>')" id="button_<?php echo $formId; ?>" class="bg_f1592a fr bdr_aca height32 min_width114  received_<?php echo $formId; ?>">Received</button>
                <input type="hidden" name="item_id_<?php echo $formId; ?>" id="item_id_<?php echo $formId; ?>" value="<?php echo $itemId;  ?>">
                <div class="sap_20"></div>
            <?php } }  ?>
           <?php echo form_close(); ?>
       
       
       <hr class="bb2_F1592A pt3 clearb"  />
       <div class="sap_15"></div>
       
       
       <!---show files by industry--->
        <?php if($IndustryId!="10" && $mediaFileCount > 0){  ?>
           
            <div class="fs18 red lineH30 font_bold"><?php echo $mediaFileCount; ?> <span class="clr_444"> <?php echo $fileTextName; ?></span>.</div>
        
        <?php }elseif($IndustryId=="10"){ ?>
            <div class="fs18 red lineH30 font_bold"><?php echo $videoFileCount; ?> <span class="clr_444">Video Files</span>.</div>
            <div class="fs18 red lineH30 font_bold"><?php echo $audioFileCount; ?> <span class="clr_444">Audio Files</span>.</div>
            <div class="fs18 red lineH30 font_bold"><?php echo $docFileCount; ?> <span class="clr_444">Text Files</span>.</div>
        <?php } ?>
        
        
        <?php if($videoFileCount>0){ ?>
            <div class="sap_20"></div>
            <div class="lett_8p pb8"> You can access the files via download and/or Pay Per </div>
            <div  class="lett_8p lineH14">View until <b class="red date_sale"><?php echo  date("d F Y",strtotime($expiryDate)); ?></b> <b class="time"><?php echo date("H:i",strtotime($expiryDate)); ?></b>  <span class="fs12">Luxembourg Time</span></div>
            <div class="sap_20"></div>
             <a href="<?php echo $downloadLink;?>" <?php echo $traget;?> >
               <button class="fr bg_f1592a bdr_aca ml15 height32" >
               <span class="download_file pr20 ">Download All</span></button>
            </a>
            
            <a href="<?php echo $ppvLink;?>" <?php echo $traget;?> >
            <button class="fr mr0 view_btn view_all mt0 " role="button" >View All</button>
            </a>
        <?php } ?>
       
       <div class="sap_20"></div>
     
    </div>
 </div>
             
