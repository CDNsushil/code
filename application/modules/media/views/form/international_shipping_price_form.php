<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$formName = 'internationalShippingPricingForm';
	
	//echo  "countriesId==".$countriesId;
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);
	
	if(isset($interationalShipping)){
		//extract($interationalShipping);
	}
	
	$spIdInput = array(
		'name'	=> 'spId',
		'id'	=> 'spId',
		'value'	=> (isset($spId) && is_numeric($spId) && ($spId>0))?$spId:0,
		'type'	=> 'hidden'
	);
	
	$amountInput = array(
		'name'	=> 'amount',
		'id'	=> 'amount',
		'class'	=> 'font_wN  width_65 ml10 text_alighC required number',
		'placeholder'	=> '0.00',
		'onblur'	=> "placeHoderHideShow(this,'0.00','show')",
		'onclick'	=> "placeHoderHideShow(this,'0.00','hide')",
		'value'	=> (isset($amount) && is_numeric($amount) && ($amount>0))?$amount:0.00,
		'min'	=> 0.1,
		'title'	=> $this->lang->line('moreThenZero')
	);
	
	$zoneTitleInput = array(
		'name'	=> 'zoneTitle',
		'type'	=> 'hidden',
		'id'	=> 'zoneTitle',
		'class'	=> 'font_wN  width_65 ml10 text_alighC required',
		'placeholder'	=> 'Zone Title',
		'onblur'	=> "placeHoderHideShow(this,'Zone Title','show')",
		'onclick'	=> "placeHoderHideShow(this,'Zone Title','hide')",
		'value'	=> isset($zoneTitle)?$zoneTitle:'',
	);
	
	$shortDesc_minVal=0;
	$shortDesc_maxVal=15;
	$wordLabel=$shortDesc_minVal.' - '.$shortDesc_maxVal.$this->lang->line('words');
	$shortDesc=(isset($shortDesc) && $shortDesc != null && $shortDesc != 'null')?$shortDesc:'';
	$shortDesc=trim($shortDesc);
	
	$description = array(
		'name'	=> 'shortDesc',
		'id'	=> 'shortDesc',
		'class'	=> 'ffont_wN width610 p10 red_bdr_2 height_62 radius0 required',
		'placeholder'	=> 'Delivery Information*',
		'onblur'	=> "placeHoderHideShow(this,'Delivery Information*','show')",
		'onclick'	=> "placeHoderHideShow(this,'Delivery Information*','hide')",
		'value'	=> $shortDesc,
	);
	
	$zonTtitle = (isset($zoneTitle))?$zoneTitle:'';
	// set same as globa check
    $checkGlobal = '';
    if($this->session->userdata('isGlobalCheck')) {
        $checkGlobal = 'checked';
    }
    // set base url
    $baseUrl = formBaseUrl();?>
    <div class="c_1">
            <?php
            echo form_open(base_url(lang().'/shipping/saveGlobalShippingPrice'),$formAttributes);
                echo form_input($spIdInput); 
                echo form_input($zoneTitleInput); ?>
                <div class="wra_head">
                <h3 class="red fs21 fnt_mouse  bb_aeaeae">Shipping Charge for <?php echo $zonTtitle;?>*</h3>
                <div class="sap_40"></div>
                <ul class="display_table clearb mb20">
                <li>
                <label> <span>Shipping Charge</span> </label>
                    <?php echo currencySign()."&nbsp;".form_input($amountInput);?>
                </li>
                </ul>
                <h3 class="red fs21 fnt_mouse  bb_aeaeae mb20">Delivery Information for <?php echo $zonTtitle;?>*</h3>
                    <?php echo form_textarea($description); ?>
                </div>
            
                <div class="defaultP lineH20 mt35 fl">
                    <label>
                        <div class="ez-checkbox"><input <?php echo $checkGlobal;?> type="checkbox" value="1" name="isSameAsGlobal" /></div>
                        <span class="display_table"> 
                            <?php echo $this->lang->line('shippingInfoText1');?>
                            <a href="<?php echo site_url(lang().'/dashboard/globalsettings/4')?>"><?php echo $this->lang->line('shippingInfoText2');?></a>
                            <?php echo $this->lang->line('shippingInfoText3');?>
                        </span>
                    </label>
                </div>
            <?php
            // set back url page name
            $data['backPage'] = 'addshippingzone';
            $data['spId'] = $spId;
            $this->load->view('common_view/shipping_buttons',$data);    
      
      echo form_close();?>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#<?php echo $formName;?>").validate({
            submitHandler: function() {
                var fromData=$("#<?php echo $formName;?>").serialize();
                loader();
                $.post('<?php echo $baseUrl.'/saveshippingzoneprice/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                        $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('saveShippingZonePrice');?></div>');
                        timeout = setTimeout(hideDiv, 5000);
                    }
                }, "json");
            }
        });
    });
</script>

