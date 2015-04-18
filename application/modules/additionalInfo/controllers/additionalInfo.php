<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare mediatheme Controller Class
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sapna Jain
 *  @link		http://toadsquare.com/
 */

class additionalInfo extends MX_Controller {

	private $userId = NULL;
	
	/**
	 * Constructor
	**/
	function __construct(){
	  //My own constructor code
	  $load = array(
			'library' 	=> 'Lib_masterMedia + lib_sub_master_media + lib_additional_info+ lib_social_media',
			//'language' 	=> 'additionalInfo',
			'helper' 	=> 'form + file + archive'				
	  );
	  
	  parent::__construct($load);
	  $this->userId= isLoginUser()?isLoginUser():0;
	
	}

	/**
		* Loads News form (Entry) on page
	**/
	/* no further use, commented by sushil: 03/02/2014
	public function newsForm($entityId=0,$elementId=0,$returnUrl='')
	{		
		$newsFormData['entityId'] = $entityId;
		$newsFormData['elementId'] = $elementId;	 
		$this->load->view('news_form',$newsFormData);	 
	} */
	
	/**
		* Loads REVIEWS form (Entry) on page
	**/
	function reviewForm($entityId=0,$elementId=0,$returnUrl='')
	{
		$reviewFormData['entityId'] = $entityId;
	    $reviewFormData['elementId'] = $elementId;
		$reviewFormData['label'] = $this->lang->language;
		$this->load->view('review_form',$reviewFormData);
	}

	/**
		* Loads Interviews form (Entry) on page
	**/
	function interviewForm($entityId=0,$elementId=0,$returnUrl='')
	{
		$interviewForm['entityId'] = $entityId;
	    $interviewForm['elementId'] = $elementId;
		$interviewForm['label'] = $this->lang->language;
		$this->load->view('interview_form',$interviewForm);
	}
	
	/**
		* Loads News form (Entry) on page
	**/
	public function sesTimeForm($entityId=0,$elementId=0,$returnUrl='',$entityType,$launchEventEntity='',$launchEventId=0)
	{
	 
		
		//$finalsocialMediaData['socialMedia'] = $this->lib_additional_info->getValuesFromDB($elementId);	
		/* else $range = getDataFromTabel('LaunchEvent','LaunchEventCreated',$rangeArray); */
		
	    if($launchEventEntity == '') 
	    {
		 $sesTimeData['eventId'] = $elementId;
		 $sesTimeData['launchEventId'] = 0;
		}
		
		if($elementId!=0)
		{
		 $sesTimeData['eventId'] = $elementId;
		 $sesTimeData['launchEventId'] = $launchEventId;
		}
		
		if($elementId==0) 
		{
		 $sesTimeData['eventId'] = 0;
		 $sesTimeData['launchEventId'] = $launchEventId;
		}		
		 
		$masTktArray = array('tableName'=>'MasterTicketCategories');
		
		//capturing table Id from costant defined file using tableName			
		$masTkflds = $this->db->list_fields($this->db->dbprefix($masTktArray['tableName']));

		foreach ($masTkflds as $field)
		{
			$masTktArray['fieldKeys'][]=$field;
		} 

		$masTktObject = new lib_additional_info($masTktArray) ;
		$whereArray='';
		$orderBy = '';
		$masTktData = $masTktObject->listAdditionalInfo($whereArray,$orderBy,$limit=0,1);
	
		$sesTimeData['masterTickets'] =	$masTktData;	
		/*
		$addInfoSessArray = array('tableName'=>'EventSessions');
		
		//capturing table Id from costant defined file using tableName		
		$fields = $this->db->list_fields($this->db->dbprefix($addInfoSessArray['tableName']));

		foreach ($fields as $field)
		{
			$addInfoSessArray['fieldKeys'][]=$field;
		} 
	
		$addInfoObject = new lib_additional_info($addInfoSessArray);
				
		$whereSessionArray = array('sessionId'=>$elementId);
		$orderSessionBy = array('position' => 'ASC');
		$addInfoData = $addInfoObject->listAdditionalInfo($whereSessionArray,$orderSessionBy,$limit=0);
		echo '<pre />';print_r($addInfoData);die;
		*/
		$sesTimeData['StartHour'] = 0;
		$sesTimeData['StartMin'] = 0;
		$sesTimeData['EndHour'] = 0;
		$sesTimeData['EndMin'] = 0;		
		$this->load->view('session_time_form',$sesTimeData);
	 
	}
	
/**
 @params $entityId : Id got from constants file for defined table eg.event showcase, film and video etc.,
 @params $elementId : Id for record for which we have to fetch all related news
**/
	public function listSesTime($entityId=0,$elementId=0,$returnUrl,$entityType,$launchEventEntity='',$launchEventId=0)
	{		
		
		$addInfoSessArray = array('tableName'=>'EventSessions');
		
		//capturing table Id from costant defined file using tableName		
		$fields = $this->db->list_fields($this->db->dbprefix($addInfoSessArray['tableName']));

		foreach ($fields as $field)
		{
			$addInfoSessArray['fieldKeys'][]=$field;
		} 
	
		$addInfoObject = new lib_additional_info($addInfoSessArray);
				
		if($launchEventEntity == '') $whereArray = array($entityType=>$elementId,'launchEventId'=>'0,null');
		
		if($launchEventEntity == '' && $elementId!=0) $whereArray = array($entityType=>$elementId);
		if($launchEventEntity != '' && $elementId==0) $whereArray = array($launchEventEntity=>$launchEventId);
		if($launchEventEntity != '' && $elementId!=0) {
			if($launchEventId == 0) $launchEventId = null;
			//$whereinField ='EventId,LaunchEventId';
			//$whereinValue =array($elementId,$launchEventId);
			
			$whereArray = array($entityType=>$elementId,$launchEventEntity=>$launchEventId);
			//echo '<pre />whereArray:';print_r($whereArray);
		}
	
		$orderSessionBy = array('position' => 'ASC');
		$addInfoData = $addInfoObject->listAdditionalInfo($whereArray,$orderSessionBy,$limit=0);
		//$table='', $field='*',  $where='',  $whereinField='', $whereinValue='', $orderBy='', $order='ASC', $whereNotIn=0
		//$addInfoData = getDataFromTabelWhereWhereIn($this->db->dbprefix($addInfoSessArray['tableName']),'*','',$whereinField, $whereinValue);
		$finalListing['sesTimes'] = $addInfoData;	
		$finalListing['label'] = $this->lang->language;
		$this->load->view('session_time_list',$finalListing);
		
	}
	
