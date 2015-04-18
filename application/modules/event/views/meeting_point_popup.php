<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
	<div class="popup_close_btn" id="close-popup" onclick="$(this).parent().trigger('close');"></div>
	<div id="popupImagesContainer" class="" >
      <div class="popup_gredient ">
        <div class="width_545">
          <div class="row">
            <div class="ml18 pt25 mr18 sessionT_heading">
              <div class="cell clr_444">Meeting Point</div>
              <div class="cell mt_minus18 ml_minus_5"><img src="<?php echo base_url();?>images/headingaerow.png"> </div>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="seprator_10"></div>
          <div class="position_relative">
            <div class="cell shadow_wp strip_absolute_1">
              <!-- <img src="images/strip_blog.png"  border="0"/>-->
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
            <div class="seprator_20"></div>
            <div class="row">
              <div class="aerowimgbg ml18 cell"> </div>
              <div class=" cell pt10 width_356 pl26">
                <div class="seprator_29"></div>
                <p class="text_alignC font_size24 orange_color lineH27 font_opensansSBold"> Meeting Point</p>
                <div class="seprator_5"> </div>
                <p class="text_alignC font_size24 font_opensansLight "> is now active</p>
              </div>
              <div class="clear"></div>
            </div>
            <div class="seprator_26"></div>
            <div class="row">
              <div class="tds-button Fright mr5"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" onclick="$(this).parent().trigger('close');" ><span>Close</span></a> </div>
              <div class="tds-button Fright mr10"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class="width_225">More about Meeting Point</span></a> </div>
              <div class="clear"></div>
            </div>
            <div class="seprator_5 clear"></div>
          </div>
        </div>
      </div>
</div>
