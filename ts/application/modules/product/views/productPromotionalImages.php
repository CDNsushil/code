<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
// Add for buy space popup
$userContainerId = (isset($containerDetails[0]['userContainerId']) && ($containerDetails[0]['userContainerId']>0) ) ? $containerDetails[0]['userContainerId'] : 0 ; ?>

<input name="userContainerId" id="userContainerId" value="<?php echo $userContainerId ?>" type="hidden">

<?php
/* Product first save product popup Start*/
	$isShowProductPopup=$this->session->userdata('isShowProductPopup');
	if(isset($isShowProductPopup) && $isShowProductPopup==1){
		$this->session->unset_userdata('isShowProductPopup');
		if($productType=='sell' || $productType=='wanted'){
			$workUrl['descriptionUrl'] = 'javascript:void(0)';
			$workUrl['prMaterialUrl'] = '';
		}
		$workUrl['indexUrl'] = site_url(lang()).'/product/'.$productType;
		$workUrl['popupSection'] = 'product';
		if($productType=='sell'){
			$workUrl['sellSettingUrl'] = site_url(lang()).'/dashboard/globalsettings';
		}
		$popup_media = $this->load->view('common/afterSavePopup',$workUrl,true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				 loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}
/* Product first save product popup End*/

echo Modules::run("product/productPromotionalVideo",$productId,$entityMediaType); 
?>

<?php
if((isset($productId) && $productId>0) )
{
	$productPromotionalImages['strip'] =1;
	//echo '<pre />';print_r($productPromotionalImages);
	echo $this->load->view('mediatheme/promoImgAccordView',$productPromotionalImages);
} 
?>

