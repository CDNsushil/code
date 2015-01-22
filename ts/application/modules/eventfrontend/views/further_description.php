<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<div class="cream_gradient width_776">
  <div class="seprator_30"></div>
  <div class="row ml52 mr52">
	  <div class="cell ml14 width_490">
		<div class="up_popup_titlebottom"><?php echo $this->lang->line('furtherNoBRDescription');?></div>
	  </div>
	  <div class="clear"></div>
  </div>
  <div class="seprator_30"></div>
  <div class="trans_bdr_box ml52 mr52">
	<div class="bg_white pt25 pl20 pr20 pb25 font_opensans">
	  <p><?php echo changeToUrl(nl2br($description));?></p>
	</div>
  </div>
  <div class="seprator_40"></div>
</div>
