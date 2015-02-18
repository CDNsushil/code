<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(!empty($isGlobalPriceDownload) && ($isGlobalPriceDownload =='f' || $isGlobalPriceDownload =='t') && !empty($isPrice) && $isPrice=="t")//if any donwloadable elemnt is presnet then show the PPV button
{
    
//check user is loggedIn
$loggedUserId = (isLoginUser())?isLoginUser():0;

//get element owner id
$elementOwnerId = (!empty($ownerId)) ? $ownerId : 0;		

$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');

//$functionBuyButton = ($tdsUid == $loginId)?"customAlert('".$canNotBuy."')":'';
if($price>0) { 
	$priceDetails = getDisplayPrice($price,$sellerCurrency);
	
    if($loggedUserId > 0){
	
    	$where = array(
			'tdsUid'    =>  $loggedUserId,
			'elementId' =>  $elementId,
			'entityId'  =>  $entityId											
		);
		
		$entityIdElementId=$entityId.'_'.$elementId;
		if($tdsUid != $loggedUserId) {				
			$countResult=countResult('Wishlist',$where);
			$beforeBuyProduct = "You must be logged in to buy a product.";
			if($countResult>0){
				$alreadInWishlist="You have already added this product in your wishlist";
				$functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$alreadInWishlist."')}";

			}else{
                
                $buyProduct=$this->load->view('cart/buy_product_new',array('productBasePrice' =>$price,'price'=>$priceDetails['displayPrice'],'currencySign'=>$priceDetails['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projectId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'purchaseType'=>1), true);?>
				<script>
				var DVDProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
				</script>
				<?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',DVDProduct".$entityIdElementId.")}";    
			}
		} else{  
			$beforeBuyProduct = "You must be logged in to buy a product.";
			$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
			$functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$canNotBuy."')}";
		}          

	} else {
		$beforeBuyProduct = "You must be logged in to buy a product.";		
		$functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
	}
    
     if($quantity>0){
?>
        <button class="pay_button text_alighC mt0" type="button" onclick="<?php echo $functionBuyProduct ?> "> 
                <span class="fl">
                <?php echo $this->lang->line($industryType.'_'.$mediaFileType.'_paid_physical_button'); ?> 
                </span>
                <span class="red fr pl10"><?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?></span>
        </button>
        
      <?php }else{ ?>
        
        <button class="pay_button red <?php echo ($showview=='project')?"fl":"fr mt0"; ?> collec_btn pl25 pr25" type="button">
           <?php echo $this->lang->line('m_sold_out'); ?> <span class="<?php echo ($showview=='project')?"pl10 pr12":""; ?> "></span> 
            <span class="pr10"><?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?></span> 
        </button>
                
    <?php } ?>
        
        <?php
       
        if($showview=="projectelement" && $industryType=='musicNaudio'){
            //this design for music and audio element details page
            echo '<div class="sap_5 "></div><div class="fl">';
            echo $this->load->view('shipping/shipping_frontend_view_new',array('elementId'=>$elementId,'entityId'=>$entityId,'designtype'=>'1'),true);
            echo '</div>';
        }else{
            echo $this->load->view('shipping/shipping_frontend_view_new',array('elementId'=>$elementId,'entityId'=>$entityId,'designtype'=>'1'),true);
        }
        
        if($showview=="projectelement" && $industryType=='musicNaudio'){
            echo    '<div class="sap_30 bb_e7e7e7"></div>
                    <div class="sap_20 "></div>';
        }        
	
    } //end if price>0
} 
?>
