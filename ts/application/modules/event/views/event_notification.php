<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!------- Top Most Menu Buttons ------->   
<?php echo Modules::run("event/menuNavigation"); ?> 
<!------ End Of Top Menu -------> 
<?php

$formAttributes = array(
	'name'=>'eventNotificationForm',
	'id'=>'eventNotificationForm'
);


$eventTitle = array(
	'name'	=> 'Title',
	'id'	=> 'Title',
	'class'	=> 'Bdr2 formTip required error',
	'value'	=> set_value('Title'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);


$eventType = array(
	'name'	=> 'EventType',
	'id'	=> 'EventType',
	'class'	=> 'Bdr2 formTip required error',
	'value'	=> $data['EventType'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
); 

$eventShortDesc = array(
	'name'	=> 'OneLineDescription',
	'id'	=> 'OneLineDescription',
	'class'	=> 'Bdr2 heightAuto rz  required error',
	'value'	=> set_value('OneLineDescription'),
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')",
	'rows'	=> 3
);

$eventTag = array(
	'name'	=> 'Tagwords',
	'id'	=> 'Tagwords',
	'class'	=> 'Bdr2 heightAuto rz  required error',
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	'value'	=> set_value('Tagwords'),
	'rows'	=> 2
);

$eventStartDate = array(
	'name'	=> 'StartDate',
	'id'	=> 'StartDate',
	'class'	=> 'BdrCommon  required error date-input',	
	'value'	=> set_value('StartDate'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);

$eventFinishDate = array(
	'name'	=> 'FinishDate',
	'id'	=> 'FinishDate',
	'class'	=> 'BdrCommon  required error date-input',	
	'value'	=> set_value('eventFinishDate'),	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);

$eventSelectTime = array(
	'name'	=> 'Time',
	'id'	=> 'Time',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('Time'),
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 30,
	'style' => 'width:128px;'
);

$address = array(
	'name'	=> 'Address',
	'id'	=> 'Address',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('Address'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$city = array(
	'name'	=> 'city',
	'id'	=> 'city',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('city'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$state = array(
	'name'	=> 'state',
	'id'	=> 'state',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('state'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$zipcode = array(
	'name'	=> 'Zip',
	'id'	=> 'Zip',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('Zip'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$country = array(
	'name'	=> 'Country',
	'id'	=> 'Country',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('Country'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$city = array(
	'name'	=> 'City',
	'id'	=> 'City',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('City'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,

);

$addUrl = array(
	'name'	=> 'URL',
	'id'	=> 'URL',
	'class'	=> 'Bdr2  required error',
	'value'	=> set_value('URL'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);
$showProfileImage = '';
?>

<div class="frm_wp">
<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
<input type="hidden" value="1" name="NatureId" id="NatureId" />
<?php echo form_hidden('EventId', 0); ?>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['title'];?></div>
<div class="cell" >
<?php echo form_input($eventTitle); ?>
<div class="red"><?php echo form_error($eventTitle['name']); ?></div>
</div>
</div>


<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo 'Event Type';?></div>
<div class="cell" >
<?php echo form_input($eventType); ?>
<div class="red"><?php echo form_error($eventType['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>		  
<div class="row">
<div class="cell orng_lbl"><?php echo $label['oneLineDescription'];?></div>
<div class="cell" >
<?php echo form_textarea($eventShortDesc); ?>
<div class="red"><?php echo form_error($eventShortDesc['name']); ?></div>
<div class="remainingLimit fl" id="descriptionLimit">
<?php 
//$str=set_value('eventShortDesc')?set_value('proShortDesc'):@$LID->eventShortDesc;
//echo str_word_count($str);
?>
</div>
<div class="fl"><?php echo $label['totalWords'];?></div>
</div>
</div>
		  
<div class="row heightSpacer"> &nbsp;</div>	  
<div class="row">
<div class="cell orng_lbl"><?php echo $label['tagWords'];?></div>
<div class="cell" >
<?php echo form_textarea($eventTag); ?>
<div class="red"><?php echo form_error($eventTag['name']); ?></div>
<div class="remainingLimit fl" id="tagLimit">
<?php 
//$str=set_value('eventTag')?set_value('eventTag'):@$LID->eventTag;
//echo str_word_count($str);
?>
</div> <div class="fl"><?php echo $label['totalWords'];?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell  orng_lbl""><?php echo $label['selectIndustry'];?></div>
<div class="cell">
<?php
$eventIndustryName = "Industry";
$eventIndustryVal = 0;
?>
<div class="Bdr3">
<div class="bg_sel">
<span class="abc"><?=$label['eventIndustry'];?></span>
<?php 
echo form_dropdown($eventIndustryName, $eventIndustryList, $eventIndustryVal ,'id="Industry"','class="single"');
?>
</div>
</div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell  orng_lbl""><?php echo $label['selectGenre'];?></div>
<div class="cell">
<?php 
$subgenre = getGenerList(1, 1, lang(), 'selectGenre');
$eventGenre=1;
if($eventGenre=='other')
$dispOtherGenre='';
else
$dispOtherGenre='none';
?>
<div class="Bdr3">
<div class="bg_sel">
<span class="abc"><?=$label['selectGenre'];?></span>
<?php
echo form_dropdown('Genre', $subgenre, $eventGenre,'id="Genre" class="required"  onchange="addRemoveOther(this.value,\'eventGenreOtherDiv\',\'eventGenreOther\');"');
?>
</div>
</div>
</div> 
<div class="cell" id="eventGenreOtherDiv" style="display:<?php echo $dispOtherGenre?>;">
			<input name="eventGenreOther" id="eventGenreOther" type="text" class="Bdr4 required error"  value="" placeholder="Other"/>
		 </div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventStartDate']; ?></div>	
<div class="cell" >
<?php echo form_input($eventStartDate); ?>
<div class="red"><?php echo form_error($eventStartDate['name']); ?></div>
</div>
<div class="cell widthSpacer10">&nbsp;</div>
<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#eventStartDate").focus();' /> </div>
<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>


<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventFinishDate']; ?></div>
<div class="cell" >
<?php echo form_input($eventFinishDate); ?>
<div class="red"><?php echo form_error($eventFinishDate['name']); ?></div>
</div>
<div class="cell widthSpacer10">&nbsp;</div>
<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#eventFinishDate").focus();' /> </div>
<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventSelectTime'];?></div>
<div class="cell" >
<?php echo form_input($eventSelectTime); ?>
<div class="red"><?php echo form_error($eventSelectTime['name']); ?></div>
</div>
</div>			

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['eventImage']; ?></div>
<div class="cell">

<div class="row" >
<div class="cell dblBorder" style="vertical-align:middle; height:100px; width:100px; padding:5px;">

<img style="max-width:100px; min-height:100px; max-height:100px; margin:auto;" id="profileImage"  src="<?php echo getImage($showProfileImage);?>" />
</div>
<div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell dblBorder" style=" background-color:#E9E9E9; min-height:100px; max-height:100px;width:420px; padding:5px;">
<div class="row" >
<div class="cell" ><?php echo $label['uploadImage']; ?></div>
</div>

<div class="row">
<div class="cell" align="center">
<div id="FileUpload">
<input type="file" size="24" name="Image" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));" style="width:385px;" />

<div id="BrowserVisible" style="width:385px;">
<input type="text" id="FileField" class="formTip Bdr4" style="width:300px;" title="<?php echo $label['eventImage']; ?>"/>
<div class="tds-button" style="position:absolute; right:0; top:0;">
<a id="browse_btn"><span><?php echo $label['browse']; ?></span></a>
</div>
</div>
</div>
</div>
</div><!-- End Div Row-->
<div class="row">
<div class="cell" align="left" style="padding-top:3px;"><?php echo $label['allowed_image_size'];?></div>
</div><!-- End row -->	
</div>
</div><!-- End row -->
</div>
</div><!-- End row -->

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell  orng_lbl"">&nbsp;</div>
<div class="cell">
<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">
	<div class="title-content-center-label" style="width: 541px;"><?php echo $label['addLocation']; ?></div>
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell  orng_lbl"><?php echo $label['address']; ?></div>
<div class="cell" >
<?php echo form_input($address); ?>
<div class="red"><?php echo form_error($address['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['country']; ?></div>
<div class="cell" >
<?php
$countryval='';
//echo '<pre />';print_r($countries);
echo form_dropdown($country['name'] , $countries,  0 ,'id="country"' ); ?>

<div class="red"><?php echo form_error($country['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['city']; ?></div>
<div class="cell" >
<?php echo form_input($city); ?>
<div class="red"><?php echo form_error($city['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['state']; ?></div>
<div class="cell" >
<?php echo form_input($state); ?>
<div class="red"><?php echo form_error($state['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl" ><?php echo $label['zipcode']; ?></div>
<div class="cell">
<?php echo form_input($zipcode); ?>
<div class="red"><?php echo form_error($zipcode['name']); ?></div>
</div>
</div>


<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell orng_lbl"><?php echo $label['addUrl']; ?></div>
<div class="cell" >
<?php echo form_input($addUrl); ?>
<div class="red"><?php echo form_error($addUrl['name']); ?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventType']; ?></div>
<div class="cell doubleBorder">
<div class="row" style="padding-top:0px">
<div class="cell radio">
  <input type="radio" name="Type" value="1" <?php echo 'checked'; //if($values['optionSelected']==1) echo 'checked';?> />
</div>

<div class="cell widthSpacer"> &nbsp;</div>

<div class="cell">
 <?php echo $label['live'];?> 
</div>

<div class="cell widthSpacer"> &nbsp;</div>
 
<div class="cell radio">
	<input type="radio" name="Type" value="2" <?php // if($values['optionSelected']==2) echo 'checked';?> />
</div>
<div class="cell">
 <?php echo $label['online'];?> 
</div>
</div>
</div>
</div>
		
<div class="row heightSpacer"> &nbsp;</div>
<input type="hidden" name="save" value="" />
		<div class="Btn_wp">
		  <div class="btn_wp" style="padding-left:145px;">
			<div class="button_left">
			  <div class="button_right">
				<div class="button_text save" onclick="submitform();">
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
<script type="text/javascript"> 
function submitform()
{
    document.eventNotificationForm.save.value= 'Save'; 
    document.eventNotificationForm.submit();  
}
</script>
