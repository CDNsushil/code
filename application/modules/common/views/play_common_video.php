<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient bg_313131_imp">
	<div id="loader_div_hidee" class="show_loader_div"><img src="<?php echo  base_url().'images/'; ?>loading_wbg.gif"></div>
	<div id='videoFile' class="pt10 pl10 pr10 pb5 bg_313131_imp">
	<?php if($isExternal=="f"){ ?>
		<!------------This section show internal video-------------->
		<iframe src="<?php echo base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityID.'/'.$elementID.'/'.$projectID; ?>" width="400" height="250"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>  
	<?php } else {
		
		//check embed type is iframe	
		if($embedType == 'iframe')	
		{	
		if($isValidUrl=="yes"){
		?>
		<!------------This section show valid url external video-------------->
		<iframe src="<?php echo $src; ?>" width="400" height="250" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>  
	<?php } else { ?>
		<!------------This section show in valid url video-------------->
		<iframe src="<?php echo base_url().'en/player/videoError'; ?>" width="400" height="250" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>  
		
	<?php } }else { 
	  
	 //play embed code 	
	 echo html_entity_decode($src); ?>
	
	<?php } } ?>
	</div>
</div>
	
<script>
 

	 setTimeout(function() {
		// Do something after 2 seconds
		
      	$(".show_loader_div").hide();
		}, 3000);
	
</script>