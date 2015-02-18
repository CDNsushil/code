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
// set base url
$baseUrl = formBaseUrl(); 
?>

<div class="TabbedPanelsContent Consumption_Tax TabbedPanelsContentVisible">
	<div class="c_1">
		<?php echo form_open($baseUrl.'/saveConsumptionTax/'.$elementId,$consumptionTaxFormAttributes); ?>
			<h3 class="red fs21 fnt_mouse bb_aeaeae ">
				<?php echo $this->lang->line('needToChargeCTax');?>
			</h3>
			<div class="sap_40"></div>
			<ul class=" display_table mb22 clearb">
				<li class="defaultP ">
					<label class="tax_no width_112">
						<?php 
						if($userProfileData->chargeConsumptionTax=='t') {
							$chargeConsumptionTaxYes='checked';
							$chargeConsumptionTaxNo='';
						} else {
							$chargeConsumptionTaxYes=''; 
							$chargeConsumptionTaxNo='checked';
						}
						?>
						<input type="radio" <?php echo $chargeConsumptionTaxNo;?> value="f" id="chargeConsumptionTax" name="chargeConsumptionTax" />
						No 
					</label>
					<label class="ml88 tax_yes">
						<input type="radio" <?php echo $chargeConsumptionTaxYes;?>  value="t" id="chargeConsumptionTax" name="chargeConsumptionTax" />
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
				
			<ul class="org_list clearb">
				<li class="icon_2"><?php echo $this->lang->line('settingStoreInGlobal');?></li>
			</ul>
            <!-- Form buttons -->
			<div class="fr btn_wrap display_block font_weight">
               <a href="<?php echo site_url(lang().'/media/'.$industry.'/'.$elementId);?>" id="cancleForm"> 
                    <button class="bg_ededed bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('cancel');?></button>
                </a>
                <a href="<?php echo $baseUrl.'/shipping/'.$elementId;?>" id="backStep">
                    <button class="back back_click1 bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('back');?></button>
                </a>
                <button id="next_consumption_steps" class="b_F1592A bdr_F1592A " type="button"><?php echo $this->lang->line('next');?></button>
			</div>
			<input id="sellerSettings" type="hidden" value="sellerSettings" name="sellerSettings">
		<?php echo form_close(); ?> 
	</div>
</div>
<script>
	/**
	 * Manage consumption second step for charge
	 */		
	$('#next_consumption_steps').click(function() {
        var chargeConsumptionTax = $('input[name=chargeConsumptionTax]:checked').val();
        if(chargeConsumptionTax == 'f') {
            $('#consumptionTaxForm').submit();
        } else {
            $('#consumption_tax_div').hide();
            $('#charge_consumption_tax_div').fadeIn('slow');
        }
		
	});
</script>
