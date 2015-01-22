<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?><!------join popup message div start------>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<div class="bg_white">
	<div class="width535px" id="showSuccessMsg">
		<div class="joinpopup_msg_box"> 
			<div class="Fright mr13"><img alt="logo" src="<?echo base_url()?>images/join-popup_logo.png"></div> <div class="clear"> </div></div>
			<div class="join_heading pt20 pl15 pr15 f13"> 
			<div class="f26 font_opensansLight">
				<?php echo $this->lang->line('message_after_registration_completed_1_first'); ?>    
			</div> 
			<div class="mt16 f13 font_opensansSBold">
				<?php echo $this->lang->line('message_after_registration_completed_1_second'); ?>    
			</div>
			<div class="mt20 mb25 f13 font_opensansSBold">
				<?php echo $this->lang->line('message_after_registration_completed_1_third'); ?>    
			</div>
			
			<div class="bdr_Borange mr8"></div>
			<div class="seprator_20"></div>
			<div class="tds-button Fright mr3"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" onclick="$(this).parent().trigger('close');"><span class="font_opensans"><?php echo $this->lang->line('cancel')?></span></a> </div>
			<div class="clear"></div>
		 </div>
		
		<div class="position_relative">
			<div class="font_opensans clr_666 font_size13">
				<div class=" seprator_15 clear"></div>
			</div>
		</div> 
	</div>
</div>
