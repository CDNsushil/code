<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
if($isValidUrl == 'no') echo '<div style="width:'.$width.'; height:'.$height.'">
	<div class="width_100_per height_100_per display_table">
		<div class="valignMid display_table_cell">
			<img src="'.getImage($this->config->item('defaultNoMediaImg')).'" class="ma" />
		</div>
	</div>
</div>
'; 
else {
$width = str_replace('px','',$width);	
$height = str_replace('px','',$height);
	 ?>
<iframe src="<?php echo $src; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
<?php } ?>
