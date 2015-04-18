<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$priceShippingCharge = array(
    'name'  =>  'priceShippingCharge',
    'id'    =>  'priceShippingCharge',
);

$vatPercentValue    =  $this->config->item('media_vat_percent');
// set vat price values for download or shipped file
$vatPriceValue      =  "0.00";
$totalPriceValue    =  "0.00";
// set vat price values for PPV
$vatPPVPriceValue   =  "0.00";
$totalPPVPriceValue =  "0.00";
// set Collection Title 
//$priceValue = (!empty($elementDetails->price))?number_format($elementDetails->price,2):'';

if(!empty($priceValue)) {
    $vatPriceValue    = number_format(($priceValue*$vatPercentValue)/100,2); 
    $totalPriceValue  = number_format($priceValue + $vatPriceValue,2); 
} else if(isset($perViewPrice) && !empty($perViewPrice)) {
    // set vat price values for PPV
    $vatPPVPriceValue    = number_format(($perViewPrice*$vatPPVPriceValue)/100,2); 
    $totalPPVPriceValue  = number_format($perViewPrice + $vatPPVPriceValue,2); 
} 

$albumPrice       =   array(
    'name'        =>  'albumPrice',
    'id'          =>  'albumPrice',
    'class'       =>  'required  number font_wN width86 albumPriceSet',
   //'title'      =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  $priceValue,
    'placeholder' =>  "0.00",
    'maxlength'	=> 6,
    'onBlur'      =>  "placeHoderHideShow(this,'0.00','show')",
    'onClick'     =>  "placeHoderHideShow(this,'0.00','hide')"
);

$ppvPrice       =   array(
    'name'        =>  'perViewPrice',
    'id'          =>  'perViewPrice',
    'class'       =>  'required  number font_wN width86 ppvPriceSet',
    'value'       =>  (isset($perViewPrice))?$perViewPrice:'',
    'placeholder' =>  "0.00",
    'maxlength'   => 6,
    'onBlur'      =>  "placeHoderHideShow(this,'0.00','show')",
    'onClick'     =>  "placeHoderHideShow(this,'0.00','hide')"
);

$elementEntityIdField = array(
    'name'	=>  'elementEntityId'.$browseId,
    'value'	=>  $elementEntityId,
    'id'	=>  'elementEntityId'.$browseId,
    'type'	=>  'hidden'
);

$baseUrl = formBaseUrl();
?>
   
<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
    <div class="TabbedPanelsContent member width635 m_auto clearb">
        <?php   
        echo form_open($baseUrl.'/settitlendescription/'.$elementId,$priceShippingCharge); 
        echo form_input($elementEntityIdField);
        ?>
            <div class="c_1">
                <!---------  Set download or shipped price input section ------------->
                <h3 class="red fs21  bb_aeaeae"><?php echo $this->lang->line('whatPriceForFile');?></h3>
                <div class="sap_40"></div>
                <table class=" width100_per  clearb rate_table ">
                    <tr>
                        <td class="width_100"></td>
                        <td class="width_150"> Your<br />
                                    Price </td>
                        <td class="widht_150"> Toadsquare’s<br />
                                    Service Fee</td>
                        <td class="width_200"> Price<br />
                                    Shown on site </td>
                    </tr>
                    <tr>
                        <td>Album Price </td>
                        <td>
                            <b class="pl5"><?php echo  $sellerCurrency;?> </b>
                            <?php echo form_input($albumPrice); ?>
                        </td>
                        <td> 
                           <?php echo  $sellerCurrency;?>  <span class="vatPriceCal"><?php echo $vatPriceValue; ?> </span> 
                        </td>
                        <td class="red font_bold"> 
                           <?php echo  $sellerCurrency;?> <span class="totalCalculation"><?php echo $totalPriceValue; ?> </span> 
                        </td>
                    </tr>
                </table>
                <div class="sap_20"></div>
                <?php if(isset($isPPV) && !empty($isPPV)) { ?>
                    <!---------  Set pay per view price input section ------------->
                    <h3 class="red fs21  bb_aeaeae"><?php echo $this->lang->line('whatPriceForPPV');?></h3>
                    <div class="sap_40"></div>
                    <table class=" width100_per  clearb rate_table ">
                        <tr>
                            <td class="width_100"></td>
                            <td class="width_150"> Your<br />
                                        Price </td>
                            <td class="widht_150"> Toadsquare’s<br />
                                        Service Fee</td>
                            <td class="width_200"> Price<br />
                                        Shown on site </td>
                        </tr>
                        <tr>
                            <td>Pay Per View Price </td>
                            <td>
                                <b class="pl5"><?php echo  $sellerCurrency;?> </b>
                                <?php echo form_input($ppvPrice); ?>
                            </td>
                            <td> 
                                <?php echo  $sellerCurrency;?>  <span class="vatPPVPriceCal"><?php echo $vatPPVPriceValue; ?> </span> 
                            </td>
                            <td class="red font_bold"> 
                                <?php echo  $sellerCurrency;?>  <span class="totalPPVCalculation"><?php echo $totalPPVPriceValue; ?> </span> 
                            </td>
                        </tr>
                    </table>
                    <div class="sap_20"></div>
                <?php } ?>
                <ul class="bt_aeaeae pt30">
                    <li class="icon_2">Prices displayed on the site include the Toadsquare Service Fee, which is the greater of 
                        EUR 0.40 (USD 0.50) or 15 percent. The Service Fee is not refundable. Prices do not include any Consumption Taxes 
                        (VAT, GST, Sales Tax etc.) or Shipping Charges. These will be added during checkout if applicable.
                    </li>
                </ul>
           </div>
        <?php echo form_close();?>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = '/uploadtitle/'.$projectId.'/'.$elementId;
        // set skip page
       // $data['skipPage'] = '/uploadimageinfo/'.$projectId.'/'.$elementId;
        $data['isSkipstep'] = 1;
        // set next form name
        $data['formName'] = 'priceShippingCharge';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        var getVATPercent = parseInt("<?php echo $vatPercentValue; ?>");
        
        //set album price with vat calculation
        $(".albumPriceSet").blur(function(){
           var priceValue = parseInt($(this).val());
            $(this).val(priceValue.toFixed(2));
            if(!isNaN(priceValue)){ 
                var VATPriceCal = (priceValue*getVATPercent)/100
                var totalPriceCal =  priceValue + VATPriceCal;
                $('.vatPriceCal').html(VATPriceCal.toFixed(2));
                $('.totalCalculation').html(totalPriceCal.toFixed(2));
            } 
        });
        //set album price with vat calculation
        $(".ppvPriceSet").blur(function(){
           var priceValue = parseInt($(this).val());
            $(this).val(priceValue.toFixed(2));
            if(!isNaN(priceValue)){ 
                var VATPriceCal = (priceValue*getVATPercent)/100
                var totalPriceCal =  priceValue + VATPriceCal;
                $('.vatPPVPriceCal').html(VATPriceCal.toFixed(2));
                $('.totalPPVCalculation').html(totalPriceCal.toFixed(2));
            } 
        });
        
        // hide require and number message
        $.extend($.validator.messages, {
            required: "",
            number: ""
        });
        
        //validation set and save data
        $("#priceShippingCharge").validate({
            submitHandler: function() {
                var fromData=$("#priceShippingCharge").serialize();
                $.post('<?php echo $baseUrl.'/priceshippingchargepost/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                    }
                }, "json");
            }
        });
        
    });
</script>
