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
    $fileSize               =   (!empty($purchaseData->fileSize))?$purchaseData->fileSize:0;
    
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
        
        if(($entityId=='54') && ($elementId == $projId)){
            $isElement=0;
        }else{
            $isElement=1;
        }
        
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
                $downloadLink=$ownerId.'+'.$elementId.'+'.$industryType.'+'.$userId.'+'.$dwnId;
                $downloadLink=encode($downloadLink);
                $downloadLink=base_url(lang().'/mediafrontend/downloadfilenew/'.$downloadLink);
                $traget='target="_blank"';
            }else{
                $fileId=0;
                
                $downloadLink=$ownerId.'+'.$entityId.'+'.$elementId.'+'.$projId.'+'.$fileId.'+Project+projId+'.$elementTable.'+elementId+'.$isElement.'+'.$userId.'+'.$dwnId;
                $downloadLink=encode($downloadLink);
                $downloadLink=lcfirst($downloadLink);
                $downloadLink=base_url(lang().'/download/file/'.$downloadLink);
            }
        }
    }
    
 ?>
 
<div class="sale_box shadow_light">
    <!-- Half box white  --> 
    <div class="half_box verti_top">
       <div class="fs18 red lineH30  bb_F1592A font_bold"> <?php echo $fileTextName; ?> Purchase</div>
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
       <div class="sap_10"></div>
       <div class="lettsp3 pb8">Your can access the files via download </div>
       <div  class="lettsp3 lineH14">until <b><span class="red"><?php echo  date("d F Y",strtotime($expiryDate)); ?></span> <?php echo date("H:i",strtotime($expiryDate)); ?></b>  <span class="fs12">Luxembourg Time</span></div>
       <div class="sap_25"></div>
       <div class="sale_thum">
          <img src="<?php echo $getImage; ?>" alt="" />
       </div>
       <div class="sap_10"></div>
        <a href="<?php echo $downloadLink;?>" <?php echo $traget;?> >
           <button class="fr mt8 bg_f1592a bdr_aca height32 " role="button" aria-disabled="false">
                <span class="download_file pr20 mr10">Download</span>|
           <span class="pl5"> <?php echo formatSizeUnits($fileSize); ?></span>
           </button>
        </a>
    </div>
 </div>
