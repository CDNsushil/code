<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$totalRecords = count($listData);
if($totalRecords > 0)
{
	foreach($listData as $key => $value)
	{	
		$uniqueId='element'.$value['EventId'];
		if($value['isPublished']=='t'){
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
		
		$createDate=$value['EventDateCreated'];
		$expiryDate=$value['expiryDate'];
		$currentDate = date("Y-m-d H:i:s");
		if(strlen($expiryDate) < 10){
			 $expiryDate= dateFormatView(date('Y-m-d',(strtotime($value['EventDateCreated'])+(60*60*24*30*3))))	;
			 $event_expiry_date = date('Y-m-d',(strtotime($value['EventDateCreated'])+(60*60*24*30*3)));
		}else{
			$event_expiry_date = $expiryDate;
			$expiryDate= dateFormatView($expiryDate);
		}
		
		if($event_expiry_date != '' && $currentDate <= $event_expiry_date) {
			$expiryDateColor = '';
			$expire_label = $this->lang->line('toolExpires');
		} else {
			$expiryDateColor = 'clr_red';
			$expire_label = $this->lang->line('toolExpired');
		}
		
		$createDate=dateFormatView($createDate);
		
		$Title = getSubString($value['Title'], 40);	
			 
		//DEFINING EDIT,PREVIEW AND DELETE URLS
		$maineventid = $value['EventId'];
		$encodedEventId = encode($maineventid);
		$delFlag=0;

		$url = 'deleteEvent/'.$encodedEventId;
		$addUrl = base_url('event/eventnotifications/eventsession/'.$maineventid.'/'.$NatureId);
		$editUrl = base_url('event/eventnotifications/eventform/'.$maineventid);
		$previewUrl = base_url('event/previewEvent');
		
		if(isset($value['StartDate']) && $value['StartDate'] != '')
		{
			$eventStartDate = date("l, d F Y", strtotime($value['StartDate']));
		}
		
		$eventFinishDate = '';
		if(isset($value['FinishDate']) && $value['FinishDate'] != '')
		{
			$eventFinishDate = date("l, d F Y", strtotime($value['FinishDate']));
		}

		if(isset($value['LaunchDate']) && $value['LaunchDate'] != '')
		{
			$eventLaunchDate = date("l, d F Y", strtotime($value['LaunchDate']));
		}

		$eventTime = $value['Time'];
		
		//if filepath is set for any of the event type it will shoe he respective image else show the no-image 
		if(isset($value['filePath'])){
		 if($value['filePath']!='')
			$imagePathForEvent = $value['filePath'].'/'.$value['fileName'];
			$smallNotificationImg = addThumbFolder(@$imagePathForEvent,'_s');
		}
		else $smallNotificationImg ='';

		$eventMediaSrc = getImage($smallNotificationImg, $this->config->item('defaultEventImg_s'));
		
		if((strpos($value['OrgURL'], 'http://') === false) && @$value['OrgURL'] !='')  $VenueURL = "http://".$value['OrgURL'];
		else $VenueURL = $value['OrgURL'];
		if(@$VenueURL=='') $VenueURL = '--';
		$notificationTime = '';
		if(isset($value['Time'])&& $value['Time']>0){	
			list($starthour, $startmin, $startsec) = explode(":", $value['Time']);

			if(substr($starthour,0,1) ==0) $starthour = substr($starthour,1);
			if(substr($startmin,0,1) ==0) $startmin = substr($startmin,1);

			
			if($starthour>0) $notificationTime = $starthour.'h';
			if($starthour<=0) $startmin = $startmin.'min';
			if($startmin>0) $notificationTime .= $startmin;
		}
		
		//FOR ADDRESS DEFINING VARIABLE
		$addressInfo = '--';
		if(isset($value['OrgName']) &&  $value['OrgName']!='')
		{
			if(isset($addressInfo ) &&  $addressInfo !='') $addressInfo = $value['OrgName'];
			
		}
		
		if(isset($value['OrgAddress']) &&  $value['OrgAddress']!='')
		{
			if(isset($addressInfo ) &&  $addressInfo !='') $addressInfo = $value['OrgAddress'];
			
		}
		//Line Or Online Event Notification
		/*
		$TypeEvent = getDataFromTabel('MasterProjectType','projectTypeName','typeId',$value['Type']);
		
		if(is_array($TypeEvent)) 
		{
			$OrgLiveOrOnline = $TypeEvent[0]->projectTypeName;
			$check = strstr($OrgLiveOrOnline, 'Live');
			if(empty($check)) $LiveOrOnline = 'Online';
			else $LiveOrOnline = 'Live';
		}
		* */
		$LiveOrOnline = '';
		if(@$value['Type'] ==1 || @$value['Type']=='') $LiveOrOnline = 'Live';
		if(@$value['Type'] ==2) $LiveOrOnline = 'Online';
			
				
?>
		
			<div class="row blog_wrapper new_theme_blog_box_gray">
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
					<div class="event_inner_heading"><?php echo $Title;	?></div><!--event_inner_heading-->
					<div class="row">
					<div class="browse_thumb_wrapper cell ml0">
					<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
					   <tbody><tr><td><img src="<?php echo $eventMediaSrc; ?>" border="0"/></td></tr></tbody>
					</table>
				 </div><!--browse_thumb_wrapper-->                     
                     
                 <div class="inner_date_box_wrapper">
					<div class="inner_date_box">Date</div> <div class="inner_date_wp"><?php echo $eventStartDate;?></div>
					<div class="clear"></div>
					<div class="inner_date_box"><?php echo $label['venue']; ?></div> <div class="inner_date_wp"><?php echo getSubString($addressInfo, 30);	?></div>
					<div class="clear"></div>
					<div class="inner_date_box"><?php echo strtoupper($label['url']);?></div> <div class="inner_date_wp overflowHid"><?php echo $VenueURL; ?></div>
					<div class="clear"></div>
					<!--div class="inner_date_box"><?php echo $this->lang->line('eventLabTime');?></div> <div class="inner_date_wp"><?php echo $notificationTime;?></div-->
					<div class="clear"></div>
					<div class="inner_date_box"><?php echo $this->lang->line('type');?></div> <div class="inner_date_wp"><?php echo (@$value['EventType']=='1' || @$value['EventType']=='' )?'Event':'Launch';	?></div>
                 </div><!--inner_date_box_wrapper-->
                </div><!--row-->
				<div class="clear"></div>
				
				<div class="published_box_wp ">
					<div class="published_heading"><?php echo $this->lang->line('FirstSaved');?></div> 
					<div class="published_date"><?php echo $createDate;?></div>                            
					<div class="clear"></div>  
					<div class="published_heading"><?php echo $expire_label;?></div> 
					<div class="published_date <?php echo $expiryDateColor;?>"><?php echo $expiryDate;?></div>                            
					<div class="clear"></div>
					<!--div class="tds-button renew_btn"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span><?php echo $this->lang->line('Renew');?></span></a> </div-->
				</div><!--published_box_wp-->                    
               </div>
                  <!--blog_links_wrapper-->
               </div>
			   <div class="cell blog_right_wrapper">
                  <div class="blog_link2_wrapper">
                   <div class="tds-button-top modifyBtnWrapper"> 							
					<a href="<?php echo $editUrl;?>" class="formTip" title="<?php echo $this->lang->line('edit')?>">
						<span>
							<div class="projectEditIcon"></div>
						</span>
					</a> 

					<?php //Preview Icon
						$viewLink = base_url(lang().'/eventfrontend/eventnotification/'.$userId.'/'.$maineventid);
						$previewLink = base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$maineventid.'/eventnotification');
						$viewTooltip=$this->lang->line('view');
						$previewTooltip=$this->lang->line('preview');
					?>
					<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
					<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
					<a href="javascript:void(0);" class="formTip" onclick="moveInArchive('','Events','EventId','<?php echo $maineventid; ?>','EventArchive','isPublished','/event/eventnotifications','notification','','');"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
					</div>   
                    <!--icon_edit_blog-->
                  </div>
                  <div class="clear"></div>
                 <?php 
                  
                  //Fetch records from logsummary table for ratting,crave and view value for event
					$LogSummarywhere=array('entityId'=>$entityId,'elementId'=>$maineventid);
					
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
					
					$cravedALL = '';
					$loggedUserId = $userId;
					if($loggedUserId > 0){
						$where = array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$entityId,
								'elementId'=>$maineventid
							);
						$countResult = countResult('LogCrave',$where);
						$cravedALL = ($countResult>0)?'admin_cravedALL':'';
					}else
					{
						$cravedALL = '';
					}						  
                  ?>
                  
                  <div class="rating_box_wrapper" style="padding-top:12px;">
                  	<div class="live_text"><?php echo $LiveOrOnline;?></div>
                    <div class="rating_cover">
                      <?php $this->load->view('rating/ratingAvg',array('elementId'=>$maineventid,'entityId'=>$entityId,'ratingClass'=>'cell ml14 Fright'));?>
                    </div>
                  </div>
                  <!--rating_box_wrapper-->
                  
                  <div class="clear"></div>
                  <div class="blog_link3_wrapper">
                    <div class="blog_link3_box">
                      <div class="icon_crave2_blog <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves');?></div>
                      <div class="blog_link3_point"><?php echo ($craveCount>0)?$craveCount:0; ?></div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_post2_blog"><?php echo $this->lang->line('reviews');?></div>
                      <div class="blog_link3_point"><?php echo ($reviewCount>0)?$reviewCount:0; ?></div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_view2_blog"><?php echo $this->lang->line('Views');?></div>
                      <div class="blog_link3_point"><?php echo ($viewCount>0)?$viewCount:0; ?> </div>
                    </div>
                    
                    <div class="blog_link3_box">
                      <div class="icon_lastview2_blog"> Last Viewed<br/><b><?php echo $lastViewDate;?></b> </div>
                    </div>
                  </div>
                </div>                             
                
                <div class="row blog_links_wrapper">
					
					<div class="fl cell">
						 <?php
							$currentUrl = base_url(lang().'/eventfrontend/eventnotification/'.$userId.'/'.$maineventid);					
							$relation = array('email','share','getShortLink','entityTitle'=>addslashes($Title),'shareType'=>$this->lang->line('events'),'shareLink'=> $currentUrl,'id'=> 'event'.$maineventid,'isPublished'=>$value['isPublished']);
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
						$notificationArray = array('entityId'=>$entityId,'elementId'=>$maineventid,'industryId'=>$value['IndustryId'],'projectType'=>'performancesevents');
						
						$publisButton = array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>1,'tabelName'=>'Events','pulishField'=>'isPublished','field'=>'EventId','fieldValue'=>$maineventid,'notificationArray'=>$notificationArray);
						$unpublisButton = array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>1,'tabelName'=>'Events','pulishField'=>'isPublished','field'=>'EventId','fieldValue'=>$maineventid,'notificationArray'=>$notificationArray);
					?> 
					<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
						<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
					</div>
					
					<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
						<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
					</div>              
								
				   <div class="clear"></div>                      
               </div>
               <div class="create_similar_text"><a href="" class="a_orange">Create a similar Event Notification</a></div>
			   <div class="clear"></div>
			  </div>
			</div>
			<!--blog_wrapper-->
            <div class="shadow_blog_box"></div><!--shadow_blog_box-->
		
		
		<?php		
	}//END FOR FOREACH LOOP
	
	if($items_total >  $perPageRecord){
		?>
		<div class="row">
			<div class="cell width_569 pagingWrapper">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/event/eventnotifications'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php
	}  

}
