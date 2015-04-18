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
				
				if($userId==$ownerId){
					?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/description/'.$collaborationId);?>"><span class=""><?php echo $this->lang->line('settings');?></span></a></div>	
					<?php 
				}else{
					?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/uploadMedia/'.$collaborationId);?>"><span class=""><?php echo $this->lang->line('settings');?></span></a></div>	
					<?php 
				}
				
				if($currentMathod != 'communications'){?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/communications/'.$collaborationId);?>"><span class=""><?php echo $this->lang->line('communications');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'mediaExchange'){?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php  echo base_url(lang().'/collaboration/mediaExchange/'.$collaborationId);?>"><span class="two_line"><?php echo $this->lang->line('media-Exchange');?></span></a></div>	
					<?php 
				}
				if($currentMathod != 'milestones'){?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/milestones/'.$collaborationId);?>"><span class=""><?php echo $this->lang->line('milestones');?></span></a></div>
					<?php
				} 
				if($currentMathod != 'todos'){?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/todos/'.$collaborationId);?>"><span class=""><?php echo $this->lang->line('todos');?></span></a></div>	
					<?php
				} ?>
				<div class="row line1 mr3"></div>
		</div>
</div> 
<?php 
if(isset($mainHeader) && $mainHeader=='settings'){	?>
	<div class="row seprator_5"></div>
	<div class="row">
		<div class="main_project_heading">
			<div class="btn_outer_wrapper fr width_auto pl5 mr14">
				<div class="fr">
					<div class="tds-button-big Fright">
						<?php 
						if($currentMathod != 'description' && ($userId==$ownerId)){?>
							<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/description/'.$collaborationId);?>"><span><?php echo $this->lang->line('description');?></span></a>
							<?php 
						}
						if($currentMathod != 'uploadMedia'){?>
							<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/uploadMedia/'.$collaborationId); ?>"><span class="two_line"><?php echo $this->lang->line('uploadMediaTab');?></span></a>	
							<?php
						}
						if($currentMathod != 'members'){?>
							<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/members/'.$collaborationId); ?>"><span class=""><?php echo $this->lang->line('members');?></span></a>
							<?php 
						}
						if($currentMathod != 'prMaterial'){?>
							<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/collaboration/settings/prMaterial/'.$collaborationId); ?>"><span><?php echo $this->lang->line('prMaterialTab');?></span></a>	
							<?php
						} ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
<?php if(isset($currentMathod) && $currentMathod != 'prMaterial'){?>
	</div>
	<?php
}?>
	<div class="row seprator_5"></div>
	<?php 
}	?>
