<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$projId = isset($projId)?$projId:0;
$setpriceformatForm = array(
	'name'=>'setpriceformatForm',
	'id'=>'setpriceformatForm'
);
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
$projSellType = isset($projSellType)?$projSellType:1;

if($projSellType == 1){
	$checkedSetPrice = 'checked';
	$checkedSetAuction = '';
}else{
	$checkedSetPrice = '';
	$checkedSetAuction = 'checked';
}

echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'savePriceformat'.DIRECTORY_SEPARATOR),$setpriceformatForm); 
	echo form_input($projIdInput); 
    ?>
	<div class="c_1 fixed_price ">
		<h3 class="red fs21 fnt_mouse  bb_aeaeae"><?php echo $this->lang->line('PFHcat'.$projCategory);?></h3>
		<div class="sap_40"></div>
		<ul class=" display_table defaultP clearb">
			<li class=" fixed ">
				<label>
				<input type="radio" value="1" name="projSellType" <?php echo $checkedSetPrice; ?> />
				<?php echo $this->lang->line('fixedPrice');?></label>
			</li>
			<li class="clearb fl fs17 pt15 pb15 ml36"><?php echo $this->lang->line('OR');?></li>
			<li class="auction">
				<label>
				<input type="radio" value="2" name="projSellType" <?php echo $checkedSetAuction; ?> />
				<?php echo $this->lang->line('auction');?></label>
			</li>
		</ul>
	</div>
	<div class="fr btn_wrap display_block font_weight">
		<!--<button class=" bg_ededed bdr_b1b1b1 mr5"><?php echo $this->lang->line('cancel');?></button>-->
		<a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'setupsales'.DIRECTORY_SEPARATOR.$projId) ;?>">
			<button type="button" class=" back  bdr_b1b1b1 mr5" ><?php echo $this->lang->line('back');?></button>
		</a>
		<button type="submit" class="b_F1592A next_click32 bdr_F1592A"><?php echo $this->lang->line('next');?></button>
	</div>
	<?php 
echo form_close();
?>
