<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionGroupLimit = $this->config->item('competitionGroupLimit');
$countGroup = (isset($countGroup) && is_numeric($countGroup))?$countGroup:0;
if(isset($header) ){
	echo $header;
}
if(isset($competitionGroupForm) ){ ?>
	<div class="row">
		<div class="cell tab_left">
			<div class="tab_heading"><?php echo $this->lang->line('competitionsGroup');?></div><!--tab_heading-->
		</div>
		<div class="cell tab_right">
			<?php 
			if($competitionGroupLimit > $countGroup){ ?>
				<div class="tab_btn_wrapper">
					<div class="tds-button-top"> 
						<a   class="formTip formToggleIcon" title="Add" onclick="fillFormValueCG(0,'#competitionGroupFormDiv')">
							<span><div class="projectAddIcon"></div></span>
						</a>
					</div>
				</div>
				<?php 
			} ?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="form_wrapper toggle frm_strip_bg " >
		<div class="row"><div class="tab_shadow"></div></div>
	<?php
	echo $competitionGroupForm;
}

if(isset($competitiongroupsList) && ($competitionGroupLimit > $countGroup) ){
	echo $competitiongroupsList;
}
if(isset($competitionGroupForm) ){ 
	echo '<div class="seprator_25 clear row"></div>';
	echo '<div class="row"><div class="tab_shadow"></div></div>';
	echo '</div>';
}?>

