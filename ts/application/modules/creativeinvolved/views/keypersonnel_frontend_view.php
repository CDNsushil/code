<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
$creativeArray = array('elementId'=>$elementId,'crtStatus'=>'t','entityId'=>$entityId);
$totalCreatives = countResult('AssociativeCreatives',$creativeArray);
if($totalCreatives>0){
$keypersonnelInformation=Modules::run("creativeinvolved/associativeCreatives",$elementId,$entityId,$heading,'keypersonnel_frontend',true); 

?>
<script>
	var keypersonnelData=<?php echo json_encode($keypersonnelInformation);?>;
</script>
<?php 

if(@$keypersonnelInformation!=''){
	if(isset($noButton) && @$noButton==1) { ?>
	<a onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" href="javascript:loadPopupData('popupBoxWp','popup_box',keypersonnelData)" class="orange_color cell"><span class="gray_clr_hover"><?php echo $heading;?></span></a>
	<?php } else {?>
	<div class="tds-button01 cell"> <a onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" href="javascript:loadPopupData('popupBoxWp','popup_box',keypersonnelData)" ><span class="black_link_hover"><?php echo $heading;?></span></a></div>
	<?php 
	} 
}
}
?>
