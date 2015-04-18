<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
	var baseurl = "<?php print base_url(); ?>";
	
	$(document).ready(function(){
		$("#workProfileForm").validate({});
	});

</script>

<?php 
$profileImgPath = '';
$profileImgName = '';
if($fileId > 0){
	$mediaDetail = getMediaDetail($fileId);
	if(!empty($mediaDetail))
	{
		$profileImgPath = $mediaDetail[0]->filePath;
		$profileImgName = $mediaDetail[0]->fileName;
	}
}

$monthArr = array();
for($i=1;$i <= 12;$i++)
{
	$month[$i] = $i;
}
?>

<script type="text/javascript">
bkLib.onDomLoaded(function() {
var myNicEditor = new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul']});
myNicEditor.setPanel('myNicPane2');
myNicEditor.addInstance('myInstance2');
});
</script>

<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1>Personal Details</h1>
		</div>
		<?php include('navigationMenu.php');?>
	</div>

<?php
$profileImgPath = array(
	'name'	=> 'profileImgPath',
	'id'	=> 'profileImgPath',
	//'value'	=> set_value('profileImgPath',$profileImgPath']),
	'size'	=> 30,
	'class'       => 'width556px',
	
);

$profileFNameArr = array(
	'name'	=> 'profileFName',
	'id'	=> 'profileFName',
	'value'	=> $profileFName,
	'size'	=> 30,
	'maxlength' => 80,
	'class'       => 'width556px required',
	
);

$profileLNameArr = array(
	'name'	=> 'profileLName',
	'id'	=> 'profileLName',
	'value'	=> set_value('profileLName',$WorkProfile['profileLName']),//,set_value('profileFName',$WorkProfile['profileFName']);
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'width556px',
);

$profileAddArr = array(
	'name'	=> 'profileAdd',
	'id'	=> 'profileAdd',
	'value'	=> $profileAdd,
	'size'	=> 30,
	'maxlength' => 80,
	'class' => 'width556px ',
	
);

$profileStreetArr = array(
	'name'	=> 'profileStreet',
	'id'	=> 'profileStreet',
	'value'	=> $profileStreet,
	'size'	=> 30,
	'maxlength' => 80,
	'class' => 'width556px',
	
);
$profileZipArr = array(
	'name'	=> 'profileZip',
	'id'	=> 'profileZip',
	'value'	=> $profileZip,
	'size'	=> 30,
	'maxlength' => 80,
	'class'       => 'width556px',
	
);

$profileCityArr = array(
	'name'	=> 'profileCity',
	'id'	=> 'profileCity',
	'value'	=> $profileCity,
	'size'	=> 30,
	'maxlength' => 80,
	'class'	 => 'width556px',
	
);

$profileStateArr = array(
	'name'	=> 'profileState',
	'id'	=> 'profileState',
	'value'	=> $profileState,
	'size'	=> 30,
	'maxlength' => 80,
	'class' => 'width556px',
	
);

$profileEmailArr = array(
	'name'	=> 'profileEmail',
	'id'	=> 'profileEmail',
	'value'	=> $profileEmail,
	'size'	=> 30,
	'class'       => 'width556px email',
	
);

$profilePhoneArr = array(
	'name'	=> 'profilePhone',
	'id'	=> 'profilePhone',
	'value'	=> $profilePhone,
	'size'	=> 30,
	'maxlength' => 15,
	'class'       => 'width556px',
	
);

$synopsisArr = array(
	'name'	=> 'synopsis',
	'id'	=> 'synopsis',
	'value'	=> $synopsis,
	'class'       => 'width556px formTip rz f12  required',
	'title'       => $label['summaryTip'],
	'rows' => '2',
	'cols' => '25',
	'style' => 'height:80px;',
);

$languagesKnownArr = array(
	'name'	=> 'languagesKnown',
	'id'	=> 'languagesKnown',
	'value'	=> $languagesKnown,
	'size'	=> 30,
	'class'       => 'width556px ',
	
);

