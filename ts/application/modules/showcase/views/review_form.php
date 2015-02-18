<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script>
$(document).ready(function(){	
	$("#reviewsForm").validate({});	
});
</script>
<?php
$reviewsFormAttributes = array(
	'name'=>'reviewsForm',
	'id'=>'reviewsForm'
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

$title = array(
	'name'	=> 'reviewstitle',
	'id'	=> 'reviewstitle',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add title here',
	'value'	=> set_value('reviewsTitle'),
	'placeholder'	=> 'Add title here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);

$writerName = array(
	'name'	=> 'reviewswriterName',
	'id'	=> 'reviewswriterName',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add your writer name here',	
	'value'	=> set_value('writerName'),	
	'placeholder' => 'Add your writer name here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:392px;'
);

$reviewsPublishDate = array(
	'name'	=> 'reviewsPublishDate',
	'id'	=> 'reviewsPublishDate',
	'class'	=> 'BdrCommon formTip required error date-input',	
	'value'	=> set_value('reviewsPublishDate'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;',
);

$reviewsDescription = array(
	'name'	=> 'reviewsDescription',
	'id'	=> 'reviewsDescription',
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

$reviewsEmbbededURL = array(
	'name'	=> 'reviewsEmbbededURL',
	'id'	=> 'reviewsEmbbededURL',
	'value'	=> set_value('reviewsEmbbededURL'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
	'rows'      => 3,
    'cols'      => 45,
	'style'      => 'width:392px;',
	'class'       => 'BdrCommon formTip  required error',
	'title'       =>  $label['externalURL'],
);

$reviewsEmbbededVideo = array(
	'name'	=> 'reviewsEmbbededVideo',
	'id'	=> 'reviewsEmbbededVideo',
	'value'	=> set_value('reviewsEmbbededVideo'),//,set_value('workOneLineDesc',$workOffered['workOneLineDesc']);	
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
<div class="frm_wp">
<?php echo form_open($this->uri->uri_string(),$reviewsFormAttributes); ?>
<input type="hidden" value="0" name="showcaseReviewsId" id="showcaseReviewsId" />
<input type="hidden" value="" name="formtype" />
<?php
echo form_hidden('reviewIdForUp','');	
echo form_hidden('reviewIdForDown','');
?>

<div class="row" style="width:100%;">

<div class="cell"><?php  echo anchor('javascript://void(0);', $label['search'],array('class'=>'formTip','title'=> $label['search'],'onclick'=>'javascript:openLightBox(\'listBoxWp\',\'listFormContainer\',\'/showcase/showReviewsList\')')); ?></div>
<div class="cell">&nbsp;|&nbsp;</div>

<div class="cell"><?php echo anchor('javascript://void(0);', $label['externalSite'],array('class'=>'formTip','title'=> $label['externalSite'],'onclick'=>'')); ?></div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<?php

//echo "<pre />";print_r($workOffered);
	$reviews['uploadVideoType'] = 't';
	$flagtoshowreviewvideo = $reviews['uploadVideoType'] == 't'?1:0;
	
	//echo "tttt".$flagtoshowvideo;
	if( $flagtoshowreviewvideo ==1) 
	{
		$reviewVideoChecked ='checked="checked"';
		$reviewVideoShow = 'display:block';
		$reviewUrlShow = 'display:none';
		$reviewUrlChecked ='';
	}
	else{
		$reviewVideoChecked ='';
		$reviewVideoShow = 'display:none';
		$reviewUrlShow = 'display:block';
		$reviewUrlChecked ='checked="checked"';
	}
?>
<div class="row" style="width:100%;" id="reviewEmbedDIv">
<div class="cell orng_lbl">
	<div class="row">	
		<div style="float:right;">
			<?php echo $label['externalUrl'];?>&nbsp;
			<div class="radio" id="url" name="reviews" style="float:right;">
				<input type="radio" value="url" <?=$reviewUrlChecked;?> name="myReviewUpload" id="Div_Review_1">
			</div>
		</div>
		  
		
	</div>
	<div class="row">
		<div style="float:right;">
			<?php echo $label['embedVideo'];?> &nbsp;
			<div class="radio" id="video" name="reviews" style="float:right">
				<input id="Div_Review_2" name="myReviewUpload" type="radio" value="video" <?=$reviewVideoChecked;?> />
			</div>	
		</div>
	</div>
	<div class="row heightSpacer"> &nbsp;</div>	
</div>
	<div class="cell" >		
	
			<div  id="showReviewVideoUpload"  style=" min-height:70px; max-height:70px; <?=$reviewVideoShow;?>" >
				<?php 	
				//$reviewsEmbbededVideo['value'] = '';	
				//$reviews['reviewsVideo'] = '';
				echo form_textarea($reviewsEmbbededVideo);  	
				?>	
				<div class="row heightSpacer"> &nbsp;</div>	  
			</div>
			<div id="showReviewEmbbededURL" style=" min-height:70px; max-height:70px; <?=$reviewUrlShow;?>" >
				
				<?php 	
				$reviewsEmbbededURL['value'] = '';	
				echo form_input($reviewsEmbbededURL);  	
				?>				
			</div>
	</div>
</div>
	
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
				<?php echo form_input($reviewsPublishDate); ?>
				<div class="red"><?php echo form_error($reviewsPublishDate['name']); ?></div>
			</div>
			<div class="cell widthSpacer10">&nbsp;</div>

			<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#reviewsPublishDate").focus();' /> </div>
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
					echo form_dropdown('reviewsLanguage', $language, set_value('reviewsLanguage'),'id="reviewsLanguage" class="required"');
				?>
			  </div>
			   </div>
			</div>
		</div>
		<div class="row heightSpacer"> &nbsp;</div>		  
		  
		  <div class="row">
		  <div class="cell">
			  <div class="Btn_wp">
			  <div class="btn_wp" style="padding-left:145px;">
				<div class="button_left">
				  <div class="button_right">
					<div class="button_text save" onclick="submitForm('Reviews');">
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
					<div class="button_text" style=" padding-left:10px; font-weight:bold;" onclick="commonCancel('REVIEWSForm-Content-Box','Reviews-No-Records');">
						<?php echo $label['cancel']; ?>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			</form>
		</div><!-- End class="cell" -->
		</div><!-- End class="row" -->
		  <div class="row heightSpacer"> &nbsp;</div>	
</div><!-- End Div frm_wp -->
<div class="row heightSpacer"> &nbsp;</div>	
<script language="javascript" type="text/javascript">
function moveUp(reviewIdForDown)
{
	document.reviewsForm.reviewIdForUp.value = reviewIdForDown;
	document.reviewsForm.submit();
	//window.location = "<?php base_url()?>workprofile/moveUp/"+profileSocialLinkId;
}
function moveDown(reviewIdForDown)
{
	document.reviewsForm.reviewIdForDown.value = reviewIdForDown;
	document.reviewsForm.submit();
}
</script>	 	
