<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div id="show_comment" class="bc_grey mH35 width228px p10" >
		<p> 
		<?php if($isShortlist) { ?>
			<div class="tds-button fl ml10">  <button  onclick="shorlistNunshortlist('<?php echo $userId; ?>','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>','<?php echo $shortlistId ?>');"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('competitionUnshortlist'); ?></span></button> </div>
		<?php } else { ?>
			<div class="tds-button fl ml10">  <button  onclick="shorlistNunshortlist('<?php echo $userId; ?>','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>','<?php echo $shortlistId ?>');"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('competitionShortlist'); ?></span></button> </div>
		<?php } ?>
		</p>
</div>
<script type="text/javascript">
	function shorlistNunshortlist(val1,val2,val3,val4) {
	
		fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3,
					shortlistId:val4
				}
				$.post(baseUrl+language+'/competition/shorlistNunshortlistInsert',fromData, function(data) {
					if(data){
						$('#show_comment').html(data);
					} 	
				});
	}
</script>	
