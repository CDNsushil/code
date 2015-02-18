<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
$(document).ready(function(){	
	$("#awardsForm").validate({});	
});
</script>
<?php

$awardsFormAttributes = array(
	'name'=>'awardsForm',
	'id'=>'awardsForm'
);

$awardsUrl = array(
	'name'	=> 'awardsUrl',
	'id'	=> 'awardsUrl',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add url here',
	'value'	=> set_value('awardsUrl'),
	'placeholder'	=> 'Add url here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
	
);

$awardsTitle = array(
	'name'	=> 'awardsTitle',
	'id'	=> 'awardsTitle',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add title here',
	'value'	=> set_value('awardsTitle'),
	'placeholder'	=> 'Add title here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);

$awardsPublishDate = array(
	'name'	=> 'awardsPublishDate',
	'id'	=> 'awardsPublishDate',
	'class'	=> 'BdrCommon formTip required error date-input',	
	'value'	=> set_value('awardsPublishDate'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;',
);

$awardsDescription = array(
	'name'	=> 'awardsDescription',
	'id'	=> 'awardsDescription',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'value'	=> set_value('awardsDescription'),
	'placeholder'	=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'minlength'	=> 50,
	'rows'	=> 5,
	'wordlength'=>"50,100",
	'style' => 'width:393px;',
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')"
);

echo form_open($this->uri->uri_string(),$awardsFormAttributes); 
?>

<div class="frm_wp">
<!-- Adding Form to insert/update DB enrty for AWARDS -->


<input type="hidden" value="0" name="showcaseAwardsId" id="showcaseAwardsId" />
<input type="hidden" value="" name="formtype" />
	<div class="row" style="width:100%;">		  
		 
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['title'];?></div>
			<div class="cell" >
				<?php echo form_input($awardsTitle); ?>
				<div class="red"><?php echo form_error($awardsTitle['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  
		  <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['add'].' '.$label['url'];?></div>
			<div class="cell" >
				<?php echo form_input($awardsUrl); ?>
				<div class="red"><?php echo form_error($awardsUrl['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>		  
		  
		  
		  <div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['publishDate']; ?></div>
			
			<div class="cell" >
				<?php echo form_input($awardsPublishDate); ?>
				<div class="red"><?php echo form_error($awardsPublishDate['name']); ?></div>
			</div>
			<div class="cell widthSpacer10">&nbsp;</div>

			<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#awardPublishDate").focus();' /> </div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
			</div>

		 
		  <div class="row heightSpacer"> &nbsp;</div>		  
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['add'].' '.$label['description'];?></div>
			<div class="cell" >
			  <?php echo form_textarea($awardsDescription); ?>
			  <div class="red"><?php echo form_error($awardsDescription['name']); ?></div>
			   <div class="remainingLimit fl" id="descriptionLimit">0</div> <div class="fl">Total Words </div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div>
		  <div class="row">
		  <div class="cell">
			  <div class="Btn_wp">
			  <div class="btn_wp" style="padding-left:145px;">
				<div class="button_left">
				  <div class="button_right">
					<div class="button_text save"onclick="submitForm('Awards');">
						<?php echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold"'); ?>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div><!-- End class="cell" -->
		<div class="cell">
			 <div class="Btn_wp">
			  <div class="btn_wp" style="padding-left:10px; width: 90px;">
				<div class="button_left">
				  <div class="button_right">
					<div class="button_text Cancel" style=" padding-left:10px;" onclick="commonCancel('AWARDSForm-Content-Box','Awards-No-Records');">
						<strong><?php echo $label['cancel']; ?></strong>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div><!-- End class="cell" -->
		</div><!-- End class="row" -->
	
<!-- End of AWARDS Form -->
</div><!-- End Row -->
</div>
</form>
<div class="row heightSpacer"> &nbsp;</div>	
<?php
//
?>