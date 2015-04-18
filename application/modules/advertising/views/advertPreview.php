<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
	<?php 
	if($bannerData->storagetype=="web")
		{ 
	?>
		<img src="<?php echo base_url('openx/www/images').'/'.$bannerData->filename ?>" />
	<?php 
		}else{
		echo $showCode; 
	}
	?>
