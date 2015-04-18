<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
if(!isset($workProfileId) || $workProfileId==0)
{
?>
<div class="row opacity_4">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('education'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Education toggle Icon -->							
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="eduToggleIcon" toggleDivId="EDUCATION-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<?php
}
else{
		$formEduName = "addEducation";
		
		$formEduAttributes = array(
			'name'=>$formEduName,
			'id'=>$formEduName
		);
		
		$yearArr = array();
		for($i=1962;$i <= date("Y");$i++)
		{
			$year[$i] = $i;
		}
				
	$educationUniversity = array(
		'name'	=> 'university',
		'id'	=> 'educationUniversity',
		'class'	=> 'BdrCommon width_155 formTip eduInfoUpdate',
		'title'=>  $this->lang->line('university'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('university'),
		//'minlength'	=> 2,
		'maxlength'	=> 30,
		'size'	=> 20,
		'onchange' => 'checkUni();'
	);
	
	$educationDegree = array(
		'name'	=> 'degree',
		'id'	=> 'educationDegree',
		'class'	=> 'BdrCommon width_155 formTip eduInfoUpdate',
		'title'=>  $this->lang->line('degree'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('degree'),
		//'minlength'	=> 2,
		'maxlength'	=> 30,
		'size'	=> 20,
		'onchange' => 'checkDegree();'
	);

 $eduUrl = base_url(lang().'/workprofile/saveEducation');

?>
<?php //echo form_open(base_url(lang().'/workprofile/addEducation'),$formEduAttributes);  ?>

<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('education'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Education toggle Icon -->							
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="eduToggleIcon" toggleDivId="EDUCATION-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->	
<div class="clear"></div>
	<div id="EDUCATION-Content-Box" class="frm_strip_bg">		
	<div class="row"><div class="tab_shadow"></div></div>
		
			<input type="hidden" id="educationId" value="0" />
			<input type="hidden" id="replaceId" value="0" />

			<div class="row" id="eduDiv">	

				<div class="empty_label_wrapper cell"><?php //echo $this->lang->line('eduactionInformation');?></div>
				<!--label_wrapper-->
				<div class="cell frm_element_wrapper" style="display:block;">		
						<div class="cell ">
							<div class="small_select_wp_b">
								

								<select id="educationYear" name="educationYear" class="eduInfoUpdate  width_90" onchange ="checkYear();" >
									<option value=""><?php echo $this->lang->line('yearFrom');?></option>
								
									<?php foreach($year as $y) {
									$selected="Selected";
									?>
									<option value="<?php echo $y;?>"><?php echo $y?></option>
									<?php } ?>
								</select>
								<div id="eduYearError" class="dn"><label class="error"><?php echo $this->lang->line('requiredmSg');?></label></div>
							</div>
						</div>
										
					
						
						<div class="cell ">
							<div class="small_select_wp_a">
								
								<select id="educationYearTo" name="educationYearTo" class="eduInfoUpdate width_85" onchange ="checkDate()" >
									<option value=""><?php echo $this->lang->line('yearTo');?></option>
									<?php foreach($year as $y) {
									$selected="Selected";
									?>
									<option value="<?php echo $y;?>"><?php echo $y?></option>
									<?php } ?>
								</select>
								<div id="eduYearErrorTo" class="dn"><label class="error"><?php echo $this->lang->line('requiredmSg');?></label></div>
							</div>
						</div>
							
							
						
						<div class='tar fl width_155'>
							<div class="row"><?php echo form_input($educationUniversity); ?></div>
							<?php echo form_error($educationUniversity['name']); ?>
							<?php echo isset($errors[$educationUniversity['name']])?$errors[$educationUniversity['name']]:''; ?>
							<div id="eduUnivError" class="dn"><label class="error"><?php echo $this->lang->line('thisReqField');?></label></div>
						</div>
						<div class="cell widthSpacer">&nbsp;</div>
						<div  class="educationDegreeDiv width_155 pr2">
							<div class="row"><?php echo form_input($educationDegree); ?></div>
							<?php echo form_error($educationDegree['name']); ?>
							<?php echo isset($errors[$educationDegree['name']])?$errors[$educationDegree['name']]:''; ?>
							<div id="eduDegreeError" class="dn"><label class="error"><?php echo $this->lang->line('thisReqField');?></div>
						</div>
						<div class="cell widthSpacer">&nbsp;</div>
						
						<div class="cell cat_btn ml5">
						<?php
/*
							echo anchor('javascript://void(0);','<span><div id="addCatButton" class="cat_edit_icon eduInfoUpdate"></div></span>',array('class'=>'formTip go fl',
							'title'=>$this->lang->line('save').' '.$this->lang->line('education'),
							'onclick'=>"addEducation();"));	
							
							//echo '<div id="catCancel" class="dn">';
							echo anchor('javascript://void(0);','<span><div id="catCancel" class="cat_cross_icon"></div></span>',array('class'=>'formTip go fl dn',
							'title'=>$this->lang->line('cancel'),
							'onclick'=>"catCancel();",
							'id'=>'catCancel'
							));	*/
						?>
					</div>
				
				
				
				<div class="cell pt5">
						
						<div class="small_btn mr0">
							<?php
							echo anchor('javascript://void(0);','<span><div id="catCancel" class="cat_smll_cancel_icon"></div></span>',array('class'=>'formTip go fl dn',
							'title'=>$this->lang->line('cancel'),
							'onclick'=>"catCancel();",
							'id'=>'catCancel',
							'style'=>'display:none'
							));	 ?>
							
						</div>
						
						<div class="small_btn mr0">
							<?php
							echo anchor('javascript://void(0);','<span><div id="addCatButton" class="cat_smll_save_icon eduInfoUpdate" ></div></span>',array('class'=>'formTip go fl',
							'title'=>$this->lang->line('save'),
							'onclick'=>"addEducation();"));	?>
							
						</div>
						
					</div>
				
				
				
			 </div><!-- End insidecategory -->	
		</div><!--End categoryDiv-->
	
		<div id="EDUCATION-Content" style="display:block;" class="row">	
				
		<?php 
			//This shows posts related with blog
			echo Modules::run("workprofile/educationList",$workProfileId); 
		?>	

		<input type="hidden" id="countEducation" value="<?php echo $countEducation;?>" />
		<input type="hidden" id="delEducationId" name="delEducationId" value="" />

		</div>
		
		<div class="seprator_10 row"></div>
	
		<div class="clear"></div>
	</div>	


<script type="text/javascript">	

	//$(document).ready(function() {
	//$('.eduInfoUpdate').bind("keydown", function(l) {
	//console.log(l.keyCode);
	// if (l.keyCode == 13) {
	//	 addEducation();
	//   return true;
	//  } 
	//else 
	//{
	//return true;
	//}
	//});
	//});

	function checkUni()
	{
		if($('#educationUniversity').val()!='') $('#eduUnivError').hide();
		else $('#eduUnivError').show();
	}
	
	function checkYear()
	{
		if($('#educationYear').val()!='') $('#eduYearError').hide();
		else $('#eduYearError').show();
	}
	
	
	function checkDate()
	{
		
		var toYear = $('#educationYear').val();
		var fromYear =$('#educationYearTo').val();
		
		if(fromYear <= toYear)
		{
			alert("To must be greater ");
			setSeletedValueOnDropDown('educationYearTo','To');
			}
		
		
		
	}
	
	
	
	function checkDegree()
	{
		if($('#educationDegree').val()!='') $('#eduDegreeError').hide();
		else $('#eduDegreeError').show();
	}
	
	function addEducation()
	{ 					
		var DivID = 'educationInfo';
		var url = "<?php echo  $eduUrl ?>"; 
		var val1 = $('#educationId').val();  
		var val2 = $('<?php echo $workProfileId;?>').val();  
		var val3 = $('#educationYear').val();  
		var val4 = 'loadImg';  
		var val5 = $('#educationDegree').val();  
		var val6 = $('#educationUniversity').val();  
		var val7 = $('#replaceId').val();  				 
		var val8 = $('#educationYearTo').val();
		
		//alert(url);return false;
		
		if(val3=='') {
			$('#eduYearError').show();
			$('#educationYear').focus();
			$('#educationYear').addClass("required");
		}
		if(val8=='') {
			$('#eduYearErrorTo').show();
			$('#educationYearTo').focus();
			//$('#educationYear').addClass("required");
		}
		
		
		
		if(val5=='') {
			$('#eduDegreeError').show();
			$('#educationDegree').focus();
			//$('#educationDegree').addClass("required");
		}
		if(val6=='') {
			$('#eduUnivError').show();
			$('#educationUniversity').focus();
			//$('#educationUniversity').addClass("required");
		}
		
		if(val3 != '' && val5 != '' && val6 != '')
		{

			AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8);
			
			$('#educationId').attr('value',0);
			$('#educationYear').attr('value','');
			$('#educationUniversity').attr('value','');
			$('#educationUniversity').attr('value','');
			$('#educationDegree').attr('value','');
			if($('#addCatButton').hasClass('cat_smll_edit_icon'))
			{
				$('#addCatButton').removeClass('cat_smll_edit_icon');
				$('#addCatButton').addClass('cat_smll_save_icon');
			}
			selectBox();
			$('#workProEducation').show();	
			$('#catCancel').hide();	
		}
		else 
		{ 
			//alert('<?php echo  $this->lang->line('requiredMsg'); ?>');
			$('#educationYear').focus();
			$('#educationYearTo').focus();
		}

	}
		
	function catCancel()
	{
		$('#educationId').attr('value',0);
		$('#educationUniversity').attr('value','');
		$('#educationDegree').attr('value','');

		if($('#addCatButton').hasClass('cat_smll_edit_icon'))
		{
			$('#addCatButton').removeClass('cat_smll_edit_icon');
			$('#addCatButton').addClass('cat_smll_save_icon');
		}
		//selectBox();
		$('#catCancel').hide();
		setSeletedValueOnDropDown('educationYear','From');
		setSeletedValueOnDropDown('educationYearTo','To');
	}
	
	function removeEducationRow(removeId,flag)
	{
		var delEducationId = $('#delEducationId').attr("value");
		var catTitle = $('#delEducationId').attr("value");

		var userDelId = $('#useDelId_'+removeId).val();		
		
		if(flag==1)
		{
			alert('<?php echo  $this->lang->line('categoryRelated'); ?>');
			return false;
		}
		else
		{
			var conBox = confirm('<?php echo  $this->lang->line('categoryDelMsg'); ?>');
			if(conBox)
			{						
				if(delEducationId == '')
				{
					delEducationId = userDelId;
				}
				else 
					delEducationId = delEducationId+','+userDelId;
				
				$('#delEducationId').attr('value',delEducationId);
				
				$('#removeID_'+removeId).remove();
			
			}
			else
			{
				return false;
			}
		}		
	}

</script>
<?php
}//End If
?>
