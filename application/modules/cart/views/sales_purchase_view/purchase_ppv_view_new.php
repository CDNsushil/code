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
    
    //get product image
    $getImage = getImageInfo($entityId,$elementId,$sectionId);
    
    
    $dwnMaxday = $purchaseData->dwnMaxday;
    $expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='d F Y H:i:s');
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
        
        if(($entityId=='54') && ($elementId == $projId)){
            $isElement=0;
            $projElementId=0;
        }else{
            $isElement=1;
            $projElementId=$elementId;
        }
        
        $isTableFound=true;
        switch($sectionId){
            case '1':
                $industryType='filmvideo';
            break;
            
            case '2':
                $industryType='musicaudio';
            break;
            
            case '3':
                $industryType='writingpublishing';
            break;
            
            case '4':
                $industryType='photographyart';
            break;
            
            case '5':
                $industryType='educationmaterial';
            break;
                
            default:
                $isTableFound=false;
            break;
            
        }
        $downloadLink='javascript:void(0);';
        
        if($isTableFound){
            $traget='target="_blank"';
            $ppvLink=$ownerId.'+'.$projId.'+'.$industryType.'+'.$projElementId.'+'.$userId.'+'.$dwnId;
            $ppvLink=encode($ppvLink);
            $ppvLink=base_url(lang().'/mediafrontend/ppvfile/'.$ppvLink);
        }
    }
    
 ?>


<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 red lineH30  bb_F1592A font_bold"> Pay Per View Purchase</div>
       <div class="font_bold pt10 pb15"> <?php echo $purchaseData->itemName; ?>
       </div>
       <div class="date_wrap"> <span class="width_120 fl">Date & Time</span> <span><b><?php echo date("d F Y, H:i",strtotime($purchaseData->ordDateComplete)) ?></b> <span class="fs11 pl10"> Luxembourg Time</span></span> </div>
       <div class="date_wrap pt8"><span class="width_120">Seller</span><span class="font_bold"><a href="<?php echo base_url_lang('showcase/index/'.$purchaseData->sellerId); ?>" target="_blank"><?php echo ucwords($purchaseData->firstName.' '.$purchaseData->lastName); ?></a></span></div>
       <div class="sale_btnwrap">
            <a   href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank">
                <button class="sale_btn white_button" type="button">Sales Record</button>
            </a>
            <button class="sale_btn contact_buyer white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/sellerInfoNew','<?php echo $purchaseData->itemId; ?>');" type="button">Contact Seller</button>
            <button class="light_btn white_button" onclick="openLightBox('popupBoxWp','popup_box','/cart/commentonpurchase','<?php echo $purchaseData->entityId; ?>','<?php echo $purchaseData->elementId; ?>','<?php echo $purchaseData->ordId; ?>','<?php echo $purchaseData->itemId; ?>','<?php echo $purchaseData->sellerId; ?>');" id="Purchase<?php echo $purchaseData->itemId; ?>" type="button">
            <?php if($purchaseData->buyercommentsid == ""){ echo "Comment on Purchase"; }else{ echo "Edit your Comment"; } ?>
            </button>
       </div>
    </div>
    <!-- Half box gary  --> 
    <div class="half_box_second  verti_top">
       <div class="sap_10"></div>
       <div class="lettsp3 pb8">Your can access the files via download </div>
       <div  class="lettsp3 lineH14">until <b><span class="red"><?php echo date("d F Y",strtotime($expiryDate)); ?></span> <?php echo date("H:i",strtotime($expiryDate)); ?></b>  <span class="fs12">Luxembourg Time</span></div>
       <div class="sap_25"></div>
       <div class="sale_thum">
          <img src="<?php echo $getImage; ?>" alt="" />
       </div>
       <div class="sap_10"></div>
        <a href="<?php echo $ppvLink;?>" <?php echo $traget;?> >
        <button class="fr mr0 view_btn mt0" role="button" >View</button>
        </a>
    </div>
 </div>