<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   
$lang=lang();
$formAttributes = array(
	'name'=>'consumptionChargeForm',
	'id'=>'consumptionChargeForm'
);
$ConsumptionTaxEncoded = json_encode($ConsumptionTax);
$allStateTaxName = 'VAT, GST, Sales Tax etc*';
$allStateTaxPercentage = '%';

if($userProfileData->isTaxSameForAllStats!='f') {
	 
	$isTaxSameForAllStatsYes = 'checked'; 
	$isTaxSameForAllStatsNo = ''; 
	$isSavaBtnShow = '';
	$isNextBtnShow = 'dn';
	$isTaxSameForAllStatesShow = '';
	if(isset($ConsumptionTax) && $ConsumptionTax && is_array($ConsumptionTax) && count($ConsumptionTax) > 0) {
		foreach($ConsumptionTax as $key=>$tax) {
			$allStateTaxName = $tax['taxName'];
			$allStateTaxPercentage = $tax['taxPercentage'];
			break;
		}
	} 
} else {  
	
	$isTaxSameForAllStatsYes = ''; 
	$isTaxSameForAllStatsNo = 'checked'; 
	$isSavaBtnShow = 'dn';
	$isNextBtnShow = '';
	$isTaxSameForAllStatesShow = 'dn';
}
// set base url
$baseUrl = formBaseUrl();
?>
<div class="TabbedPanelsContentGroup">
<!-- =================Consumption Tax 2==================-->
<div class="TabbedPanelsContent Consumption_Tax TabbedPanelsContentVisible"> 
    <?php echo form_open($baseUrl.'/saveConsumptionTax/'.$elementId,$formAttributes);?>                
		<div class="c_1">
			<div id="isTaxSameForAllStatesDiv"  class="<?php echo $isTaxSameForAllStatesShow;?>">
				<h3 class="red fs21 pt12 pb10  "><?php echo $this->lang->line('consumtionTaxDetail');?></h3>
				<div class="sap_40"></div>
				<ul class=" display_table mb22 fs13 clearb rate_wrap">
					<li class="mb10 ">
						<label class=" pr10 fs15 fl lineH28"><?php echo $this->lang->line('consumtionTaxType');?></label>
						<span><input type="text" name="allStateTaxName" class="font_wN width152 shadownone required" value="<?php echo $allStateTaxName;?>" onblur="placeHoderHideShow(this,'VAT, GST, Sales Tax etc*','show')" onclick="placeHoderHideShow(this,'VAT, GST, Sales Tax etc*','hide')" placeholder="VAT, GST, Sales Tax etc*">
					</span>
                    </li>
					<li class=" mb3">
						<label class=" pr10 fs15 fl lineH28"><?php echo $this->lang->line('rate');?></label>
						<span><input type="text" name="allStateTaxPercentage" class="font_wN width_50 shadownone text_alighC number required" value="<?php echo $allStateTaxPercentage;?>" onblur="placeHoderHideShow(this,'%*','show')" onclick="placeHoderHideShow(this,'%*','hide')" placeholder="%*">
					</span>
                    </li>
				</ul>
				<div class="sap15"></div>
			</div>
			<h3 class="red fs21 "><?php echo $this->lang->line('whereNeedToCharge');?></h3>
			<div class="sap_30"></div>
			<ul class="fl clearb country_tab billing_form mb30">
				<li class="defaultP fl width_325 select select_1">
					<p class=" clearb pb10 pl1 ml37">
						<?php echo $this->lang->line('country');?>
					</p>
					<label class="pl0">
						
							<input type="radio" onclick="stateWiseTaxPercentageShow();" name="territory" id="territoryCountry" value="0" <?php if($userProfileData->territory==0 || $userProfileData->territory==null || empty($userProfileData->territory)){ echo 'checked';}?>>
						<span class="fl position_relative zindex_999">
							<?php
							$territoryCountryId=$userProfileData->territoryCountryId>0?$userProfileData->territoryCountryId:$userProfileData->countryId;
							$firstCountryId=set_value('territoryCountryId')?set_value('territoryCountryId'):$territoryCountryId;
							if(is_array($countiesNotInEU) && count($countiesNotInEU) > 0){
								echo form_dropdown('territoryCountryId', $countiesNotInEU, $territoryCountryId,'id="territoryCountryId" class="main_SELECT" onchange="AJAX(\''.base_url(lang().'/dashboard/getConsumptionStatesList').'\',\'statesDiv\',this.value, ConsumptionTaxEncoded); emptyStateUl();"');
							}
							?>	
							</span>
					</label>
				</li>
				<li class="defaultP fl ml3 ">
					<p class="clearb pb10 pl1"><?php echo $this->lang->line('stateProRegion');?> </p>
					<div id="statesDiv" class="min_h_151">
						<?php 
						$data['statesList']=getStatesList($territoryCountryId);
						$data['ConsumptionTax']=$ConsumptionTax;
						$this->load->view('dashboard/consumption_states_list',$data);
						?>
					</div>
				</li>
			</ul>
			<h2 class="clearb fs28 lineH24 bb_F1592A pb10 pt30"><?php echo $this->lang->line('or')?></h4>
			<div class="sap_15"></div>
			<div class="defaultP clearb country_tab">
				<label class="lineH25">
						<input type="radio" <?php if($userProfileData->territory==1){ echo 'checked';}?> onclick="euCountiesTaxPercentage();" name="territory" id="territoryEuropean" value="1" >
					<?php echo $this->lang->line('euroeanAddedTax');?>
				</label>
				<?php 
				$isTaxSameForAllStatesDiv='';
				if($userProfileData->territory==1) {
				   $isTaxSameForAllStatesDiv='dn';
				}?>           
				<div id="isTaxInfoSameDiv" class="<?php echo $isTaxSameForAllStatesDiv;?>">
					<div class="sap_60"></div>
					<h4 class="red fs21  fnt_mouse  mb15 bb_aeaeae clearb"><?php echo $this->lang->line('isTaxSameForStates');?></h4>
					<p class="defaultP clearb">
						<label class="width_112">
							<input type="radio" <?php echo $isTaxSameForAllStatsYes;?>  value="t" name="isTaxSameForAllStats" id ="isTaxSameForAllStatsYes" onclick=" $('#isTaxSameForAllStatesDiv').show();" class="ez-hide">
							<?php echo $this->lang->line('yes');?>
						</label>
						<label>
							<input type="radio" <?php echo $isTaxSameForAllStatsNo;?>  value="f" name="isTaxSameForAllStats" id ="isTaxSameForAllStatsNo" onclick=" $('#isTaxSameForAllStatesDiv').hide();" class="ez-hide">
							<?php echo $this->lang->line('no');?>
						</label>
					</p>
				</div>
			</div>
				<ul class="org_list">
					<li class="icon_1 red"><?php echo $this->lang->line('allSaleUpdate');?></li>
				</ul>
                <!-- Form buttons -->       
                <div class="fr btn_wrap display_block font_weight">
                    <a href="<?php echo $baseUrl;?>" id="cancleForm"> 
                        <button class="bg_ededed bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('cancel');?></button>
                    </a>
                    <a href="javascript://void(0);" id="backToStep1">
                        <button class="back back_click1 bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('back');?></button>
                    </a>
                    <button id="next_consumption_charge_step" class="b_F1592A bdr_F1592A " type="button"><?php echo $this->lang->line('next');?></button>
				</div>
			</div>
            <input id="consumptionCharge" type="hidden" value="consumptionCharge" name="consumptionCharge">
            <input id="euCountriesHidden" type="hidden" value="<?php echo $euCountriesHidden?>" name="euCountriesHidden">
		<?php  echo form_close(); ?>             
	</div>
