<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
	<div id="show_success_msg" class="customAlert">
		<?php echo $errorMsg; ?>	
</div>	 
