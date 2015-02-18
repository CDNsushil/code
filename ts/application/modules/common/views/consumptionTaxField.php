<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$isConsumptionTax=(isset($isConsumptionTax) && ($isConsumptionTax) > 0)?$isConsumptionTax:1;
$consumptionTaxPercentage=(isset($consumptionTaxPercentage) && ($consumptionTaxPercentage) > 0)?$consumptionTaxPercentage:0;
$projectSpacificTax_popup=$this->load->view('common/projectSpacificTax_popup',array('consumptionTaxPercentage'=>$consumptionTaxPercentage),true);
$projectSpacificTax_popup=json_encode($projectSpacificTax_popup);
echo '<script> var projectSpacificTax ='.$projectSpacificTax_popup.';</script>';
?>
<div class="row">
	<div class="label_wrapper cell ">
		<label><?php echo $this->lang->line('consumptionTax');?></label>
	</div>
	<div class=" cell frm_element_wrapper ">	
			<div class="row  ml20">
				<div class="cell">
					<div class="defaultP mt2"><input type="radio" value="1" <?php if($isConsumptionTax==1){echo 'checked';}?> name="isConsumptionTax" ></div>
				</div>
				<div class="cell font_opensansSBold f11 ml5 mt3 mr10"><?php echo $this->lang->line('useGlobalSettings');?></div>
				<div class="cell">
					<div class="defaultP mt2"><input type="radio" value="2" <?php if($isConsumptionTax==2){echo 'checked';}?> name="isConsumptionTax" onclick="loadPopupData('popupBoxWp','popup_box',projectSpacificTax)" ></div>
				</div>
				<div class="cell font_opensansSBold f11 ml5 mt3 mr10"><?php echo $this->lang->line('projectSpacific');?></div>
				<div class="cell">
					<div class="defaultP mt2"><input type="radio" value="0" <?php if($isConsumptionTax==0){echo 'checked';}?> name="isConsumptionTax" ></div>
				</div>
				<div class="cell font_opensansSBold f11 ml5 mt3 mr10"><?php echo $this->lang->line('notRequired');?></div>
			</div>
	</div>
	<input type="hidden" id="consumptionTaxPercentage" name="consumptionTaxPercentage" value="<?php echo $consumptionTaxPercentage;?>" >
</div>
