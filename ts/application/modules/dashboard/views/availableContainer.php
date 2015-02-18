<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=isset($sectionId)?$sectionId:0;
$formNameId=str_replace(':','_',$sectionId);
$section=(isset($section)?$section:$this->lang->line('section'.$formNameId));
$seprator_14=isset($sectionImage)?'<div class="seprator_14"></div>':'';
$sectionImage=isset($sectionImage)?$sectionImage:$this->config->item('sectionIdImage'.$formNameId);
if(isset($availableContainer) && $availableContainer  && is_array($availableContainer) && count($availableContainer) > 0 && !isset($notAllowtoDirectUse)){
	echo $seprator_14;
	?>
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
					<?php
					$formAttributes = array(
						'name'=>'selectContainerFrom'.$formNameId,
						'id'=>'selectContainerFrom'.$formNameId
					);
					echo form_open($formSubmitUrl,$formAttributes);
						?>
						<div class="fl width_256">
							<div class="minH108">
								<?php
								$i=0;
								foreach($availableContainer as $k=>$pkg){
									
									$i++;
									$userContainerId=isset($pkg->userContainerId)?$pkg->userContainerId:0;
									$orderId=isset($pkg->orderId)?$pkg->orderId:0;
									
									if($i==1){
										$orderIdFirst=$orderId;
										$userContainerIdFirst=$userContainerId;
									}
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
									}
									
									//echo $pkg->orderId;
									
									?>
									<div class="row_<?php echo $userContainerId ?>">
										<div class="price_trans_wp">
											<div class="font_arial font_size14 font_weight fl pt5 width_85 clr_f1592a pl10"><?php echo $i;?>.</div>
											<div class="defaultP mt2 mr10">
												<input type="radio" name="userContainerId" <?php echo $selected;?> value="<?php echo $userContainerId;?>" onclick="getOrderId('<?php echo $pkg->orderId ?>','<?php echo $userContainerId ?>','<?php echo $formNameId;?>');">
											</div>
											<div class="font_arial font_weight fl pt5 width_80 text_alignL ml5 ml20"><?php echo $sizeString;?></div>
										</div>
										<div class="clear"></div>
										<div class="seprator_10"></div>
									</div>
									<?php
								}
								
								$projectTypeInput = array(
									'name'	=> 'selectProjectType'.$formNameId,
									'id'	=> 'selectProjectType'.$formNameId,
									'type'	=> 'hidden'
								);

								if(isset($selectProjectType) && is_array($selectProjectType) && count($selectProjectType) > 0){
									$projectTypeInput['value']=1;
									$projectTypeSelect=$this->load->view('projectTypeSelect',array('selectProjectType'=>$selectProjectType,'section'=>$section,'sectionId'=>$sectionId,'sectionImage'=>$sectionImage),true);
									$projectTypeSelect=json_encode($projectTypeSelect);
									echo '<script> var projectTypeSelect'.$formNameId.'='.$projectTypeSelect.'</script>';	
								}else{
									$projectTypeInput['value']=0;
									echo '<script> var projectTypeSelect'.$formNameId.'=0</script>';
								}
								 echo form_input($projectTypeInput);
								?>
								<input type="hidden" name="sectionId" value="<?php echo $sectionId;?>">
								<div class="clear"></div>
								<div class="seprator_16"></div>                       
							</div>
						</div>
						<div class="clear"></div>
                    <?php						
						if($pkg->userContainerId>0){
							$pkgContainerId = $pkg->userContainerId;							
						} else {								
							$pkgContainerId ='';								
						}
								   
						//$function="openLightBox('popupBoxWp','popup_box','/membershipcart/refund',$('#orderId').val();)"; ?>
														
						<input type="hidden" name="orderId" id="orderId<?php echo $formNameId;?>" value="<?php echo $orderIdFirst; ?>" />					
						<input type="hidden" name="containerId" id="containerId<?php echo $formNameId;?>" value="<?php echo $userContainerIdFirst; ?>" />					
						<input type="hidden" name="sectionName" id="sectionName<?php echo $formNameId;?>" value="<?php echo $section; ?>" />					
					   <div class="tds-button fr mr5 container_box"> <a href="<?php echo base_url(lang().'/membershipcart/addspace/'.$pkgContainerId);?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" style="background-position: 0px -38px;"><span class="font_size12 font_opensansSBold width_63" style="background-position: right -38px;"><?php echo $this->lang->line('addSpace');?></span></a> </div>								
						<!--<div class="tds-button fr ml20"> <a href="javascript:void:none" class="comingSoon" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_80"><?php echo $this->lang->line('addSpace');?></span></a> </div>-->	
						<?php
						$refundClass='pt8';
						if(!isset($notAllowtoDirectUse)){ 
							$refundClass='mt-25 ml-20';
							?>
							<div class="tds-button fr ml20 "> <a onclick="isThereAnyProjectType('<?php echo $formNameId;?>',projectTypeSelect<?php echo $formNameId;?>);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold clr_f1592a width_60 gray_clr_hover"><?php echo $this->lang->line('use');?></span></a> </div>
							<?php
						}
					echo form_close(); ?>	
					<div class="fl font_opensans <?php echo $refundClass;?>"><a class="hoverOrange" href="javascript:void(0)" onClick="openRefundPopup('<?php echo $formNameId;?>');">Request a Refund</a></div>		
				</div>
				
				<div class="clear"></div>  
				<div class="seprator_8"></div>
				<div class="dashbdrstrip"></div> 
				<div class="clear"></div>
				<div class="seprator_14"></div>
				<div class="row">
					<!--
					<div class="fl font_opensans"><a href="javascript:void:none" class="comingSoon"><?php echo $this->lang->line('buyAnotherTool');?></a></div> 
					-->
					<div class="fl font_opensans org_anchor_hover"><a href="<?php echo base_url(lang().'/membershipcart/addTool/'.$pkg->tsProductId); ?>">Buy Another <?php echo $section; ?> Tool<?php //echo $this->lang->line('buyAnotherTool');?></a></div> 
					<div class="fr font_opensans org_anchor_hover"><a href="<?php echo base_url(lang().'/package/information'); ?>"><?php echo $this->lang->line('membershipInformation');?></a></div>
				</div>
				
	<?php if(($pkg->tsProductId==18) || ($pkg->tsProductId==2) ) { ?>					  
		 <div class="font_opensansSBold font_size11 mt2 Fleft pt10">
			 You can use this tool for Projects in Film & Video, Music & Audio, Photography <br> & Art, Writing & Publishing and Educational Material.
		</div>
	<?php } ?>		
				
				
				
				<div class="clear"></div>
				<div class="seprator_16"></div>
			</div>
		</div>
	</div>
	<?php
}elseif((!isset($hideNoAvailable) && @$hideNoAvailable != true) ){
	$this->load->view('dashboard/noContainerAvailable',array('sectionId'=>$sectionId));
}?>

<script>

function getOrderId(ordId,containerId,formNameId){	
	
	$('#orderId'+formNameId).val(ordId);	
	$('#containerId'+formNameId).val(containerId);	
}


function openRefundPopup(formNameId){

	var orderId = $('#orderId'+formNameId).val();	
	var containerId = $('#containerId'+formNameId).val();	
	var sectionName = $('#sectionName'+formNameId).val();
	
	if(orderId>0){	
		   openLightBoxHttps('popupBoxWp','popup_box','/membershipcart/refund',orderId,containerId,sectionName);
		 }else {
		  customAlert('This was a free container.');
	   }
	}
</script>
