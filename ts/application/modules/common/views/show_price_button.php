<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(isLoginUser() == false) {
	$loginId=0;
}else{
	$loginId=isLoginUser();
}

$tdsUid = (isset($tdsUid) && ($tdsUid!='')) ? $tdsUid : 0;		
$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
//$functionBuyButton = ($tdsUid == $loginId)?"customAlert('".$canNotBuy."')":'';
if(@$price>0 && $quantity>0) { 
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
				$buyProduct=$this->load->view('cart/buy_product',array('productBasePrice' =>$price,'price'=>$priceDetails['displayPrice'],'currencySign'=>$priceDetails['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projId,'sectionId'=>$sectionId,'ownerId'=>$tdsUid,'purchaseType'=>1), true);?>
				<script>
				var PpvProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
				</script>
				<?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',PpvProduct".$entityIdElementId.")}";    
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

	if(strcmp($buttonStyle,'big')==0) {?>
		<div class="<?php echo $buttonClass;?>">
			<div class="huge_btn Price_btn_style ptr black_link_hover" onclick="<?php echo $functionBuyProduct ?> "><?php echo $this->lang->line('product');?> <br>
				<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?>
			</div>
			<?php echo $shippingView = $this->load->view('shipping/shipping_frontend_view',array('elementId'=>$elementId,'entityId'=>$entityId),true);?>
			<div class="clear"></div>
		</div> 
		<?php 
	}else{ ?>
		<div class="tds-button01 cell mr3"> 
			<a onclick="<?php echo $functionBuyProduct ?> " onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)">
				<span><?php echo $this->lang->line('product').'&nbsp;'.$priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?></span>
			</a> 
		</div>
		<?php 
	}
} //end if price>0
?>
