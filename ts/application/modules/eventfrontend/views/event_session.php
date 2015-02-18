<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$sessionHeading=($eventType=='event')?$this->lang->line('sessionTimes'):$this->lang->line('launchSession');
	if(isset($eventList[0]) && $eventType=='launch'){
		$eventList['eventSessions'][0]=$eventList[0];
		$sessionHeading=$this->lang->line('launchSession');
		$displayDetails='';
		$id=isset($launchEventId)?$launchEventId:'';
	}else{
		$sessionHeading=$this->lang->line('sessionTimes');
		$displayDetails='dn';
		$id=isset($EventId)?$EventId:'';
	}
	
	$eventLink=base_url(lang().'/eventfrontend/'.$method.'/'.$userId.'/'.$id);
	
	if(!isset($userInfo)){
		$userInfo =showCaseUserDetails($userId);
	}
	$seller_currency=$userInfo['seller_currency'];
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	
	$sectionId=$this->config->item('performancesneventsSectionId');
	$maxPurchaseTickets=$this->config->item('maxPurchaseTickets');
	
	
	/*start manage session periode is expired*/
	$launchEventId=isset($launchEventId)?$launchEventId:0;
	$EventId=isset($EventId)?$EventId:0;
	$eventIsExpired = 'f';
	
	$eventDate=isset($eventList[0]['StartDate'])?$eventList[0]['StartDate']:$eventList[0]['date'];
	if($launchEventId > 0){
		$finishDate = $eventDate;
	}
	else{
		if(isset($eventList[0]['FinishDate'])) $finishDate = $eventList[0]['FinishDate'];
		else $finishDate = $eventList[0]['StartDate'];
	}
	
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
	
	/*end manage session periode is expired*/
