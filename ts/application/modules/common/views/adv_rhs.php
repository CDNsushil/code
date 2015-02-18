<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$adPath = 'images/ad_images/160X600';
$fecthFormPath = ROOTPATH.$adPath;

$imgreturned = getImagesFromDir($fecthFormPath);
//To fetch the href deifned for required images from config and then adding url accordingly
	$imgparts = pathinfo($imgreturned);
	$configAraay160X600 = $this->config->item('160X600');
	if(isset($configAraay160X600[$imgparts['filename']]) && $configAraay160X600[$imgparts['filename']]!=''){
		$gototurl = "'".$configAraay160X600[$imgparts['filename']]."'";
		$onclickgo='class="ptr" onclick="gotourl('.$gototurl.',0);"';
	}
	else
		$onclickgo='';
	
if(isset($imgreturned) && $imgreturned!=''){ 
?>

<div class="AI_table">
	<div class="AI_cell">
		<img src="<?php echo base_url().$adPath.'/'.$imgreturned ;?>"  <?php echo $onclickgo;?> />
	</div>
</div>
<?php } ?>
