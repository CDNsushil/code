<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
<div class="popup_gredient ">
      <div class="<?php echo $widthClass; ?>">
	<?php 
		// load popup header view	
		$this->load->view('common/common_popup_header');
	?> 
    <div class ="dna height_50" id="showButton">
			<div class="cell join_heading pb4 pt20 f20 tac width100percent lh25">
				<?php echo $message; ?><br>
			</div>												
		</div>
		<div class="row">
			<div class="tds-button Fright mr14  mt10" id="redirectButton"> <a href="<?php echo $linkUrl; ?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="orange_color gray_clr_hover  font_opensansSBold width_60"><?php echo $this->lang->line('yes_big')?></span></a>
				<div class="clear"></div>
			</div>
			<div class="tds-button Fright mr5  mt10" id="redirectButton"> <a onclick="$(this).parent().trigger('close');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="dash_link_hover  font_opensansSBold width_60"><?php echo $this->lang->line('cancel')?></span></a>
				<div class="clear"></div>
			</div>
			<div class="seprator_10"></div>
            <div class ="pl20 ml10">&nbsp;</div>
        </div>
            
        <div class=" seprator_10 clear"></div>
      </div>
    </div>

