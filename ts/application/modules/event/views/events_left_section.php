<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!isset($isArchive)){
$isArchive='f';	
}

//if filepath is set for any of the event type it will shoe he respective image else show the no-image 
	//----------make element default event/launch image code start---------//
	if(isset($EventId) && !empty($EventId)) {
		$projectEventId = $EventId;
		$projectFieldName = '.eventId';
	} elseif(isset($LaunchEventId) && !empty($LaunchEventId)) {
		$projectEventId = $LaunchEventId;
		$projectFieldName = '.launchEventId';
	} else {
		$projectEventId = '';
	}
	$eventImage = $filePath.$fileName;
	if(!empty($filePath) && !empty($fileName) && file_exists($eventImage)) {
		$eventImage=addThumbFolder($eventImage,'_s');
		$eventMediaSrc=getImage($eventImage,$this->config->item('defaultEventImg_s'));
	} else {
		if(!empty($projectEventId)) {
			$getProjectImage = getEventsPrimaryImage($projectEventId,$projectFieldName);
			if($getProjectImage){
				$eventImage = $getProjectImage;
			}else{
				$eventImage = addThumbFolder($eventImage,'_s');				
			}
		} else {
			$eventImage = addThumbFolder($eventImage,'_s');	
		}
		$eventMediaSrc = getImage(@$eventImage,$this->config->item('defaultEventImg_s'));
	}
	//----------make element default event/launch image code start---------//
?>
<div class="cell width_200">
<?php echo Modules::run("common/profileImage",$eventMediaSrc);

$location = $this->uri->segment(3);

if(strcmp($location,'index')!=0 && $location!='' && strcmp(strtoupper($location),strtoupper('eventnotifications'))!=0)	{
	 if($isArchive=='t'){
		 $notificationLink = base_url(lang().'/event/eventnotifications/notificationslist/deleted');
	 }else{
		  $notificationLink = base_url(lang().'/event/eventnotifications/notificationslist');
	 }
?>    
	<div class="row">
		<div class=" cell frm_heading ">
			<?php echo anchor($notificationLink, '<h2>'.$this->lang->line('eventHeadingNotificationIndex').'</h2>',array('class'=>'hoverOrange'));?>
		</div>                
		<div class="clear"></div>		   
	</div>
	<div class="seprator_34 row"></div>             
<?php 
}

echo Modules::run("event/eventsLeftSubSection",2,@$activeEventId,$isArchive);
echo Modules::run("event/eventsLeftSubSection",3,@$activeEventId,$isArchive);
echo Modules::run("event/eventsLeftSubSection",4,@$activeEventId,$isArchive);
 
?>
<div class="clear"></div>
<?php
/*How to publish popup*/
	$this->load->view('common/howToPublish',array('industryType'=>'performanceNevent'));
/*End How to publish popup */
?>	
</div>

<?php
//
?>
