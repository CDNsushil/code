<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$adPath = 'images/ad_images/728X90';
$fecthFormPath = ROOTPATH.$adPath;

$imgreturned = getImagesFromDir($fecthFormPath);
$imgparts = pathinfo($imgreturned);
	$configAraay728X90 = $this->config->item('728X90');
	if(isset($configAraay728X90[$imgparts['filename']]) && $configAraay728X90[$imgparts['filename']]!=''){
		$gototurl = "'".$configAraay728X90[$imgparts['filename']]."'";
		$onclickClass='ptr';
		$onclickgo='class="ptr" onclick="gotourl('.$gototurl.',0);"';
	}
	else{
		$onclickgo='';
		$onclickClass='';
	}
if(isset($imgreturned) && $imgreturned!=''){ 
?>
<div class="width778px ml10">
	<div  class="width728px ma" >
		 <div class="ad_box mt20 mb10 width728px">
			<div class="AI_table">
				<div class="AI_cell">
					<img src="<?php echo base_url().$adPath.'/'.$imgreturned ;?>" class="max_w728_h90  <?php echo $onclickClass;?>" <?php echo $onclickgo;?>  />
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

