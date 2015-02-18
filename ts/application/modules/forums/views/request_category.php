<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	 $(document).ready(function() {
	// validate the comment form when it is submitted
	   $("#requestCategory").validate({ });
	 });  

</script>

<?php /*echo "<pre>";print_r($shippingZones); die;*/ ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	
		 <div class="seprator_14"></div>
 <?php
	echo form_open('forums/request_sub_cat/', 'class="form" id="requestCategory" name="requestCategory"'); 
	?>
  <div class="bdr_d2d2d2 Contact_form_topbox ml15 mr14">
  
  <div class=" font_opensans font_size18 clr_666 pt5 pl15 lineH_30"><?php echo $this->lang->line('RequestASubcategory'); ?></div>
  <div class="seprator_7"></div>
  <div class="position_relative overflow_h pb20">
  <div class="cell shadow_wp strip_absolute left_137">
      <!-- <img src="images/strip_blog.png"  border="0"/>-->
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td height="42"><img src="<?php echo  base_url();?>images/subcategory_vshedow_t.png"></td>
          </tr>
          <tr>
            <td class="shadow_mid_small_subcate_popup">&nbsp;</td>
          </tr>
          <tr>
            <td height="42"><img src="<?php echo  base_url();?>images/subcategory_vshedow_b.png"></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"></div>
    </div>
  
    <div class="cell">
  <!-- row01-->
    	<div class="row pt7">
            <div class="contact_label_subcate_popup_new_post cell">
              <label class="select_field labe_aerow"><?php echo $this->lang->line('From'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_405 ml-17">
              <span class="pt7"><?php echo $userFullName; ?></span>	
            </div>
          </div>
           <!-- row01-->
           <div class="clear"></div>
           <div class="seprator_6"></div>
    	<div class="row">
            <div class="contact_label_subcate_popup_new_post_request cell">
              <label class="select_field "><?php echo $this->lang->line('Category'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_405 ml-17">
				<?php echo form_input($title); ?>
            </div>
          </div>
           <!-- row02-->
    </div>
    <div class="clear"></div>
  </div>
  </div>
    <div class="seprator_14"></div>
    <div class="row">
            <div class="contact_label_subcate_popup_new_post cell ml15">
              <label class="select_field labe_aerow"><?php echo $this->lang->line('Reason'); ?></label>
            </div>
            <div class="cell contact_frm_element_wrapper width_405 ml-17">
              <?php echo form_textarea($body); ?>
            </div>
          </div>      
          
          
    <div class="row wordcounter" id="word_counter">
		    <span class="tag_word_orange mt5 clr_666 font_size11 ml185 mt4 orange_clr_imp"><?php echo $this->lang->line('5_50words');?></span>
    </div>
    <div class="clear"></div>
    <div class="Req_fld cell ml185"><?php echo $this->lang->line('RequiredFields'); ?></div>
    <input type="hidden" name="parent_cat" id="parent_cat" value="<?php echo $parent_cat;?>">
	<div class="seprator_14"></div>
    <div class="Fright">
    <div class="tds-button fr mr20 mb10"><button onclick="submitform();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0">Submit</span></button></div>
      <div class="clear"></div>
    </div>
    <?php echo form_close(); ?>
     <div class="seprator_9 clear"></div>
</div>
</div>