</div>
<script>
	$(document).ready(function() {
	   /**
		* Manage consumption tax form submission
		*/	
		$("#consumptionChargeForm").validate({
			submitHandler: function() {
				var fromData=$("#consumptionChargeForm").serialize();
				var stateList = [];
				$(".checkboxStates:checked").each(function() {
					stateList.push(this.value);
				});
				if(stateList.length > 0) {
				
                    $.post('<?php echo $baseUrl.'/saveConsumptionTax/'.$elementId ?>',fromData, function(data) {
                        window.location.href = '<?php echo $baseUrl ?>' + data.nextStep;
                    }, "json");
				} else {
					alert('Please select State, Provence, Region first!');
					return false;
				}
			}
		});
	}); 
    
	var ConsumptionTaxEncoded = <?php echo $ConsumptionTaxEncoded;?>
  
	function emptyStateUl() {
		$('#stateWiseTaxUl').html('');
		var htmlString='<li id="noStateHasSelected" class="height_30"><label class="pl20 mt4 cell font_opensansSBold pb6"><?php echo $this->lang->line('noStateHasSelected');?></label><div class="clear"></div></li>';
		$('#stateWiseTaxUl').append(htmlString);
	}
	
	function euCountiesTaxPercentage() {
        
        $('#isTaxInfoSameDiv').hide();
        $('#isTaxSameForAllStatsYes').click();
        $('#allStatesNext').hide(); 
        $('#allStatesSave').show(); 
        $('#isTaxSameForAllStatesDiv').show();
        var euCountriesHidden = $('#euCountriesHidden').val();
        $('#euCountriesHidden').val('1');
    }
    
	function stateWiseTaxPercentageShow() {
        $('#isTaxInfoSameDiv').show();
		$('#isTaxSameForAllStatesDiv').show();
		var euCountriesHidden = $('#euCountriesHidden').val();
		$('#euCountriesHidden').val('0');
		if(euCountriesHidden==1) {
			emptyStateUl();
			var ConsumptionTax1 = <?php echo $ConsumptionTaxEncoded;?>;
			var territory = '<?php echo $userProfileData->territory;?>';
			var  url = baseUrl+language+'/dashboard/stateWiseTaxPercentageShow';
			var  url1 = baseUrl+language+'/dashboard/getConsumptionStatesList';
			AJAX(url,'stateTaxSliderContainer','',ConsumptionTax1,territory);
			var territoryCountryId=$('#territoryCountryId').val();
			AJAX(url1,'statesDiv',territoryCountryId, <?php echo $ConsumptionTaxEncoded;?>);
			runTimeCheckBox();
		}
	}
	
   /**
	* Manage next step of state tax listing
	*/
	$('#next_consumption_charge_step').click(function() {
        
        var isTaxSameForAllStats = $('input[name=isTaxSameForAllStats]:checked').val();
        if(isTaxSameForAllStats == 't') {
            $('#consumptionChargeForm').submit();
        } else {

            var stateList = [];
            $(".checkboxStates:checked").each(function() {
                stateList.push(this.value);
            });
            if(stateList.length > 0) {
                $('#stateCountryId').val($('#territoryCountryId').val());
                $('#charge_consumption_tax_div').hide();
                $('#consumption_state_tax_div').fadeIn('slow');
                var form_data = {stateList: stateList};
                $.ajax
                ({
                    type: "POST",
                    url: '<?php echo $baseUrl.'/consumptionStateTaxHtml/' ?>',
                    data: form_data,
                    success: function(data)
                    {	
                        if(data) {	
                            $('#stateTaxList').html(data);	
                        }
                    }
                });
            } else {
                alert('Please select State, Provence, Region first!');
                return false;
            }
        }
	});
    
    /**
     * Manage back event of consumption second step for charge
     */		
    $('#backToStep1').click(function() {
        $('#charge_consumption_tax_div').hide(); 
        $('#consumption_tax_div').fadeIn('slow');
    });

</script>

