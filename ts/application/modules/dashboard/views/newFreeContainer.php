<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=isset($sectionId)?$sectionId:0;
$formNameId=str_replace(':','_',$sectionId);
$section=(isset($section)?$section:$this->lang->line('section'.$formNameId));
$seprator_14=isset($sectionImage)?'<div class="seprator_14"></div>':'';
$sectionImage=isset($sectionImage)?$sectionImage:$this->config->item('sectionIdImage'.$formNameId);

if(isset($availableContainer) && $availableContainer  && is_array($availableContainer) && count($availableContainer) > 0 ){
	echo $seprator_14;
	?>
	<div class="">
		<div class="dash_boxgradient min_h142">
			<div class="dash_Atool_leftbox heightAuto left14 bdr_white1 mt8 width_82 bdr_bottom0">
				<div class="height_117">
					<div class="AI_table">
						<div class="AI_cell"> <img src="<?php echo base_url('images/default_thumb/'.$sectionImage);?>" alt="Media" class="bdr_white max_w58_h88 dashbox-shedow"> </div>
					</div>
				</div>
			</div>
			<div class="dash_headgrad  pt7 pb8 pl20"><samp class="font_museoSlab font_size20 pl-2 ml_138 clr_D45730"><?php echo $section;?></samp></div>
			<div class="seprator_15"></div>
			<div class="pl20 pr20">
				<div class="dash_Atool_text pl0 pb5 pr2 fl ml_138 minH50">
					<?php 
					$formAttributes = array(
						'name'=>'selectContainerFrom'.$formNameId,
						'id'=>'selectContainerFrom'.$formNameId
					);
					echo form_open($formSubmitUrl,$formAttributes);
					?>
					<div id="freecontainerSlider<?php echo $formNameId;?>" class="fl dashporeslide mt-3 mediascroll_li position_relative width_252">
						<a href="#" class="buttons prev position_absolute right0 z_index_3 disable"></a>
						<div class="viewport dashpeslider_container width222 height170">
							<ul class="overview">
					<?php
						$i=0;
						foreach($availableContainer as $k=>$pkg){
							$i++;
							$userContainerId=isset($pkg->userContainerId)?$pkg->userContainerId:0;
							$containerTitle=$pkg->title;
							$selected=($i==1)?'checked':'';
							if($pkg->containerSize < 1073741824){
								$size=bytestoMB($pkg->containerSize,'mb');
								$size=number_format($size,0);
								$sizeString=number_format($size,0).' '.$this->lang->line('mb');
							}else{
								$size=bytestoMB($pkg->containerSize,'gb');
								$size=number_format($size,0);
								$sizeString=number_format($size,0).' '.$this->lang->line('gb');
							}?>
							<li class="mH25 fl width_256">
								<div class="row">
									<div class="price_trans_wp">
										<div class="font_size12  fl pt5 width_122 pl34 font_opensans "><?php echo $this->lang->line('space');?></div>
										<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml10 clr_818181"><?php echo $sizeString;?></div>
										<?php
										if($userContainerId > 0 && (isset($pkg->elementId) && $pkg->elementId == 0)){ ?>
											<input type="hidden" name="userContainerId" <?php echo $selected;?> value="<?php echo $userContainerId;?>">
											<?php
										}elseif(isset($pkg->userDefaultTsProductId)&& $pkg->userDefaultTsProductId > 0 ){ ?>
											<input type="hidden" name="userDefaultTsProductId" <?php echo $selected;?> value="<?php echo $pkg->userDefaultTsProductId;?>">
											<?php
										}
									?>
									</div>
									<div class="clear"></div>
									<div class="seprator_10"></div>
								</div>
							</li>
							<?php
						}
						?>
						</ul>
				</div>
				<a href="#" class="buttons next position_absolute right0 bottom4"></a>
			</div>
						<input type="hidden" name="sectionId" value="<?php echo $sectionId;?>">
						<div class="clear"></div>
						<div class="seprator_16"></div>                       
						<div class="tds-button fr ml5 container_box"> <a href="<?php echo base_url(lang().'/package/buytools');?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_80"><?php echo $this->lang->line('addSpace');?></span></a> </div>
						<div class="tds-button fr ml20"> <a onclick="$('#selectContainerFrom<?php echo $formNameId;?>').submit();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold clr_f1592a width_80 gray_clr_hover"><?php if(isset($submitButton)) echo $submitButton; else echo $this->lang->line('use');?></span></a> </div>
						<?php
					echo form_close(); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="seprator_25"></div>
			<div class="clear"></div>
		</div>
	</div>
	<?php
}elseif((!isset($hideNoAvailable) && @$hideNoAvailable != true) ){
	$this->load->view('dashboard/noContainerAvailable',array('sectionId'=>$sectionId));
}?>
	
<script type="text/javascript">
	/*tab function*/
	$(document).ready(function(){
		if($('#freecontainerSlider<?php echo $formNameId;?>'))	
		$('#freecontainerSlider<?php echo $formNameId;?>').tinycarousel({ axis: 'y', display: 5});	
	});
</script>
