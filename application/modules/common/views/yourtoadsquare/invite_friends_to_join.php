<li class="blue_bottom toad_menu_open" data-submenu-id="sub_t25 ">
   <a href="javascript:void(0)">Invite friends to join</a>
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t25">
      <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Invite a friend to join Toadsquare</span></li>
      <li>
         <span class="content_menu">
            <span class="sap_15"></span> <img src="<?php echo $imgPath; ?>logo_121.png" alt=""  /> <span class="sap_55"></span>
            <div class="fs20  open_sans  text_alighC clr_444"> Email freinds and collegues and<br />
               ask them to join. 
            </div>
            <span class="sap_40"></span>
                <div class=" addthis_toolbox  mb15 fs12 email_link display_block text_alignC"
                    addthis:url="<?php echo (isset($UrlToShare) && !is_array($UrlToShare))?$UrlToShare:''; ?>" 
                    addthis:title="A Link to my Work Profile (it will work for 15 days)"
                    addthis:description=""
                   >
                      <a class="addthis_button_yahoomail"><span class="yahoo_icon mail_icon " href=""> <?php echo $this->lang->line('Yahoo'); ?> </span></a>
                      <a class="addthis_button_gmail"><span class="gmail_icon mail_icon " href=""><?php echo $this->lang->line('Gmail'); ?> </span></a>
                      <a class="addthis_button_hotmail"><span class="hotmail_icon mail_icon " href=""><?php echo $this->lang->line('Hotmail'); ?></span></a>
                      <a class="addthis_button_rediff"> <span class="reddif_icon mail_icon " href=""><?php echo $this->lang->line('Rediff'); ?> </span></a>
                      <a class="addthis_button_mailto"><span class="last pl7 bdr_d1d1d1 pr10 our_icon mail_icon " href=""><?php echo $this->lang->line('Your_Client'); ?></span></a>
                   </div>
         </span>
      </li>
   </ul>
</li>
