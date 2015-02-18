<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(isset($globalProjDownloadable) && ($globalProjDownloadable =='t'))//if any donwloadable elemnt is presnet then show the PPV button
{

if(isLoginUser() == false){
	$loginId=0;
}else{
	$loginId=isLoginUser();
}
$tdsUid = (isset($tdsUid) && ($tdsUid!='')) ? $tdsUid : 0;		
$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');


if(@$price>0  && ($isGlobalDownload=='t' || $isMajor)) {
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
				$buyProduct=$this->load->view('cart/buy_product',array('productBasePrice' =>$price,'price'=>$priceDetails['displayPrice'],'currencySign'=>$priceDetails['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$priceBtnDetails['projectId'],'sectionId'=>$sectionId,'ownerId'=>$tdsUid,'purchaseType'=>3), true);?>
				<script>
				var buyProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
				</script>
				<?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',buyProduct".$entityIdElementId.")}";    
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

	if(strcmp($buttonStyle,'big')==0) {
		?>       
		<div class="row">
			<div class="position_relative hiddenspace height_25">				 
				<div class="huge_btn Price_btn_style ptr" onmouseup="mouseup_huge_button(this)" onmousedown="mousedown_huge_button(this)" onclick="<?php echo $functionBuyProduct; ?>">
					<div class="width205px black_link_hover"><?php echo $this->lang->line('project_payperview');?>
						<?php echo $priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?>
					</div>	
				</div>									
				<div class="clear"></div>
			</div>		   
		</div>
		<?php 
	}
	else { ?>
		<div class="tds-button01 cell mr3"> 
			<a onclick="<?php echo $functionBuyProduct; ?>" onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)">
			<span><?php echo $this->lang->line('project_payperview').'&nbsp;'.$priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?></span>
			</a> 
		</div>
	<?php 
	}
} //end if price>0
}
?>