$nationalityArr = array(
	'name'	=> 'nationality',
	'id'	=> 'nationality',
	'value'	=> $nationality,
	'size'	=> 30,
	'class'       => 'width556px ',
	
);

$noticePeriodArr = array(
	'name'	=> 'noticePeriod',
	'id'	=> 'noticePeriod',
	'value'	=> $noticePeriod,
	'size'	=> 30,
	'class'       => 'width556px ',
	
);

$remunerationRequiredArr = array(
	'name'	=> 'remunerationRequired',
	'id'	=> 'remunerationRequired',
	'value'	=> $remunerationRequired,
	'size'	=> 30,
	'class'       => 'width_273 mr15 ',
	
);

$educationArr = array(
	'name'	=> 'education',
	'id'	=> 'education',
	'value'	=> $education,
	'cols' => 25,
	'rows' => 2,
	'class' => 'width556px',
	'title'       =>  $label['education'],
	
);

$achievmentsAndAwardsArr = array(
	'name'	=> 'achievmentsAndAwards',
	'id'	=> 'achievmentsAndAwards',
	'value'	=> $achievmentsAndAwards,
	'size'	=> 30,
	'cols' => 70,
	'rows' => 5,
	'class' => 'textarea workProfileAchievmentsAndAwards',
	'title' =>  '',
);

$userfile =	array(
	'name'        => 'userfile',
	'id'          => 'profileImgPath',
);

$countriesIntrestedIdInput = array(
	'name'	=> 'countriesInterestWorking',
	'id'	=> 'countriesInterestWorking',
	'type'	=> 'hidden',
	'value'	=> $countriesInterestWorking
);

$isContractMonthFillInput = array(
	'name'	=> 'isContractMonthFill',
	'id'	=> 'isContractMonthFill',
	'type'	=> 'hidden',
	'value'	=> ''
);

$isContractWorkInput = array(
	'name'	=> 'isContractWork',
	'id'	=> 'isContractWork',
	'type'	=> 'hidden',
	'value'	=> $isContractWork,
);

