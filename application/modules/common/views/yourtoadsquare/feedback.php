<li class="blue_bottom pb15 toad_menu_open" data-submenu-id="sub_t26 " >
   <a href="javascript:void(0)">Feedback</a>
   <ul class="menu_inner popover   menusecond toad_menu_open_sub"  id="sub_t26">
      <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> <span class="display_cell veti_midl">Feedback</span></li>
      <li>
        <form id="feedbackForm" name="feedbackForm" method="post" action="<?php echo base_url(lang().'/common/feedbackSave');?>">
            <input type="hidden" value="<?php echo isset($currentUrl)?$currentUrl:''; ?>" name="currentUrl">
            <input type="hidden" name="recipientsId" class="required" value="<?php echo $isLoginUser;?>">
            <span class=" content_menu width100_per">
                <span class="sap_20"></span>
                <ul class="form_nenu width_auto fl ">
                   <li>
                       <input type="text" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('Your_FeedbackPlaceH'); ?>','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('Your_FeedbackPlaceH'); ?>','hide')" value="" placeholder="<?php echo $this->lang->line('Your_FeedbackPlaceH'); ?>"  class="font_wN required" name="feedbacksubject" />
                   </li>
                   <li>
                      <textarea type="text" onblur="placeHoderHideShow(this,'Feedback*','show')" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('Your_FeedbackS'); ?>','hide')" value="" placeholder="<?php echo $this->lang->line('Your_FeedbackS'); ?>"  class="font_wN height_75 required" name="feedbackmessage" ></textarea>
                   </li>
                   <li>
                      <button class="fr gray_btn mr40" type="submit"><?php echo $this->lang->line('submit'); ?></button>
                   </li>
                </ul>
             </span>
         </form>
         
      </li>
   </ul>
</li>
