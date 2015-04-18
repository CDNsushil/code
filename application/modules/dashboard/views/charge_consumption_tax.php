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
?>
<div class="TabbedPanelsContentGroup">
<!-- =================Consumption Tax 2==================-->
<div class="TabbedPanelsContent Consumption_Tax TabbedPanelsContentVisible"> 
    <?php echo form_open('dashboard/saveConsumptionTax',$formAttributes);?>                
		<div class="c_1">
			<div id="isTaxSameForAllStatesDiv"  class="<?php echo $isTaxSameForAllStatesShow;?>">
				<h3 class="red fs21 fnt_mouse pt12 pb10  bb_aeaeae "><?php echo $this->lang->line('consumtionTaxDetail');?></h3>
				<div class="sap_40"></div>
				<ul class=" display_table mb22 fs13 clearb rate_wrap">
					<li class="mb10 ">
						<label class=" pr10 fs15 fl lineH28"><?php echo $this->lang->line('consumtionTaxType');?></label>
						<span>
                            <input type="text" name="allStateTaxName" class="font_wN width152 shadownone required" value="<?php echo $allStateTaxName;?>" onblur="placeHoderHideShow(this,'VAT, GST, Sales Tax etc*','show')" onclick="placeHoderHideShow(this,'VAT, GST, Sales Tax etc*','hide')" placeholder="VAT, GST, Sales Tax etc*">
                        </span>
                    </li>
					<li class=" mb3">
						<label class=" pr10 fs15 fl lineH28"><?php echo $this->lang->line('rate');?></label>
						<span>
                            <input type="text" name="allStateTaxPercentage" class="font_wN width_50 shadownone text_alighC number required" value="<?php echo $allStateTaxPercentage;?>" onblur="placeHoderHideShow(this,'%*','show')" onclick="placeHoderHideShow(this,'%*','hide')" placeholder="%*">
                        </span>
                    </li>
				</ul>
				<div class="sap15"></div>
			</div>
			<h3 class="red fs21 fnt_mouse bb_aeaeae "><?php echo $this->lang->line('whereNeedToCharge');?></h3>
			<div class="sap_30"></div>
			<ul class="fl clearb country_tab billing_form mb30">
				<li class="defaultP fl width_325 select select_1">
					<p class=" clearb pb10 pl1 ml37">
						<?php echo $this->lang->line('country');?>
					</p>
					<label class="pl0">
						<div class="ez-radio">
							<input type="radio" onclick="stateWiseTaxPercentageShow();" name="territory" id="territoryCountry" value="0" <?php if($userProfileData->territory==0 || $userProfileData->territory==null || empty($userProfileData->territory)){ echo 'checked';}?> class="ez-hide">
						</div>
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
					<div class="ez-radio ez-selected">
						<input type="radio" <?php if($userProfileData->territory==1){ echo 'checked';}?> onclick="euCountiesTaxPercentage();" name="territory" id="territoryEuropean" value="1" class="ez-hide">
					</div>
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
							<input type="radio" <?php echo $isTaxSameForAllStatsYes;?>  value="t" name="isTaxSameForAllStats" id ="isTaxSameForAllStatsYes" onclick="$('#allStatesNext').hide(); $('#allStatesSave').show(); $('#isTaxSameForAllStatesDiv').show();" class="ez-hide">
							<?php echo $this->lang->line('yes');?>
						</label>
						<label>
							<input type="radio" <?php echo $isTaxSameForAllStatsNo;?>  value="f" name="isTaxSameForAllStats" id ="isTaxSameForAllStatsNo" onclick="$('#allStatesNext').show(); $('#allStatesSave').hide(); $('#isTaxSameForAllStatesDiv').hide();" class="ez-hide">
							<?php echo $this->lang->line('no');?>
						</label>
					</p>
				</div>
			</div>
				<ul class="org_list">
					<li class="icon_1 red"><?php echo $this->lang->line('allSaleUpdate');?></li>
				</ul>       
				<div class="fr btn_wrap display_block font_weight">
					<button type="submit" class="red fl p10 bdr_a0a0a0 taxbt_not ui-button  <?php echo $isSavaBtnShow;?> ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" id="allStatesSave">
						<span class="ui-button-text"><?php echo $this->lang->line('save');?></span>
					</button>
					<a href="javascript://void(0);" id="next_consumption_charge_step"> 
						<button type="button" class="fl p10 bdr_F1592A b_F1592A taxbt_yes mr0 <?php echo $isNextBtnShow;?>  ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"  aria-disabled="false" id="allStatesNext">
							<span class="ui-button-text"><?php echo $this->lang->line('next');?></span>
						</button>
					</a>
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
				
					$.ajax
					({
						type: "POST",
						url: baseUrl+language+'/dashboard/saveConsumptionTax',
						data: fromData,
						beforeSend: function() {
							loader();
						},
						success: function(data) {	
							if(data) {	
								window.location.href = window.location.href;
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
						$("#successMsg").html('');
							alert(thrownError);
						}
					});
					return false;
					/*$.post(baseUrl+language+'/dashboard/saveConsumptionTax',fromData, function(data) {
						if(data) {
							window.location.href = window.location.href;
						}
					});*/
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
        
		
		/*if(euCountriesHidden!=1) {
			   
			$('#isTaxSameForAllStatesDiv').hide();
			$('#isTaxSameForAllStats').click();
			
			emptyStateUl();
			$('#checkAllStates').attr('checked', false);
			$('.checkboxStates').attr('checked', false);
			var euCountiesList = <?php echo json_encode($euCountiesList);?>;
			var ConsumptionTax = <?php echo $ConsumptionTaxEncoded;?>;
			var territory = '<?php echo $userProfileData->territory;?>';
			var  url = baseUrl+language+'/dashboard/euCountiesTaxPercentage';
			AJAX(url,'stateTaxSliderContainer',euCountiesList,ConsumptionTax,territory); 
			runTimeCheckBox();
		}*/
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
				url: baseUrl+language+'/dashboard/consumptionStateTaxHtml',
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
	});
	
</script>

