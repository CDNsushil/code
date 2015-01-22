<?php

$compNameArr = array(
	'name'	=> 'compName',
	'id'	=> 'compName',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px required',
	
);

$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);


$empStartDateArr = array(
	'name'	=> 'empStartDate',
	'id'	=> 'empStartDate',
	'value'	=> '',
	'class' => 'width246px required formTip',
	//'dateGreaterThan'=>'#currentDate',
    'title' =>$this->lang->line('currentDateMsg'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'readonly' =>true
);



$empEndDateArr = array(
	'name'	=> 'empEndDate',
	'id'	=> 'empEndDate',
	'value'	=> '',
	'size'	=> 30,
	'class' => 'width246px required ',
	'monthYearGreaterThan'=>'#empStartDate',
  	'title' => 'The '.$label['empEndDate'].' must be after the '.$label['empStartDate'].'.', 
	'onChange'       => 'checkDate()',
	'readonly' =>true
);

$compAddArr = array(
	'name'	=>'compAdd',
	'id'	=> 'compAdd',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['compAdd'],
);

$compCountryArr = array(
	'name'	=>'compCountry',
	'id'	=> 'compCountry',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['compCountry'],
);

$compStateArr = array(
	'name'	=>'compState',
	'id'	=> 'compState',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['compState'],
);

$compCityArr = array(
	'name'	=>'compCity',
	'id'	=> 'compCity',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       => '',
);

$compPeriod = array(
	'name'	=>'period',
	'id'	=> 'period',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	
);

$compZipArr = array(
	'name'	=>'compZip',
	'id'	=> 'compZip',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['compZip'],
);

$compDescArr = array(
	'name'	=> 'compDesc',
	'id'	=> 'compDesc',
	'value'	=> '',
	'title'       =>  '',
	'cols' => 70,
	'rows' => 5,
	'class' => 'width548px heightAuto rz formTip required ',
);

$empAchivmentsArr = array(
	'name'	=> 'empAchivments',
	'id'	=> 'empAchivments',
	'value'	=> '',
	'title' => '',
	'cols' => 70,
	'rows' => 5,
	'class' => 'heightAuto rz required width548px',
	'style' => 'padding: 3px; border: 5px solid #000; height:150px; display:none',
);

$empDesignationArr = array(
	'name'	=> 'empDesignation',
	'id'	=> 'empDesignation',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px required',
);

$tillDate = array(
    'name'        => 'tillDate',
    'id'          => 'tillDate',
    'value'       => 'accept',
    'class'       => 'cell formTip',
	'style' =>'margin-top:7px;',
    );

$mode  = array(
	'name'	=> 'mode',
	'value'	=> $mode,
	'id'	=> 'mode',
	'type'  => 'hidden'	
);
?>


<script type="text/javascript">
  $(function () {
	  $('#empEndDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
  
  $(function () {
	  $('#empStartDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
  
  
</script>




<div class="row form_wrapper">
	<div class="upload_media_left_top row"></div>

<?php
	$attributes = array('name' => 'customForm', 'id' => 'customForm');
	echo form_open('workprofile/addMoreEmpHistory',$attributes);
	echo form_input($mode);
	echo form_hidden('workProfileId',$workProfileId);
	echo form_hidden('position', $position);
	
	
?>

<div class="upload_media_left_box">
<input type="hidden" name="empHistId" id="empHistId" value="0" />
<?php /*
<div class="row">
	<div class="label_wrapper cell bg-non"><div class="lable_heading"><h1 class="two_line_heading"><span id="EmpHistoryTitle"><?php echo $label['add'];?></span> <?php echo $label['employmentHistory'];?></h1></div></div>
	
</div><!--row-->	
*/?>

	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['compName']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($compNameArr); ?>
			<?php echo form_error($compNameArr['name']); ?>
			<?php echo isset($errors[$compNameArr['name']])?$errors[$compNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	<?php /* Commented as per client's requirement
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['compAdd']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php
			echo form_input($compAddArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['compCountry']; ?></label>
		</div><!--label_wrapper-->
		<?php
			$compCountryName = 'compCountry';
			if($mode=='edit')
				$compCountryval = $compCountry;
			else
				$compCountryval ='';
		?>
		<div class="cell frm_element_wrapper">
			
			<?php echo form_dropdown($compCountryName , $countries, $compCountryval,'id="country"'); ?>
				
		</div>
	</div><!--from_element_wrapper-->
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['compState']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($compStateArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	*/?>
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['townRcity']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($compCityArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['compCountry']; ?></label>
		</div><!--label_wrapper-->
		<?php
			$compCountryName = 'compCountry';
			if($mode=='edit')
				$compCountryval = $compCountry;
			else
				$compCountryval ='';
		?>
		<div class="cell frm_element_wrapper">
			
			<?php echo form_dropdown($compCountryName , $countries, $compCountryval,'id="compCountry"'); ?>
				
		</div>
	</div>
	
	
	
	
	
	<?php /* Commented as per client's requirement
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['compZip']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($compZipArr); ?>
		</div>
	</div><!--from_element_wrapper-->
 */ ?>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['empDesignation']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($empDesignationArr); ?>
			<?php echo form_error($empDesignationArr['name']); ?>
			<?php echo isset($errors[$empDesignationArr['name']])?$errors[$empDesignationArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['empStartDate']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="cell width270px">
			<?php echo form_input($currentDate); echo form_input($empStartDateArr); ?>
			<?php echo form_error($empStartDateArr['name']); ?>
			<?php echo isset($errors[$empStartDateArr['name']])?$errors[$empStartDateArr['name']]:''; ?>
			</div>
			
			<div class="cell" style="padding-top:5px;"><img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#empStartDate").focus();' /> </div>
		</div>
	</div><!--from_element_wrapper-->
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['empEndDate']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="cell width270px">
			<?php echo form_input($empEndDateArr); ?>
			<?php echo form_error($empEndDateArr['name']); ?>
			<?php echo isset($errors[$empEndDateArr['name']])?$errors[$empEndDateArr['name']]:''; ?>
			</div>
			
			<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#empEndDate").focus();' /> </div>
			<div id="endDateCHeckBoxDiv" class="dn">
				<div class="cell" >
					<div class="orng cell" style="width:55px;"><?php echo $label['currentDate']?></div>
				</div>
				<div class="cell defaultP mt2" onclick="javascript:checkBoxFunction();">
					<?php echo form_checkbox($tillDate); ?>
				</div>
			</div>
		</div>		
	</div><!--from_element_wrapper-->

	<?php /* DESCRIPTION
		$value='';
		$value=htmlentities($value);
		$data=array('name'=>'compDesc','value'=>$value, 'view'=>'description','addclass' => 'width548px',);
		echo Modules::run("common/formInputField",$data);
	*/ ?>
		
	

	<div class="row">
		<div class="label_wrapper cell">
			<?php echo form_label($label['description'], $empAchivmentsArr['id']); ?>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper width560px NIC">
			<div id="myNicPanel" class="cell bdr_e2e2e2 tmailtop_gradient p15 width_530px"></div>
			<div id="myInstance1" class="editordiv frm_Bdr width540px" title="<?php echo $label['compDesc'];?>">
				<?php //echo html_entity_decode($empAchivments);?>
			</div>
	
			<?php echo form_textarea($empAchivmentsArr); ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="cell">
	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">

			<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields')?></div><!--Req_fld--><div class="clear"></div>
                       <div class="fl pb5"><?php echo $label['afterReqMsg']?> </div>

			
			<div class="frm_btn_wrapper padding-right0">
							
				<?php
				$button=array('saveOnClick','cancelHide');
				echo Modules::run("common/loadButtons",$button); 
				?>				
			</div>
			
			
			
			
		</div>
		</div>
	</div><!--from_element_wrapper-->
	
	</div>
	<?php echo form_close(); ?>
	
	<div class="clear"></div>
	<div class="upload_media_left_bottom row"></div>
</div>

<script type="text/javascript">
function calcelForm()
{
	location.href=baseUrl+language+"/workprofile/empHistoryListing";
}

function submitform()
{
	var divContent = $.trim($('#myInstance1').html());		
	$('#empAchivments').val(divContent);
	return true;
}

$(document).ready(function() {
	
	 if($('#tillDate').is(':checked')==true){
	 $('#empEndDate').attr('disabled','disabled');
	 }
});
</script>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		   var myNicEditor = new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul']});
			myNicEditor.setPanel('myNicPanel');
			myNicEditor.addInstance('myInstance1');
    });
    
	function checkDate()
	{
		var flag ;
		var start_date = document.getElementById("empStartDate").value;
		var end_date = document.getElementById("empEndDate").value;
		if(start_date ==''){
			alert(fillStartDate);
			$("#empStartDate").addClass("error");
			flag 	= false;
		}
		if($('#tillDate').is(':checked')==false)
		{
			if(start_date ==''){
				//alert(fillEndDate);
				$("#empEndDate").addClass("error");
				flag 	= false;
			}
			var yr1  = parseInt(start_date.substring(0,4),10);		
			var mon1 = parseInt(start_date.substring(5,7),10);
			var dt1  = parseInt(start_date.substring(8,10),10);
			var yr2  = parseInt(end_date.substring(0,4),10);
			var mon2 = parseInt(end_date.substring(5,7),10);
			var dt2  = parseInt(end_date.substring(8,10),10);		
			var date1_val = new Date(yr1, mon1, dt1);
			var date2_val = new Date(yr2, mon2, dt2);
			if(date1_val <= date2_val)
			{
				flag 	= true;
			}else
			{
				//alert(endDateCheck);
				$("#empEndDate").addClass("error");
				flag 	= false;
			}
		}
		return flag;
	}
function checkBoxFunction() {
	var currentTime = new Date()
	var month = currentTime.getMonth()+1;
	var day = currentTime.getDate();
	var year = currentTime.getFullYear();
	var tillDate = (day + "-" + month + "-" + year)	
	if($('#tillDate').is(':checked')){
		$('#empEndDate').attr('disabled','disabled');
	}else{
		$('#empEndDate').removeAttr('disabled');
	}
}
	

</script>

