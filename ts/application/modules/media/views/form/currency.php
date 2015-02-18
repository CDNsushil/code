<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$projId = isset($projId)?$projId:0;
$currencyForm = array(
	'name'=>'currencyForm',
	'id'=>'currencyForm'
);
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
$seller_currency=LoginUserDetails('seller_currency');

if($seller_currency == 1){
	$checkedEuros = '';
	$checkedDollars = 'checked';
}else{
	$checkedEuros = 'checked';
	$checkedDollars = '';
}



echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveCurrency'.DIRECTORY_SEPARATOR.$projId),$currencyForm); 
	echo form_input($projIdInput); 
    ?>
	<div class="c_1 ">
		<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 whitespace_now"><?php echo $this->lang->line('whatSellerCurrency');?></h3>
		<div class="sap_40"></div>
		<ul class=" display_table clearb rate_wrap">
			<li class="defaultP ">
			<label class=" pr80">
			<input type="radio" value="0" name="seller_currency" <?php echo $checkedEuros; ?> />
			<?php echo $this->lang->line('sellerEuros');?></label>
			<label>
			<input type="radio" value="1" name="seller_currency" <?php echo $checkedDollars; ?> />
			<?php echo $this->lang->line('sellerUSDollars');?></label>
			</li>
		</ul>

		<ul class="org_list">
			<li class=" icon_1"><?php echo $this->lang->line('currencyMsgsale');?></li>
			<li class="icon_2"><?php echo $this->lang->line('currencySettingStored');?></b></li>
		</ul>
	</div>
	<div class="fr btn_wrap display_block font_weight">
		<!--<button class=" bg_ededed bdr_b1b1b1 mr5"><?php echo $this->lang->line('cancel');?></button>
		<a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'setupshowcase'.DIRECTORY_SEPARATOR.$projId) ;?>">
			<button type="button" class=" back  bdr_b1b1b1 mr5 back_click32" ><?php echo $this->lang->line('back');?></button>
		</a>-->
		<button type="submit" class="b_F1592A next_click32 bdr_F1592A"><?php echo $this->lang->line('next');?></button>
	</div>
	<?php 
echo form_close();
?>
