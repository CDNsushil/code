<?php $visaAvailableArr = array(
    'name'        => 'visaAvailable',
    'id'          => 'visaAvailable',
);

$educationDetail = json_decode($education);

$educationDetailArray = array();
$educationYearArray = array();
$educationUniversityArray = array();
$educationDegreeArray = array();
?>
<div class="row width100percent">
	<div class="label_wrapper cell">
		<label class="select_field">
			<?php echo $label['education']?>
		</label>
	</div>
	<div class=" cell frm_element_wrapper">
		<span id="addEducation" style="margin-right:4px">
			<span id='education_count' style="display:none">1</span>
			<span><div class="projectAddIcon formTip ptr" title ="<?php echo $label['addeducationInformation']?>" onclick="addEducation();"></div></span>
		</span>	
	</div>
</div><!-- end row-->

<div class="row width100percent">
<div class="empty_label_wrapper cell"></div>
<div class=" cell frm_element_wrapper">
	<div id="p_education"  class="educationInfoDiv formTip" title="<?php echo $label['addEducation']?>">	
	<div class="cell">
		<div class="orng" style="width:80px"><?php echo $label['year']?></div>
	</div>
	<div class="cell width180px">
		<div class="orng"><?php echo $label['university']?></div>
	</div>
	<div class="cell width180px">
		<div class="orng"><?php echo $label['degree']?></div>
	</div>
		<?php 
		//echo $WorkProfileRecord['education'];
		$yearArr = array();
		for($i=1962;$i <= date("Y");$i++)
		{
			$year[$i] = $i;
		}
		?>
		<div class="cell educationDetailId_1">
			<div class="cell">
			<div id="educationYear_12" class="profileDropDown">
				
						<select id="educationYear_1" name="educationYear[1]" >
							<option value=""><?php echo $label['selectYear']?></option>
							<?php foreach($year as $y) {
							$selected="Selected";
							?>
							<option value="<?php echo $y;?>"><?php echo $y?></option>
							<?php } ?>
						</select>
					
			</div>
			</div>
			<div class='tar fl ml10'>
					<input type="text" id="educationUniversity_1" size="12" name="educationUniversity[1]" class="formTip required" />
				<?php echo form_error($education['name']); ?>
				<?php echo isset($errors[$education['name']])?$errors[$education['name']]:''; ?>
				<span class="clear_seprator "></span>
			</div>
			<div  class="educationDegreeDiv">
				<input type="text" id="educationDegree_1" size="12" name="educationDegree[1]" class="formTip" />
				<?php echo form_error($education['name']); ?>
				<?php echo isset($errors[$education['name']])?$errors[$education['name']]:''; ?>
				<span class="clear_seprator "></span>
			</div>
			<div class="fr" >
				<a title="Remove" class="formTip ptr" onclick="removeEducationDetail(1)">
					<div class="projectDeleteIconEducation"></div>
				</a>
			</div>
		</div>
	</div>
	</div>
	</div>
<div class="clear_seprator"></div>
<script type="text/javascript">
function addEducation()
{
	var education_count_old = $('#education_count').html();
	education_count = Number(education_count_old)+Number(1);

	$('div.educationInfoDiv').css('display','block');  // Again Display:block the educationInfoDiv Div
	selectBox();
	$('<div class="removeID cell"><div class="cell profileDropDown"><select id="educationYear_'+education_count+'" name="educationYear['+education_count+']" ><option value="">Select Year</option><?php foreach($year as $y) { $selected="Selected"; ?><option value="<?php echo $y;?>"><?php echo $y?></option><?php } ?></select></div><div  class="fl tar ml10"><input type="text" id="educationUniversity_'+education_count+'" size="12" name="educationUniversity['+education_count+']" class="formTip required" /><span class="clear_seprator"></span></div><div class="fl tar ml10"><input type="text" id="educationDegree_'+education_count+'" size="12" name="educationDegree['+education_count+']" class="formTip" /><span class="clear_seprator "></span></div><div class="fr ml10" id="remEducation"><a class="formTip ptr" href="#" title="Remove"><div class="projectDeleteIconEducation"></div></a></div></div>').appendTo($('#p_education'));
	
	 selectBox();

	$('#education_count').html(education_count);

	$('#remEducation').live('click', function() {
		var conBox = confirm(areYouSure);
		if(conBox){
				var removeIdDiv =  $('.removeID').size();
				
				var mycountprojectDeleteIcon =  $('.projectDeleteIconEducation').size();
				
				$(this).parents('div .removeID').remove();

				if(removeIdDiv ==1 && mycountprojectDeleteIcon <=1){
				$('div.educationInfoDiv').css('display','none');
				}
			}
		else{
			return false;
		}
			return false;
	});
}

</script>
