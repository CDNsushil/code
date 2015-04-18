<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'donateForm',
'id'=>'donateForm'
);
$seller_currency=(isset($seller_currency) && ($seller_currency>0) )?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);
?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="row p15 width_400">
		<div class="popup_heading_small">Donate</div>
		<div class="seprator_10"></div>
		<?php 
		$DonateInfoMsg=$this->lang->line('DonateInfoMsg');
		$DonateInfoMsg=str_replace('{currencySign}',$currencySign,$DonateInfoMsg);
		echo $DonateInfoMsg;
		?>
		<div class="seprator_5"></div>
		<?php echo form_open(base_url_secure(lang().'/cart/donate'),$formAttributes); ?>
			<div class="row">
				<div class="cell pt3 pr10 font_opensansSBold">Amount</div>
				<div class="cell pt5"><?php echo $currencySign;?>&nbsp;</div>
				<div class="cell">
						<input type="text" name="price" class=" input_small_bg width_53 required priceOverOne" value="">
						<input type="hidden" name ='entityId' value="<?php echo $entityId; ?>" />
						<input type="hidden" name ='elementId' value="<?php echo $elementId; ?>" /> 
						<input type="hidden" name ='projId' value="<?php echo $projId; ?>" />  
						<input type="hidden" name ='sectionId' value="<?php echo $sectionId; ?>" />
						<input type="hidden" value="<?php echo $seller_currency; ?>" name="currency" />
						<input type="hidden" value="4" name="purchaseType" />
						<input type="hidden" value="<?php echo $ownerId; ?>" name="ownerId" />
					
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="seprator_10"></div>
			<div class="Fright  "><a class="tds-button_new" onclick="$('#donateForm').submit();" onmouseup="mouseup_tds_button_new(this)" onmousedown="mousedown_tds_button_new(this)" href="#">Donate</a></div>
			<div class="clear"></div>
		<?php echo form_close(); ?> 
		<div class="mt10 font_size11 lH14"><?php //echo $this->lang->line('donateEducateMsg');?>
		
		<span class="fl"> *</span>  <span class="pl10 pb7"> This is not a charitable donation. It is a donation in appreciation of the enjoyment you have received from the work, so it is treated as a sale.</span>
		<span class="fl"> *</span>  <span class="pl10 pb7"> A Toadsquare Service Fee of the greater of EUR 0.40 (USD 0.50) or 15 percent, and Consumption Tax (VAT, GST, Sales Tax etc.), if applicable, will be deducted from the amount the member receives. This Service Fee is not refundable.</span>
		<div class="inline"><span class="fl"> *</span>  <span class="pl10 pb7"> You need a PayPal account to make donations.</span></div>
        <span class="fl"> *</span>  <span class="pl10"> After your donation, we will email you a Sales Record. You can also see it from your Purchases page in your Cart.</span>
				
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#donateForm").validate();
});
</script>
