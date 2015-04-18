<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(!isset($countNotification)){
		if(isset($notificationList) && is_array($notificationList) && count($notificationList) > 0){
			$countNotification = count($notificationList);
		}else{
			$countNotification = 0;
		}
	}
	$countNotification=$countNotification>0?$countNotification:0;
	$main_button_div_class = '';
?>
<td class="bg_SREvent" valign="top">
	<div class="cell width_476 sub_col_1 pr9 pl9 ">
		<div class="seprator_10"></div>
		<?php
		if($eventList && isset($eventList[0]) && is_array($eventList[0]) && count($eventList[0]) > 0) {
			echo "<div class='row' id='elementListingAjaxDiv'>";
			echo $eventPage; 
			echo "</div>";
		}else{
			redirectToNorecord404();
			//echo "<div class='p15'>".$this->lang->line('noRecord')."</div>";
		}?>
		<div class="clear seprator_10"></div>
	</div>

</td>
<td class="bg_SREvent" valign="top">
	<div class="cell width_284 pl10 pr10 sub_col_2 ">
		<?php
			$launchEventId=isset($launchEventId)?$launchEventId:0;
			$EventId=isset($EventId)?$EventId:0;
			$eventIsExpired = 'f';
			//echo "<pre>";
			//print_r($eventList[0]);die;
			
			
			if(($launchEventId > 0 || $EventId > 0) && ($eventList && isset($eventList[0]) && is_array($eventList[0]) && count($eventList[0]) > 0)){
				$eventDate=isset($eventList[0]['StartDate'])?$eventList[0]['StartDate']:$eventList[0]['date'];
				if($launchEventId > 0){
					$finishDate = $eventDate;
				}
				else{
					if(isset($eventList[0]['FinishDate'])) $finishDate = $eventList[0]['FinishDate'];
					else $finishDate = $eventList[0]['StartDate'];
				}
				
				$Rating = $eventList[0]['otpion'];
				$eventDate=dateFormatView($eventDate,'Y-m-d');
				$finishDate=dateFormatView($finishDate,'Y-m-d');
				$currentDateTime=currntDateTime('Y-m-d');
				
				$eventDate = new DateTime($eventDate);
				$currentDate = new DateTime($currentDateTime);
				$finishDate = new DateTime($finishDate);
				$interval = $currentDate->diff($eventDate);
				$intervalForFinishDate = $currentDate->diff($finishDate);
				
				$intervaltoshow= $interval->format('%a');
				$matchinterval= $interval->format('%R%a');		
				$intervalForFinishDate= $intervalForFinishDate->format('%R%a');
							
				if($matchinterval <= 0 && $intervalForFinishDate <= 0) $eventIsExpired = 't';
				//if($eventIsExpired == 'f'){
					if($matchinterval > 0){
						$remaingDays=$intervaltoshow.' '.$this->lang->line('days');
						$toGo=$this->lang->line('toGo');
						$StartingIn=$this->lang->line('Starting_in');
					}else{
						$StartingIn= '';
						$remaingDays=$this->lang->line('Ongoing');
						$toGo=$this->lang->line('going');
					}
					
					$earlyBirdStatus='f';
					$eventSellstatus='f';//code change by lokendra(22-aug-2013) old value is 'NULL'
					$eventFreeStatus='f';
					$ticketLink='';
					if($launchEventId > 0){
						$ticketLink=base_url(lang().'/eventfrontend/sessionTickets/'.$userId.'/'.$launchEventId.'/launch'); 
						$ticketLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$launchEventId).'/sessionTickets/launch':$ticketLink;
						$earlyBirdStatus=$eventList[0]['earlyBirdStatus'];
						$eventSellstatus=$eventList[0]['eventSellstatus'];
					}else if(isset($eventList['eventSessions']) && count($eventList['eventSessions'])>0){
						
						$ticketLink=base_url(lang().'/eventfrontend/sessionTickets/'.$userId.'/'.$EventId.'/event'); 
						$ticketLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$EventId).'/sessionTickets/event':$ticketLink;
						
						foreach($eventList['eventSessions'] as $session){
							//echo '<pre />';print_r($session);
							if($session['earlyBirdStatus']=='t'){
								$earlyBirdStatus='t';
							}
							if($session['eventSellstatus']=='t'){
								$eventSellstatus='t';
							}
							if($session['eventSellstatus']=='f'){
								$eventFreeStatus='t';
							}
						}
					}
					$ticketLabel=($eventSellstatus=='f')?$this->lang->line('Tickets'):($eventSellstatus=='t')?$this->lang->line('buyTickets'):$this->lang->line('sessionDetails');
					$offerImage=base_url().'images/frontend/';
					if($eventSellstatus=='f'){
						
						//$offerImage.='free_tag.png'; old value 22-aug-2013
				
						//-------code add by lokendra(22-aug-2013) start-------//
						if($eventFreeStatus=='t' && $earlyBirdStatus=='t'){
							$offerImage.='freeearlybirdoffer_tag.png';
						}
						elseif($eventFreeStatus=='t'){
							$offerImage.='free_tag.png';
						}
						elseif($earlyBirdStatus=='t'){
							$offerImage.='earlybirdoffer_tag.png';
						}else{
							$offerImage=true;
							$main_button_div_class = 'pl50';
						}
						//----------code add by lokendra end-----//
					}
					else if($eventSellstatus=='t')
					{
						if($eventFreeStatus=='t' && $earlyBirdStatus=='t'){
							$offerImage.='freeearlybirdoffer_tag.png';
						}
						elseif($eventFreeStatus=='t'){
							$offerImage.='free_tag.png';
						}
						elseif($earlyBirdStatus=='t'){
							$offerImage.='earlybirdoffer_tag.png';
						}
						else{
							$offerImage=true;
							$main_button_div_class = 'pl50';
						}
					}
					else{
						$offerImage=true;
						$main_button_div_class = 'pl50';
					}
					//}
				//else{
				//	$offerImage=false;
				//} 
			
				$FDdata=array(
				
								'title'=>$eventList[0]['Title'],
								'description'=>$eventList[0]['Description']
							 );
				$FD=$this->load->view('further_description',$FDdata,true);
				
				/* add class when event is expired*/
				if($eventIsExpired != 'f'){ 
					$main_button_div_class = 'pl50';
					$offerImage=false;
				}	
				?>
				
			  
				<div class="scroll_box darkGrey_bg bdr_a8a6a6 mt10 mb10">
					<div class="mt15 Fleft">
						<a href="<?php echo $ticketLink;?>">
							<?php if($eventIsExpired == 'f'){ ?>
							<div class="eventL_countdown_new position_relative width_98 bdr_white bdew6_2side ml30 mr30" onmouseup="mouseup_apply_btn(this)" onmousedown="mousedown_apply_btn(this)">
								<span><?php echo $StartingIn;?></span><span class="clr_ff0000 font_OpenSansBold font_size14 text_alignC"><?php echo $remaingDays;?></span>
							</div>
							<?php }else{ 
								$ticketLabel = $this->lang->line('sessionDetails'); ?>
							<div class="eventL_countdown_new position_relative width_98 bdr_white bdew6_2side ml30 mr30 f17imp text_alignC" onmouseup="mouseup_apply_btn(this)" onmousedown="mousedown_apply_btn(this)">	
								<span><?php echo $this->lang->line('missedEventButton');?></span>	
							</div>	
							<?php } ?>	
						
						<span id="sessionTicketButton" class="Apply_big_btn_new  ml30 mr30" onmouseup="mouseup_apply_btn(this)" onmousedown="mousedown_apply_btn(this)"><?php echo $this->lang->line('ticketsessiondetailsmsg'); ?></span>
						</a>
						<div class="text_alignC font_opensans pt3 pl2 pr2">
							<?php echo $Rating;?>
						</div>
					</div>
					<?php
					//}
						if(isset($offerImage) && $offerImage!='' && $offerImage!=1 ){ 
					?>
					<div class="Fleft">
						<img src="<?php echo $offerImage;?>">
					</div>
					<?php } ?>	
					<div class="clear">
					</div>
				</div>
				
				
			 <!-- session Ticket -->
				
				<script>var FD=<?php echo json_encode($FD);?>;</script>
				<div class="row summery_right_archive_wrapper width_auto pb0 ptr" onclick="javascript:loadPopupData('popupBoxWp','popup_box',FD);">
					<h1 class="sumRtnew_strip clr_white gray_light_hover"><?php echo $this->lang->line('furtherNoBRDescription');?>
					  <div class="Fright mt9 mr23">
						  <a onclick="javascript:loadPopupData('popupBoxWp','popup_box',FD);" onmousedown="mousedown_plus_icon(this)" onmouseup="mouseup_plus_icon(this)" class="ma_plus_icon"></a>
					  </div>
					</h1>
				</div>		
			<?php
				$isOngoingEvantLaunch=false;
				if(($EventId >0) && ($eventList[0]['LaunchEventId']>0)&& ($eventList[0]['islaunchpublish']=='t')){
					$isOngoingEvantLaunch=true;
					$ongoingEvantLaunch=$this->lang->line('launch');
					
					$EvantLaunchLink=base_url(lang().'/eventfrontend/eventlaunch/'.$userId.'/'.$eventList[0]['LaunchEventId']);
					$EvantLaunchLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$eventList[0]['LaunchEventId']).'/eventlaunch':$EvantLaunchLink;
					
				}elseif(($launchEventId >0) && ($eventList[0]['EventId']>0)&& ($eventList[0]['iseventpublish']=='t')){
					$isOngoingEvantLaunch=true;
					$ongoingEvantLaunch=$this->lang->line('ongoingEvent');
					$EvantLaunchLink=base_url(lang().'/eventfrontend/event/'.$userId.'/'.$eventList[0]['EventId']);
					$EvantLaunchLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$eventList[0]['EventId']).'/event':$EvantLaunchLink;
				}
				if($isOngoingEvantLaunch){ ?>
				  <div class="row summery_right_archive_wrapper width_auto pb10 ptr" onclick="window.location.href='<?php echo $EvantLaunchLink;?>'">
						<h1 class="sumRtnew_strip clr_white gray_light_hover"><?php echo $ongoingEvantLaunch;?>
						  <div class="Fright mt9 mr23"> <a href="<?php echo $EvantLaunchLink;?>" onmousedown="mousedown_plus_icon(this)" onmouseup="mouseup_plus_icon(this)" class="ma_plus_icon"></a>
						  </div>
						</h1>
				  </div>
					<?php
				}
			}
		?>			
		  <div class="pt10 pb7">
			  <?php if($countNotification > 0){ 
					$eventLink=base_url(lang().'/eventfrontend/eventnotification/'.$userId);
					$eventLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/0/eventnotification'):$eventLink;
				  ?>
				  <div class="colap_leftSide hoverOrange"> <span class="Fleft"><a href="<?php echo $eventLink;?>" class="hoverOrange"><?php echo $this->lang->line('eventNotifications');?> (<?php echo $countNotification;?>)</a></span>
					<div class="clear"></div>
				  </div>
				  <?php
			   } 
				
				$this->load->view('launchEvent_list',array('LaunchEvents'=>$LaunchEvents,'launchEventId'=>$launchEventId)); 
				$this->load->view('event_list',array('events'=>$events,'EventId'=>$EventId)); 
				
				if(isset($suportLinks) && $suportLinks){
					echo '<div class="seprator_16"></div>';
					 $this->load->view('mediafrontend/supporting_material',array('suportLinks'=>$suportLinks,'clr_white'=>'clr_white'));
					 echo '<div class="seprator_16"></div>';
				}
				
				if($launchEventId > 0 || $EventId > 0)
				{
					echo '<div class="seprator_20 clear row"></div>';
					$projectId=($launchEventId > 0)?$launchEventId:$EventId;
					$tableInfo=array(
									'entityId'=>$entityId,
									'elementId'=>$projectId,
									'tableName'=>array('AddInfoNews','AddInfoInterview','AddInfoReviews'),
									'sections'=>array($this->lang->line('news'),$this->lang->line('interviews'),$this->lang->line('externalReviews')),
									'orderBy'=>array('news','interv','review'),
									'sectionBgcolor'=>'rightBoxBG'
								);
					echo Modules::run("additionalInfo/additionalInfoList", $tableInfo);
				}
			  ?>
			<div class="clear seprator_20"></div>			  
				<!-- Div for 250x250 advert display-->
				<div class="ad_box_shadow width250px mb20" id="advert250_250"><?php 
					if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
						//Manage right side forum advert
						$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
						if(!empty($bannerRhsData)) {
							$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
						} else {
							$this->load->view('common/adv_rhs_forum');
						}
					} else {
						$this->load->view('common/adv_rhs_forum');
					}?>
				</div>
		  </div>
	</div>
</td>

<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	}
?> 
