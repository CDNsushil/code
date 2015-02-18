<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$consumptionTaxFormAttributes = array(
	'name'=>'consumptionTaxForm',
	'id'=>'consumptionTaxForm',
	'toggleDivForm'=>'consumptionTaxForm-Content-Box',
	'section'=>'#consumptionTax'
);

$identificationNumberArr = array(
	'name'	=> 'identificationNumber',
	'id'	=> 'identificationNumber',
	'value'	=> set_value('identificationNumber')?set_value('identificationNumber'):$userProfileData->identificationNumber,
	'size'	=> 30,
	'maxlength'	=> 100,
	'class' => 'width_622 border_cacaca height_24 shadownone',
);
$identityNumber = set_value('identificationNumber')?set_value('identificationNumber'):$userProfileData->identificationNumber;
?>

<div class="TabbedPanelsContent Consumption_Tax TabbedPanelsContentVisible">
	<div class="c_1">
		<?php echo form_open('dashboard/saveConsumptionTax',$consumptionTaxFormAttributes); ?>
			<h3 class="red fs21 fnt_mouse bb_aeaeae ">
				<?php echo $this->lang->line('needToChargeCTax');?>
			</h3>
			<div class="sap_40"></div>
			<ul class=" display_table mb22 clearb">
				<li class="defaultP ">
					<label class="tax_no width_112">
						<?php 
						if($userProfileData->chargeConsumptionTax=='f') {
							$chargeConsumptionTaxYes='checked';
							$chargeConsumptionTaxNo='';
							$displayNext = '';
							$displaySave = 'display_none';
						} else {
							$chargeConsumptionTaxYes=''; 
							$chargeConsumptionTaxNo='checked';
							$displayNext = 'display_none';
							$displaySave = '';
						}
						?>
						<input type="radio" <?php echo $chargeConsumptionTaxNo;?> value="f" id="chargeConsumptionTax" name="chargeConsumptionTax" onclick="$('#consumptionTaxinfo').hide()"   />
						No 
					</label>
					<label class="ml88 tax_yes">
						<input type="radio" <?php echo $chargeConsumptionTaxYes;?>  value="t" id="chargeConsumptionTax" name="chargeConsumptionTax" onclick="$('#consumptionTaxinfo').show();" />
						Yes
					</label>
				</li>
			</ul>
			<h3 class="red fs21 mt52 bb_aeaeae">
				<?php echo $this->lang->line('taxInfo');?>
			</h3>
			<div class="sap_40"></div>
			<ul class="billing_form">
                <li class="bdr_non mb0"><?php echo $this->lang->line('enterTax');?></li>
				<li>
					<input type="text" name="identificationNumber" id="identificationNumber" class="font_wN" placeholder=" Tax / Business Registration Number: e.g. EU VAT Number " value="<?php echo $identityNumber;?>" onclick="placeHoderHideShow(this,' Tax / Business Registration Number: e.g. EU VAT Number ','hide')" onblur="placeHoderHideShow(this,' Tax / Business Registration Number: e.g. EU VAT Number ','show')">
				</li>
			</ul>
					
			<ul class="org_list mb30">
				<li class="icon_1 red"><?php echo $this->lang->line('allSaleUpdate');?></li>
			</ul>
			<div class="fr btn_wrap display_block font_weight">
				<button class="red fr p10 bdr_a0a0a0 taxb_not <?php echo $displaySave;?>" type="submit"><?php echo $this->lang->line('save');?></button>
					<a href="javascript://void(0);" id="next_consumption_step">  
				<button class="fr p10 bdr_a0a0a0 b_F1592A taxb_yes mr0 <?php echo $displayNext;?> " type="button">Next</button></a>
			</div>
			<input id="sellerSettings" type="hidden" value="sellerSettings" name="sellerSettings">
		<?php echo form_close(); ?> 
	</div>
</div>
<script>
	/**
	 * Manage consumption second step for charge
	 */		
	$('#next_consumption_step').click(function() {
		$('#consumption_tax_div').hide();
		$('#charge_consumption_tax_div').fadeIn('slow');
	});
</script>
