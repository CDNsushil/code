<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$hrefNone='javascript:void(0);';
$isArchive = (isset($isArchive) && ($isArchive=='t'))?'t':'f';
$DC=(is_numeric($competitionId) && ($competitionId>0))?'':'disable_btn';
?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $this->lang->line('competition_entries'); ?></h1>
	</div>
	<div class="cell frm_element_wrapper pt1">
		<div class="tds-button-big Fright">
			<a href="<?php echo base_url(lang().'/competition/competitionlist/');?>"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo  $this->lang->line('competition_button'); ?></span></a> 
			<a class="disable_btn" href="<?php echo $hrefNone;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo  $this->lang->line('shortList'); ?></span></a> 
			<a class="disable_btn" href="<?php echo $hrefNone;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo  $this->lang->line('votes'); ?></span></a> 
			<?php
				if($isArchive=='t'){?>
					<a href="<?php echo base_url(lang().'/competition/competitionentrylist/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('compti_entries_br_index'); ?></span></a>
					<?php
				}else{ ?>
					<a href="<?php echo base_url(lang().'/competition/entrydeleteditems/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('deletedBRItems'); ?></span></a>
					<?php
				}
			?>
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
