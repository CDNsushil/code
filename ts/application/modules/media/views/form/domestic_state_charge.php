<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$domesticShippingForm = array(
	'name' => 'domesticShippingStateForm',
	'id'   => 'domesticShippingStateForm'
);
    // set domestic country
	$domesticCountry = (isset($domesticCountry) && ($domesticCountry >0 )) ?$domesticCountry : 0;
    // set default currensy sign as euro
    $domesticCurrency = '€';
    // set state listing of selected country
	$stateList = getStatesList($domesticCountry); 
	if(isset($states) && is_object($states) && count($states) >0 ) {
		$stateArray = $states ;
		$selStates = (array) $stateArray;
		$IsCheckedAll = (array_key_exists('checked_all', $selStates)) ? 'checked' : '' ;
    } else { 
        $selStates = '' ; 
    }
// set form url
$formUrl = formBaseUrl();

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

$domesticIsAllRateSame = array(
    'name' => 'isAllRateSame',
    'id'   => 'isAllRateSame',
    'type' => 'hidden',
    'value'=>  (!empty($isAllRateSame))?$isAllRateSame:0,
);

$domesticCountry = array(
    'name' => 'domesticShippingcountry',
    'id'   => 'domesticShippingcountry',
    'type' => 'hidden',
    'value'=>  (!empty($domesticCountry))?$domesticCountry:0,
);

