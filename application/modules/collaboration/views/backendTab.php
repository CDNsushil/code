<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$hrefNone='javascript:void(0);';
$DC=(is_numeric($collaborationId) && ($collaborationId>0))?'':'disable_btn'; 
$bg_non=(isset($heading) && !empty($heading)) ? '' : 'bg-non';

if(isset($currentMathod) && $currentMathod != 'prMaterial'){?>
	<div class="row">
			<div class="cell frm_heading <?php echo $bg_non;?>">
				<h1>
				<?php 
					echo $heading;
				?>
				</h1>
			</div>
	<?php
}
?>
		<div class="cell frm_element_wrapper pt1">
				<?php 
				if($currentMathod != 'index'){
					if($userId==$ownerId){
						?>
						<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/index/');?>"><span class="two_line"><?php echo $this->lang->line('collaborationBRIndex');?></span></a></div>
						<?php
					}else{
						?>
						<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/assignedCollaboration/'.$collaborationId);?>"><span class="two_line"><?php echo $this->lang->line('collaborationBRIndex');?></span></a></div>
						<?php
					}
				} 
				if($currentMathod != 'todos'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($collaborationId) && $collaborationId > 0) echo base_url(lang().'/collaboration/todos/'.$collaborationId); else echo $hrefNone;?>"><span class="two_line"><?php echo $this->lang->line('manage_Project');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'prMaterial'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($collaborationId) && $collaborationId > 0) echo base_url(lang().'/collaboration/prMaterial/'.$collaborationId); else echo $hrefNone;?>"><span><?php echo $this->lang->line('prMaterialTab');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'members'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($collaborationId) && $collaborationId > 0) echo base_url(lang().'/collaboration/members/'.$collaborationId); else echo $hrefNone;?>"><span class=""><?php echo $this->lang->line('members');?></span></a></div>
					<?php 
				}
				if($currentMathod != 'uploadMedia'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($collaborationId) && $collaborationId > 0) echo base_url(lang().'/collaboration/uploadMedia/'.$collaborationId); else echo $hrefNone;?>"><span class="two_line"><?php echo $this->lang->line('uploadMediaTab');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'description' && ($userId==$ownerId)){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/description');if(isset($collaborationId) && $collaborationId > 0) echo '/'.$collaborationId.'/';?>"><span><?php echo $this->lang->line('description');?></span></a></div>
					<?php 
				}
				?>
				<div class="row line1 mr3"></div>
		</div>
<?php if(isset($currentMathod) && $currentMathod != 'prMaterial'){?>
	</div>
	<?php
}?>
