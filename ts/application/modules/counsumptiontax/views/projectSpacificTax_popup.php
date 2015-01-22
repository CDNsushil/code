<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="popup_close_btn" id="popup_close_btnDiv" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="width510px pt24 pl20 pb20 pr20">
		<div class="row">
			<div class="cell font_opensans font_size24  bdr_Borange height_16 width510px ">
				Project Specific Percentage
			</div>
		</div>
		<div class="row clear seprator_34"></div>
		<div class="row">
			<div class="font_museoSlab font_size18  lineH27">
				<?php echo $this->lang->line('projectSpacificMsg');?>
			</div>
		</div>
		<div class="row clear seprator_34"></div>
		<div class="row">
			<div class="cell">
				<input type="text" value="" class="width90px number required" id="CTP" name="CTP">
			</div>
			<div class="cell font_museoSlab font_size18 pl20 pt5">
				<?php echo $this->lang->line('percent');?>
			</div>
		</div>
		<div class="row clear seprator_34"></div>
		<div class="row">
			<div class="tds-button ml138 fr"> <a href="javascript:submitProjectSpacificTax();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="font_size14 font_opensansSBold width_90 clr_f1592a">Submit</span></a></div>
			<div class="tds-button ml138 fr mr5"> <a href="javascript:void(0);" onclick="$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="font_size14 font_opensansSBold width_90">Cancel</span></a></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script>
function submitProjectSpacificTax(){
	var CTP = $('#CTP').val();
	if(CTP > 0){
		$('#taxPercentage').val(CTP);
		$('#CTSform').submit();
		$('#popup_close_btnDiv').parent().trigger('close');
	}else{
		alert('Tax must be grater then 0.');
	}
}
</script>
