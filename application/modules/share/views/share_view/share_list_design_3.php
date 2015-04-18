<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//check preview mode is active
$previewClass   = (previewModeActive())?"previewmode":"";
?>

<div class=""
    addthis:url="<?php echo $urlToShare ?>" 
    addthis:title="A Link to my Work Profile (it will work for 15 days)"
    addthis:description=""
> 
   <a class="<?php echo $previewClass; ?> small_share3 fb_small addthis_button_facebook" > </a>
     <a class="<?php echo $previewClass; ?> small_share3 twiit_icon addthis_button_twitter" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 linkden_small addthis_button_linkedin" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 google_small addthis_button_google_plusone_share" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 timbler_small addthis_button_tumblr" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 stumble_icon addthis_button_stumbleupon" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 pin_small addthis_button_pinterest" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 digg_small addthis_button_digg" > </a>
   <a class="<?php echo $previewClass; ?> small_share3 reditt_small pr3 addthis_button_reddit" > </a>
   <a class=" share_icon3 bdr_l_666  small_share ml5 mr0 pr5" > </a>
</div>


 
