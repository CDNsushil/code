<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$mathod=$this->router->method;

if($mathod == 'eventnotifications') $NatureId =1;
if($mathod == 'events') $NatureId =2;
if($mathod == 'launch') $NatureId =3;
if($mathod == 'eventwithlaunch' || $mathod == 'launchwithevent') $NatureId =4;
if(!isset($NatureId) || $NatureId =='') $NatureId = 1;

$location = $this->uri->segment(3);


if(isset($EventId) && is_numeric($EventId)){
	
}else{
	$EventId  = $this->uri->segment(5);
}
$EventId = is_numeric($EventId)?$EventId:0;

if(isset($LaunchEventId) && is_numeric($LaunchEventId)){
	
}else{
	$LaunchEventId  = $this->uri->segment(5);
}
$LaunchEventId = is_numeric($LaunchEventId)?$LaunchEventId:0;


$setBackUrl = array('backurl'  => $mathod);

$this->session->set_userdata($setBackUrl);
$currentBackUrl      = $this->session->userdata('backurl');

if(isset($currentBackeventId) && $currentBackeventId>0)
	$eventURL = 'event/index/'.$currentBackeventId;
else
	$eventURL = 'event/index/'.$EventId;	
	

?>

<div class="frm_btn_wrapper  mr6">
	<div class="tds-button-big ">
		<?php
		//one menu for Event Notification Only
		/*
		if($NatureId ==1) 
		{
			if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) 
				echo anchor('event/eventForm/'.$EventId, '<span>'.$label['eventNotification'].'</span>', array('onmousedown'=>'mousedown_tds_button(this)','onmouseup'=>'mouseup_tds_button(this)'));
			else
				echo '<a href="javascript:void(0);" ><span>'.$label['eventNotification'].'</span></a>';
				
		}
		*/
		if(isset($_SERVER['HTTP_REFERER']))
		{		
			$backLink=$_SERVER['HTTP_REFERER'];		
		}
		else
		{
			$backLink='event/eventnotifications';
		}	
		
		if($NatureId == 1 && (strcmp($location,'eventnotifications')==0)) 
		{
			echo anchor('event/eventnotifications', '<span class="two_line">'.$label['eventNotificationIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));					
		}			
				
		if($NatureId == 2)  
		{
				$eventESForm = array('id'=>'ESForm','name'=>'ESForm');
				$eventFurthForm = array('id'=>'eventFurthForm','name'=>'eventFurthForm');
				
				$urleventsession='event/events/eventsession/'.$EventId;
				echo form_open($urleventsession,$eventESForm); 	
				echo '<input name="NatureId" value='.$NatureId.' type ="hidden" />';
				echo '<input name="eventId" value='.$EventId.' type ="hidden" />';
				echo '<input name="currentSessionId" value="0" type ="hidden" />';
				echo form_close();
				
				$urleventprmaterial='event/events/eventprmaterial/'.$EventId;
				echo form_open($urleventprmaterial,$eventFurthForm); 	
				echo '<input name="NatureId" value='.$NatureId.' type ="hidden" />';
				echo '<input name="EntityId" value='.$EventId.' type ="hidden" />';
				echo form_close();
				
			$location3 = $this->uri->segment(4);
			
			if((strcmp(strtolower($location3),'eventform') != 0))
			{
				if($EventId!=0) 
					echo anchor('event/events/eventform/'.$EventId.'/'.$NatureId, '<span class="two_line">'.$label['eventMDescription'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
				else
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['eventMDescription'].'</span></a>';
			}
			
			if((strcmp(strtolower($location3),'eventsession') !=0 ))
			{	
				if($EventId == 0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['eventMSession'].'</span></a>';
				else					
					echo anchor('javascript://void(0);', '<span class="two_line">'.$this->lang->line('eventMSession').'</span>',array('class'=>'','onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)','onclick'=>"$('#ESForm').submit();"));
				
					//echo anchor('event/events/eventsession/'.$EventId.'/'.$NatureId, '<span class="two_line">'.$label['eventMSession'].'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp($location3,'eventFurtherDesc') !=0 ))
			{
				if($EventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span></a>';
				else
					echo anchor('event/events/eventFurtherDesc/'.$EventId, '<span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp($mathod,'eventfurtherdescription') !=0 ))
			{
				if($EventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span></a>';
				else
					echo anchor('event/eventfurtherdescription/'.$EventId, '<span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp(strtolower($location3),'eventprmaterial') !=0 ))
			{	
				if($EventId == 0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('additionalInformation').'</span></a>';
				
				else 
					echo anchor('javascript://void(0);', '<span>'.$this->lang->line('additionalInformation').'</span>',array('class'=>'','onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)','onclick'=>"$('#eventFurthForm').submit();"));
				
					//echo anchor('event/events/eventprmaterial/'.$EventId.'/'.$NatureId, '<span>'.$this->lang->line('additionalInformation').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
						
			if($EventId !=0 ) 
			{
				echo anchor('event/events/eventdetail/'.$EventId, '<span>'.$label['eventIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			else
			{
				echo anchor($backLink, '<span>'.$label['eventIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
		}
		
		//launchEvent Sub Menu
		if($NatureId == 3) 
		{
			
			$location3 = $this->uri->segment(4);
			
			$displayPostPRSection = 0;
			
			$launchTypeArray = getDataFromTabelCommon('LaunchEvent','Type,LaunchEventCreated','LaunchEventId',$LaunchEventId);
			
			if(is_array($launchTypeArray) && !empty($launchTypeArray)) 
			{
				$LaunchEventCreated = $launchTypeArray[0]->LaunchEventCreated;
				$LaunchType = $launchTypeArray[0]->Type;
				$launchExpiryDate = date('Y-m-d',(strtotime($LaunchEventCreated)+(60*60*24*30*6)));	
				$today_time = strtotime(date('Y-m-d'));
				$expire_time = strtotime($launchExpiryDate);

				//Show the post launch images when launch is expired
				if ($expire_time < $today_time && ($LaunchType==1 || $LaunchType=='')) {
					$displayPostPRSection = 1;
				}
				else $displayPostPRSection = 0;
			}
		
			
			if(((strcmp($location3,'launcheventform')!=0) && (strcmp($location3,'launchEvent')!=0)))
			{
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('launchMDescription').'</span></a>';
				else
					echo anchor('event/launch/launcheventform/'.$LaunchEventId, '<span class="two_line">'.$this->lang->line('launchMDescription').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp($location3,'launchsession')!=0))
			{	
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['launchMSession'].'</span></a>';
				else
					echo anchor('event/launch/launchsession/'.$LaunchEventId, '<span class="two_line">'.$label['launchMSession'].'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp($mathod,'launchfurtherdescription') !=0 ))
			{
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span></a>';
				else
					echo anchor('event/launchfurtherdescription/'.$LaunchEventId, '<span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
						
				
			if((strcmp($location3,'launchpromomaterial')!=0))
			{
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span></a>';
				else
					echo anchor('event/launch/launchpromomaterial/'.$LaunchEventId, '<span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if((strcmp($location3,'launchprmaterial')!=0))
			{
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span>'.$this->lang->line('additionalInformation').'</span></a>';
				else
					echo anchor('event/launch/launchprmaterial/'.$LaunchEventId, '<span>'.$this->lang->line('additionalInformation').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			//if((strcmp($location3,'launchpostprimg')!=0) && $displayPostPRSection==1)
			if((strcmp($location3,'launchpostprimg')!=0) )
			{
				if($LaunchEventId==0) 
					echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('postlaunchBRPR').'</span></a>';
				else
					echo anchor('event/launch/launchpostprimg/'.$LaunchEventId, '<span class="two_line">'.$this->lang->line('postlaunchBRPR').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			}
			
			if($LaunchEventId!=0) 
				echo anchor('event/launch/launchdetail/'.$LaunchEventId, '<span>'.$label['launchIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			else
				echo anchor($backLink, '<span>'.$label['launchIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
			
		}
		
		if($NatureId ==4 || (strcmp($location,'eventwithlaunch')==0)) 
		{
			$location4 = $this->uri->segment(4);
			$launchEventMenuId = 0;
			$displayPostPRSection = 0;
			//get the launch is for event and assing accordingly
			if((strcmp($location4,'launchsession')==0) || (strcmp($location4,'eventsession')==0)) {$width2="width540px";$width1='width550px';}
			else{ $width1="width584px"; $width2='';}
			echo '<div class="clear"></div>';
			echo '<div class="'.$width1.'">';
			//Goes here when in launch else case 
			if(isset($location) && (strcmp($location,'launchwithevent')==0)) {
				//GET LAUNCH EVENTID FOR EVENT
				$launchEventMenuIdArray = getDataFromTabelCommon('LaunchEvent','LaunchEventId,Type,LaunchEventCreated','EventId',$EventId);
				if(is_array($launchEventMenuIdArray) && !empty($launchEventMenuIdArray)) 
				{
					$launchEventMenuId = $launchEventMenuIdArray[0]->LaunchEventId;
					$LaunchEventCreated = $launchEventMenuIdArray[0]->LaunchEventCreated;
						$EventLaunchType = $launchEventMenuIdArray[0]->Type;
						$launchExpiryDate = date('Y-m-d',(strtotime($LaunchEventCreated)+(60*60*24*30*6)));	
						$today_time = strtotime(date('Y-m-d'));
						$expire_time = strtotime($launchExpiryDate);

						//Show the post launch images when launch is expired
						if ($expire_time < $today_time && ($EventLaunchType==1 || $EventLaunchType=='')) {
							$displayPostPRSection = 1;
						}
						else $displayPostPRSection = 0;
				}
				else $launchEventMenuId = 0;			
					
				?>			
				<div class="row <?php echo $width1;?> mr11">
					<div class="fl">		
						<a style="background-position: 0 -96px;" href="javascript://void(0);"><span style="background-position: right -96px;" ><?php echo $this->lang->line('launch');?></span></a>
						<?php 
							$eventWithLaunchUrl = base_url("event/eventwithlaunch/eventform/".$EventId);					
							echo anchor($eventWithLaunchUrl, '<span>'.$this->lang->line('event').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
						?>
					</div>
					<div class="fr pr6">				
					<?php 				
						
						if($launchEventMenuId==0)
						{
							//Form to submit the nature type on launch form
							$eventLForm = array('id'=>'LForm','name'=>'LForm');

							$url='event/launchwithevent/eventlaunchdetail/';
							echo form_open($url,$eventLForm); 	
							echo '<input name="ELNatureId" value='.$NatureId.' type ="hidden" />';
							echo '<input name="ELEntityId" value='.$EventId.' type ="hidden" />';
							echo form_close();

							echo anchor('javascript://void(0);', '<span>'.$this->lang->line('index').'</span>',array('class'=>'','onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)','onclick'=>"$('#LForm').submit();"));
						}
						else
						{
							//$indexWithLaunchUrl = base_url("event/launchwithevent/eventlaunchdetail/".$EventId);
							$indexWithLaunchUrl = base_url("event/eventwithlaunch/eventwithlaunchdetail/");
							echo anchor($indexWithLaunchUrl, '<span class="two_line">'.$this->lang->line('eventWithLaunchIndex').'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
						}
					?>
					</div>
				</div>
				<div class="row line1 mr11 <?php echo $width2;?> pb5 mt2"></div>
				
				<div class="Fright common_btn_outer_wrapper mr10 pb3 pl6">
					<?php
					if((strcmp($location4,'launcheventform')!=0))
					{
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('launchMDescription').'</span></a>';
						else
							echo anchor('event/launchwithevent/launcheventform/'.$launchEventMenuId, '<span class="two_line">'.$this->lang->line('launchMDescription').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}
				
					if((strcmp($location4,'launchsession')!=0))
					{	
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['launchMSession'].'</span></a>';
						else
							echo anchor('event/launchwithevent/launchsession/'.$launchEventMenuId, '<span class="two_line">'.$label['launchMSession'].'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}
					
					
					
					if((strcmp($mathod,'launchfurtherdescription') !=0 ))
					{
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span></a>';
						else
							echo anchor('event/launchfurtherdescription/'.$launchEventMenuId, '<span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}
				
					if((strcmp($location4,'launchpromomaterial')!=0))
					{
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span></a>';
						else
							echo anchor('event/launchwithevent/launchpromomaterial/'.$launchEventMenuId, '<span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}	
							
					if((strcmp($location4,'launchprmaterial')!=0))
					{
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span>'.$this->lang->line('additionalInformation').'</span></a>';
						else
							echo anchor('event/launchwithevent/launchprmaterial/'.$launchEventMenuId, '<span>'.$this->lang->line('additionalInformation').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}
				
				
				
					if((strcmp($location4,'launchpostprimg')!=0) && $displayPostPRSection==1)
					{
						if($launchEventMenuId==0) 
							echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('postlaunchBRPR').'</span></a>';
						else
							echo anchor('event/launchwithevent/launchpostprimg/'.$launchEventMenuId, '<span class="two_line">'.$this->lang->line('postlaunchBRPR').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					}	?>
					
				</div>
				<?php
				
			}
			
			else 
			{
			$launchEventMenuIdArray = getDataFromTabelCommon('LaunchEvent','LaunchEventId','EventId',$EventId);
			if(is_array($launchEventMenuIdArray) && !empty($launchEventMenuIdArray)) $launchEventMenuId = $launchEventMenuIdArray[0]->LaunchEventId;
			else $launchEventMenuId = 0;
			//Form to sumnit the nature type on launch form
			$eventTForm = array('id'=>'eventELForm','name'=>'eventELForm');
			
			$url='event/launchwithevent/launcheventform/'.$launchEventMenuId;
			echo form_open($url,$eventTForm); 	
				echo '<input name="NatureId" value='.$NatureId.' type ="hidden" />';
				echo '<input name="EntityId" value='.$EventId.' type ="hidden" />';
				?>
				<div class="row <?php echo $width1;?>">
					<div class="fl">					
						<?php 								
							 $eventWithLaunchUrl = "event/launchwithevent/launcheventform/".$launchEventMenuId;
							 
							 //$indexWithLaunchUrl = base_url("event/eventwithlaunch/eventwithlaunchdetail/".$EventId);
							 $indexWithLaunchUrl = base_url("event/eventwithlaunch/eventwithlaunchdetail/");
							 
							 if($EventId>0)
								echo anchor('javascript://void(0);', '<span>'.$this->lang->line('launch').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)','onclick'=>"$('#eventELForm').submit();"));
							 else 
								echo '<a href="javascript:void(0);" class="disable_btn" ><span>'.$this->lang->line('launch').'</span></a>';
						?>
						<a style="background-position: 0 -96px;" href="javascript://void(0);" ><span style="background-position: right -96px;" ><?php echo $this->lang->line('event');?></span></a>
					</div>
					
					<div class="fr pr6">
						<?php					
							echo anchor($indexWithLaunchUrl, '<span class="two_line">'.$label['eventWithLaunchIndex'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));					
						?>
					</div>
				</div>
				
				<?php 
			echo form_close(); ?>	
			<div class="row line1 mr11 <?php echo $width2;?> pb5 mt2"></div>
			
			<div class="Fright common_btn_outer_wrapper mr10 pb3 pl6">
				<?
				
				if((strcmp($location4,'eventform') !=0 ))
				{			
					if($EventId!=0 || (strcmp($location,'eventform')==0) || (strcmp($location,'index')==0)) 
						echo anchor('event/eventwithlaunch/eventform/'.$EventId, '<span class="two_line">'.$label['eventMDescription'].'</span>', array('onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
					else
						echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['eventMDescription'].'</span></a>';
				}
				
				
				if((strcmp($location4,'eventsession') !=0 ))
				{	
					if($EventId==0) 
						echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$label['eventMSession'].'</span></a>';
					else
						echo anchor('event/eventwithlaunch/eventsession/'.$EventId, '<span class="two_line">'.$label['eventMSession'].'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
				}
				
				
				if((strcmp($mathod,'eventfurtherdescription') !=0 ))
				{
					if($EventId==0) 
						echo '<a href="javascript:void(0);" class="disable_btn" ><span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span></a>';
					else
						echo anchor('event/eventfurtherdescription/'.$EventId, '<span class="two_line">'.$this->lang->line('furtherDescriptionTab').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
				}
				
				if((strcmp($location4,'eventFurtherDesc') !=0 ))
				{
					if($EventId==0) 
						echo '<a href="javascript:void(0);" class="disable_btn"><span class="two_line">'.$label['promotionalBRMaterial'].'</span></a>';
					else
						echo anchor('event/eventwithlaunch/eventFurtherDesc/'.$EventId, '<span class="two_line">'.$label['promotionalBRMaterial'].'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
				}	
				
				if((strcmp($location4,'eventprmaterial')!=0))
				{
					if($EventId==0)
						echo '<a href="javascript:void(0);" class="disable_btn" ><span>'.$this->lang->line('additionalInformation').'</span></a>';
					else
						echo anchor('event/eventwithlaunch/eventprmaterial/'.$EventId, '<span>'.$this->lang->line('additionalInformation').'</span>',array('class'=>'commonfontfamily','onmousedown'=>'mousedown_big_button(this)','onmouseup'=>'mouseup_big_button(this)','onmouseout'=>'mouseout_big_button(this)'));
				}
				?>
			</div>	<?php	
		}
			
			echo '</div>';
			
		}
		?>
	</div>
</div>
<?php
if($NatureId !=4) echo '<div class="row line1 mr11 width567px"></div>';
if((strcmp($location,'launchSession')!=0) || (strcmp($location,'eventSession')!=0)) echo '<div class="row seprator_5"></div>';
?>
