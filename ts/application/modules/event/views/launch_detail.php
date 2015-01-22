<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$userId = isLoginUser(); 
//$userInfo = showCaseUserDetails($userId);

$seller_currency=LoginUserDetails('seller_currency');
if($seller_currency==''){
	$isSellerSettings=false;
}else{
	$isSellerSettings=true;
}
$seller_currency=($seller_currency>0)?$seller_currency:0;
$currencySign=$this->config->item('currency'.$seller_currency);

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

$addUrl = base_url('event/launch/launchsession/'.$mainlaunchid);
$sessionUrl = base_url('event/launch/launchsession/'.$mainlaunchid);
$editUrl = base_url('event/launch/launcheventform/'.$mainlaunchid);
$previewUrl = base_url('event/previewEvent');
$url = 'deleteEvent/'.$encodedEventId;

$uniqueId='project'.$mainlaunchid;
if($isPublished=='t'){
	$viewDisplay='';
	$previewDisplay='style="display: none;"';
	
	$rtspDisplay='';
	$rtsupDisplay='style="display: none;"';
	
	$pDisplay='';
	$upDisplay='style="display: none;"';
}else{
	$viewDisplay='style="display: none;"';
	$previewDisplay='';
	
	$rtspDisplay='style="display: none;"';
	$rtsupDisplay='';
	
	$pDisplay='style="display: none;"';
	$upDisplay='';
}
?>

<!-- Notification Title get shown END's here -->

<div class="clear"></div>
<?php 
$Title=(isset($Title) && !empty($Title))?$Title:'';
echo Modules::run("event/indexNavigation",@$Title); 
if(!empty($Title)){
?>

	<div class="row">
		<div class="main_project_heading">
			<div class="Main_heading_new fl"> <?php echo getSubString(@$Title, 67); ?></div>
		</div>
	</div>
<?php
}else{
	echo '<div class="clear"></div>';
}
?>	
<!-- Launch event records get displayed here -->
<div class="row mt6 position_relative">
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
?>
<!-- Left Menu List Of All Event Sections -->

<?php

	$NatureId=3;
	$sectionArray = array('NatureId'=>$NatureId,'isArchive'=>$isArchive);
	echo Modules::run("event/eventsLeftSection",$sectionArray);

