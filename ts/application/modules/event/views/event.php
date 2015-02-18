<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
	'name'=>'eventForm',
	'id'=>'eventForm'
);

$eventTitle = array(
	'name'	=> 'Title',
	'id'	=> 'Title',
	'class'	=> 'width556px formTip required',
	'value'	=> $data['Title'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$otherGenre = array(

    'name'	=> 'OtherGenre',
	'id'	=> 'genre2',
	'class'	=> 'width246px formTip',
	'value'	=> $data['OtherGenre'],
	//'minlength'	=> 2,
	'maxlength'	=> 25,
	'size'	=> 30

);

$eventType = array(
	'name'	=> 'EventType',
	'id'	=> 'EventType',
	'class'	=> 'width556px formTip required',
	'value'	=> $data['EventType'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$eventShortDesc = array(
	'name'	=> 'OneLineDescription',
	'id'	=> 'OneLineDescription',
	'class'	=> 'width556px rz formTip required',
	'value'	=> $data['OneLineDescription'],
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')",
	'rows'	=> 3,
	'width'=> "500px"
);

$eventTag = array(
	'name'	=> 'Tagwords',
	'id'	=> 'Tagwords',
	'class'	=> 'width556px rz formTip required',
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	'value'	=> $data['Tagwords'],
	'rows'	=> 2
);

$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

if(isset($data['StartDate']) && $data['StartDate']!='') $StartDate = date("d F Y", strtotime(substr(@$data['StartDate'],0,-9)));
if(isset($data['FinishDate']) && $data['FinishDate']!='') $FinishDate = date("d F Y", strtotime(substr(@$data['FinishDate'],0,-9)));

$eventStartDate = array(
	'name'	=> 'StartDate',
	'id'	=> 'StartDate',
	'class'	=> 'width246px required date-input',	
	'value'	=> @$StartDate,	
	'readonly'	=> true,	
	'title' =>$this->lang->line('currentDateMsg'),	
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);
if(!isset($data['StartDate']) || @$data['StartDate']=='') {	
$eventStartDate['class']=$eventStartDate['class'].' dateGreaterThan';
$eventStartDate = array_merge($eventStartDate, array('dateGreaterThan'=>'#currentDate'));
}

$eventFinishDate = array(
	'name'	=> 'FinishDate',
	'id'	=> 'FinishDate',
	'class'	=> 'dateGreaterThan width246px date-input',
	'dateGreaterThan'=>'#StartDate',	
	'value'	=> @$FinishDate,	
	'title' =>$this->lang->line('finishDateMsg'),	
	'readonly'	=> true,
	'maxlength'	=> 50,
	'size'	=> 50,
	'rows'	=> 5,
	'style' => 'width:154px;'
);

$eventSelectTime = array(
	'name'	=> 'Time',
	'id'	=> 'Time',
	'class'	=> 'width556px formTip',
	'title'=>  $label['eventSelectTime'],
	'value'	=> $data['Time'],
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 30,
	'style' => 'width:128px;'
);

$address = array(
	'name'	=> 'Address',
	'id'	=> 'Address',
	'class'	=> 'width556px formTip',
	'value'	=> $data['Address'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$address2 = array(
	'name'	=> 'Address2',
	'id'	=> 'Address2',
	'class'	=> 'width556px formTip',
	'value'	=> $data['Address2'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$city = array(
	'name'	=> 'City',
	'id'	=> 'City',
	'class'	=> 'width556px formTip',
	'value'	=> $data['City'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$state = array(
	'name'	=> 'State',
	'id'	=> 'State',
	'class'	=> 'width556px formTip',
	'value'	=> $data['State'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$zipcode = array(
	'name'	=> 'Zip',
	'id'	=> 'Zip',
	'class'	=> 'width556px formTip',
	'value'	=> $data['Zip'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$addUrl = array(
	'name'	=> 'URL',
	'id'	=> 'URL',
	'class'	=> 'width556px formTip web_url',
	'value'	=> $data['URL'],
	//'minlength'	=> 2,
	//'maxlength'	=> 50,
	'size'	=> 50,
	
);

$VenueName = array(
	'name'	=> 'VenueName',
	'id'	=> 'VenueName',
	'class'	=> 'width556px formTip',
	'value'	=> $data['VenueName'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$VenuePhone = array(
	'name'	=> 'VenuePhone',
	'id'	=> 'VenuePhone',
	'class'	=> 'width556px formTip',
	'value'	=> $data['VenuePhone'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$VenueEmail = array(
	'name'	=> 'VenueEmail',
	'id'	=> 'VenueEmail',
	'class'	=> 'width556px formTip email',
	'value'	=> $data['VenueEmail'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$OrgName = array(
	'name'	=> 'OrgName',
	'id'	=> 'OrgName',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgName'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$orgaddress = array(
	'name'	=> 'OrgAddress',
	'id'	=> 'OrgAddress',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgAddress'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$orgaddress2 = array(
	'name'	=> 'OrgAddress2',
	'id'	=> 'OrgAddress2',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgAddress2'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
); 

$orgcity = array(
	'name'	=> 'OrgCity',
	'id'	=> 'OrgCity',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgCity'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgstate = array(
	'name'	=> 'OrgState',
	'id'	=> 'OrgState',
	'class'	=> 'width556px formTip',
	'value'	=>  $data['OrgState'],
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgzipcode = array(
	'name'	=> 'OrgZip',
	'id'	=> 'OrgZip',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgZip'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgaddUrl = array(
	'name'	=> 'OrgURL',
	'id'	=> 'OrgURL',
	'class'	=> 'width556px formTip web_url',
	'value'	=> $data['OrgURL'],
	'minlength'	=> 2,
	//'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgphoneno = array(
	'name'	=> 'OrgPhone',
	'id'	=> 'OrgPhone',
	'class'	=> 'width556px formTip',
	'value'	=> $data['OrgPhone'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

$orgemail = array(
	'name'	=> 'OrgEmail',
	'id'	=> 'OrgEmail',
	'class'	=> 'width556px formTip email',
	'value'	=> $data['OrgEmail'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	
);

 $eventTime = array(
	'name'	=> 'eventime',
	'id'	=> 'testtime',
	'time'  =>"(#testtime).val()",
	'class'	=> 'time',	
	'onblur' =>"validateHhMm(this)",
	'value'	=> $data['Time'],	
	'size'	=> 4,
);

$thisId = (isset($data['EventId']) && $data['EventId']>0)?$data['EventId']:0;

$successEventMessage = (isset($data['EventId']) && ($data['EventId']>0))?$this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('updated'):$this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('added');	

$currentEventId = array(
	'name'	=> 'EventId',
	'id'	=> 'EventId',
	'value'	=> $thisId,	
	'type' =>'hidden'
);

$lastInsertedMediaId = array(
    'name'        => 'lastInsertedMediaId',
    'id'          => 'lastInsertedMediaId',
    'value'       => $thisId,
    'type'		  => 'hidden'
);
echo form_input($lastInsertedMediaId); 

$relocateId = array(
    'name'        => 'relocateId',
    'id'          => 'relocateId',
    'value'       => $thisId,
    'type'		  => 'hidden'
);
echo form_input($relocateId); 

$thisFileId = (isset($data['FileId']) && @$data['FileId']>0)?$data['FileId']:0;
$currentFileId  = array(
	'name'	=> 'FileId',
	'id'	=> 'FileId',
	'value'	=> $thisFileId ,	
	'type' =>'hidden'
);


if(isset($eventNatureId) && $eventNatureId > 0){
	
}else{
	$eventNatureId = 1;
}



$thisNatureId = $eventNatureId;
$currentNatureId  = array(
	'name'	=> 'NatureId',
	'id'	=> 'NatureId',
	'value'	=> $thisNatureId ,	
	'type' =>'hidden'
);

$showProfileImage = '';

?>

<div class="row form_wrapper">
	
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['eventDescription'];?></h1>
		</div>
		<!------- Top Most Menu Buttons ------->   
	<?php 
		$navArray['NatureId'] = $eventNatureId;
		$navArray['EventId'] = (isset($data['EventId']) && is_numeric($data['EventId']) )?$data['EventId']:0;
		$navArray['LaunchEventId'] = (isset($data['LaunchEventId']) && is_numeric($data['LaunchEventId']) )?$data['LaunchEventId']:0;
		$navArray['currentMathod'] = 'eventform';
		echo Modules::run("event/menuNavigation",$navArray);
	?> 
	<!------ End Of Top Menu ------->
	</div>
	
	<!-- <div class="frm_wp"> -->
	<div class="row position_relative">
	<?php 
	 echo Modules::run("common/strip");
	 echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
	 echo form_input($currentNatureId);
	
	
	 echo form_input($currentEventId);
	 echo form_input($currentFileId);

	if($eventNatureId==1)
	{
		if(isset($data['filePath']) && @$data['filePath']!=''){
			 $imagePathForEvent = @$data['filePath'].'/'.@$data['fileName'];
			 $smallLaunchImg = addThumbFolder(@$imagePathForEvent,'_s');
		   }
		else $smallLaunchImg = '';


		$finalSmallImg=getImage($smallLaunchImg,$this->config->item('defaultEventImg_s'));
		$eventMediaSrc = '<img id="galImg_'.$thisId.'" style="max-width: 100px; max-height: 100px; margin: auto;" src="'.$finalSmallImg.'" alt="'.$data['Title'].'" />'."";
		$browseImgJs = '_showcaseImgJs';	
		
		$stockImageFlag = 0;
		$norefresh = 1;
		$required = 0;
		$checksection = 'redirect';
				
		$fileData=array('imgSrc'=>$finalSmallImg,'typeOfFile'=>1,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$eventMediaPath,'embedCode'=>'', 'required'=>'', 'label'=>$this->lang->line('image'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseImgJs,'imgload'=>1,'norefresh'=>0, 'view'=>'upload_ws_frm');
		echo Modules::run("common/formInputField",$fileData);
		
	}
?>	

	 <div class="row">
		<div class="cell label_wrapper"><label class="select_field"><?php echo $label['title'];?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($eventTitle); ?>
				<div class="red"><?php echo form_error($eventTitle['name']); ?></div>
		</div>
	 </div>
<?php 
 
		$value=set_value('OneLineDescription')?set_value('OneLineDescription'):@$eventShortDesc['value'];
		$value=htmlentities($value);
		$onlneDes=array('name'=>'OneLineDescription','value'=>$value, 'required'=>'required', 'labelText'=>'oneLineDescription', 'view'=>'oneline_description');
		echo Modules::run("common/formInputField",$onlneDes);

		$value=set_value('Tagwords')?set_value('Tagwords'):@$eventTag['value'];
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
										
					if((isset($data['Industry']) && $data['Industry']!='')) 
					{
						$eventIndustryVal=$data['Industry'];
					}else 
					{
						$eventIndustryVal=0;
						$catiD=0;
					}
														
					$selInds=set_value('Industry')?set_value('Industry'):@$eventIndustryVal;	
					
					echo form_dropdown($eventIndustryName, $eventIndustryList, $selInds ,'id="Industry" class="required" onchange="getTypeListGenre(\'projectTypeList\',\'\',this.value,'.$catiD.');"');
				?>
		</div>
	 </div>
	 
	<!-- Show the radio button of event and launch for notification only -->
	<?php	
	if(@$eventNatureId==1)
	{ 
	
	?>
	 <div class="row">
		<div class="cell label_wrapper bg_none"><label class="bg_none"></label></div>
			<div class="cell frm_element_wrapper" >
					<div class="row" style="padding-top:0px">
						<div class="cell defaultP" id="event">
						  <input type="radio" class="radio" name="EventType" value="1" id="event" <?php if(!isset($data['EventType']) || @$data['EventType']==1 || @$data['EventType']=='') echo 'checked="checked"';?> />
						</div>
						<div class="cell widthSpacer"> &nbsp;</div>

						<div class="cell width90px">
							<label class="lH25"> <?php echo $label['event'];?> </label>
						</div>					
						<div class="cell defaultP" id="launch">
							<input type="radio" class="radio" name="EventType" value="2" id="launch" <?php if($data['EventType']==2) echo 'checked="checked"';?> />
						</div>
					
						<div class="cell">
							<label class="lH25"> <?php echo $label['launch'];?> </label>
						</div>
					</div>
		</div>
	 </div>
	 <?php } ?>
	 
	 <div class="row">
		<div class="cell label_wrapper bg_none"><label class="bg_none"></label></div>
			<div class="cell frm_element_wrapper" >
					<div class="row" style="padding-top:0px">
						<div class="cell defaultP" id="live">
						  <input type="radio" class="radio" name="Type" value="1" id="live" <?php if(!isset($data['Type'])||@$data['Type']==1 || @$data['Type']=='') echo 'checked="checked"';?> />
						</div>
						<div class="cell widthSpacer"> &nbsp;</div>

						<div class="cell width90px">
							<label class="lH25"> <?php echo $label['live'];?> </label>
						</div>
					
						<div class="cell defaultP" id="online">
							<input type="radio" class="radio" name="Type" value="2" id="online" <?php if($data['Type']==2) echo 'checked="checked"';?> />
						</div>
					
						<div class="cell">
							<label class="lH25"> <?php echo $label['online'];?> </label>
						</div>
					</div>
		</div>
	 </div>
	
	 <div class="row">
		<div class="cell label_wrapper bg_none"><label class="bg_none"></label></div>
			<div class="cell frm_element_wrapper" >
					<div class="row" style="padding-top:0px">
						<div class="cell defaultP" id="Entertainment">
						  <input type="radio" class="radio" name="Genre" value="1" id="Entertainment" <?php if(!isset($data['Genre']) || @$data['Genre']==1 || @$data['Genre']=='') echo 'checked="checked"';?> />
						</div>
						<div class="cell widthSpacer"> &nbsp;</div>

						<div class="cell">
							<label class="lH25"><?php echo $label['entertainment'];?> </label>						
						</div>

						<div class="cell widthSpacer pr10"> &nbsp;</div>
					
						<div class="cell defaultP" id="Educational">
							<input type="radio" class="radio" name="Genre" value="2" id="Educational" <?php if($data['Genre']==2) echo 'checked="checked"';?> />
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
		 
	<div class="seprator_25 clear row"></div>
	
	
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
		<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('eventStartDate');?></label></div>
			<div class="cell frm_element_wrapper" >
				<div class="cell" >
					<?php  echo form_input($currentDate); echo form_input($eventStartDate); ?>
					<div class="red"><?php echo form_error($eventStartDate['name']); ?></div>
				</div>
				
				<div class="cell widthSpacer10">&nbsp;</div>
				<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#StartDate").focus();' /> </div>
		</div>
	 </div>

	 <div class="row">
			<div class="cell label_wrapper">
				<label>
					<?php echo $this->lang->line('eventFinishDate');?>
				</label>
			</div>
			<div class="cell frm_element_wrapper" >
				<div class="cell">
					<?php echo form_input($eventFinishDate); ?>
					<div class="red"><?php echo form_error($eventFinishDate['name']); ?></div>
				</div>
				<div class="cell widthSpacer10">&nbsp;</div>
				<div class="cell" style="padding-top:5px;"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#FinishDate").focus();' /> </div>
			</div>
	</div>
	
	<!-- Show the Venue detail for notification only -->
	<?php	
	if(@$eventNatureId==1)
	{ 
	
	?>
	 <div class="row">
			<div class="cell label_wrapper"><div class="lable_heading"><h1><?php echo $label['addLocation']; ?></h1></div></div>
			<div class="cell frm_element_wrapper" >&nbsp;</div>
	 </div>	
	 <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['venueName'];?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($VenueName); ?>
				<div class="red">
					<?php echo form_error($VenueName['name']); ?>
				</div>
		</div>
	 </div>
	 
  	 <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['address1']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($address); ?>
				<div class="red">
					<?php echo form_error($address['name']); ?>
				</div>
		</div>
	 </div>
	 
	  <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['address2']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($address2); ?>
				<div class="red">
					<?php echo form_error($address2['name']); ?>
				</div>
		</div>
	 </div>
	 
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['twnRcity']; ?></label></div>
			<div class="cell frm_element_wrapper" >
			<?php echo form_input($city); ?>
			<div class="red"><?php echo form_error($city['name']); ?></div>
		</div>
	</div>	 
	 
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['state']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($state); ?>
				<div class="red">
					<?php echo form_error($state['name']); ?>
				</div>
		</div>
	 </div>
	 	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['zipcode']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($zipcode); ?>
				<div class="red">
					<?php echo form_error($zipcode['name']); ?>
				</div>
		</div>
	 </div>
	 
	 <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['country']; ?></label></div>
			<div class="cell frm_element_wrapper" >
			<?php	
				$CountryName = $label['country'];
				if((isset($data['Country']) && $data['Country']>0)) 
				{
					$CountryVal= $data['Country'];
				} else {
					$CountryVal= '';
				} 
				$attr = 'id="Country" class="dropDown single"';
				echo form_dropdown($CountryName,$countries,$CountryVal,$attr);
			?>
			<div class="red">
				<?php echo form_error($CountryName); ?>
			</div>
		</div>
	 </div>	
	
	 <div class="row">
		<div class="cell label_wrapper"><label><?php echo $label['addUrl']; ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($addUrl); ?>
				<div class="red">
					<?php echo form_error($addUrl['name']); ?>
				</div>
		</div>
	 </div>
	 
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('phoneNo'); ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($VenuePhone); ?>
				<div class="red">
					<?php echo form_error($VenuePhone['name']); ?>
				</div>
		</div>
	 </div>


	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('email'); ?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($VenueEmail); ?>
				<div class="red">
					<?php echo form_error($VenueEmail['name']); ?>
				</div>
		</div>
	 </div>	 
	<?php }	?> 
	
 
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
				$CountryName = $label['country'];				
				$orgCountryVal= $data['OrgCountry'];
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
	

	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper pagingWrapper">
			<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
			<input type="hidden" name="save" value="" />
			 <div class="fr">			 
			 <?php
			
				$button=array('ajaxSave');
				echo Modules::run("common/loadButtons",$button); 
			 ?>	
			 	<div class="tds-button fl"><button onclick="cancelfrmhere();" id="cancelButton" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div> <div class="icon-form-cancel-btn"></div></span></button></div>	
			 </div>	 
			 <div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
			<?php if($moduleMethod=='eventnotifications'){?>
			 <div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
				<a href="<?php echo site_url(lang()).'/event/eventnotifications';?>" target="_blank">Index page</a>.</div>
			</div>
			<?php }?>
		</div>		
		<div class="clear"></div>	
	</div>
	<?php echo form_close();?>
</div>
</div>

<?php
if(!isset($browseImgJs)){ 
	$browseImgJs=''; 
}
$fileImg="fileInput".$browseImgJs;
$fileNameImage="fileName".$browseImgJs;
?>
<script type="text/javascript"> 

$("#testtime").mask("ho:nm");

function cancelfrmhere() {	
  window.location.href= '<?php echo $returnBack;?>';	
}

$(document).ready(function() {
	$("#FinishDate").change(function() {
		var sDate = new Date($(this).val());
	});   
	
	$("#eventForm").validate({
		rules: {
		   Language: {
				required:true,
				NumGrtrZero:true
			} 
		 },
		 messages: {
					OneLineDescription: "<?php echo $this->lang->line('requires_3_50_words');?>",
					Tagwords: "<?php echo $this->lang->line('requires_3_25_words');?>",
					Language: "<?php echo $this->lang->line('thisFieldIsReq');?>"
		},
		submitHandler: function() {						
			
			var eventNatureId = '<?php echo $eventNatureId;?>';
			eventNatureId = parseInt(eventNatureId);
			
			var elementId = $('#EventId').val();
			var fileId = $('#FileId').val();
			
			var imagePath = '<?php echo $eventMediaPath;?>';
			var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
			var Type = $('input:radio[name=Type]:checked').val();		
			var Genre = $('input:radio[name=Genre]:checked').val();
			var EventType = $('input:radio[name=EventType]:checked').val();
			var countryId = $('#Country').val()?$('#Country').val():0;
			var OrgCountryId = $('#OrgCountry').val()?$('#OrgCountry').val():0;
			var FinishDate = $('#FinishDate').val()?$('#FinishDate').val():$('#StartDate').val();
			
			var fileImg = $('#fileInput<?php echo $browseImgJs;?>').val();
			
			if(fileImg==undefined){
				fileImg = '';
			}	

			if( (fileImg.length >= 4) && (eventNatureId == 1) ){ 
				var imgData = {"filePath":imagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#<?php echo $fileNameImage;?>').val(),"fileSize":fileSize,"fileType":'1',"isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>}; 
			}
			else { 
				var imgData = ''; 
			}		
			
			if(elementId ==0) {
				if(eventNatureId == 1){
						var data = {"Title":$('#Title').val(),"NatureId":$('#NatureId').val(),"Language":$('#Language').val(),"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"EventType":EventType,"Type":Type,"Genre":Genre,"OtherGenre":$('#genre2').val(),"StartDate":$('#StartDate').val(),"FinishDate":FinishDate,"VenueName":$('#VenueName').val(),"VenuePhone":$('#VenuePhone').val(),"VenueEmail":$('#VenueEmail').val(),"Address":$('#Address').val(),"Address2":$('#Address2').val(),"City":$('#City').val(),"State":$('#State').val(),"Country":countryId,"Zip":$('#Zip').val(),"URL":$('#URL').val(),"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"EventDateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"EventDateModified":'<?php echo date('Y-m-d h:i:s'); ?>'};
				}else{
						var data = {"Title":$('#Title').val(),"NatureId":$('#NatureId').val(),"Language":$('#Language').val(),"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"EventType":EventType,"Type":Type,"Genre":Genre,"OtherGenre":$('#genre2').val(),"StartDate":$('#StartDate').val(),"FinishDate":FinishDate,"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"EventDateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"EventDateModified":'<?php echo date('Y-m-d h:i:s'); ?>'};
				}
				 
			}
			else {
				if(eventNatureId == 1){
						var data = {"EventId":elementId,"Language":$('#Language').val(),"Title":$('#Title').val(),"NatureId":$('#NatureId').val(),"Type":Type,"Genre":Genre,"EventType":EventType,"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"OtherGenre":$('#genre2').val(),"StartDate":$('#StartDate').val(),"FinishDate":FinishDate,"VenueName":$('#VenueName').val(),"VenuePhone":$('#VenuePhone').val(),"VenueEmail":$('#VenueEmail').val(),"Address":$('#Address').val(),"Address2":$('#Address2').val(),"City":$('#City').val(),"State":$('#State').val(),"Country":countryId,"Zip":$('#Zip').val(),"URL":$('#URL').val(),"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"EventDateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 	
				}else{
						var data = {"EventId":elementId,"Language":$('#Language').val(),"Title":$('#Title').val(),"NatureId":$('#NatureId').val(),"Type":Type,"Genre":Genre,"EventType":EventType,"OneLineDescription":$('#OneLineDescription').val(),"Tagwords":$('#Tagwords').val(),"Industry":$('#Industry').val(),"OtherGenre":$('#genre2').val(),"StartDate":$('#StartDate').val(),"FinishDate":FinishDate,"OrgName":$('#OrgName').val(),"OrgURL":$('#OrgURL').val(),"OrgAddress":$('#OrgAddress').val(),"OrgAddress2":$('#OrgAddress2').val(),"OrgCity":$('#OrgCity').val(),"OrgState":$('#OrgState').val(),"OrgCountry":OrgCountryId,"OrgZip":$('#OrgZip').val(),"OrgEmail":$('#OrgEmail').val(),"OrgPhone":$('#OrgPhone').val(),"tdsUid":<?php echo isLoginUser(); ?>,"EventDateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 	
				}
					
			}
			
			if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
			var returnFlag = AJAX_json('<?php echo base_url(lang()."/event/eventjquerysave");?>','',elementId,data,fileId,imgData,'EventId');
			
			if(returnFlag)
			{		
				
				$('#messageSuccessError').html('<div class="successMsg"><?php echo $successEventMessage;?></div>');
				timeout = setTimeout(hideDiv, 5000);	
				
				if(eventNatureId==1){
					var returnform = baseUrl+language+'/event/'+'<?php echo $this->router->method;?>'+'/eventform/'+returnFlag.id;
				}
				else{
					if(elementId > 0) {
						var returnform = baseUrl+language+'/event/'+'<?php echo $this->router->method;?>'+'/eventform/'+returnFlag.id;
					} else{
						var returnform = baseUrl+language+'/event/'+'<?php echo $this->router->method;?>'+'/eventsession/'+returnFlag.id;
					} 
				}				
				$('#relocateId').val(returnform);
										
				$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();	
				if((fileImg.length < 4) ){ 
					window.location.href = returnform;
				}
				
				return true;
			}	
		}
	});
});
</script>
