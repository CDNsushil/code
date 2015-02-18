<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$formName='shippingForm'.$unqueId;
	$zoneTitle=@$title?$title:'';
	$countriesId=@$countriesId?$countriesId:'';
	
	//echo  "countriesId==".$countriesId;
	// Have you any idea when Robin will come Office today?
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);
	$unqueIdInput = array(
		'name'	=> 'unqueId',
		'id'	=> 'unqueId'.$unqueId,
		'value'	=> $unqueId,
		'type'	=> 'hidden'
	);
	$titleInput = array(
		'name'	=> 'title',
		'id'	=> 'title'.$unqueId,
		'value'	=> $zoneTitle,
		'type'	=> 'hidden'
	);
	
	$spIdInput = array(
		'name'	=> 'spId',
		'id'	=> 'spId'.$unqueId,
		'value'	=> $spId>0?$spId:0,
		'type'	=> 'hidden'
	);
	$zoneIdInput = array(
		'name'	=> 'zoneId',
		'id'	=> 'zoneId'.$unqueId,
		'value'	=> $zoneId>0?$zoneId:0,
		'type'	=> 'hidden'
	);
	$entityIdInput = array(
		'name'	=> 'entityId',
		'id'	=> 'entityId'.$unqueId,
		'value'	=> $entityId>0?$entityId:0,
		'type'	=> 'hidden'
	);
	$elementIdInput = array(
		'name'	=> 'elementId',
		'id'	=> 'elementId'.$unqueId,
		'value'	=> $elementId>0?$elementId:0,
		'type'	=> 'hidden'
	);
	$countriesIdInput = array(
		'name'	=> 'countriesId',
		'id'	=> 'countriesId'.$unqueId,
		'value'	=> $countriesId,
		'type'	=> 'hidden'
	);
	
	$shortDesc_minVal=0;
	$shortDesc_maxVal=15;
	$wordLabel=$shortDesc_minVal.' - '.$shortDesc_maxVal.$this->lang->line('words');
	$shortDesc=(isset($shortDesc) && $shortDesc != null && $shortDesc != 'null')?$shortDesc:'';
	$shortDesc=trim($shortDesc);
	$description = array(
	'name'	=> 'shortDesc',
	'id'	=> 'shortDesc',
	'class'	=> 'textarea_small_bg width_614',
	'value'	=> $shortDesc,
	'wordlength'=>$shortDesc_minVal.','.$shortDesc_maxVal,
	'onkeyup'=>"checkWordLen(this,'".$shortDesc_maxVal."','descLimit')",
	'rows'	=> 1,
	'cols'	=> 84,
	);
	
	$zoneCounriesInput = array(
		'name'	=> 'zoneCounries',
		'id'	=> 'zoneCounries'.$unqueId,
		'class'	=> 'clr_darkgrey textarea_small_bg required',
		'value'	=> zoneCountries($countriesId),
		'cols'	=> 84,
		'rows'	=> 2,
		'readonly'	=> true
	);
	$amountInput = array(
		'name'	=> 'amount',
		'id'	=> 'amount'.$unqueId,
		'class'	=> 'clr_darkgrey price_input_shipping required number',
		'value'	=> $amount>0?$amount:0.00,
		'min'	=> 0.1,
		'maxlength'	=> 15,
		'title'	=> $this->lang->line('moreThenZero')
	);
	if(!empty($countriesId)){
		$countriesId = explode('|',$countriesId);
	}else{
		$countriesId[]=0;
		$countriesId[]='';
	}
