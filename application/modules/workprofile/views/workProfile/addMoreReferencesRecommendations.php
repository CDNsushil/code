<?php
$refFNameArr = array(
	'name'	=> 'refFName',
	'id'	=> 'refFName',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'required width548px',
	
);

$refLNameArr = array(
	'name'	=> 'refLName',
	'id'	=> 'refLName',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'required width548px',
	
);

$refCompNameArr = array(
	'name'	=> 'refCompName',
	'id'	=> 'refCompName',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	
);

$refAddArr = array(
	'name'	=>'refAdd',
	'id'	=> 'refAdd',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refAdd'],
);

$refCountryArr = array(
	'name'	=>'refCountry',
	'id'	=> 'refCountry',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refCountry'],
);

$refStateArr = array(
	'name'	=>'refState',
	'id'	=> 'refState',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refState'],
);

$refCityArr = array(
	'name'	=>'refCity',
	'id'	=> 'refCity',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refCity'],
);


$refZipArr = array(
	'name'	=>'refZip',
	'id'	=> 'refZip',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refZip'],
);

$refDescriptionArr = array(
	'name'	=> 'refDescription',
	'id'	=> 'refDescription',
	'value'	=> '',
	'title' =>  $label['refDescription'],
	'cols' => 65,
	'rows' => 2,
	'class'       => 'width548px heightAuto rz required',
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descLimit')",
);

$refEmailArr = array(
	'name'	=> 'refEmail',
	'id'	=> 'refEmail',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'formTip width548px email',
	'title'       =>  $label['refEmail'],
);

$refContactArr = array(
	'name'	=>'refContact',
	'id'	=> 'refContact',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refContact'],
);

$refURLArr = array(
	'name'	=>'refURL',
	'id'	=> 'refURL',
	'value'	=> '',
	'size'	=> 30,
	'class'       => 'width548px',
	'title'       =>  $label['refURL'],
);

$mode  = array(
	'name'	=> 'mode',
	'value'	=> $mode,
	'id'	=> 'mode',
	'type'  => 'hidden',
	
);
?>
<div class="upload_media_left_top row"></div>
<?php
	$attributes = array('name' => 'customForm', 'id' => 'customForm');
	echo form_open('workprofile/addMoreReferencesRecommendations',$attributes);
	//echo '$workProfileId'.$workProfileId;
	echo form_hidden('workProfileId', $workProfileId);
	echo form_hidden('position', $position);
	echo form_input($mode);
?>
<div class="upload_media_left_box">
<input type="hidden" name="refId" value="0" id="refId"/>
<?php /*
<div class="row">
	<div class="label_wrapper cell bg-non"><div class="lable_heading"><h1 class="two_line_heading"><span id="RefTitle"><?php echo $label['add'];?></span> <?php echo $label['referencesRecommendation'];?></h1></div></div>
	
</div><!--row-->	
*/
?>
<div class="row form_wrapper">
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['refFName']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refFNameArr); ?>
			<?php echo form_error($refFNameArr['name']); ?>
			<?php echo isset($errors[$refFNameArr['name']])?$errors[$refFNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['refLName']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refLNameArr); ?>
			<?php echo form_error($refLNameArr['name']); ?>
			<?php echo isset($errors[$refLNameArr['name']])?$errors[$refLNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['refCompany']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refCompNameArr); ?>
			<?php echo form_error($refCompNameArr['name']); ?>
			<?php echo isset($errors[$refCompNameArr['name']])?$errors[$refCompNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	<?php /* Commented as per client's requirement
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refAdd']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refAddArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refCountry']; ?></label>
		</div><!--label_wrapper-->
		<?php
			$refCountryName = 'refCountry';
			$refCountryval ='';
		?>
		<div class="cell frm_element_wrapper">
			
					<?php echo form_dropdown($refCountryName , $countries, $refCountryval,'id="refCountry"'); ?>
				</div><!--bg_sel-->
			
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refState']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refStateArr); ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refCity']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refCityArr); ?>	
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refZip']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php
		echo form_input($refZipArr); ?>
		</div>
	</div><!--from_element_wrapper-->
 */ ?>
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refEmailAdd']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php
		echo form_input($refEmailArr); ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refPhone']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refContactArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	<?php /* Commented as per client's requirement
	<?php 
		///$value='';
		//$value=htmlentities($value);
		$data=array('name'=>'refDescription','value'=>'', 'view'=>'description');
		echo Modules::run("common/formInputField",$data);
	?>
	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['refURL']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($refURLArr); ?>
		</div>
	</div><!--from_element_wrapper-->
	*/ ?>
<!--
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['refDescription']; ?></label>
		</div>
		<div class=" cell frm_element_wrapper">
			<?php echo form_textarea($refDescriptionArr); ?>
			<div class="row wordcounter">
				<div class="fr" id="descLimit">
					<?php if($mode=='edit') {
							echo str_word_count($refDescription);
							} 
							else 
							{ 
							echo 0 ;
							}?>
				</div>
				<div class="fr mr5"><?php echo $label['totalWords']?></div>
				<?php echo form_error($refDescriptionArr['name']); ?>
				<?php echo isset($errors[$refDescriptionArr['name']])?$errors[$refDescriptionArr['name']]:''; ?>
			</div>
		</div>
	</div> -->
	<!--from_element_wrapper-->
	
	<?php //echo form_hidden('save','Save');?>
	<div class="cell">
	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields']?></div><!--Req_fld-->			
			<div class="frm_btn_wrapper padding-right0">
				<?php
					$button=array('save','cancelHide');
					echo Modules::run("common/loadButtons",$button); 
				?>
			</div>
		 <div class="fl pb5"><?php echo $label['afterReqMsg']?> </div>
		</div>
		</div>
	</div><!--from_element_wrapper-->
	<div class="clear"></div>
</div>
</div>
<?php echo form_close();?>
<div class="upload_media_left_bottom row"></div>
<div class="seprator_25 clear"></div>
