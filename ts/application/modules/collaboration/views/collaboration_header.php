<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$isArchive = (isset($isArchive) && ($isArchive=='t'))?'t':'f';
	$hrefNone='javascript:void(0);';
 ?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $this->lang->line('collaboration'); ?></h1>
	</div>
	<div class="cell frm_element_wrapper pt1">
		<div class="tds-button-big Fright">
			<a href="javascript:getUserContainers('<?php echo $sectionId;?>','/collaboration/description')"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('collaborationBRNew'); ?></span></a> 
			<?php
				if($isArchive=='t'){?>
					<a href="<?php echo base_url(lang().'/collaboration/index/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('collaborationBRIndex'); ?></span></a>
					<?php
				}else{ ?>
					<a href="<?php echo base_url(lang().'/collaboration/deleteditems/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('deletedBRItems'); ?></span></a>
					<?php
				}
			?>
			
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
