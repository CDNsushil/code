<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$isArchive = (isset($isArchive) && ($isArchive=='t'))?'t':'f';
	$hrefNone='javascript:void(0);';
 ?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $this->lang->line('competitionsGroup'); ?></h1>
	</div>
	<div class="cell frm_element_wrapper pt1">
		
		
		<div class="tds-button-big Fright">
			<a href="<?php echo base_url(lang().'/competition/competitionlist/');?>"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo  $this->lang->line('competitionIndex'); ?></span></a> 
			<?php
				if(in_arrayr( 'competitionentry', $userNavigations, $key='section', $is_object=0 )){
					$compEntHref=base_url(lang().'/competition/competitionentrylist');
					$compOpacity='';
					$acticeTab='onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"';
				}else{
					$compEntHref='javascript:void(0);';
					$compEntOpacity='opacity_4';
					$acticeTab='';
				}?>
				<a class="<?php echo $compEntOpacity; ?>" href="<?php echo $compEntHref;?>" <?php echo $acticeTab;?>><span class="two_line"><?php echo $this->lang->line('competitionBREntries'); ?></span></a>
				<?php
			?>
			<a href="<?php echo base_url(lang().'/competition/competitiondeleteditems/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('deletedBRItems'); ?></span></a>
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
