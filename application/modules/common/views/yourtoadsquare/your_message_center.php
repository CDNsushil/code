<li data-submenu-id="sub_t2" class="msg_center common_i toad_menu_open">
   <a href="javascript:void(0)">Your Message Center</a> 
   
    <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t2">
          <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Your Message Center</span></li>
          <li>
             <span class="content_menu ">
                 
                <?php if(($readMsgCount == 0) && ($notificationCount == 0) && ($contactCount == 0)){ ?>
                   <div class="fs14">Your Toadsquare communications hub gives you:</div>
                <?php } ?>
                
                <?php 
                //tmail condition
                if($readMsgCount > 0){ ?>
                    <h3 class=" fs18 red opens_light">Tmail</h3>
                    <span class="sap_10"></span> <span class="fl pt12" ><?php echo $unreadMsgCount; ?> new Tmails</span>
                    <a href="<?php echo base_url_lang('tmail/inbox'); ?>">
                        <button type="button" class="fr gray_btn">Read</button>
                    </a>
                    <span class="sap_10"></span>
                    <span class="fl pt12" >Tmail members craving you</span>
                    <a href="<?php echo base_url_lang('tmail/compose'); ?>">
                        <button type="button" class="fr gray_btn">Compose</button>
                    </a>
                    <span class="sap_30 bd_t "></span>
                <?php  }else{ ?>
                   <span class="sap_15 bd_t"></span>
                    <h3 class=" fs18 red opens_light">Tmail</h3>
                    <span class="sap_10"></span>
                    <p> Our internal email system is called Tmail. </p>
                    <span class="sap_10"></span>
                    <p>Members can send you a Tmail if you have a Showcase Homepage up with a Contact Me button on it, or if you crave something on their Showcase.
                    <p> <span class="sap_15 bd_t"></span>
                <?php } ?>
                
                <?php 
                //Notifications condition
                if($notificationCount > 0){ ?>
                    <h3 class=" fs18 red opens_light">Notifications </h3>
                    <span class="sap_10"></span> <span class="fl pt4" ><span class="green fs20"><?php echo $notificationCount; ?></span> new notifications</span>
                    <a href="<?php echo base_url_lang('notifications/index'); ?>">
                        <button type="button" class="fr gray_btn">Read</button>
                    </a>
                    <span class="sap_30 bd_t "></span>
                <?php  }else{ ?>
                    <h3 class=" fs18 red opens_light ">Notifications </h3>
                    <span class="sap_10 "></span>
                    <p>Receive notifications from us here as well as finding out about updates to the site that you may enjoy.</p>
                    <span class="sap_15 bd_t"></span>
                <?php } ?>
            
                <?php 
                     if($contactCount > 0){ ?>
                    <h3 class=" fs18 red opens_light">Contacts</h3>
                    <span class="sap_10"></span> <span class="fl pt4" ><span class="green fs20"><?php echo $contactCount; ?></span> contacts</span>
                    <a href="<?php echo base_url_lang('messagecenter/contacts'); ?>">
                        <button type="button" class="fr gray_btn">View</button>
                    </a>
                    <a href="<?php echo base_url_lang('messagecenter/contacts?action=add'); ?>">
                        <button type="button" class="fr gray_btn">Add</button>
                    </a>
                    <?php  }else{ ?>
                    <h3 class=" fs18 red opens_light ">Contacts</h3>
                    <span class="sap_10"></span>
                    <span class="fl " >Keep a record of your contacts.</span>
                    <a href="<?php echo base_url_lang('messagecenter/contacts?action=add'); ?>">
                        <button class="fr gray_btn mt-12">Add</button>
                    </a>
                <?php } ?>
             </span>
          </li>
    </ul>
 </li>
