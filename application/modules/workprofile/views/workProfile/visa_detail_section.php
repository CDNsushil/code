<?php
$visaDetail= json_decode($visaAvailable);

$visaDetailArray = array();
$visaCountryArray = array();
$visaTypeArray = array();

$visaAvailableArr = array(
    'name'        => 'visaAvailable',
    'id'          => 'visaAvailable',
);	

 if($workProfileId==0){ //Insert mode?>
 <div class="seprator_27 row"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['visaAvailable']?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="cell defaultP"  onClick="get_radio_valuelevels_Edit(1);">
				<input type='radio' name='levelsEdit' id='editYes' value='level1'>
			</div>
			<div class="cell widthSpacer">&nbsp;</div>
			<div class="cell"><label><?php echo $label['yes']?></label></div>
			<div class="cell widthSpacer">&nbsp;</div>
			<div class="cell defaultP"  onclick="get_radio_valuelevels_Edit(2);">
				<input id="editNo" class="radio" type="radio" checked="" value="level2" name="levelsEdit">
			</div>
			<div class="cell widthSpacer">&nbsp;</div>
			<div class="cell"><label><?php echo $label['no']?></label></div>
			<?php echo form_error($visaAvailableArr['name']); ?>
			<?php echo isset($errors[$visaAvailableArr['name']])?$errors[$visaAvailableArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->

<div id='level2' style="display:none"></div>

<div id='level1' style="display:none">
	<?php $profileVisaCountry = 'visaCountry[1]'; ?>
	<div class="row width100percent">
		<div class="empty_label_wrapper cell"></div>
		<div class="cell frm_element_wrapper">
			<div class="orng">
				<div onclick="addVisa()" id="addScnt" class="projectAddIcon formTip" style="cursor:pointer" title="Add Visa Information"></div>
				<span id='visa_count_edit' style="display:none">1</span>
			</div>
		</div>
	</div>

	<div class="row width100percent">
		<div class="empty_label_wrapper cell"></div>
		<div class="cell frm_element_wrapper">

			<div id="p_scents"  class="visaInfoDiv formTip" title="<?php echo $label['addVisaInformation']?>">
				<div class="cell" style="width:190px;">
					<div class="orng"><?php echo $label['country']?></div>
				</div>
				<div class="cell" style="width:190px;">
					<div class="orng"><?php echo $label['visaType']?></div>
				</div>
				<?php 
				$visaDetailArray = object2array($visaDetail);
				$visaCountryArray = object2array($visaDetailArray['visaCountry']);
				$visaTypeArray = object2array($visaDetailArray['visaType']);
				for($i=1;$i<=count($visaCountryArray);$i++)
				{
					$profileVisaCountryval = $visaCountryArray[$i];
					$profileVisaType = $visaTypeArray[$i];
				}
				?>
				<div class="cell visaDetailId_1">
					<div class="cell profileDropDown">
						
									<?php echo form_dropdown($profileVisaCountry , $countries, set_value($profileVisaCountry ),'id="visaCountry"'); //, 'onclick="selectBox()"'  ?>
							
					</div>
					<div class="cell ml20">
						<?php $visaType['name']= 'visaType[1]'?>
						<input type="text" id="visaType_1" size="26" name="<?php echo $visaType['name']?>" value="" class="formTip required"/>
						<?php echo form_error($visaType['name']); ?>
						<?php echo isset($errors[$visaType['name']])?$errors[$visaType['name']]:''; ?>
						<span class="clear_seprator "></span>
					</div>
					<div class="floatRight-ml20" >
						<a title="Remove" class="formTip ptr" onclick="removeVisaDetail(1)">
							<div class="projectDeleteIcon"></div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else { //Edit mode?> 
<div class="seprator_27 row"></div>

<div class="row">
	<div class="label_wrapper cell">
		<label >
			<?php echo $label['visaAvailable']; ?>
		</label>
	</div>
	<div class=" cell frm_element_wrapper">
		<div class="cell defaultP"  onClick="get_radio_valuelevels_Edit(1);" >
			<input type='radio' name='levelsEdit' id='editYes' value='level1Wdit' checked="true">
		</div>
		<div class="cell widthSpacer">&nbsp;</div>
		<div class="cell"> <?php echo $label['yes']?> </div>

		<div class="cell widthSpacer">&nbsp;</div>

		<div class="cell defaultP"  onClick="get_radio_valuelevels_Edit(2);">
			<input type='radio' name='levelsEdit' id='editNo' value='level2Wdit' <?php if($visaAvailable=='') { echo "checked";} ?>>
		</div>
		<div class="cell"> <?php echo $label['no']?>  </div>
	</div>
	<?php echo form_error($visaAvailableArr['name']); ?>
	<?php echo isset($errors[$visaAvailableArr['name']])?$errors[$visaAvailableArr['name']]:''; ?>
</div>

<div id='level2Wdit' style="display:none"></div>
<span class="clear_seprator "></span>
	
<div id='level1Wdit' <?php if($visaAvailable=='') { echo "style='display:none;'";} ?> class="level1Wdit">
	<?php $visaDetailArray = object2array($visaDetail);
		$visaCountryArray = object2array($visaDetailArray['visaCountry']);
		$visaTypeArray = object2array($visaDetailArray['visaType']);
	?>
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['visaInformation']?>
			</label>
		</div>
		<div class=" cell frm_element_wrapper">
			<div class="title-content">
				<div class="title-content-left">
					<div class="title-content-right">
						<div class="title-content-center">
							<div class="title-content-center-label"><span id="addScntEdit" style="margin-right:6px">
									<?php if(count($visaCountryArray) !=0) {?><span id='visa_count' style="display:none"><?php echo count($visaCountryArray);?></span>
									<?php }else {?>
									<span id='visa_count' style="display:none">1</span>
									<?php }?>
									<span><div class="projectAddIcon formTip ptr" title ="Add Visa Information"></div></span>
							</span>		</div>
							
							<div class="clearfix" > </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="row width100percent">
	<div class="empty_label_wrapper cell"></div>
	<div class=" cell frm_element_wrapper">
		<div id="p_scentsEdit"  class="visaInfoDiv formTip"  title="<?php echo $label['addVisaInformation']?>">
			<div class="cell" style="width:190px;" id="countyText">
				<div class="orng"><?php echo $label['country']?></div>
			</div>
			<div class="cell" style="width:190px;" id="visaTypeText">
				<div class="orng"><?php echo $label['visaType']?></div>
			</div>
			<!--<div class="orng" >Country</div>-->
			<!--<div class="orng" >Visa Type</div>-->
			<?php
				$x='';
				$profileVisaCountry = 'visaCountry[$x + count($visaCountryArray)]'; ?>
			<?php 
			if($visaCountryArray!=''){ // When user will select option "no" than Creating the new select box and input field as default
			for($i=1;$i<=count($visaCountryArray);$i++)
			{
				if(isset($visaCountryArray[$i]) && isset($visaTypeArray[$i])){
				$profileVisaCountryval = $visaCountryArray[$i];
				//echo "-----".$profileVisaCountryval;
				$profileVisaType = $visaTypeArray[$i];
				//echo "<pre />"; print_r($countries);
			?>
			<div id="visaDetailId_<?php echo $i ?>" class="cell visaDetailId_<?php echo $i ?>">
				<div class="cell">
					<div id="visaCountry_<?php echo $i ?>" class="profileDropDown">
					
						<select class="required" id="visaCountry_<?php echo $i ?>" name="visaCountry[<?php echo $i ?>]" onclick="selectBox();" >
						<?php 						
						foreach($countries as $c) {?>
							<option value="<?php echo $c?>" <?php if($profileVisaCountryval == $c) { echo "selected"; }?>><?php echo $c?></option>
							<?php } ?>
						</select>
					
					</div>
				</div>
			
				<div class="cell ml20">
				<?php //$visaType['name']= 'visaType[1]'?>

				 <input type="text" id="visaType_<?php echo $i ?>" size="26" name="visaType[<?php echo $i ?>]" value="<?php if(isset($profileVisaType)) { echo $profileVisaType; }?>" class="formTip required"/>
				</div>
				<div class="floatRight-ml10" >
					<a title="Remove" class="ptr formTip" onclick="removeVisaDetail(<?php echo $i ?>)">
						<div class="projectDeleteIcon"></div>
					</a>
				</div>
				<span class="clear_seprator "></span>
			</div>
			<?php } } } else{ ?>
			
			<div id="visaDetailId_1" class="cell visaDetailId_1">
				<div class="cell profileDropDown">
					<div id="visaCountry_1" >
						
						<select class="visaCountry" name="visaCountry[1]" onclick="selectBox();" id="visaCountry">
							<?php foreach($countries as $c) {?>
							<option value="<?php echo $c?>"><?php echo $c?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="cell ml20 "> 
					<input type="text" id="visaType_<?php echo $i ?>" size="26" name="visaType[1]" class="formTip required"/>
				</div>
				<div class="floatRight-ml20" >
					<a class="formTip ptr" title="Remove" onclick="removeVisaDetail(1)" >
						<div class="projectDeleteIcon"></div>
					</a>
				</div>
				<span class="clear_seprator "></span>
			</div>
			<?php }?>
	</div>
</div>
</div>
</div>
<?php }?>
 <span class="clear_seprator "></span>

<script type="text/javascript">

function get_radio_valuelevels_Edit(val)
	{
		
		if($('input:radio[name=levelsEdit]:checked').val()=='level2Wdit')
			{
				$('#p_scentsEdit div').html('');
				$('div.visaInfoDiv').css('display','none');
			}
		if($('input:radio[name=levelsEdit]:checked').val()=='level1Wdit')
			{
				$('#level1Wdit').css('display','block');
				$('#level1Wdit :select').removeAttr('disabled');
				$('#level1Wdit :input').removeAttr('disabled');
				<?php if($visaAvailable!=''){ ?>
				$('#countyText').append('<div class="orng">Country</div>');
				$('#visaTypeText').append('<div class="orng">Visa Type</div>');
				<?php }?>
			}
			
	    val = val - 1;
	    for (var i=0; i < document.customForm.levelsEdit.length; i++){
		if(i==val){
           document.customForm.levelsEdit[i].checked = true;
	    }
    }
    for (var i=0; i < document.customForm.levelsEdit.length; i++){
     if (document.customForm.levelsEdit[i].checked)
        {
      var rad_val = document.customForm.levelsEdit[i].value;
         document.getElementById(rad_val).style.display = "block";
     }
    else{
     var rad_val = document.customForm.levelsEdit[i].value;
    document.getElementById(rad_val).style.display = "none";
     }
    }
	}
	</script>
