<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
  <div class="width_674">
    
    <div class="popup_note"> If you consider that any material / content published on Toadsquare website is
contrary to the law, we will take down the material and inform the Toadsquare
member who put it up.  Please realise that such accusations are serious and
the other member of Toadsquare may choose to take follow-up action if they
wish. </div>
    <div class="position_relative">
    <div class="cell shadow_wp strip_absolute left_250">
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td height="59"><img src="<?php echo base_url();?>images/shadow-top.png"></td>
          </tr>
          <tr>
            <td class="shadow_mid">&nbsp;</td>
          </tr>
          <tr>
            <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom.png"></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"></div>
    </div>
    <div class="seprator_20"></div>
    <div class="row">
      <div class="pop_label_wrapper02 cell">
        <div class="num_01 Fleft"></div>
        <div class="text_with_num"><b class="pl5">&nbsp;</b>Please indicate which material / content you consider to be illegal / inappropriate</div>
      </div>
      <!--label_wrapper-->
      <div class="pop_field_wrapper02 cell">
         <div class="seprator_5"></div>     
        <div class="input_small_bg "><input type="text" value="Title" name=""></div>
        <div class="seprator_6"></div>
        <div class="input_small_bg "><input type="text" value="Posting Member’s Name" name=""></div>
      
      </div>
    </div>
    <div class="seprator_34 clear"></div>
    <div class="row">
      <div class="pop_label_wrapper02 cell">
        <div class="num_02 Fleft"></div>
        <div class="text_with_num"><b class="pl5">&nbsp;</b>Please indicate the reason for the above mentioned material to be considered as illegal / inappropriate</div>
      </div>
      <!--label_wrapper-->
      <div class="pop_field_wrapper02 cell">
      <div class="mr10 ml10 mt10">
         <div class="defaultP">
          <input type="radio" id="month3" value="3" name="month">
        </div>
        <div for="month3" class="pop_radio_label02">Infringement of third party’s legal rights, including intellectual property rights;</div>
        <div class="clear seprator_13"> </div>
        <div class="defaultP">
          <input type="radio" id="month3" value="3" name="month">
        </div>
        <div for="month3" class="pop_radio_label02">Defamatory material;</div>
          <div class="clear seprator_13"> </div>
       <div class="defaultP">
         <input type="radio" id="month3" value="3" name="month" >
        </div>
        <div for="month3" class="pop_radio_label02">Material offending public morality (including discriminative, xenophobic or racist photos);</div>
        <div class="clear seprator_13"> </div>
        <div class="defaultP">
          <input type="radio" id="month3" value="3" name="month">
        </div>
        <div for="month3" class="pop_radio_label02">Any violent or pornographic material accessible for minors;</div>
          <div class="clear seprator_13"> </div>
          <div class="defaultP">
          <input type="radio" id="month3" value="3" name="month">
        </div>
        <div for="month3" class="pop_radio_label02">Privacy concerns;</div>
        <div class="clear seprator_13"> </div>
        <div class="defaultP">
          <input type="radio" id="month3" value="3" name="month">
        </div>
        <div for="month3" class="pop_radio_label02">Others.</div>
          <div class="clear seprator_13"> </div>
        </div>
      </div>
    </div>
    <div class="clear seprator_30"></div>
    <div class="row">
      <div class="pop_label_wrapper02 cell">
        <div class="num_03 Fleft"></div>
        <div class="text_with_num"><b class="pl5">&nbsp;</b>Please provide the precise explication as to why the published content / material is to be considered as illegal/inappropriate and should thus be removed:<br><br>

Please note that if no (or not sufficient) explanation is provided the notification will not be considered and in such case Toadsqaure reserves the right not to remove the notified material</div>
      </div>
      <!--label_wrapper-->
      <div class="pop_field_wrapper02 cell defaultP">
                
        <div class="textarea_small_bg "><textarea class="textarea_small" rows="9" cols="65" name="blogTagWords" original-title="Tag Words"></textarea></div>
        <div class="clear seprator_5"></div>
        <div class="pop_field_text mr14 pl5">&gt; 50 words</div>
        <div class="seprator_30"></div>
        <div class="pop_field_text mr14 pl5">We will forward the above information provided by you to the
Toadsquare member who uploaded the material.<br><br>Please note that Toadsquare reserves the right not to remove the notified material / content if it considered that the abuse report is not sufficiently grounded.  <br><br>

We will provide the member who uploaded the notified material in question with your name and email address that you have provided to Toadsquare, so that if they choose they may contact you to resolve the issue. </div>
      </div>
    </div>
    <div class="seprator_15 clear"></div>
    <div class="row">
    <div class="cell width_361"><div class="Fright change_selection"><a class="orange_color" href="javascript:loadPopupData('popupBoxWp','popup_box',abusiveReportSelect);">Change Selection</a> </div></div>
    <div class="cell Fright">
      <div class="tds-button Fright mr18"> <a href="javascript:void(0)" onclick="javascript:$(this).parent().trigger('close');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Submit</span></a> </div>
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