	public function addInfoSesTimePanel($entityId=0,$elementId=0,$returnUrl,$entityType,$launchEventEntity='',$launchEventId=0,$showDelOption=0,$sessionId=0,$natureId=0)
	{
	$presentSessionClass= $this->router->class;
	$presentSessionMethod= $this->router->method;
	$returnUrl = $presentSessionClass.'/'.$presentSessionMethod;
	
	if($launchEventEntity == '') $whereArray = array($entityType=>$elementId,'launchEventId'=>0);
	if($launchEventEntity != '' && $elementId!=0) $whereArray = array($entityType=>$elementId,$launchEventEntity=>$launchEventId);
	if($launchEventEntity == '' && $elementId!=0) $whereArray = array($entityType=>$elementId);
	if($launchEventEntity != '' && $elementId==0) $whereArray = array($launchEventEntity=>$launchEventId);
	if($entityId==9){
	$eventResult=$this->model_common->getDataFromTabel('Events','Type',array('NatureId >'=>1,'tdsUid'=>$this->userId));	
	$finalPanel['currentType']=$eventResult[0]->Type;
	$finalPanel['eventCountResult']=count($eventResult);
	$returnUrl = $returnUrl.'/eventsession/'.$elementId;
	}
	else{
	$eventResult=$this->model_common->getDataFromTabel('LaunchEvent','Type',array('tdsUid'=>$this->userId));
	$finalPanel['currentType']=$eventResult[0]->Type;
	$finalPanel['eventCountResult']=count($eventResult);
	$returnUrl = $returnUrl.'/launchsession/'.$launchEventId;
	}
	 
	//Count Total Session for Entity To hide the session form to avoid further insetion of record
	$totalSessions = countResult('EventSessions',$whereArray);
	$addInfoSessArray = array('tableName'=>'EventSessions');
		
		//capturing table Id from costant defined file using tableName		
		$fields = $this->db->list_fields($this->db->dbprefix($addInfoSessArray['tableName']));

		foreach ($fields as $field)
		{
			$addInfoSessArray['fieldKeys'][]=$field;
		} 
	
		$addInfoObject = new lib_additional_info($addInfoSessArray);
		if(@$sessionId ==0 && @$launchEventId<=0 && strcmp($sessionId,'addsession')!=0) 
			$whereSessionArray = array('sessionId'=>$sessionId);
		else{
			if($sessionId>0 || strcmp($sessionId,'addsession')==0)	{	
			if(strcmp($sessionId,'addsession')==0) $sessionId = -1;
			$whereSessionArray = array('sessionId'=>$sessionId);
			}
			else
			$whereSessionArray = $whereArray;
		}
		$orderSessionBy = array('position' => 'ASC');
		$addInfoData = $addInfoObject->listAdditionalInfo($whereSessionArray,$orderSessionBy,$limit=1);
	
		//echo $this->db->last_query();
		$addInfoData = object2array(@$addInfoData[0]);
		
		//Get the detail of session values
		$extraAttr = getSessionTimeAtt($addInfoData['sessionId']);
		
		if(is_array($extraAttr))
			$meregedEditAttr = array_merge($addInfoData,$extraAttr);
		else
			$meregedEditAttr = $addInfoData;
	
	$finalPanel['entityType'] = $entityType;
	$finalPanel['launchEventEntity'] = $launchEventEntity;
	$finalPanel['launchEventId'] = $launchEventId;
	$finalPanel['entityId'] = $entityId;
	$finalPanel['elementId'] = $elementId;
	$finalPanel['returnUrl'] = $returnUrl;	
	$finalPanel['showDelOption'] = 0;
	$finalPanel['totalSessions'] = $totalSessions;	
	$finalPanel['fillSessions'] = $meregedEditAttr;	
	$finalPanel['sessionId'] = $sessionId;	
	//$finalPanel['eventNatureId'] = $natureId;	
	

	$masTktArray = array('tableName'=>'MasterTicketCategories');
	
	//capturing table Id from costant defined file using tableName			
	$masTkflds = $this->db->list_fields($this->db->dbprefix($masTktArray['tableName']));

	foreach ($masTkflds as $field)
	{
		$masTktArray['fieldKeys'][]=$field;
	} 

	$masTktObject = new lib_additional_info($masTktArray) ;
	$whereArray = '';
	$orderBy = '';
	$masTktData = $masTktObject->listAdditionalInfo($whereArray,$orderBy,$limit=0,1);
	$finalPanel['masterTickets'] =	$masTktData;	
	if($finalPanel['eventCountResult']==1 && $totalSessions==0){
		$this->session->set_userdata('isShowEventPopup',1);
	 }
	//echo '<pre />';print_r($finalPanel);
	$this->load->view('add_info_ses_time_panel',$finalPanel);
	
	}
	
	public function saveAddInfoSession(){
		
		 $userId=$this->isLoginUser();
		 $seesionId=0;
		 $primaryKey = 'sessionId';
			
		 $addInfoArray = array('tableName'=>'EventSessions');//AddInfoNews,AddInfoReviews,AddInfoInterview
					
		 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

		 foreach ($fields as $field)
		 {
			$addInfoArray['fieldKeys'][]=$field;
		 } 
			
		 $addInfoObject = new lib_additional_info($addInfoArray) ;
		
		 $addInfoData['label'] = $this->lang->language;
		
		 $config = array();
			
			$config = array(
				array(
						 'field'   => 'title',
						 'label'   =>  $addInfoData['label']['title'],
						 'rules'   => 'trim|xss_clean'
				),
			);		
		
			$this->form_validation->set_rules($config); 
			$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
			if($this->form_validation->run())
			{	
			
			if(strcmp($this->input->post('submit'),'Save')==0)
			{			
			
				$sectionId = $this->input->post('sectionId');
				$primaryId = $this->input->post('primaryId');
				$startTime = $this->input->post('eventstartime');
				$endTime  = $this->input->post('eventendtime');
				$secs =0;
				
				$secon = $this->input->post('country');
				$eventSellstatus = $this->input->post('eventSellstatus');
			
				if(!isset($secon) || $secon=='') $session_country =0;			
				else  $session_country = $this->input->post('country');
				
				$selaunchEventId = $this->input->post('launchEventId');
				if(!isset($selaunchEventId) || $selaunchEventId==''|| $selaunchEventId==0){ $selaunchEventId = null;		}		
				
				$earlyBirdStatusPost = $this->input->post('earlyBirdStatus');
				if(strcmp(@$earlyBirdStatusPost,'accept')==0) $earlyBirdStatus='t';
				else $earlyBirdStatus='f';
				
					
			
				if(strcmp($eventSellstatus,'false')==0 || $eventSellstatus==null) $earlyBirdStatus = 'f';
				 
				 
				$valuesArray = array( 
				'sessionId'=>$this->input->post('sessionId'),
				'date'=>$this->input->post('date'),
				'venueName'=>$this->input->post('venueName'),
				'venueEmail'=>$this->input->post('venueEmail'),
				'phoneNumber'=>$this->input->post('phoneNumber'),
				'address'=>$this->input->post('address'),
				'address2'=>$this->input->post('address2'),
				'city'=>$this->input->post('city'),
				'state'=>$this->input->post('state'),
				'country'=>$session_country,
				'zip'=>$this->input->post('zip'),
				'url'=>$this->input->post('url'),
				'eventId'=>$this->input->post('eventId'),
				'launchEventId'=>$selaunchEventId,
				'eventSellstatus'=>(!isset($eventSellstatus) || $eventSellstatus=='')?null:$eventSellstatus,
				'earlyBirdStatus'=>$earlyBirdStatus,
				'sessionTitle'=>$this->input->post('sessionTitle')
				);		
				
				
				if((strcmp($endTime,'__:__')==0) || $endTime == '' ) $valuesArray['endTime'] ="00:00";
				else $valuesArray['endTime'] = $endTime;
				if(strcmp($startTime,'__:__')==0) $valuesArray['startTime'] ="00:00";
				else $valuesArray['startTime'] =$startTime;;

				if(!isset($primaryId) || $primaryId==0 || $primaryId=='')
				{
				  $valuesArray['sessionCreated'] = date("Y-m-d H:i:s"); 
				}
				else
				{
				  $valuesArray['sessionCreated'] = date("Y-m-d H:i:s"); 			  
				  $valuesArray['sessionModified'] = date("Y-m-d H:i:s"); 
				}
				$seesionId=$newSessionId = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey,0);
				$entityId = getMasterTableRecord('EventSessions');
				
				if($sectionId==9){
					$section='event';
					$projectId=(is_numeric($valuesArray['eventId']))?$valuesArray['eventId']:0;
					
				}elseif($sectionId==15){
					$section='launch';
					$projectId=(is_numeric($valuesArray['launchEventId']))?$valuesArray['launchEventId']:0;
				}else{
					$projectId=0;
					$section='';
				}
				
				$notificationFlag=false;
				if($valuesArray[$primaryKey] > 0){
					$notificationFlag=true;
					$type='2';
				}else{
					$type='1';
					
				}
				$userActivityData=$valuesArray;
				unset($userActivityData['sessionCreated']);
				
				$prvActivityData='';
				$userActivityData=str_replace("'","&apos;",json_encode($userActivityData));
				
				$whereCondition=array('entityId'=>$entityId,'elementId'=>$seesionId,'projId'=>$projectId);
				
				$activityResult=$this->model_common->getDataFromTabel($table='LogUserActivity', 'data', $whereCondition, '', $orderBy='', '', 1);
				
				if($activityResult){
					$prvActivityData=$activityResult[0]->data;
				}
				
				if($prvActivityData != $userActivityData){
					$userActivityInsert=array(
						'tdsUid'=>$this->userId,
						'entityId'=>$entityId,
						'elementId'=>$seesionId,
						'projId'=>$projectId,
						'sectionId'=>$sectionId,
						'type'=>$type,
						'data'=>$userActivityData
					);
					$this->model_common->addDataIntoTabel('LogUserActivity', $userActivityInsert);
					if($notificationFlag){
						$insertNotificationQueue=array(
							'entityId'=>$entityId,
							'elementId'=>$seesionId,
							'projectId'=>$projectId,
							'alert_type'=>$section,
							'projectType'=>'performancesevents',
							'ownerId'=>$this->userId,
							'notificationType'=>2
						);
						$this->model_common->addDataIntoTabel('NotificationQue', $insertNotificationQueue);
						$this->sendEventChangeEmail('EventSessions',$seesionId,$section);
					}
				}
			}
		 }
		 	