$deliveryInformation = array(
    'name' => 'deliveryInformation',
    'id'   => 'deliveryInformation',
    'type' => 'hidden',
    'value'=>  (!empty($deliveryInformation))?$deliveryInformation:0,
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
$projDomesticPrice = array(
    'name'    => 'price',
    'id'      => 'price',
    'class'   => 'required ml10',
    'type'    => 'text',
    'value'   => (!empty($price))?$price:'0.00',
    'onclick' => "placeHoderHideShow(this,'0.00','hide')",
    'onblur'  => "placeHoderHideShow(this,'0.00','show')",
    'placeholder' => "0.00"
);

if(!empty($isSameAsGlobal)) {
    $globalChecked = 'checked';
}

$stateFormDn = '';
$statePriceFormDn = 'dn';
if(!empty($isAllRateSame) && $isAllRateSame == 't' ) {
    $stateFormDn = 'dn';
    $statePriceFormDn = '';
}
?>
    <div class="c_1">
    <?php echo form_open($formUrl.'/savedomesticshipping/'.$projectId.'/'.$elementId,$domesticShippingForm); ?>
        <div class="<?php echo $stateFormDn;?>" id="domesticStateList">
            <h3 class="red fs21 fnt_mouse bb_aeaeae ">
                Which of the states / provinces / regions will you ship to and
                how much you will charge?*
            </h3>
            <div class="sap_40"></div>
            <div class="width100_per radius2">
               <div class="height_40 defaultP">
                    <label class="pt5 all_click">
                        <input <?php echo $IsCheckedAll ?>  value="1" id="checkStates" name="checked_all" onclick="checkAll(this, '.checkboxStates')"  type="checkbox" />
                    <span class="pl35">  All </span> </label>
                </div>
                <div class="clear"></div>
                <div id="slider4" class="slider domestic height137"> 
                    <a class="buttons prev" >left</a>
                    <div class="viewport">		
                        <ul class="fs13 width100_per overview slect_coustom slect_menu defaultP">
                            <?php 
                            if(isset($stateList) && is_array($stateList) && count($stateList) >0) {
                                foreach ($stateList as $key=>$list)  {
                                    foreach($selStates as $i=>$item) {
                                        if($key==$i){
                                            $checked = 'checked';
                                            $value = $item;
                                            break;
                                        } else{
                                            $checked = '';
                                            $value = '0.00';
                                        }
                                    }?>
                                    <li>
                                        <label> 
                                            <input <?php echo $checked;?>  type="checkbox" name="check" value="<?php echo $key ?>" id="CheckboxGroup1_0" class=" check_<?php echo $key ?> checkboxStates" />
                                            <span><?php echo $list ?></span> 
                                        </label>
                                        <?php echo $domesticCurrency;?>
                                        <input type="text" onblur="placeHoderHideShow(this,'0.00','show')" onclick="placeHoderHideShow(this,'0.00','hide')" value="<?php echo $value ?>" placeholder="0.00" class="state_price font_wN  width_65 val_<?php echo $key ?>" name="state[<?php echo $key ?>]">
                                    </li>
                                <?php  
                                }  
                            } ?>
                        </ul>
                    </div>
                    <a class="buttons next" href="" ></a> 
                </div>
            </div>
        </div> 
        
        <div id="domesticSamePrice" class="<?php echo $statePriceFormDn;?>">
            <h3 class="red fs21 fnt_mouse bb_aeaeae ">
                Domestic Price Details
            </h3>
            <div class="sap_40"></div>
            <?php echo $domesticCurrency;
            echo form_input($projDomesticPrice);?>
        </div>
        
         <div class="defaultP lineH20 mt35 fl ">
            <label>
                <input type="checkbox" value="1" name="isSameAsGlobal" <?php echo $globalChecked ?>/>
                <span class="display_table"> 
                    <?php echo $this->lang->line('shippingInfoText1');?>
                    <a href="<?php echo site_url(lang().'/dashboard/globalsettings/4')?>"><?php echo $this->lang->line('shippingInfoText2');?></a>
                    <?php echo $this->lang->line('shippingInfoText3');?>
                </span>
            </label>
        </div>
        <?php 
        // set back url
        $data['backPage'] = 'domesticshipping';
        $this->load->view('common_view/shipping_buttons',$data);
        //set form hidden fields 
        echo form_input($domesticProjectId);
        echo form_input($domesticElementId);
        echo form_input($domesticEntityId);
        echo form_input($projDomesticId);
        echo form_input($domesticIsAllRateSame);
        echo form_input($domesticCountry);
        echo form_input($deliveryInformation);
    echo form_close();?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $.extend($.validator.messages, {
            required: "",
            number: ""
        });
            
        runTimeCheckBox();
        $('#slider4').tinycarousel({ axis: 'y', display: 1});
        //jquery checkbox 
        $('.defaultP input').ezMark();    
        $('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'});	
    });

    
    function checkAll(obj,checkbox) {
        if(!checkbox){
            checkbox ='.CheckBox';
        }
		$(checkbox).attr("checked", obj.checked);
		if(!$('#checkStates').is(":checked")){
            $( ".state_price" ).each(function( index ) {
                $( this ).removeClass( "required error" );
                $(this).val('0.00');
			});
		}
		runTimeCheckBox();
	}
    
    /* Domestic shipping details */
	$('#nextButton').click(function() {
        var isAllRateSame = $('#isAllRateSame').val();
        if(isAllRateSame == 'f') {
            var len = $('.checkboxStates:checked').length;
            if( len <= 0 ) {
                customAlert('Please select states for domestic shipping');
                return false;
                e.preventDefault();
            }
            checkState();
        }
      
        $("#domesticShippingStateForm").validate({
			submitHandler: function(form) {
				var fromData=$("#domesticShippingStateForm").serialize(); 				              
				$.post( '<?php echo $formUrl.'/savedomesticshipping/'.$projectId.'/'.$elementId ?>',fromData, function( data ) {
                    window.location.href = '<?php echo $formUrl ?>' + data.nextStep;
               }, "json");
			}
		});
    });

    function checkState() {
        var val ;
        var domesticPrice ;

        if($('#checkStates').is(":checked")) {
            $( ".state_price" ).each(function( index ) {
                $( this ).addClass( "required number error" );
                $('#isError').val(1);
            });
            $(':checkbox:checked').each(function(i){
                val = $(this).val();
                domesticPrice = $('.val_'+val).val();
                if(domesticPrice > 0){
                    $('.val_'+val).removeClass('required number error');
                    $('#isError').val(0);
                }  
            });
        } else {
            $( ".state_price" ).each(function( index ) {
                $( this ).removeClass( "required number error" );
                 $('#isError').val(0);
            });
            $(':checkbox:checked').each(function(i){
                val = $(this).val();
                domesticPrice = $('.val_'+val).val();
                if(domesticPrice <= 0) {
                    $('.val_'+val).addClass('required number error');
                     $('#isError').val(1);
                }
            });
        }
    } 


</script>  
