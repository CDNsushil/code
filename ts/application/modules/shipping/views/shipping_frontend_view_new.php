<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    $designtypeshow = (!empty($designtype))?$designtype:1;
    $shippingInformation=Modules::run("shipping/shippingList",$elementId,$entityId,'shipping_frontend_new',true); 
?>
<script>
	var shippingData=<?php echo json_encode($shippingInformation);?>;
</script>

<?php if($designtypeshow==1){ ?>
<!--<p class="fs11 clearb mt10">This Album contains physical goods that will be shipped to you.</p>-->
<a class="btn_review mt3 <?php echo ($showview=='project')?"fl clearb":"fr clearb"; ?>  fs13" href="javascript:void(0)" onclick="loadPopupData('popupBoxWp','popup_box',shippingData)">Shipping Charges.</a>
<?php  } ?>

