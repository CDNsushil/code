<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$loggedUserId=isloginUser();
$userInfo = showCaseUserDetails($loggedUserId,'frontend');
//print_r($userInfo);
$beforeDonate=$this->lang->line('beforeDonateLoggedIn');
if($loggedUserId > 0 && ($ownerId!=$loggedUserId)){
	$donorDetail=array('entityId'=>$entityId,'elementId'=>$elementId,'projId'=>$projId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'seller_currency'=>$seller_currency);									  							  
	$donateInformation=$this->load->view("shipping/donatepopup",$donorDetail,true);
?>
<script>
	var donateData=<?php echo json_encode($donateInformation);?>;

</script>
<?php
	$functionDonate="loadPopupData('popupBoxWp','popup_box',donateData)";
}
else{
	$donateNowMsg = $this->lang->line('donateNowMsg');	
	if(isset($ownerId) && $ownerId>0)	
	$functionDonate = ($ownerId!=$loggedUserId)?"openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeDonate."')":"customAlert('".$donateNowMsg."')";
	else 
		$functionDonate = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeDonate."')";
}
?>
<div onclick="javascript:<?php echo $functionDonate;?>"  class="cell position_relative hiddenspaceDonate ptr formTip" title="<?php echo $this->lang->line('toolTipDonation');?>">
     <div class="huge_btn Price_btn_style black_link_hover" onmouseup="mouseup_huge_button(this)" onmousedown="mousedown_huge_button(this)"><span class="pt8 pb8"><?php echo $this->lang->line('donate');?></span></div>

</div>
