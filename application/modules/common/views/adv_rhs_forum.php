<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$adPath = 'images/ad_images/250X250';
$fecthFormPath = ROOTPATH.$adPath;

$imgreturned = getImagesFromDir($fecthFormPath);

if(isset($imgreturned) && $imgreturned!=''){ 
?>
<div class="AI_table">
	<div class="AI_cell">
		<img src="<?php echo base_url().$adPath.'/'.$imgreturned ;?>"  />
	</div>
</div>
<?php } ?>
