<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

   //get free project data and load into view
   $freeButtonDetails['projFreeData']      =   $projFreeData;
    
    //prepare data and check condition
    $isButtonShow                =  false;
    $hasDownloadableFileOnly     =  (!empty($projFreeData['hasDownloadableFileOnly']))?$projFreeData['hasDownloadableFileOnly']:'0';
    $globalElementDownloadable   =  (!empty($projFreeData['globalElementDownloadable']))?$projFreeData['globalElementDownloadable']:'f';
    $projSellstatus              =  (!empty($projFreeData['projSellstatus']))?$projFreeData['projSellstatus']:'0';
    $isprojDownloadPrice         =  (!empty($projFreeData['isprojDownloadPrice']))?$projFreeData['isprojDownloadPrice']:'f';
    $projDonations               =  (!empty($projFreeData['projDonations']))?$projFreeData['projDonations']:'f';

    //condition for free donwload button
    if($hasDownloadableFileOnly=='1' && $globalElementDownloadable=="t" && $projSellstatus==0 && $isprojDownloadPrice=='f'){
        $this->load->view('common_view/free_media_download_button_new',$projFreeData);
        $isButtonShow   =   true;
    }
    
    // if button is show then add seprator
    if($isButtonShow && $showview=="project" && $industryType=='writingNpublishing'){
        echo '<div class="sap_10 "></div>';
    }
    
    //check project donation allow
    if($projDonations=='t'){
        $this->load->view('common_view/donate_button_frontend',$projFreeData);
        $isButtonShow   =   true;
    }
    
    
    // if button is show then add seprator
    if($isButtonShow && $showview=="project" &&  $industryType!='writingNpublishing'){
        echo '<div class="sap_20 bb_e7e7e7"></div><div class="sap_20 "></div>';
    }
    
?>


