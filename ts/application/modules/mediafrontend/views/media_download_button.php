<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if( isset($globalProjDownloadable) && isset($elementPresent) && $globalProjDownloadable =='t' && $elementPresent=='t'){ //if any donwloadable elemnt is presnet then show the download button
$loggedUserId=isloginUser();
$downloadLink='javascript:void(0);';
$downloadClass='fl';
if(isset($ownerId) && isset($entityId) && isset($elementId) && isset($projectId) && isset($fileId) && isset($tableName) && isset($primeryField) && isset($elementTable) && isset($elementPrimeryField) && isset($isElement)){
	if($isElement==0){
		$downloadClass='fr';
		$downloadLink=$userId.'+'.$elementId.'+'.$industryType.'+'.$loggedUserId.'+0';
		$downloadLink=encode($downloadLink);
		$downloadLink=base_url(lang().'/mediafrontend/downloadfile/'.$downloadLink);
	}else{
		$downloadLink=$ownerId.'+'.$entityId.'+'.$elementId.'+'.$projectId.'+'.$fileId.'+'.$tableName.'+'.$primeryField.'+'.$elementTable.'+'.$elementPrimeryField.'+'.$isElement.'+'.$loggedUserId.'+0';
		$downloadLink=encode($downloadLink);
		$downloadLink=lcfirst($downloadLink);
		$downloadLink=base_url(lang().'/download/file/'.$downloadLink);
		$downloadClass='fr';
	}
}
$beforeDownloadLoggedIn=$this->lang->line('beforeDownloadLoggedIn');
	
	if($loggedUserId > 0){
				
		if($isMajor || $isElement==0){
			$entityId=$projEntityId;
			$elementId=$projectId;
			$downloadPrice =$projDownloadPrice;
		}
		
		$downloadDisplyPrice = getDisplayPrice($downloadPrice,$seller_currency);		
		$where = array(
			'tdsUid'=>$loggedUserId,
			'elementId'=>$entityId,
			'entityId'=>$elementId											
		);
		
		$entityIdElementId=$entityId.'_'.$elementId;
		if($ownerId != $loggedUserId) {				
			$countResult=countResult('Wishlist',$where);
			$beforeBuyProduct = "You must be logged in to buy a product.";
			if($countResult>0){
				$alreadInWishlist="You have already added this product in your wishlist";
				$functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$alreadInWishlist."')}";

			}else{	
				$buyProduct=$this->load->view('cart/buy_product',array('productBasePrice' =>$downloadPrice,'price'=>$downloadDisplyPrice['displayPrice'],'currencySign'=>$downloadDisplyPrice['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projectId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'purchaseType'=>2), true);?>
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

	} else {
		$beforeBuyProduct = "You must be logged in to buy a product.";		
		$functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
	}

if($isElement==1) {
	
	$fileName=trim($fileName);
	$filePath=trim($filePath);
	$fpLen=strlen($filePath);
	if($fpLen > 0 && substr($filePath,-1) != '/'){
		$filePath=$filePath.'/';
	}
	 $file=$filePath.$fileName;
	
	if($isExternal != 't' && is_file($file)){
	
	if($projSellstatus && $isDefault !='t' && (($isDownloadPrice) || ($isMajor && $isprojPrice && $isprojDownloadPrice)) ){
		
		if($isMajor){
			$downloadPrice =$projDownloadPrice;
		}
		$downloadPrice = getDisplayPrice($downloadPrice,$seller_currency);
		$downloadClass='fl';
		$downloadLink='javascript:void(0);';
		$downLoadString=$this->lang->line('project_download').'&nbsp;'.$downloadPrice['currencySign'].' '.$downloadPrice['displayPrice'];
		$target='';
	}else{
		$downLoadString=$this->lang->line('project_download');
		$target='target="_blank"';
		$functionBuyProduct="return checkIsUserLogin('".$beforeDownloadLoggedIn."');";
	}?>
	<div class="<?php echo $downloadClass;?>">
		<div class="tds-button01 cell mr3"> 
			<a <?php echo $target;?> href='<?php echo $downloadLink;?>' onclick="<?php echo $functionBuyProduct;?>" onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" >
				<span>
					<?php echo $downLoadString;?>
				</span>
			</a> 
		</div> 
	</div>    
	<?php 
	}
}
else {

	if($isGlobalDownload=='t' || $isMajor || $projSellstatus==''){
		if($projSellstatus && $isprojDownloadPrice ){			
			$downloadPrice = getDisplayPrice($projDownloadPrice,$seller_currency);
			$downloadLink='javascript:void(0);';
			$downLoadString=$this->lang->line('project_download').'<br>'.$downloadPrice['currencySign'].' '.$downloadPrice['displayPrice'];
			$target='';
		}else{		
			$downLoadString='<span class="pt8 pb8">'.$this->lang->line('project_download').'</span>';
			$target='target="_blank"';
			$functionBuyProduct="return checkIsUserLogin('".$beforeDownloadLoggedIn."');";
		}
		
		?>
		<div class="cell productPriceButton ml20 height_90">
			<a <?php echo $target;?> href='<?php echo $downloadLink;?>' onclick="<?php echo $functionBuyProduct;?>">
				<div class="huge_btn Price_btn_style ptr black_link_hover" onmousedown="mousedown_huge_button(this)" onmouseup="mouseup_huge_button(this)" >
					<?php echo $downLoadString;?>
				</div>
			</a>
			<div class="clear"></div>
		</div> 
		<?php 
	}
}
}
?>