if(!isset($LaunchEventId) || !$LaunchEventId > 0) {
	$sectionId=$this->config->item('launchesSectionId');
	$returnUrl='/event/launch/launcheventform';
?>

	<div class="cell width_488 margin_left_55 pr">
		<?php
		if($isArchive=='t'){
				// echo $this->lang->line('noRecord');
		}else{
			?>
			<div id="showContainer">
				<script>
						AJAX('<?php echo base_url(lang().'/package/getAvailableUserContainer');?>','showContainer','<?php echo $sectionId?>','<?php echo $returnUrl?>','1');
				</script>
			</div>
			<?php
		} ?>
	</div>
	
<?php
}else{	//Line Or Online Event Notification
	$LiveOrOnline = '';
	if(@$Type ==1 || @$Type=='') $LiveOrOnline = 'Live';
	if(@$Type ==2) $LiveOrOnline = 'Online';
	
	$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
	$expiryDateColor=($isExpired=='t')?'red':'';
	$createDate=$LaunchEventCreated;
	$currentDate = date("Y-m-d H:i:s");
	$expiryDate=$expiryDate;
	if(strlen($expiryDate) < 10){
		$expiryDate= dateFormatView(date('Y-m-d',(strtotime($createDate)+(60*60*24*30*6))))	;
		$launch_expiry_date = date('Y-m-d',(strtotime($createDate)+(60*60*24*30*6)));
	}else{
		$launch_expiry_date = $expiryDate;
		$expiryDate= dateFormatView($expiryDate);
	}
	
	if($launch_expiry_date != '' && $currentDate <= $launch_expiry_date) {
		$expiryDateColor = '';
		$expire_label = $this->lang->line('toolExpires');
	} else {
		$expiryDateColor = 'clr_red';
		$expire_label = $this->lang->line('toolExpired');
	}
	
	$createDate=dateFormatView($createDate);

	$containerSize=(isset($containerSize) && is_numeric($containerSize))?$containerSize:$this->config->item('defaultContainerSize');
	$dirname='media/'.LoginUserDetails('username').'/launchevents/'.$mainlaunchid.'/';
	$dirSize=getFolderSize($dirname);

	$remainingBytes=($containerSize-$dirSize);
	if($remainingBytes < 0){
		$remainingBytes = 0;
	}

	$containerSize=bytestoMB($containerSize,'mb');
	$dirSize=bytestoMB(getFolderSize($dirname),'mb');
	$remainingSize=($containerSize-$dirSize);
	if($remainingSize < 0){
		$remainingSize = 0;
	}
	$remainingSize = number_format($remainingSize,2,'.','');
	$remainingSize=$remainingSize.'&nbsp;'.$this->lang->line('mb');
	$containerSize=$containerSize.'&nbsp;'.$this->lang->line('mb');
?>
<div class="cell width_569 padding_left16">
	<?php 
		if($isArchive=='t'){
			$this->load->view('common/deletedItemMsg');
		}
		if($isBlocked=='t'){
			$this->load->view('common/illegalMsg');
		}
	?>
		<div class="row blog_wrapper new_theme_blog_box_gray <?php echo $redBorder3px;?>">
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
                            <div class="published_date"><?php echo $createDate;?></div>                            
                            <div class="clear"></div>
                                                         
                            <div class="published_heading"><?php echo $expire_label;?></div> 
                            <div class="published_date <?php echo $expiryDateColor;?>"><?php echo $expiryDate;?></div>
                            <div class="clear"></div>
                            
                            <div class="published_heading"><?php echo $this->lang->line('freeSpace');?></div> 
                            <div class="published_date"><?php echo $remainingSize.'&nbsp;'.$this->lang->line('outof').'&nbsp'.$containerSize;?></div>
                            <div class="clear"></div>
                            <?php if($isBlocked=='f'){ 
								if(isset($userContainerId) && $userContainerId>0){
									$projectContainerId = $userContainerId;							
								} else {								
									$projectContainerId ='';
								}
								?>                           
                            <div class="tds-button renew_btn btn_span_hover"> 
								<!--<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span>Renew</span></a>-->
								<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php echo base_url(lang().'/membershipcart/renewCart/'.$projectContainerId);?>">
									<span class="mr3 pr10">
										<div class="renew_button fr ml20 pr0"></div>
										<div class="Fright ml0"><?php echo $this->lang->line('Renew'); ?></div>
									</span>
								</a>
                             </div>
							<?php } ?>
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
						<?php
						$viewLink = base_url(lang().'/eventfrontend/eventlaunch/'.$userId.'/'.$LaunchEventId);
						$previewLink = base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$LaunchEventId.'/eventlaunch');
						$viewTooltip=$this->lang->line('view');
						$previewTooltip=$this->lang->line('preview');
						
						if($isArchive=='t'){
							if($isBlocked != 't' && $isExpired != 't'){ ?>
									 <!--Replace un archived icon with restore icon -->
									 <a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','LaunchEvent','LaunchEventId','<?php echo $mainlaunchid; ?>','isArchive','/event/launch/deletedItems','');"><span><div class="restore_btn_icon"></div></span></a> 
									 
									 
									<!--<a class="formTip" href="javascript:void(0);" title="<?php //echo $this->lang->line('unArchive');?>" onclick="moveFromArchive('','LaunchEvent','LaunchEventId','<?php //echo $mainlaunchid; ?>','isArchive','/event/launch/deletedItems','');"><span><div class="blogUnArchiveIcon"></div></span></a>-->
									<?php
								}
								if($isBlocked != 't'){
									$deleteFunction="changeStatusAsDeleted('LaunchEvent','LaunchEventId','".$mainlaunchid."','launch','".$this->lang->line('sureDelMsg')."');";
									?> 
									<a href="javascript:void(0);" class="formTip ml6" onclick="<?php echo $deleteFunction;?>" title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}else{ 
								
								$field = array('launchEventId'=>$LaunchEventId);
								$result = countResult('EventSessions',$field);
								if($result==0){
									echo anchor($addUrl, '<div class="projectAddIcon"></div>',array('onclick'=>"$('#addsessionForm').submit();"));
								}
								?>	
								<a href="<?php echo $editUrl;?>" class="formTip" title="<?php echo $this->lang->line('edit')?>"><span><div class="projectEditIcon"></div></span></a> 
								
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								
								<a href="javascript://void(0);" class="formTip" onclick="moveInArchive('','LaunchEvent','LaunchEventId','<?php echo $mainlaunchid; ?>','isArchive','isPublished','/event/launch/launchdetail/','','','')"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a>
								<?php
							} ?>
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
                    <div class="blog_link3_box pt8 pl7">
                       <?php
							$eMeetingPointForm = array(
								'name'=>'eMeetingPointForm',
								'id'=>'eMeetingPointForm'
							);
							$eMeetingPointFormUrl = $this->router->class.'/launch/meetingpoint/'.$mainlaunchid;
							echo form_open($eMeetingPointFormUrl,$eMeetingPointForm); 	
								echo '<input id = "flag" name = "flag" value = "1" type = "hidden" />';
							echo form_close();	
						 ?>
				 
					
						<div class="tds-button"> 
							<a onclick="meetingpoint('<?php echo $meetingPoint;?>','<?php echo $this->lang->line('noMeetingPointMsg');?>');"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#" style="background-position: 0px -38px;"><span class="btn_meeting dash_link_hover" style="background-position: right -38px;">
								<div class="icon-meeting-btn">&nbsp;</div><div class="btn_content_wp"><?php echo $this->lang->line('meeting')?><br><div style="float:left; width:auto; margin:0px; height:auto"><?php echo $this->lang->line('point')?></div>
								<div style="float:right; width:auto; height:auto; font-size:11px; font-weight:bold; padding-top:1px; margin-left:23px;"><?php echo $meetingPoint;?></div>
								</div>
								</span>
							</a> 
						</div>
					
                    </div>
                  </div>
                </div>
                               
                
                <div class="row blog_links_wrapper">
                 <div class="fl cell">
					 <?php
						$currentUrl = base_url(lang().'/eventfrontend/eventlaunch/'.$userId.'/'.$mainlaunchid);				
						$relation = array('share','getShortLink' ,'email','show','entityTitle'=>  addslashes($Title), 'shareType'=>$this->lang->line('events'), 'shareLink'=> $currentUrl, 'id'=> 'launch'.$mainlaunchid,'entityId'=>$entityId,'elementid'=>$mainlaunchid,'projectType'=>'launch','isPublished'=>$isPublished);
					 ?>
					<div id="relationToSharePublish<?php echo $uniqueId;?>" class="row rtsp" <?php echo $rtspDisplay; ?> >
						<?php $relation['isPublished']='t';
						 $this->load->view('common/relation_to_share',array('relation'=>$relation));
						 ?>
					</div>
					
					<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="row rtsup" <?php echo $rtsupDisplay; ?>>
						<?php $relation['isPublished']='f';
						 $this->load->view('common/relation_to_share',array('relation'=>$relation));
						 ?>
					</div>
				 </div>
				 
				
                 
					<?php
					if($isArchive=='f' && $isBlocked=='f'){ 
						$whereArray = array('launchEventId'=>$mainlaunchid);						
						$totalSessions = countResult('EventSessions',$whereArray);
						
						
						$isFARF=1;
						if($isFARF && $sellstatus && !$isSellerSettings){
							$isFARF=0;
							$sessionMsg=$this->lang->line('sellerSettingsMsg');
						}
						
						$notificationArray = array('entityId'=>$entityId,'elementId'=>$mainlaunchid,'industryId'=>$Industry,'projectType'=>'performancesevents','alert_type'=>'launch');
						
						$publisButton=array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>0,'tabelName'=>'LaunchEvent','pulishField'=>'isPublished','field'=>'LaunchEventId','fieldValue'=>$mainlaunchid, 'totalSessions'=>$totalSessions,'checkSession'=>1,'notificationArray'=>$notificationArray);
						$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>0,'tabelName'=>'LaunchEvent','pulishField'=>'isPublished','field'=>'LaunchEventId','fieldValue'=>$mainlaunchid, 'totalSessions'=>$totalSessions,'checkSession'=>1,'notificationArray'=>$notificationArray);
						
						?>
						<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
							<?php  $this->load->view('common/publish_event',$publisButton); ?>
						</div>
						
						<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
							<?php $this->load->view('common/publish_event',$unpublisButton);?>
						</div> 
						<?php
						
					}?>
                   
                  				
                     <div class="clear"></div>
                      
                  </div>
                   <div class="create_similar_text"> <a href="javascript://void(0);" class="a_orange">Create a similar Launch</a></div>
                  
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
$sessionArray['isArchive'] = $isArchive;
$sessionArray['isBlocked'] = $isBlocked;
$sessionArray['isExpired'] = $launchexpired;
$sessionArray['isPublished'] = $isPublished;
echo Modules::run("event/sessionList",$sessionArray);

?>

</div>
<?php }?>
<div class="clear"></div>
<div class="seprator_10"></div>
</div><!-- End position_relative--> 

