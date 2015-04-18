
<?php
$currency = (isset($currency) && ($currency > 0 )) ? $currency : 0; 
if($currency==0){
	$text = 'You are selling in Euros €';
}else {
	$text= 'You are selling in US Dollars $ ';
	}
?>

<div class="TabbedPanelsContent TabbedPanelsContentVisible"> 							
	<div class="c_1  us_wrap ">
		<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 selling_text "><?php echo $text ?></h3>
		<div class="sap_40"></div>
		<ul>
		<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
		<li class="icon_2"><?php echo $this->lang->line('currencyMsgchangeshrt');?></li>
		</ul>
		<div class="btn_wrap fr">
		<a href="javascript:void(0)" >  <button class="fl p10 bdr_a0a0a0 Euros" onclick="showCurrencyForm();"  type="button"><?php echo $this->lang->line('back');?></button></a>
		<a href="javascript:void(0)" >  <button class="p10 ml10 bdr_a0a0a0 b_F1592A" onclick="showConsumptionTab();"    type="button"><?php echo $this->lang->line('next');?></button></a>
		</div>
	</div>
</div>
