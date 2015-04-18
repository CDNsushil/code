<?php 

//check is news completed for notication
$isGreenIcon = '';
$divDisabledClass="";
if($isUpcommingCompleted==false){
    $isGreenIcon = 'green_icon';
    $divDisabledClass="opacityP5 linkdisabled";
}
// get login user id
$loginUserId = LoginUserDetails('user_id'); 
?>


<li data-submenu-id="sub_t16" class="toad_menu_open <?php echo $isGreenIcon; ?>">
    <a href="javascript:void(0)">Your Upcoming Media Showcases
        <?php if(!empty($isGreenIcon)){ ?>
            <i class="you_todo_icon"></i>
        <?php } ?>
    </a>
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t16">
      <li class=" fs20  letter_5 clr_geern your_toad bg_f3f3f3 display_table"> <span class="display_cell veti_midl">Manage your Upcoming Media Showcases</span></li>
      <li>
         <span class="content_menu ">
             <?php   if($isUpcommingCompleted==false) { ?> 
                <div class="green you_todo_icon "> You have things to do!</div>
                <span class="sap_15"></span>
                <ul class="width100_per fs14 fl  listpb10 red_arrow_list">
                   <li><a href=""  class="no_wrap">Complete your Upcoming Collection </a></li>
                   <!--<li><a>Renew  your Upcoming  Media Showcase </a></li>
                   <li  ><a class="red fs12 text_alignL">
                      Another member has reported a problem with your Showcase
                      The item has been taken off your Showcase. See the item in question. </a>
                   </li>-->
                </ul>
                <span class="sap_30 bd_t "></span>
            <?php } ?>
            <span class="sap_10"></span> 
            <ul class="width100_per listpb10  fs14  red_arrow_list <?php //echo $divDisabledClass; ?>">
               <li><a href="<?php echo base_url(lang().'/upcomingprojects/upcomingpublicisemedia');?>"> Publicise your  Upcoming Media </a></li>
               <li><a href="<?php echo base_url(lang().'/upcomingprojects/upcomingeditmedia');?>">Edit your  Upcoming Media  </a></li>
               <li><a href="<?php echo base_url(lang().'/upcomingfrontend/upcomingprojects/'.$loginUserId);?>">  View your  Upcoming Media </a></li>
            </ul>
         </span>
         <div class="your_toad_subhead bt_none red fs18">What type of Media do you want to showcase?</div>
         
         <form action="<?php echo base_url(lang().'/upcomingprojects/setmediaaddtype');?>" method="post" id="upcomingMediaAddForm">
             <span class="content_menu <?php //echo $divDisabledClass; ?>">
                <ul class="pl41 red_arrow_list menu_radio defaultP  listpb10">
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="1"  checked="checked" value="<?php echo $this->config->item('filmNvideoSectionId');?>"/><?php echo $this->lang->line('Your_FV');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="2"  value="<?php echo $this->config->item('musicNaudioSectionId');?>"/><?php echo $this->lang->line('Your_MA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="4" value="<?php echo $this->config->item('photographyNartSectionId');?>"/><?php echo $this->lang->line('Your_PA');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="3" value="<?php echo $this->config->item('writingNpublishingSectionId');?>"/><?php echo $this->lang->line('Your_W');  ?></a></li>
                    <li><input type="radio" name="mediaType" class="upmediaselect" id="10" value="<?php echo $this->config->item('educationMaterialSectionId');?>"/><?php echo $this->lang->line('Your_EM');  ?></a></li>
                </ul>
                <span class="sap_20"></span>
                <p class="text_alighC">
                   <button type="button" class="max_wnone gray_btn upcomingmediasubmit <?php //echo (empty($divDisabledClass))?"upcomingmediasubmit":"";  ?> ">Add an Upcoming Media Showcase</button>
                </p>
             </span>
         </form>
      </li>
   </ul>
</li>
