<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=isset($sectionId)?$sectionId:0;
$formNameId=str_replace(':','_',$sectionId);
?>
<div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="dast_container_outer pall0">
		<div class="dash_boxgradient min_h142">
			<div class="dash_headgrad font_museoSlab font_size24 clr_888 pt7 pb8 pl20"><?php echo $this->lang->line('selectTool');?> <samp class="font_museoSlab font_size20 pl-2 ml28 clr_D45730"><?php echo $section;?></samp></div>
			<div class="seprator_15"></div>
			<div class="pl20 pr20">
				<div class="dash_Atool_leftbox width_100 pt17 pb17 position_relative fl leftInherit height125px">
					<div class="height125">
						<div class="AI_table">
							<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/'.$sectionImage);?>" alt="Media" class="bdr_white max_w81_h128 dashbox-shedow"> </div>
						</div>
					</div>
				</div>

				<div class="dash_Atool_text minH140 pl0 pb5 pr2 fl ml50">
					<div class="fl width_256">
						<div class="minH108">
							<?php
							$i=0;
							foreach($selectProjectType as $type=>$url){
								$i++;
								$selected=($i==1)?'checked':'';
								?>
								<div class="row">
										<div class="price_trans_wp">
										<div class="defaultP mt2 mr10 ml10">
											<input <?php echo $selected;?> type="radio" name="projectType" value="<?php echo $url;?>" name="month">
										</div>
										<div class="font_arial font_weight font_size12 fl pt5 width_196 text_alignL ml5 clr_818181"><?php echo $this->lang->line($type);?></div>
									</div>
									<div class="clear"></div>
									<div class="seprator_10"></div>
								</div>							
								<?php
							}
							?>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="tds-button fr ml20"> <a onclick="changeFormAction('<?php echo $formNameId;?>')" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class="font_size12 font_opensansSBold clr_f1592a width_60"><?php echo $this->lang->line('continue');?></span></a> </div>

				</div>
				<div class="clear"></div>  
				<div class="seprator_8"></div>
				<div class="dashbdrstrip"></div> 
				<div class="clear"></div>
				<div class="seprator_14"></div>
				<div class="row">
					<div class="fl font_opensans org_anchor_hover"><a href="<?php echo base_url(lang().'/package/buytools'); ?>"><?php echo $this->lang->line('buyAnotherTool');?></a></div> <div class="fr font_opensans org_anchor_hover"><a href="<?php echo base_url(lang().'/package/information'); ?>"><?php echo $this->lang->line('membershipInformation');?></a></div>
				</div>
				<div class="clear"></div>
				<div class="seprator_16"></div>
			</div>
		</div>
	</div>
</div>
<script>
	function changeFormAction(formNameId){
		var form_url = $('input:radio[name=projectType]:checked').val();
		$('#selectContainerFrom'+formNameId).attr("action", form_url);
		$('#selectContainerFrom'+formNameId).submit();
	}
</script>
