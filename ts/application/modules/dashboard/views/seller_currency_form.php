<?php
$seller_currency = (isset($seller_currency) && ($seller_currency > 0 )) ? $seller_currency : 0; 
if($seller_currency==0){
	$is_euro_selected = "checked = 'checked' ";
	$is_usd_selected = '';
}else {
	$is_euro_selected = '';
	$is_usd_selected = 'checked';
	}
?>

<div class="TabbedPanelsContent TabbedPanelsContentVisible"> 
	<div class="c_1 main_price ">
		<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 whitespace_now"><?php echo $this->lang->line('whatSellerCurrency');?> </h3>
		<div class="sap_40"></div>
		<ul class=" display_table clearb rate_wrap">
		<li class="defaultP ">
		<label class=" pr80 Eu_btn">
		<input  type="radio" name="seller_currency" value="0" <?php echo $is_euro_selected ?> >
		<?php echo $this->lang->line('sellerEuros');?></label>
		<label class="Us_btn">
		<input  type="radio" name="seller_currency" value="1" <?php echo $is_usd_selected ?> >
		<?php echo $this->lang->line('sellerUSDollars');?> </label>
		</li>
		</ul>

		<ul class="org_list">
			<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
			<li class="icon_2"><?php echo $this->lang->line('currencyMsgchange');?></li>
		</ul>
		<div class="fr btn_wrap display_block font_weight">
		<button class="red fr p10 bdr_a0a0a0" onclick="saveSellerCurrency()" type="button"><?php echo $this->lang->line('save');?></button>
		</div>
	</div> 
</div>
<script>
 $(document).ready(function() {

      $('.defaultP input').ezMark();
    
      $('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'});

      $("SELECT").selectBox(); 
   });
</script>  

