<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!------- Top Most Menu Buttons ------->   
<?php 

echo Modules::run("event/menuNavigation",$eventNatureId);

?> 
<!------ End Of Top Menu ------->

<?php

$action = $this->router->class.'/'.$this->router->method;

$formAttributes = array(
	'name'=>'launchEventForm',
	'id'=>'customForm'
); 

$eventTitle = array(
	'name'	=> 'Title',
	'id'	=> 'Title',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  $label['eventTitle'],
	'value'	=> isset($data['Title'])?$data['Title']:'',
	'placeholder'	=> $label['eventTitle'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$eventType = array(
	'name'	=> 'EventType',
	'id'	=> 'EventType',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  $label['eventType'],
	'value'	=> isset($data['EventType'])?$data['EventType']:'',
	'placeholder'	=> $label['eventType'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
); 

$eventShortDesc = array(
	'name'	=> 'OneLineDescription',
	'id'	=> 'OneLineDescription',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['eventDescriptionTitle'],
	'value'	=> isset($data['OneLineDescription'])?$data['OneLineDescription']:'',
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')",
	'placeholder'	=> $label['eventDescriptionTitle'],
	'rows'	=> 3,
	'width'=> "500px"
);

$eventTag = array(
	'name'	=> 'Tagwords',
	'id'	=> 'Tagwords',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['eventTagTitle'],
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	'value'	=> isset($data['Tagwords'])?$data['Tagwords']:'',
	'placeholder'	=> $label['eventTagTitle'],
	'rows'	=> 2
);

$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

$eventLaunchDate = array(
	'name'	=> 'LaunchDate',
	'id'	=> 'LaunchDate',
	'class'	=> 'BdrCommon required error date-input',	
	'value'	=> isset($data['LaunchDate'])?substr($data['LaunchDate'],0,-9):'',	
	'minlength'	=> 2,
	'dateGreaterThan'=>'#currentDate',
	'title' =>'Launch date must be greater than/equal to Current date',
	'placeholder'	=> $label['LaunchDate'],
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);

$eventSelectTime = array(
	'name'	=> 'Time',
	'id'	=> 'Time',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  $label['eventSelectTime'],
	'value'	=> isset($data['Time'])?$data['Time']:'',
	'placeholder'	=> $label['eventSelectTime'],
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 30,
	'style' => 'width:116px;'
);

$address = array(
	'name'	=> 'Address',
	'id'	=> 'Address',
	'class'	=> 'Bdr2 formTip',
	'title'=>  $label['address'],
	'value'	=> isset($data['Address'])?$data['Address']:'',
	'placeholder'	=> $label['address'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$city = array(
	'name'	=> 'City',
	'id'	=> 'City',
	'class'	=> 'Bdr2 formTip',
	'title'=>  $label['city'],
	'value'	=> isset($data['City'])?$data['City']:'',
	'placeholder'	=> $label['city'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$state = array(
	'name'	=> 'State',
	'id'	=> 'State',
	'class'	=> 'Bdr2 formTip',
	'title'=>  $label['state'],
	'value'	=> isset($data['State'])?$data['State']:'',
	'placeholder'	=> $label['state'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$zipcode = array(
	'name'	=> 'Zip',
	'id'	=> 'Zip',
	'class'	=> 'Bdr2 formTip',
	'title'=>  $label['zipcode'],
	'value'	=> isset($data['Zip'])?$data['Zip']:'',
	'placeholder'	=> $label['zipcode'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$country = array(
	'name'	=> 'Country',
	'id'	=> 'Country',
	'class'	=> 'Bdr2 formTip error',
	'title'=>  $label['country'],
	'value'	=> isset($data['Country'])?$data['Country']:0,
	'placeholder'	=> $label['country'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);


$addUrl = array(
	'name'	=> 'URL',
	'id'	=> 'URL',
	'class'	=> 'Bdr2 formTip required error',
	'title'=>  $label['addUrl'],
	'value'	=> isset($data['URL'])?$data['URL']:'',
	'placeholder'	=> $label['addUrl'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$eventDescription = array(
	'name'	=> 'Description',
	'id'	=> 'Description',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['eventDescription50to100'],
	'value'	=> isset($data['Description'])?$data['Description']:'',
	'wordlength'=>"50,100",
	'onkeyup'=>"checkWordLen(this,100,'eventdescriptionLimit')",
	'placeholder'	=> $label['eventDescription50to100'],
	'rows'	=> 3
);
$showProfileImage = '';

?>

<div class="frm_wp">
<?php 
 echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
 echo form_hidden('NatureId',$eventNatureId); 
 ?>
<?php
if(isset($data['EventId']) && $data['EventId']>0)
 echo form_hidden('EntityId',$data['EventId']);
 
 if(isset($data['LaunchEventId']) && $data['LaunchEventId']>0)
 echo form_hidden('LaunchEventId',$data['LaunchEventId']);
?>
<?php  

if(!isset($data['LaunchEventId']) || $data['LaunchEventId']<=0) {
	if( (isset($data['EventId']) && $data['EventId']>0)){
?>
<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">

<div class="cell" ><?php echo '<input type="checkbox" id="myCheckBoxDuplicate" name="myCheckBoxDuplicate" checked ="checked" OneLineDescription="'.$data['OneLineDescription'].'"  Description="'.$data['Description'].'" />'; ?></div>
<div class="cell" style="padding-left:10px"><?php echo $label['checkToDuplicate']; ?></div>

</div>
<?php 
}
}
?>
<div class="row heightSpacer"> &nbsp;</div>	
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
$str=$eventShortDesc['value']?$eventShortDesc['value']:@$data['oneLineDescription'];
echo str_word_count($str);
?>
</div>
<div class="fl"><?php echo $label['totalWords'];?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php  echo form_input($currentDate); echo $label['LaunchDate']; ?></div>	
<div class="cell" >
<?php echo form_input($eventLaunchDate); ?>
<div class="red"><?php echo form_error($eventLaunchDate['name']); ?></div>
</div>
<div class="cell widthSpacer10">&nbsp;</div>
<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#LaunchDate").focus();' /> </div>

</div>

<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventSelectTime'];?></div>
<div class="cell pb5" >
	<div class="cell">
    <div class="hr-stepper">
        <input type="text" size="3" name="hh" value=<?=$hour;?> />
        <div><button type="submit" name="ns_button_1_2" value="1" class="plus"></button></div>
        <div><button type="submit" name="ns_button_2_3" value="-1" class="minus"></button></div>
        <p class="pt2 f10">hh</p>
    </div>
	</div>
	
	<div class="cell pl5">&nbsp;</div>

	<div class="cell">
    <div style="position:relative; height:21px; width:32px; padding-top:5px;border: 1px solid #A0A0A0;padding-right: 5px;" class="minsec-stepper">
        <input type="text" size="3" name="mm" value=<?=$min;?> />
        <div><button type="submit" name="ns_button_1_2" value="1" class="plus"></button></div>
        <div><button type="submit" name="ns_button_2_3" value="-1" class="minus"></button></div>
       <p class="pt2 f10">mm</p>
    </div>
</div>
<div class="red"><?php echo form_error($eventSelectTime['name']); ?></div>
</div>
</div>			

<div class="row heightSpacer"> &nbsp;</div>		  
<div class="row">
<div class="cell orng_lbl"><?php echo $label['eventDescription'];?></div>
<div class="cell" >
<?php echo form_textarea($eventDescription); ?>
<div class="red"><?php echo form_error($eventDescription['name']); ?></div>
<div class="remainingLimit fl" id="eventdescriptionLimit">
<?php 
$str=set_value('eventDescription')?set_value('eventDescription'):@$data['Description'];
echo str_word_count($str);
?>
</div>
<div class="fl"><?php echo $label['totalWords'];?></div>
</div>
</div>

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
<div class="cell  orng_lbl">&nbsp;</div>
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
<div class="cell orng_lbl"><?php echo $label['eventType']; ?></div>
<div class="cell doubleBorder">
<div class="row" style="padding-top:0px">
<div class="cell radio" id="live">
	<?php
	
	if(!isset($data['Type']) || $data['Type']=='') $LaunchType = 1;
	else $LaunchType = $data['Type'];
	?>
  <input type="radio" class="radio" name="Type" value="1" id="live" <?php if( $LaunchType==1 ||  $LaunchType=='') echo 'checked';?> />
</div>

<div class="cell widthSpacer"> &nbsp;</div>

<div class="cell">
 <?php echo $label['live'];?> 
</div>

<div class="cell widthSpacer"> &nbsp;</div>
 
<div class="cell radio" id="online">
	<input type="radio" class="radio" name="Type" value="2" id="online" <?php if( $LaunchType==2) echo 'checked';?> />
</div>
<div class="cell">
 <?php echo $label['online'];?> 
</div>
</div>
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

$CountryName = "Country";
		if((isset($data['LaunchEventId']) && $data['LaunchEventId']>0)) {
			$CountryVal= $data['Country'];
		}else
		{
			$CountryVal= '';
		}?>
		<?php $attr = 'id="Country" class="dropDown single"';
		echo form_dropdown($CountryName, $countries,$CountryVal ,$attr);
		?>

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
<input type="hidden" name="formtype" value="">
<input type="hidden" name="save" value="" />

		<div class="Btn_wp">
		  <div class="btn_wp" style="padding-left:145px;">
			<div class="button_left">
			  <div class="button_right">
				<div class="button_text save" >
					<?php echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold" onclick="submitform(\'mainEvent\');"'); ?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!--Btm_wp-->
<?php echo form_close();?>
<?php

$eventPromoImages['tableName'] = $tableName;

if((isset($data['EventId']) && $data['EventId']>0) || (isset($data['LaunchEventId']) && $data['LaunchEventId']>0)){
	
?>
<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<?php echo $this->load->view('mediatheme/promoMediaTitleBar',$count); ?>

<div id="PROMOTIONALIMAGE-Content-Box"  style="display:block;" >

<div id="PROMOTIONALIMAGEForm-Content-Box"  <?php echo $PROMOTIONALIMAGEForm;?>>
<?php echo Modules::run("mediatheme/promoMediaForm",$data['EventId'],$action,$tableName,$mediaType); ?>
</div><!-- End Div PROMOTIONALIMAGEForm-Content-Box -->	

<!-- Show List Of PROMOTIONALIMAGE -->
<?php 
$action = 'event/deletePromoMedia';
echo Modules::run("mediatheme/index",$data['EventId'],$action,$eventPromoImages,$showDelOption,$returnUrl); 
?> 
<div>

</div><!-- End Div "PROMOTIONALIMAGEForm-Content-Box" -->

</div><!-- End Div "PROMOTIONALIMAGE-Content-Box"-->
</div><!-- End class="row" -->
<?php echo Modules::run("additionalInfo/addInfoSesTimePanel",$tableId,$data['EventId'],$this->uri->uri_string(),'eventId','launchEventId',$data['LaunchEventId']); ?>
<?php /*
<div class="row heightSpacer"> &nbsp;</div>
<div class="row">
<div class="cell" style="width:100%;">
	<div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center"  onmouseover="this.style.cursor='pointer'" >
	<div class="title-content-center-label"><?php echo $label['SESSIONTIME']; ?></div>
	<div class="tds-button-top"> 
	<?php 
		echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['add'],'onclick'=>'showRelatedForm(\'SESSIONTIMEForm-Content-Box\',\'SESSIONTIME-No-Records\',\'title\',\'writerName\',\'newsLanguage\',\'publishDate\',\'newsEmbedDIv\',\'newsEmbbededVideo\',\'newsEmbbededURL\',\'showcaseNewsId\');$(\'#SESSIONTIME-Content-Box\').show();'));
	?>
	</div>
	<div class="toggleAdditionalInfo" toggleDivId="SESSIONTIME-Content-Box"  toggleDivRecords="SESSIONTIME-No-Records" toggleDivForm="SESSIONTIMEForm-Content-Box"  align="right">
	<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['SESSIONTIME']; ?>"/>
	</div>	
	</div><!-- End class="title-content-center" -->
	</div><!-- End class="title-content-right" -->
	</div><!-- End class="title-content-left" -->
	</div><!-- End class="title-content" -->
</div> 
<div id="SESSIONTIME-Content-Box">

<div id="SESSIONTIMEForm-Content-Box"  style="display:none;">
<?php //echo Modules::run("event/sessionTimeForm"); ?>
</div><!-- End Div SESSIONTIMEForm-Content-Box -->	

<!-- Show List Of SESSIONTIME -->
<?php //echo Modules::run("event/sessionTimeList"); ?> 
<div>

</div><!-- End Div "SESSIONTIMEForm-Content-Box" -->

</div><!-- End Div "SESSIONTIME-Content-Box"-->
</div><!-- End class="row" -->*/?>
<? 

} //end if EventId is set to some existing Id 
?>
<div class="row heightSpacer">&nbsp;</div>

</div>
<?php
//echo '<pre />';print_r($data);
?>
<!--frm_wp-->

<script language="javascript" type="text/javascript">
function showRelatedForm(showDiv,hideDiv,titleValue,mediaId,BrowserHiddenPromo,PromoFileField,PromoDesc){
//alert(showDiv);
document.getElementById(showDiv).style.display = 'block';
if(document.getElementById(hideDiv))
document.getElementById(hideDiv).style.display = 'none';
document.getElementById(mediaId).value = 0;
document.getElementById(titleValue).value = '';
document.getElementById(BrowserHiddenPromo).value = '';
document.getElementById(PromoFileField).value = '';
document.getElementById(PromoDesc).value = '';
$('#currentPromotionalImage').attr('src',baseUrl+'images/no_images.jpg');
}

//Function called on cancel button of form
function commonCancel(formId,norecord){
//alert(formId);
//$('#'+formId).toggle();
	if($('#'+formId).is(':visible')) $('#'+formId).hide();
		else $('#'+formId).show();
if($('#'+norecord).length > 0)
	$('#'+norecord).show();
	
$('html, body').animate({scrollTop:'200px'}, 'fast');
}
</script>
<script type="text/javascript"> 
function submitform(saveType)
{
//	alert(saveType);
 if(saveType == 'mainEvent'){
		document.launchEventForm.formtype.value = saveType;	
		
	}    
var start = document.launchEventForm.StartDate.value; var end = document.launchEventForm.FinishDate.value;

if(Date.parse(start) <= Date.parse(end)) { 
document.launchEventForm.save.value= 'Save'; 
document.launchEventForm.submit(); return true;
} 
else { 
alert("Finish Date must be greater than Start Date"); 
return false;  
}   
    
}
$(document).ready(function() {

//To delete
$("#FinishDate").change(function() {
var sDate = new Date($(this).val());
//alert(sDate);
//alert("End Date must be greater than Start Date")

});
$("#Time").change(function() {   

   var timeFieldValue = $(this).val();
    re = /^\d{1,2}:\d{2}:\d{2} ?$/;
    if(timeFieldValue != '' && !timeFieldValue.match(re)) {
      alert("Invalid time format: " + timeFieldValue+"  hh:mm:ss");
	   $(this).val('');      
       $("#Time").select();

      return false;
    }
    var splittime = timeFieldValue.split(":");
    if(splittime[0] > 23 || splittime[1] > 59 ||splittime[2]>59) {
      alert('Please enter a valid time format(hh:mm:ss)');
       $(this).val('');      
       $("#Time").select();
      return false;
    }
});

//on the basis on seleted radio button to enhance the validation for venue option
$(function() {
<?php if(!isset($LaunchType) || $LaunchType ==1 || $LaunchType =='' ){?>  

 $("#Address").addClass("required error");
 $("#Country").addClass("required error");
 $("#City").addClass("required error");
 $("#State").addClass("required error");
 $("#Zip").addClass("required error");
  $("#URL").removeClass("required error");
<?php }else{?> 
 
 $("#Address").removeClass("required error");
 $("#Country").removeClass("required error");
 $("#City").removeClass("required error");
 $("#State").removeClass("required error");
 $("#Zip").removeClass("required error");
 $("#URL").addClass("required error");
<?php } ?>     
 });

$("#live").click(function() {

 $("#Address").addClass("required error");
 $("#Country").addClass("required error");
 $("#City").addClass("required error");
 $("#State").addClass("required error");
 $("#Zip").addClass("required error");
 $("#URL").removeClass("required error");  
 });
 
 $("#online").click(function() {

 $("#Address").removeClass("required error");
 $("#Country").removeClass("required error");
 $("#City").removeClass("required error");
 $("#State").removeClass("required error");
 $("#Zip").removeClass("required error");
  
 $("#URL").addClass("required error");  
 });


$('#myCheckBoxDuplicate').click (function ()
{

if ($(this).is(':checked'))
{
	
	var OneLineDescription = $(this).attr('OneLineDescription');
	var Description = $(this).attr('Description');
	$('#Title').attr("value",'<?php echo $data['Title'];?>');
	$('#EventType').attr("value",'<?php echo $data['EventType'];?>');
	$('#OneLineDescription').val(OneLineDescription);
	$('#Description').val(Description);
	$('#Time').attr("value",'<?php echo $data['Time'];?>');
	$('#Address').attr("value",'<?php echo $data['Address'];?>');
	$('#City').attr("value",'<?php echo $data['City'];?>');
	$('#State').attr("value",'<?php echo $data['State'];?>');
	$('#Zip').attr("value",'<?php echo $data['Zip'];?>');
	$('#Country').attr("value",'<?php echo $data['Country'];?>');
	$('#URL').attr("value",'<?php echo $data['URL'];?>');

//$("#LaunchTitle").val(<?php echo $data['Title'];?>);//LaunchTitle  EventType OneLineDescription eventTagTitle eventSelectTime Address City State Zip Country URL
}
else{

	$('#Title').attr("value",'');
	$('#EventType').attr("value",'');
	$('#OneLineDescription').attr("value",'');
	$('#Description').attr("value",'');
	$('#Time').attr("value",'');
	$('#Address').attr("value",'');
	$('#City').attr("value",'');
	$('#State').attr("value",'');
	$('#Zip').attr("value",'');
	$('#Country').attr("value",'');
	$('#URL').attr("value",'');
	
}
});
});

</script>
