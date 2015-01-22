<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!------- Top Most Menu Buttons ------->   
<?php echo Modules::run("showcase/menuNavigation"); ?> 
<!------ End Of Top Menu ------->   
<?php

$formAttributes = array(
	'name'=>'showcaseForm',
	'id'=>'customForm'
);


$firstName = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  'Add your first name here',
	'value'	=> set_value('firstName'),
	'placeholder'	=> 'Add your first name here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$lastName = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  'Add your last name here',
	'value'	=> set_value('lastName'),
	'placeholder'	=> 'Add your last name here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$enterpriseName = array(
	'name'	=> 'enterpriseName',
	'id'	=> 'enterpriseName',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  'Add your enterprise name here',	
	'value'	=> set_value('enterpriseName'),	
	'placeholder' => 'Add your enterprise name here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$optionAreaName = array(
	'name'	=> 'optionAreaName',
	'id'	=> 'optionAreaName',
	'class'	=> 'Bdr2 formTip required error',	
	'value'	=> set_value('optionAreaName'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$tagwords = array(
	'name'	=> 'tagwords',
	'id'	=> 'tagwords',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['tagwords'].' here'.$label['15_100_words'],
	'value'	=> set_value('tagwords'),
	'placeholder'	=>  $label['add'].' '.$label['tagwords'].' here'.$label['15_100_words'],
	'minlength'	=> 50,
	'maxlength'	=> 300,
	'rows'	=> 5
);

$creativeFocus = array(
	'name'	=> 'creativeFocus',
	'id'	=> 'creativeFocus',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['onelinedescription'].$label['10_50_words'],
	'value'	=> set_value('creativeFocus'),
	'placeholder'	=> $label['add'].' '.$label['onelinedescription'].$label['10_50_words'],
	'minlength'	=> 50,
	'maxlength'	=> 300,
	'rows'	=> 5
);
$creativePath = array(
	'name'	=> 'creativePath',
	'id'	=> 'creativePath',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['descriptionminmax'],
	'value'	=> set_value('creativePath'),
	'placeholder'	=> $label['add'].' '.$label['descriptionminmax'],
	'minlength'	=> 50,
	'maxlength'	=> 300,
	'rows'	=> 5
);

$proShortDesc = array(
	'name'	=> 'proShortDesc',
	'id'	=> 'proShortDesc',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  'Add a one line description here.( 15-100 words )',
	'value'	=> set_value('proShortDesc'),
	'placeholder'	=> 'Add a one line description here.( 15-100 words )',
	'minlength'	=> 50,
	'maxlength'	=> 300,
	'rows'	=> 5
);
$projTag = array(
	'name'	=> 'projTag',
	'id'	=> 'projTag',
	'class'	=> 'Bdr2 heightAuto rz formTip required error',
	'title'=>  'Add tag words.( 5-50 words )',
	'value'	=> set_value('projTag'),
	'placeholder'	=> 'Add tag words.( 5-50 words )',
	'minlength'	=> 20,
	'maxlength'	=> 200,
	'rows'	=> 5
);
$FvReleaseDate = array(
	'name'	=> 'FvReleaseDate',
	'id'	=> 'FvReleaseDate',
	'value'	=> set_value('FvReleaseDate'),
	'title'=>  'Add a release date from calendar',
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr2 date-input'
);
$fvSubtitle1 = array(
	'name'	=> 'fvSubtitle1',
	'id'	=> 'fvSubtitle1',
	'class'	=> 'Bdr5 formTip',
	'title'=>  'Add the subtitle 1 of project here',
	'value'	=> set_value('fvSubtitle1'),
	'placeholder'	=> 'Add the subtitle 1 of project here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$fvSubtitle2 = array(
	'name'	=> 'fvSubtitle2',
	'id'	=> 'fvSubtitle2',
	'class'	=> 'Bdr5 formTip',
	'title'=>  'AAdd the subtitle 2 of project here',
	'value'	=> set_value('fvSubtitle2'),
	'placeholder'	=> 'Add the subtitle 2 of project here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$fvDubbing1 = array(
	'name'	=> 'fvDubbing1',
	'id'	=> 'fvDubbing1',
	'class'	=> 'Bdr5 formTip',
	'title'=>  'Add the dubbing 1 of project here',
	'value'	=> set_value('fvDubbing1'),
	'placeholder'	=> 'Add the dubbing 1 of project here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$fvDubbing2 = array(
	'name'	=> 'fvDubbing2',
	'id'	=> 'fvDubbing2',
	'class'	=> 'Bdr5 formTip',
	'title'=>  'Add the dubbing 2 of project here',
	'value'	=> set_value('fvDubbing2'),
	'placeholder'	=> 'Add the dubbing 2 of project here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$profileImage= '';
?>
<div class="frm_wp">
	<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
	<div class="row" style="width:100%;">
			<div class="cell orng_lbl"><?php echo $label['profileType']; ?></div>
			<div class="cell doubleBorder">
			  <div class="row" style="padding-top:0px">
				<div class="cell radio" id="<?php echo $label['creative']; ?>">
				  <input type="radio" name="catId" checked value="1">
				</div>
				
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				 <?php echo $label['creative'];?> 
				</div>
				
				<div class="cell widthSpacer"> &nbsp;</div>
				 
				<div class="cell radio" id="<?php echo $label['associatedProfessional']; ?>">
					<input type="radio"  name="catId" value="2">
				</div>
				
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				  <?php echo $label['associatedProfessional'];?> 
				</div>
				
				<div class="cell widthSpacer"> &nbsp;</div>
				 
				<div class="cell radio" id="<?php echo $label['enterprise']; ?>">
					<input type="radio"  name="catId" value="3">
				</div>
				
				
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				  <?php echo $label['enterprise'];?> 
				</div>
				
				<div class="cell widthSpacer"> &nbsp;</div>
				 
				<div class="cell radio" id="<?php echo $label['performingArtist']; ?>">
					<input type="radio"  name="catId" value="4">
				</div>
				
				
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				  <?php echo $label['performingArtist'];?> 
				</div>
			  </div>
			</div>
		  </div>

		 <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['firstName'];?></div>
			<div class="cell" >
				<?php echo form_input($firstName); ?>
				<div class="red"><?php echo form_error($firstName['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  
		  <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['lastName'];?></div>
			<div class="cell" >
				<?php echo form_input($lastName); ?>
				<div class="red"><?php echo form_error($lastName['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  <div id="enterpriseNameTog" style="display:none;">
		  <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['enterpriseName'];?></div>
			<div class="cell" >
				<?php echo form_input($enterpriseName); ?>
				<div class="red"><?php echo form_error($enterpriseName['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  </div>
		  
		  <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><div id="areaId"><?php echo $label['creative']; ?> <?php echo $label['area'];?></div></div>
			
			<div class="cell" >
				<?php echo form_input($optionAreaName); ?>
				<div class="red"><?php echo form_error($optionAreaName['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  
		  <div class="row heightSpacer"> &nbsp;</div>		  
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['tagwords'];?></div>
			<div class="cell" >
			  <?php echo form_textarea($tagwords); ?>
			  <div class="red"><?php echo form_error($tagwords['name']); ?></div>
			</div>
		  </div>
		    
		   <div class="row heightSpacer"> &nbsp;</div>		  
		  <div class="row">
			<div class="cell orng_lbl"><div id="focusId"><?php echo $label['creativeFocus']; ?></div></div>
			<div class="cell" >
			  <?php echo form_textarea($creativeFocus); ?>
			  <div class="red"><?php echo form_error($creativeFocus['name']); ?></div>
			</div>
		  </div>
		   
		   <div class="row heightSpacer"> &nbsp;</div>		  
		  <div class="row">
			<div class="cell orng_lbl"><div id="pathId"><?php echo $label['creativeFocus']; ?></div></div>
			<div class="cell" >
			  <?php echo form_textarea($creativePath); ?>
			  <div class="red"><?php echo form_error($creativePath['name']); ?></div>
			</div>
		  </div>
		  
		  <div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
		<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['profileImage']; ?></div>
		<div class="cell">
			<div class="table" style="width:100%;">
				<div class="row" >
					<div class="cell dblBorder" style="vertical-align:middle; height:100px; width:100px; padding:5px;">
					<img style="max-width:100px; min-height:100px; max-height:100px; margin:auto;"  src="<?php echo getImage($profileImage);?>" />
					</div>
					<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell dblBorder" style=" background-color:#E9E9E9; min-height:100px; width:400px; padding:5px;">
					<div id="toggelProfileImage">
						<div class="row">
						<div class="cell">					
							<div class="tds-button">
							<a id="showStockImage"><span>Stock Image</span></a>
							</div>
						</div>
						<div class="cell">					
							<div class="tds-button">
							<a id="showUploadImage"><span>My Image</span></a>
							</div>
						</div>
						</div>
					</div>
					<div id="uploadProfileImage" style="display:none;">
					<div class="row" >
						<div class="cell" ><?php echo $label['uploadImage']; ?><span class="clear_seprator"></span></div>
					</div>
					<div class="row">
					<div class="cell" align="center">
						<div id="FileUpload">
								<input type="file" size="24" name="userfile" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));" style="width:385px;" />
								
								<div id="BrowserVisible" style="width:385px;">
									 <input type="text" id="FileField" class="formTip Bdr4" style="width:300px;" title="<?php echo $label['profileImage']; ?>"/>
									 <div class="tds-button" style="position:absolute; right:0; top:0;">
										<a id="browse_btn"><span>Browse</span></a>
									</div>
								</div>
							</div>
						</div>
					</div><!-- End Div Row-->
					<div class="row">
						<div class="cell" align="left" style="padding-top:25px;"><?php echo $label['allowed_image_size'];?></div>
					</div><!-- End row -->					
					</div><!-- End uploadProfileImage -->
					</div>
				</div><!-- End row -->
			</div><!-- End table -->
		</div>
    </div>
</div><!-- End row -->



		<div class="Btn_wp">
		  <div class="btn_wp" style="padding-left:145px;">
			<div class="button_left">
			  <div class="button_right">
				<div class="button_text save">
					<?php echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold"'); ?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!--Btm_wp-->
	<?php echo form_close(); ?>
</div>
<!--frm_wp-->

<script>
    $(function(){
	$("#showUploadImage").click(function(){
  $("#uploadProfileImage").show();
});
	var $curr = $("input[type=radio]");

  $(".radio").click(function(){
 
 //  $('#it').attr({ value:$(this).attr('id')}); 
     //$('#it').attr({ value:this.value });
	 if($(this).attr('id') == '<?php echo $label['enterprise']; ?>')
	 {
	 	$("#enterpriseNameTog").show();
	 }else{
	 	$("#enterpriseNameTog").hide();
	 }
	 $("#areaId").html($(this).attr('id')+' <?php echo $label['area'];?>');
	 $("#focusId").html($(this).attr('id')+' <?php echo $label['focus'];?>');
	 $("#pathId").html($(this).attr('id')+' <?php echo $label['path'];?>');

  }); 
});

</script>