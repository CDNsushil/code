<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//check preview mode is active
$previewClass   = (previewModeActive())?"previewmode":"";

?>

<span class="fl"
addthis:url="<?php echo $urlToShare ?>" 
addthis:title="A Link to my Work Profile (it will work for 15 days)"
addthis:description=""
>
    <a class=" share_icon small_share2 pl10 bdr_right_666 mr5"> </a>
    <a class="<?php echo $previewClass; ?> small_share2 fb_small addthis_button_facebook " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 twiit_icon addthis_button_twitter " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 linkden_small addthis_button_linkedin "> </a>
    <a class="<?php echo $previewClass; ?> small_share2 google_small addthis_button_google_plusone_share "> </a>
    <a class="<?php echo $previewClass; ?> small_share2 timbler_small addthis_button_tumblr " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 stumble_icon addthis_button_stumbleupon " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 pin_small addthis_button_pinterest  " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 digg_small addthis_button_digg " > </a>
    <a class="<?php echo $previewClass; ?> small_share2 reditt_small addthis_button_reddit " > </a>
</span>
