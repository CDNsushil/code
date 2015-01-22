<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script>
$(document).ready(function(){	
	$("#newsForm").validate({});	
});
</script>
<?php
$newsFormAttributes = array(
	'name'=>'newsForm',
	'id'=>'newsForm'
);

$externalUrl = array(
	'name'	=> 'externalUrl',
	'id'	=> 'externalUrl',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add external url here',
	'value'	=> set_value('externalUrl'),
	'placeholder'	=> 'Add external url here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);

$url = array(
	'name'	=> 'url',
	'id'	=> 'url',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add url here',
	'value'	=> set_value('url'),
	'placeholder'	=> 'Add url here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$title = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add title here',
	'value'	=> set_value('newsTitle'),
	'placeholder'	=> 'Add title here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);

$writerName = array(
	'name'	=> 'writerName',
	'id'	=> 'writerName',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add your writer name here',	
	'value'	=> set_value('writerName'),	
	'placeholder' => 'Add your writer name here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);


$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

$publishDate = array(
	'name'	=> 'publishDate',
	'id'	=> 'associatedMediapublishDate',
	'class'	=> 'dateGreaterThan width246px required date-input',	
	'dateGreaterThan'=>'#currentDate',
	'title' =>'Publish date must be greater than/equal to Current date',	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);

$description = array(
	'name'	=> 'tagwords',
	'id'	=> 'tagwords',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'value'	=> set_value('tagwords'),
	'placeholder'	=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'minlength'	=> 50,
	'rows'	=> 5,
	'wordlength'=>"50,100",
	'style' => 'width:393px;',
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')"
);

$newsEmbbededURL = array(
	'name'	=> 'newsEmbbededURL',
	'id'	=> 'newsEmbbededURL',
	'value'	=> set_value('newsEmbbededURL'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 3,
    'cols'      => 45,
	'style'      => 'width:392px;',
	'class'       => 'BdrCommon formTip  required error',
	'title'       =>  $label['externalURL'],
);

$newsEmbbededVideo = array(
	'name'	=> 'newsEmbbededVideo',
	'id'	=> 'newsEmbbededVideo',
	'value'	=> set_value('newsEmbbededURL'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 2,
    'cols'      => 45,
	'style'      => 'width:392px;',
	'class'       => 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'       =>  $label['externalURL'],
);
$userfile =	array(
	'name'        => 'userfile',
	'id'          => 'workVideo',
);
?>
<?php echo form_open('showcase/additionalInfoForm',$newsFormAttributes); ?>
<div class="frm_wp">	
	
	<input type="hidden" value="0" name="showcaseNewsId" id="showcaseNewsId" />
	<input type="hidden" value="" name="formtype" />
		
		<div class="row" style="width:100%;" >
				<div class="cell" style="padding:0px 5px 0px 5px;">
				<?php  echo anchor('javascript://void(0);', $label['search'],array('class'=>'formTip','title'=> $label['search'],'onclick'=>'javascript:openLightBox(\'listBoxWp\',\'listFormContainer\',\'/event/showAssociatedMediaList\')')); ?>			
				</div>
				
		</div>
	
	<div class="row heightSpacer"> &nbsp;</div>

<div class="row">
	<div class="cell orng_lbl"><?php echo $label['title'];?></div>
	<div class="cell" >
		<?php echo form_input($title); ?>
		<div class="red"><?php echo form_error($title['name']); ?></div>
	</div>
	<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>
		  
<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
	<div class="cell orng_lbl"><?php echo $label['writerName'];?></div>
	<div class="cell" >
		<?php echo form_input($writerName); ?>
		<div class="red"><?php echo form_error($writerName['name']); ?></div>
	</div>
	<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>
		 
		  
<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
	<div class="cell orng_lbl"><?php echo $label['publishDate']; ?></div>
	
	<div class="cell width270px">
		<?php echo form_input($currentDate); echo form_input($publishDate); ?>
		<div class="red"><?php echo form_error($publishDate['name']); ?></div>
	</div>
	<div class="cell widthSpacer10">&nbsp;</div>

			<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#associatedMediapublishDate").focus();' /> </div>
	<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>
<div class="row heightSpacer"> &nbsp;</div>

<div class="row">
	<div class="label_wrapper cell"><label class="select_field"><?php echo $label['select'].' '.$label['langauage'];?></label></div>
	<div class="cell">
	   <div class="Bdr7">
		<div class="bg_sel Bdr6"> 
		<span class="abc">00</span>
		
		<?php
			$language = getlanguageList();
			echo form_dropdown('associatedMediaLanguage', $language, set_value('associatedMediaLanguage'),'id="associatedMediaLanguage" class="required"');
		?>
	  </div>
	  </div>
	</div>
</div>
		 <?php /*?> <div class="row heightSpacer"> &nbsp;</div>		  
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['add'].' '.$label['description'];?></div>
			<div class="cell" >
			  <?php echo form_textarea($description); ?>
			  <div class="red"><?php echo form_error($description['name']); ?></div>
			   <div class="remainingLimit fl" id="descriptionLimit">0</div> <div class="fl">Total Words </div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div><?php */?>
<!-- Below Show Save And Cancel Button -->
<div class="row">
<div class="cell">
	  <div class="Btn_wp">
	  <div class="btn_wp" style="padding-left:145px;">
		<div class="button_left">
		  <div class="button_right">
			<div class="button_text save"  onclick="submitForm('News');">
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
			<div class="button_text" style=" padding-left:10px; font-weight:bold;" onclick="commonCancel('ASSOCIATEDMEDIASForm-Content-Box','ASSOCIATEDMEDIAS-No-Records');">
				<?php echo $label['cancel']; ?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
</div><!-- End class="cell" -->
</div><!-- End class="row" -->
<div class="row heightSpacer"> &nbsp;</div>	
</div><!-- End Div frm_wp -->	  
<div class="row heightSpacer"> &nbsp;</div>	
</form>
