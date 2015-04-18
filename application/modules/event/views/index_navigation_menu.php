<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$eventTForm = array(	
	'id'=>'eMenuNavForm',
	'name'=>'eMenuNavForm'		 
);

$location = $this->uri->segment(3);
//To check for deleted page
$lasturi = end($this->uri->segments);
$secondLastKey = count($this->uri->segment_array())-1;
$secondlasturi = $this->uri->segment($secondLastKey);

$spanClass = '';

if(isset($_SERVER['HTTP_REFERER']))
{		
$backLink=$_SERVER['HTTP_REFERER'];		
}
else
{
$backLink='event/eventnotifications';
}	
		

  switch($location){
				 
	case 'eventdetail':
		   $url='event/events/eventform';
		   //Delete the Event
		   $deletedurl = 'event/events/deletedItems';
		   $natId=2;
		   $flagForType=0;
		   $eventHeading = $this->lang->line('eventsHeadingIndex');	
		   $indexHeading = $this->lang->line('eventsHeadingIndex');	
		   $indexClass = '';	
		   $newEventLabel = $this->lang->line('mainTab2');
		   $sectionId=$this->config->item('eventsSectionId');
		   $submitLink='/event/events/eventform';
		   $indexUrl = base_url(lang()."/event/events/eventdetail/");
		   break;
	case 'events':
		   $url='event/events/eventform';
		   $deletedurl = 'event/events/deletedItems';
		   $flagForType=0;
		   $natId=2;
		   $eventHeading = $this->lang->line('eventsHeadingIndex');	
		    $indexHeading = $this->lang->line('eventsHeadingIndex');	
		   $indexClass = '';
		   $newEventLabel = $this->lang->line('mainTab2');
		   $sectionId=$this->config->item('eventsSectionId');
		   $submitLink='/event/events/eventform';
		   $indexUrl = base_url(lang()."/event/events/eventdetail/");		 
		   break;
	 case 'launch':
		   $url='event/launch/launcheventform';
		   $flagForType=1;
		   $deletedurl = 'event/launch/deletedItems';
		   $natId=3;
		   $eventHeading = $this->lang->line('launchHeadingIndex');
		   $indexHeading = $this->lang->line('launchHeadingIndex');	
		   $indexClass = '';
		   $newEventLabel = $this->lang->line('mainTab3');
		   $sectionId=$this->config->item('launchesSectionId');
		   $submitLink='/event/launch/launcheventform';
		   $indexUrl = base_url(lang()."/event/launch/launchdetail/");
		   break;
	 case 'launchdetail':
		   $url='event/launch/launcheventform';
		   $flagForType=1;
		   $deletedurl = 'event/launch/deletedItems';
		   $natId=3;
		   $eventHeading = $this->lang->line('launchHeadingIndex');
		   $indexHeading = $this->lang->line('launchHeadingIndex');	
		   $indexClass = '';
		   $newEventLabel = $this->lang->line('mainTab3');
		   $sectionId=$this->config->item('launchesSectionId');
		   $submitLink='/event/launch/launcheventform';
		   $indexUrl = base_url(lang()."/event/launch/launchdetail/");
		   break;
	 case 'launch':
		   $url='event/launch/launcheventform';
		   $flagForType=1;
		   $deletedurl = 'event/launch/deletedItems';
		   $natId=3;
		   $eventHeading = $this->lang->line('launchHeadingIndex');
		   $indexHeading = $this->lang->line('launchHeadingIndex');	
		   $indexClass = '';
		   $newEventLabel = $this->lang->line('mainTab3');
		   $sectionId=$this->config->item('launchesSectionId');
		   $submitLink='/event/launch/launcheventform';
		   $indexUrl = base_url(lang()."/event/launch/launchdetail/");
		   break;
	 case 'eventwithlaunch':	 
		   $url = 'event/eventwithlaunch/eventform';
		   $flagForType=0;
		   $deletedurl = 'event/eventwithlaunch/deletedItems';
		   $natId = 4;
		   $eventHeading = $this->lang->line('eventHeadingWithLaunchIndex');
		   $indexHeading = $this->lang->line('eventWithLaunchIndex');	
		   $indexClass = 'two_line';
		   $newEventLabel = $this->lang->line('mainTab4');	
		   $spanClass = 'two_line';	
		   $sectionId=$this->config->item('eventswithLaunchSectionId');
		   $submitLink='/event/eventwithlaunch/eventform';
		   $indexUrl = base_url(lang()."/event/eventwithlaunch/eventwithlaunchdetail/");
		   break;
	 case 'eventlaunchdetail':	 
		   $url='event/eventwithlaunch/eventform';
		   $flagForType=0;
		   $deletedurl = 'event/eventwithlaunch/deletedItems';
		   $natId=4;		   
		   $eventHeading = $this->lang->line('eventHeadingWithLaunchIndex');
		   $indexHeading = $this->lang->line('eventWithLaunchIndex');	
		   $indexClass = 'two_line';
		   $newEventLabel = $this->lang->line('mainTab4');	
		   $spanClass='two_line';
		   $sectionId=$this->config->item('eventswithLaunchSectionId');
		   $submitLink='/event/eventwithlaunch/eventform';
		   $indexUrl = base_url(lang()."/event/eventwithlaunch/eventwithlaunchdetail/");	
		   break;		  
	 case 'launchwithevent':	 
		   $url='event/eventwithlaunch/eventform';
		   $natId=4;
		   $deletedurl = 'event/eventwithlaunch/deletedItems';
		   $flagForType=0;
		   $indexUrl = base_url(lang()."/event/eventwithlaunch/eventwithlaunchdetail/");	
		   $eventHeading = $this->lang->line('eventHeadingWithLaunchIndex');
		   $indexHeading = $this->lang->line('eventWithLaunchIndex');	
		   $indexClass = 'two_line';
		   $newEventLabel = $this->lang->line('mainTab4');	
		   $spanClass='two_line';
		   $sectionId=$this->config->item('eventswithLaunchSectionId');
		   $submitLink='/event/eventwithlaunch/eventform';		
		   break;		  
	 case 'eventwithlaunchdetail':	 
		   $url='event/eventwithlaunch/eventform';
		   $deletedurl = 'event/eventwithlaunch/deletedItems';
		   $indexUrl = base_url(lang()."/event/eventwithlaunch/eventwithlaunchdetail/");	
		   $flagForType=0;
		   $natId=4;
		   $newEventLabel = $this->lang->line('mainTab4');	
		   $spanClass='two_line';
		   $sectionId=$this->config->item('eventswithLaunchSectionId');
		   $submitLink='/event/eventwithlaunch/eventform';		
		   break;		  
		  
	 default:	 
		  $url='event/eventnotifications/eventform';	
		  $deletedurl=base_url('event/eventnotifications/notificationslist/deleted');	
		  $indexUrl=base_url('event/eventnotifications/notificationslist');	
		  $flagForType=0;
		  $natId=1;
		  $eventHeading = $this->lang->line('eventHeadingNotificationIndex');
		  $indexHeading = $this->lang->line('eventNotificationIndex');	
		  $indexClass = 'two_line';
		  $newEventLabel = $this->lang->line('mainTab1');
		  $sectionId=$this->config->item('eventNotificationsSectionId');
		  $submitLink='/event/eventnotifications/eventform';
  }		

	$eventFormAttr = array(
		'name'=>'delItemForm',
		'id'=>'delItemForm'
	);
	
	echo form_open($deletedurl,$eventFormAttr); 	
		echo '<input id = "NatureId" name = "NatureId" value = "'.$natId.'" type = "hidden" />';
		echo '<input id = "flag" name = "flag" value = "'.$flagForType.'" type = "hidden" />';
	echo form_close();	
	
	//if(isset($NatureId)&&$NatureId==4) $eventHeading = $this->lang->line('eventHeadingWithLaunch');
	echo form_open($url,$eventTForm); 	
	echo '<input name="NatureId" value='.$natId.' type ="hidden" />'; 
	if(strcmp($secondlasturi,'meetingpoint')==0){
		$buttonHeading = $indexHeading;
		$eventHeading = $this->lang->line('meetingPoint');
	} 
	if(strcmp($lasturi,'usermeetingpoint')==0){
		$buttonHeading = $this->lang->line('back');
		$eventHeading = $this->lang->line('meetingPoint');
	} 
	
	if(strcmp($lasturi,'purchasesessionlist')==0){
		$buttonHeading = $this->lang->line('back');
		$eventHeading = $this->lang->line('purchased_session');
	}
	
	$isShowButton=false; 
	 
	if(strcmp($lasturi,'usermeetingpoint')==0 || strcmp($secondlasturi,'meetingpoint')==0){
		$buttonLable = $this->lang->line('purchased_session');
		$buttonLink = base_url('event/purchasesessionlist');
		$backLink='event/eventnotifications';
		$isShowButton = true;
	} 
	
	if(strcmp($lasturi,'purchasesessionlist')==0){
		$buttonLable = $this->lang->line('meetingPoint');
		$buttonLink = base_url('event/usermeetingpoint');
		$backLink='event/eventnotifications';
		$isShowButton = true;
	}
