<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'workTypeForm',
    'id'=>'workTypeForm',
);

$remunerationRequiredInput = array(
    'name'	    => 'remunerationRequired',
    'value'	    => (isset($workProfileDetails->remunerationRequired) && !empty($workProfileDetails->remunerationRequired)) ? $workProfileDetails->remunerationRequired : '',
    'id'	    => 'remunerationRequired',
    'type'	    => 'text',
    'class'     => 'width_240 fl number',
    'onclick'   =>  "placeHoderHideShow(this,'Renumeration','hide')",
    'onblur'    =>  "placeHoderHideShow(this,'Renumeration','show')",
    'placeholder' =>  "Renumeration",
);

$isContractWork = (isset($workProfileDetails->isContractWork) && !empty($workProfileDetails->isContractWork)) ? $workProfileDetails->isContractWork : '';

if( $isContractWork=='t' ) { 
	$contractWorkCheck =true;
} else { 
	$contractWorkCheck =false;
}
$contractWorkInput = array(
	'name'     => 'contractWork',
	'id'       => 'contractWork',
	'class'    => 'checkbox',
	'value'    => '1',
	'checked'  =>  $contractWorkCheck,
);
	
$isContractWorkInput = array(
	'name'	=> 'isContractWork',
	'id'	=> 'isContractWork',
	'type'	=> 'hidden',
	'value'	=> $isContractWork,
);

$monthArr = array();
for($i=1;$i <= 12;$i++)
{
	$month[$i] = $i;
}
// set contract months
$minContractMonth = (isset($workProfileDetails->minContractMonth) && !empty($workProfileDetails->minContractMonth)) ? $workProfileDetails->minContractMonth : 0;
$maxContractMonth = (isset($workProfileDetails->maxContractMonth) && !empty($workProfileDetails->maxContractMonth)) ? $workProfileDetails->maxContractMonth : 0;

// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>
<div class="content display_table  TabbedPanelsContent  pl25 ">
	<div class="width177 pr20 fl mt116">
		<ul class="listpb20 color_999  mt10 text_alignR">
			<li>Renumeration </li>
			<li>Availability</li>
			<li><?php echo $this->lang->line('interestedContractWork');?></li>
			<li class="mt85">Display Section</li>
		</ul>
	</div>
            
	<div class="c_1  width635 fl">
        <h3> <?php echo $this->lang->line('typeOfWorkSort');?> </h3>
        <div class="sap_30"></div>
        <?php echo form_open($baseUrl.'/typeofworksort',$formAttributes); ?>
             <ul class="listpb15">
         
                <li>
					<?php echo form_input($remunerationRequiredInput); ?>
					<span class="position_relative fl">
						<?php
						$rateList = getRemunerationRateList();
						$remunerationRate = (isset($workProfileDetails->remunerationRate) && !empty($workProfileDetails->remunerationRate)) ? $workProfileDetails->remunerationRate : '';
						echo form_dropdown('remunerationRate', $rateList, $remunerationRate,'id="remunerationRate" class=" main_SELECT selectBox ml20 width_141"');
						?>
					 </span>
                </li>
                
				<li>
					<span class="position_relative height30 fl">
						<?php
						$availabilityList = getAvailabilityList();
						$availability = (isset($workProfileDetails->availability) && !empty($workProfileDetails->availability)) ? $workProfileDetails->availability : '';
						echo form_dropdown('availability', $availabilityList, $availability,'id="availability" class=" main_SELECT selectBox width260"');
						?>
					</span>
                </li>
                
				<?php
				if((isset($isContractWork) && $isContractWork=='t') || (!empty($availability))){$dn='';} else{$dn='dn';}
				if(isset($isContractWork) && $isContractWork=='t'){$workMsgDn='';} else{$workMsgDn='dn';}
				?>
				
				<li class="<?php echo $dn;?> lineH12imp" id="contractWorkAvail">
					<span class="defaultP">
						<?php echo form_checkbox($contractWorkInput);?>	
					</span>
				</li>
				
				<li class="<?php echo $workMsgDn;?> work_sort" id="contractWorkMsg">
					<span class="fl pr10 pt6">From</span> 
					<span class="add_select position_relative fl">
						<p>
							<span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
								<input value="<?php echo $minContractMonth;?>" name="minContractMonth" readonly id="minContractMonth" aria-valuenow="89" class="ui-spinner-input" autocomplete="off" role="spinbutton">
								<a class="ui-spinner-button ui-spinner-up ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" onclick="manageWorkDuration('up','minContractMonth')">
									<span class="ui-button-text"><span class="ui-icon-triangle-1-n"></span></span>
								</a>
								<a class="ui-spinner-button ui-spinner-down ui-corner-br ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" onclick="manageWorkDuration('down','minContractMonth')">
									<span class="ui-button-text"><span class="ui-icon-triangle-1-s"></span></span>
								</a>
							</span>
						</p>
					</span>
		
					<span class="fl pl15 pr15 pt6 "> month to</span> 
					
					<span class="add_select position_relative fl">
						<p>
							<span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
								<input value="<?php echo $maxContractMonth;?>" name="maxContractMonth" readonly id="maxContractMonth" aria-valuenow="89" class="ui-spinner-input" autocomplete="off" role="spinbutton">
								<a class="ui-spinner-button ui-spinner-up ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" onclick="manageWorkDuration('up','maxContractMonth')">
									<span class="ui-button-text"><span class="ui-icon-triangle-1-n"></span></span>
								</a>
								<a class="ui-spinner-button ui-spinner-down ui-corner-br ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button" aria-disabled="false" onclick="manageWorkDuration('down','maxContractMonth')">
									<span class="ui-button-text"><span class="ui-icon-triangle-1-s"></span></span>
								</a>
							</span>
						</p>
					</span>
					
					<span class="fl pl10 pr10 pt6"> months </span> 	
				</li>
            </ul>
			<div class="sap_20 bb_c2c2"></div>
			<div class="sap_25"></div>
			<span class="lineH14">    
				You can choose to hide this section: 
			</span>
            <ul class="listpb15 pt15 defaultP">
				<li>	
					<input class="" type="checkbox" name="isHideWorkSortFromOnlineWP" <?php if($workProfileDetails->isHideWorkSortFromOnlineWP == 't') { ?> checked="checked" <?php } ?> />
					from online Work Profile 
				</li>

				<li>	
					<input class="" type="checkbox" name="isHideWorkSortFromCV" <?php if($workProfileDetails->isHideWorkSortFromCV == 't') { ?> checked="checked" <?php } ?> />
					from your printed CV (PDF)
				 </li><br />
			</ul>
      
        <?php 
			echo form_input($isContractWorkInput);
        echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] =  '/workprofile/skills';
        // set next form name
        $data['formName'] = 'workTypeForm';
		$this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
    </div>
