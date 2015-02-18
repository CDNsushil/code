<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$urlToShare = $UrlToShare; ?>
<div id="addJS">
    <script type="text/javascript" src="<?php echo base_url()?>templates/frontend/js/addthis_widget.js"></script>
</div>
<div class="poup_bx width258 minH220 shadow">
    <div onclick="$(this).parent().trigger('close');" class="close_btn position_absolute"></div>
    <h3 class="red fs21  text_alighC mb15 mt15 big_share big_invite">Invite</h3>
   <div class="bdrb_afafaf mb18"></div>
    <p>
        Invite your friends and collegues to join Toadsquare.
    </p>
    <div class="addthis_toolbox  "

    addthis:url="<?php echo $urlToShare ?>" 
    addthis:title="A Link to my Work Profile (it will work for 15 days)"
    addthis:description="">
       <div class=" mt30 mb15 fs12 email_link display_block  text_alignc"> 
            <a class="yahoo_icon mail_icon addthis_button_yahoomail"> Yahoo </a> 
            <a class="gmail_icon mail_icon addthis_button_gmail" >Gmail </a> 
            <a class="hotmail_icon mail_icon addthis_button_hotmail" >Hotmail </a> 
            <a class="reddif_icon mail_icon addthis_button_rediff" >Rediff </a> 
            <a class="last pl7 bdr_d1d1d1 pr10 our_icon mail_icon addthis_button_mailto">Your Client </a> 
        </div>
    </div>
</div>
<div class=" display_list_1 fl  heightauto"></div>
