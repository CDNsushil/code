<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/*Seller Shipping Domestic settings */

$domesticShippingForm = array(
	'name' => 'domesticShippingForm',
	'id'   => 'domesticShippingForm'
);

$domesticProjectId = array(
	'name' => 'projectId',
	'id'   => 'projectId',
	'type' => 'hidden',
	'value'=>  (!empty($projectId))?$projectId:0,
);

$domesticElementId = array(
	'name' => 'elementId',
	'id'   => 'elementId',
	'type' => 'hidden',
	'value'=>  (!empty($elementId))?$elementId:0,
);

$domesticEntityId = array(
	'name' => 'entityId',
	'id'   => 'entityId',
	'type' => 'hidden',
	'value'=>  (!empty($entityId))?$entityId:0,
);

$projDomesticId = array(
	'name' => 'projDomesticId',
	'id'   => 'projDomesticId',
	'type' => 'hidden',
	'value'=>  (!empty($domesticId))?$domesticId:0,
);

$domesticIndustry = array(
	'name' => 'indusrty',
	'id'   => 'indusrty',
	'type' => 'hidden',
	'value'=>  (!empty($indusrty))?$indusrty:0,
);

$domesticCountry = (!empty($domesticCountry)) ? $domesticCountry : '';
$deliveryInformation = (!empty($deliveryInformation)) ? $deliveryInformation : '';
$isAllRateSameYes = '';
$isAllRateSameNo = 'checked';
if(isset($isAllRateSame) && $isAllRateSame == 't') {
    $isAllRateSameYes = 'checked';
    $isAllRateSameNo = '';
}
// set base url
$baseUrl = formBaseUrl();
?>
	
<div id="TabbedPanels7" class="TabbedPanels tab_setting"> 
    <!--========== Setup your Auction  =================-->
    <div class="TabbedPanelsContentGroup">
        <!--=======================Domestic======================--> 
        <?php echo form_open($baseUrl.'/domesticshippingstates/'.$projectId.'/'.$elementId,$domesticShippingForm); ?>
             <div class="TabbedPanelsContent">
                <div class="c_1 display_none" id="domestic_state">
                    <?php 
                    if(!empty($domesticCountry)) {
                        $this->load->view('form/domestic_state_charge');
                    } ?>
                </div>
            
                <div class="c_1" id="domestic_shipping">
                    <h3 class="red fs21 fnt_mouse  bb_aeaeae">Domestic Shipping*</h3>
                    <ul class=" mt30 billing_form domestic_country position_relative height_30">
                        <li class="select width_208">
                            <?php
                            $countries = getCountryList();
                            echo form_dropdown('domesticShippingcountry', $countries, $domesticCountry,'id="domestic_shippingcountry" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
                            ?>
                        </li>
                    </ul>
                    <div class="wra_head">
                        <h3 class="red fs21 fnt_mouse  bb_aeaeae">Is the Rate the same for all States, Provinces &amp; Regions?*</h3>
                        <ul class=" mt30 display_table clearb mb20 rate_wrap ">
                            <li class="defaultP font_weight	">
                                <label>
                                    <input  type="radio" name="isAllRateSame" value="t" id="isAllRateSameYes" <?php echo $isAllRateSameYes; ?> />
                                    Yes
                                </label>
                                <label class="pl41">
                                    <input  type="radio" name="isAllRateSame" value="f" id="isAllRateSameNo" <?php echo $isAllRateSameNo; ?> />
                                    No
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="wra_head">
                        <h3 class="red fs21 mb25 fnt_mouse  bb_aeaeae"> How will you deliver your Prints?* </h3>
                        <textarea col="" row="" class="font_wN width610 p10 red_bdr_2 height_89 radius0 required" type="text" onClick="placeHoderHideShow(this,'Delivery  Information','hide')" onBlur="placeHoderHideShow(this,'Delivery  Information','show')" placeholder="Delivery Information" name="deliveryInformation"><?php echo $deliveryInformation ?></textarea>
                    </div>
               
                    <div class="defaultP lineH20 mt35 fl">
                        <label>
                            <input type="checkbox" value="1" name="isSameAsGlobal" />
                            <span class="display_table"> 
                                <?php echo $this->lang->line('shippingInfoText1');?>
                                <a href="<?php echo site_url(lang().'/dashboard/globalsettings/4')?>"><?php echo $this->lang->line('shippingInfoText2');?></a>
                                <?php echo $this->lang->line('shippingInfoText3');?>
                            </span>
                        </label>
                    </div>
                </div>
                <?php 
                // set back url
                $data['backPage'] = 'domesticshipping';
                if(!empty($domesticId)) {
                    $data['backPage'] = 'shipping';
                    if(!empty($elementId)) {
                        $data['backPage'] = 'shippingcharge';
                    }
                }
                $this->load->view('common_view/shipping_buttons',$data);
                //set form hidden fields
                echo form_input($domesticProjectId);
                echo form_input($domesticElementId);
                echo form_input($domesticEntityId);
                echo form_input($projDomesticId);
                echo form_input($domesticIndustry);
                ?> 
              </div>    
        <?php  echo form_close();?>
    </div>
</div>
<script type="text/javascript">
    /*$(document).ready(function() {
        $("#domesticShippingForm").validate({
            submitHandler: function() {
                var fromData=$("#domesticShippingForm").serialize();
                $.post('<?php echo $baseUrl.'/domesticshippingstates/'.$projectId.'/'.$elementId;?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl;?>'+data.nextStep;
                    }
                }, "json");
            }
        });
    });*/
    
    
    /* Domestic shipping details */
    $('#domestic_shippingcountry').change(function() {
        var domesticCountry = $('#domestic_shippingcountry').val();
        var projDomesticId  = $('#projDomesticId').val();
        fromData = 'domestic_country='+domesticCountry+'&projDomesticId='+projDomesticId;
        $.post( '<?php echo $baseUrl.'/getDomesticState';?>',fromData, function( data ) {
            if(data) {
                $('#domestic_state').html(data);
            }
        });
    });
    
    /* manage domestic shippings next step */
    $('#nextStateButton').click(function() {
        var domesticCountry = $('#domestic_shippingcountry').val();
        if(domesticCountry != '') {
            $('#domestic_shipping').hide();
            $('#domestic_state').show();
            var isAllRateSame = $('input[name="isAllRateSame"]:checked').val();
            if(isAllRateSame == 't') {
                $('#domesticSamePrice').show();
                $('#domesticStateList').hide();
            }
            $('#nextButton').show();
            $('#nextStateButton').hide();
        } else {
            alert('Please select country first!');
        }
    });
    
    $('#isAllRateSameYes').click(function() {
        $('#nextButton').show();
        $('#nextStateButton').hide();
    });
    
    $('#isAllRateSameNo').click(function() {
        $('#nextButton').hide();
        $('#nextStateButton').show();
    });
    
</script>