?>
<div class="eventN_box_shadow bdr_a8a6a6 darkGrey_bg">
	<div class="seprator_10"></div>
	<div class="eventL_box clr_444 bg_white bdr_non pt5 min_hauto">
	  <!--sessionT_top_box-->
	  <div class="sessionT_top_box pb5 global_shadow_light">
		<div class="sessionT_heading pt4"> <?php echo $sessionHeading;?> </div>
		<div class="text_alignR font_opensans font_size18 pt15 pb10 org_anchor_hover"><a href="<?php echo $eventLink;?>"><?php if(isset($eventList[0]['Title'])) echo $eventList[0]['Title'];?></a></div>
	  </div>
	  <div class="seprator_20"></div>
	  <?php 
		/* Set expired title when expired it true*/
		if($eventIsExpired!='f'){
		?>
			<div class="tac pb10 f14 fm_os"><?php echo $this->lang->line('missedEvent');?></div>	
		<?php }?>
	  <!--sessionT_list-->
	  <?php
	  
		if(isset($eventList) && is_array($eventList) && count($eventList) > 0 && isset($eventList['eventSessions']) && is_array($eventList['eventSessions']) && count($eventList['eventSessions']) > 0){
			$event=$eventList[0];
			$NatureId=$event['NatureId'];
			
			switch($NatureId){
				case 1:
					$sectionId=$this->config->item('eventNotificationsSectionId');
				break;
				
				case 2:
					$sectionId=$this->config->item('eventsSectionId');
				break;
				
				case 3:
					$sectionId=$this->config->item('launchesSectionId');
				break;
				
				case 4:
					$sectionId=$this->config->item('eventswithLaunchSectionId');
				break;
			}
						
			$sessions=$eventList['eventSessions'];
			
			$countSessions=count($sessions);
			foreach($sessions as $skey=>$session){
				
				$eventSessionIsExpired='f'; // for checking session is expire
				//echo	date('H i s a',time());
				// check event session is expired
				$dateFormatSet = 'Y-m-d '.$session['endTime'];
				$eventSessionCloseDate= date($dateFormatSet,strtotime($session['date']));
				if(strtotime($eventSessionCloseDate)<=time()){
					$eventSessionIsExpired='t';
				}
				
			    $eventDate=$session['date'];
				$eventWD=dateFormatView($eventDate,'D');
				$eventD=dateFormatView($eventDate,'d');
				$eventM=dateFormatView($eventDate,'M');
				$eventY=dateFormatView($eventDate,'Y');
				
				$startTime=strlen($session['startTime'])>4?$session['startTime']:'00:00';
				$startTime=substr($startTime, 0, 5);
				//$startTime=str_replace(':','h',$startTime);
				$endTime=strlen($session['endTime'])>4?$session['endTime']:'24:00';
				$endTime=substr($endTime, 0, 5);
				//$endTime=str_replace(':','h',$endTime);
				
				$sessionTicket=false;
				$total_tickets =0;
				if(empty($tickets)) $total_tickets ='none';
				if(isset($tickets) && is_array($tickets) && count($tickets) > 0){
					$total_tickets =0;
					foreach($tickets as $tkey=>$ticket){
						
						if($ticket['SessionId']==$session['sessionId']){
							$total_tickets += $ticket['Quantity'];
							$sessionTicket[]=$ticket;
							unset($tickets[$tkey]);
						}
					}
				}
				
				$venueOrgniserDetails=array(
										'id'=>$id,
										'venueaddress'=>htmlentities($session['address']),
										'venueaddress2'=>htmlentities($session['address2']),
										'venuecountryName'=>htmlentities($session['countryName']),
										'venuestate'=>htmlentities($session['state']),
										'venuecity'=>htmlentities($session['city']),
										'venuezip'=>htmlentities($session['zip']),
										'venueEmail'=>htmlentities($session['venueEmail']),
										'venueName'=>htmlentities($session['venueName']),
										'venueurl'=>htmlentities($session['url']),
										'venuephoneNumber'=>htmlentities($session['phoneNumber']),
										'OrgName'=>htmlentities($event['OrgName']),
										'OrgAddress'=>htmlentities($event['OrgAddress']),
										'OrgAddress2'=>htmlentities($event['OrgAddress2']),
										'OrgCity'=>htmlentities($event['OrgCity']),
										'OrgState'=>htmlentities( $event['OrgState']),
										'OrgZip'=>htmlentities( $event['OrgZip']),
										'OrgURL'=>htmlentities( $event['OrgURL']),
										'OrgPhone'=>htmlentities( $event['OrgPhone']),
										'OrgEmail'=>htmlentities( $event['OrgEmail']),
										'OrgCountry'=>htmlentities( $event['orgniserCountry'])
									);
				
		$thisNatureId = $eventList[0]['NatureId'];
		$projectId=(isset($launchEventId) && $launchEventId > 0)?$launchEventId:$EventId;
		
		if($thisNatureId==2)
			$thisSectionId = '9:2';
		
		if($thisNatureId==3)
			$thisSectionId = '9:3';
		
		if($thisNatureId==4)
			$thisSectionId = '9:4';
	
		$sessionTicketDetails = array('tickets'=>$sessionTicket,'venueOrgniserDetails'=>$venueOrgniserDetails,'userInfo'=>$userInfo,'seller_currency'=>$seller_currency,'currencySign'=>$currencySign,'thisNatureId'=>$thisNatureId,'thisSectionId'=>$thisSectionId,'ownerId'=>$eventList[0]['tdsUid'],'projectId'=>$projectId);?>
				<div>
					<div class="sessionT_list font_size13 font_opensans">
					  <div class="sessionT_list_top">
						<div class="width_116 cell font_OpenSansBold pr8 height8 "><span class="position_absolute bottom_0 ml2"><?php echo $eventWD;?></span></div>
						<div class="width_216 cell pr8"><?php echo $session['venueName'];?></div>
						<div class="Fright"></div>
						<div class="clear"></div>
					  </div>
					  <div class="sessionT_list_bottom pt3">
						<div class="width_116 cell pr8 font_arial"><span class="font_size18 bold clr_ff0000 inline ml2"><?php echo $eventD;?></span> <?php echo $eventM.' '.$eventY;?> <span class="font_OpenSansBold pl40"><?php echo $startTime; echo (isset($endTime) && $endTime!='00:00')?'-'.$endTime:'';?></span></div>
						<div class="width_216 cell font_OpenSansBold pr8"><?php echo $session['sessionTitle'];?></div>
						
						<?php
						if($eventSessionIsExpired=='f'){
							if(isset($total_tickets) && $total_tickets>0){
								if($eventType=='event'){ 
									 if($session['eventSellstatus']!=''){
									?>								
									<div class="Fright mt_minus22 position_relative mr5 toggle_Ticket">
										<a class="Dgrey_btn black_link_hover" onclick="hideRelationDiv('sessionDetails<?php echo $session['sessionId']; ?>')" onmouseup="mouseup_Dgrey_btn(this)" onmousedown="mousedown_Dgrey_btn(this)"><?php echo $this->lang->line('Tickets');?></a>
									</div>
									<?php
									}else {
										?>								
									<div class="Fright mt_minus22 position_relative mr5 toggle_Ticket">
										<a class="Dgrey_btn black_link_hover" onclick="hideRelationDiv('sessionDetails<?php echo $session['sessionId']; ?>')" onmouseup="mouseup_Dgrey_btn(this)" onmousedown="mousedown_Dgrey_btn(this)"><?php echo $this->lang->line('details');?></a>
									</div>
									<?php
									}
								}else{ ?>
									<div class="Fright mt_minus18 position_relative mr5 toggle_Ticket2" >
										<a class="clr_e1545c" href="javascript:void(0)"><?php echo $this->lang->line('LAUNCH');?></a>
									</div>
									<?php
								}
							}else if($total_tickets ==0 && $total_tickets!='none'){ ?>
								<div class="Fright mt_minus22 position_relative mr5 toggle_Ticket"><a href="javascript:void(0);" class="Dgrey_btn clr_ff0000 black_link_hover"><?php echo $this->lang->line('sold_out');?></a></div>
								
							<?php	
								}
						}
						?>
						<div class="clear"></div>
					  </div>
					</div>
					<!--sessionT_ticket detail-->
				<?php 
				if($eventSessionIsExpired=='f'){
					//Check if no tickets and no seesion detail than show nothing
						if(!empty($venueOrgniserDetails) || !empty($tickets)){ 
					?>
					<div class="bdr_8e8e8e global_shadow_medium mr5 ml5 mb16 mt5 toggle <?php echo $displayDetails;?>" id="sessionDetails<?php echo $session['sessionId']; ?>">
						<?php
								
							
							if($session['eventSellstatus']=='f' && $session['eventSellstatus']!=''){
								$this->load->view('session_free',$sessionTicketDetails);
								//--------Start add join meeting point btn--------//
								/*	if(ENVIRONMENT != 'production'){*/
									if($session && isset($session) && is_array($session) && count($session) > 0){
										//load join meeting button
										echo $this->load->view('join_meeting_point',array('eventList'=>$eventList[0],'sessionData'=>$session,'mt12'=>'','isDetailVal'=>'0'));
									}
								/*}*/
								//--------End add join meeting point btn----------//
							}
							else if($session['eventSellstatus']=='t' && $session['eventSellstatus']!=''){
								if($session['earlyBirdStatus']=='f'){
									$this->load->view('session_sell',$sessionTicketDetails);
								}else{
									$currentDateTime= currntDateTime('y-m-d');
									if(isset($sessionTicket[0]['beforeDate']) && (strtotime($sessionTicket[0]['beforeDate']) > strtotime($currentDateTime)) ){
										$this->load->view('session_earlyBird',$sessionTicketDetails);
									}else{
										$this->load->view('session_sell',$sessionTicketDetails);
									}
								}
								//--------Start add join meeting point btn--------//
								/*if(ENVIRONMENT != 'production'){*/
									if($session && isset($session) && is_array($session) && count($session) > 0){
										//load join meeting button
										echo $this->load->view('join_meeting_point',array('eventList'=>$eventList[0],'sessionData'=>$session,'mt12'=>'','isDetailVal'=>'0'));
									}
								/*}*/
								//--------End add join meeting point btn----------//
							
							}else{
							?>
							 <div class="sessionT_ticketdetail_msg"></div>
							  <div class="seprator_15"></div>
							  <div class="sessionT_cat_list_box">	
								<?php	
									$this->load->view('orgniser_venue_view',array('venueOrgniserDetails'=>$venueOrgniserDetails,'section'=>'eventSession'));
									//--------Start add join meeting point btn--------//
									/* if(ENVIRONMENT != 'production'){ */
										if($session && isset($session) && is_array($session) && count($session) > 0){
											//load join meeting button
											echo $this->load->view('join_meeting_point',array('eventList'=>$eventList[0],'sessionData'=>$session,'mt12'=>'mt12','isDetailVal'=>'1'));
										}
									/*} */
									//--------End add join meeting point btn----------//	
								?>
								<div class="clear seprator_15"></div>
							 </div>
							<?php
							}
						?>
                    </div>
				    <?php
					}
				}
					if($countSessions == ($skey+1)){
						echo '<div class="seprator_10"></div>';
					}
					?>   
				</div>
				<?php
			}
		}else{
				echo $this->lang->line('noRecord');
		}?>
	
	 </div>
	<div class="seprator_5"></div>
	<?php 
	if(isset($eventIsExpired) && $eventIsExpired=='f'){?>
	<div class="clear"></div>
	<div class="ml285">
		<a class="dash_link_hover white font_opensansLight f13" target="_blank" href="<?php echo site_url().'tips/front_tips/34' ?>"><?php echo $this->lang->line('aboutMeetingPoint');?></a>
	</div>
	<div class="seprator_10"></div>
	<?php } ?>
