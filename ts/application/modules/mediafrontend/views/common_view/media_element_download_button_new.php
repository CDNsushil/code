<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//this condition for paid element media donwload
if($elementPresent=='t' && $isDownloadPrice=='t' && $globalElementDownloadable=="t"){
    
    $loggedUserId   =   isloginUser();
    $downloadLink   =   'javascript:void(0);';
    
    $beforeDownloadLoggedIn=$this->lang->line('beforeDownloadLoggedIn');
    
    if($loggedUserId > 0){
                
     
        //get project donwload price data array
        $downloadDisplyPrice = getDisplayPrice($downloadPrice,$sellerCurrency);
        
        $where          =  array(
            'tdsUid'    => $loggedUserId,
            'elementId' => $elementId,
            'entityId'  => $entityId											
        );
        
            
        $entityIdElementId=$entityId.'_'.$elementId;
        if($ownerId != $loggedUserId) {				
            $countResult=countResult('Wishlist',$where);
            $beforeBuyProduct = "You must be logged in to buy a product.";
            if($countResult>0){
                $alreadInWishlist="You have already added this product in your wishlist";
                $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$alreadInWishlist."')}";

            }else{	
                $buyProduct=$this->load->view('cart/buy_product_new',array('productBasePrice' =>$downloadPrice,'price'=>$downloadDisplyPrice['displayPrice'],'currencySign'=>$downloadDisplyPrice['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projectId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'purchaseType'=>2), true);?>
                <script>
                var downloadProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
                </script>
                <?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',downloadProduct".$entityIdElementId.")}";    
            }
        } else{  
            $beforeBuyProduct = "You must be logged in to buy a product.";
            $canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
            $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$canNotBuy."')}";
        }

    }else {
        $beforeBuyProduct = "You must be logged in to buy a product.";		
        $functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
    }
    
    
    if($hasDownloadableFileOnly==0 || $globalElementDownloadable=='t'){
        if($projSellstatus==1 && $isDownloadPrice=='t'){
            //buy collection download button			
            $downloadPrice = getDisplayPrice($downloadPrice,$sellerCurrency);
            $downloadLink='javascript:void(0);';
            $downLoadString=$downloadPrice['currencySign'].' '.$downloadPrice['displayPrice'];
            $target='';
            $buttonLable = $this->lang->line($industryType.'_'.$mediaFileType.'_element_download_file');
        }
        
        ?>
             <a <?php echo $target;?> href='<?php echo $downloadLink;?>' onclick="<?php echo $functionBuyProduct;?>">
                <button class="pay_button eledownbuttn" type="button">
                    <?php echo $buttonLable; ?> 
                    <span class="red fr"><?php echo $downLoadString;?> </span>
                </button>
             </a>
         
        <?php 
        
        if($showview=="projectelement" && $industryType=='musicNaudio'){
            echo    '<div class="sap_30 bb_e7e7e7"></div>
                    <div class="sap_20 "></div>';
        }   
    }
    
}
?>
