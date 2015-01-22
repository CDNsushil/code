<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$projId = isset($projId)?$projId:0;
$inventorytypeForm = array(
	'name'=>'inventorytypeForm',
	'id'=>'inventorytypeForm'
);
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
$projSellTypeInput = array(
	'name'	=> 'projSellType',
	'type'	=> 'hidden',
	'id'	=> 'projSellType',
	'value'	=>isset($projSellType)?$projSellType:1
);

$hasDownloadableFileOnly = isset($hasDownloadableFileOnly)?$hasDownloadableFileOnly:0;

if($hasDownloadableFileOnly == 1){
	$checkedDownload = 'checked';
	$checkedDownloadPrint = '';
}else{
	$checkedDownload = '';
	$checkedDownloadPrint = 'checked';
}

echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveInventorytype'.DIRECTORY_SEPARATOR),$inventorytypeForm);
    echo form_input($projIdInput);
    echo form_input($projSellTypeInput); ?>
	<div id="TabbedPanels3" class="c_1">
		<h3 class="red fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('MW_ITHcat'.$projCategory);?></h3>
		<div class="sap_40"></div>
		<ul class=" display_table defaultP clearb rate_wrap ">
			<li class=" ">
				<label>
					<input type="radio" value="1" name="hasDownloadableFileOnly" <?php echo $checkedDownload; ?> /><?php echo $this->lang->line('MW_ITDOcat'.$projCategory);?>
				</label>
			</li>
			<li class="clearb fl fs18 fshel_regu mt17 mb18 ml75"> <?php echo $this->lang->line('OR');?> </li>
			<li class="">
				<label class="fl">
					<input type="radio" value="0" name="hasDownloadableFileOnly" <?php echo $checkedDownloadPrint; ?> />
					<span class="fl text_alighL">
						<?php echo $this->lang->line('MW_ITDScat'.$projCategory);?>
					</span>
				</label>
			</li>
		</ul>
		
	</div>
	
	<div class="fr btn_wrap display_block font_weight">
		<!--<button class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('cancel');?></span></button>-->
		<a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'setpriceformat'.DIRECTORY_SEPARATOR.$projId) ;?>">
			<button type="button" class="back  bdr_b1b1b1 mr5 back_click32 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
		</a>
		<button type="submit" class="b_F1592A next_click32 bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('next');?></span></button>
	</div><?php 
echo form_close();?>
