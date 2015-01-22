<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$isArchive = (isset($isArchive) && ($isArchive=='t'))?'t':'f';
	$hrefNone='javascript:void(0);';
 ?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $this->lang->line('competitions'); ?></h1>
	</div>
	<div class="cell frm_element_wrapper pt1">
		
		
		<div class="tds-button-big Fright">
			<a href="javascript:getUserContainers('<?php echo $sectionId;?>','/competition/description/language1')"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('competitionBRNew'); ?></span></a> 
			<?php
			
				if(in_arrayr( 'competition', $userNavigations, $key='section', $is_object=0 )){
					$compGroupHref=base_url(lang().'/competition/competitiongroups');
					$compGroupOpacity='';
				}else{
					$compGroupHref='javascript:void(0);';
					$compGroupOpacity='opacity_4';
				}
				
			
				if(in_arrayr( 'competitionentry', $userNavigations, $key='section', $is_object=0 )){
					$compEntHref=base_url(lang().'/competition/competitionentrylist');
					$compShortEntHref=base_url(lang().'/competition/shortlist');
					$compOpacity='';
				}else{
					$compShortEntHref='javascript:void(0);';
					$compEntHref='javascript:void(0);';
					$compEntOpacity='opacity_4';
				}
				
				// get competition entry shortlist count
				$userId=isloginUser();
				$whereCondition = array('userId'=>$userId);
				$shortlistCount = countResult('CompetitionShortlist', $whereCondition); ?>
				
				<a class="<?php echo $compGroupOpacity; ?>" href="<?php echo $compGroupHref;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('competitions_Group'); ?></span></a>
				<a class="<?php echo $compEntOpacity; ?>" href="<?php echo $compEntHref;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('competitionBREntries'); ?></span></a>
				
				<?php if($shortlistCount > 0){  ?>
					<a class="<?php echo $compEntOpacity; ?>" href="<?php echo $compShortEntHref;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('competitionBRShortlist'); ?></span></a>
				<?php } ?>
			<?php
				if($isArchive=='t'){?>
					<a href="<?php echo base_url(lang().'/competition/competitionlist/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('competitionBRIndex'); ?></span></a>
					<?php
				}else{ ?>
					<a href="<?php echo base_url(lang().'/competition/competitiondeleteditems/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $this->lang->line('deletedBRItems'); ?></span></a>
					<?php
				}
			?>
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
