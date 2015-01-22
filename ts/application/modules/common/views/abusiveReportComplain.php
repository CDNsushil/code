<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php /*echo "<pre>";print_r($shippingZones); die;*/ ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
  <div class="width_674">
    
    <div class="popup_note"> Toadsquare is sorry you find material / content published on the website to
be unacceptable based on your own personal opinion, however we will not
take down such content / material for reasons of personal taste. </div>
    <div class="pop_bdr"></div>
    
    <div class="position_relative">
    <div class="cell shadow_wp strip_absolute left_154">
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
          </tr>
          <tr>
            <td class="shadow_mid_small">&nbsp;</td>
          </tr>
          <tr>
            <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"></div>
    </div>
    <div class="seprator_10"></div>
    <div class="row">
      <div class="pop_label_wrapper cell">
        <div class="num_01 Fright"></div>
      </div>
      <!--label_wrapper-->
      <div class="pop_field_wrapper01 cell defaultP">
                
        <div class="pop_field_text">If you wish, please write a message explaining why you are offended and we will send it to the Toadsquare member who uploaded the media.  They may choose to respond.</div>
        <div class="seprator_20"></div>
        <div class="textarea_small_bg "><textarea class="textarea_small" rows="2" cols="65" name="blogTagWords" original-title="Tag Words"></textarea></div>
      </div>
    </div>
    <div class="seprator_20 clear"></div>
    <div class="row">
      <div class="pop_label_wrapper cell">
        <div class="num_02 Fright"></div>
      </div>
      <!--label_wrapper-->
      <div class="pop_field_wrapper01 cell defaultP">
        <div class="pop_field_text">Or, if you consider the content to be illegal, please notify Toadsquare by changing your selection.</div>
      </div>
    </div>
    <div class="seprator_15 clear"></div>
    <div class="row">
    <div class="cell width_273"><div class="Fright change_selection"><a class="orange_color" href="javascript:loadPopupData('popupBoxWp','popup_box',abusiveReportSelect);">Change Selection</a> </div></div>
    <div class="cell Fright">
      <div class="tds-button Fright mr18"> <a href="#" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Submit</span></a> </div>
	  <div class="tds-button Fright mr8"> <a href="javascript:void(0)" onclick="javascript:$(this).parent().trigger('close');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Cancel</span></a> </div>
      <div class="clear"></div>
      </div>
       <div class="clear"></div>
    </div>
    </div>
    
    
    <div class="seprator_15 clear"></div>
    <div class="row">
      <div class="cell"></div>
      <div class="cell"></div>
    </div>
  </div>
  </div>
  <script>runTimeCheckBox();</script>
