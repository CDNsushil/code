<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

class notifications extends MX_Controller {
private $LogCrave = 'LogCrave';

	function __construct(){		
		 $load = array(
			'model'		=> 'model_notifications',	
            'library' 	=> 'pagination_new_ajax',			
			'config'	=> 'notification_alert'			
		 );		
		parent::__construct($load); 	
		$this->userId= $this->isLoginUser();
				
	}
	
	function notification_when_section_craved()
	{		
		$params = $this->input->post('notificationArray');
		//echo '<pre />params:';print_r($params);
		$projectType = $params['projectType'];
			
			switch($projectType) {
				
				case 'creatives':
				case 'enterprises':
				case 'associatedprofessionals':
					//$this->craved_user($params);
				break;	
				case 'blog':
					//$this->craved_blog($params);
				break;	
				case 'upcoming':
					//$this->craved_upcoming($params);
				break;	
				case 'performancesevents':
					//$this->craved_performancesevents($params);
				break;				
				case 'work':
					//$this->craved_work($params);
				break;	
				case 'product':
					//$this->craved_product($params);
				break;	
				case 'filmNvideo':
				case 'writingNpublishing':
				case 'photographyNart':
				case 'musicNaudio':
				case 'educationMaterial':
					//$this->craved_media($params);
				break;	
			
			}				
	}
	
	
	function craved_user($params) {
				
		$participantsData = '';		
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$projectType = $params['projectType'];
		$industry = getDataFromTabel('MasterIndustry','IndustryId',  'IndustryKey', $projectType,'', 'ASC', $limit=1 );		
		
		if($industry) 
		 $industryId = $industry[0]->IndustryId;
		else 
		 $industryId = 0;
			
		$ownerId = $this->userId; //any user craved the element
		
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');	
		
		$message = str_replace("{X}",LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}
	
	//Craved Blog 
	function craved_blog($params){
		
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');	
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);		
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved_blog($whereClause);
		//echo '<pre />';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
				echo 'notificationId:'.$this->db->last_query();
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
				echo '<br />NotificationParticipants:'.$this->db->last_query();
				
			}
		}
	}
	
	function craved_upcoming($params){
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');	
			
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		//echo '<pre />';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}

	
	function craved_performancesevents($params){
		
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');		
		
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		//echo '<pre />';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}
	
	
	function craved_work($params){
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');
		
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		//echo '<pre />';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}
	
		
	function craved_product($params){
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');	
		
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		//echo '<pre />';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,															 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}
	
	
	function craved_media($params){
		$participantsData = '';
		$entityId = $params['entityId'];
		$elementId = $params['elementId'];
		$projectId = $params['elementId'];
		$industryId = $params['industryId'];
		$projectType = $params['projectType'];
		$ownerId = $this->userId; //any user craved the element
		$whereClause = array($this->LogCrave.'.entityId'=>$entityId,$this->LogCrave.'.elementId'=>$elementId,$this->LogCrave.'.projectType'=>$projectType);
		
		if(isset($params['alert_type']))
			$message = $this->config->item($projectType.'_'.$params['alert_type'].'_alert');	
		else
			$message = $this->config->item($projectType.'_alert');	
		
		$message = str_replace("{X}", LoginUserDetails('firstName').' '.LoginUserDetails('lastName'),$message);			
		//$this->notification_when_user_craved($whereClause['userId']);
		$all_user_who_craved = $this->model_notifications->notification_when_section_craved($whereClause);
		
		//echo '<pre />all_user_who_craved:';print_r($all_user_who_craved);
		if(!empty($all_user_who_craved)){
			
			$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
																  'projectId'=>$projectId,
																  'elementId'=>$elementId,
																  'ownerId'=>$ownerId,
																  'industryId'=>$industryId,			 
																  'message'=>$message)									
										);
										
			//TO Check If The Element Is First Time Published
			$countNotification = countResult('Notification',$notificationsArray['notificationData'],'');
					
			if($countNotification<=0){
				
				$notificationId = $this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
					
				//Make array for inserting in NotificationParticipants
				foreach($all_user_who_craved as $key => $participantDetail) {			
					$flag ='f';			
					$participantsData[] = array('notificationId' => $notificationId,
					'userId' => $participantDetail['tdsUid'],
					'status' => 0,
					'isSender' => $flag);
					
				}//End Foreach
				
				//Insert multiple entries in notification participants table
				if(!empty($participantsData))
				$this->model_common->insertBatch('NotificationParticipants',$participantsData);		
			}
		}
	}

	/*
	 * {X}:OwnerId WHo send the notification
	 * {Y}:UserId for whom notifiction is
	 */
	function index($section='all',$ajaxHit=0)
	{		
		//echo '<pre />';print_r($_POST);die;
		$breadcrumbItem = array('messagecenter','notifications');
		$breadcrumbURL = array('notifications','notificationslist');
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString'] = $breadcrumbString;
		$data['section'] = $section;
		
		$type=0;
		$elementEntityId=0;
		$entityId=0;
		$sessionEntityId=0;
		$industryId=0;
		
		if($section=='all'){
			$type='all';
			$elementEntityId=0;
			$industryId=0;
		}		
		if($section=='yourReviews'){
			$type='yourReviews';
			$entityId=0;
			$industryId=0;
		}
		if($section=='filmNvideo'){
			$type='filmNvideo';
			//$entityId='filmNvideo';
			$entityId=54;
			$elementEntityId=12;
			$industryId=1;
		}
		if($section=='musicNaudio'){
			//54/25/2
			$type='musicNaudio';
			$entityId=54;
			$elementEntityId=25;
			$industryId=2;
		}
		if($section=='photographyNart'){
			//54/47/3
			$type='photographyNart';
			$entityId=54;
			$elementEntityId=47;
			$industryId=4;
		}
		if($section=='writingNpublishing'){
			//54/84/4
			$type='writingNpublishing';
			$entityId=54;
			$elementEntityId=84;
			$industryId=3;
		}		
		if($section=='performancesevents'){
			//9/15
			$type='performancesevents';
			$entityId=9;
			$sessionEntityId=10;
			$elementEntityId=15;
			$industryId=0;
		}
		if($section=='educationMaterial'){
			//54/7/5
			$type='educationMaterial';
			$entityId=54;
			$elementEntityId=7;
			$industryId=5;
		}
		if($section=='work'){
			//82
			$type='work';
			$entityId=82;
			$elementEntityId=0;
			$industryId=0;
		}
		if($section=='product'){
			//49
			$type='product';
			$entityId=49;
			//$elementEntityId=0;
			$industryId=0;
		}
		if($section=='blog'){
			//96
			$type='blog';
			$entityId=96;
			//$elementEntityId=0;
			$industryId=0;
		}
		if($section=='enterprises'){
			//93/8
			$type='enterprises';
			$entityId=93;
			//$elementEntityId=0;
			//$industryId=8;
			$industryId=0;
		}
		if($section=='associatedprofessionals'){
			//93/7
			$type='associatedprofessionals';
			$entityId=93;
			$elementEntityId=0;
			$industryId=0;
			$industryId=7;
		}
		if($section=='creatives'){
			//93/6
			$type='creatives';
			$entityId=93;
			$elementEntityId=0;
			//$industryId=6;
			$industryId=0;
		}
		//if($type==93) $whereClause = array('type'=>93,'industryId'=>$elementEntityId);
		//else $whereClause = array('type'=>$type,'elementEntityId'=>$elementEntityId,'industryId'=>$industryId);
	
		$whereClause = array('type'=>$type,'entityId'=>$entityId,'elementEntityId'=>$elementEntityId,'sessionEntityId'=>$sessionEntityId,'industryId'=>$industryId);	
		
		
		$data['section_notification_count'] = $this->model_notifications->count_notifications();		
		$data['perPageRecord'] = $this->config->item('perPageRecordProduct');
		$data['count_section_craved_list'] = $this->model_notifications->count_fetched_notifications($whereClause,$data['perPageRecord']);	
		
		
		$pages = new Pagination_new_ajax;		
	
		$pages->items_total = count($data['count_section_craved_list']); // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$data['perPageRecord'];
		
		// Add By Amit to check if cookie exists		
		$isCookie = getPerPageCookie('notificationPerPageVal',$data['perPageRecord']);		
		
		$pages->items_per_page=$isCookie ;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();
		$data['section_craved_list'] = $this->model_notifications->fetch_notifications($whereClause,$pages->items_per_page,$pages->offst);
        
        	
		//echo '<pre />';print_r($section_craved_list);
		//echo $this->db->last_query();die;
		//echo '<pre />';print_r($_POST);die;
		
         // get notification count
        $unreadNotificationCount        =    countResult('NotificationParticipants',array('userId'=>$this->userId,'isSender'=>'f','status'=>0));
        $data['unreadNotificationCount'] = $unreadNotificationCount;
        
		if($ajaxHit==1)	{
			$this->load->view('notifications',$data);
		}else{
		
			//$this->template->load('template','notifications',$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_tmail';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->new_version->load('new_version','notifications',$data);
		}	
	}
	
	function notificationslist($section='all')
	{		
		$breadcrumbItem = array('messagecenter','notifications');
		$breadcrumbURL = array('notifications','notificationslist');
		$breadcrumbString = set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString'] = $breadcrumbString;
		$data['section'] = $section;
		$type=0;
		$entityId=0;
		$elementEntityId=0;
		$sessionEntityId=0;
		$industryId=0;
		
		if($section=='all'){
			$type=0;
			$elementEntityId=0;
			$industryId=0;
		}
		if($section=='yourReviews'){
			$type='yourReviews';
			$entityId=0;
			$industryId=0;
		}		
		if($section=='filmNvideo'){
			$type='filmNvideo';
			//$entityId='filmNvideo';
			$entityId=54;
			$elementEntityId=12;
			$industryId=1;
		}
		if($section=='musicNaudio'){
			//54/25/2
			$type='musicNaudio';
			$entityId=54;
			$elementEntityId=25;
			$industryId=2;
			
		}
		if($section=='photographyNart'){
			//54/47/3
			$type='photographyNart';
			$entityId=54;
			$elementEntityId=47;
			$industryId=4;
		}
		if($section=='writingNpublishing'){
			//54/84/4
			$type='writingNpublishing';
			$entityId=54;
			$elementEntityId=84;
			$industryId=3;
		}		
		if($section=='performancesevents'){
			//9/15
			$type='performancesevents';
			$entityId=9;
			$sessionEntityId=10;
			$elementEntityId=15;
			$industryId=0;
		}
		if($section=='educationMaterial'){
			//54/7/5
			$type='educationMaterial';
			$entityId=54;
			$elementEntityId=7;
			$industryId=5;
		}
		if($section=='work'){
			//82
			$type='work';
			$entityId=82;
			$elementEntityId=0;
			$industryId=0;
		}
		if($section=='product'){
			//49
			$type='product';
			$entityId=49;
			//$elementEntityId=0;
			$industryId=0;
		}
		if($section=='blog'){
			//96
			$type='blog';
			$entityId=96;
			//$elementEntityId=0;
			$industryId=0;
		}
		if($section=='enterprises'){
			//93/8
			$type='enterprises';
			$entityId=93;
			//$elementEntityId=0;
			$industryId=8;
		}
		if($section=='associatedprofessionals'){
			//93/7
			$type='associatedprofessionals';
			$entityId=93;
			$elementEntityId=0;
			$industryId=7;
		}
		if($section=='creatives'){
			//93/6
			$type='creatives';
			$entityId=93;
			$elementEntityId=0;
			$industryId=6;
		}
		//if($type==93) $whereClause = array('type'=>93,'industryId'=>$elementEntityId);
		//else $whereClause = array('type'=>$type,'elementEntityId'=>$elementEntityId,'industryId'=>$industryId);
		//echo '<pre />';print_r($_REQUEST);
		$whereClause = array('type'=>$type,'entityId'=>$entityId,'elementEntityId'=>$elementEntityId,'sessionEntityId'=>$sessionEntityId,'industryId'=>$industryId);	
		//echo '<pre />';print_r($whereClause);
		$data['perPageRecord'] = $this->config->item('perPageRecordProduct');
		$data['count_section_craved_list'] = $this->model_notifications->count_fetched_notifications($whereClause,$data['perPageRecord']);	
				
		$pages = new pagination_new_ajax;		
	
		$pages->items_total = count($data['count_section_craved_list']); // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$data['perPageRecord'];
		
		// ADD by Amit to set cookie		
		$isSetCookie = setPerPageCookie('notificationPerPageVal',$data['perPageRecord']);		
		
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isSetCookie;
		
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();
		$data['section_craved_list'] = $this->model_notifications->fetch_notifications($whereClause,$pages->items_per_page,$pages->offst);	
		
		$this->load->view('list_notification',$data);
	}


	function trashNotificationMessage()
	{
		
		$ajaxHit=1;
		$delItems=$this->input->post('delItems');
		$section=$this->input->post('section');
		$limit =0;	
		$perPage=(!empty($perPage)) ? $perPage :8;
		$offSet=(!empty($offSet)) ? $offSet :0; 
		
		$items = explode(',',$delItems);		 
		//echo 'items:'.$items;die;		 
		$curentUid = $this->userId;
		
		foreach($items as $delItem)
		{
			$this->model_notifications->trashNotificationMessage($delItem,$curentUid);
		}	
	 
		$this->index($section,$ajaxHit);					
	}

}
