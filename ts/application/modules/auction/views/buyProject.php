<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Get users currency details
//$seller_currency = LoginUserDetails('seller_currency');
$seller_currency = getSellerInfo($ownerId);
$seller_currency = (isset($seller_currency) && $seller_currency>0)?$seller_currency:0;
$currencySign    = $this->config->item('currency'.$seller_currency);

$buyProduct=$this->load->view('cart/buy_product',array('productBasePrice' =>$basePrice,'price'=>$price,'currencySign'=>$currencySign ,'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'purchaseType'=>$purchaseType,'sellType'=>1), true);?>
<script>
	var buyProduct<?php echo $projId;?> =<?php echo json_encode($buyProduct);?>
</script>
<?php 
	$beforeBuyProduct = "You must be logged in to buy a product.";	
	$functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',buyProduct".$projId.")}"; 
?>
<div id="buyProject" onclick="<?php echo $functionBuyProduct;?>"></div>

<script>
	$(document).ready(function(){
		$("#buyProject").trigger('click');
	});
</script>


