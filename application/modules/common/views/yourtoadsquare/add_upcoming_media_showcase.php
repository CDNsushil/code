<li data-submenu-id="sub_t16" class="bg_f3f3f3 toad_menu_open">
   <a href="javascript:void(0)"><span>Add</span> an Upcoming Media Showcase</a>
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t16">
      <li class=" fs20  letter_5 clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Create gossip about your media in development</span></li>
      <li>
         <span class="content_menu">
            <p>Use this section to give out enticing snippets of the media you are developing and build anticipation amongst your fans? It's the start of your online PR campaign. </p>
            <span class="sap_20"></span>
            <p>As your work progresses, update your Showcase, keeping your fans engaged.</p>
         </span>
         <div class="your_toad_subhead red fs18">What type of Media do you want to showcase?</div>
         <form action="<?php echo base_url(lang().'/upcomingprojects/setmediaaddtype');?>" method="post" id="upcomingMediaAddForm">
             <span class="content_menu">
                <ul class="pl41 red_arrow_list menu_radio defaultP  listpb10">
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="1"  checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="2"  value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="4" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="3" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="10" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
                </ul>
                <span class="sap_20"></span>
                <p class="text_alighC">
                   <button class="max_wnone gray_btn upcomingmediasubmit" type="button">Add an Upcoming Media Showcase</button>
                </p>
             </span>
         </form>
      </li>
   </ul>
</li>
