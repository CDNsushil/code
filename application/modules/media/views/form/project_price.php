<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$projectPriceForm = array(
	'name'=>'projectPriceForm',
	'id'=>'projectPriceForm'
);
$seller_currency=LoginUserDetails('seller_currency');
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);
$projId = isset($projId)?$projId:0;

$projPrice = isset($projPrice)? number_format($projPrice,2):00.00;
$priceDetails=getDisplayPrice($projPrice,$seller_currency);

$projDownloadPrice = isset($projDownloadPrice)? number_format($projDownloadPrice,2):00.00;
$downloadPriceDetails=getDisplayPrice($projDownloadPrice,$seller_currency);

$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
$projPriceInput = array(
    'name'	=> 'projPrice',
    'value'	=> ($projPrice>0)?$projPrice:'',
    'id'	=> 'projPrice',
    'type'	=> 'text',
    'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionEProduct','#displayPriceEProduct')",
    'class'=>'font_wN width86 NumGrtrZero required',
    "placeHolder"=>"00.00",
    "onclick"=>"placeHoderHideShow(this,'00.00','hide')",
    "onblur"=>"placeHoderHideShow(this,'00.00','show')"
);
$projDownloadPriceInput = array(
    'name'	=> 'projDownloadPrice',
    'value'	=> ($projDownloadPrice>0)?$projDownloadPrice:'',
    'id'	=> 'projDownloadPrice',
    'type'	=> 'text',
    'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionEProduct','#displayPriceEProduct')",
    'class'=>'font_wN width86 NumGrtrZero required',
    "placeHolder"=>"00.00",
    "onclick"=>"placeHoderHideShow(this,'00.00','hide')",
    "onblur"=>"placeHoderHideShow(this,'00.00','show')"
);

$hasDownloadableFileOnly = (isset($hasDownloadableFileOnly) && (int)$hasDownloadableFileOnly > 0)?$hasDownloadableFileOnly:0;
$hasDownloadableFileOnlyInput = array(
	'name'	=> 'hasDownloadableFileOnly',
	'type'	=> 'hidden',
	'id'	=> 'hasDownloadableFileOnly',
	'value'	=>$hasDownloadableFileOnly
);

$sellPriceType = (isset($sellPriceType) && (int)$sellPriceType > 0)?$sellPriceType:1;
$sellPriceTypeInput = array(
	'name'	=> 'sellPriceType',
	'type'	=> 'hidden',
	'id'	=> 'sellPriceType',
	'value'	=>$sellPriceType
);

$nextStep='pickupshipping';
$totalCommision = $priceDetails['totalCommision'];
$displayPrice = $priceDetails['displayPrice'];
if($hasDownloadableFileOnly==1){
    $nextStep='sellerconsumptiontax';
    $totalCommision = $downloadPriceDetails['totalCommision'];
    $displayPrice = $downloadPriceDetails['displayPrice'];
    $projPriceInput = $projDownloadPriceInput;
}

if(($sellPriceType == 1) && ($hasDownloadableFileOnly==0) ){
    $nextStep='inventory';
}

$nextSteplink =  base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep.DIRECTORY_SEPARATOR.$projId);




echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveProjectPrice'.DIRECTORY_SEPARATOR),$projectPriceForm); 
    echo form_input($projIdInput);
    echo form_input($hasDownloadableFileOnlyInput);
    echo form_input($sellPriceTypeInput);
    
    $MW_ProjectPricingHeading  =str_replace('{{var category}}',$category,$this->lang->line('MW_ProjectPricingHeading'));
    ?>
    <div class="c_1 fixed_cnt">
        <h3 class="red fs21 "><?php echo $MW_ProjectPricingHeading;?></h3>
        <div class="sap_40"></div>
        <table class=" width100_per  clearb rate_table ">
            <tbody>
                <tr>
                    <td class="width_100"></td>
                    <td class="width_150"> Your<br>
                    Price </td>
                    <td class="widht_150"> Toadsquare’s<br>Service Fee</td>
                    <td class="width_200"> Price<br>Shown on site </td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('catType'.$projCategory);?> Price</td>
                    <td>
                        <b class="pl5"><?php echo $currencySign;?> </b> <?php echo form_input($projPriceInput); ?>
                    </td>
                    <td id="totalCommisionEProduct"><?php echo $currencySign.' '.$totalCommision;?></td>
                    <td class="red" id="displayPriceEProduct"><?php echo $currencySign.' '.$displayPrice;?></td>
                </tr>
            </tbody>
        </table>
        <?php
        $bt_aeaeae= 'bt_aeaeae';
        if(($sellPriceType == 2) && ($hasDownloadableFileOnly==1) ){
            echo '<h3 class="red fs21 ">'.$this->lang->line('MW_ItemPriceHcat'.$projCategory).'</h3>';
             $bt_aeaeae= '';
        }
        ?>
        <div class="sap_20"></div>
        <ul class="<?php echo $bt_aeaeae;?> pt30">
        <li class="icon_2">Prices displayed on the site include the Toadsquare Service Fee, which is the greater of 	EUR 0.40 (USD 0.50) or 15 percent. The Service Fee is not refundable. Prices do not include any Consumption Taxes (VAT, GST, Sales Tax etc.) or Shipping Charges. These will be added during checkout if applicable. </li>
        </ul>
    </div>

    <div class="fr btn_wrap display_block font_weight">
       <!-- <button type="button" class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Cancel</span></button>-->
        <!--<a href="<?php //echo $nextSteplink; ?>">
            <button type="button" class="next_click1 bdr_b1b1b1 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php //echo $this->lang->line('skip');?></span></button>
        </a>-->
        <a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'setuppricing'.DIRECTORY_SEPARATOR.$projId) ;?>">
            <button type="button" class="back back_click1 bdr_b1b1b1 mr5" role="button" aria-disabled="false"><?php echo $this->lang->line('back');?></button>
        </a>
        <button type="submit" class="b_F1592A bdr_F1592A" role="button" aria-disabled="false"><?php echo $this->lang->line('next');?></button>
    </div>
<?php 
echo form_close();?>
<script type="text/javascript">
  $(document).ready(function(){
	  $("#projectPriceForm").validate();
  });
</script>	

			
              
		
