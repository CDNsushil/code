<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div id="show_comment" class="bc_grey minH66 width228px p10" >
	<p><?php echo $errorMsg; ?></p>
	<?php 
	if(!$isError){ ?>
		<p> 
			<div class="tds-button Fright ml10">  <button  onclick="$(this).parent().trigger('close');"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('cancel'); ?></span></button> </div>
			<div class="tds-button Fright ml10">  <button  onclick="voteInsert('<?php echo $userId; ?>','<?php echo $competitionId; ?>','<?php echo $competitionEntryId; ?>');"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('vote_button'); ?></span></button> </div>
		</p>
	<?php }	?>
</div>


<script type="text/javascript">
	function voteInsert(val1,val2,val3) {
	
		fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/competitionvoteinsert',fromData, function(data) {
					if(data){
						$('#show_comment').html(data);
					} 	
				});
	}
</script>	
