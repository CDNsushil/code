<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Todasquare frontend Controller Class
 *
 *  manage frontend details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class eventfrontend extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
			 $load = array(
					'model'		=> 'event/model_event',
					'language' 	=> 'event'
			 );
			parent::__construct($load);		
			
		   
			//$this->userId= $this->isLoginUser();
			$this->userId= isLoginUser()?isLoginUser():0;
			
			// Load  path of css and cache file path
			$this->dirCache = 'cache/event/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/event/'; 
			$this->data['dirUploadMedia'] = $this->dirUploadMedia;
			$this->head->add_js($this->config->item('system_js').'jquery.tabs.js');
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			} 
	}
	
/*============================Film and Video Section==================================================*/	
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() {
		$this->eventnotification();
	}
	
	public function preview($userId=0,$id=0,$mathod='eventnotification',$extra='') 
	{
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirectToNorecord404();
		}
		if(empty($extra)){
			$this->$mathod($userId,$id);
		}else{
			$this->$mathod($userId,$id,$extra);
		}
		
	}
	
	public function eventnotification($userId=0,$EventId=0, $return=0,$view='eventfrontend') {
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0)){
			redirectToNorecord404();
		}
		$this->data['method']='eventnotification';
		$this->data['userId']=$userId;
		$this->data['notificationEventId']=$EventId;
		$this->data['entityId'] = $entityId = getMasterTableRecord('Events');
		
		/* Update view count */
		$viewEntityId = $entityId;
		if((!empty($viewEntityId)) && (!empty($EventId))){
			
			manageViewCount($viewEntityId,$EventId,$userId);
		}	
		
		$this->data['cacheFile'] =$cacheFile=$this->dirCache.'eventnotification_User_'.$userId.'.php';
		
		$this->data['moduleMathod'] = $moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		$isPublished=($preview==1)?'':'t';
		$natureId=1;
		
		$currentDateTime= currntDateTime();
		$interval=$this->config->item('eventShownForExtraDays');
		$eventShownForExtraDays=getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');
		
		$where=array('tdsUid'=>$userId,'NatureId'=>$natureId);
		if($EventId > 0){
			$where['EventId']=$EventId;
		}
		if($isPublished == 'f' || $isPublished == 't'){
			$where['isPublished']=$isPublished;
			//$where['FinishDate >= ']=$eventShownForExtraDays;
		}
		
		
		//$this->db->where("(\"StartDate\" <= '".$eventShownForExtraDays."' OR \"FinishDate\" <= '".$eventShownForExtraDays."')", null, false);
		
		$this->data['countResult']=$this->model_common->countResult('Events',$where);
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordEvents');
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$this->data['pagingLink'] = base_url(lang().'/eventfrontend/'.$moduleMathod.'/'.$userId.'/'.$EventId);
		if($moduleMathod=='events'){
			$this->data['pagingLink'] = base_url(lang().'/eventfrontend/'.$moduleMathod.'/notification/'.$userId.'/'.$EventId);
		}
		
		$this->data['eventList'] =$eventList=$this->model_event->getEventFullDetails($EventId,$userId,$isPublished,$natureId,$pages->offst,$pages->limit);
		
		
		$this->eventNotificationList($userId);
		$this->launchEventDetails($userId);
		$this->eventDetails($userId);
		
		
		
		if(!is_numeric($this->data['countNotification']) || $this->data['countNotification']==0){
			if(count($this->data['LaunchEvents'])> 0){
				redirect('eventfrontend/eventlaunch/'.$userId.'/'.$this->data['LaunchEvents'][0]->LaunchEventId);
			}elseif(count($this->data['events'])> 0){
				redirect('eventfrontend/event/'.$userId.'/'.$this->data['events'][0]->EventId);
			}
		}
		
		if($return != 1){
			$ajaxRequest = $this->input->post('ajaxRequest');
			if($ajaxRequest){
				 $this->load->view('event_notification',$this->data) ;
			}else{
				$this->data['eventPage'] = $this->load->view('event_notification',$this->data,true);
				$breadcrumbItem=array('showcase','performancesnevents','eventnotification');
				$breadcrumbURL=array('showcase/aboutme/'.$userId,'eventfrontend/eventnotification/'.$userId,'eventfrontend/eventnotification/'.$userId);
				$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
				$this->data['breadcrumbString']=$breadcrumbString;
				$this->template_front_end->load('template_front_end',$view,$this->data);
			}
		}
	}
	
	public function eventlaunch($userId=0,$LaunchEventId=0, $return=0,$view='eventfrontend') {
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0)){
			redirectToNorecord404();
		}
		if(!($LaunchEventId > 0)){
			redirect('eventfrontend/eventnotification/'.$userId);
		}
		$this->data['method']='eventlaunch';
		$this->data['userId']=$userId;
		$this->data['launchEventId']=$LaunchEventId;
		$this->data['entityId'] = $entityId = getMasterTableRecord('LaunchEvent');
		
		/* Manage Launch view count */
		$viewEntityId = $entityId;
		if((!empty($viewEntityId)) && (!empty($LaunchEventId))){
			$sectionId = $this->config->item('launchesSectionId');
			$projId = $LaunchEventId;
			manageViewCount($viewEntityId,$LaunchEventId,$userId,$projId,$sectionId);
		}	
		$this->data['cacheFile'] =$cacheFile=$this->dirCache.'eventlaunch_User_'.$userId.'_event_'.$LaunchEventId.'.php';
		
		if(!is_file($cacheFile) || is_file($cacheFile)){
				
				$this->data['moduleMathod'] =$moduleMathod=$this->router->fetch_method();
				$preview=($moduleMathod=='preview')?1:0;
				$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
				$isPublished=($preview==1)?'':'t';
				$eventList=$this->model_event->getLaunchEventFullDetails($LaunchEventId,$userId,$isPublished);
				$eventList['promotionalImages']=$this->model_event->getEventPromotionalImages(array('launchEventId'=>$LaunchEventId,'launchPostPR'=>'f'));
				$eventList['launchPostPRImages']=$this->model_event->getEventPromotionalImages(array('launchEventId'=>$LaunchEventId,'launchPostPR'=>'t'));
				if(!is_dir($this->dirCache)){
					@mkdir($this->dirCache, 777, true);
				}
				$cmd3 = 'chmod -R 777 '.$this->dirCache;
				exec($cmd3);
				$data=str_replace("'","&apos;",json_encode($eventList));	//encode data in json format
				$stringData = '<?php $ProjectData=\''.$data.'\';?>';
				if (!write_file($cacheFile, $stringData)){					// write cache file
					 echo 'Unable to write the file';
				}	
						
		}
		if(is_file($cacheFile) || !is_file($cacheFile)){
			require_once ($cacheFile);
			$this->data['eventList'] =json_decode($ProjectData, true);
			if($this->data['eventList'] && is_array($this->data['eventList']) && count($this->data['eventList']) > 0){
				$LogSummaryWhere=array('entityId'=>$entityId,'elementId'=>$LaunchEventId);
				$this->data['logSummryDta'] =$this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',$LogSummaryWhere,'','','',1);
			}else{
				$this->data['logSummryDta'] =false;
			}
		}else{
			$this->data['eventList']=false;
		}
		
		$this->launchEventDetails($userId);
		$this->eventDetails($userId);
		$this->eventNotificationList($userId);
		
		$this->supportingmaterial($entityId, $LaunchEventId) ;
		
		if($return != 1){
			
			if(isset($LaunchEventId) && !empty($LaunchEventId) && isset($this->userId)){
				//Get session details of users ticket 
				$ticketWhere = array('projectId'=>$LaunchEventId,'userId'=>$this->userId);
				$getTicketBuyDetails = getDataFromTabel('TicketTransectionLog', 'sessionId',  $ticketWhere, '', $orderBy='', '', 1 );
				if(isset($getTicketBuyDetails[0]->sessionId) && !empty($getTicketBuyDetails[0]->sessionId)){
					$this->data['ticketSessionId'] = $getTicketBuyDetails[0]->sessionId;
					if(isset($this->data['ticketSessionId']) && !empty($this->data['ticketSessionId'])){
						//Get Meeting point info of user
						$meetingWhere = array('session_id'=>$this->data['ticketSessionId']);
						$getMeetingDetails = getDataFromTabel('MeetingPoint', 'id',  $meetingWhere, '', $orderBy='', '', 1 );
						if(isset($getMeetingDetails[0]->id) && !empty($getMeetingDetails[0]->id)){
							$this->data['meetingPointId'] = $getMeetingDetails[0]->id;
						}
					}
				}
			}
			
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Set advert performance and event section id
			$advertSectionId = $this->config->item('performancesneventsSectionId');
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			//$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType3'=>$bannerType3,'bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);
		} 	
			
			$this->data['eventPage'] = $this->load->view('event_launch',$this->data,true);
			$breadcrumbItem=array('showcase','performancesnevents','eventlaunch');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'eventfrontend/eventnotification/'.$userId,'eventfrontend/eventlaunch/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
	
			$this->template_front_end->load('template_front_end',$view,$this->data);
		}
	}
	
	public function event($userId=0,$EventId=0, $return=0,$view='eventfrontend') {
		$userId=$userId>0?$userId:$this->userId;
		if(!($userId > 0)){
			redirectToNorecord404();
		}
		if(!($EventId > 0)){
			redirect('eventfrontend/eventnotification/'.$userId);
		}
		$this->data['method']='event';
		$this->data['userId']=$userId;
		$this->data['entityId'] = $entityId = getMasterTableRecord('Events');
		$this->data['EventId'] = $EventId;
		$this->data['cacheFile'] =$cacheFile=$this->dirCache.'PEevent_User_'.$userId.'_event_'.$EventId.'.php';
		
		/* Manage Event view count */
		$viewEntityId = $entityId;
		if((isset($viewEntityId)) && (!empty($viewEntityId)) && (isset($EventId)) && (!empty($EventId))){
			$sectionId = $this->config->item('eventsSectionId');
			$projId = $EventId;
			manageViewCount($viewEntityId,$EventId,$userId,$projId,$sectionId);
		}	
		
		
		if(!is_file($cacheFile) || is_file($cacheFile)){
				$this->data['moduleMathod'] =$moduleMathod=$this->router->fetch_method();
				$preview=($moduleMathod=='preview')?1:0;
				$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
				$isPublished=($preview==1)?'':'t';
				$eventList=$this->model_event->getEventFullDetails($EventId,$userId,$isPublished);
				
				$eventList['promotionalImages']=$this->model_event->getEventPromotionalImages(array('eventId'=>$EventId));
				$eventList['launchPostPRImages']='';
				$eventList['eventSessions']=$this->model_event->geteventSessions(array('EventSessions.eventId'=>$EventId));
				
				if(!is_dir($this->dirCache)){
					@mkdir($this->dirCache, 777, true);
				}
				$cmd3 = 'chmod -R 777 '.$this->dirCache;
				exec($cmd3);
				$data=str_replace("'","&apos;",json_encode($eventList));	//encode data in json format
				$stringData = '<?php $ProjectData=\''.$data.'\';?>';
				if (!write_file($cacheFile, $stringData)){					// write cache file
					 echo 'Unable to write the file';
				}
			
		}
		if(is_file($cacheFile) || !is_file($cacheFile)){
			require_once ($cacheFile);
			$this->data['eventList'] =json_decode($ProjectData, true);
			if($this->data['eventList'] && is_array($this->data['eventList']) && count($this->data['eventList']) > 0){
				$LogSummaryWhere=array('entityId'=>$entityId,'elementId'=>$EventId);
				$this->data['logSummryDta'] =$this->model_common->getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',$LogSummaryWhere,'','','',1);
			}else{
				$this->data['logSummryDta'] =false;
			}
		}else{
			$this->data['eventList']=false;
		}
		$this->launchEventDetails($userId);
		$this->eventDetails($userId);
		$this->eventNotificationList($userId);
		
		$this->supportingmaterial($entityId, $EventId);
		if($return != 1){
			if(isset($EventId) && !empty($EventId) && isset($this->userId)){
				//Get session details of users ticket 
				$ticketWhere = array('projectId'=>$EventId,'userId'=>$this->userId);
				$getTicketBuyDetails = getDataFromTabel('TicketTransectionLog', 'sessionId',  $ticketWhere, '', $orderBy='', '', 1 );
				if(isset($getTicketBuyDetails[0]->sessionId) && !empty($getTicketBuyDetails[0]->sessionId)){
					$this->data['ticketSessionId'] = $getTicketBuyDetails[0]->sessionId;
					if(isset($this->data['ticketSessionId']) && !empty($this->data['ticketSessionId'])){
						//Get Meeting point info of user
						$meetingWhere = array('session_id'=>$this->data['ticketSessionId']);
						$getMeetingDetails = getDataFromTabel('MeetingPoint', 'id',  $meetingWhere, '', $orderBy='', '', 1 );
						if(isset($getMeetingDetails[0]->id) && !empty($getMeetingDetails[0]->id)){
							$this->data['meetingPointId'] = $getMeetingDetails[0]->id;
						}
					}
				}
			}
			
			//manage advert types if exists
			if(is_dir(APPPATH.'modules/advertising')) {
				//Set advert performance and event section id
				$advertSectionId = $this->config->item('performancesneventsSectionId');
				//Get banner records based on section and advert type
				$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
				//$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
				$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
				$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
				$this->data['advertSectionId'] = $advertSectionId; //set advert section id
				//Load view of advert js functions
				$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType3'=>$bannerType3,'bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);
			} 	
			
			$this->data['eventPage'] = $this->load->view('event',$this->data,true);
			$breadcrumbItem=array('showcase','performancesnevents','event');
			$breadcrumbURL=array('showcase/aboutme/'.$userId,'eventfrontend/eventnotification/'.$userId,'eventfrontend/event/'.$userId);
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
			$this->template_front_end->load('template_front_end',$view,$this->data);
		}
	}
	
	function sessionTickets( $userId=0, $EventId=0,$eventType='event',$view='eventfrontend'){
		$sessionIds=false;
		if($eventType=='event'){
			$this->event($userId,$EventId, $return=1);
			$entityId = getMasterTableRecord('Events');
			if(isset($this->data['eventList']['eventSessions']) && is_array($this->data['eventList']['eventSessions']) && count($this->data['eventList']['eventSessions']) > 0){
				$sessionIds = array_map(function ($ar) {return $ar['sessionId'];}, $this->data['eventList']['eventSessions']);
			}
			$eventTypeLink='eventfrontend/event/'.$userId.'/'.$EventId;

		}else{
			$this->eventlaunch($userId,$EventId, $return=1);
			$entityId = getMasterTableRecord('LaunchEvent');
			if(isset($this->data['eventList'][0]['sessionId']) && $this->data['eventList'][0]['sessionId'] > 0){
				$sessionIds[] = $this->data['eventList'][0]['sessionId'];
			}
			$eventTypeLink='eventfrontend/eventlaunch/'.$userId.'/'.$EventId;
		}
		$this->data['entityId'] = $entityId;
		$this->data['userId'] =$userId;
		$this->data['eventType'] = $eventType;
		if($sessionIds){
			$this->data['tickets'] =$this->model_event->getSessionsTickets($sessionIds);
		}else{
			$this->data['tickets'] =false;
		}
		$this->data['eventPage'] = $this->load->view('event_session',$this->data,true);
		$breadcrumbItem=array('showcase','performancesnevents',$eventType,'sessionTickets');
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'eventfrontend/eventnotification/'.$userId,$eventTypeLink,'eventfrontend/sessionTickets/'.$userId.'/'.$EventId.'/'.$eventType);
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$this->data['breadcrumbString']=$breadcrumbString;
		
		$this->template_front_end->load('template_front_end',$view,$this->data);
	}
	
	public function events($eventType='launch', $userId=0, $EventId=0) {
		
		$this->data['eventType'] = $eventType;
		$this->data['id'] = $EventId;
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Set advert performance and event section id
			$advertSectionId = $this->config->item('performancesneventsSectionId');
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'sectionId'=>$advertSectionId),true);
		}
		
		if($eventType=='launch'){
			$this->eventlaunch($userId,$EventId, $return=0 ,$view='eventfrontend_search');
		}elseif($eventType=='notification'){
			$this->eventnotification($userId,$EventId, $return=0 ,$view='eventfrontend_search');
		}elseif($eventType=='eventSession'){
			$this->sessionTickets($userId, $EventId,$eventType='event',$view='eventfrontend_search');
		}elseif($eventType=='launchSession'){
			$this->sessionTickets($userId, $EventId,$eventType='launch', $view='eventfrontend_search');
		}else{
			$this->event($userId,$EventId, $return=0,$view='eventfrontend_search');
		}
	}
	
	function launchEventDetails($userId=0){
		$this->data['moduleMathod'] =$moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		$this->data['LaunchEvents']=$this->model_event->getLaunchDetails($userId,$checkPublished);
	}
	
	function eventDetails($userId=0){
		$this->data['moduleMathod'] = $moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		$this->data['events']=$this->model_event->getEventDetails($userId,$checkPublished);
	}
	
	function eventNotificationList($userId=0,$natureId=1,$isPublished='t'){
		$this->data['moduleMathod'] = $moduleMathod=$this->router->fetch_method();
		$preview=($moduleMathod=='preview')?1:0;
		$checkPublished=( ($userId==$this->userId) && isset($preview) && $preview ==1)?false:true;
		$isPublished=($preview==1)?'':'t';
		$this->data['notificationList']=$this->model_event->getNotificationDetails($userId,$natureId=1,$isPublished);
		$this->data['countNotification']=count($this->data['notificationList']);
	}
	
	/*
	 * Function to join Meeting Point 
	 */
	function joinMeetingPoint(){
		$sessionId = $this->input->post('sessionId');
		if(isset($sessionId) && !empty($sessionId) && isset($this->userId)){
			//Check Users meeting point status
			$meetingWhere = array('session_id'=>$sessionId,'user_id'=>$this->userId);
			$getMeetingDetails = getDataFromTabel('MeetingPoint', 'id',  $meetingWhere, '', $orderBy='', '', 1 );
			if(isset($getMeetingDetails[0]->id)){
				echo 2;
			}else{
				//$eventWhere = array('sessionId'=>$sessionId,'userId'=>$this->userId);
				//$getEventDetails = getDataFromTabel('TicketTransectionLog', '*',  $eventWhere, '', $orderBy='', '', 1 );
				$eventWhere = array('sessionId'=>$sessionId);
				$getEventDetails = getDataFromTabel('EventSessions', '*',  $eventWhere, '', $orderBy='', '', 1 );
				if(isset($getEventDetails) && !empty($getEventDetails)){
					//Set Event Id
					if(isset($getEventDetails[0]->eventId) && !empty($getEventDetails[0]->eventId))
					{
						$eventId = $getEventDetails[0]->eventId;
						$launchId = 0;
					}
					//Set Launch Id
					if(isset($getEventDetails[0]->launchEventId) && !empty($getEventDetails[0]->launchEventId))
					{
						$eventId = 0;
						$launchId = $getEventDetails[0]->launchEventId;
					}
					
					$meetingData['event_id']   =  $eventId;
					$meetingData['launch_id']  =  $launchId;
					$meetingData['session_id'] =  $sessionId;
					$meetingData['user_id']    =  $this->userId;
					$insertMeeting = $this->model_event->joinMeetingData($meetingData);
					if(isset($insertMeeting)){
						echo 1;
					}else{
						echo 0;
					}
				}
			}
		}
	}
	
	function supportingmaterial($entityId=0, $elementId=0){
		$this->load->model('media/model_media');
		$whereSuportLinks=array('entityid_to'=>$entityId,'elementid_to'=>$elementId);
		$res=$this->model_media->suportLinks($whereSuportLinks);
		
		if($res){
			$this->data['suportLinks']=$res;
		}else{
			$this->data['suportLinks']=false;
		}
	}
	
	/*
	 * @Details :  this funciton is used send http to https curl request
	 * for free ticket purchase
	 * @return : json response 
	 */ 
	
	
	function buyfreeticket(){
		
		//$server_path = base_url(lang().'/cart/testwork');
		$server_path = base_url_secure(lang().'/cart/buyFreeTickets');
		$postArray['ticketDetails']=$_POST['ticketDetails'];
		
		//--Send API request using curl
		$postArray = http_build_query($postArray);
		$ch = curl_init($server_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $postArray);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		$resp = curl_exec($ch);
		curl_close($ch); 
	
		echo $resp;	
	}	
	
	//-----------this funciton only for testing----------//
	
	function buyfreeticketold(){
		
		$server_path = base_url_secure(lang().'/cart/testwork');
		$postArray = array("test1","test2","test3","test4");
		
		//--Send API request using curl
		$postArray = http_build_query($postArray);
		$ch = curl_init($server_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $postArray);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
		$resp = curl_exec($ch);
		//echo $resp;
		
		echo curl_error($ch);
		echo "<br>";
		echo curl_errno($ch);
		// Check if any error occurred
		curl_close($ch); 
		
		$resp_arr = json_decode($resp);
		print_r($resp_arr);die;
	
		
	}
	
	
	//-----------this funciton only for testing----------//
	
	function buyfreetickettest(){
		
		$server_path = base_url_secure(lang().'/cart/testwork');
		$postArray = array("test1","test2","test3","test4");
		
		
		// Set the URL to visit
		$url = base_url_secure(lang().'/cart/testwork');

		// In this example we are referring to a page that handles xml
		$headers = array( "Content-Type: text/xml",);

		// Initialise Curl
		$curl = curl_init();
		if ($curl === false)
		{
			throw new Exception(' cURL init failed');
		}

		// Configure curl for website
		curl_setopt($curl, CURLOPT_URL,  base_url_secure());

		// Set up to view correct page type
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		// Turn on SSL certificate verfication
		curl_setopt($curl, CURLOPT_CAPATH, "/usr/local/www/vhosts/toadsquare/httpdocs/cacert.pem");
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);

		// Tell the curl instance to talk to the server using HTTP POST
		curl_setopt($curl, CURLOPT_POST, 1);

		// 1 second for a connection timeout with curl
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

		// Try using this instead of the php set_time_limit function call
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);

		// Causes curl to return the result on success which should help us avoid using the writeback option
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$resp = curl_exec($curl);
		
		
		echo curl_error($curl);
		echo "<br>";
		echo curl_errno($curl);
		// Check if any error occurred
		curl_close($curl); 
		
		$resp_arr = json_decode($resp);
		print_r($resp_arr);die;
		
	}	
	
}
/* End of file frontend.php */
/* Location: ./application/module/frontend/frontend.php */