?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient ">
	<div class="width_690">
		<?php
	$countryFlag=false;
	/*echo "<pre>";
	print_r($countryList);
	die;*/
	if(is_array($countryList) && count($countryList) > 0){ 
		echo form_open(base_url(lang().'/shipping/addEditshipping'),$formAttributes);
		echo form_input($unqueIdInput); 
		echo form_input($spIdInput); 
		echo form_input($zoneIdInput);
		echo form_input($entityIdInput);
		echo form_input($elementIdInput);
		echo form_input($countriesIdInput);
		echo form_input($titleInput);
		?>
		<div class="popup_orange_head"><?php echo $zoneTitle;?></div>
		<div class="position_relative ml30 mt20">
			<div class="cell shadow_wp strip_absolute left_201 shiping_field_divide">
				<!-- <img src="images/strip_blog.png"  border="0"/>-->
				  <table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
					<tbody>
					  <tr>
						<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
					  </tr>
					  <tr>
						<td class="shadow_mid_small">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
					  </tr>
					</tbody>
				  </table>
				<div class="clear"></div>
			</div>
			<div class="cell shadow_wp strip_absolute left_485 shiping_field_divide">
			<!-- <img src="images/strip_blog.png"  border="0"/>-->
			<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
			<tbody>
			  <tr>
				<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
			  </tr>
			  <tr>
				<td class="shadow_mid_small">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
			  </tr>
			</tbody>
			</table>
			<div class="clear"></div>
			</div>
			  <div class="row">
				<div class="cell">
				  <div class="Shiping_title mb20"> <span class="pr3">1. </span><?php echo $this->lang->line('selectContinent');?></div>
				  <div class="shiping_select_box01">
					<div class="mr10 ml10 mt10">
					  <?php
						$continentId=0;
						$continentCountries=array();
						$i=0;
						foreach($countryList as $k=>$country){
							if($country->continentId !=$continentId && $country->continentId > 0){
								$continentId=$country->continentId; 
								$checked=$i==0?'checked':'';
								$i++;
								?>
								 <div class="defaultP">
									<input <?php echo $checked;?> type="radio" name="continentId"  value="<?php echo $continentId;?>" onclick="showCurrentHideEach('#countryListing<?php echo $continentId;?>','.countryListing')" />
								 </div>
								 <div class="cell ml10"><?php echo $country->continent;?></div>
								 <div class="clear seprator_8"> </div>
								<?php
							}
							$continentCountries[$country->continentId][$country->countryId]=$country->countryName;
						}?>
					</div>
				  </div>
				</div>
				<div class="cell ml65">
				  <div class="Shiping_title mb20"> <span class="pr3">2. </span> <?php echo $this->lang->line('selectCountries');?> </div>
				  <div class="shiping_select_box02">
					
					<?php
						$continentId=0;
						$i=0;
						foreach($continentCountries as $continentId=>$Countries){ 
							$dn=$i==0?'':'dn';?>
							 <div class="mr10 ml20 mt10 <?php echo $dn?> countryListing" id="countryListing<?php echo $continentId;?>">
								<?php
									foreach($Countries as $countryId=>$countryName){
										$checked=in_array($countryId, $countriesId)?'checked':''; ?>
										 <div class="defaultP">
											<input type="checkbox" class="CheckBox" name="countryCheckBox[]" value="<?php echo $countryId; ?>" title="<?php echo $countryName; ?>" <?php echo $checked;?> />
										 </div>
										 <div class="cell ml10 width_130"><?php echo $countryName;?></div>
										 <div class="bdr_below_checkbox clear"></div>
										 <?php
									}
								?>
								<div class="clear seprator_9"> </div>
							 </div>
							<?php
							$i++;
						}?>
					
				  </div>
				</div>
				<div class="cell ml65">
				  <div class="Shiping_title mb20"> <span class="pr3">3. </span> <?php echo $this->lang->line('setCharge');?></div>
				   <?php echo $this->lang->line('EURO')."&nbsp;".form_input($amountInput); ?>
				</div>
				<div class="clear"></div>
			  </div>
		</div>
		<div class="seprator_45 clear"></div>
		<div class="row ml30">
			<div class="width_614">
					<?php echo form_textarea($zoneCounriesInput); ?>
			</div>
			<div class="seprator_5 clear"></div>
			<div class="note_belw_textarea"> <?php echo $this->lang->line('selectCountriesInZoneMsg');?></div>
		</div>
		<div class="seprator_25 clear"></div>
		
		<div class="row ml30 note_belw_textarea mb5">
			<?php echo $this->lang->line('shippingDetails');?>
		</div>
			
			<div class="row ml30">
			<div class="width_614">
				<?php echo form_textarea($description); ?>
				<div id="word_counter" class="row wordcounter width635px">
					<?php echo form_error($description['name']); ?>
					<span class="tag_word_orange"> <?php echo $wordLabel;?> </span>
					<span class="five_words" > 				
						<span id="descLimit">
							<?php
								echo str_word_count($shortDesc);
							?>
						</span>
						<span> <?php echo $this->lang->line('words');?></span>
					 </span>
				</div>
			</div>
		</div>	
		
		<div class="seprator_20 clear"></div>
		
		 <div class="row mr20">
			<?php
				$button=array('submit', 'cancel','buttonId'=>'_SP');
				echo Modules::run("common/loadButtons",$button); 
			 
			 /*
			  <div class="cell Fright">
				<div class="tds-button Fright mr28"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span ><?php echo $this->lang->line('submit');?></span></a> </div>
				<div class="tds-button Fright mr8"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#" ><span ><?php echo $this->lang->line('cancel');?></span></a> </div>
				<div class="clear"></div>
			  </div>
			  * */
			 ?>
		  
		  <div class="clear"></div>
		</div>
		<?php echo form_close(); ?>
			<script>
				
				$(document).ready(function(){	
					runTimeCheckBox();
					$("#cancelButton_SP").click(function(){
						$('#popup_close_btn').click();
					});
					$(".CheckBox").click(function(){
						var countriesName = new Array();
						var countriesId = new Array();
						var names = '';
						var ids ='';
						
						var i=0;
						$('.CheckBox').each(function(index, value){
							if(this.checked){
								countriesName[i]=this.title;
								countriesId[i]=this.value;
								i++;
							}
						});
						
						if(countriesId.length >= 1){
							names = countriesName.join(', ');
							ids=  '|'+countriesId.join('|');
						}
						
						$('#zoneCounries<?php echo $unqueId;?>').val(names);
						$('#countriesId<?php echo $unqueId;?>').val(ids);
						
					});
					
					$("#<?php echo $formName;?>").validate({
						  submitHandler: function() {
							  var fromData=$("#<?php echo $formName;?>").serialize();
							 if($('#status<?php echo $unqueId;?>').attr('checked')){
								 fromData = fromData+'&status=t';
								}
							$.post(baseUrl+language+'/shipping/addEditshipping',fromData, function(data) {
							  if(data){
								 var amount = $("#amount<?php echo $unqueId;?>").val();
								  $("#showAmount<?php echo $unqueId;?>").val(amount);
								  $("#secriptDiv<?php echo $unqueId;?>").html(data);
								 
								  $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
								  timeout = setTimeout(hideDiv, 5000);
								  $('#popup_close_btn').click();
							  }
							});
						 }
					});
					
					
				});
			</script>
			<?
	 }
	 else{ ?>
		<div class="cell pro_title">
			<?php echo $this->lang->line('noRecord'); ?>
			<div class="clear"></div>
		 </div>
		<?php
	 }
	 ?>
	</div>
	<div class="seprator_15 clear"></div>
	<div class="row"></div>
</div>