?>
	<div class="row">
		<div class=" cell frm_heading mt3">
			<h1><?php echo $eventHeading; ?></h1>
		</div>		
		<div class="frm_btn_wrapper">
			
			<div class="tds-button-big fr mr10">	
			<?php
			 
				//---------show usermeeting poing and purchase button by condition---------//
				if($isShowButton){
					echo anchor($buttonLink, '<span >'.$buttonLable.'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));					
				}	
			 
				$newsHref="javascript:getUserContainers('".$sectionId."','".$submitLink."');";				
				if(strcmp($secondlasturi,'meetingpoint')!=0 &&strcmp($lasturi,'usermeetingpoint')!=0 &&strcmp($lasturi,'purchasesessionlist')!=0) { 					
					
				?>					
					<a onclick="<?php echo $newsHref;?>" class="eventOption" href="javascript:void(0);" onmousedown='mousedown_big_button(this)' onmouseup='mouseup_big_button(this)' onmouseout='mouseout_big_button(this)'><span class="<?php echo $spanClass;?>"><?php echo $newEventLabel; ?></span></a>	
					<?php 
					if(strcmp($lasturi,'deletedItems')!=0 && strcmp($lasturi,'deleted')!=0  && strcmp($secondlasturi,'deletedItems')!=0 && strcmp($secondlasturi,'deleted')!=0 ){
					?>
						<a onclick="$('#delItemForm').submit();" class="eventOption" href="javascript:void(0);" onmousedown='mousedown_big_button(this)' onmouseup='mouseup_big_button(this)' onmouseout='mouseout_big_button(this)'><span class="two_line"><?php echo $this->lang->line('deletedBRItems'); ?></span></a>	
					<?php 
					}
					else{
						echo anchor($indexUrl, '<span  class='.$indexClass.'>'.$indexHeading.'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));					
					}
		 
				} else {
					
					if($buttonHeading == 'Back') $indexClass='';
					
					echo anchor($backLink, '<span class='.$indexClass.'>'.$buttonHeading.'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));					
				}
				
			?>
			</div>		
		</div><!-- End frm_btn_wrapper -->
	</div><!-- End row -->
<?php echo form_close(); ?>	
<div class="row line1 width573px mr11"></div>
