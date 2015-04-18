<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$savePricingForm = array(
	'name'=>'savePricingForm',
	'id'=>'savePricingForm'
);
$projId = isset($projId)?$projId:0;
$sellPriceType = isset($sellPriceType)?$sellPriceType:1;
$collectionChecked = $collectionNpieceChecked = $pieceChecked = '';

$hasDownloadableFileOnly = (isset($hasDownloadableFileOnly) && (int)$hasDownloadableFileOnly > 0)?$hasDownloadableFileOnly:0;
$hasDownloadableFileOnlyInput = array(
	'name'	=> 'hasDownloadableFileOnly',
	'type'	=> 'hidden',
	'id'	=> 'hasDownloadableFileOnly',
	'value'	=>$hasDownloadableFileOnly
);

if($sellPriceType == 1){
	$collectionChecked = 'checked';
}
elseif($sellPriceType == 2){
	$collectionNpieceChecked = 'checked';
}
else{
	$pieceChecked = 'checked';
}
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);

echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'savePricing'.DIRECTORY_SEPARATOR),$savePricingForm);
    echo form_input($projIdInput);
    echo form_input($hasDownloadableFileOnlyInput); ?>
	<div class="c_1">
		<h3 class="red fs21 "><?php echo $this->lang->line('MW_SPHcat'.$projCategory);?></h3>
		<div class="sap_40"></div>
		<ul class=" display_table clearb rate_wrap">
			<li class="defaultP clearb indi_btn">
				<label>
					<input type="radio" value="1" name="sellPriceType" <?php echo $collectionChecked; ?> />
					<?php echo $this->lang->line('MW_SPP0cat'.$projCategory);?>
				</label>
			</li>
			<li class="clearb fl fs18 fshel_regu mt20 mb10 ml75"><?php echo $this->lang->line('OR');?></li>
			<li class="defaultP clearb prnit_without">
				<label>
				<input type="radio" value="3" name="sellPriceType" <?php echo $pieceChecked; ?> />
				<?php echo $this->lang->line('MW_SPPEcat'.$projCategory);?>
				</label>
			</li>
			
            <?php if($hasDownloadableFileOnly==1){?>
                <li class="clearb fl fs18 fshel_regu mt20 mb10 ml75"><?php echo $this->lang->line('OR');?></li>
                <li class="defaultP clearb print_btn ">
                    <label>
                        <input type="radio" value="2" name="sellPriceType" <?php echo $collectionNpieceChecked; ?> />
                        <span class="fl lineH20"><?php echo $this->lang->line('MW_SPFBcat'.$projCategory);?></span>
                    </label>
                </li>
                <?php 
            }?>
            
		</ul>
	</div>
	<div class="fr btn_wrap display_block font_weight">
		<!--<button class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('cancel');?></span></button>-->
		<a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'inventorytype'.DIRECTORY_SEPARATOR.$projId) ;?>">
			<button type="button" class="back back_click4 bdr_b1b1b1 mr5" role="button" aria-disabled="false"><?php echo $this->lang->line('back');?></button>
		</a>
		<button type="submit" class="b_F1592A bdr_F1592A" role="button" aria-disabled="false"><?php echo $this->lang->line('next');?></button>
	</div>
<?php 
echo form_close();?>

			
              
		
