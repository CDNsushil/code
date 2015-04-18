<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'workLocationForm',
    'id'=>'workLocationForm',
);

$workLocationType = (isset($workProfileDetails->workLocationType) && !empty($workProfileDetails->workLocationType)) ? $workProfileDetails->workLocationType : '';

$checkedContinents = '';
$checkedCountries = '';
$checkedStates = '';

if($workLocationType == 2){
	$checkedCountries = 'checked';
} elseif($workLocationType == 3){
	$checkedStates = 'checked';
} else {
	$checkedContinents = 'checked';
}
// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>

<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<?php //echo form_open($baseUrl.'/setaddbutton/',$formAttributes); ?>  
		<h3><?php echo $this->lang->line('workLocations')?></h3>
		<div class="sap_20"></div>
		<p> <?php echo $this->lang->line('addUpLocations');?> </p>
		<div class="sap_15"></div>
		<div class="defaultP"> 
			<span class="fl mr30">
				<input type="radio" value="1" name="workLocationType" onclick="getLocations(1)" id="continentsType" <?php echo $checkedContinents; ?> />
				<?php echo $this->lang->line('continents');?>
			</span> 
			<span class="fl mr30">
				<input type="radio" value="2" name="workLocationType" onclick="getLocations(2)" id="countriesType" <?php echo $checkedCountries; ?> />
				<?php echo $this->lang->line('countries');?>
			</span>
			<span class="fl ">
				<input type="radio" value="3" name="workLocationType" onclick="getLocations(3)" id="statesType" <?php echo $checkedStates; ?> />
				<?php echo $this->lang->line('states');?>
			</span> 
		</div>
		<div class="sap_50"></div>
		<div class="bc2c2c2 p10 width152 fl open_sans">
			<!-----Continent checkbox options list box ----> 
			<ul class="defaultP listpb10 fs13 " id="continentCheckboxList">
				<?php
				foreach($continentList as $continent) { ?>
					<li>
						<input type="checkbox" name="continentCheckId" value="<?php echo $continent->id;?>" />
						<?php echo $continent->continent;?> 
					</li>
				<?php 
				}?>
			</ul>
			<!-----Continent radio options list box ----> 
			<ul class="defaultP listpb10 fs13 dn" id="continentRadioList">
				<?php
				$i = 0;
				foreach($continentList as $continent) { ?>
					<li>
						<input type="radio" name="continentId" <?php if($i==0) { ?> checked='checked' <?php } ?> value="<?php echo $continent->id;?>" onclick="getCountryList('<?php echo $continent->id;?>'); " />
						<?php echo $continent->continent;?> 
					</li>
					<?php 
					$i++;
				}?>
			</ul>
		</div>
		
		<!-----Country list box ----> 
		<div class="bc2c2c2 width207 p3 fl ml15 open_sans slidervertical slider dn" id="countryListHtml"></div>
		<!-----States list box ----> 
		<div class="bc2c2c2 width207 p3 fl ml15 open_sans slidervertical slider dn" id="stateListHtml"></div>

		<div class="sap_20"></div>
		<button class="fr" onclick="addWorkLocation()">Add</button>
		<div class="sap_30 bb_c2c2"></div>
		<div class="sap_30"></div>
		<!-----Work location listing  ----> 
		<?php if(!empty($locationList)) { ?>
			<span class="red pl82 "> Location </span>
			<ul class="list_box pt20 clearb">
				<?php foreach($locationList as $location) { ?>
					<li class="mb10 lineH20 pl30" id="locationDiv_<?php echo $location->workLocationId;?>">
						<span class="bg_f9f9f9 width100_per lineH21"> 
							<span class=" fl pl50 width210 "> <?php echo getWorkLocation($location->workLocationType,$location->locationId);?> </span>  
							<span class="red mr20 fr ptr" onclick="deleteworklocation('<?php echo $location->workLocationId;?>');">Delete </span> 
						</span>
					</li>
				<?php }?>
			</ul>
		<?php } ?>
	</div>
	<!-- Form buttons -->
	<?php 
	// set back page
	$data['backPage'] = '/workprofile/typeofworksort';
	// set next form name
	$data['isNextstep'] = '1';
	$data['nextPage'] = '/workprofile/education';
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>
</div>

<script type="text/javascript">
	 $(document).ready(function(){
		$('.slidervertical').tinycarousel({ axis: 'y', display: 1});
		$('#slider7').tinycarousel({ axis: 'y', display: 1});		
			
	});
	
    // Manage location boxes
    function getLocations(locationType) {
		// get continent id
		var continentId = $('input:radio[name=continentId]:checked').val();
		
		if(locationType == 2) {          // if selected option : Countries
			$('#continentCheckboxList').hide();
			$('#continentRadioList').show();
			$('#stateListHtml').hide();
			// get countries of continent
			getCountryList(continentId);
		} else if(locationType == 1) {     // if selected option :  Continents
			$('#continentCheckboxList').show();
			$('#continentRadioList').hide();
			$('#countryListHtml').hide();
			$('#stateListHtml').hide();
		} else {                           // if selected option :  States
			$('#continentCheckboxList').hide();
			$('#continentRadioList').show();
			// get countries of continent
			getCountryList(continentId);
			// use setTimeout() to execute state listing of country
			setTimeout(getStateList, 1000);
		}
	}
	
	// Get country listing html
	function getCountryList(continentId) {
		var locationType = $('input:radio[name=workLocationType]:checked').val();
		fromData = 'continentId='+continentId+'&locationType='+locationType;
		$.post('<?php echo $baseUrl.'/getcountries';?>',fromData, function(data) {
			if(data){
				$('#countryListHtml').show();
				$('#countryListHtml').html(data);
				if(locationType == 3) {
					// use setTimeout() to execute state listing of country
					getStateList();
				}
			}
		});
	}
	
	// Get state listing html
	function getStateList() {
		// get country id
		var countryId = $('input:radio[name=countryId]:checked').val();
		fromData = 'countryId='+countryId;
		$.post('<?php echo $baseUrl.'/getstates';?>',fromData, function(data) {
			if(data){
				$('#stateListHtml').show();
				$('#stateListHtml').html(data);
			}
		});
	}
	
	// Add work locations
	function addWorkLocation() {
		var locationType = $('input:radio[name=workLocationType]:checked').val();
		var locationIds = [];
		
		if( locationType == 1 ) {
			$('#continentCheckboxList input:checked').each(function() {
				locationIds.push($(this).val());
			});
			
		} else if( locationType == 2 ) {
			$('#countryListHtml input:checked').each(function() {
				locationIds.push($(this).val());
			});
		} else if( locationType == 3 ) {
			$('#stateListHtml input:checked').each(function() {
				locationIds.push($(this).val());
			});
		}
		
		if(locationIds != '') {
			fromData = 'locationType='+locationType+'&locationIds='+locationIds;
			$.post('<?php echo $baseUrl.'/setworklocations';?>',fromData, function(data) {
				if(data){
					refreshPge();
				}
			 }, "json");
		} else {
			alert('Please select location first');
			return false;
		}
	}
	
	  // remove visa from workrprofile
    function deleteworklocation(workLocationId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'workLocationId='+workLocationId;
             $.post('<?php echo $baseUrl.'/deleteworklocation/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#locationDiv_"+workLocationId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }
    	
     function checkUncheckStates(obj){
        $("#stateListHtml input:checkbox[name=countryId[]]" ).attr('checked',obj.checked);
        runTimeCheckBox();
    }
 
 
</script>
