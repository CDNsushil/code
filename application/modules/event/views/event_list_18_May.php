<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


<!--eventPreviewBoxWp START-->
<div id="postPreviewBoxWp" class="postPreviewBoxWp" style="display:none; height:auto; min-width:760px;">
	<div id="close-reviewBox" title="Close it" class="tip-tr close-customAlert"></div>			
	<div class="postPreviewFormContainer" id="postPreviewFormContainer"></div><!--End Div eventPreviewFormContainer-->
</div><!--End Div eventPreviewBoxWp-->


<div class="row heightSpacer"> &nbsp;</div>
<!------- Top Most Menu Buttons ------->   
<?php // echo Modules::run("event/menuNavigation"); ?> 
<!------ End Of Top Menu -------> 
<!-- eventPreview option boc for four type of event START-->
<div id="mainTabBoxWp" class="mainTabBoxWp">
	<div id="close-postPreviewBox" title="Close it" class="tip-tr close-customAlert"></div>			
	<div class="mainTabFormContainer" id="mainTabFormContainer"></div><!--End Div postPreviewFormContainer-->
</div><!--End Div postPreviewBoxWp-->
<div class="row" style="float:right">					
<div class="cell">
  
<div class="tds-button floatLeft" > 
<?php

$previewUrl = '/event/previewOption';
echo anchor('javascript://void(0);', 
'<span>New Event</span>',				
array('class'=>'formTip','onmousedown'=>'mousedown_tds_button(this)','onmouseup'=>'mouseup_tds_button(this)',
'title'=>'New Event',
'onclick'=>'openUserLightBox(\'mainTabBoxWp\',\'mainTabFormContainer\',\''.$previewUrl.'\',\'hterh\');'));
?>
</div>
</div>
</div>
<?php
$live = '<span style="padding: 0px 5px; background-color: rgb(153, 0, 0); color: rgb(255, 255, 255); font-size: 10px;">Live</span>';

$online = '<span style="padding: 0px 5px; background-color: rgb(0, 153, 153); color: rgb(255, 255, 255); font-size: 10px;">Online</span>';

