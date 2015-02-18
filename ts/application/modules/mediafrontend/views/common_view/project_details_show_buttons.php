<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    
    //get user info for seller currency and currency sign
    if(!isset($userInfo)){
        $userInfo = showCaseUserDetails($frentendUserId);
    }
    
    //get seller currency data    
    $sellerCurrency    =   $userInfo['seller_currency'];
    $sellerCurrency    =   (!empty($sellerCurrency) && $sellerCurrency>0)?$sellerCurrency:0;
    $currencySign      =   $this->config->item('currency'.$sellerCurrency);
    
    //get related information 
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

    // price button for download and purchase product
    $priceBtnDetails=array(
        'ownerId'=>$projectOwnerId,
        'projEntityId'=>$entityId,
        'entityId'=>$entityId,
        'sectionId'=>$sectionId,
        'elementId'=>$projectId,
        'projectId'=>$projectId,
        'tableName'=>'Project',
        'primeryField'=>'projId',
        'elementTable'=>$elemetTable,
        'elementPrimeryField'=>'projId',
        'fileId'=>0,
        'isElement'=>0,
        'isMajor'=>false,
        'projSellstatus'=>$projSellstatus,
        'isprojPrice'=>$isprojPrice,
        'projPrice'=>$projPrice,
        'isprojDownloadPrice'=>$isprojDownloadPrice,
        'projDownloadPrice'=>$projDownloadPrice,
        'isPrice'=>false,
        'isDownloadPrice'=>false,
        'price'=>'',
        'downloadPrice'=>'',
        'fileName'=>'',
        'filePath'=>'',
        'isExternal'=>'',
        'isDefault'=>'',
        'sellerCurrency'=>$sellerCurrency,
        'globalElementDownloadable'=>$globalElementDownloadable,
        'elementPresent'=>$elementPresent,
        'isGlobalPriceDownload'=>$isGlobalPriceDownload,
        'isElementGlobalDVD'=>$isElementGlobalDVD,
        'hasDownloadableFileOnly'=>$hasDownloadableFileOnly,
        'globalElementIsPublished'=>$globalElementIsPublished,
        'sellPriceType'=>$sellPriceType,
        'showview'=>$showview,
        'industryType'   =>  $industryType,
    );
    
 
        //check project sell status is free or paid
        $isButtonShow = false;
        if($projSellstatus){
            if($projSellType==1){
                //fixed price code here
                
                if($hasDownloadableFileOnly==1 && $globalElementDownloadable=="t" &&  $isprojDownloadPrice=='t'  && ($sellPriceType==1 || $sellPriceType==2)){
                
                    //load purchase for donwload button view 
                    $this->load->view('common_view/media_download_button_new',$priceBtnDetails);
                    
                }elseif($hasDownloadableFileOnly==0 && $isprojPrice=='t'  &&  ($sellPriceType==1 || $sellPriceType==2)){
                  
                    //purchase and shipping view
                    
                    //set default quantity flag
                    $qunatityFlag   =   't';

                    //set default shipping flag
                    $shippingFlag   =   't';
                    
                    //Array is passed to give property of price button to get shown on the basisi of those
                    $buttonProperty = array(
                        'price'     =>  $projPrice,
                        'priceFlag' =>  $projectData['isprojPrice'],
                        'quantity'  =>  $projectData['projQuantity'],
                        'elementId' =>  $projectData['projId'],
                        'projId'    =>  $projectData['projId'],
                        'sectionId' =>  $sectionId,
                        'entityId'  =>  $entityId,
                        'projId'    =>  $projectData['projId'],
                        'sectionId' =>  $sectionId,
                        'shippingFlag'=>  $shippingFlag,
                        'qunatityFlag'=>  $qunatityFlag,
                        'seller_currency'=>  $sellerCurrency,
                        'buttonClass'   =>  ' ',
                        'buttonStyle'   =>  'big',
                        'tdsUid'    =>$frentendUserId,
                    );
                    
                    
                    //load product price button
                    $buttonProperty['buttonClass']      = $buttonClass;
                    $buttonProperty['priceBtnDetails']  = $priceBtnDetails;
                    echo Modules::run("common/buyCollectionButton",$buttonProperty);
                    
                }
                
            }elseif($projSellType==2){
                //auction button show data
                $bidCollectionData = array(
                    'projectId'      =>  $projectId,
                    'entityId'       =>  $entityId,
                    'elementId'      =>  $projectId,
                    'sectionId'      =>  $sectionId,
                    'ownerId'        =>  $projectOwnerId,
                    'currencySign'   =>  $currencySign,
                    'sellerCurrency' =>  $sellerCurrency,
                    'showview'       =>  $showview,
                    'industryType'   =>  $industryType,
                );
                echo Modules::run("auction/bidforcollection",$bidCollectionData);		
            }
        }else{
            
            $projFreeData                   =   array(
                'hasDownloadableFileOnly'   =>  $hasDownloadableFileOnly,
                'globalElementDownloadable' =>  $globalElementDownloadable,
                'projSellstatus'            =>  $projSellstatus,
                'isprojDownloadPrice'       =>  $isprojDownloadPrice,
                'projDonations'             =>  $projDonations,
                'entityId'                  =>  $entityId,
                'elementId'                 =>  $projectId,
                'projId'                    =>  $projectId,
                'sectionId'                 =>  $sectionId,
                'ownerId'                   =>  $frentendUserId,
                'currencySign'              =>  $currencySign,
                'sellerCurrency'            =>  $sellerCurrency,
                'showview'                  =>  $showview,
                'industryType'              =>  $industryType,
            );
            
            $freeButtonDetails['projFreeData']  =   $projFreeData;
            $this->load->view('common_view/free_project_button_view',$freeButtonDetails);
        }
?>
