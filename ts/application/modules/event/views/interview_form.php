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

$publishDate = array(
	'name'	=> 'publishDate',
	'id'	=> 'interviewPublishDate',
	'class'	=> 'BdrCommon formTip required error date-input',	
	'value'	=> set_value('publishDate'),	
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
				<?php  echo anchor('javascript://void(0);', $label['search'],array('class'=>'formTip','title'=> $label['search'],'onclick'=>'javascript:openLightBox(\'listBoxWp\',\'listFormContainer\',\'/event/showInterviewsList\')')); ?>			
				</div>
				
				<div class="cell">|</div>
			
				<div class="cell"  style="padding:0px 5px 0px 5px;"><?php echo anchor('javascript://void(0);', $label['externalSite'],array('class'=>'formTip','title'=> $label['externalSite'],'onclick'=>'$(\'#INTERVIEWSForm-Content-Box\').show();')); ?>	
				</div>
		</div>
	
	<div class="row heightSpacer"> &nbsp;</div>
	<?php 
	
	$news['newsVideo']= '';
	$news['uploadVideoType'] = 't';
	$flagtoshowvideo = $news['uploadVideoType'] == 't'?1:0;

	if( $flagtoshowvideo == 1 ) 
	{
		$videoChecked ='checked="checked"';
		$videoShow = 'display:block';
		$urlShow = 'display:none';
		$urlChecked = '';
	}
	else{
		$videoChecked = '';
		$videoShow = 'display:none';
		$urlShow = 'display:block';
		$urlChecked ='checked="checked"';
	}
?>
<!-- Shows Radio Button for externalUrl and embedVideo -->
<div class="row" style="width:100%;"  id="newsEmbedDIv">
<div class="cell orng_lbl">
	<div class="row">	
		<div style="float:right;">
			<?php echo $label['externalUrl'];?>&nbsp;
			<div class="radio" id="url" name="news" style="float:right;">
				<input type="radio" value="url" <?=$urlChecked;?> name="myUpload" id="Div_1" >
			</div>
		</div>
		
	</div>
	<div class="row">
		<div style="float:right;">
			<?php echo $label['embedVideo'];?> &nbsp;
			<div class="radio" id="video" name="news" style="float:right">
				<input id="Div_2" name="myUpload" type="radio" value="video" <?=$videoChecked;?> />
			</div>	
		</div>		
	</div>
		
</div>
	<div class="cell" >		
		
			<div  id="showNewsVideo"  style=" min-height:70px; max-height:70px; <?=$videoShow;?>" >
				<?php 	
				$newsEmbbededVideo['value'] = $news['newsVideo'];	
				echo form_textarea($newsEmbbededVideo);  	
				?>	
				<div class="row heightSpacer"> &nbsp;</div>	  
				
			</div>
			<div id="showNewsURL" style=" min-height:70px; max-height:70px; <?=$urlShow;?>" >
				
				<?php 	
				$newsEmbbededURL['value'] = $news['newsVideo'];	
				echo form_input($newsEmbbededURL);  	
				?>
				
			</div>
	</div>
		

</div>
		
		 <?php /*?><div class="row heightSpacer"> &nbsp;</div>
		  <div class="row">
			<div class="cell orng_lbl"><?php echo $label['externalUrl'];?></div>
			<div class="cell" >
				<?php echo form_input($externalUrl); ?>
				<div class="red"><?php echo form_error($externalUrl['name']); ?></div>
			</div>
			<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
		  </div><?php */?>

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
	
	<div class="cell" >
		<?php echo form_input($publishDate); ?>
		<div class="red"><?php echo form_error($publishDate['name']); ?></div>
	</div>
	<div class="cell widthSpacer10">&nbsp;</div>

			<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#interviewPublishDate").focus();' /> </div>
	<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>
<div class="row heightSpacer"> &nbsp;</div>

<div class="row">
	<div class="cell orng_lbl"><?php echo $label['select'].' '.$label['langauage'];?></div>
	<div class="cell">
	   <div class="Bdr7">
		<div class="bg_sel Bdr6"> 
		<span class="abc">00</span>
		
		<?php
			$language = getlanguageList();
			echo form_dropdown('interviewLanguage', $language, set_value('interviewLanguage'),'id="interviewLanguage" class="required"');
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
			<div class="button_text" style=" padding-left:10px; font-weight:bold;" onclick="commonCancel('INTERVIEWSForm-Content-Box','INTERVIEWS-No-Records');">
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
