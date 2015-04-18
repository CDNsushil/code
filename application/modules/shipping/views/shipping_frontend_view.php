<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $shippingInformation=Modules::run("shipping/shippingList",$elementId,$entityId,'shipping_frontend',true); ?>
<script>
	var shippingData=<?php echo json_encode($shippingInformation);?>;
</script>
<div class="huge_btn shipping_btn_style ptr black_link_hover"  onclick="loadPopupData('popupBoxWp','popup_box',shippingData)"><?php echo $this->lang->line('shippingCharges');?></div>
