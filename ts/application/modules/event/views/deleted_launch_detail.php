<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
//echo '<pre />';print_r($eventData);

//$userId = isLoginUser();
//$userInfo = showCaseUserDetails($userId);

if(isset($LaunchEventCreated) && $LaunchEventCreated != '')
{
	$eventFirstSaved = date("l, d F Y", strtotime($LaunchEventCreated));
	$eventExpiryDate = date('l, d F  Y',(strtotime($LaunchEventCreated)+(60*60*24*30*6)));
	
}
else {
	$eventFirstSaved = date("l, d F Y");
	$eventExpiryDate = date('l, d F Y',(strtotime($eventFirstSaved)+(60*60*24*30*6)));
}

$EventType = $this->lang->line('launch');
//if(strlen($EventType) >20) $EventType = substr($EventType,0,20).'...';

//DEFINING EDIT,PREVIEW AND DELETE URLS
$mainlaunchid = @$LaunchEventId;
$encodedEventId = encode($mainlaunchid);
$delFlag=0;

//TO count free space 
$continerSize=0;

$continerSize=$continerSize>0?(number_format(($continerSize/(1024*1024)),2)):50;

$dirname='media/'.LoginUserDetails('username').'/launchevents/'.$mainlaunchid.'/';

$dirSize=bytestoMB(getFolderSize($dirname),'mb');

$reminingSize=($continerSize-$dirSize).'&nbsp;'.$this->lang->line('mb');

$continerSize=$continerSize.'&nbsp;'.$this->lang->line('mb');


$addUrl = base_url('event/launch//launcheventform');
$sessionUrl = base_url('event/launch/launchsession/'.$mainlaunchid);
$editUrl = base_url('event/launch/launcheventform/'.$mainlaunchid);
$previewUrl = base_url('event/previewEvent');
$url = 'deleteEvent/'.$encodedEventId;
?>

<!-- Notification Title get shown END's here -->

<div class="clear"></div>
<?php echo Modules::run("event/indexNavigation",@$Title); ?>

<div class="row">
	<div class="main_project_heading">
		<div class="Main_heading_new fl"> <?php echo getSubString(@$Title, 67); ?></div>
	</div>
</div>
<!-- Launch event records get displayed here -->
<div class="row mt6 position_relative">
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
?>
<!-- Left Menu List Of All Event Sections -->
<?php

	//$itemNatureId=3;
	$sectionArray = array('NatureId'=>$itemNatureId);
	echo Modules::run("event/eventsLeftSection",$sectionArray);

