<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    //get user info for seller currency and currency sign
    if(!isset($userInfo)){
        $userInfo = showCaseUserDetails($frentendUserId);
    }
    
    //get current element open data
    $elementData         =   false;
    if(!empty($elementDataList)):
        foreach($elementDataList as $key => $getElementData){
            //check element id and set data
            if($getElementData['elementId']==$elementId){
                $elementData        =  $getElementData;
            }
        }
    endif;
    
    //get seller currency data    
    $sellerCurrency    =   $userInfo['seller_currency'];
    $sellerCurrency    =   (!empty($sellerCurrency) && $sellerCurrency>0)?$sellerCurrency:0;
    $currencySign      =   $this->config->item('currency'.$sellerCurrency);
    
    //get project related information 
    $downloadPrice                =   (!empty($projectData['projDownloadPrice']))?$projectData['projDownloadPrice']:0;
    $projDonations                =   (!empty($projectData['projDonations']))?$projectData['projDonations']:'f';
    $projSellstatus               =   (!empty($projectData['projSellstatus']) && $projectData['projSellstatus']=='t')?true:false;
    $projSellType                 =   (!empty($projectData['projSellType']))?$projectData['projSellType']:'0';
    $projectId                    =   (!empty($projectData['projId']))?$projectData['projId']:'0';
    $projectOwnerId               =   (!empty($projectData['tdsUid']))?$projectData['tdsUid']:'0';
    $hasDownloadableFileOnly      =   (!empty($projectData['hasDownloadableFileOnly']))?$projectData['hasDownloadableFileOnly']:'0';
    $sellPriceType                =   (!empty($projectData['sellPriceType']))?$projectData['sellPriceType']:'0';
    $isprojDownloadPrice          =   (!empty($projectData['isprojDownloadPrice']))?$projectData['isprojDownloadPrice']:'t';
    $projDownloadPrice            =   (!empty($projectData['projDownloadPrice']))?$projectData['projDownloadPrice']:'0';
    $isprojPrice                  =   (!empty($projectData['isprojPrice']))?$projectData['isprojPrice']:'t';
    $projPrice                    =   (!empty($projectData['projPrice']))?$projectData['projPrice']:'0';
    $entityId                     =   (!empty($projectData['entityId']))?$projectData['entityId']:'0';
    $projQuantity                 =   (!empty($projectData['projQuantity']))?$projectData['projQuantity']:'0';
    
    //get element related information
    $downloadPriceElement                   =   (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:0;
    $perViewPriceElement                    =   (!empty($elementData['perViewPrice']))?$elementData['perViewPrice']:0;
    $priceElement                           =   (!empty($elementData['price']))?$elementData['price']:0;
    $isDownloadPriceElement                 =   (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f';
    $isPerViewPriceElement                  =   (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f';
    $isPriceElement                         =   (!empty($elementData['isPrice']))?$elementData['isPrice']:'f';
    $isPublishedElement                     =   (!empty($elementData['isPublished']))?$elementData['isPublished']:'f';
    $elementQuantity                        =   (!empty($elementData['quantity']))?$elementData['quantity']:'0';
    
    //check at least one element present in project
    $elementDataListCount    =      count($elementDataList);
    $elementPresent          =      (!empty($elementDataListCount))?'t':'f';
    
    // get published element array list 
    $isPublishedArray                =  search_nested_arrays($elementDataList,'isPublished');
    $globalElementIsPublished        =  'f';

    //check element is published or not atleast one
    if(!empty($isPublishedArray)){
        if(in_array('t',$isPublishedArray)){
            $globalElementIsPublished = 't';
        }
    }

    //if not element published then set false in present element
    $elementPresent = ($globalElementIsPublished=='f')?'f':'t';

    //get external media list array
    $isExternalArray            =  search_nested_arrays($elementDataList,'isExternal');
    $globalElementDownloadable  =  'f';
     
    //check  external media element is true set
    if(!empty($isExternalArray)){
        if(in_array('f',$isExternalArray)){
            $globalElementDownloadable = 't';
        }
    }

    //Check if all element are free having no download price button	
    $isDownloadPriceArray       =  search_nested_arrays($elementDataList,'isDownloadPrice');
    $downloadPriceArray         =  search_nested_arrays($elementDataList,'downloadPrice');
    $downloadPriceArrayCount    =  count($downloadPriceArray);
    $isGlobalPriceDownload           =  'f';
     
    //to check atleast one element has donwload price and status should be true
    for($j = 0; $j < $downloadPriceArrayCount; $j++)
    {
        if($downloadPriceArray[$j]>0 && $isDownloadPriceArray[$j]=='t') {
            $isGlobalPriceDownload = 't';
            break;
        }
    }

    //Check if all element are free having no PPV price button
    $isDVDPriceArray        =  search_nested_arrays($elementDataList,'isPrice');
    $DVDPriceArray          =  search_nested_arrays($elementDataList,'price');
    $DVDPriceArrayCount     =  count($DVDPriceArray);
    $isElementGlobalDVD     =  'f';

    //to check atleast one element should have price and isPrice should be true
    for($j = 0; $j < $DVDPriceArrayCount; $j++){
        if($DVDPriceArray[$j]>0 && $isDVDPriceArray[$j]=='t'){
            $isElementGlobalDVD = 't';
            break;
        }
    }
    

    // price button array for "donwload" and "payperview" and "DVD"
    $priceBtnDetails                =   array(
        'ownerId'                   =>  $projectOwnerId,
        'projectId'                 =>  $projectId,
        'entityId'                  =>  $elementEntityId,
        'elementId'                 =>  $elementId,
        'sectionId'                 =>  $sectionId,
        'projSellstatus'            =>  $projSellstatus,
        'sellPriceType'             =>  $sellPriceType,
        'hasDownloadableFileOnly'   =>  $hasDownloadableFileOnly,
        'sellerCurrency'            =>  $sellerCurrency,
        'downloadPrice'             =>  $downloadPriceElement,
        'perViewPrice'              =>  $perViewPriceElement,
        'price'                     =>  $priceElement,
        'isDownloadPrice'           =>  $isDownloadPriceElement,
        'isPerViewPrice'            =>  $isPerViewPriceElement,
        'isPrice'                   =>  $isPriceElement,
        'isPublished'               =>  $isPublishedElement,
        'globalElementDownloadable' =>  $globalElementDownloadable,
        'elementPresent'            =>  $elementPresent,
        'isGlobalPriceDownload'     =>  $isGlobalPriceDownload,
        'isElementGlobalDVD'        =>  $isElementGlobalDVD,
        'globalElementIsPublished'  =>  $globalElementIsPublished,
        'quantity'                  =>  $elementQuantity,
        'industryType'              =>  $industryType,
        'mediaFileType'              =>  $mediaFileType,
    );
    
        //check project sell status is free or paid
        if($projSellstatus){
            if($projSellType==1){
                
                //fixed price code here
                //1:A Price for the Collection,2:A Price for each Piece and Collection, 3: Price for the each piece
                if($hasDownloadableFileOnly==1 && $isprojDownloadPrice=='t'  && ($sellPriceType==3 || $sellPriceType==2)){
                
                    //load purchase for donwload button view 
                    $this->load->view('common_view/media_element_download_button_new',$priceBtnDetails);
                    
                }elseif($hasDownloadableFileOnly==0 && $sellPriceType==3 ){
                    
                    //load purchase for price/DVD button view 
                    if($isPriceElement=="t"){
                        echo Modules::run("common/elementDVDButton",$priceBtnDetails);
                    }
                    
                    //load purchase for donwload button view 
                    if($isDownloadPriceElement=="t"){
                        $this->load->view('common_view/media_element_download_button_new',$priceBtnDetails);
                    }
                   
                    //here we will show pay per view and download button
                    if($isPerViewPriceElement=="t"){
                        echo Modules::run("common/elementpayperview",$priceBtnDetails);
                    }
               
                }
            }
        }
?>
