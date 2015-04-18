<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
	body{
		 margin:0px;
		 padding:0px;
		}
	</style>
<?php 
if($media == NULL) echo '<div style="width:'.$width.'; height:'.$height.';background-color:#313131"><table width="100%" height="100%" >
<tr style=" text-align: center;vertical-align: middle;"><td>
<img src="'.getImage($this->config->item('defaultNoMediaImg')).'" /></td></tr></table></div>
'; 
else { 
echo '<script type="text/javascript" src="'. base_url('player/flowplayer/flowplayer-3.2.12.min.js').'"></script>';	
?>
<div id="videoFile" style="width:<?php echo $width; ?>; height:<?php echo $height; ?>"></div>
<?php echo $media;?>
<?php } ?>
