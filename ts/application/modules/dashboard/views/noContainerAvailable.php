<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=isset($sectionId)?$sectionId:0;
$formNameId=str_replace(':','_',$sectionId);
$noAvailablesection=(isset($noAvailablesection)?$noAvailablesection:$this->lang->line('section'.$formNameId));
$seprator_14=isset($noAvailableImage)?'<div class="seprator_14"></div>':'';
$noAvailableImage=isset($noAvailableImage)?$noAvailableImage:$this->config->item('sectionIdImage'.$formNameId);
echo $seprator_14;

$tsProductId = getTSProductId($sectionId);
$tsProductId = isset($tsProductId) ? $tsProductId : 0;
$sectionName =isset($noAvailablesection) ? $noAvailablesection : ''; ?>
<!--<div class="dast_container_outer pall0">-->
<div>
	<div class="dash_boxgradient min_h142">
		<div class="dash_headgrad font_museoSlab font_size24 clr_888 pt7 pb8 pl20"><?php echo $this->lang->line('selectTool');?> <samp class="font_museoSlab font_size20 pl-2 ml28 clr_D45730"><?php echo $noAvailablesection;?></samp></div>
		<div class="seprator_15"></div>
		<div class="pl20 pr5">
			<div class="dash_Atool_leftbox width_100 pt15 pb15 position_relative fl leftInherit height125px">
				<div class="height125">
					<div class="AI_table">
						<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/'.$noAvailableImage);?>" alt="Media" class="bdr_white max_w81_h128 dashbox-shedow"> </div>
					</div>
				</div>
			</div>
			<div class=" pb5 fl ml14">
				<div class="bg_444 pt10 popup_inner width_300 fr mr5">
						<div class="text_alignC width_102 margin_auto"> <img src="<?php echo base_url('images/noavailabeltool.png');?>" alt="noavailable"> </div>
						<div class="seprator_10"></div>
						<div class="text_alignC width_300 buypopupheading font_size22 clr_white text_shedow font_museoSlab"> <?php echo $this->lang->line('noAvailableTools');?> </div>
						<div class="seprator_15"></div>
					</div>
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>  
			<div class="seprator_8"></div>
			<div class="dashbdrstrip"></div> 
			<div class="clear"></div>
			<div class="seprator_14"></div>
			<div class="row">
			<!--	
				<div class="fl font_opensans"><a href="javascript:void:none" class="comingSoon" ><?php echo $this->lang->line('buyAnotherTool');?></a></div> <div class="fr font_opensans"><a href="<?php //echo base_url(lang().'/package/information'); ?>"><?php echo $this->lang->line('membershipInformation');?></a></div>
				-->
			<div class="fl font_opensans org_anchor_hover">
				<div class="tds-button fl">
					<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php echo base_url(lang().'/membershipcart/addTool/'.$tsProductId); ?>">
						<span class="font_size14 font_opensansSBold clr_666" style="background-position: right -38px;">Buy Another <?php echo $sectionName; ?> Tool</span>
					</a>
				</div>
			</div>
			
				
			<!--<div class="fr font_opensans org_anchor_hover"> 
				<div class="tds-button fl mr-5">
					<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php //echo base_url(lang().'/package/information'); ?>">
						<span class="font_size13 font_opensansSBold clr_666" style="background-position: right -38px;"><?php //echo $this->lang->line('membershipInformation');?></span>
					</a>
				</div>
			</div>-->
				
			</div>
			<div class="clear"></div>
			<div class="seprator_16"></div>
		</div>
	</div>
</div>
