<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php /*echo "<pre>";print_r($shippingZones); die;*/ ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
  <div class="row width_545">
	<div class="popup_heading"> Please tell us why the media is Abusive or Inappropriate</div>
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
	  <div class="pop_field_wrapper cell">
		<div class="defaultP">
		  <input type="radio" checked id="abusiveComplain" value="3" name="abusiveComplain">
		</div>
		<div for="month3" class="pop_radio_label">In my opinion some of the materials / content published on the website are illegal / inappropriate according to law.</div>
	  </div>
	</div>
	<div class="seprator_20 clear"></div>
	<div class="row">
	  <div class="pop_label_wrapper cell">
		<div class="num_02 Fright"></div>
	  </div>
	  <!--label_wrapper-->
	  <div class="pop_field_wrapper cell">
		<div class="defaultP">
		  <input type="radio" id="abusiveForm" value="6" name="abusiveComplain">
		</div>
		<div for="month6" class="pop_radio_label">Some of the materials / content published on the website seem to be unacceptable based on my own personal opinion.</div>
	  </div>
	</div>
	<div class="seprator_15 clear"></div>
	
	<div class="row">
	  <div class="tds-button Fright mr18"> <a href="javascript:loadPopup()" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Next</span></a> </div>
	  <div class="tds-button Fright mr8"> <a href="javascript:void(0)" onclick="javascript:$(this).parent().trigger('close');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Cancel</span></a> </div>
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
	<script>
		runTimeCheckBox();
		function loadPopup(){	
			var abusiveForm = '';
			if($('#abusiveForm').attr('checked')){
				abusiveForm = abusiveReportForm;
			}else{
				abusiveForm = abusiveReportComplain;
			}
			loadPopupData('popupBoxWp','popup_box',abusiveForm);
		}
	</script>