if(isset($isContractWork) && $isContractWork=='t'){ 
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
	
$minimumMonthInput = array(
	'name'	=> 'minContractMonth',
	'id'	=> 'minContractMonth',
	'value'	=> $minContractMonth,
	'size'	=> 30,
	'maxlength' => 80,
	'class'     => 'width250px numeric',
	'placeholder' => 'Minimum Month',
	
);

$maximumMonthInput = array(
	'name'	=> 'maxContractMonth',
	'id'	=> 'maxContractMonth',
	'value'	=> $maxContractMonth,
	'size'	=> 30,
	'maxlength' => 80,
	'class'     => 'width250px numeric',
	'placeholder' => 'Maximum Month',
	
);	

$profileImg = '';
if($fileId > 0)
{
	$profileImg = 'media/'.LoginUserDetails('username').'/workProfile/'.$profileImgName;
	$profileImg = addThumbFolder($profileImg,'_s','thumb',$this->config->item('defaultImg'));	
}

$finalSmallImg = getImage($profileImg,$this->config->item('defaultImg'));

$attr = array("name"=>'workProfileForm','id'=>'workProfileForm');

echo form_open_multipart('workprofile/workProfileForm',$attr);

?>

<div class="row position_relative">

<?php

echo Modules::run("common/strip");

if(!isset($workProfileId) || $workProfileId =='') $workProfileId=0;
echo form_hidden('workProfileId',$workProfileId);
echo form_hidden('fileId',$fileId);
echo form_hidden('tdsUid',$tdsUid);

		$img = '<img id="imgSrc" class="ma backgroundBlack" src="'.$finalSmallImg.'" />';
		
		$fileUpload = array(
			'name'	=> 'userfile',
			'class'	=> 'formTip btn_browse',
			'title'=>  'Upload Image file',
			'value'	=> '',
			'accept'=> $this->config->item('imageAccept'),
			'onchange'=> "$('#fileInput').val(this.value)",
			'onmousedown'=> "mousedown_tds_button(getElementById('browse_btn'));",
			'onmouseup'=> "mouseup_tds_button(getElementById('browse_btn'));"
		);
		
		$inputArray = array(
			'name'	=> 'fileInput',
			'class'	=> 'width300px fl',
			'value'	=> '',
			'id'	=> 'fileInput',
			'type'	=> 'text',
			'readonly' => true,
			
		);
		
		echo Modules::run("mediatheme/promoImageForm",$label['image'],$img ,$fileUpload,$inputArray,0);
		
	?>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['profileFName'] ;//echo $this->lang->line('name'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
		<?php echo form_input($profileFNameArr); ?>
		<?php echo form_error($profileFNameArr['name']); ?>
		<?php echo isset($errors[$profileFNameArr['name']])?$errors[$profileFNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<!--As per client requirement-->
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['profileLName']; ?></label>
		</div>
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profileLNameArr); ?>
			<?php echo form_error($profileLNameArr['name']); ?>
			<?php echo isset($errors[$profileLNameArr['name']])?$errors[$profileLNameArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('address1'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profileAddArr); ?>
			<?php echo form_error($profileAddArr['name']); ?>
			<?php echo isset($errors[$profileAddArr['name']])?$errors[$profileAddArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('address2'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profileStreetArr); ?>
			<?php echo form_error($profileStreetArr['name']); ?>
			<?php echo isset($errors[$profileStreetArr['name']])?$errors[$profileStreetArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
		
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('twnRcity'); ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<?php echo form_input($profileCityArr); ?>
			<?php echo form_error($profileCityArr['name']); ?>
			<?php echo isset($errors[$profileCityArr['name']])?$errors[$profileCityArr['name']]:''; ?>
		</div>
	</div><!-- row -->	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('state'); ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<?php echo form_input($profileStateArr); ?>
			<?php echo form_error($profileStateArr['name']); ?>
			<?php echo isset($errors[$profileStateArr['name']])?$errors[$profileStateArr['name']]:''; ?>
		</div>
	</div><!-- row -->
	
	<?php
	$profileCountryName = 'profileCountry';
	$profileCountryval = $profileCountry;
	?>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['zipcode']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profileZipArr); ?>
			<?php echo form_error($profileZipArr['name']); ?>
			<?php echo isset($errors[$profileZipArr['name']])?$errors[$profileZipArr['name']]:''; ?>
		</div>
	</div><!-- row -->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('country'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">						
			<?php 
			 echo form_dropdown($profileCountryName , $countries, set_value($profileCountryName , ( ( !empty($profileCountryval) ) ? "$profileCountryval" : 0 )),'id="country"' );
			 echo form_error($profileCountryName); 
			?>			
		</div>
	</div><!-- row -->
	
		
		<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('emailAddress'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profileEmailArr); ?>
			<?php echo form_error($profileEmailArr['name']); ?>
			<?php echo isset($errors[$profileEmailArr['name']])?$errors[$profileEmailArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('phoneNo'); ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($profilePhoneArr); ?>
			<?php echo form_error($profilePhoneArr['name']); ?>
			<?php echo isset($errors[$profilePhoneArr['name']])?$errors[$profilePhoneArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
<div class="seprator_25 cell"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['summary']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_textarea($synopsisArr); ?>
			<?php echo form_error($synopsisArr['name']); ?>
			<?php echo isset($errors[$synopsisArr['name']])?$errors[$synopsisArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->	
	<div class="seprator_25 cell"></div>
	
	<!--Intrested country section start-->
	<div class="row">
		<div class="cell label_wrapper height_50"><label class="select_field"><?php echo $this->lang->line('intrestedCountry');?></label></div>
		<!-- Day -->
		<div class="cell frm_element_wrapper mt8">
			<div class="row pt5">			
				<div class="cell defaultP">
				  <input type="radio" <?php if(empty($countriesInterestWorking)) echo 'checked';?> value="0"  name="intrestedCountryType" onclick="$('#intrestCountryDiv').hide();" />
				</div>
				
				<div class="cell mr20">
				  <label class="lH25"><?php echo $this->lang->line('allIntrestedCountry');?></label>
				</div>
				
				<div class="cell defaultP">
				  <input type="radio" value="1" <?php if(!empty($countriesInterestWorking)) echo 'checked';?> name="intrestedCountryType" onclick="$('#intrestCountryDiv').show();" />
				</div>
				
				<div class="cell mr20">
				  <label class="lH25"><?php echo $this->lang->line('upTOThreeCountry');?></label>
				</div>
			</div>
		</div>
	</div>
	<?php if(!empty($countriesInterestWorking)){$dn='';} else{$dn='dn';} ?>
	<div class="row <?php echo $dn;?>" id="intrestCountryDiv">
		<div class="cell label_wrapper bg-non"></div>
		<!-- Day -->
		<div class="cell frm_element_wrapper">
			<?php $this->load->view('workProfile/countryForm');?>
		</div>
	</div>
	<!--Intrested country section end-->	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['availability']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			
					<select name="availability" id="availability">
						<option value=""><?php echo $label['selectAvailability'] ?></option>
						
						<option value="freelance" <?php if($availability!='') { if($availability=='freelance') { echo "selected"; } }?>><?php echo $label['freelance'] ?></option>
						
						<option value="fullTime" <?php if($availability!='') { if($availability=='fullTime') { echo "selected"; } }?>><?php echo $label['fulltime'] ?></option>
						<option value="partTime" <?php if(($availability) !='') { if($availability=='partTime') { echo "selected"; } }?>><?php echo $label['parttime'] ?></option>
						
						
						<option value="casual" <?php if(($availability) !='') { if($availability=='casual') { echo "selected"; } }?>><?php echo $label['casual'] ?></option>
						
					</select>
				
			<?php echo form_error($availability); ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<?php if((isset($isContractWork) && $isContractWork=='t') || (!empty($availability))){$dn='';} else{$dn='dn';} 
	if(isset($availability)) {
		$availability = ($availability=='freelance')?"Freelance":($availability=='fullTime'?"Full - Time":($availability=='partTime'?"Part - Time":($availability=='casual'?"Casual":'')));
		$availLabel = $availability . ' from 3 to 6 months.';
	}else {
		$availLabel = '';
	}
	if(isset($isContractWork) && $isContractWork=='t'){$workMsgDn='';} else{$workMsgDn='dn';} 
	?>
	<!--start row for contract work -->
	<div class="row <?php echo $dn;?>" id="contractWorkAvail">
		<div class="label_wrapper cell">
			<label><?php echo $this->lang->line('contractWork'); ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="row mt8">
				<div class="cell defaultP">
					<?php echo form_checkbox($contractWorkInput);?>	
				</div>
				
				<div class="cell <?php echo $workMsgDn;?>" id="contractWorkMsg">
					<?php //echo $availLabel;?>
					<!--<div class="cell" id="availWorkMsg"></div>-->
					<div class="cell mt-4 width_120px">
						<div class="small_select_wp_b">
							<select id="minContractMonth" name="minContractMonth" class="eduInfoUpdate  width_90" >
								<option value=""><?php echo $this->lang->line('yearFrom');?></option>
							
								<?php foreach($month as $m) {
								$selected="Selected";
								?>
								<option value="<?php echo $m;?>" <?php if($minContractMonth == $m) { echo "selected"; }?>><?php echo $m?></option>
								<?php } ?>
							</select>
							<?php echo form_error($minimumMonthInput); ?>
						</div>
						<div id="minContractMonthError" class="dn"><label class="error"><?php echo $this->lang->line('fromMustLower');?></label></div>
					</div>
					<!--<div class="cell">to</div>-->
					<div class="cell mt-4">
						<div class="small_select_wp_b">
							<select id="maxContractMonth" name="maxContractMonth" class="eduInfoUpdate  width_90" >
								<option value=""><?php echo $this->lang->line('yearTo');?></option>
							
								<?php foreach($month as $m) {
								$selected="Selected";
								?>
								<option value="<?php echo $m;?>" <?php if($maxContractMonth == $m) { echo "selected"; }?>><?php echo $m?></option>
								<?php } ?>
							</select>
							<?php echo form_error($maximumMonthInput); ?>
						</div>
						<div id="maxContractMonthError" class="dn"><label class="error"><?php echo $this->lang->line('toMustGreater');?></label></div>
					</div>
					<div class="cell mt3">Months</div>		
				</div>
			</div>
		</div>	
	</div><!-- row -->
	<!--end row for contract work -->
	<?php //if(!empty($minContractMonth) && !empty($maxContractMonth)){$dn='';} else{$dn='dn';} ?>
	<!--<div class="row <?php //echo $dn;?>" id="contactWork">
		<div class="label_wrapper cell">
			<label class="select_field"><?php //echo $this->lang->line('contractWorkDuration'); ?></label>
		</div>--><!--label_wrapper-->
		
			<!--<div class=" cell frm_element_wrapper">
			<div class="Fleft">
			<?php  //echo form_input($minimumMonthInput);?>
			<?php //echo form_error($minimumMonthInput['name']); ?>
			<div id="minMonthError" class="dn"></div>
			</div>
			
			<div class="Fright wpform_select mr_minus10">
				<?php  //echo form_input($maximumMonthInput);?>
				<?php  //echo form_error($maximumMonthInput['name']);?>
				<div id="maxMonthError" class="dn"></div>
			</div>
		</div>
	</div>--><!--from_element_wrapper-->
	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['noticePeriod']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($noticePeriodArr); ?>
			<?php echo form_error($noticePeriodArr['name']); ?>
			<?php echo isset($errors[$noticePeriodArr['name']])?$errors[$noticePeriodArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo 'Remuneration'; ?></label>
		</div><!--label_wrapper-->
		
		<div class=" cell frm_element_wrapper">
			<div class="Fleft ">
			<?php  echo form_input($remunerationRequiredArr);
			 $remunerationRateArr['name'] = 'remunerationRate'; ?>

			 <?php echo form_error($remunerationRequiredArr['name']); ?>
			 <?php echo isset($errors[$remunerationRequiredArr['name']])?$errors[$remunerationRequiredArr['name']]:''; ?>
			 </div>
			 <div class="Fright wpform_select mr_minus10">
			 <select name="remunerationRate" id="remunerationRate" class="error ">
						<option value=""><?php echo $label['selectPeriod']?></option>
						<option value="1" <?php if($remunerationRate!='') { if($remunerationRate=='1') { echo "selected"; } }?>>
						<?php echo $label['perannum'] ?></option>
						<option value="2" <?php if(($remunerationRate) !='') { if($remunerationRate=='2') { echo "selected"; } }?>><?php echo $label['perMonthly'] ?></option>
						<option value="3" <?php if(($remunerationRate) !='') { if($remunerationRate=='3') { echo "selected"; } }?>><?php echo $label['perWeekly'] ?></option>
						<option value="4" <?php if(($remunerationRate) !='') { if($remunerationRate=='4') { echo "selected"; } }?>><?php echo $label['perHourly'] ?></option>
					</select>
				</div>
			<?php form_error($remunerationRateArr['name']); ?>
		</div>
	</div><!--from_element_wrapper-->
<div class="seprator_15 cell"></div>

   <div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['languages']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($languagesKnownArr); ?>
			<?php echo form_error($languagesKnownArr['name']); ?>
			<?php echo isset($errors[$languagesKnownArr['name']])?$errors[$languagesKnownArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_3 cell"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['nationality']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($nationalityArr); ?>
			<?php echo form_error($nationalityArr['name']); ?>
			<?php echo isset($errors[$nationalityArr['name']])?$errors[$nationalityArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<div class="row">
		<div class="label_wrapper cell">
			<label ><?php echo $label['achievmentsAndAwards']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper NIC">
			<div id="myNicPane2" class="cell bdr_e2e2e2 tmailtop_gradient p15 width_536px"></div>
			<div id="myInstance2" class="editordiv frm_Bdr minHeight200px width_545">
				<?php echo html_entity_decode($achievmentsAndAwards);?>				
				<?php echo form_error($achievmentsAndAwardsArr['name']); ?>
				<?php echo isset($errors[$achievmentsAndAwardsArr['name']])?$errors[$achievmentsAndAwardsArr['name']]:''; ?>
			</div>			
		</div>
		<?php echo form_textarea($achievmentsAndAwardsArr); ?>
	</div><!--from_element_wrapper-->
<?php 	echo form_hidden('save','Save');
		echo form_input($countriesIntrestedIdInput);
		echo form_input($isContractMonthFillInput);
		echo form_input($isContractWorkInput);
		?>
	<div class="cell pagingWrapper">
	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields']?></div><!--Req_fld-->
          
			<div class="frm_btn_wrapper padding-right0">
			
				<?php
					$button=array('saveOnClick','cancelForm');
					echo Modules::run("common/loadButtons",$button); 
				?>	
				 <div class="fl pb5"><?php echo $label['afterReqMsg']?> </div>							
				<div class="seprator_5 cell"></div>
					
			</div>
			</div>
		</div>
	</div><!--from_element_wrapper-->

<div class="clear"></div>
	
</div>
	
<?php echo form_close(); ?>
</div>
<?php	
	
	//Education Information
	echo Modules::run("workProfile/addEducation",$workProfileId);
	
	//Visa Detail Section
	echo Modules::run("workProfile/visaDetailSection",$workProfileId);
	
?>
<script type="text/javascript">

//Check whether to submit the form or not

function CheckForm(event)
{

	var visaCountryId = document.getElementById('visaCountryId');
	var visaType = document.getElementById('visaType');
	var educationYear = document.getElementById('educationYear');
	var educationDegree = document.getElementById('educationDegree');
	var educationUniversity = document.getElementById('educationUniversity');
		
	if((document.activeElement == visaCountryId)||(document.activeElement == visaType)||(document.activeElement == educationYear)||(document.activeElement == educationDegree)||(document.activeElement == educationUniversity))
	{
		return false;
	}
	else 
		submitform();
}


function calcelForm()
{
	location.href=baseUrl+language+"/workprofile";
}

$('#BrowserHidden').bind('change', function() {
	
var ext = $('#FileField').val().split('.').pop().toLowerCase();
if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
{
    alert('Only gif,png,jpg,jpeg extensions are allowed');
	$('#BrowserHidden').attr({ value: '' }); 
	$('#FileField').attr({ value: '' }); 
}
});

function submitform()
{
	
	<?php if(!$fileId >0) { ?>
		if($('#FileField').val() ==''){
			//alert('test');
			alert('You did not select a file to upload');
			return false;
		}else
		{
			var divContent = $.trim($('#myInstance2').html());			
			$('#achievmentsAndAwards').attr({ value:divContent });
			return true;
		}
	<?php } else { ?>
	
				var divContent = $.trim($('#myInstance2').html());
				$('#achievmentsAndAwards').attr({ value:divContent });
				return true;
		<?php 
	} ?>
}
$(document).ready(function(){	
	$("#contractWork").click(function(){
		if($('#contractWork').is(':checked') === true) {
			$('#contractWorkMsg').show();
			$('#isContractWork').val(1);
			//$('#contactWork').show();
		} else {
			$('#contractWorkMsg').hide();
			$('#isContractWork').val(0);
			//$('#contactWork').hide();
			//$('#isContractMonthFill').val(0);
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
	
	//Check contract months status on submit
	$("#saveButtonCommon").click(function(){
		var isContractMonthFill = $('#isContractMonthFill').val();
		var minContractVal = $("#minContractMonth").val();
		var maxContractVal = $("#maxContractMonth").val();
		
		if($('#contractWork').is(':checked') === false) {
				$('#minContractMonth').val('');
				$('#maxContractMonth').val('');
		}else {
			if(minContractVal=='' || maxContractVal=='') {
				alert('Please fill Interested in Contract Work durations.');
				return false;
			}
		}
		//if(isContractMonthFill==1) {
		//	return false;
		//}
	});
	
	//Manage after availability change
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

</script>