</div>
<!--  content wrap  end --> 
<script>
     radioCheckboxRender();
  
    $(document).ready(function() {
        $("#workTypeForm").validate({
            submitHandler: function() {
                var fromData=$("#workTypeForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/settypeofworksort';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });   
       
	$("#contractWork").click(function(){
		if($('#contractWork').is(':checked') === true) {
			$('#contractWorkMsg').show();
			$('#isContractWork').val(1);
			
		} else {
			$('#contractWorkMsg').hide();
			$('#isContractWork').val(0);
		}
	});
	
	
	$("#minContractMonth").change(function(){
		var minContractVal = $("#minContractMonth").val();
		var maxContractVal = $("#maxContractMonth").val();
		if((parseInt(minContractVal)>=parseInt(maxContractVal)) || minContractVal=='') {
			//alert("From must be lower ");
			$('#minContractMonthError').show();
			setSeletedValueOnDropDown('minContractMonth','From');
			$('#isContractMonthFill').val(1);
		}
		else {
			$('#minContractMonthError').hide();
			$('#isContractMonthFill').val(0);
		}
	});
	
	$("#maxContractMonth").change(function(){
		var minContractVal = $("#minContractMonth").val();
		var maxContractVal = $("#maxContractMonth").val();
		if((parseInt(minContractVal)>=parseInt(maxContractVal)) || maxContractVal=='') {
			//alert("To must be greater ");
			$('#maxContractMonthError').show();
			setSeletedValueOnDropDown('maxContractMonth','To');
			$('#isContractMonthFill').val(1);
		}
		else {
			$('#maxContractMonthError').hide();
			$('#isContractMonthFill').val(0);
		}
	});
	
	$("#availability").change(function(){
		var e = document.getElementById("availability");
		var strAvailability = e.options[e.selectedIndex].text;
		var contractWorkCheck = '<?php echo $contractWorkCheck;?>';
		if(contractWorkCheck==true) {
			$('#contractWork').prop('checked', true);
			runTimeCheckBox();
		}
		
		if(strAvailability!='' && strAvailability!='Select Availability') {
			$('#contractWorkAvail').show();
			//alert($('#contractWork').is(':checked'));
			if($('#contractWork').is(':checked') === true) {
				$('#contractWorkMsg').show();
			}else{
				$('#contractWork').prop('checked', false);
				runTimeCheckBox();
				$('#contractWorkMsg').hide();
			}
			$('#contractWork').show();
			//$('#availWorkMsg').text(strAvailability+' from');
		}else {
		
			$('#contractWorkAvail').hide();
			$('#contractWork').hide();
			$('#contractWorkMsg').hide();
			$('#contractWork').prop('checked', false);
			runTimeCheckBox();
		}
	});     
});
    
    //------------------------------------------------------------------------
			
	/**
	 * @Description: Manage contract work data as spinner changes 
	 */ 
	function manageWorkDuration(spinnerType,monthType) {
	
		// get min or max month  value
		var contractMonth = $('#'+monthType).val();
		
		
		if( spinnerType == 'up' ) {
			if(contractMonth < 12) {
				contractMonth = parseInt(contractMonth)+1;
			}
		} else {
			if(contractMonth > 0) {
				contractMonth = parseInt(contractMonth)-1;
			}
		}
		// append values as min or max month
		$('#'+monthType).val(contractMonth);
	}
</script>
