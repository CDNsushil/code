<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div id="loader_div_hidee" class="show_loader_div"><img src="<?php echo  base_url().'images/'; ?>loading_wbg.gif"></div>
<div class="popup_gredient bg_313131_imp">
	<div id='videoFile' class="pt10 pl10 pr10 pb5 bg_313131_imp">
	
		<iframe src="<?php echo base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityID.'/'.$elementID.'/'.$projectID; ?>" width="652" height="500"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>  
	
	</div>
</div>

<script>
 

	 setTimeout(function() {
		// Do something after 2 seconds
		
      	$(".show_loader_div").hide();
		}, 3000);
	
</script>