echo '<div class="frm_wp">';
$totalRecords = count($listData);
if($totalRecords > 0)
{
$flag =1;
$delEventAction = 'event/deleteEvent';

$eventFormAttr = array(
	'name'=>'eventForm',
	'id'=>'eventForm'
		 
);

//Path for clock images
$redClock = 'images/icons/clockred.png';
$blueClock = 'images/icons/clockblue.png';
$yellowClock = 'images/icons/clockyellow.png';

//Path for category images
$ticketA = 'images/icons/ticketA.png';
$ticketB = 'images/icons/ticketB.png';
$ticketC = 'images/icons/ticketC.png';
echo form_open($delEventAction,$eventFormAttr); 	
echo '<input id="eventId" name="eventId" value="" type ="hidden" />';
echo '<input id="flag" name="flag" value="" type ="hidden" />';
echo form_close();
foreach($listData as $key => $value)
{
//echo '<pre />';print_r($value);die;
	
$sessionCount=1;
//---------Assingning Images for start date, finish date, launch date-----------

if(isset($value['StartDate']) && $value['StartDate'] != '')
{
	$eventStartDate = date("F d, Y", strtotime($value['StartDate']));
	$redClockSrc = '<img style="max-width: 16px; min-height: 16px; max-height: 16px; margin: 0px;" src="'.getImage($redClock).'" alt="'.$eventStartDate.'" title="'.$eventStartDate.'"  class="formTip"  />';
}
else $redClockSrc ='';

if(isset($value['FinishDate']) && $value['FinishDate'] != '')
{
	$eventFinishDate = date("F d, Y", strtotime($value['FinishDate']));
	$blueClockSrc = '<img style="max-width: 16px; min-height: 16px; max-height: 16px; margin: 0px;" src="'.getImage($blueClock).'" alt="'.$eventFinishDate.'" title="'.$eventFinishDate.'"  class="formTip"  />';
}
else $blueClockSrc ='';

if(isset($value['LaunchDate']) && $value['LaunchDate'] != '')
{
	$eventLaunchDate = date("F d, Y", strtotime($value['LaunchDate']));
	$yellowClockSrc = '<img style="max-width: 16px; min-height: 16px; max-height: 16px; margin: 0px;" src="'.getImage($yellowClock).'" alt="'.$eventLaunchDate.'"  title="'.$eventLaunchDate.'" class="formTip" />';
}
else $yellowClockSrc ='';
  
  
$arrowSep = 'images/icons/breadcrumb_separator_arrow_1_dot.png';
$arrowSepSrc = 	'<img style="max-width: 16px; min-height: 16px; max-height: 16px; margin: 0px;" src="'.getImage($arrowSep).'" />';
$eventTime = $value['Time'];

$encodedEventId = encode($value['EventId']);

//if filepath is set for any of the event type it will shoe he respective image else show the no-image 
if(isset($value['filePath'])){
 if($value['filePath']!='')
$imagePathForEvent = $value['filePath'].'/'.$value['fileName'];
}
else $imagePathForEvent = '';

$eventMediaSrc = '<img style="max-width: 82px; min-height: 82px; max-height: 100px; margin: auto;" src="'.getImage($imagePathForEvent).'" alt="'.$value['Title'].'" />'."<br /><br />";

?>
<!-- Start Show Event Title -->

<div class="row">
<div class="cell" style="width:100%;">
<div class="title-content">
<div class="title-content-left">
<div class="title-content-right">
<div class="title-content-center">
<div class="title-content-center-label" >
<div class="row">
<div class="cell">
<?php 

if($value['NatureId']==1) echo $label['eventNotification'];
if($value['NatureId']==2) echo $label['event'];
if($value['NatureId']==3) echo $label['launchEvent'];
if(($value['NatureId']==4) && isset($value['maineventid']) && ($value['maineventid']!='' || $value['maineventid']>0)) echo $label['eventWithLaunch'];
if(($value['NatureId']==4) && !isset($value['maineventid']) && $value['maineventid']=='' && $value['maineventid']<=0) echo $label['launchEvent'];
if(isset($value['Industry']) && $value['Industry'] !='')
echo ' ('.getIndustry($value['Industry']).')';
?>
</div></div><!--end row -->
</div>

<div class="tds-button-top"">
<?php //if($flag ==1){?>
<!-- Post Edit Icon -->
<?php 
//form assigning different form for event and launch event
$delFlag = 0;

if($value['NatureId'] != 3) {
	$editUrl = 'event/eventForm/'.$value['maineventid'];
	$encodedEventId = encode($value['maineventid']);
	$delFlag = 0;
	
}
if($value['NatureId'] == 3) {
	$editUrl = 'event/launchEventForm/0/3/'.$value['LaunchEventId'];
	$encodedEventId = encode($value['LaunchEventId']);
	$delFlag = 1;
	
}

echo anchor($editUrl, '<span>
<div class="projectEditIcon"></div>
</span>',array('class'=>'formTip','title'=>$label['edit']));?>
<?php //} ?>

<!-- Post Preview Icon -->
<?php 
if($delFlag == 1)
$previewUrl = '/event/previewLaunchEvent';
else
$previewUrl = '/event/previewEvent';

echo anchor('javascript://void(0);', 
'<span><div class="projectPreviewIcon"></div></span>',				
array('class'=>'formTip',
'title'=>$label['preview'],
'onclick'=>'openUserLightBox(\'postPreviewBoxWp\',\'postPreviewFormContainer\',\''.$previewUrl.'\',\''.$encodedEventId.'\');'));

?>
<?php if($flag ==1){?>
<!-- Post Delete Icon -->
<?php 
$url = 'event/deleteEvent/'.$encodedEventId;
echo anchor('javascript://void(0);', '<span><div class="projectDeleteIcon"></div></span>',array('class'=>'formTip delImg','myeventid'=>$encodedEventId,'title'=>$label['delete'],'flag'=>$delFlag));
?>
<?php } ?>
</div><!-- End class="tds-button-top" -->
</div><!-- End class="title-content-center" -->
</div><!-- End class="title-content-right" -->
</div><!-- End class="title-content-left" -->
</div><!-- End class="title-content" -->
</div></div><!--end row -->
<div class="row">
<div class="cell dblBorder" style="float:left;vertical-align:middle;padding:5px;clear:both;overflow:hidden;height:82px;width:82px;">
<?php echo $eventMediaSrc;?>
</div>
<div class="cell" style="height:auto;float:right;width:86%;">
<!-- Start Show Event Title -->
<div class="row">
<div class="cell" style="width:100%;">
<div class="title-content">
<div class="title-content-left">
<div class="title-content-right">
<div class="title-content-center">
<div class="title-content-center-label" >
<div class="row">
<div class="cell">
<div class="row"  style="width:450px;">
<div class="cell">
<?php 

if(strlen($value['EventType']) >50) $EventType = substr($value['EventType'],0,50).'...';
else  $EventType = $value['EventType'];

echo $EventType;

?>
</div>
<div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell">
<?php if($value['Type']==1)  echo $live;
if($value['Type']==2) echo $online;?>
</div>
</div>

</div>
</div><!-- End class="row" -->
</div><!-- End class="title-content-center-label" -->
<div class="tds-button-top"">
<a href="#"><span>
<div class="projectRating">
<img src="<?php echo base_url();?>images/buttons/ratings.png" border="0" class="formTip" title="Rating"/>
</div>
</span></a>
</div><!-- End class="tds-button-top" -->
</div><!-- End class="title-content-center" -->
</div><!-- End class="title-content-right" -->
</div><!-- End class="title-content-left" -->
</div><!-- End class="title-content" -->
</div><!-- End Cell -->
</div><!-- End Row -->
<!-- End Show Event Title -->

<div class="row">

<div class="cell" style="min-width:73%;max-width:50%; padding-left:5px;">
<div class="row">
<div class="cell">

<?php
if(strlen($value['OneLineDescription']) >150) $OneLineDescription = substr($value['OneLineDescription'],0,150).'...';
else  $OneLineDescription = $value['OneLineDescription'];
echo $OneLineDescription;
if(isset($value['Tagwords'])){
if(strlen($value['Tagwords']) >0){
?>
<br />
<?php
if(strlen($value['Tagwords']) >100) $tagwords = substr($value['Tagwords'],0,100).'...';
else  $tagwords = $value['Tagwords'];

echo '<b style="color:#000">'.$label['tags'].':</b>'.$tagwords;

}
}
?>
<br />

</div><!-- End Cell -->
</div><!-- End Row -->
<!-- End Venue(Address) Deatil -->

<!-- Start Show Venue URL Deatil -->
<div class="row">
<div class="cell">
	<b style="color:#000"><?php echo $label['venue']; ?>:</b><br />
<?php

if($value['Address'] !='' ) echo $value['Address'].'<br />';//Check for Address value

if($value['State'] !='' ) echo $value['State'].'<br />';//Check for State value

if($value['City'] =='' && $value['Country']>0) {
 $countryName = getLanguage($value['Country']); $cityCountry = $countryName;
}
else $cityCountry = '';

if($cityCountry !='' ) echo $cityCountry.'<br />';//Check for city & country value
if($value['Zip'] !='' ) echo $value['Zip'].'<br />';//Check for zip value
?>
<?php

if(strpos($value['URL'], "http://")) $URL = $URL;
else $URL = "http://".$value['URL'];

echo '<a href="'.$URL.'"  target="_blank">'.$label['venueURL'].'</a>';
?>
</div><!-- End Cell -->
</div><!-- End Row -->
<!-- End Venue URL Deatil -->
</div>
<!-- End Second Cell -->
<div  class="cell" style="vertical-align:middle; text-align:center; float:right; padding-top:0px; ">
<?php
$eventCraveCount = '';
$eventViewCount = '';
$eventReviewCount = '';
$eventCount = '';
?>
<div class="row" style="height:50px; width:145px;">	
	<div class="cell"> 
		<img class="formTip minMax16px" Title="<?php echo $label['Craves'];?>" alt="Craves" src="<?php echo base_url();?>images/icons/1317210972_star_red.png"><br /><?php print($eventCraveCount == '' ? '0' : $eventCraveCount ); ?>
	</div><div class="cell" style="padding-left:13px;">&nbsp;</div>
	<div class="cell" > 
		<img class="formTip minMax16px" Title="<?php echo $label['Views'];?>" alt="Views" src="<?php echo base_url();?>images/icons/group.png"><br /><?php print($eventViewCount == '' ? '0' : $eventViewCount );?>
	</div><div class="cell" style="padding-left:13px;">&nbsp;</div>
	<div class="cell"> 
		<img class="formTip minMax16px" Title="<?php echo $label['Reviews'];?>" alt="Reviews" src="<?php echo base_url();?>images/icons/comments.png"><br /><?php print($eventReviewCount == '' ? '0' : $eventReviewCount );?>
	</div><div class="cell" style="padding-left:1px;">&nbsp;</div>
	
</div> <!-- End for count row -->

<div class="row pt10">					
<div class="cell">
  
<div class="tds-button floatRight" > 
<?php
$flag = 1;
$eventPublish = $value['EventPublish']; 
if($flag ==1){
		if($eventPublish=='t') echo anchor('event/publishEvent/'.$value['EventId'], '<span>'.$label['Unpublish'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)','onmouseup'=>'mouseup_tds_button(this)')); 
 		if($eventPublish=='f') echo anchor('event/publishEvent/'.$value['EventId'], '<span>'.$label['Publish'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)','onmouseup'=>'mouseup_tds_button(this)'));
		}
?>
	<?php 
		//$urlToShare = base_url()."blog/previewPost/".$postId.'&t=Gurutva is testing this by code'; 
		//$urlToShare = base_url()."blog/previewPost/".$postId;
		$urlToShare = encode('http://115.113.182.141/toadsquare/wireframe2/toadsquare_blog.html');//we have pass the encoded url for security purpose
		echo Modules::run("share/shareButton",$urlToShare);
		$enPostId = 1;
		?>	
</div><!-- End  class="tds-button floatRight" To display buttons for Archive/Unarchive and Share Button-->
</div>
</div>
<!-- Display Clocks-->
<div class="row pl25">	
<?php if(isset($redClockSrc) && $redClockSrc !=''){ ?>
<div class="cell"><?php echo $redClockSrc; ?></div><!-- End Cell -->
<div class="cell pr10 pl10"><?php echo $arrowSepSrc;?></div>
<?php } ?>
<?php if(isset($blueClockSrc) && $blueClockSrc !=''){ ?>
<div class="cell"><?php echo $blueClockSrc; ?></div><!-- End Cell -->
<?php } ?>
<?php if(isset($yellowClockSrc) && $yellowClockSrc !=''){ 
if(isset($blueClockSrc) && $blueClockSrc !=''){ ?><div class="cell pr10 pl10"><?php echo $arrowSepSrc;?></div><?php } ?>
<div class="cell"><?php echo $yellowClockSrc; ?></div><!-- End Cell -->
<?php } ?>
</div><!-- End Row -->
<div class="clear">&nbsp;</div>
<div class="row">		

<div class="cell">
	<?php echo anchor('event/duplicateEvent/'.$value['EventId'], '<span>'.$label['dupliateEventText'].'</span>',array('onmousedown'=>'mousedown_tds_button(this)','onmouseup'=>'mouseup_tds_button(this)')); ?>
</div><!-- End Cell -->
</div><!-- End Row -->
</div><!-- End Cell -->
</div><!-- End Row -->
<div class="clear">&nbsp;</div>

<?php

if(count($value['sessionList'])>0){
	?>
	<div>
	<?php
$sessionCommonId = 0;
foreach($value['sessionList'] as $sessSet)
{

$adressInfo = '';

if($sessionCommonId != $sessSet['sessionId']){
//for eliminating duplicatcy of records.making fresh copy for tickets,so that it do nit show the previous value of ticket with curretn value of tickets
$ticketAText=''; $ticketBText='';$ticketCText=''; $ticketFreeText='';
if($sessionCount ==1 ||($sessionCount%3) ==0)
echo '<div class="row pt2"></div><div class="row">';
?>
<div class="cell">&nbsp;</div>
<div class="cell pr5 pl5 pt5 pb5 minMaxWidth265px" style="background-color:#000000; color: #FFFFFF;">
<div class="row">
<div class="cell minMaxWidth100px" align="center">
	<?php echo $label['session'].$sessionCount;?>
</div><!-- End Cell -->
<div class="cell minMaxWidth100px" align="center">
	<?php echo $label['venue']; ?>
</div><!-- End Cell -->
</div><!-- End Row -->
<?php	

$sessionCount++;

$sessionCommonId =  $sessSet['sessionId'];

if(isset($sessSet['address']) &&  $sessSet['address']!='')
{
if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ','.$sessSet['address'];
else $adressInfo = $sessSet['address'];
}
if(isset($sessSet['city']) &&  $sessSet['city']!='')
{
if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ','.$sessSet['city'];
else $adressInfo = $sessSet['city'];
}
if(isset($sessSet['country']) &&  $sessSet['country']!='')
{
if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ','.getCountry($sessSet['country']);
else $adressInfo = getCountry($sessSet['country']);
}
if(isset($sessSet['state']) &&  $sessSet['state']!='')
{
if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ','.$sessSet['state'];
else $adressInfo = $sessSet['state'];
}
if(isset($sessSet['zip']) &&  $sessSet['zip']!='')
{
if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ','.$sessSet['zip'];
else $adressInfo = $sessSet['zip'];
}
if(isset($sessSet['url']) &&  $sessSet['url']!='')
{
	
if(strpos($sessSet['url'], "http://")) $sessURL = $sessSet['url'];
else $sessURL = "http://".$sessSet['url'];

if(isset($adressInfo ) &&  $adressInfo !='')$adressInfo .= ',<a href="'.$sessURL.'" target="_blank"> '.$label['venueURL'].'</a>';
else $adressInfo = '<a href="'.$sessURL.'" target="_blank">'.$label['venueURL'].'</a>';;
}


?>
<div class="row">
<div class="cell minMaxWidth100px">
<div class="row">
<div class="cell minMaxWidth100px" align="center"><?php echo date("d m y", strtotime($sessSet['date']));?>
</div><!-- End Cell -->
</div><!-- End Row --> 
<div class="row">
<div class="cell width45px" align="center"><?php echo substr($sessSet['startTime'],0, -3); ?>
</div><!-- End Cell -->
<div class="cell pr5">&nbsp;</div>
<div class="cell width45px" align="center"><?php echo substr($sessSet['endTime'],0, -3);?>
</div><!-- End Cell -->
</div><!-- End Row --> 
</div><!-- End Cell -->
<div class="cell minMaxWidth100px">
	<?php echo $adressInfo; ?>
</div><!-- End Cell -->
</div><!-- End Row -->
<?php
}
//echo '<pre />';print_r($value['sessionList']);
//echo '<pre />';print_r($sessSet);

	$prevSeesionTimeId = $sessSet['sessionId'];
	if($sessSet['TicketCategoryId'] == 1)
	{
		$ticketAText = $sessSet['Title'].','.$sessSet['Price'].'|'.$sessSet['Quantity'];
		$ticketAPrice = $sessSet['Price'];
		$ticketAQuantity = $sessSet['Quantity'];
		$ticketASrc = '<img src="'.getImage($ticketA).'" alt="'.$ticketAText.'" title="'.$ticketAText.'"  class="formTip minMax24px"  />';
	}
	
	if($sessSet['TicketCategoryId'] == 2)
	{
		$ticketBText = $sessSet['Title'].','.$sessSet['Price'].'|'.$sessSet['Quantity'];
		$ticketBPrice = $sessSet['Price'];
		$ticketBQuantity = $sessSet['Quantity'];
		$ticketBSrc = '<img src="'.getImage($ticketB).'" alt="'.$ticketBText.'" title="'.$ticketBText.'"  class="formTip minMax24px"  />';
	}
	
	if($sessSet['TicketCategoryId'] == 3)
	{
		$ticketCText = $sessSet['Title'].','.$sessSet['Price'].'|'.$sessSet['Quantity'];
		$ticketCPrice = $sessSet['Price'];
		$ticketCQuantity = $sessSet['Quantity'];
		$ticketCSrc = '<img src="'.getImage($ticketC).'" alt="'.$ticketCText.'" title="'.$ticketCText.'"  class="formTip minMax24px"  />';
	}
	
	if($sessSet['TicketCategoryId'] == 4)
	{
		$ticketFreeText = $sessSet['Title'].','.$label['free'].'|'.$sessSet['Quantity'];
		$ticketFreePrice = $label['free'];
		$ticketFreeQuantity = $sessSet['Quantity'];
		$ticketFreeSrc = '<img src="'.getImage($ticketA).'" alt="'.$ticketFreeText.'" title="'.$ticketFreeText.'"  class="formTip minMax24px"  />';
	}

if(isset($ticketAText) && $ticketAText!='' && isset($ticketBText) && $ticketBText!='' && isset($ticketCText) && $ticketCText!='' && isset($ticketFreeText) && $ticketFreeText!='') { 
?>	
<!-- Show ticket detail -->
<div class="row">
<div class="cell" align="center">
<?php if(isset($ticketAText) && $ticketAText!='') { ?>
<?php echo $ticketASrc;?>
<div class="row">
	<div class="cell"><?=$label['currency'].$ticketAPrice;?></div><!-- End Cell -->
	<div class="cell pl2">&nbsp;</div>
	<div class="cell"><?=$ticketAQuantity;?></div><!-- End Cell -->
</div><!-- End Row -->
</div><!-- End Cell -->
<?php } ?>
<div class="cell pr10">&nbsp;</div>
<?php if(isset($ticketBText) && $ticketBText!='') { ?>
<div class="cell" align="center">
<?php echo $ticketBSrc;?>
<div class="row">
	<div class="cell"><?=$label['currency'].$ticketBPrice;?></div><!-- End Cell -->
	<div class="cell pl2">&nbsp;</div>
	<div class="cell"><?=$ticketBQuantity;?></div><!-- End Cell -->
</div><!-- End Row -->
</div><!-- End Cell -->
<?php } ?>
<div class="cell pr10">&nbsp;</div>
<?php if(isset($ticketCText) && $ticketCText!='') { ?>
<div class="cell" align="center">
<?php echo $ticketCSrc;?>
<div class="row">
	<div class="cell"><?=$label['currency'].$ticketCPrice;?></div><!-- End Cell -->
	<div class="cell pl2">&nbsp;</div>
	<div class="cell"><?=$ticketCQuantity;?></div><!-- End Cell -->
</div><!-- End Row -->
</div><!-- End Cell -->
<?php } ?>
<div class="cell pr10">&nbsp;</div>
<?php if(isset($ticketFreeText) && $ticketFreeText!='') { ?>
<div class="cell" align="center">
<?php echo $ticketFreeSrc;?>
<div class="row">
	<div class="cell"><?=$ticketFreePrice;?></div><!-- End Cell -->
	<div class="cell pl10">&nbsp;</div>
	<div class="cell"><?=$ticketFreeQuantity;?></div><!-- End Cell -->
</div><!-- End Row -->
</div><!-- End Cell -->

</div><!-- End Row -->
</div><!-- End Cell -->
<!-- End Show ticket detail -->
<?php 
}
}
}//foreach for session

?>
</div>
</div>
</div><!-- End Cell style="background-color:#000000;" -->

<?php
echo '<div class="row heightSpacer">&nbsp;</div>';
}
?>

</div></div>
<div class="row heightSpacer">&nbsp;</div>
<?php
  }//End foreach

?>
</div>
<?php
}else{
	echo '<div class="norecordfound pt10">'.$label['noEvent'].'</div>';
	echo '<div class="row heightSpacer">&nbsp;</div>';
}


?>

<script language="javascript" type="text/javascript">
function DeleteAction(eventId,flag)
{	 
var conBox = confirm("Are you sure you want to delete the selected record." );
		if(conBox){
			document.eventFrom.eventId.value = eventId;
			document.eventFrom.submit();
		}
		else{
			return false;
		}		
}
$(document).ready(function() {

//To delete
$(".delImg").click(function() {

var conBox = confirm(areYouSure);
		if(conBox){
		
var eventId = $(this).attr('myeventid');
var flag = $(this).attr('flag');
//alert(eventId);
$("#eventId").val(eventId);
$("#flag").val(flag);
$('#eventForm').submit();
return true;
		}
		else{
		return false;
		}
});
});
</script>

