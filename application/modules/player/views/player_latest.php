<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
if($media == NULL) echo '<div style="width:'.$width.'; height:'.$height.'">
	<div class="width_100_per height_100_per display_table">
		<div class="valignMid display_table_cell">
			<img src="'.getImage($this->config->item('defaultNoMediaImg')).'" class="ma" />
		</div>
	</div>
</div>
'; 
else { ?>
<div id="videoFile" style="width:<?php echo $width; ?>; height:<?php echo $height; ?>"></div>
<?php echo $media;?>
<?php } ?>
