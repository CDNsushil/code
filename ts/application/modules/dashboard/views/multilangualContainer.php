<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$userId=isLoginUser();
$add_multilangual_link = site_url(lang().'/showcase/multilingaul_showcase_form');
$showcaseAddLink = '<div class="tds-button-top modifyBtnWrapper">
					<a class="formTip fr mr8" href="'.$add_multilangual_link.'" title="'.$this->lang->line('add').'">
					<div class="projectAddIcon width_20"></div>
					</a></div>';					
?>
<div class="Members-Buy-Tools_shedow mt0 pr15 ml0">
	<div  class="dash_Atool_list_box min_h142 ml5 width_435">
		<div class="dash_Atool_leftbox heightAuto width_100 pt17 pb17 fl mt8">
			<div class=" height_112">
				<div class="AI_table">
					<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/Multilingual-Showcase_110x73.jpg');?>" alt="Multilingual" class="bdr_white max_w81_h128 dashbox-shedow"> </div>
				</div>
			</div>
		</div>
		<div class="dash_headgrad pt7 pb8 pl_130"><samp class="font_museoSlab font_size20 pl-2 ml34 clr_D45730"><?php echo $this->lang->line('multilingualShowcase');echo $showcaseAddLink;?></samp></div>
		<div class="seprator_15"></div>
		<div class="pl20 pr20">         
			<div class="dash_Atool_text pl0 pb5 pr2 fl ml148 min_height64">
				<?php
				$formAttributes = array(
					'name'=>'multilangualContainerFrom',
					'id'=>'multilangualContainerFrom'
				);
				$formSubmitUrl = base_url(lang().'/dashboard');
				echo form_open($formSubmitUrl,$formAttributes);
				?>
					<div class="fl width265px minH66">
						<?php
						if(isset($userShowcaseMultiLang) && !empty($userShowcaseMultiLang)){
							foreach($userShowcaseMultiLang as $userShowcaseMultiLang){
								$showcaseLangId = $userShowcaseMultiLang->showcaseLangId;
								$langName = getLanguage($userShowcaseMultiLang->langId);
								$edit_multilangual_link = site_url(lang().'/showcase/multilingaul_showcase_form/'.$userId.'/'.$showcaseLangId);
								$delete_multilangual_link = site_url(lang().'/showcase/deleteMultilingualShowcase/'.$showcaseLangId);
								 echo '<div class="row">
									<div class="cell font_opensansSBold font_size12 clr_555 width215px">'.$langName.'</div>
									<div class="fr ml12">
										<div class="small_btn formTip modifyBtnWrapper mr10">
											<a class="formTip fr mr8" href="'.$edit_multilangual_link.'" title="'.$this->lang->line('edit').'">
											<div class="cat_smll_edit_icon width_20"></div>
											</a>
										</div>
									</div>
								</div>
								<div class="seprator_5 row"></div>
								';
							}
						}else{?>
							        
							<div class="tds-button fr mt38 mr10"> 
								<a href="<?php echo base_url(lang().'/showcase/multilingaul_showcase_form');?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)">
									<span class="font_size12 font_opensansSBold dash_link_hover"><?php echo $this->lang->line('use');?></span>
								</a>
							</div>
					<?php }?>
					<div class="seprator_10"></div>
				</div>
				<div class="clear"></div>
				<?php
				echo form_close();?>
			</div> 
			<div class="clear"></div>
		</div>
		<div class="seprator_5"></div>
	</div>
</div>	
<div class="seprator_20"></div>
