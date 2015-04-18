<li data-submenu-id="sub_t9" class="bg_f3f3f3 toad_menu_open">
   <a href="javascript:void(0)"><span>Add</span> a Media Showcases</a>
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t9">
      <li class=" fs20  clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Promote and sell your Media.</span></li>
      <li>
         <span class="content_menu ">
            <p>Put up your Films & Videos, Music & Audio, Photos & Artworks, Writings and Educational Media to create a     fantastic online portfolio. </p>
            <span class="sap_20"></span>
            <p>Grow your fan base, get feedback on your work with<br />
               reviews, craves and ratings, and earn some cash by selling your media.
            </p>
         </span>
         <div class="your_toad_subhead red fs18"> What type of Media do you want to showcase?</div>
         <form action="<?php echo base_url(lang().'/media/setmediaaddtype');?>" method="post" id="mediaAddForm">
             <span class="content_menu pl35  pt30 pr30">
                <ul class="pl41 red_arrow_list menu_radio defaultP  listpb10">
                    <li><input type="radio" name="mediaType" class="mediaselect" id="filmvideo"  checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="musicaudio"  value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="photographyart" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="writingpublishing" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="mediaselect" id="educationmaterials" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
                </ul>
                <span class="sap_20"></span>
                <p class="text_alignC">
                   <button class=" width_208 gray_btn mediaselctedsubmit" type="button">Add a Media Showcase</button>
                </p>
             </span>
         </form>
      </li>
   </ul>
  
</li>