		 if(isset($eventSellstatus) && $eventSellstatus!=''){
			
			 //post for tickets used to create array to get inserted in table
			
			 $saveticketCheckBox = $this->input->post('ticketCheckBox');
			 $saveTicketsId = $this->input->post('ticketId');
			 $saveTickets = $this->input->post('ticket');
			 $saveTicketCatId = $this->input->post('ticketCatId');
			 $saveSpeTicketCatId = $this->input->post('speTicketCatId');
			 $savePrice = $this->input->post('price');
			 $configTicketCategoryKey = array_keys($this->config->item('ticketCategory'));
			 $configTicketCategory = $this->config->item('ticketCategory');
			 $savePriceScheduleId = $this->input->post('PriceScheduleId');
			 $speStartDate = $this->input->post('speStartDate');
			 $speStartPrice = $this->input->post('speStartPrice');
			 $speEndDate = $this->input->post('speEndDate');
			 $speEndPrice = $this->input->post('speEndPrice');
			
			 $presentSessionId = $this->input->post('sessionId');
			 $count = count($saveticketCheckBox);
			foreach ($configTicketCategoryKey as $key=>$i) 	
			{
			if($saveTicketsId[$i]>0)
			$TicketsId = $saveTicketsId[$i];
			else $TicketsId = 0;
			$searchInArray = $i;
			if(strcmp($eventSellstatus,'false')==0) $saveticketCheckBox[] = $configTicketCategoryKey[3];
			//If Category
			if(in_array($searchInArray,@$saveticketCheckBox)) $thisTicketCheckBox[$i] = 't';
			else $thisTicketCheckBox[$i]='f';
			if(strcmp($eventSellstatus,'false')==0)
			{
				if(strcmp($configTicketCategoryKey[3],$i)!=0){
					//echo $configTicketCategoryKey[3].':'.$i;
					$saveTickets[$i] = null;  
					$savePrice[$i]= null;
					$thisTicketCheckBox[$i]= 'f'; 	
					
					if((@$savePriceScheduleId[$i]>0)){
					$saveSpeStartTicketArray[$i] = array(
					'PriceScheduleId'=> $savePriceScheduleId[$i],
					'SessionId' => $newSessionId,
					'TicketCategoryId'=> $key+1,
					//'TicketId'=> $lastTicketId[$i],
					'StartDate' => null,
					'Price'=> null
					);
				}			
				}			
			}
			else
			{
				$saveTickets[$configTicketCategoryKey[3]]= null;
				$savePrice[$configTicketCategoryKey[3]]= null;
				$thisTicketCheckBox[$configTicketCategoryKey[3]]= 'f';
				$speStartDateCurr =($speStartDate[0]=='')?$this->input->post('date'):$speStartDate[0];
				$thisStartPrice=(@$speStartPrice[$i]!='')?@$speStartPrice[$i]:null;
				
				if((@$savePriceScheduleId[$i]>0) && (@$savePriceScheduleId[$i]!='') && (strcmp(@$earlyBirdStatus,'t')!=0)){
					$saveSpeStartTicketArray[$i] = array(
					'PriceScheduleId'=> $savePriceScheduleId[$i],
					'SessionId' => $newSessionId,
					'TicketCategoryId'=> $key+1,
					//'TicketId'=> $lastTicketId[$i],
					'StartDate' => null,
					'Price'=> null
					);
				}		
				
				if((strcmp(@$earlyBirdStatus,'t')==0)){
					$saveSpeStartTicketArray[$i] = array(
					'PriceScheduleId'=> $savePriceScheduleId[$i],
					'SessionId' => $newSessionId,
					'TicketCategoryId'=> $key+1,
					//'TicketId'=> $lastTicketId[$i],
					'StartDate' => $speStartDateCurr,
					'Price'=> $thisStartPrice
					);
				}
			}
			
			$saveTicketArray[$i]=array('TicketId' =>@$TicketsId,'SessionId' =>$newSessionId,'TicketCategoryId'=>$key+1,'Quantity' => @$saveTickets[$i],'Price'=>@$savePrice[$i],'EventId'=>$this->input->post('eventId'),'LaunchEventId'=>$selaunchEventId,$i=>@$thisTicketCheckBox[$i]);
			$lastTicketId[$i] = $this->model_common->saveAdditionalInfo('Tickets',$saveTicketArray[$i],'TicketId',1);
				
				if(is_array(@$saveSpeStartTicketArray[$i])){
					 $saveSpeStartTicketArray[$i] = array_merge($saveSpeStartTicketArray[$i],array('TicketId'=>$lastTicketId[$i]));
					 $lastSpeTicketId = $this->model_common->saveAdditionalInfo('TicketPriceSchedule',$saveSpeStartTicketArray[$i],'PriceScheduleId',1);
				}	
			}
			$this->counsumptiontaxSettings($seesionId);
		}
		$msgsessionSaved = $this->lang->line('sessionSaved');
		set_global_messages($msgsessionSaved, 'success');
		$returnUrl = $this->input->post('returnUrl');
		redirect(base_url($returnUrl.'/'.$seesionId));
	}
	
	public function sendEventChangeEmail($tbl='',$id=0, $section='') {
		$userId=$this->isLoginUser();
		$isTableFound=true;
		$joinWithSessionTable=false;
		
		switch($tbl){
			case 'Events':
				$selectedField='Events.StartDate,Events.FinishDate,Events.EventId as "eventId", Events.Title as "title"';
				$where=array('Events.EventId'=>$id);
				$like='"entityIdPE":"9"';
				$showcase_url='/eventfrontend/event/'.$userId.'/'.$id;
			break;
			
			case 'LaunchEvent':
				$selectedField='LaunchEvent.LaunchEventId as "launchEventId",LaunchEvent.LaunchDate as "StartDate",EventSessions.date as "FinishDate", LaunchEvent.Title as "title"';
				$joinWithSessionTable=true;
				$where=array('LaunchEvent.LaunchEventId'=>$id);
				$like='"entityIdPE":"15"';
				$showcase_url='/eventfrontend/eventlaunch/'.$userId.'/'.$id;
			break;
			
			case 'EventSessions':
			
				$selectedField='EventSessions.date as "FinishDate",EventSessions.eventId,EventSessions.launchEventId,EventSessions.sessionId, EventSessions.sessionTitle as "title"';
				$where=array('EventSessions.sessionId'=>$id);
			break;
			
			default:
				$isTableFound=false;
			break;
		}
		
		if($isTableFound){
			$res= $this->model_common->getEventLaunchSession($tbl, $selectedField, $where, $joinWithSessionTable);
			if($res){
				
				$res=$res[0];
				$projectTitle=$res->title;
				if(isset($res->StartDate)){
					$startDate=$res->StartDate;
				}else{
					$startDate=$res->FinishDate;
				}
				$startDate=strtotime($startDate);
				$FinishDate=$res->FinishDate;
				
				$FinishDate=strtotime($FinishDate);
				$currentDate=date('Y-m-d');
				$currentDate=strtotime($currentDate);
				
				if(($startDate > $currentDate) || ($FinishDate > $currentDate)){
					$like2=false;
					$projId=$id;
					if($tbl=='EventSessions'){
						if($section=='event'){
							$like='"entityIdPE":"9"';
							$showcase_url='/eventfrontend/sessionTickets/'.$userId.'/'.$res->eventId.'/event';
						}else{
							$like='"entityIdPE":"15"';
							$showcase_url='/eventfrontend/sessionTickets/'.$userId.'/'.$res->launchEventId.'/launch';
						}
						$like2='"SessionId":"'.$id.'"';
						$projId=0;
					}
					
					$userDetails= $this->model_common->getTicketPurchaseUser($projId, $like, $like2);
					/* get delete email template*/
					$where=array('purpose'=>'launchdatechange','active'=>1);
					$templateRes=getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
					
					$start_at = date('d F Y', $startDate);
					$end_at = date('d F Y', $FinishDate);
					
					$site_url = site_url('');
					
					if($_SERVER["SERVER_NAME"]=='localhost'){
						$site_base_url = site_base_url();
					}else{
						$site_base_url = site_url('');
					}
					
					$image_base_url = site_base_url().'images/email_images/';
					$crave_url = $this->config->item('crave_url');
					$facebook_url = $this->config->item('facebook_follow_url');
					$linkedin_url = $this->config->item('linkedin_follow_url');
					$showcase_url=base_url(lang().$showcase_url);
					
					if($userDetails){
						foreach($userDetails as $user){
							$sellerInfo=json_decode($user->sellerInfo);
							$ownerId=$user->sellerId;
							$ownerName=$sellerInfo->firstName.' '.$sellerInfo->lastName;
							$ownerEmail=$sellerInfo->email;
							
							$receiverId=$user->tdsUid;
							$receiverEmail=$user->email;
							$receiverName=$user->firstName.' '.$user->lastName;
							
							/* Set Event Email Body and Subject for Email*/
							if($templateRes) {
								$reportTemplate=$templateRes[0]->templates;
								/* owner showcase url */
								$owner_showcase = base_url(lang().'/showcase/aboutme/'.$ownerId);
								$searchArray = array("{launch_name}","{start_at}","{end_at}" , "{site_url}" , "{site_base_url}", "{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{showcase_url}");
								$replaceArray = array($projectTitle, $start_at,    $end_at,     $site_url,     $site_base_url,     $image_base_url,  $crave_url,  $facebook_url,   $linkedin_url, $showcase_url);
								$deleteTemplateBody=str_replace($searchArray, $replaceArray, $reportTemplate);
								$deleteTemplateSubject=$templateRes[0]->subject;
								
								$from_email = $this->config->item('webmaster_email', '');
								$this->email->from($from_email, $this->config->item('website_name', ''));
								$this->email->to($receiverEmail);
								$this->email->subject(sprintf($deleteTemplateSubject));
								$this->email->message($deleteTemplateBody);
								$flag = $this->email->send();
							}
						}
					}
				
				}
			}
		}
	
	}
	
	public function counsumptiontaxSettings($seesionId=0) {
		$userId=$this->userId;
		$counsumptiontaxDone=false;                     
		if($userId > 0){
			$entityId=$this->input->post('entityId');
			$elementId=$seesionId;
			$projectId=$this->input->post('projectId');
			$taxSettings=$this->input->post('taxSettings');
			$taxPercentage=$this->input->post('taxPercentage');
			
			if($entityId > 0 && $elementId >0){
				$updateData=array(
					'userId'=>$userId,
					'entityId'=>$entityId,
					'elementId'=>$elementId,
					'projectId'=>$projectId,
					'taxSettings'=>$taxSettings,
					'taxPercentage'=>$taxPercentage,
					'dateLastModify'=>currntDateTime()
				);
				$where=array(
					'userId'=>$userId,
					'entityId'=>$entityId,
					'elementId'=>$elementId
				);
				$res=$this->model_common->getDataFromTabel('ConsumptionTaxSettings', 'id',  $where, '', '', '', 1 );
				if($res){
					$res=$res[0];
					$id=$res->id;
					$this->model_common->editDataFromTabel('ConsumptionTaxSettings', $updateData, 'id', $id);
				}else{
					$this->model_common->addDataIntoTabel('ConsumptionTaxSettings', $updateData);
				}
				$counsumptiontaxDone=true;
				$msg=$this->lang->line('ratedSuccessfully');
			}
		}
	}
	
	function shiftSessionTime(){
	
	 //redirect($returnUrl);
	 $primaryKey = 'sessionId';
	 $addInfoArray = array('tableName'=>'EventSessions');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray);
	
	
	 $addInfoFormData['label'] = $this->lang->language;
	//To delete the selected record
		if($this->input->post('sessionIdForDelete'))
		{
			$IdForDelete = decode($this->input->post('sessionIdForDelete'));
			
			//First we have to delete the realted recirds in table TicketPriceSchedule & Tickets
			
			$whereTicktes = 'where "SessionId"='.$IdForDelete;		
			$delTicketsArray = getDataFromTabel($this->db->dbprefix('Tickets'),'TicketId','SessionId',$IdForDelete);		
			$whereInTicketId = '';
			
			foreach($delTicketsArray as $key => $ticketIdObj)
			{
				$whereInTicketId .= $ticketIdObj->TicketId.',';			
			}
			$whereInTicketId = substr($whereInTicketId,0,-1);
			
			if(isset($whereInTicketId) && $whereInTicketId != '')
			{
				$whereTicktePS = 'where "TicketId" in ('.$whereInTicketId.')';
				$this->model_common->deleteDataFromTabel($this->db->dbprefix('TicketPriceSchedule'), $whereTicktePS);
			}
			
			$this->model_common->deleteDataFromTabel($this->db->dbprefix('Tickets'), $whereTicktes);			
			$addInfoFormData = $addInfoObject->delAdditionalInfo($primaryKey,$IdForDelete);			
		}
		
		if($this->input->post('sessionIdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
						
			$getPostion = $addInfoObject->shiftCellAdditionalInfo($primaryKey,$currentId,$currentPos,$swapId,$swapPos);
		}	
	 $returnUrl = $this->input->post('returnUrl');
	 redirect($returnUrl);	
	}
	
	public function saveAddInfoNews(){
	 $primaryKey = 'newsId';
	 $addInfoArray = array('tableName'=>'AddInfoNews');//AddInfoNews,AddInfoReviews,AddInfoInterview
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));
	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoData['label'] = $this->lang->language;
	
	 $config = array();
		
		$config = array(
			array(
					 'field'   => 'title',
					 'label'   =>  $addInfoData['label']['title'],
					 'rules'   => 'trim|xss_clean'
			),
		);
			
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{	
		
		if(strcmp($this->input->post('submit'),'Save')==0)
		{			
			$primaryId = $this->input->post('newsId');
			
			$newsEmbed=trim($this->input->post('newsEmbbededVideo'));
			if(strstr($newsEmbed,'+')){
				$newsEmbed=urldecode($newsEmbed); 
			}
			
			$publishDate=$this->input->post('publishDate');
			if(empty($publishDate)){
				$publishDate=date('Y-m-d h:i:s');
			}
			
			$newsUrlType=$this->input->post('newsUrlType');
			if($newsUrlType==1){
				$associatedNewsElementId=$this->input->post('associatedNewsElementId')>0?$this->input->post('associatedNewsElementId'):0;
			}else{
				$associatedNewsElementId=0;
			}
			
			$valuesArray = array(
			'newsId'=>$this->input->post('newsId'),
			'tdsUid'=>$this->userId,
			'newsTitle'=>$this->input->post('title'),
			'newsWriter'=>$this->input->post('writerName'),
			'newsPublishDate'=>$publishDate,
			'newsLanguage'=>$this->input->post('newsLanguage')>0?$this->input->post('newsLanguage'):1,
			'newsDescription'=>$this->input->post('newsDescription'),
			'newsEmbed'=>$newsEmbed,
			'newsExternalUrl'=>$this->input->post('externalUrl'),
			'newsUrlType'=>($newsUrlType>0)?$newsUrlType:0,
			'entityId'=>$this->input->post('entityId'),
			'elementId'=>$this->input->post('elementId'),
			'projId'=>$this->input->post('projId'),
			'associatedNewsElementId'=>$associatedNewsElementId
			);
			
			$addInfoFlag=true;
			if(!isset($primaryId) || $primaryId==0 || $primaryId=='')
			{
			  $valuesArray['newsCreatedDate'] = date("Y-m-d H:i:s"); 
			  $valuesArray['newsModifiedDate'] = date("Y-m-d H:i:s");
			  
			  $whereCase =array('entityId'=>$this->input->post('entityId'),'elementId'=>$this->input->post('elementId'));
			  $countRes=$this->model_common->countResult($table='AddInfoNews',$whereCase);
			  $addInfoLimitation=$this->config->item('addInfoLimitation');
			  if($countRes >= $addInfoLimitation){
				  $addInfoFlag=false;
			  }
			}
			else
			{
			  $valuesArray['newsModifiedDate'] = date("Y-m-d H:i:s"); 
			}
			
			if(!$addInfoFlag){
				$msg=$this->lang->line('addInfoLimitation');
				set_global_messages($msg, $type='error', $is_multiple=true);
			}else{
				$addInfoData = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey,1);
				$msg=$this->lang->line('msgNewsSave');
				set_global_messages($msg, $type='success', $is_multiple=true);
			}
		}
	 }
	 
	 $returnUrl = $this->input->post('returnUrl');
	 $returnUrl = str_replace('/news','',$returnUrl);
	 $returnUrl = str_replace('/reviews','',$returnUrl);
	 $returnUrl = str_replace('/interviews','',$returnUrl);
	  $returnUrl = $returnUrl.'/news';
	 redirect($returnUrl);
	}
	
	public function saveAddInfoReviews()
	{
		
	 $primaryKey = 'reviewId';
		
	 $addInfoArray = array('tableName'=>'AddInfoReviews');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoData['label'] = $this->lang->language;
	
	 $config = array();
		
		$config = array(
			array(
					 'field'   => 'title',
					 'label'   =>  $addInfoData['label']['title'],
					 'rules'   => 'trim|xss_clean'
			),
		);
		
	
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{	
		
		if(strcmp($this->input->post('submit'),'Save')==0)
		{			
			$primaryId = $this->input->post('reviewId');
			
			$reviewEmbed=trim($this->input->post('reviewsEmbbededVideo'));
			if(strstr($reviewEmbed,'+')){
				$reviewEmbed=urldecode($reviewEmbed); 
			}
			
			$publishDate=$this->input->post('publishDate');
			if(empty($publishDate)){
				$publishDate=date('Y-m-d h:i:s');
			}
			
			
			$valuesArray = array(
				'reviewId'=>$this->input->post('reviewId'),
				'tdsUid'=>$this->userId,
				'reviewTitle'=>$this->input->post('title'),
				'reviewWriter'=>$this->input->post('writerName'),
				'reviewPublishDate'=>$publishDate,
				'reviewLanguage'=>$this->input->post('reviewLanguage')>0?$this->input->post('reviewLanguage'):1,
				'reviewDescription'=>$this->input->post('reviewDescription'),
				'reviewEmbed'=>$reviewEmbed,
				'reviewExternalUrl'=>$this->input->post('externalUrl'),
				'reviewUrlType'=>$this->input->post('reviewUrlType'),
				'entityId'=>$this->input->post('entityId'),
				'elementId'=>$this->input->post('elementId')
			);
			 $addInfoFlag=true;
			if(!isset($primaryId) || $primaryId==0 || $primaryId=='')
			{
			  $valuesArray['reviewModifiedDate'] = date("Y-m-d H:i:s");
			 
			  $whereCase =array('entityId'=>$this->input->post('entityId'),'elementId'=>$this->input->post('elementId'));
			  $countRes=$this->model_common->countResult($table='AddInfoReviews',$whereCase);
			  $addInfoLimitation=$this->config->item('addInfoLimitation');
			  if($countRes >= $addInfoLimitation){
				  $addInfoFlag=false;
			  } 
			}
			else
			{
			  $valuesArray['reviewCreatedDate'] = date("Y-m-d H:i:s"); 
			  $valuesArray['reviewModifiedDate'] = date("Y-m-d H:i:s"); 
			}
			if(!$addInfoFlag){
				$msg=$this->lang->line('addInfoLimitation');
				set_global_messages($msg, $type='error', $is_multiple=true);
			}else{
				$addInfoData = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey);
				$msg=$this->lang->line('msgReviewSave');
				set_global_messages($msg, $type='success', $is_multiple=true);
			}
		}
	 }	
	 $returnUrl = $this->input->post('returnUrl');
	 $returnUrl = str_replace('/news','',$returnUrl);
	 $returnUrl = str_replace('/reviews','',$returnUrl);
	 $returnUrl = str_replace('/interviews','',$returnUrl);
	 $returnUrl = $returnUrl.'/reviews';
	 redirect($returnUrl);
	}
	
	public function saveAddInfoInterviews()
	{
		
	 $primaryKey = 'intervId';
		
	 $addInfoArray = array('tableName'=>'AddInfoInterview');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
	
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoData['label'] = $this->lang->language;
	
	 $config = array();
		
		$config = array(
			array(
					 'field'   => 'title',
					 'label'   =>  $addInfoData['label']['title'],
					 'rules'   => 'trim|xss_clean'
			),
		);
		
	
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{	
		
		if(strcmp($this->input->post('submit'),'Save')==0)
		{			
			$primaryId = $this->input->post('intervId');
			$intervEmbed=trim($this->input->post('interviewEmbbededVideo'));
			if(strstr($intervEmbed,'+')){
				$intervEmbed=urldecode($intervEmbed); 
			}
			$publishDate=$this->input->post('publishDate');
			if(empty($publishDate)){
				$publishDate=date('Y-m-d h:i:s');
			}
			$valuesArray = array(
				'intervId'=>$this->input->post('intervId'),
				'tdsUid'=>$this->userId,
				'intervTitle'=>$this->input->post('title'),
				'intervWriter'=>$this->input->post('writerName'),
				'intervPublishDate'=>$publishDate,
				'intervLanguage'=>$this->input->post('intervLanguage')>0?$this->input->post('intervLanguage'):1,
				'intervDescription'=>$this->input->post('intervDescription'),
				'intervEmbed'=>$intervEmbed,
				'intervExternalUrl'=>$this->input->post('externalUrl'),
				'intervUrlType'=>$this->input->post('intervUrlType'),
				'entityId'=>$this->input->post('entityId'),
				'elementId'=>$this->input->post('elementId')
			);
			 $addInfoFlag=true;
			if(!isset($primaryId) || $primaryId==0 || $primaryId=='')
			{
			  $valuesArray['intervModifiedDate'] = date("Y-m-d H:i:s");
			  $whereCase =array('entityId'=>$this->input->post('entityId'),'elementId'=>$this->input->post('elementId'));
			  $countRes=$this->model_common->countResult($table='AddInfoInterview',$whereCase);
			  $addInfoLimitation=$this->config->item('addInfoLimitation');
			  if($countRes >= $addInfoLimitation){
				  $addInfoFlag=false;
			  }  
			}
			else
			{
			  $valuesArray['intervCreatedDate'] = date("Y-m-d H:i:s"); 
			  $valuesArray['intervModifiedDate'] = date("Y-m-d H:i:s"); 
			}
			if(!$addInfoFlag){
				$msg=$this->lang->line('addInfoLimitation');
				set_global_messages($msg, $type='error', $is_multiple=true);
			}else{
				$addInfoData = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey);
				$msg=$this->lang->line('msgInterviewSave');
				set_global_messages($msg, $type='success', $is_multiple=true);
			}
		}
	 }	
	 $returnUrl = $this->input->post('returnUrl');
	 $returnUrl = str_replace('/news','',$returnUrl);
	 $returnUrl = str_replace('/reviews','',$returnUrl);
	 $returnUrl = str_replace('/interviews','',$returnUrl);
	 $returnUrl = $returnUrl.'/interviews';
	 redirect($returnUrl);
	}
	
	
	function shiftNews(){
	
	 //redirect($returnUrl);
	 $primaryKey = 'newsId';
	 $addInfoArray = array('tableName'=>'AddInfoNews');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoFormData['label'] = $this->lang->language;
	//To delete the selected record
		if($this->input->post('newsIdForDelete'))
		{
			$newsIdForDelete = decode($this->input->post('newsIdForDelete'));
			$addInfoFormData = $addInfoObject->delAdditionalInfo($primaryKey,$newsIdForDelete);			
		}
		
		if($this->input->post('newsIdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
						
			$getPostion = $addInfoObject->shiftCellAdditionalInfo($primaryKey,$currentId,$currentPos,$swapId,$swapPos);
		}	
	 $returnUrl = $this->input->post('returnUrl');
	 redirect($returnUrl);	
	}
	
	
	function shiftReviews(){
	
	 $primaryKey = 'reviewId';
		
	 $addInfoArray = array('tableName'=>'AddInfoReviews');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoFormData['label'] = $this->lang->language;
		if($this->input->post('IdForDelete'))
		{
			$newsIdForDelete = decode($this->input->post('IdForDelete'));
			$addInfoFormData = $addInfoObject->delAdditionalInfo($primaryKey,$newsIdForDelete);			
		}
		
		if($this->input->post('IdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			//echo $currentId.''.$currentPos.''.$swapId.''.$swapPos;die;
			$getPostion = $addInfoObject->shiftCellAdditionalInfo($primaryKey,$currentId,$currentPos,$swapId,$swapPos);
		}	
		$returnUrl = $this->input->post('returnUrl');
	 redirect($returnUrl);		
	}
	
	function shiftInterviews(){
	
	 $primaryKey = 'intervId';
		
	 $addInfoArray = array('tableName'=>'AddInfoInterview');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoFormData['label'] = $this->lang->language;
	//To delete the selected record
		if($this->input->post('IdForDelete'))
		{
			$newsIdForDelete = decode($this->input->post('IdForDelete'));
			$addInfoFormData = $addInfoObject->delAdditionalInfo($primaryKey,$newsIdForDelete);			
		}
		
		if($this->input->post('IdForSwap') ==1)
		{
			$currentId =  decode($this->input->post('currentId'));
			$currentPos =  $this->input->post('currentPosition');
			$swapId =  decode($this->input->post('swapId'));
			$swapPos =  $this->input->post('swapPosition');
			//echo $currentId.''.$currentPos.''.$swapId.''.$swapPos;die;
			$getPostion = $addInfoObject->shiftCellAdditionalInfo($primaryKey,$currentId,$currentPos,$swapId,$swapPos);
		}	
	 $returnUrl = $this->input->post('returnUrl');
	 redirect($returnUrl);		
	}
	/**
		* Loads Associated Media form (Entry) on page
	**/
	function associatedMediaForm()
	{

		$associatedMediaFormData['label'] = $this->lang->language;
		$this->load->view('associated_media_form',$associatedMediaFormData);
	}

/**
	@params $entityId : Id got from constants file for defined table eg.event showcase, film and video etc.,
	@params $elementId : Id for record for which we have to fetch all related news
**/
	public function listSectionNews($data=array())
	{
		$newsArray = array('tableName'=>'AddInfoNews');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
		$fields = $this->db->list_fields($this->db->dbprefix($newsArray['tableName']));

		foreach ($fields as $field)
		{
			$newsArray['fieldKeys'][]=$field;
		} 
	
		$newsObject = new lib_additional_info($newsArray) ;
		$whereArray = array('AddInfoNews.entityId' => $data['entityId'],'AddInfoNews.elementId'=>$data['elementId']);
		$orderBy = array('position' => 'ASC');
		$newsData = $newsObject->listAdditionalInfo($whereArray,$orderBy,$limit=0);
		
		
		$finalNewsData['news'] = $newsData;	
		$finalNewsData['label'] = $this->lang->language;
		$finalNewsData['ownerId'] = $data['ownerId'];	
		$finalNewsData['userId'] = isLoginUser();
		//echo '<pre />';print_r($finalNewsData);
		$this->load->view('news_list',$finalNewsData);
		
	}
	
	public function addInfoAssociatedMediaPanel($entityId=0,$elementId=0,$returnUrl='')
	{
		$finalPanel['entityId'] = $entityId;
		$finalPanel['elementId'] = $elementId;
		$finalPanel['returnUrl'] = $returnUrl;	
		$this->load->view('add_info_associated_media_panel',$finalPanel);
	}
	
	
	function associatedMediasList()
	{
		$this->load->view('associated_media_list');
	}	
	
	public function prmaterial($data=array())
	{
        if(isset($data['table']) && !empty($data['table'])){
            $orderBy = '';
            $joinTable = '';
            $joinOn = '';
            $data['sectionId'] = '';
            $data['actionUrl'] = '';
            $data['listingPage'] = '';
            if($data['table'] == 'AddInfoNews'){
               $orderBy = 'newsModifiedDate'; 
               $joinTable = 'NewsElement';
               $joinOn = 'associatedNewsElementId';
               $data['sectionId'] = 'news';
               $data['actionUrl'] = base_url(lang().DIRECTORY_SEPARATOR.'additionalInfo'.DIRECTORY_SEPARATOR.'savePRnews');
               $data['listingPage'] = 'additionalInfo/pr_news_listing';
            }elseif($data['table'] == 'AddInfoReviews'){
               $orderBy = 'reviewModifiedDate'; 
               $joinTable = 'ReviewsElement';
               $joinOn = 'associatedReviewsElementId';
               $data['sectionId'] = 'reviews';
               $data['actionUrl'] = base_url(lang().DIRECTORY_SEPARATOR.'additionalInfo'.DIRECTORY_SEPARATOR.'savePRreviews');
               $data['listingPage'] = 'additionalInfo/pr_reviews_listing'; 
            }elseif($data['table'] == 'AddInfoInterview'){
               $orderBy = 'intervModifiedDate';
               $data['sectionId'] = 'interviews';
               $data['actionUrl'] = base_url(lang().DIRECTORY_SEPARATOR.'additionalInfo'.DIRECTORY_SEPARATOR.'savePRinterviews');
               $data['listingPage'] = 'additionalInfo/pr_interviews_listing';  
            }
            
            $whereCondition = array($data['table'].'.entityId'=>$data['entityId'],$data['table'].'.elementId'=>$data['elementId'],$data['table'].'.tdsUid'=>$data['tdsUid']);
            $data['prData']=$this->model_common->getPRmaterial($data['table'], $whereCondition, $orderBy,$joinTable,$joinOn);
            
            $this->load->view($data['PRview'],$data);
        }
    }
    
    public function savePRnews()
	{
        $error = 1 ;
        $PRid = 0 ;
        $msg = $this->lang->line('postDataError');
        $post = $this->input->post();
		if(isset($post['entityId']) && ((int)$post['entityId'] > 0) && isset($post['elementId']) && ((int)$post['elementId'] > 0) ){
            
            $urlType=$post['urlType'];
            $urlType= ((int)$urlType == 1) ? 1:2;
            $saveData = array(
                'tdsUid'=>$this->userId,
                'newsUrlType'=>($urlType>0)?$urlType:0,
                'entityId'=>$post['entityId'],
                'elementId'=>$post['elementId'],
                'projId'=>$post['projId'],
                'newsModifiedDate'=>date("Y-m-d H:i:s")
            );
            
            if($urlType==1){
                $associatedElementId=$post['associatedElementId']>0?$post['associatedElementId']:0;
                $saveData['associatedNewsElementId'] = $associatedElementId;
            }else{
                $saveData['newsTitle'] = $post['title'];
                $saveData['newsExternalUrl'] = $post['externalUrl'];
                $saveData['associatedNewsElementId'] = 0;
            }
            
            $PRid = $post['PRid'];
            $mode = 'add';
            if(isset($PRid) && ((int)$PRid > 0))
            {
                $whereCase =array('newsId'=>$PRid);
                $countRes=$this->model_common->countResult('AddInfoNews',$whereCase);
                if((int)$countRes > 0){
                    $mode = 'edit';
                }
            }
            
           
            if($mode == 'edit'){
                $this->model_common->editDataFromTabel('AddInfoNews', $saveData, 'newsId', $PRid);
                $msg=$this->lang->line('msgNewsUpdate');
                 $error = 0;
            }else{
                $whereCase =array('entityId'=>$post['entityId'],'elementId'=>$post['elementId']);
                $countRes=$this->model_common->countResult('AddInfoNews',$whereCase);
                $addInfoLimitation=$this->config->item('addInfoLimitation');
                if($countRes >= $addInfoLimitation){
                    $msg=$this->lang->line('addInfoLimitation');
                }else{
                    $PRid = $this->model_common->addDataIntoTabel('AddInfoNews', $saveData);
                    $msg=$this->lang->line('msgNewsSave');
                    $error = 0;
                }
            }
            $data = array('PRid'=>$PRid,'msg'=>$msg,'error'=>$error,'table'=>'AddInfoNews','tdsUid'=>$this->userId,'entityId'=>$post['entityId'],'elementId'=>$post['elementId'],'projId'=>$post['projId'],'PRview'=>'additionalInfo/pr_news_listing');
            $this->prmaterial($data);    
		}
    }
    
    public function savePRreviews()
	{
        $error = 1 ;
        $PRid = 0 ;
        $msg = $this->lang->line('postDataError');
        $post = $this->input->post();
		if(isset($post['entityId']) && ((int)$post['entityId'] > 0) && isset($post['elementId']) && ((int)$post['elementId'] > 0) ){
            
            $urlType=$post['urlType'];
            $urlType= ((int)$urlType == 1) ? 1:2;
            $saveData = array(
                'tdsUid'=>$this->userId,
                'reviewUrlType'=>($urlType>0)?$urlType:0,
                'entityId'=>$post['entityId'],
                'elementId'=>$post['elementId'],
                'projId'=>$post['projId'],
                'reviewModifiedDate'=>date("Y-m-d H:i:s")
            );
            
            if($urlType==1){
                $associatedElementId=$post['associatedElementId']>0?$post['associatedElementId']:0;
                $saveData['associatedReviewsElementId'] = $associatedElementId;
            }else{
                $saveData['reviewTitle'] = $post['title'];
                $saveData['reviewExternalUrl'] = $post['externalUrl'];
                $saveData['associatedReviewsElementId'] = 0;
            }
            
            $PRid = $post['PRid'];
            $mode = 'add';
            if(isset($PRid) && ((int)$PRid > 0))
            {
                $whereCase =array('reviewId'=>$PRid);
                $countRes=$this->model_common->countResult('AddInfoReviews',$whereCase);
                if((int)$countRes > 0){
                    $mode = 'edit';
                }
            }
            
           
            if($mode == 'edit'){
                $this->model_common->editDataFromTabel('AddInfoReviews', $saveData, 'reviewId', $PRid);
                $msg=$this->lang->line('msgReviewUpdated');
                 $error = 0;
            }else{
                $whereCase =array('entityId'=>$post['entityId'],'elementId'=>$post['elementId']);
                $countRes=$this->model_common->countResult('AddInfoReviews',$whereCase);
                $addInfoLimitation=$this->config->item('addInfoLimitation');
                if($countRes >= $addInfoLimitation){
                    $msg=$this->lang->line('addInfoLimitation');
                }else{
                    $PRid = $this->model_common->addDataIntoTabel('AddInfoReviews', $saveData);
                    $msg=$this->lang->line('msgReviewSave');
                    $error = 0;
                }
            }
            $data = array('PRid'=>$PRid,'msg'=>$msg,'error'=>$error,'table'=>'AddInfoReviews','tdsUid'=>$this->userId,'entityId'=>$post['entityId'],'elementId'=>$post['elementId'],'projId'=>$post['projId'],'PRview'=>'additionalInfo/pr_reviews_listing');
            $this->prmaterial($data);    
		}
    }
    
    public function savePRinterviews()
	{
        $error = 1 ;
        $PRid = 0 ;
        $msg = $this->lang->line('postDataError');
        $post = $this->input->post();
		if(isset($post['entityId']) && ((int)$post['entityId'] > 0) && isset($post['elementId']) && ((int)$post['elementId'] > 0) ){
            
            $urlType=$post['urlType'];
            $urlType= ((int)$urlType == 1) ? 1:2;
            $saveData = array(
                'tdsUid'=>$this->userId,
                'intervTitle'=> $post['title'],
                'intervExternalUrl'=> $post['externalUrl'],
                'intervUrlType'=>($urlType>0)?$urlType:0,
                'entityId'=>$post['entityId'],
                'elementId'=>$post['elementId'],
                'projId'=>$post['projId'],
                'intervModifiedDate'=>date("Y-m-d H:i:s")
            );
            
            $PRid = $post['PRid'];
            $mode = 'add';
            if(isset($PRid) && ((int)$PRid > 0))
            {
                $whereCase =array('intervId'=>$PRid);
                $countRes=$this->model_common->countResult('AddInfoInterview',$whereCase);
                if((int)$countRes > 0){
                    $mode = 'edit';
                }
            }
            
           
            if($mode == 'edit'){
                $this->model_common->editDataFromTabel('AddInfoInterview', $saveData, 'intervId', $PRid);
                $msg=$this->lang->line('msgInterviewUpdate');
                 $error = 0;
            }else{
                $whereCase =array('entityId'=>$post['entityId'],'elementId'=>$post['elementId']);
                $countRes=$this->model_common->countResult('AddInfoInterview',$whereCase);
                $addInfoLimitation=$this->config->item('addInfoLimitation');
                if($countRes >= $addInfoLimitation){
                    $msg=$this->lang->line('addInfoLimitation');
                }else{
                    $PRid = $this->model_common->addDataIntoTabel('AddInfoInterview', $saveData);
                    $msg=$this->lang->line('msgInterviewSave');
                    $error = 0;
                }
            }
            $data = array('PRid'=>$PRid,'msg'=>$msg,'error'=>$error,'table'=>'AddInfoInterview','tdsUid'=>$this->userId,'entityId'=>$post['entityId'],'elementId'=>$post['elementId'],'projId'=>$post['projId'],'PRview'=>'additionalInfo/pr_interviews_listing');
            $this->prmaterial($data);    
		}
    }
    
    /* no further use, commented by sushil : 03-02-2014
	
    public function addInfoNewsPanel($entityId=0,$elementId=0,$returnUrl='',$otherData=array())
    {
        $this->userId= $this->isLoginUser();
        
        $ownerId=isset($otherData['ownerId'])?$otherData['ownerId']:$this->userId;
        
        $finalPanel['entityId'] = $entityId;
        $finalPanel['elementId'] = $elementId;
        $finalPanel['returnUrl'] = $returnUrl;	
        $finalPanel['ownerId'] = $ownerId;	
        $finalPanel['userId'] = $this->userId;	
        
        $this->load->view('add_info_news_panel',$finalPanel);
    } */
	
	/**
	@params $entityId : Id got from constants file for defined table eg.event showcase, film and video etc.,
	@params $elementId : Id for record for which we have to fetch all related news
**/
	public function listSectionReviews($data=array())
	{
		$reviewsArray = array('tableName'=>'AddInfoReviews');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
		$fields = $this->db->list_fields($this->db->dbprefix($reviewsArray['tableName']));

		foreach ($fields as $field)
		{
			$reviewsArray['fieldKeys'][]=$field;
		} 
		
		$reviewsObject = new lib_additional_info($reviewsArray) ;
				
		$whereArray = array('entityId' => $data['entityId'],'elementId'=>$data['elementId']);
		
		$orderBy = array('position' => 'asc');
		$reviewsData = $reviewsObject->listAdditionalInfo($whereArray,$orderBy='',$limit=0);
		
		$finalReviewsData['reviews'] = $reviewsData;	
		
		$finalReviewsData['label'] = $this->lang->language;
		$this->load->view('reviews_list',$finalReviewsData);
		
	}
	
	/* no further use, commented by sushil : 03-02-2014
	public function addInfoReviewsPanel($entityId=0,$elementId=0, $returnUrl='')
	{
		$finalPanel['entityId'] = $entityId;
		$finalPanel['elementId'] = $elementId;
		$finalPanel['returnUrl'] = $returnUrl;
		//$finalPanel['label'] = $this->lang->language;
		if(strcmp($this->router->class,'showcase') ==0)
		$finalPanel['reviewDisplayStyle'] = '';
		else
		$finalPanel['reviewDisplayStyle'] = 'dn';
		
		$this->load->view('add_info_reviews_panel',$finalPanel);
	} */
	
	
	/**
	 @params $entityId : Id got from constants file for defined table eg.event showcase, film and video etc.,
	 @params $elementId : Id for record for which we have to fetch all related news
	**/
	public function listSectionInterviews($data=array())
	{
		$intervArray = array('tableName'=>'AddInfoInterview');//AddInfoNews,AddInfoReviews,AddInfoInterview
				
		$fields = $this->db->list_fields($this->db->dbprefix($intervArray['tableName']));

		foreach ($fields as $field)
		{
			$intervArray['fieldKeys'][]=$field;
		} 
		
		$intervObject = new lib_additional_info($intervArray) ;
				
		$whereArray = array('entityId' => $data['entityId'],'elementId'=>$data['elementId']);
		
		$orderBy = array('position' => 'asc');
		$intervData = $intervObject->listAdditionalInfo($whereArray,$orderBy='',$limit=0);
		
		$finalIntervData['interviews'] = $intervData;	
		
		$finalIntervData['label'] = $this->lang->language;
		$this->load->view('interview_list',$finalIntervData);
		
	}
	
	/* no further use, commented by sushil : 03-02-2014
	public function addInfoInterviewsPanel($entityId=0,$elementId=0,$returnUrl='')
	{
		$finalPanel['entityId'] = $entityId;
		$finalPanel['elementId'] = $elementId;
		$finalPanel['returnUrl'] = $returnUrl;
		$finalPanel['interviewDisplayStyle'] = 'style="display:block;"';
		$this->load->view('add_info_interviews_panel',$finalPanel);
	} */
	
	public function searchAdditionalInfo()
	{
		$section=$this->input->get('val1');
		$table=$this->input->get('val2');
		$orderBy=$this->input->get('val3');
		$data['section']=$section;
		$data['searchResult']=$this->model_common->getDataFromTabel($table, '*', '', '', $orderBy, 'ASC');
		$this->load->view('search_result',$data);
	}
	
	
	/* Social media section starts*/
	
	/**
		* Loads Social Media form (Entry) on page
	**/
	public function socialMediaForm($entityId=0,$elementId=0,$returnUrl='')
	{		
		$socialMediaFormData['entityId'] = $entityId;
		$socialMediaFormData['elementId'] = $elementId;
		$socialMediaFormData['label'] = $this->lang->language;
		$socialMediaFormData['socialMediaIconList']= getIconList();	
		$this->load->view('socialmedia_form',$socialMediaFormData);	 
	}
	
	public function addInfoSocialMediaPanel($entityId=0,$elementId=0,$returnUrl='')
	{
	  $finalPanel['entityId'] = $entityId;
	  $finalPanel['elementId'] = $elementId;
	  $finalPanel['returnUrl'] = $returnUrl;	
	  $this->load->view('add_info_socialmedia_panel',$finalPanel);
	}
	
	
	public function saveAddInfosocialMedia(){
	 $primaryKey = 'profileSocialLinkId';
	 $addInfoArray = array('tableName'=>'profileSocialLink');//AddInfoNews,AddInfoReviews,AddInfoInterview AddInfosocialMedia
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));
	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $addInfoData['label'] = $this->lang->language;
	
	 $config = array();
		
		$config = array(
			
			array(
					 'field'   => 'socialLink',
					 'label'   =>  $addInfoData['label']['socialLink'],
					 'rules'   => 'trim|xss_clean'
			),
			array(
					 'field'   => 'socialLinkTypeName',
					 'label'   =>  $addInfoData['label']['profileSocialLinkType'],
					 'rules'   => 'trim|xss_clean'
			),
		);
			
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{	
		
		if(strcmp($this->input->post('submit'),'Save')==0)
		{	
					
			$primaryId = $this->input->post('profileSocialLinkId');
			
			//echo '<pre />';print_r($_POST);
			$valuesArray = array(
			'profileSocialLinkId'=>$this->input->post('profileSocialLinkId'),
			'socialLink'=>$this->input->post('socialLink'),
			'profileSocialLinkType'=>$this->input->post('profileSocialLinkType'),
			'entityId'=>$this->input->post('entityId'),
			'socialLinkArchived'=>'f',
			'workProfileId'=>$this->input->post('elementId'),
			'position'=>$this->input->post('profileSocialLinkType')>0?$this->input->post('profileSocialLinkType'):1,
			);
			//echo '<pre />';print_r($valuesArray);die;
			
			if(!isset($primaryId) || $primaryId==0 || $primaryId=='')
			{
			  $valuesArray['socialLinkDateCreated'] = date("Y-m-d H:i:s"); 
			  $valuesArray['socialLinkDateModified'] = date("Y-m-d H:i:s"); 
			}
			else
			{
			  $valuesArray['socialLinkDateModified'] = date("Y-m-d H:i:s"); 			 
			}
			
			$addInfoData = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey,1);
			//echo $this->db->last_query();die;
			$msg=$this->lang->line('msgSocialMediaSave');
			set_global_messages($msg, $type='success', $is_multiple=true);
		}
	 }
	 
	 $returnUrl = $this->input->post('returnUrl');
	  $returnUrl = $returnUrl.'/';
	 redirect($returnUrl);
	}
	
