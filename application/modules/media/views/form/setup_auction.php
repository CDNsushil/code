<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$lang=lang();
$auctionPriceForm = array(
	'name'=>'auctionPriceForm',
	'id'=>'auctionPriceForm'
);

$seller_currency=LoginUserDetails('seller_currency');
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);

$projId = isset($projId)?$projId:0;
$auctionId = isset($auctionData['auctionId'])?$auctionData['auctionId']:0;
$minBidPrice = isset($auctionData['minBidPrice'])? number_format($auctionData['minBidPrice'],2):00.00;
$startDate = isset($auctionData['startDate']) ? date('d F Y',strtotime($auctionData['startDate'])) : '';
$endDate = isset($auctionData['endDate']) ? date('d F Y',strtotime($auctionData['endDate'])) : '';
$days='';
if($startDate != ''){
    $datetime1 = date_create($auctionData['startDate']);
    $datetime2 = date_create($auctionData['endDate']);
    $interval = $datetime1->diff($datetime2);
    $days =$interval->format('%a');
}

$priceDetails=getDisplayPrice($minBidPrice,$seller_currency);
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
$auctionIdInput = array(
	'name'	=> 'auctionId',
	'type'	=> 'hidden',
	'id'	=> 'auctionId',
	'value'	=>$auctionId
);

$minBidPriceInput = array(
    'name'	=> 'minBidPrice',
    'value'	=> ($minBidPrice>0)?$minBidPrice:'',
    'id'	=> 'minBidPrice',
    'type'	=> 'text',
    'onkeyup'=> "getDisplayPrice(this,'".$seller_currency."','#totalCommisionEProduct','#displayPriceEProduct')",
    'class'=>'font_wN width86 NumGrtrZero required',
    "placeHolder"=>"00.00",
    "onclick"=>"placeHoderHideShow(this,'00.00','hide')",
    "onblur"=>"placeHoderHideShow(this,'00.00','show')"
);
$daysInput = array(
    'name'	=> 'days',
    'value'	=> ($days>0)?$days:'',
    'id'	=> 'days',
    'type'	=> 'text',
    'onChange'=> "endDateCalculation('#startDate', this, '#endDateDiv');",
    'class'=>'font_wN width86 number required',
    "placeHolder"=>"0",
    "onclick"=>"placeHoderHideShow(this,'0','hide')",
    "onblur"=>"placeHoderHideShow(this,'0','show')"
);
$startDateInput = array(
    'name'	=> 'startDate',
    'value'	=> $startDate,
    'id'	=> 'startDate',
    'type'	=> 'text',
    'onChange'=> "endDateCalculation(this, '#days', '#endDateDiv');",
    'class'=>'calendar_picker required',
    "placeHolder"=>date('d F Y'),
    "onclick"=>"placeHoderHideShow(this,'".date('d F Y')."','hide')",
    "onblur"=>"placeHoderHideShow(this,'".date('d F Y')."','show')",
    "readonly"=>true
);
$hasDownloadableFileOnly = (isset($hasDownloadableFileOnly) && (int)$hasDownloadableFileOnly > 0)?$hasDownloadableFileOnly:0;
$hasDownloadableFileOnlyInput = array(
	'name'	=> 'hasDownloadableFileOnly',
	'type'	=> 'hidden',
	'id'	=> 'hasDownloadableFileOnly',
	'value'	=>$hasDownloadableFileOnly
);

$nextStep='pickupshipping';
if( isset($hasDownloadableFileOnly) && ($hasDownloadableFileOnly==1) ){
    $nextStep='sellerconsumptiontax';
}
$nextSteplink = $this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.$nextStep.DIRECTORY_SEPARATOR.$projId;


echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveAuctionPrice'.DIRECTORY_SEPARATOR),$auctionPriceForm); 
    echo form_input($projIdInput);
    echo form_input($auctionIdInput);
    echo form_input($hasDownloadableFileOnlyInput);
    ?>
    <div class="wra_head auction_cnt">
        <h3 class="red fs21 "> Setup your Auction</h3>
        <div class="sap_30"></div>
        <div class="c_1">
        <h4 class="red fs18 fshel_midum   bb_aeaeae"> Minimum Bid</h4>
        <table class=" width100_per mt5 a-btnclearb rate_table ">
            <tbody>
                <tr>
                    <td class="width_100"></td>
                    <td class="width_150"> Minimum <br>
                    Bid </td>
                    <td class="widht_150"> Toadsquare’s<br>
                    Service Fee</td>
                    <td class="width_200"> Minimum Bid<br>
                    Shown on site </td>
                </tr>
                <tr>
                    <td>Set Minimum Bid </td>
                    <td class="min_bid">
                        <b class="pl5"><?php echo $currencySign;?> </b><?php echo form_input($minBidPriceInput);?>
                    </td>
                    <td id="totalCommisionEProduct"><?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?></td>
                    <td class="red" id="displayPriceEProduct"><?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="sap_40"></div>
        <div class="c_1">
        <h4 class="red fs18 fshel_midum bb_aeaeae"> Setup Auction Times</h4>
        <ul class="rate_table pt27 pb25">
        <li class="position_relative">
        <label class="width_141 pt5 fl"> Start Date </label>
        <span class=" fl pt4">
            <?php echo form_input($startDateInput);?>
            <img class="ui-datepicker-trigger ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#startDate").focus();' alt="..." title="...">
        </span> </li>
        <li>
        <label class="width_141 pt8 fl"> Period </label>
        <span class=" fl width100">
            <?php echo form_input($daysInput);?> </span>
            <span class=" pl6 pt8"> Days</span>
       
        </li>
        <li class="pt8">
        <label class="width_141 fl"> Auction Ends</label>
        <span id="endDateDiv"><?php echo $endDate;?></span>
        </li>
        </ul>
        </div>
        <div class="sap_20"></div>
        <ul class="bt_aeaeae pt20 clearb">
        <li class="icon_2">Prices displayed on the site include the Toadsquare Service Fee, which is the greater of 	EUR 0.40 (USD 0.50) or 15 percent. The Service Fee is not refundable. Prices do not include any Consumption Taxes (VAT, GST, Sales Tax etc.) or Shipping Charges. These will be added during checkout if applicable. </li>
        </ul>
        <div class="sap_10"></div>
    </div>

    <div class="fr btn_wrap display_block font_weight">
       <!-- <button type="button" class="bg_ededed bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Cancel</span></button>-->
        <a href="<?php echo $nextSteplink; ?>">
            <button type="button" class="next_click1 bdr_b1b1b1 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('skip');?></span></button>
        </a>
        <a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'inventorytype'.DIRECTORY_SEPARATOR.$projId) ;?>">
            <button type="button" class="back back_click1 bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
        </a>
        <button type="submit" class="b_F1592A next_click1 bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('next');?></span></button>
    </div>

<?php echo form_close();?>

<script type="text/javascript">
  $(document).ready(function(){
	  $("#auctionPriceForm").validate();
  });
</script>			
              
		