if(!isset($LaunchEventId) || $LaunchEventId<=0) {
?> <!-- No Message
	<div class="cell width_569 padding_left16">
		<div class="row blog_wrapper new_theme_blog_box_gray">

			<div class="blog_box bg-non-color   height200px">
			<div align="center" class="mt79">
				<?php
				/*
				if($itemNatureId==3)
					echo '<div class="norecordfound pt10">'.$this->lang->line('noDelLaunch').'</div>';
				else
					echo '<div class="norecordfound pt10">'.$this->lang->line('noDelEventWithLaunch').'</div>';
				*/
				?>
			</div>
			<div class="clear"></div>
			</div>
		</div>
		<div class="shadow_blog_box"> </div>
	</div>-->
<?php
}else{	//Line Or Online Event Notification
	$LiveOrOnline = '';
	if(@$Type ==1 || @$Type=='') $LiveOrOnline = 'Live';
	if(@$Type ==2) $LiveOrOnline = 'Online';
	
	/*
	$TypeEvent = getDataFromTabel('MasterProjectType','projectTypeName','typeId',$Type);
	
	if(is_array($TypeEvent)) {
		$OrgLiveOrOnline = $TypeEvent[0]->projectTypeName;
		$check = strstr($OrgLiveOrOnline, 'Live');
		if(empty($check)) $LiveOrOnline = 'Online';
		else $LiveOrOnline = 'Live';
	}
	*/
?>
<div class="cell width_569 padding_left16">
		<div class="row blog_wrapper new_theme_blog_box_gray">
           <div class="toggle_btn"></div>
              <div class="blog_box bg-non-color">
				                
				<div class="one_side_small_shadow">
					<table width="100%"  height="100% "border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_top.png');?>"/></td>
					  </tr>
					  <tr>
						<td class="publish_shad_mid">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_bottom.png');?>"/></td>
					  </tr>
					 </table>
				</div><!--one_side_small_shadow-->
                    
                <div class="cell blog_left_wrapper width_395  pr16">
                 
                  <div class="row">                    
                    <div class="published_box_wp ">
                    		<div class="published_heading"><?php echo $this->lang->line('FirstSaved');?></div> 
                            <div class="published_date"><?php echo $eventFirstSaved;?></div>                            
                            <div class="clear"></div>
                                                         
                            <div class="published_heading"><?php echo $this->lang->line('Expires');?></div> 
                            <div class="published_date"><?php echo $eventExpiryDate;?></div>
                            <div class="clear"></div>
                            
                            <div class="published_heading">Free space</div> 
                            <div class="published_date"><?php echo $reminingSize.'&nbsp;'.$this->lang->line('outof').'&nbsp'.$continerSize;?></div>
                            <div class="clear"></div>
                                                        
                            <div class="tds-button renew_btn"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span>Renew</span></a> </div>
                    </div><!--published_box_wp-->
                    
                  </div>
                  <div class="seprator_10 row"></div>
                  
                   <div class="row"> 
                   <div class="cell width215px"><b class="orange_color"><?php echo $this->lang->line('type');?></b> <span class="event_organiser_name"><?php echo getSubString($OtherGenre, 25);?></span></div>
                   <div class="cell"><b class="orange_color"><?php echo $this->lang->line('totalTicketSales');?></b> <span class="event_organiser_price">€ 0</span></div>
       			   <div class="clear"></div>
                   <div class="seprator_13"></div>                 
                  </div>
                  
                  <div class="row"> <b class="orange_color">Event Organiser</b> <span class="event_organiser_name"><?php echo getUserName($tdsUid);?></span>
       
                  <div class="seprator_13"></div>                 
                  </div>                 
                  
                  <div class="row"><b class="orange_color"><?php echo $this->lang->line('project_logLineDescription');?></b>
                    <p><?php echo getSubString($OneLineDescription, 67);?></p>
                    <div class="seprator_13"></div>
                    <?php 
                   // echo $Tagwords;
					if(isset($Tagwords)){
						if(strlen($Tagwords) >0 && $Tagwords>0)
						{
						?>
						<b class="orange_color"><?php echo  $this->lang->line('project_tags');?></b>
						<p><?php echo getSubString($Tagwords, 67);?></p>
						<?php 
						} 
                    }
                    ?>
                  </div>
                  
                  <!--blog_links_wrapper-->
                </div>
                <div class="cell blog_right_wrapper">
                  <div class="blog_link2_wrapper">
                   
                    <div class="tds-button-top modifyBtnWrapper"> 
						
						<?php echo anchor('javascript://void(0);','<span><div class="projectPreviewIcon"></div></span>',array('class'=>'formTip','title'=>$this->lang->line('preview'),'onclick'=>'openUserLightBox(\'postPreviewBoxWp\',\'postPreviewFormContainer\',\''.$previewUrl.'\',\''.$encodedEventId.'\');')); ?>

						<a href="javascript://void(0);" class="formTip comingSoon" onclick="delEvent('<?php echo encode($mainlaunchid);?>')"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a>
                    </div>                     
                   
                    <!--icon_edit_blog-->
                  </div>
                  <div class="clear"></div>
                   <?php 
                  
                  //Fetch records from logsummary table for ratting,crave and view value for event
					$LogSummarywhere=array('entityId'=>$entityId,'elementId'=>$mainlaunchid);
					
					$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,viewCount,reviewCount,lastViewDate',  $LogSummarywhere, '', $orderBy='', '', 1 );
					
					if($resLogSummary)
					{
						$resLogSummary=$resLogSummary[0];
						$craveCount=$resLogSummary->craveCount;						
						$viewCount=$resLogSummary->viewCount;
						$reviewCount=$resLogSummary->reviewCount;
						$lastViewDate=date("d M Y", strtotime($resLogSummary->lastViewDate));
						
					}
					else
					{
						$craveCount=0;						
						$viewCount=0;
						$reviewCount=0;
						$lastViewDate=date('d M Y');
					}				
                  
                  ?>
                  
                  <div class="rating_box_wrapper" style="padding-top:12px;">
                  	<div class="live_text"><?php echo $LiveOrOnline;?></div>
                    <div class="rating_cover">
                      <?php $this->load->view('rating/ratingAvg',array('elementId'=>$mainlaunchid,'entityId'=>$entityId,'ratingClass'=>'cell ml14 Fright'));?>
                    </div>
                  </div>
                  <!--rating_box_wrapper-->
                  
                  <div class="clear"></div>
                  <div class="blog_link3_wrapper">
                    <div class="blog_link3_box">
                      <div class="icon_crave2_blog"> Craves </div>
                      <div class="blog_link3_point"><?php echo ($craveCount>0)?$craveCount:0; ?></div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_post2_blog"> Reviews </div>
                      <div class="blog_link3_point"><?php echo ($reviewCount>0)?$reviewCount:0; ?></div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_view2_blog"> Views </div>
                      <div class="blog_link3_point"><?php echo ($viewCount>0)?$viewCount:0; ?> </div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_lastview2_blog"> Last Viewed<br/><b><?php echo $lastViewDate;?></b> </div>
                    </div>
                  </div>
                </div>
                               
                
                <div class="row blog_links_wrapper">
                 <?php
					
					$whereArray = array('LaunchEventId'=>$mainlaunchid,'Quantity >'=>0);						
					$totalSessions = countResult('Tickets',$whereArray);
					
					$currentStatus=$isPublished=='t'?$this->lang->line('Publish'):$this->lang->line('hide');
					$changeStatus=$isPublished=='t'?$this->lang->line('hide'):$this->lang->line('Publish');
					
					$publisButton=array('currentStatus'=>$currentStatus,'changeStatus'=>$changeStatus,'isPublished'=>$isPublished,'tabelName'=>'LaunchEvent','pulishField'=>'isPublished','field'=>'LaunchEventId','fieldValue'=>$mainlaunchid, 'view'=>'publishUnpublish','totalSessions'=>$totalSessions,'checkSession'=>1);
					echo Modules::run("common/formInputField",$publisButton);
									
					 // Show view page for getShortLink ,email,share,invite and postOnPost
					 // entityTitle: Title of page you want to share
					 // shareType: text(like: post,film and video etc)
					 // shareLink: url to get shared with users
					$currentUrl = $this->config->site_url().$this->router->class.'/launchDetail/'.$mainlaunchid;				
					$relation = array('share','getShortLink' ,'email','entityTitle'=>  addslashes($Title), 'shareType'=>$this->lang->line('events'), 'shareLink'=> $currentUrl, 'id'=> 'event'.$EventId);
				
					?>
					<div class="tds-button fr pr70">
						<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#" style="background-position: 0px -38px;">
						 <span class="btn_meeting" style="background-position: right -38px;"> <div class="icon-meeting-btn">&nbsp;</div>
							<div class="btn_content_wp"><?php echo $this->lang->line('meeting')?><br>
								<div style="float:left; width:auto; margin:0px; height:auto"><?php echo $this->lang->line('point')?></div>
								<div style="float:right; width:auto; height:auto; font-size:11px; font-weight:bold; padding-top:1px; margin-left:23px;"><?php echo $meetingPoint;?></div>
							</div>
						</span>
					   </a> 
					</div>
					<?php
						echo Modules::run("common/loadRelations",$relation); 
					?>    
                
                  
                   <div class="tds-button fr "> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span>Publish</span></a>
                   
                  </div>					
                     <div class="clear"></div>
                      
                  </div>
                   <div class="create_similar_text"> <a href="javascript://void(0);">Create a similar Launch</a></div>
                  
                <div class="clear"></div>
              </div>
              <!--blog_box-->
            </div>
            <!--blog_wrapper-->
            <div class="shadow_blog_box"> </div>
            <!--shadow_blog_box-->
<!-- Event Session -->
<?php 

$sessionArray['entityType'] = 'eventId';
$sessionArray['elementId'] = 0;
$sessionArray['launchEventId'] = $LaunchEventId;
$sessionArray['launchEventEntity'] = 'launchEventId';
$sessionArray['editSessionUrl'] = $sessionUrl;
echo Modules::run("event/sessionList",$sessionArray);

?>

</div>
<?php }?>
<div class="clear"></div>
<div class="seprator_10"></div>
</div><!-- End position_relative--> 
