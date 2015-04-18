<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//check preview mode is active
$previewClass   = (previewModeActive())?"previewmode":"";

?>

<span class="fr  soc_1" 	
addthis:url="<?php echo $urlToShare ?>" 
addthis:title="A Link to my Work Profile (it will work for 15 days)"
addthis:description="">
        <a class=" share_icon small_share pr5 bdr_right_666"></a>
       
        <a class="<?php echo $previewClass; ?> small_share fb_small addthis_button_facebook" ></a>
		<a class="<?php echo $previewClass; ?> small_share linkden_small addthis_button_linkedin"></a>
        <a class="<?php echo $previewClass; ?> small_share google_small addthis_button_google_plusone_share"></a>
        <a class="<?php echo $previewClass; ?> small_share timbler_small addthis_button_tumblr"></a>
        <a class="<?php echo $previewClass; ?> small_share stumble_icon addthis_button_stumbleupon"></a>
        <a class="<?php echo $previewClass; ?> small_share twiit_icon addthis_button_twitter"></a>
</span>