/**
	@params $entityId : Id got from constants file for defined table eg.event showcase, film and video etc.,
	@params $elementId : Id for record for which we have to fetch all related news
**/
	public function listSectionSocialMedia($entityId=0,$elementId=0,$returnUrl)
	{
		$socialMediaArray = array('tableName'=>'profileSocialLink');//AddInfoNews,AddInfoReviews,AddInfoInterview				
		$fields = $this->db->list_fields($this->db->dbprefix($socialMediaArray['tableName']));

		foreach ($fields as $field)
		{
			$socialMediaArray['fieldKeys'][]=$field;
		} 
	
		$socialMediaObject = new lib_additional_info($socialMediaArray) ;
		
		$whereArray = array('entityId' => $entityId,'workProfileId'=>$elementId);		
		$orderBy = array('position' => 'ASC');
		//$socialMediaData = $socialMediaObject->listAdditionalInfo($whereArray,$orderBy,$limit=0);		
		$finalsocialMediaData['socialMedia'] = $this->lib_additional_info->getValuesFromSocialMedia($whereArray);		
		$finalsocialMediaData['label'] = $this->lang->language;
		$finalsocialMediaData['socialMediaType'] =$this->lib_social_media->getValues();
		
		$this->load->view('socialmedia_list',$finalsocialMediaData);
		
	}
	
	
	function shiftSMPosition ()
	{
		$tableProfileSocialLink='profileSocialLink';
		$controller=$this->input->post('controllerName');
		$currentId =  decode($this->input->post('currentId'));
		$currentPos =  $this->input->post('currentPosition');
		$swapId =  decode($this->input->post('swapId'));
		$swapPos =  $this->input->post('swapPosition');
		$showcaseId=  $this->input->post('entityId');
		$userShowcaseId =  $this->input->post('userShowcaseId');
		
		$getPostion = $this->model_common->shiftRecord($tableProfileSocialLink,'profileSocialLinkId',$currentId,$currentPos,$swapId,$swapPos);
		redirect($controller.'/socialMedia/'.$userShowcaseId);
	}
			
			
	function additionalInfoList($tableInfo=array())
	{ 
		$data['sections'] = $tableInfo['sections'];
		$data['sectionsname'] = $tableInfo['sectionsname'];
		$data['sectionBgcolor'] = @$tableInfo['sectionBgcolor']?$tableInfo['sectionBgcolor']:'C5C5C5';
		$data['fieldPrefix'] = $tableInfo['orderBy'];
		$data['largeTab'] = @$tableInfo['largeTab'];
		$whereField = array('entityId' => $tableInfo['entityId'],'elementId'=>$tableInfo['elementId']);
		
		if(!is_array($tableInfo['tableName'])){
			$tableInfo['tableName'] = array($tableInfo['tableName']);
			$tableInfo['orderBy'] = array($tableInfo['orderBy']);
		}
		
		foreach($tableInfo['tableName'] as $k=>$table){
			$orderBy = $tableInfo['orderBy'][$k].'Id';
			$data['additionalInfo'][] = $this->model_common->getDataFromTabel($table, '*',  $whereField, '', $orderBy, 'DESC');
			
		}
		
		$this->load->view('additionalInfoList',$data);
	}
    
    //-------------------------------------------------------------------------
    
    /*
     * @access: public
     * @descrition: this method is use to show additional info lit
     * @param: array
     * @return: string
     * @auther: lokendra meena
     */ 
    
    public function additionalInfoListNew($tableInfo=array())
	{ 
		$data['sections'] = $tableInfo['sections'];
		$data['sectionsname'] = $tableInfo['sectionsname'];
		$data['sectionBgcolor'] = @$tableInfo['sectionBgcolor']?$tableInfo['sectionBgcolor']:'C5C5C5';
		$data['fieldPrefix'] = $tableInfo['orderBy'];
		$data['largeTab'] = @$tableInfo['largeTab'];
		$whereField = array('entityId' => $tableInfo['entityId'],'elementId'=>$tableInfo['elementId']);
		
		if(!is_array($tableInfo['tableName'])){
			$tableInfo['tableName'] = array($tableInfo['tableName']);
			$tableInfo['orderBy'] = array($tableInfo['orderBy']);
		}
		
		foreach($tableInfo['tableName'] as $k=>$table){
			$orderBy = $tableInfo['orderBy'][$k].'Id';
			$data['additionalInfo'][] = $this->model_common->getDataFromTabel($table, '*',  $whereField, '', $orderBy, 'DESC');
			
		}
		
		$this->load->view('additionalInfoListNew',$data);
	}
    
    //---------------------------------------------------------------------
	
	function loadview(){
		$data=$this->input->get('val1');
		$this->load->view($data['viewPage'],$data);
	}
	
	
	function addInfoInterviewVideo($entityId=0,$elementId=0,$returnUrl='')
	{  
		$showcaseId=$elementId;
		$showcaseData['dirUploadMedia']='media/'.LoginUserDetails('username').'/showcase/';
		$showcaseData['entityId'] = $entityId;
		$showcaseData['showcaseId'] = $showcaseId;
		$showcaseData['returnUrl'] = $returnUrl;
		$showcaseData['elementFieldId'] = 'showcaseId';
		$showcaseData['elemetTable'] = 'UserShowcase';
		$showcaseData['browseId'] = '_interview';
		$showcaseData['folderPath'] = 'media/'.loginUserDetails('username').'/showcase/interview/';
		$showcaseData['showcaseData'] = $this->model_common->getDataFromTabel($table='UserShowcase', $field='showcaseId, tdsUid, interviewFileId,interviewTitle,interviewDescription,userContainerId',  $whereField=array('showcaseId'=>$showcaseId), '', $orderBy='', $order='', $limit=1 );
		
		$this->load->view('additionalInfo/additional_main_video',$showcaseData);
	}
	
	function addInfoIntroVideo($entityId=0,$elementId=0,$returnUrl='')
	{  
		$showcaseId=$elementId;
		$showcaseData['dirUploadMedia']='media/'.LoginUserDetails('username').'/showcase/';
		$showcaseData['showcaseId'] = $showcaseId;
		$showcaseData['elementFieldId'] = 'showcaseId';
		$showcaseData['elemetTable'] = 'UserShowcase';
		$showcaseData['browseId'] = '_Introductory';
		$showcaseData['folderPath'] = 'media/'.loginUserDetails('username').'/showcase/introductory/';
		$showcaseData['showcaseData'] = $this->model_common->getDataFromTabel($table='UserShowcase', $field='showcaseId, tdsUid,introductoryFileId,introductoryTitle,introductoryDescription,userContainerId',  $whereField=array('showcaseId'=>$showcaseId), '', $orderBy='', $order='', $limit=1 );
		$this->load->view('additionalInfo/additional_intro_video',$showcaseData);
	}
	
	function additionalInfoPopup()
	{  
		 
		 $AIData=$this->input->post('val1');
		
		 $this->load->view('additionalInfoPopup',$AIData);
		
	}
    
    function additionalInfoPopupNew()
	{  
		 
		 $AIData=$this->input->post('val1');
		
		 $this->load->view('additionalInfoPopup_new',$AIData);
		
	}
	
	
	/* Social media section ends*/
}
	?>