</div>

  <div class="row width470px ma mt10"> <?php $this->load->view('common/adv_content_bot'); ?></div>
<?php 
$formAttributes = array(
	'name'=>'buyTicketsForm',
	'id'=>'buyTicketsForm'
);
$ticketDetails = array(
	'name'	=> 'ticketDetails',
	'id'	=> 'ticketDetails',	
	'type' =>'hidden',
	'value'	=> ''
);
echo form_open(base_url_secure(lang().'/cart/buyTickets'),$formAttributes);
echo form_input($ticketDetails);
echo form_close();
?>
<script>
	
	function purchaseTicket(selectClass,SessionId,type,remainingPurchaseTicketsLimit){
		if(SessionId){
			SessionId=parseInt(SessionId);
		}else{
			SessionId=0;
		}
		
		if(selectClass && (SessionId > 0) && type){
			var seller_currency='<?php echo $seller_currency;?>';
			var sectionId='<?php echo $sectionId;?>';
			var ownerId='<?php echo $userId;?>';
			var eventORlaunchId='<?php echo $id;?>';
			var entityId='<?php echo $entityId;?>';
			var isQuantity=false;
			var msg = '<?php echo $this->lang->line('selectAtleastOneTicket');?>';
			var ticketData = '[';
			var i =0;
			var qty = 0;
			$('select'+selectClass).each(function(index){
				qty= $(this).attr("value");
				qty=parseInt(qty);
				if(qty > 0){
					i++;
					isQuantity=true;
					TicketId=$(this).attr("TicketId");
					ticketData+='{"sectionId":"'+sectionId+'","ownerId":"'+ownerId+'","entityId":"'+entityId+'","eventORlaunchId":"'+eventORlaunchId+'","SessionId":"'+SessionId+'","TicketId":"'+TicketId+'","qty":"'+qty+'","type":"'+type+'","seller_currency":"'+seller_currency+'"},'; 
				}
				
			});
			if((type==0) && (qty > remainingPurchaseTicketsLimit)){
				var maxPurchaseTickets= '<?php echo $maxPurchaseTickets;?>';
				var allReadyPurchased =(maxPurchaseTickets - remainingPurchaseTicketsLimit);
				var msg = '';
				if(remainingPurchaseTicketsLimit==0){
					msg = 'You have already bought '+maxPurchaseTickets+' free tickets of this event.';
				}else{
					msg = 'You cannot purchase more than '+remainingPurchaseTicketsLimit+' free tickets.';
				
				}
				customAlert(msg);
			}else{
				
				//-----if purchase type 0 means ticket are free directly buy-----//
				if(type==0){
					if(isQuantity){
						ticketData = '';
						var LoggedInUserId = '<?php echo isLoginUser(); ?>';
						ticketData+='{"sectionId":"'+sectionId+'","ownerId":"'+ownerId+'","entityId":"'+entityId+'","eventORlaunchId":"'+eventORlaunchId+'","SessionId":"'+SessionId+'","TicketId":"'+TicketId+'","qty":"'+qty+'","type":"'+type+'","seller_currency":"'+seller_currency+'","LoggedInUserId":"'+LoggedInUserId+'"}'; 
						$("#ticketDetails").val(ticketData);
						var fromData=$("#buyTicketsForm").serialize();
						var url = '<?php echo base_url(lang().'/eventfrontend/buyfreeticket') ?>';
						openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
						$.post(url,fromData, function(data) {
						  if(data){
									$('#popupBoxWp').trigger('close');
									$('#popup_box').hide();
									$('#defaultLoader').remove();
									customAlert(data.msg);
								if(data.success=='1'){
									$(".popup_close_btn").attr( 'onclick', 'refreshMypage()' );
								}
							}
						},"json");
						return false;
					}else{
						customAlert(msg);
					}
				}{
				
					ticketData+='{"eor":"1"}]';
					if(isQuantity){
						//ticketData=ticketData.serialize();
						$("#ticketDetails").val(ticketData);
						$("#buyTicketsForm").submit();
					}else{
						customAlert(msg);
					}
				}
			}
			
		}
	}
	
	//----------refresh my current page-------//
	
	function refreshMypage(){
		refreshPge();
	}
	
	
	function calculateTicketPrice(selectClass){
		var ticketPrice = 0;
		var ticketTotalPrice = 0;
		var sumOfPrice = 0;
		var qty = 0;
		var ticketPriceDiv = '';
		var sumOfPriceDiv = '';
		$('select'+selectClass).each(function(index){
			ticketCurrentId = $(this).attr("ticketCurrentId");
			ticketPriceDiv = $(this).attr("ticketPriceDiv");
			sumOfPriceDiv = $(this).attr("sumOfPriceDiv");
			ticketPrice = $(this).attr("ticketPrice");
			ticketPrice = parseFloat(ticketPrice);
			qty = $(this).attr("value");
			qty =parseInt(qty);
			ticketTotalPrice =(qty*ticketPrice);
			sumOfPrice = (sumOfPrice+ticketTotalPrice);
			ticketTotalPrice = parseFloat(ticketTotalPrice).toFixed(2);
			$(ticketPriceDiv).html('<?php echo $currencySign;?> '+ticketTotalPrice);
			
			$('#qnty'+ticketCurrentId+'').val(qty);
		});
		sumOfPrice=parseFloat(sumOfPrice).toFixed(2);
		$('#priceTotal'+ticketCurrentId+'').val(sumOfPrice);
		$(sumOfPriceDiv).html('<?php echo $currencySign;?> '+sumOfPrice);
	}

	
	
</script>
