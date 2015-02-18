<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$domesticStateForm = array(
	'name'=>'domesticStateForm',
	'id'=>'domesticStateForm'
); ?>

<div class="TabbedPanelsContentGroup SSSContents " id="dsh"> 
	<div class="TabbedPanelsContent TabbedPanelsContentVisible">
	<?php
	$domestic_country = (isset($domestic_country) && ($domestic_country >0 )) ?$domestic_country : 0;
	$deliveryInformation = (isset($deliveryInformation)) ?$deliveryInformation :'';	
	$stateList = getStatesList($domestic_country); 
	if(isset($states) && is_object($states) && count($states) >0 ) {
		$stateArray = $states ;
		$selStates = (array) $stateArray;
		$IsCheckedAll = (array_key_exists('checked_all', $selStates)) ? 'checked' : '' ;
		  }else{ $selStates = '' ; }
	
 echo form_open($this->uri->uri_string(),$domesticStateForm); ?>
		<div class="c_1">
			<input type="hidden" name="countryId" value="<?php echo $domestic_country ?>" /> 
			<input type="hidden" name="deliveryInformation" value="<?php echo $deliveryInformation ?>" /> 
			<h3 class="red fs21 fnt_mouse bb_aeaeae ">Which of the states / provinces / regions will you ship to and
			how much you will charge?*</h3>
			<div class="sap_40"></div>
			<div class=" width_520 m_auto defaultP domestic">
			<div class=" slect_menu ml26 mr27 bdr_c4c4c4  height_30 ">
				<label class="pt5 pl10 all_click">
					<input <?php echo $IsCheckedAll ?>  value="1" id="checkStates" name="checked_all" onclick="checkAll(this, '.checkboxStates')"  type="checkbox" />
				<span>  All </span> </label>
			</div>			
				<div id="slider4" class="slider ml26 mr27 bdr_c4c4c4 mt10 p10 domestic"> <a class="buttons prev" >left</a>
					<div class="viewport">		
						<ul class="fs13 width100_per pl0 overview slect_coustom slect_menu">
			<?php if(isset($stateList) && is_array($stateList) && count($stateList) >0) {
				   foreach ($stateList as $key=>$list) {
					    foreach($selStates as $i=>$item){
						  if($key==$i){
							   $checked = 'checked';
							   $value = $item;
							   break;
							 }else{
								$checked = '';
								$value = '0.00';
								}
						} ?>
							<li>
							<label> 
							<input <?php echo $checked;?>  type="checkbox" name="check" value="<?php echo $key ?>" id="CheckboxGroup1_0" class=" check_<?php echo $key ?> checkboxStates" />
							<span><?php echo $list ?></span> </label>
							€
							<input type="text" onblur="placeHoderHideShow(this,'0.00','show')" onclick="placeHoderHideShow(this,'0.00','hide')" value="<?php echo $value ?>" placeholder="0.00" class="state_price font_wN  width_65 val_<?php echo $key ?>" name="state[<?php echo $key ?>]">
							</li>
				    <?php  }  } ?>
						</ul>		
						<a class="buttons next" href="" ></a> </div>						
					</div>
					<ul class="org_list">
						<li class="icon_2 ">Changes to these settings will NOT change your Shipping setup for your current sales.
You will be able to copy this Shipping information to new sales. 
						</li>
					</ul>
					<div class="fr btn_wrap display_block font_weight">
					<a href="javascript:void(0)"> 
                        <button type="button" class="TabbedPanelsTab SSSabMenu fl p10 back_dom bdr_a0a0a0" id="dsSabMenu" onclick="hideShow(this,'#ds','.SSSContents','slow','.SSSabMenu','TabbedPanelsTabSelected');">Back</button></a>
					<button class="fl p10 red bdr_a0a0a0" onclick="return saveDomesticState();" type="submit">Save</button>
				</div>
			</div>	
		</div>
	</div>
<?php echo form_close(); ?>	
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
		
/* Domestic shipping details */
	function saveDomesticState(){
		var len = $('.checkboxStates:checked').length;
		if(len <= 0){
			customAlert('Please select states for domestic  shipping');
			return false;
			e.preventDefault();
			}
		
		checkState();
		$("#domesticStateForm").validate({
			submitHandler: function(form) {
				var fromData=$("#domesticStateForm").serialize(); 				              
				$.post( baseUrl+language+'/dashboard/saveDomesticState',fromData, function( data ) {
					if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
						}
				}, "json");
			}
		});
    }
    
function checkAll(obj,checkbox){	
	if(!checkbox){
		checkbox ='.CheckBox';
		}
		$(checkbox).attr("checked", obj.checked);
		if(!$('#checkStates').is(":checked")){
		$( ".state_price" ).each(function( index ) {
			$( this ).removeClass( "required error" );
			$(this).val('0.00')
			});
		}
		runTimeCheckBox();
	}

function checkState(){
	var val ;
	var domesticPrice ;
	
		if($('#checkStates').is(":checked")){
			$( ".state_price" ).each(function( index ) {
				$( this ).addClass( "required number error" );			
				
			});				
			$(':checkbox:checked').each(function(i){
			val = $(this).val();
			domesticPrice = $('.val_'+val).val();			
			if(domesticPrice > 0){
			 $('.val_'+val).removeClass('required number error');
			}  
		});

		} else {
			$( ".state_price" ).each(function( index ) {
			  $( this ).removeClass( "required number error" );
		   });		
		$(':checkbox:checked').each(function(i){
			val = $(this).val();
			domesticPrice = $('.val_'+val).val();
			if(domesticPrice <= 0){
			 $('.val_'+val).addClass('required number error');
			}
			  
		});	
	}	
	//runTimeCheckBox();
	} 


</script>  
