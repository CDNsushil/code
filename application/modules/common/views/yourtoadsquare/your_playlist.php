<li data-submenu-id="sub_t4" class="Playlist_center common_i toad_menu_open">
   <a href="javascript:void(0)">Your Playlist</a> 
   
   <?php if($myPlaylistCount > 0){ ?>
       <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t4">
          <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Your Playlist</span></li>
          <li>
            <span class=" content_menu width100_per  ">
            <span class="sap_20"></span> 
            <span class=" pt6 pb10 width100_per" >You have <span class="green fs20"> <?php echo $myPlaylistCount; ?> </span> music files in your Playlist </span>
            <span class="sap_20"></span>
            <a href="<?php echo base_url_lang('showcase/mypaylist?action=play'); ?>"> 
                <button type="button" class="fl play_icon gray_btn">Play </button>
            </a>
            <a href="<?php echo base_url_lang('showcase/mypaylist'); ?>">
                <button type="button" class="fl gray_btn">Edit</button>
            </a> 
            <a href="<?php echo base_url_lang('craves/myplaylist'); ?>">
                <button type="button" class="fl gray_btn">View</button>
            </a> 
             </span>
          </li>
       </ul>
   <?php }else{ ?>
        <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t4">
            <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Create an Album</span></li>
            <li> <span class="content_menu pl35  pt20 pr30"> <span class="sap_20"></span>
            <p class="fs16 lineH24 opens_light"> You can add free tracks from any Music Album or Audio Collection on Toadsquare.  Other members can play back your selection from your Showcase Homepage.</p>
            </span> 
            </li>
        </ul>
     <?php } ?>
</li>
           
