<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$action = $this->router->class.'/launch/'.$this->router->method;

$successEventMessage = (isset($data['LaunchEventId']) && ($data['LaunchEventId']>0))?$this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('updated'):$this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('added');	
	
$formAttributes = array(
	'name'=>'launchEventForm',
	'id'=>'launchEventForm'
); 

$eventTitle = array(
	'name'	=> 'Title',
	'id'	=> 'Title',
	'class'	=> 'Bdr2 width556px required',
	'value'	=> isset($data['Title'])?@$data['Title']:'',
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$eventType = array(
	'name'	=> 'EventType',
	'id'	=> 'EventType',
	'class'	=> 'Bdr2 width556px required',
	'title'=>  $label['eventType'],
	'value'	=> isset($data['EventType'])?$data['EventType']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
); 

$otherGenre =array(

    'name'	=> 'OtherGenre',
	'id'	=> 'genre2',
	'class'	=> 'width265px  ',
	//'title'=>  $label['otherGenre'],
	'value'	=> @$data['OtherGenre'],
	'minlength'	=> 2,
	'maxlength'	=> 25,
	'size'	=> 30
);

$eventShortDesc = array(
	'name'	=> 'OneLineDescription',
	'id'	=> 'OneLineDescription',
	'class'	=> 'width556px rz  required',
	'title'=>  $label['eventDescriptionTitle'],
	'value'	=> isset($data['OneLineDescription'])?$data['OneLineDescription']:'',
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')",
	'rows'	=> 3,
	'width'=> "500px"
);

$eventTag = array(
	'name'	=> 'Tagwords',
	'id'	=> 'Tagwords',
	'class'	=> 'BdrCommonTextarea heightAuto rz  required',
	'title'=>  $label['eventTagTitle'],
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	'value'	=> isset($data['Tagwords'])?$data['Tagwords']:'',
	'rows'	=> 2
);

$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

if(@$data['LaunchDate']!='')
	$LaunchDate = date('d F Y',$data['LaunchDate']);
else
	$LaunchDate = '';
$eventLaunchDate = array(
	'name'	=> 'LaunchDate',
	'id'	=> 'LaunchDate',
	'class'	=> 'BdrCommon required  date-input',	
	'value'	=> $LaunchDate,	
	'minlength'	=> 2,
	'title' =>'Launch date must be greater than/equal to Current date',
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);
if(!isset($data['LaunchDate']) || @$data['LaunchDate']=='') {
$eventLaunchDate['class'] = $eventLaunchDate['class'].' dateGreaterThan';
$eventLaunchDate = array_merge($eventLaunchDate, array('dateGreaterThan'=>'#currentDate'));
}


$eventSelectTime = array(
	'name'	=> 'Time',
	'id'	=> 'Time',
	'class'	=> 'Bdr2  required ',
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
	'class'	=> 'Bdr2 width556px',
	'title'=>  $label['address'],
	'value'	=> isset($data['Address'])?$data['Address']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
); 

$address2 = array(
	'name'	=> 'Address2',
	'id'	=> 'Address2',
	'class'	=> 'Bdr2 width556px',
	'title'=>  $label['address2'],
	'value'	=> isset($data['Address2'])?$data['Address2']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
); 

$city = array(
	'name'	=> 'City',
	'id'	=> 'City',
	'class'	=> 'Bdr2 width556px',
	'title'=>  $label['city'],
	'value'	=> isset($data['City'])?$data['City']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$state = array(
	'name'	=> 'State',
	'id'	=> 'State',
	'class'	=> 'Bdr2 width556px',
	'title'=>  $label['state'],
	'value'	=> isset($data['State'])?$data['State']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$zipcode = array(
	'name'	=> 'Zip',
	'id'	=> 'Zip',
	'class'	=> 'Bdr2 width556px',
	'title'=>  $label['zipcode'],
	'value'	=> isset($data['Zip'])?$data['Zip']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$country = array(
	'name'	=> 'Country',
	'id'	=> 'Country',
	'class'	=> 'Bdr2 ',
	'title'=>  $label['country'],
	'value'	=> isset($data['Country'])?$data['Country']:0,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$addUrl = array(
	'name'	=> 'URL',
	'id'	=> 'URL',
	'class'	=> 'Bdr2  required width556px',
	'title'=>  $label['addUrl'],
	'value'	=> isset($data['URL'])?$data['URL']:'',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$eventDescription = array(
	'name'	=> 'Description',
	'id'	=> 'Description',
	'class'	=> 'width556px rz  required',
	'title'=>  $label['eventDescription50to100'],
	'value'	=> isset($data['Description'])?$data['Description']:'',
	'wordlength'=>"50,100",
	'onkeyup'=>"checkWordLen(this,100,'eventdescriptionLimit')",
	
	'rows'	=> 8
);


$OrgName = array(
	'name'	=> 'OrgName',
	'id'	=> 'OrgName',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgName'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgaddress = array(
	'name'	=> 'OrgAddress',
	'id'	=> 'OrgAddress',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgAddress'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$orgaddress2 = array(
	'name'	=> 'OrgAddress2',
	'id'	=> 'OrgAddress2',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgAddress2'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$orgcity = array(
	'name'	=> 'OrgCity',
	'id'	=> 'OrgCity',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgCity'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgstate = array(
	'name'	=> 'OrgState',
	'id'	=> 'OrgState',
	'class'	=> 'width556px formTip',
	'value'	=>  @$data['OrgState'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgzipcode = array(
	'name'	=> 'OrgZip',
	'id'	=> 'OrgZip',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgZip'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgaddUrl = array(
	'name'	=> 'OrgURL',
	'id'	=> 'OrgURL',
	'class'	=> 'width556px formTip web_url',
	'value'	=> @$data['OrgURL'],
	'minlength'	=> 2,
	//'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgphoneno = array(
	'name'	=> 'OrgPhone',
	'id'	=> 'OrgPhone',
	'class'	=> 'width556px formTip',
	'value'	=> @$data['OrgPhone'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgemail = array(
	'name'	=> 'OrgEmail',
	'id'	=> 'OrgEmail',
	'class'	=> 'width556px formTip email',
	'value'	=> @$data['OrgEmail'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);


$showProfileImage = '';
?>

<div class="row form_wrapper">	
	<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $label['launchDescription'];?></h1>
	</div>
	<!------- Top Most Menu Buttons ------->   
	<?php 

	$navArray['NatureId'] = $eventNatureId;
	$navArray['EventId'] = (isset($data['EventId']) && is_numeric($data['EventId']) )?$data['EventId']:0;
	$navArray['LaunchEventId'] = (isset($data['LaunchEventId']) && is_numeric($data['LaunchEventId']) )?$data['LaunchEventId']:0;
	$navArray['currentMathod'] = 'launcheventform';
	echo Modules::run("event/menuNavigation",$navArray);

	?> 
	<!------ End Of Top Menu ------->
	</div> <!--row -->
<?php 

$frmEventId = array('name'	=> 'EventId',
	'id'	=> 'EventId',
	'value'	=> (@$data['EventId']>0)?$data['EventId']:0,
	'type'	=> 'hidden'
	);
	
$frmLaunchEventId = array('name'	=> 'LaunchEventId',
	'id'	=> 'LaunchEventId',
	'value'	=> (@$data['LaunchEventId']>0)?$data['LaunchEventId']:0,
	'type'	=> 'hidden'
	);

	
$relocateId = array(
    'name'        => 'relocateId',
    'id'          => 'relocateId',
    'value'       => (@$data['LaunchEventId']>0)?$data['LaunchEventId']:0,
    'type'		  => 'hidden'
);

$frmNatureId = array('name'	=> 'NatureId',
	'id'	=> 'NatureId',
	'value'	=> $eventNatureId,
	'type'	=> 'hidden'
	);
	
$thisFileId = (isset($data['FileId']) && @$data['FileId']>0)?$data['FileId']:0;
$currentFileId  = array(
	'name'	=> 'FileId',
	'id'	=> 'FileId',
	'value'	=> $thisFileId ,	
	'type' =>'hidden'
);

?>	
<div class="clear"></div>

<div class="row position_relative">
<?php echo Modules::run("common/strip");?>

<div id="Events-Content-Box">		
<?php 

echo form_open_multipart($this->uri->uri_string(),$formAttributes); 

echo form_input($frmEventId);
echo form_input($frmLaunchEventId);
echo form_input($frmNatureId);
echo form_input($currentFileId);
echo form_input($relocateId);

if(!isset($data['LaunchEventId']) || @$data['LaunchEventId']<=0) 
{
	if( (isset($data['EventId']) && $data['EventId']>0))
	{
			
		$jsonCheckDataArray = array("Title"=>@$data['Title'],"EventType"=>@$data['EventType'],"OtherGenre"=>@$data['OtherGenre'],"OrgName"=>@$data['OrgName'],"OrgAddress"=>@$data['OrgAddress'],"OrgAddress2"=>@$data['OrgAddress2'],"OrgState"=>@$data['OrgState'],"OrgCountry"=>@$data['OrgCountry'],"OrgZip"=>@$data['OrgZip'],"OrgCity"=>@$data['OrgCity'],"OrgPhone"=>@$data['OrgPhone'],"OrgURL"=>@$data['OrgURL'],"OrgEmail"=>@$data['OrgEmail'],"OneLineDescription"=>@$data['OneLineDescription'],"Description"=>@$data['Description'],"Tagwords"=>@$data['Tagwords'],"FileId"=>@$data['FileId']);
		$jsoncheckData=json_encode($jsonCheckDataArray);
				
		?>
		<script>
		var checkData = <?php echo $jsoncheckData; ?>;
		</script>
		
	<div class="row">
		<div class="label_wrapper cell">&nbsp;</div>
		<div class="cell frm_element_wrapper">
			<div class="cell" >	<div class="defaultP"><input type="checkbox" id="myCheckBoxDuplicate" name="myCheckBoxDuplicate" checked ="checked" onclick="myEventDuplicate(checkData)" /></div></div>
			<div class="cell" style="padding-left:10px"><?php echo $label['checkToDuplicate']; ?></div>
		</div>
	</div>
	<?php 
	}
}?>
<div class="row heightSpacer"> &nbsp;</div>
    <div class="row"> 	
		 <div class="label_wrapper cell">
			 <label class="select_field"><?php echo $label['title'];?></label>
		 </div><!--label_wrapper-->
		 <div class="cell frm_element_wrapper">
		  <?php echo form_input($eventTitle); ?>
		  <div class="row wordcounter">					  
			<?php echo form_error($eventTitle['name']); ?>
		  </div> <!--row wordcounter--> 		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
<?php 

$value=set_value('OneLineDescription')?set_value('OneLineDescription'):@$eventShortDesc['value'];
$value=htmlentities($value);
$onlneDes=array('name'=>'OneLineDescription','value'=>$value, 'required'=>'required', 'labelText'=>'oneLineDescription', 'view'=>'oneline_description');
echo Modules::run("common/formInputField",$onlneDes);

$value= isset($data['Tagwords'])?$data['Tagwords']:'';
$value=htmlentities($value);
$tagVal=array('name'=>'Tagwords','id'=>'Tagwords','value'=>$value,'required'=>'required', 'labelText'=>'tagWords', 'view'=>'tag_words');
echo Modules::run("common/formInputField",$tagVal);

?>
<div class="seprator_25 clear row"></div>
 <div class="row">
	<div class="cell label_wrapper"><label class="select_field"><?php echo $label['eventLabIndustry'];?></label></div>
	<div class="cell frm_element_wrapper" >
		<?php
			$eventIndustryName = "Industry";			
			if((isset($data['Industry']) && $data['Industry']!='')) {
			  $eventIndustryVal=$data['Industry'];
			}else {							
			   $eventIndustryVal='0';
			}
			
			echo form_dropdown($eventIndustryName, $eventIndustryList, $eventIndustryVal ,'id="Industry" class="required" ');
		?>
	</div>
 </div>
	 
	 <div class="row">
		<div class="cell label_wrapper bg_none"><label class="bg_none"></label></div>
			<div class="cell frm_element_wrapper" >
				<div class="row" style="padding-top:0px">
					<div class="cell defaultP" id="live">
					  <input type="radio" class="radio" name="Type" value="1" id="live" <?php if(@$data['Type']==1 || @$data['Type']=='') echo 'checked';?> />
					</div>
					<div class="cell widthSpacer"> &nbsp;</div>

					<div class="cell  width90px">
						<label class="lH25"> <?php echo $label['live'];?> </label>
					</div>			
					<div class="cell defaultP" id="online">
						<input type="radio" class="radio" name="Type" value="2" id="online" <?php if(@$data['Type']==2) echo 'checked';?> />
					</div>			
					<div class="cell">
						<label class="lH25"> <?php echo $label['online'];?> </label>
					</div>
			  </div>			
		</div>
	 </div>
	 
	 <div class="row">
		<div class="cell label_wrapper bg_none">
			<label class="bg_none"></label>
		</div>
		<div class="cell frm_element_wrapper" >
			<div class="row" style="padding-top:0px">
				<div class="cell defaultP" id="Entertainment">
				  <input type="radio" class="radio" name="Genre" value="1" id="Entertainment" <?php if(@$data['Genre']==1 || @$data['Genre']=='') echo 'checked';?> />
				</div>
				<div class="cell widthSpacer"> &nbsp;</div>

				<div class="cell">
				 <label class="lH25"><?php echo $label['entertainment'];?> </label>						
				</div>

				<div class="cell widthSpacer pr10"> &nbsp;</div>
			
				<div class="cell defaultP" id="Educational">
					<input type="radio" class="radio" name="Genre" value="2" id="Educational" <?php if(@$data['Genre']==2) echo 'checked';?> />
				</div>
			
				<div class="cell">
				 <label class="lH25"><?php echo $label['educational'];?></label>
				</div>
			</div>
		</div>
	</div>
	 	 
	 

        <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['type'];?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($otherGenre); ?>
				<div class="red"><?php echo form_error($otherGenre['name']); ?></div>
		</div>
	 </div>	

	  
		<div class="row">
			<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('originalLanguage'); ?></label></div>
			<div class="cell frm_element_wrapper">
				<div class="fl" id="eventTypeList" >
					<?php 
					
					    if((isset($data['Language']) && @$data['Language']!='')) {
							  $originalLanguage=$data['Language'];
						}else {							
							   $originalLanguage='';
						}	
						
						$originalLanguageList = getlanguageList();
						echo form_dropdown('Language', $originalLanguageList, $originalLanguage,'id="Language" class="required single"');
						
					?>
				</div>
				<div class="row wordcounter"><?php echo form_error('Type'); ?></div>
			</div>
		</div>	

 <div class="row">
	<div class="cell label_wrapper"><div class="lable_heading"><h1><?php echo $label['orgInfo'];?></h1></div></div>
	<div class="cell frm_element_wrapper" >&nbsp;</div>
 </div>
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['venueName'];?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($OrgName); ?>
				<div class="red"><?php echo form_error($OrgName['name']); ?></div>
		</div>
	</div>
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['address1']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgaddress); ?>
				<div class="red"><?php echo form_error($orgaddress['name']); ?></div>
		</div>
	</div>
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['address2']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgaddress2); ?>
				<div class="red"><?php echo form_error($orgaddress2['name']); ?></div>
		</div>
	</div>
	
	 <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['twnRcity']; ?></label></div>
			<div class="cell frm_element_wrapper" >
			<?php echo form_input($orgcity); ?>
			<div class="red"><?php echo form_error($orgcity['name']); ?></div>
		</div>
	 </div>
	 
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['state']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgstate); ?>
				<div class="red"><?php echo form_error($orgstate['name']); ?></div>
		</div>
	</div>

	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['zipcode']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgzipcode); ?>
				<div class="red"><?php echo form_error($orgzipcode['name']); ?></div>
		</div>
	 </div>	
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['country']; ?></label></div>
			<div class="cell frm_element_wrapper" >
			<?php
				//echo '<pre />';	print_r($data);		
				$CountryName = "Country";		
				$orgCountryVal= @$data['OrgCountry'];
				$attr = 'id="OrgCountry" class="dropDown single"';
				echo form_dropdown('OrgCountry',$countries,$orgCountryVal,$attr);
			?>
			<div class="red"><?php echo form_error($CountryName); ?></div>
		</div>
	</div>	
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['addUrl']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgaddUrl); ?>
				<div class="red"><?php echo form_error($orgaddUrl['name']); ?></div>
			</div>
	</div>
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('emailAddress'); ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgemail); ?>
				<div class="red"><?php echo form_error($orgemail['name']); ?></div>
			</div>
	</div>	
		 
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('phoneNo'); ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($orgphoneno); ?>
				<div class="red"><?php echo form_error($orgphoneno['name']); ?></div>
			</div>
	</div>	
	
	<input type="hidden" name="formtype" value="">
    <div class="clear"></div>
    
	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class="cell frm_element_wrapper pagingWrapper">
			<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
			<input type="hidden" name="save" value="" />
			<div class="fr">
			<?php
				$button=array('ajaxSave');
				echo Modules::run("common/loadButtons",$button); 
			?>
			<div class="tds-button fl"><button onclick="cancelfrmhere();" id="cancelButton" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div> <div class="icon-form-cancel-btn"></div></span></button></div>
			</div>
			<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
		</div>	
		<div class="clear"></div>
	</div> <!-- row -->	
	<?php echo form_close();?>	
</div> <!--row form_wrapper-->
</div> <!--row tab_wp pt2 -->
</div>

<script type="text/javascript"> 

function cancelfrmhere() {	
  window.location.href= '<?php echo $returnBack;?>';	
}
$(document).ready(function() {
	$("#launchEventForm").validate({
		submitHandler: function() {
			
			var elementId = $('#LaunchEventId').val();
			var fileId = $('#FileId').val();
			var EventId = $('#EventId').val();
			if(!EventId > 0) EventId = 0;
			
			var Type = $('input:radio[name=Type]:checked').val();		
			var Genre = $('input:radio[name=Genre]:checked').val();
			var OrgCountryId = $('#OrgCountry').val()?$('#OrgCountry').val():0;
			
			var imgData = '';	
			
			if(elementId ==0)
				var data = {"Title":$('#Title').val(),"Language":$('#Language').val(),"FileId":$('#FileId').val(),"NatureId":$('#NatureId').val(),"EventId":EventId,"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"Type":Type,"Genre":Genre,"OtherGenre":$('#genre2').val(),"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"LaunchEventCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"LaunchEventModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
			else
				var data = {"LaunchEventId":elementId,"Title":$('#Title').val(),"Language":$('#Language').val(),"FileId":$('#FileId').val(),"NatureId":$('#NatureId').val(),"EventId":EventId,"Type":Type,"Genre":Genre,"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"OtherGenre":$('#genre2').val(),"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"LaunchEventModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 		
			
			var returnFlag = AJAX_json('<?php echo base_url(lang()."/event/eventjquerysave");?>','',elementId,data,fileId,imgData,'LaunchEventId');
			if(returnFlag){
				
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $successEventMessage;?></div>');
					timeout = setTimeout(hideDiv, 5000);
					
					
					if(elementId > 0) {
						var returnform = baseUrl+language+'/event/'+'<?php echo $this->router->method;?>'+'/launcheventform/'+returnFlag.id;
						
					} else { 
						var returnform = baseUrl+language+'/event/'+'<?php echo $this->router->method;?>'+'/launchsession/'+returnFlag.id;
						
					} 	
					
					//$('#relocateId').val(returnform);
					//$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();
						
					//if($('#fileName<?php echo $browseImgJs;?>').val() =='') { window.location.href = returnform;}
					window.location.href = returnform;
					return true;
			}
		}
	});
});


function myEventDuplicate(eventValues)
{
	if ($('#myCheckBoxDuplicate').is(':checked'))
	{
		var Title = eventValues.Title;	
		var EventType = eventValues.EventType;	
		var OtherGenre = eventValues.OtherGenre;	
		var OrgName = eventValues.OrgName;	
		var OrgAddress = eventValues.OrgAddress;	
		var OrgAddress2 = eventValues.OrgAddress2;	
		var OrgState = eventValues.OrgState;	
		var OrgCountry = eventValues.OrgCountry;	
		var OrgZip = eventValues.OrgZip;	
		var OrgCity = eventValues.OrgCity;	
		var OrgPhone = eventValues.OrgPhone;	
		var OrgURL = eventValues.OrgURL;	
		var OrgEmail = eventValues.OrgEmail;	
		var OneLineDescription = eventValues.OneLineDescription;	
		var Description = eventValues.Description;
		var Tagwords = eventValues.Tagwords;
		var FileId = eventValues.FileId;
		
		$('#Title').attr("value",Title);
		$('#EventType').attr("value",EventType);
		$('#OneLineDescription').val(OneLineDescription);
		$('#Description').val(Description);
		$('#Tagwords').val(Tagwords);
		$('#genre2').attr("value",OtherGenre);
		$('#OrgName').attr("value",OrgName);
		$('#OrgAddress').attr("value",OrgAddress);
		$('#OrgAddress2').attr("value",OrgAddress2);
		$('#OrgState').attr("value",OrgState);
		$('#OrgCountry').attr("value",OrgCountry);
		$('#OrgZip').attr("value",OrgZip);
		$('#OrgCity').attr("value",OrgCity);
		$('#OrgPhone').attr("value",OrgPhone);
		$('#OrgURL').attr("value",OrgURL);
		$('#OrgEmail').attr("value",OrgEmail);
		$('#OrgEmail').attr("value",OrgEmail);
		$('#FileId').attr("value",FileId);
		

	
	}
	else{

		$('#Title').attr("value",'');
		$('#EventType').attr("value",'');
		$('#OneLineDescription').attr("value",'');
		$('#Description').attr("value",'');
		$('#Tagwords').attr("value",'');
		$('#genre2').attr("value",'');
		$('#Time').attr("value",'');
		$('#Address').attr("value",'');
		$('#City').attr("value",'');
		$('#State').attr("value",'');
		$('#Zip').attr("value",'');
		$('#Country').attr("value",'');
		$('#URL').attr("value",'');
		$('#FileId').attr("FileId",0);
		$('#galImg_').attr('src','<?php echo getImage('',$this->config->item('defaultEventImg_s'));?>');		
	}
}

</script>
