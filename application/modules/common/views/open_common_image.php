<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient bg_313131_imp">
	<div id="loader_div_hidee" class="show_loader_div pt10 pl70"><img src="<?php echo  base_url().'images/'; ?>loading_wbg.gif"></div>
	<div id='videoFile' class="pt10 pl10 pr10 pb5 bg_313131_imp ">
	
	<img src="<?php echo $imageName?>" class="maxw750_maxh528">
	
		<!------------This section show internal image-------------->
	</div>
</div>
	
<script>
 

	 setTimeout(function() {
		// Do something after 2 seconds
		
      	$(".show_loader_div").hide();
		}, 1000);
	
</script>
