<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Add for buy space popup
$userContainerId = (isset($containerDetails[0]['userContainerId']) && ($containerDetails[0]['userContainerId']>0) ) ? $containerDetails[0]['userContainerId'] : 0 ; ?>

<input name="userContainerId" id="userContainerId" value="<?php echo $userContainerId ?>" type="hidden">

<?php
/* First save Work popup Start*/
	$isShowWorkPopup=$this->session->userdata('isShowWorkPopup');
	if(isset($isShowWorkPopup) && $isShowWorkPopup==1){
		$this->session->unset_userdata('isShowWorkPopup');
		$workUrl['descriptionUrl'] = 'javascript:void(0)';
		$workUrl['prMaterialUrl'] = '';
		$workUrl['indexUrl'] = site_url(lang()).'/work/'.$workType;
		$workUrl['popupSection'] = 'work';
		$popup_media = $this->load->view('common/afterSavePopup',$workUrl,true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				 loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}
/* First save Work popup End*/

echo Modules::run("work/workPromotionalVideo",$workId,$entityMediaType); 

if((isset($workId) && $workId>0) ){

$workPromotionalImages['strip']=1;//echo '<pre />';print_r($workPromotionalImages);
echo $this->load->view('mediatheme/promoImgAccordView',$workPromotionalImages);
} 
//end if WorkId is set to some existing Id 
?>

