<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$adPath = 'images/ad_images/468X60';
$fecthFormPath = ROOTPATH.$adPath;

$imgreturned = getImagesFromDir($fecthFormPath);
$imgparts = pathinfo($imgreturned);
	$configAraay468X60 = $this->config->item('468X60');
	if(isset($configAraay468X60[$imgparts['filename']]) && $configAraay468X60[$imgparts['filename']]!=''){
		$gototurl = "'".$configAraay468X60[$imgparts['filename']]."'";
		$onclickClass='ptr';
		$onclickgo='class="ptr" onclick="gotourl('.$gototurl.',0);"';
	}
	else{
		$onclickgo='';
		$onclickClass='';
	}
if(isset($imgreturned) && $imgreturned!=''){ 
?>
<div class="cell ad_box width468px">
<div class="AI_table">
	<div class="AI_cell">
		<img src="<?php echo base_url().$adPath.'/'.$imgreturned ;?>" class="max_w468_h60 <?php echo $onclickClass;?>" <?php echo $onclickgo;?> />
	</div>
</div>
</div>
<?php } ?>

