<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(isLoginUser() == false) {
	$loginId=0;
}else{
	$loginId=isLoginUser();
}

$tdsUid = (isset($tdsUid) && ($tdsUid!='')) ? $tdsUid : 0;		
$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
//$functionBuyButton = ($tdsUid == $loginId)?"customAlert('".$canNotBuy."')":'';
if($price>0) { 
	$priceDetails = getDisplayPrice($price,$seller_currency);
	$loggedUserId=isloginUser();
	if($loggedUserId > 0){
		$entityId=isset($priceBtnDetails['entityId'])?$priceBtnDetails['entityId']:$entityId;
		$elementId=isset($priceBtnDetails['elementId'])?$priceBtnDetails['elementId']:$elementId;
		
		if(isset($priceBtnDetails['isMajor']) && isset($priceBtnDetails['isElement']) && $priceBtnDetails['isMajor'] && $priceBtnDetails['isElement']){
			$entityId=$priceBtnDetails['projEntityId'];
			$elementId=$priceBtnDetails['projectId'];
		}
		
		$where = array(
			'tdsUid'=>$loggedUserId,
			'elementId'=>$entityId,
			'entityId'=>$elementId											
		);
		
		$entityIdElementId=$entityId.'_'.$elementId;
		if($tdsUid != $loggedUserId) {				
			$countResult=countResult('Wishlist',$where);
			$beforeBuyProduct = "You must be logged in to buy a product.";
			if($countResult>0){
				$alreadInWishlist="You have already added this product in your wishlist";
				$functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$alreadInWishlist."')}";

			}else{	
				$buyProduct=$this->load->view('cart/buy_product_new',array('productBasePrice' =>$price,'price'=>$priceDetails['displayPrice'],'currencySign'=>$priceDetails['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projId,'sectionId'=>$sectionId,'ownerId'=>$tdsUid,'purchaseType'=>1), true);?>
				<script>
				var PpvProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
				</script>
				<?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',PpvProduct".$entityIdElementId.")}";    
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

	} else {
		$beforeBuyProduct = "You must be logged in to buy a product.";		
		$functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
	}
    
    $showview       =   $priceBtnDetails['showview'];
    $industryType   =   $priceBtnDetails['industryType'];
    
        if($quantity>0){
?>
            <button class="green_btn <?php echo ($showview=='project')?"fl":"fr mt0"; ?> collec_btn"  onclick="<?php echo $functionBuyProduct ?> " type="button"> 
                <?php echo $this->lang->line($industryType.'_download_button'); ?> <span class="pl10 pr10">|</span> <?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?>
            </button>
        <?php }else{ ?>
            
            <button class="pay_button red <?php echo ($showview=='project')?"fl":"fr mt0"; ?> collec_btn pl25 pr25" type="button">
                SOLD OUT <span class="<?php echo ($showview=='project')?"pl10 pr12":""; ?> "></span> 
                <span class="pr10"><?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?></span> 
            </button>
                    
        <?php } ?>
        <?php
       
        echo $shippingView = $this->load->view('shipping/shipping_frontend_view_new',array('elementId'=>$elementId,'entityId'=>$entityId,'showview'=>$showview),true);
        /*
        if($showview=="project" && $industryType!="writingNpublishing"){
            echo '<div class="sap_20 bb_e7e7e7"></div><div class="sap_20 "></div>';
        }
        */ 
    
    } //end if price>0
?>
