<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    $loggedUserId   =   isloginUser();
    $downloadLink   =   'javascript:void(0);';
    
    $beforeDownloadLoggedIn=$this->lang->line('beforeDownloadLoggedIn');
    
    if($loggedUserId > 0){
                
        if($isElement==0){
            $entityId       =   $projEntityId;
            $elementId      =   $projectId;
            $downloadPrice  =   $projDownloadPrice;
        }
        
        $downloadDisplyPrice = getDisplayPrice($downloadPrice,$sellerCurrency);
        
                
        $where = array(
            'tdsUid'=>$loggedUserId,
            'elementId'=>$elementId,
            'entityId'=>$entityId
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
            
            // check preview mode
            if(previewModeActive()){
                $canNotBuy = $this->lang->line('Youcannotbuyfromyourselfpreview');
            }
            
            $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$canNotBuy."')}";
        }          

    }else {
        $beforeBuyProduct = "You must be logged in to buy a product.";		
        $functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
    }
    
    //buy collection download button			
    $downloadPrice = getDisplayPrice($projDownloadPrice,$sellerCurrency);
    $downloadLink='javascript:void(0);';
    $downLoadString=$downloadPrice['currencySign'].' '.$downloadPrice['displayPrice'];
    ?>
    <a  href='<?php echo $downloadLink;?>' onclick="<?php echo $functionBuyProduct;?>">
        <?php if($showview=="projectelement"){?>
            <button class="green_btn" type="button"><span class="fl"><?php echo $this->lang->line($industryType.'_download_button'); ?></span> <span class=" pl7 pl10 pr7"> |</span> <?php echo $downLoadString;?> </button>
        <?php  } ?>
        
        <?php if($showview=="project"){?>
            <button class="pay_button" type="button"><span class="fl"><?php echo $this->lang->line($industryType.'_download_button'); ?></span> <span class="red pl10 fr"><?php echo $downLoadString;?></span></button>
        <?php  } ?>
    </a>

    <?php 
        //saparator show in project page
        /*
        if($showview=="project"){
            echo '<div class="sap_20 bb_e7e7e7"></div><div class="sap_20 "></div>';
        }
        */ 
    ?>
