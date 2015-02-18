<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$projId;$projTitle;$proShortDesc;$projTag;$projDescription;$projGenre;$projLanguage;$projRating;$projCreateDate;$projPublisheDate;$projEntryTime;$projStatus;$projIndustry;$projCountry;$projCity;$projReleaseDate;$projAddress;$projStreet;$projZip;$isEducationMaterial;$isEvent;$askForDonation;$projType;$mode;

?>

<?php
$formAttributes = array(
	'name'=>'customForm',
	'id'=>'customForm'
);
$projTitle = array(
	'name'	=> 'projTitle',
	'id'	=> 'projTitle',
	'class'	=> 'Bdr2 formTip required error',
	'title'	=> 'Title',
	'value'	=> $projTitle,
	'placeholder'	=> 'Title',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$proShortDesc = array(
	'name'	=> 'proShortDesc',
	'id'	=> 'proShortDesc',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  'One Line Description',
	'value'	=> $proShortDesc,
	'wordlength'=>"5,30",
	'onkeyup'=>"getRemainingLen(this,30,'descriptionLimit')",
	'placeholder'	=> 'One Line Description',
	'rows'	=> 2
);

$projTag = array(
	'name'	=> 'projTag',
	'id'	=> 'projTag',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  'Tags',
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'tagLimit')",
	'value'	=> $projTag,
	'placeholder'	=> 'Tags',
	'rows'	=> 5
);

$projDescription = array(
	'name'	=> 'projDescription',
	'id'	=> 'projDescription',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  'Description',
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'description')",
	'value'	=> $projDescription,
	'placeholder'	=> 'projDescription',
	'rows'	=> 5
);

$projIndustry = array(
	'name'	=> 'projIndustry',
	'id'	=> 'projIndustry',
	'value'	=> set_value('projIndustry'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Industry',
);

?>
<?php //echo $header;?>
		<!-- TOP NAVIGATION-->
	<span class="clear_seprator "></span>
	<div class="title-content" style="width:775px">
		<div class="title-content-left">
			<div class="title-content-right">
				<div class="title-content-center">
					<div class="title-content-center-label">Project Related Information </div>
					<div class="tds-button-top">
						<?php 
							//$locationRedirect = 'product/sell';
							//$lableAdd = '<span style="width:40px;">Back</span>';
							//echo anchor($locationRedirect,$lableAdd,array('title'=>'Back',"class"=>"formTip"));
						?>
					</div><!-- End tds-button-top-->
				<div class="clearfix" > </div>
				</div><!-- End title-content-center-->
			</div><!-- End title-content-right-->
		</div><!-- End title-content-left-->
	</div><!-- End title-content-->         
<span class="clear_seprator "></span>
<div class="frm_wp">
	<?php
	echo form_open_multipart('',$formAttributes); ?>
		<div class="row">
			<div class="cell orng_lbl">Project Title</div>
			<div class="cell" >
				<?php echo form_input($projTitle); ?>
				<div class="red"><?php echo form_error($projTitle['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"></span></div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
			<div class="cell orng_lbl">One Line Description</div>
			<div class="cell" >
			  <?php echo form_textarea($proShortDesc); ?>
			  <div class="red"><?php echo form_error($proShortDesc['name']); ?></div>
			<div class="remainingLimit fl" id="descriptionLimit"></div>
			<div class="fl">dasds</div>
			</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
			<div class="cell orng_lbl">Tags</div>
			<div class="cell" >
			   <?php echo form_textarea($projTag); ?>
			  <div class="red"><?php echo form_error($projTag['name']); ?></div>
			  <div class="remainingLimit fl" id="tagLimit"></div> 
			  <div class="fl">Words Remaining</div>
			</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="row">
			<div class="cell orng_lbl">Description</div>
			<div class="cell" >
			   <?php echo form_textarea($projDescription); ?>
			  <div class="red"><?php echo form_error($projDescription['name']); ?></div>
			<div class="remainingLimit fl" id="description">
			</div> <div class="fl">words Remaining</div>
			</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>
		<div class="orng">Industry</div>
		<?php	$projIndustryName = "projIndustry"; 
		$projIndustryVal='';?>
		<?php
			echo form_dropdown($projIndustryName, $industry, $projIndustryVal ,'id="projIndustry"','class="single"');
		?>
	 <?php echo form_error($projIndustry['name']); ?>
		 <?php echo isset($errors[$projIndustry['name']])?$errors[$projIndustry['name']]:''; ?>
		<div class="row heightSpacer"> &nbsp;</div>
		
		
		
		<div class="Btn_wp">
			<div class="btn_wp" style="padding-left:145px;">
				<div class="button_left">
					<div class="button_right">
						<div class="button_text save">
							<?php echo form_submit('save', 'Save', ' class="border0 backgroundNone white bold"'); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="btn_wp" style="padding-left:25px;">
				<div class="button_left">
					<div class="button_right">
						<div class="button_text save">
							<?php $data = array(
								'name' => 'button',
								'id' => 'button',
								'value' => 'true',
								'type' => 'reset',
								'content' => 'Cancel',
								'class'=> "border0 backgroundNone white bold",
								'onclick'=>"calcelForm()",
							);
							echo form_button($data);
							//echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold"'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Btm_wp-->
</div>




<script type="text/javascript">
	function calcelForm()
	{
		location.href=baseUrl+language+"/upcomingproject";
	}
</script>