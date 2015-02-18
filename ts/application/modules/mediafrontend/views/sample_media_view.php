<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    $mediaId            =  $mediaId.'_full';
    $sampleElementUrl   =  base_url_lang('player/getPlayerIframe/'.$mediaId.'/'.$entityId.'/'.$elementId.'/'.$projectId);
?>

<div class="poup_bx ">
   <div class=" close_btn position_absolute  " onClick="$(this).parent().trigger('close')"></div>
   <div class="sap_20"></div>
   <iframe width="750" height="896" style="margin:0; padding:0; border:0px solid #CC00DD;"
    scrolling="no" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" 
    src="<?php echo $sampleElementUrl; ?>">
    </iframe>
</div>
