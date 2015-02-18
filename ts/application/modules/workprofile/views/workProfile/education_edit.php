<?php $visaAvailableArr = array(
    'name'        => 'visaAvailable',
    'id'          => 'visaAvailable',
);

$educationDetail = json_decode($education);

$educationDetailArray = array();
$educationYearArray = array();
$educationUniversityArray = array();
$educationDegreeArray = array();


//// Update Mode for Education ?>

<span class="clear_seprator "></span>
	<?php echo form_error($visaAvailableArr['name']); ?>
	<?php echo isset($errors[$visaAvailableArr['name']])?$errors[$visaAvailableArr['name']]:''; ?>
<div>
	<?php
		$educationDetailArray = object2array($educationDetail);
		$educationYearArray = object2array($educationDetailArray['educationYear']);
		$educationUniversityArray = object2array($educationDetailArray['educationUniversity']);
		$educationDegreeArray = object2array($educationDetailArray['educationDegree']);
		?>
<div class="row width100percent">
	<div class="label_wrapper cell">
		<label class="select_field">
			<?php echo $label['eduactionInformation']?>
		</label>
	</div>
	<div class=" cell frm_element_wrapper">
		<span id="educationScntEdit" style="margin-right:4px">
			<?php if(count($educationYearArray) !=0) {?><span id='education_count' style="display:none"><?php echo count($educationYearArray);?></span>
			<?php }else {?>
			<span id='education_count' style="display:none">1</span>
			<?php }?>
			<span><div class="projectAddIcon formTip ptr" title ="<?php echo $label['addeducationInformation']?>" ></div></span>
		</span>			
	</div>
</div>

<div class="row width100percent">
<div class="empty_label_wrapper cell"></div>
<div class=" cell frm_element_wrapper">

	<div id="p_educationScentsEdit" class="educationInfoDiv formTip" title="<?php echo $label['addEducation']?>">
	<div class="cell">
		<div class="orng" style="width:131px"><?php echo $label['year']?></div>
	</div>
	<div class="cell width180px">
		<div class="orng"  style="width:181px"><?php echo $label['university']?></div>
	</div>
	<div class="cell width180px">
		<div class="orng" style="width:131px"><?php echo $label['degree']?></div>
	</div>
	<?php 
		//echo $WorkProfileRecord['education'];
		$yearArr = array();
		for($i=1962;$i <= date("Y");$i++)
		{
			$year[$i] = $i;
		}
	?>
	<?php
		$x='';
		$profileEducationYear = 'educationYear[$x + count($educationYearArray)]'; 
		for($i=1;$i<=count($educationYearArray);$i++)
		{
			$educationYear = $educationYearArray[$i];
			$educationUniversity = $educationUniversityArray[$i];
			$educationDegree = $educationDegreeArray[$i];
		?>
		<div id="educationDetailId_<?php echo $i ?>" class="cell educationDetailId_<?php echo $i ?>">
			<div class="cell">
				<div id="educationYearId_<?php echo $i ?>" class="profileDropDown">
				
					<select id="educationYear_<?php echo $i ?>" name="educationYear[<?php echo $i ?>]" >
						<option value=""><?php echo $label['selectYear']?></option>
						<?php foreach($year as $y) {
						$selected="Selected";
						?>
						<option value="<?php echo $y;?>" <?php if($educationYear == $y) { echo $selected; } ?>><?php echo $y?></option>
					<?php } ?>
					</select>
				
					
				</div>
			</div>
			<div class="cell ml10">
				<input type="text" id="educationUniversity_1" size="12" name="educationUniversity[<?php echo $i ?>]" class="formTip required" value="<?php if(isset($educationUniversity)) { echo $educationUniversity; }?>" />
			</div>
			<div class="fl tar ml10">
				<input type="text" id="educationDegree_1" size="12" name="educationDegree[<?php echo $i ?>]" class="formTip" value="<?php if(isset($educationDegree)) { echo $educationDegree; }?>" />
				<span class="clear_seprator"></span>
			</div>
			<div class="floatRight-ml10">
				<a class="formTip ptr" title="Remove" onclick="removeEducationDetail(<?php echo $i ?>)">
					<div class="projectDeleteIconEducation"></div>
				</a>
			</div>
			<span class="clear_seprator "></span>
		</div>
		<?php } ?>
	</div>
</div>

</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	<?php if($workProfileId!=0 && $educationDetail =='') {?>
		$('div.educationInfoDiv').css('display','none');
	<?php }?>
});

$(document).ready(function() {
	if($('#editNo').is(':checked')== true){
		$('#level1Wdit :select').attr('disabled', true);
		$('#level1Wdit :input').attr('disabled', true);
	}
});
</script>
