<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="addJS">
    <script type="text/javascript" src="<?php echo base_url()?>templates/frontend/js/addthis_widget.js"></script>
</div>

<div class="poup_bx  shadow">
   <div class="close_btn position_absolute ptr " onclick="$(this).parent().trigger('close');"></div>
   <h3 class="red fs21  text_alighC mb15 mt15 big_share big_shareIcon">Share</h3>
   <div class="bdrb_afafaf mb18"></div>
   <p class="text_alighC ">Share this on your social media sites.</p>
    <span class="mt40 mb15 fr email_link display_block  text_alignC" 
        addthis:url="<?php echo $urlToShare ?>" 
        addthis:title="A Link to my Work Profile (it will work for 15 days)"
        addthis:description=""
    >
        <a class="facebook_icon common_graphic addthis_button_facebook" ></a> 
        <a class="twetter_icon common_graphic addthis_button_twitter" ></a>
        <a class="linkdein_icon common_graphic addthis_button_linkedin" ></a> 
        <a class="reddit_icon common_graphic addthis_button_reddit" ></a> 
        <a class="digg_icon common_graphic addthis_button_digg" ></a>
        <a class="Stumble_icon common_graphic addthis_button_stumbleupon" ></a>
        <a class="box_icon common_graphic  addthis_button_scoopit" ></a> 
        <a class="filcr_icon common_graphic" ></a> 
        <a class="pin-interest_icon common_graphic addthis_button_pinterest" ></a>
        <a class="google_icon common_graphic addthis_button_google_plusone_share" ></a>
    </span> 
</div>
       
