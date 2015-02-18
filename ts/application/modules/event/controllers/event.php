<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare event Controller Class
 *
 *  Manage event details (Showcase Homepage, Additional Information, Recommendations)
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */

class event extends MX_Controller {
private $dirCache = '';
private $eventVar;
private $eventId;
private $eventTableName = 'Events';
private $launcheventTableName = 'LaunchEvent';
private $eventMediaTableName = 'EventMedia';
private $mediaFile = 'MediaFile';
private $promoMediaField = array();	
private $ImgConfig;
private $natureId;
private $newLaunchEventId;
private $newEventId;
private $data;
private $promoImageField = array('mediaId','mediaType','mediaTitle','mediaDescription','fileId','launchEventId','eventId','isMain');

	/**	 Constructor  **/
	function __construct(){	
	 //My own constructor code
	 $load = array(
	  		'model'		=> 'model_event',
			'library' 	=> 'form_validation + upload + session + lib_event + lib_masterMedia + lib_event_promo_image + lib_sub_master_media + lib_image_config + lib_additional_info',
			'language' 	=> 'event',
			'helper' 	=> 'form + file'
	 );
		
	parent::__construct($load); 
	
	$this->userId= $this->isLoginUser();
	$this->dirCache ='cache/event/';
	//Get variables from library loaded
	$this->eventVar = $this->lib_event->getValues();
	$this->mediaPath = "media/".LoginUserDetails('username')."/events/" ;
	$this->launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;
	
	$cmdmediaPath = 'chmod -R 777 '.$this->mediaPath;
	exec($cmdmediaPath);
	$cmdlaunchMediaPath = 'chmod -R 777 '.$this->launchMediaPath;
	exec($cmdlaunchMediaPath);	

	$this->ImgConfig = $this->lib_image_config->getImgConfigValue();
	
	$cmd = 'chmod -R 777 '.MEDIAUPLOADPATH.LoginUserDetails('username')."/events/";
	exec($cmd);
			
	//$this->head->add_js($this->config->item('system_js').'ns.js');
	$this->head->add_css($this->config->item('system_css').'frontend.css');
	$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
	$this->head->add_css($this->config->item('system_css').'upload_file.css');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');		
	}

/** Loads Event Notification View **/
function index()
{	
	$this->notificationslist();	
}

function eventnotifications($method='notificationslist',$thisId=0){
	$this->$method($thisId,$natureId=1);
}

/** Loads Event List View **/
function notificationslist($deleted='')
{	
	$eventListData['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 ))){ 
		
	}else{
		redirect('dashboard/performancesevents');		
	}
	
	$this->data['label'] = $this->lang->language;
	$userId = $this->userId;
	$this->data['userId']=$this->userId;
	$thisNatureId = 1;
	$this->data['NatureId']=$thisNatureId;	
	$this->data['entityId'] = $entityId = getMasterTableRecord('Events');
	
	if(strcmp($deleted,'deleted')==0)
	{
		$isArchive = 't';
		$loadPage='deleted_notification_list';
		$ajaxpage='deleted_notification_data';
	}
	else
	{
		$isArchive = 'f';
		$loadPage='event_notification_list';
		$ajaxpage='event_notification_data';		
	}
	
	$this->data['isArchive'] =$isArchive;
	$this->data['countResult']=$this->model_common->countResult('Events',array('NatureId'=>$thisNatureId,'tdsUid'=>$userId,'EventArchive'=>$isArchive));
	$pages = new Pagination_ajax;
	$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
	$this->data['perPageRecord'] =$this->config->item('perPageRecordEvents');
	//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
	
	// Add by Amit to set cookie for Results per page
	if($this->input->post('ipp')!=''){
		$isCookie = setPerPageCookie('eventnotificationsPerPageVal',$this->data['perPageRecord']);	
	}else {
		$isCookie = getPerPageCookie('eventnotificationsPerPageVal',$this->data['perPageRecord']);		
	}
				
	$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
	
	$pages->paginate();
	$this->data['items_total'] = $pages->items_total;
	$this->data['items_per_page'] = $pages->items_per_page;
	$this->data['pagination_links'] = $pages->display_pages();
	$this->data['listData'] =  $this->lib_event->eventList($thisNatureId,$userId,'',$isArchive,$pages->offst,$pages->limit);
	
	$ajaxRequest = $this->input->post('ajaxRequest');
	if($ajaxRequest){
		 $this->load->view($ajaxpage,$this->data) ;
	}			   
	else{
		$breadcrumbItem=array('performancesnevents','eventnotifications');
		$breadcrumbURL=array('event/eventnotifications/','event/eventnotifications/');
		if($isArchive == 't'){
			$breadcrumbItem[]='deletedItems';
			$breadcrumbURL[]='event/eventnotifications/notificationslist/deleted';
		}
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		//echo $loadPage;die;
		$this->data['breadcrumbString']=$breadcrumbString;
		//$this->template->load('template',$loadPage,$this->data);	
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isNotification'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template',$loadPage,$this->data);
	}
			
}	


function events($method='eventdetail',$thisId=0,$natureId=2,$nextId=0){
	if($method=='eventsession'){
		$this->$method($thisId);
	}else{
		$this->$method($thisId,$natureId,$nextId);
	}
}

function launch($method='launchdetail',$eventId=0,$natureId=3,$launchEventId=0,$sessionId=0){
	if($method=='launchdetail'){
		$this->$method($eventId,$natureId,$isArchive='f');
	}else{
		$this->$method($eventId,$natureId,$launchEventId,$sessionId);
	}
}

function eventwithlaunch($method='eventwithlaunchdetail',$thisId='',$natureId=4,$launchEventId=0,$sessionId=0){		
	$this->$method($thisId,$natureId,$launchEventId,$sessionId);
}

function launchwithevent($method='eventwithlaunchdetail',$thisId='',$natureId=4,$launchEventId=0,$sessionId=0){	
	$this->$method($thisId,$natureId,$launchEventId,$sessionId);
}

public function stepper()
{ 
	//$this->template->load('template','stepper');
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true
		  );
	$leftView='dashboard/help_performancesevents';
	$data['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','stepper',$data);
	
}

/** Event Promotional Video **/

public function eventPromoVideo($eventId=0)
{ 
	$eventPromoVideo['label'] = $this->lang->language;
	$eventPromoVideo['variables'] = $this->lib_event->getValues();		
	$eventPromoVideo['eventId'] = $eventId;
	//echo '<pre />eventPromoVideo';print_r($eventPromoVideo);
	//echo '<pre />eventPromoVideo';print_r($eventPromoVideo);
	//$this->template->load('template','event_promo_video',$eventPromoVideo);
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true
		  );
	$leftView='dashboard/help_performancesevents';
	$eventPromoVideo['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event_promo_video',$eventPromoVideo);
}

/** Loads common menu for giving option for event related pages **/
public function menuNavigation($navArray=array('EventId'=>0,'NatureId'=>1))
{	
	$navArray['label'] = $this->lang->language; 
	$this->load->view('navigation_menu',$navArray);
}

/** Loads index menu **/
public function indexNavigation($eventTitle='')
{
	$nav['label'] = $this->lang->language; 	
	$data['eventTitle'] = $eventTitle;
	$this->load->view('index_navigation_menu',$data);
}



/** Loads Event Listing for all the events according to sections View **/
function eventsLeftSection($sectionArray)
{	
	$this->load->view('events_left_section',$sectionArray);
}

function eventsLeftSubSection($natureId=1,$activeEventId=0,$isArchive='f'){
	$userId=$this->userId;	
	$eventLeftListData['userId'] = $userId;
	$eventLeftListData['isArchive'] = $isArchive;
	$eventLeftListData['natureId'] = $natureId;
	$eventLeftListData['activeEventId'] = $activeEventId;
	$eventLeftListData['leftListData'] =  $this->lib_event->eventLeftList($natureId,$userId,$isArchive);
	//echo '<pre />';print_r($eventLeftListData['leftListData']);
	//echo '<br />'.$this->db->last_query();
	if($natureId ==1) $eventLeftListData['eventLabel'] = $this->lang->line('eventHeadingNotificationIndex');
	if($natureId ==2) $eventLeftListData['eventLabel'] = $this->lang->line('eventsHeadingIndex');
	if($natureId ==3) $eventLeftListData['eventLabel'] = $this->lang->line('launchHeadingIndex');
	if($natureId ==4) $eventLeftListData['eventLabel'] = $this->lang->line('eventHeadingWithLaunchIndex');
	$this->load->view('events_left_sub_section',$eventLeftListData);	
}

/** Loads Event List View **/
function eventdetail($eventId=0,$natureId=0,$nextId=0,$isArchive='f')
{	
	$userId=$this->userId;
	//If event record not exist then redirect to nofound page
	if(isset($eventId) && !empty($eventId) && isset($userId)){
		$userDataWhere = array('EventId'=>$eventId,'tdsUid'=>$userId);
		checkUsersProjects('Events',$userDataWhere);
	}
		
	if($isArchive !== 't'){ $isArchive = 'f';}
	$userId=$this->userId;
	$currentEventDetail['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 ))){ 
		
	}else{
		redirect('dashboard/performancesevents');
	}
	$eventDetail['label'] = $this->lang->language;
	$thisNatureId = 2;
	$isPublished='';
	$eventDetail['eventData'] =  $this->lib_event->getValueToUpdateEvent($eventId,$thisNatureId,$isPublished,$userId,$isArchive);
	$entityId = getMasterTableRecord('Events');
	$currentEventDetail = $eventDetail['eventData'];
	$currentEventId = ($eventId>0)?$eventId:0;
	$currentEventDetail['entityId'] =  $entityId;
	$currentEventDetail['eventId'] =  $currentEventId;
	$currentEventDetail['userId'] =   $userId;
	$currentEventDetail['isArchive'] =  $isArchive;
	$currentEventDetail['userContainerId'] =  $eventDetail['eventData']['userContainerId'];
	$primaryTable = 'MeetingPoint';
	$primaryKeyForTable = 'event_id';
	$currentDateTime= currntDateTime();
	//$whereCountEventSession = array($primaryKeyForTable=>$currentEventId,'created_date >='=>$currentDateTime);
	$whereCountEventSession = array($primaryKeyForTable=>$currentEventId);
	$currentEventDetail['meetingPoint'] =  $countMeetingPoint = $this->model_common->countResult($primaryTable,$whereCountEventSession,'',1);
	
	$countSessionsForSale =0;
	if($eventDetail['eventData']){
		$countSessionsForSale = $this->model_common->countResult('EventSessions',array('eventId'=>$eventDetail['eventData']['EventId'],'eventSellstatus'=>'t'),'',1);
	}
	
	$currentEventDetail['sellstatus'] = ($countSessionsForSale > 0)?true:false;
	
	$breadcrumbItem=array('performancesnevents','eventsindex');
	$breadcrumbURL=array('event/eventnotifications/','event/events/eventdetail/'.$eventId);
	if($isArchive == 't'){
		$breadcrumbItem[]='deletedItems';
		$breadcrumbURL[]='event/events/deletedItems';
	}
	$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
	$currentEventDetail['breadcrumbString']=$breadcrumbString;
	//$this->template->load('template','normal_event_detail',$currentEventDetail);
	
	$leftData=array(
				'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
				'isDashButton'=>true,
				'isEvent'=>1
		  );
	$leftView='dashboard/help_performancesevents';
	$currentEventDetail['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','normal_event_detail',$currentEventDetail);
}

function launchdetail($launchEventId=0,$natureId=3,$isArchive='f')
{		
	if($isArchive !== 't'){ $isArchive = 'f';}
	$userNavigations=$this->model_common->userNavigations($this->userId,false);
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 ))){ 
		
	}else{
		redirect('dashboard/performancesevents');
	}
	$userId=$this->userId;
	
	//If launch record not exist then redirect to nofound page
	if(isset($launchEventId) && !empty($launchEventId) && isset($userId)){
		$userDataWhere = array('LaunchEventId'=>$launchEventId,'tdsUid'=>$userId);
		checkUsersProjects('LaunchEvent',$userDataWhere);
	}
	
	$launchNatureId = 3;
	$isPublished='';
	$eventDetail['label'] = $this->lang->language;
	
	$eventDetail['launchEventData'] =  $this->model_event->getLaunchEvent($launchEventId,$launchNatureId,$this->userId,$isPublished,0,$isArchive);
	
	$launchEventDetail = isset($eventDetail['launchEventData'][0])?$eventDetail['launchEventData'][0]:false;
	$launchEventDetail['userNavigations'] = $userNavigations;
	$launchEventDetail['entityId'] = $entityId = getMasterTableRecord('LaunchEvent');
	$primaryTable = $this->db->dbprefix('MeetingPoint');
	$primaryKeyForTable = 'launch_id';
	$launchEventDetail['meetingPoint'] =  $countMeetingPoint= $this->model_common->countResult($primaryTable,$primaryKeyForTable,$entityId,1);
	$launchEventDetail['userId'] =   $userId;
	$launchEventDetail['launchEventId'] =  $launchEventId;
	$launchEventDetail['natureId'] =  $natureId;
	$launchEventDetail['isArchive'] =  $isArchive;
	$launchEventDetail['userContainerId'] =  $eventDetail['launchEventData'][0]['userContainerId'];
	$countSessionsForSale =0;
	
	if(isset($launchEventDetail['LaunchEventId']) && $launchEventDetail['LaunchEventId'] > 0){
		$countSessionsForSale = $this->model_common->countResult('EventSessions',array('launchEventId'=>$launchEventDetail['LaunchEventId'],'eventSellstatus'=>'t'),'',1);
	}
	
	$launchEventDetail['sellstatus'] = ($countSessionsForSale > 0)?true:false;
	
	$breadcrumbItem=array('performancesnevents','launchesindex');
	$breadcrumbURL=array('event/eventnotifications/','event/launch/launchdetail/'.$launchEventId);
	if($isArchive == 't'){
		$breadcrumbItem[]='deletedItems';
		$breadcrumbURL[]='event/events/deletedItems';
	}
	$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
	$launchEventDetail['breadcrumbString']=$breadcrumbString;
	//$this->template->load('template','launch_detail',$launchEventDetail);		
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true,
					'isEvent'=>1
		  );
	$leftView='dashboard/help_performancesevents';
	$launchEventDetail['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','launch_detail',$launchEventDetail);	
}

function eventwithlaunchdetail($eventId=0,$natureId=4,$isArchive='f')
{			
	if($isArchive !== 't'){ $isArchive = 'f';}
	$userNavigations=$this->model_common->userNavigations($this->userId,false);
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 ))){ 
		
	}else{
		redirect('dashboard/performancesevents');
		
	}
	$userId=$this->userId;

	//If event record not exist then redirect to nofound page
	if(isset($eventId) && !empty($eventId) && isset($userId)){
		$userDataWhere = array('EventId'=>$eventId,'tdsUid'=>$userId);
		checkUsersProjects('Events',$userDataWhere);
	}
	$isPublished='';
	
	$eventDetail =  $this->lib_event->getValueToUpdateEvent($eventId,$natureId,$isPublished,$userId,$isArchive);
	
	$eventDetail['userId']=$userId;
	$eventDetail['isArchive']=$isArchive;
	$eventDetail['userNavigations']=$userNavigations;
	
	$addInfoArray = array('tableName'=>'LaunchEvent');
			
	$fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	foreach ($fields as $field)
	{
		$addInfoArray['fieldKeys'][] = $field;
	} 

	$addInfoObject = new lib_additional_info($addInfoArray);
	
	$eventDetail['launchEventData'] = $this->model_common->getDataFromTabel($addInfoArray['tableName'],'LaunchEventId,userContainerId','EventId',$eventId,'','',1,0,true);

	if(is_array($eventDetail['launchEventData']) && count($eventDetail['launchEventData'])>0)
	{
		$eventDetail['launchEventData'] = $eventDetail['launchEventData'][0];
		$eventDetail['userContainerId'] = $eventDetail['launchEventData']['userContainerId'];
	}
	
	$eventDetail['label'] = $this->lang->language;
	$eventDetail['entityId'] = $entityId = getMasterTableRecord('Events');
	$primaryTable = $this->db->dbprefix('MeetingPoint');
	$primaryKeyForTable = 'event_id';
	$eventDetail['meetingPoint'] =  $countMeetingPoint = $this->model_common->countResult($primaryTable,$primaryKeyForTable,$eventId,1);
	
	
	$countSessionsForSale =0;
	if(isset($eventDetail['EventId']) && $eventDetail['EventId'] >0 ){
		$countSessionsForSale = $this->model_common->countResult('EventSessions',array('eventId'=>$eventDetail['EventId'],'eventSellstatus'=>'t'),'',1);
	}
	$eventDetail['sellstatus'] = ($countSessionsForSale > 0)?true:false;
	
	$breadcrumbItem=array('performancesnevents','eventwithlaunchindex');
	$breadcrumbURL=array('event/eventnotifications/','event/eventwithlaunch/eventwithlaunchdetail/'.$eventId);
	$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
	$eventDetail['breadcrumbString']=$breadcrumbString;
	//$this->template->load('template','event_with_launch',$eventDetail);	
	
	$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
	$leftView='dashboard/help_performancesevents';
	$eventDetail['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event_with_launch',$eventDetail);
		
}

function eventlaunchdetail($eventId=0,$natureId=4,$isArchive='f')
{	
	//echo 'launchEventId'.$launchEventId;
	if($isArchive !== 't'){ $isArchive = 'f';}
	$userNavigations=$this->model_common->userNavigations($this->userId,false);
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 ))){ 
		
	}else{
		redirect('dashboard/performancesevents');
	}
	
	$userId=$this->userId;

	//If event record not exist then redirect to nofound page
	if(isset($eventId) && !empty($eventId) && isset($userId)){
		$userDataWhere = array('EventId'=>$eventId,'tdsUid'=>$userId);
		checkUsersProjects('Events',$userDataWhere);
	}
	$launchNatureId = 4;
	$isPublished='';
	$launchEventId=0;
	$eventDetail['label'] = $this->lang->language;
	if($eventId>0)
	{
		$eventDetail['launchEventData'] =  $this->model_event->getLaunchEvent($launchEventId,$launchNatureId,$userId,$isPublished,$eventId,$isArchive);	
		if(isset($eventDetail['launchEventData'][0])){
			$launchEventId=$eventDetail['launchEventData'][0]['LaunchEventId'];
			$launchEventDetail = $eventDetail['launchEventData'][0];
		}
	}
	$launchEventDetail['userContainerId'] = $eventDetail['launchEventData'][0]['userContainerId'];
	$launchEventDetail['userNavigations'] = $userNavigations;
	$launchEventDetail['LaunchEventId'] = $launchEventId;
	$launchEventDetail['EventId'] = $eventId;
	$launchEventDetail['NatureId'] = $launchNatureId;
	$launchEventDetail['userId']=$userId;
	$launchEventDetail['entityId'] = $entityId = getMasterTableRecord('LaunchEvent');
	$launchEventDetail['isArchive']=$isArchive;
	
	//if any post value is there for NatureId and EntityId else default value will be there
	
	
	
	$primaryTable = 'MeetingPoint';
	$primaryKeyForTable = 'launch_id';
	$launchEventDetail['meetingPoint'] =  $countMeetingPoint = $this->model_common->countResult($primaryTable,$primaryKeyForTable,$launchEventDetail['LaunchEventId'] ,1);
	
	$countSessionsForSale =0;
	if(isset($launchEventId) && $launchEventId > 0){
		$countSessionsForSale = $this->model_common->countResult('EventSessions',array('launchEventId'=>$launchEventId['launchEventId'],'eventSellstatus'=>'t'),'',1);
	}
	
	$launchEventDetail['sellstatus'] = ($countSessionsForSale > 0)?true:false;
	
	$breadcrumbItem=array('performancesnevents','launchwithevent');
	$breadcrumbURL=array('event/eventnotifications/','event/launchwithevent/eventlaunchdetail/'.$launchEventId);
	$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
	$launchEventDetail['breadcrumbString']=$breadcrumbString;
	//$this->template->load('template','event_launch_detail',$launchEventDetail);
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true,
					'isEvent'=>1
		  );
	$leftView='dashboard/help_performancesevents';
	$launchEventDetail['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event_launch_detail',$launchEventDetail);		
}



function sessionlist($sessionArray=array())
{	
	$addInfoArray = array('tableName'=>'EventSessions');
	$elementId = @$sessionArray['elementId'];
	$launchEventId = @$sessionArray['launchEventId'];
	$entityType = @$sessionArray['entityType'];//eventid,launchEventId
	$launchEventEntity = @$sessionArray['launchEventEntity'];//eventid,launchEventId
	
	//capturing table Id from costant defined file using tableName		
	$fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	foreach ($fields as $field)	$addInfoArray['fieldKeys'][] = $field; 

	$addInfoObject = new lib_additional_info($addInfoArray) ;
			
	//if($launchEventEntity == '') $whereArray = array($entityType=>$elementId,'launchEventId'=>0);
	
	if($elementId!=0) {$whereArray = array($entityType=>$elementId);$ticketWhereArray = array(ucfirst($entityType)=>$elementId);}
	if($launchEventEntity != ''&& $elementId==0) {$whereArray = array($launchEventEntity=>$launchEventId);$ticketWhereArray = array(ucfirst($entityType)=>$elementId);}
	if($launchEventEntity != '' && $elementId!=0) {$whereArray = array($entityType=>$elementId,$launchEventEntity=>Null);$ticketWhereArray = array(ucfirst($entityType)=>$elementId);}
	//echo $launchEventEntity.':'.$elementId.'whereArray:<pre />';print_r($whereArray);die;
	$orderBy = array('position' => 'ASC');
	
	$addInfoData = $addInfoObject->listAdditionalInfo($whereArray,$orderBy,$limit=0);
		 
	$finalListing['sesTimes'] = $addInfoData;	
	
	$masTktArray = array('tableName'=>'Tickets');
	
	//capturing table Id from costant defined file using tableName			
	$masTkflds = $this->db->list_fields($this->db->dbprefix($masTktArray['tableName']));

	foreach ($masTkflds as $field)
	{
		$masTktArray['fieldKeys'][]=$field;
	} 
	
	$masTktObject = new lib_additional_info($masTktArray) ;
	
	$orderTicketsBy = array('TicketCategoryId'=>'asc');
	$masTktData = $masTktObject->listAdditionalInfo($ticketWhereArray,$orderTicketsBy,$limit=0,1);
	$finalListing['Tickets'] =	$masTktData;
	$finalListing['editSessionUrl'] = @$sessionArray['editSessionUrl'];
	$finalListing['isArchive'] = @$sessionArray['isArchive'];
	$finalListing['isBlocked'] = @$sessionArray['isBlocked'];
	$finalListing['isExpired'] = @$sessionArray['isExpired'];
	$finalListing['userId'] = $this->userId;
	$this->load->view('session_detail',$finalListing);	
}



/** Loads Event List View **/
function deletedItems($eventId=0,$natureId=2,$nextId=0)
{		$isArchive='t';
		$mathod=$this->router->fetch_method();
		if($natureId==2){
			$this->eventdetail($eventId,$natureId,$nextId,$isArchive);
		}elseif($natureId==3){
			$this->launchdetail($eventId,$natureId,$isArchive);
		}
		elseif($natureId==4 && $mathod=='launchwithevent'){
			$this->eventlaunchdetail($eventId,$natureId,$isArchive);
		}elseif($natureId==4){
			$this->eventwithlaunchdetail($eventId,$natureId,$isArchive);
		}
		else{
		$userId =0;
		$flag= $this->input->post('flag');
		$itemNatureId = $this->input->post('NatureId'); 
		$isPublished = '';
		$isArchive='t';
		$eventListData['label'] = $this->lang->language;
		$eventListData['itemNatureId'] =  $itemNatureId;
		$eventListData['listData'] =  $this->lib_event->eventList($itemNatureId,$userId,$isPublished,$isArchive);
		
		$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_performancesevents';
			$eventListData['leftContent']=$this->load->view($leftView,$leftData,true);
			
		if($flag==1)
			//$this->template->load('template','deleted_launch_detail',$eventListData);	
			$this->template->load('backend_template','deleted_launch_detail',$eventListData);
		else
			//$this->template->load('template','deleted_event_detail',$eventListData);
			$this->template->load('backend_template','deleted_event_detail',$eventListData);
		}						
}	


/** Loads Event Launch List View **/

function eventLaunchList()
{	
	$eventListData['label'] = $this->lang->language;
	$eventListData['listData'] =  $this->lib_event->eventList(4);
	//$this->template->load('template','event_list',$eventListData);	
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true
		  );
	$leftView='dashboard/help_performancesevents';
	$eventListData['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event_list',$eventListData);
}


/**
  * Loads the form get used in Event Notification, Event, Event With Launch
  * @params eventId
**/
public function eventform($eventId=0,$natureId=1)
{	
	$userId=$this->userId;
	//If event record not exist then redirect to nofound page
	if(isset($eventId) && !empty($eventId) && isset($userId)){
		$userDataWhere = array('EventId'=>$eventId,'tdsUid'=>$userId);
		checkUsersProjects('Events',$userDataWhere);
	}
	
	 $entityId = getMasterTableRecord('Events');
	 $catiD = getEntityCategory($entityId);	 
	 $event['catiD'] =$catiD;
	 $this->eventId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;//Checks if eventId is set or not
	 $event['eventNatureId'] = $natureId;
	 $event['countResult']=$this->model_common->countResult('Events',array('NatureId'=>1,'tdsUid'=>$this->userId));
	
	 $event['variables'] = $this->eventVar;	 
	 $event['label'] = $this->lang->language;	 
	 $event['countries'] = getCountryListById();	 
	 $event['eventIndustryList'][''] = 'Select Industry';
	 
	 $industry = loadIndustry();
	 
	foreach ($industry as $resultIndustry)  $event['eventIndustryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
	
	//If Save Starts Here
	if($this->input->post('save') == 'Save')
	{ 
		
		if($this->eventId>0) $event['data'] = $this->lib_event->getValueToUpdateEvent($this->eventId); 
		
		$this->lib_event->setEvent($this->input->post());
		$event['detailed'] = $this->lib_event->getValues();		

		foreach($event['detailed']['event'] as $k => $v)
		{
			if(isset($event['detailed']['event'][$k]) && $event['detailed']['event'][$k]!='')
			{
				$event['data'][$k] = $v;
			}
		}
		
		 $addInfoArray = array('tableName'=>'Events');
					
		 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

		 foreach ($fields as $field)
		 {
			$addInfoArray['fieldKeys'][]=$field;
		 } 
		
		 $addInfoObject = new lib_additional_info($addInfoArray) ;
		 
		 $event['data']['EventId'] = $this->eventId; //to edit required
		 $event['data']['tdsUid'] = $this->userId; //to edit required
		 $primaryKey = 'EventId';		
		
		//Defining and creating folder to upload event image
		$eventMediaPath = $this->mediaPath.$this->newEventId;

		$cmd1 = 'chmod -R 777 '.MEDIAUPLOADPATH.LoginUserDetails('username');
		exec($cmd1);
		$cmd2 = 'chmod -R 777 '. $this->mediaPath;
		exec($cmd2);
		$cmd3 = 'chmod -R 777 '. $eventMediaPath;
		exec($cmd3);

		if (!file_exists($this->mediaPath)) {
			if (!mkdir($this->mediaPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}
		
		$cmd = 'chmod -R 777 '.$this->mediaPath;
		exec($cmd);

		if (!file_exists($eventMediaPath)) {
			if (!mkdir($eventMediaPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}
		
		$cmd = 'chmod -R 777 '.$eventMediaPath;
		exec($cmd);

		$eventMediaName = '';
		//file given to upload then only call upload function

		$uploadedData = array();
		$uploadArray = $_FILES;

		//UPLOADING AND INSERTING IN MASTER MEDIA TABLE
		if(isset($uploadArray['userfile']['name']) && $uploadArray['userfile']['name']!='')
		{			
			if(isset($uploadArray['userfile']['name']))
			{
				if($uploadArray['userfile']['name'] == '')
				{
					$message= 'You did not select a file to upload';
					set_global_messages($message, 'error');
					redirect($returnUrl);
				}
				
				if($uploadArray['userfile']['name'] != '')
					$uploadedData = $this->lib_sub_master_media->do_upload($uploadArray,$eventMediaPath,$this->eventId,1);
				
				//CHECK FOR ERROR AFTER UPLOAD PROMOTIONAL VIDEO
				if(!isset($uploadedData['error']))
				{
					$fileType = $this->input->post('filetype');
				
					$data['filePath'] = $eventMediaPath;
					$data['fileName'] = $uploadedData['upload_data']['file_name'];
					$data['fileSize'] = $uploadedData['upload_data']['file_size'];
					$data['fileType'] = $fileType;
					$data['fileCreateDate'] = date("Y-m-d H:i:s");

					if($event['data']['FileId']!='')
					{
						//Get the value for Media File table to unlink the related file before update
						$mediaFileData = $this->model_common->getDataFromTabel($this->mediaFile,'filePath,fileName','fileId',$event['data']['FileId']);
						
						//Update Media Data
						$this->model_common->editDataFromTabel($this->mediaFile, $data,'fileId',$event['data']['FileId']);
						$unlinkImg = $mediaFileData[0]->filePath.'/'.$mediaFileData[0]->fileName;
						
						if(file_exists($unlinkImg))
						{
							unlink($unlinkImg);
						}
					}
					else
					{
						//Insert data into main mediaFile. get the Id of mediaFile....
						$fileId = $this->model_common->addDataIntoTabel('MediaFile', $data);
					}

					if(isset($fileId) && $fileId!='')
						$event['data']['FileId'] = $fileId;						
				}
				else
				{
					$message = $uploadedData['error'];
					set_global_messages($message, 'error');
					
					//Go back to orignal page with error					
					if(isset($_SERVER['HTTP_REFERER']))
					{
						$baclLink=$_SERVER['HTTP_REFERER'];
					}
					else
					{
						$baclLink='';
					}

					redirect($baclLink);
				}
				
			} 
		}
		else unset($event['data']['FileId']);
		
		//SETTING ACCORDING TO INSERT OR UPDATE OF RECORD
		
		if($this->eventId == 0)
		{
			$event['data']['EventDateCreated'] = date("Y-m-d H:i:s");	
			$event['data']['EventDateModified'] = date("Y-m-d H:i:s");
		}
		
		if($this->eventId > 0)
			$event['data']['EventDateModified'] = date("Y-m-d H:i:s");
		
		//------------For Making time for validation of time--------------------- 
		
		//$seconds = mktime($hours,$mins,$secs);
		
		//Converting in time format to get saved in DB
		
		//if(isset($seconds)) $event['data']['Time'] = str_pad($hours, 2, "0", STR_PAD_LEFT). ':'.str_pad($mins, 2, "0", STR_PAD_LEFT). ':'.str_pad($secs, 2, "0", STR_PAD_LEFT);
		
		$FinishDate = $this->input->post('FinishDate');
		$time = $this->input->post('eventime');
		if(@$FinishDate=='')  $FinishDate=null;
		$event['data']['FinishDate'] = $FinishDate;
		$event['data']['Time'] =$time;
		
		//------------------------------------------------------------------------
		
		//----To Save The FIELD VALUES ONLY----
		//if(isset($event['data']['filePath']))
		unset($event['data']['filePath']);
		
		//if(isset($event['data']['fileName']))
		unset($event['data']['fileName']);
		unset($event['data']['Time']);
		//echo '<pre />';print_r($event);die;
		//----INSERTING AND UPDATING ACCORDING TO DATA----
		$this->newEventId = $addInfoObject->saveAdditionalInfo($event['data'],$primaryKey,1);
		
		//--IF EVENT IS OF TYPE NOTIFICATION THEN REDIRECT TO INDEX PAGE--
		if($event['eventNatureId'] ==1) 
			redirect('event/index');
		else
		{
		 $message =$this->lang->line('workSavedSuccessfully');
		 	
		 set_global_messages($message, 'success');
		 
		 $returnUrl = "event/events/eventform/".$this->newEventId;
		 redirect($returnUrl );
		}
	}//END IF SAVE
	//-------------------------END FOR SAVE IF CONDITION-------------------------

	//----GET THE VALUE TO GET FILLED IN FORM----

	if($this->eventId > 0)
	{
		$this->lib_event->getValueToUpdateEvent($this->eventId);   
	}else{
		$sectionId=$this->input->post('sectionId');
		$this->lib_package->setUserContainerId($sectionId);
	}
	
	$getEvent = $this->lib_event->getValues();
	$event['data'] = $getEvent['event'];
	
	//FOR CREATING THE RATING DROP DOWN
	$ratingList = getRatingList();
	$event['ratingList'] = $ratingList;
	
	//-----Staring Setting Hour minute and seconds to get set in stepper of form-----
		
	if(isset($event['data']['Time']) && $event['data']['Time']!='')
		list($hour, $min, $sec) = explode(":", $event['data']['Time']);
	else 
		$hour=0; $min=0; $sec=0;
		
	if(substr($hour,0,1) ==0) $hour = substr($hour,1);
	if(substr($min,0,1) ==0) $min = substr($min,1);
	if(substr($sec,0,1) ==0) $sec = substr($sec,1);
	
	$event['hour'] = $hour;
	$event['min'] = $min;
	$event['sec'] = $sec;
	
	//----------------------End of hour,minute and second---------------------------	
	
	//Show New Date hh:mm
	if(isset($event['data']['Time']) && $event['data']['Time']!='') {
		$eventTime = explode(":", $event['data']['Time'],-1);
		$event['data']['Time'] =$eventTime[0].':'.$eventTime[1];
    }
	
	if($eventId ==0){
		$event['data']['EventId'] = $this->newEventId;
		$event['EventId'] = $this->newEventId;
	}
	
	$event['promoImagePath'] = $event['eventMediaPath'] = $this->mediaPath.$event['data']['EventId'].'/';
	
	if($event['eventNatureId'] == '') $event['eventNatureId'] = $event['data']['NatureId'];
	if($event['eventNatureId'] == 2) $event['returnBack'] = base_url('event/events/eventdetail/'.$event['data']['EventId']);	
	else if($event['eventNatureId'] == 4) $event['returnBack'] = base_url('event/eventwithlaunch/eventwithlaunchdetail/'.$event['data']['EventId']);
	else $event['returnBack'] = base_url('event/eventnotifications/notificationslist');
	
	$fileMaxSize=$this->config->item('defaultContainerSize');
	
	if(!$eventId > 0){
		$eventId=0;
	}
	$containerWhere=array('EventId'=>$eventId);
	$event['containerDetails'] = $this->model_common->getContainerDetails('Events',$containerWhere);
	if(isset($event['containerDetails'][0]['containerSize']) && $event['containerDetails'][0]['containerSize'] > 0 ){
		$containerSize=$event['containerDetails'][0]['containerSize'];
		
		$dirname=$this->mediaPath;
		$dirSize=getFolderSize($dirname);
		$remainingBytes =($containerSize - $dirSize);
		if(!$remainingBytes > 0){
			$remainingBytes =0;
		}
		
		$containerSize=bytestoMB($containerSize,'mb');
		$dirSize=bytestoMB($dirSize,'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
				$remainingSize = 0;
		}
		$dirSize = number_format($dirSize,2,'.','');
		$remainingSize = number_format($remainingSize,2,'.','');
		$fileMaxSize=$remainingBytes;
	}
	$event['fileMaxSize']= $fileMaxSize;
	$event['userId'] = $this->userId;	
	//$this->template->load('template','event',$event);
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true,
					'isEvent'=>1
		  );
	$leftView='dashboard/help_performancesevents';
	$event['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event',$event);
	
}

/**
	* Loads common menu on event related pages
**/
public function previewOption()
{
	$nav['label'] = $this->lang->language; 
	$this->load->view('preview_option',$nav);
}
	
public function getGenerList() 
{	
	$ID = $this->input->post('val1');
	$typeId = $this->input->post('val2');
	$genere = getGenerList($typeId, $ID, lang(), 'selectGenre');
	echo '<div class="bg_sel Bdr3"><span class="abc">'.$this->lang->line('selectGenre').'</span>'.form_dropdown('projGenre', $genere, set_value('projGenre'),'id="projGenre" class="required" onchange="selectBox(); addRemoveOther(this.value,\'projGenreOtherDiv\',\'projGenreOther\');"').'</div>';
}
	
/**
	* Loads Event FurtherDesc Page
	* @params eventId 
	* @params natureId
**/
function eventFurtherDesc($eventId=0,$natureId=1)
{
	$this->head->add_css($this->config->item('system_css').'upload_file.css');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
	$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');	
	
	$this->eventId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;//Checks if eventId is set or not
	
	$userId=$this->userId;
	//If event record not exist then redirect to nofound page
	if(isset($this->eventId) && !empty($this->eventId) && isset($userId)){
		$userDataWhere = array('EventId'=>$this->eventId,'tdsUid'=>$userId);
		checkUsersProjects('Events',$userDataWhere);
	}
	$imagePath = $this->mediaPath.$this->eventId.'/images/';
	
	//----NO EVENT FOR ADDING FURTHER DISCRIPTION----
	if($this->eventId ==0) redirect('event/index/0');
	
	$formType = $this->input->post('formtype');	
	
	//----To Get Used While Saving The Current Record----
	if($this->eventId>0)
	{
		$getEvent = $this->lib_event->getValueToUpdateEvent($this->eventId);			
	}
	
	$eventFurtherDesc['data'] = $getEvent;
	//--------------------------------------------
	
	//TO SET THE NATURE ID FOR CURRENT EVENT 
	$localNatureId = $this->input->post('NatureId');

	if( $localNatureId =='' && $this->natureId =='') 
	{
		$this->natureId =  $natureId;
		
		$eventFurtherDesc['eventNatureId'] = $natureId;
	}
	else 
	{
		$this->natureId =  $localNatureId;
		
		$eventFurtherDesc['eventNatureId'] =  $localNatureId;
	}
	
	$eventFurtherDesc['promoDisplayStyle'] = 'style="display:block;"';
	$eventFurtherDesc['PROMOTIONALIMAGEForm'] = 'style="display:none;"';
	$eventFurtherDesc['tableName'] = $this->eventMediaTableName;
	$eventFurtherDesc['eventId'] = $this->eventId;
	$eventFurtherDesc['variables'] = $this->eventVar;
	$eventFurtherDesc['label'] = $this->lang->language;
	
	$eventFurtherDesc['countries'] = getCountryList();	

	$config = array();
	
	if(strcmp($formType,'promoImage')==0)
	{
	
		$config = array(
			array(
					 'field'   => 'mediaTitle',
					 'label'   =>  $eventFurtherDesc['label']['title'],
					 'rules'   => 'trim|xss_clean'
			),			
		);
	}			
		
	if(strcmp($formType,'mainEvent')==0)
	{

		$config = array(
			array(
					 'field'   => 'Description',
					 'label'   =>  $eventFurtherDesc['label']['eventDescription'],
					 'rules'   => 'trim|required|xss_clean'
			),
			array(
					 'field'   => 'CompanyName',
					 'label'   =>  $eventFurtherDesc['label']['eventPromoCompanyName'],
					 'rules'   => 'trim|required|xss_clean'
			),
			array(
					 'field'   => 'FileInput',
					 'label'   =>  $eventFurtherDesc['label']['eventPromoCompanyName'],
					 'rules'   => 'trim|xss_clean'
			)
		);
	}

	$this->form_validation->set_rules($config); 
	$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red"  style="margin-left:0px;">', '</label>');
	
	
	if($this->form_validation->run())
	{	
	
	if($this->input->post('submit')=='Save')
	{ 
		//FOR SAVING BASIC INFORMATION
		if(strcmp($formType,'mainEvent')==0)
		{
			
			$this->lib_event->setEvent($this->input->post());
						
				$eventFurtherDesc['detailed'] = $this->lib_event->getValues();		
				
				foreach($eventFurtherDesc['detailed']['event'] as $k => $v)
				{
					if(isset($eventFurtherDesc['detailed']['event'][$k]) && $eventFurtherDesc['detailed']['event'][$k]!='')
					{
						$eventFurtherDesc['data'][$k] = $v;
					}
				}
				
			
			/*------------------------------------------------------------------------*/
			/*-----STARTS HERE: Defining and creating folder to upload event image----*/
			/*-------------------------------------------------------------------------*/
			
			$eventMediaPath = $this->mediaPath.$this->eventId.'/images';
			
			$cmd = 'chmod -R 777 '."media/".LoginUserDetails('username');
			exec($cmd);				
				
			$newEventMedia = $this->mediaPath.$this->eventId;
			
			$newEventMediaImg = $this->mediaPath.$this->eventId.'/images';
			
			$cmdMain = 'chmod -R 0777 '.$newEventMedia;
			exec($cmdMain);

			if(!is_dir($newEventMedia))
			{
				mkdir($newEventMedia, 777, true);
			}
			
			$cmdMain = 'chmod -R 0777 '.$newEventMedia;
			exec($cmdMain);
			
			//------------------------------------------------------------
			$cmd2 = 'chmod -R 777 '.$newEventMediaImg;
			exec($cmd2);
			
			if(!is_dir($newEventMediaImg))
			{
				mkdir($newEventMediaImg, 777, true);
			}

			$cmdSub = 'chmod -R 0777 '.$newEventMediaImg;
			exec($cmdSub);
			
			$eventMediaName = '';			

			$uploadedData = array();
			$uploadArray = $_FILES;
			
			
			//If File Exists To Get Uploaded Then Only Calls Upload Function
			if(isset($uploadArray['userfile']['name']) && $uploadArray['userfile']['name']!='')
			{ 				
			
				if($uploadArray['userfile']['name'] == '')
				{							
				  $message= 'You did not select a file to upload';
				  set_global_messages($message, 'error');
				  redirect($returnUrl);
				}
				
				if($uploadArray['userfile']['name'] != '')
				{	
				 $uploadedData = $this->lib_sub_master_media->do_upload($uploadArray,$eventMediaPath,$this->eventId,1);
				}
				//CHECK FOR ERROR AFTER UPLOAD PROMOTIONAL VIDEO
				if(!isset($uploadedData['error']))
				{
					$fileType = $this->input->post('filetype');
					$data['filePath'] = $eventMediaPath;
					$data['fileName'] = $uploadedData['upload_data']['file_name'];
					$data['fileSize'] = $uploadedData['upload_data']['file_size'];
					$data['isExternal'] = 'f';
					$data['fileType'] = $fileType;

					if($eventFurtherDesc['data']['FileId']!='')
					{
						//Get the value for Media File table to unlink the related file before update
						$mediaFileData = $this->model_common->getDataFromTabel($this->mediaFile,'filePath,fileName','fileId',$eventFurtherDesc['data']['FileId']);

						//Update Media Data
						$this->model_common->editDataFromTabel($this->mediaFile, $data,'fileId',$eventFurtherDesc['data']['FileId']);
						
						$unlinkImg = $mediaFileData[0]->filePath.'/'.$mediaFileData[0]->fileName;
						
						$fileDir=trim($mediaFileData[0]->filePath);
						$fileName=trim($mediaFileData[0]->fileName);
						if(is_dir($fileDir) && $fileName !=''){
							$fpLen=strlen($fileDir);
							if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
								$fileDir=$fileDir.DIRECTORY_SEPARATOR;
							}
							findFileNDelete($fileDir,$fileName);
						}
						
						
					}
					else
					{
						//Insert data into main mediaFile. get the Id of mediaFile....
						$data['fileCreateDate'] = date("Y-m-d H:i:s");
						$fileId = $this->model_common->addDataIntoTabel('MediaFile', $data);
						
					}

					if(isset($fileId) && $fileId!='')
						$eventFurtherDesc['data']['FileId'] = $fileId;	
						$return = "event/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
					   // redirect($return);						
				}
				else
				{					
					$message = $uploadedData['error'];
					set_global_messages($message, 'error');
					$returnUrl = "event/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
					//redirect($returnUrl);
				}		
		} 
		
		
		/*-------------------------------------------------------------------*/
		/*---ENDS HERE: Defining and creating folder to upload event image---*/
		/*-------------------------------------------------------------------*/	
		
			
		/*-------------------------------------------------------------------*/
		/*-----Start: Defining and creating folder to upload event Promotional Video-----*/
		/*-------------------------------------------------------------------*/
				
		//If VideoType 1 means Video file to upload
		
			$PromoVideoMediaPath = $this->mediaPath.$this->eventId.'/video';
			
			if(!is_dir($PromoVideoMediaPath)){
					mkdir($PromoVideoMediaPath, 777, true);
			}

			$cmdVideo = 'chmod -R 0777 '.$PromoVideoMediaPath;
			exec($cmdVideo);
			//echo '<pre />';print_r($uploadArray);
			if(isset($uploadArray['PromoVideo']['name']) && $uploadArray['PromoVideo']['name']!='')
			{
					$promoVideoFileType = 2;
					
					if($uploadArray['PromoVideo']['name'] == '')
					{
						$message= 'You did not select a file to upload';
						set_global_messages($message, 'error');
						redirect($returnUrl);
					}
					
					if($uploadArray['PromoVideo']['name'] != '')
					{	
						$uploadedVideo = $this->lib_sub_master_media->do_upload($uploadArray,$PromoVideoMediaPath,$this->eventId,$promoVideoFileType,'PromoVideo');
					}				
					
					//CHECK FOR ERROR AFTER UPLOAD PROMOTIONAL VIDEO
					if(!isset($uploadedVideo['error']))
					{
						//Saving the Video File Information in Master Media Table And Last inserted fileId is fetched 
						$videoData['filePath'] = $PromoVideoMediaPath;
						$videoData['fileName'] = $uploadedVideo['upload_data']['file_name'];
						$videoData['fileSize'] = $uploadedVideo['upload_data']['file_size'];
						$videoData['fileType'] = $promoVideoFileType;
						
												
						if($eventFurtherDesc['data']['PromoVideoFileId']!='')
						{
							//Update Media Data
							$this->model_common->editDataFromTabel('MediaFile', $videoData,'fileId',$eventFurtherDesc['data']['PromoVideoFileId']);
							
							$fileDir=trim($PromoVideoMediaPath);
							$fileName=trim($eventFurtherDesc['data']['PromoVideo']);
							if(is_dir($fileDir) && $fileName !=''){
								$fpLen=strlen($fileDir);
								if($fpLen > 0 && substr($fileDir,-1) != DIRECTORY_SEPARATOR){
									$fileDir=$fileDir.DIRECTORY_SEPARATOR;
								}
								findFileNDelete($fileDir,$fileName);
							}
						}
						else
						{
							//Insert data into main mediaFile. get the Id of mediaFile....
							$videoData['fileCreateDate'] = date("Y-m-d H:i:s");
							$PromoVideoFileId = $this->model_common->addDataIntoTabel('MediaFile', $videoData);
						}
						
						if(isset($PromoVideoFileId) && $PromoVideoFileId!='')						
							$eventFurtherDesc['data']['PromoVideoFileId'] = $PromoVideoFileId;	
						
					}
					else
					{
						$message = $uploadedVideo['error'];
						set_global_messages($message, 'error');
						$returnUrl = "event/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
						redirect($returnUrl);
					}
					
			}
			else 
			{
				//----IF EXTERNAL URL TO GET SAVED----
				$externalEmdebData = $this->input->post('EmbedPromoVideo');
				
				if(isset($externalEmdebData) && $externalEmdebData!='')
				{
					$videoEmbedData['filePath'] = $externalEmdebData;
					$videoEmbedData['isExternal'] = 'f';
					$videoEmbedData['fileName'] = '';
					$videoEmbedData['fileSize'] = 0;
					

					if($eventFurtherDesc['data']['PromoVideoFileId']!='')
					{						
						//Update Media Data 
						$this->model_common->editDataFromTabel($this->mediaFile, $videoEmbedData,'fileId',$eventFurtherDesc['data']['PromoVideoFileId']);
					}
					else
					{						
						//Insert data into main mediaFile. get the Id of mediaFile....
						$videoEmbedData['fileCreateDate'] = date("Y-m-d H:i:s");
						$PromoVideoFileId = $this->model_common->addDataIntoTabel($this->mediaFile, $videoEmbedData);
					}

					if(isset($PromoVideoFileId) && $PromoVideoFileId!='')
						$eventFurtherDesc['data']['PromoVideoFileId'] = $PromoVideoFileId;	
				}
			}
				
		/*-------------------------------------------------------------------------------*/
		/*-----Ends: Defining and creating folder to upload event Promotional Video------*/
		/*-------------------------------------------------------------------------------*/	
		    //$eventFurtherDesc['data']['Image']= $eventMediaPath.'/'.$this->input->post('FileInput');
			$eventFurtherDesc['data']['EventId']= $this->eventId; //to edit required
			//echo '<pre />';	print_r($eventFurtherDesc['data']);die;
			$this->lib_event->saveEvent($eventFurtherDesc['data']);
			$returnUrl = "event/events/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
			redirect($returnUrl);
			
			//print_r($data);
			//echo $this->db->last_query();
			//die;
			
		}	
		
	//promoImage Form	
		if(strcmp($formType,'promoImage')==0){

			$fileType = $this->input->post('fileType');			
			$eventPromoMediaVal['mediaId'] = $this->input->post('mediaId');
			$eventPromoMediaVal['mediaType'] = $this->input->post('fileType');
			$eventPromoMediaVal['mediaTitle'] = $this->input->post('mediaTitle');
			$eventPromoMediaVal['mediaDescription'] = $this->input->post('mediaDescription');
			$eventPromoMediaVal['launchEventId'] = $this->input->post('LaunchEventId');
			$eventPromoMediaVal['eventId'] = $this->eventId;			
			$eventPromoMediaVal['mediaPath'] = $imagePath;
			
			$returnUrl = "event/events/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
			$uploadArray = $_FILES;
			
			//making folders to upload event Promo images
			
			if(!is_dir($this->mediaPath)){
				mkdir($this->mediaPath, 777, true);
			}			
			$cmdMain = 'chmod -R 0777 '.$this->mediaPath;
			exec($cmdMain);
			
			$newEventMedia = $this->mediaPath.$this->eventId;
		
			$cmdMain = 'chmod -R 0777 '.$newEventMedia;
			exec($cmdMain);

			if(!is_dir($newEventMedia)){
				mkdir($newEventMedia, 777, true);
			}
			
			$cmdMain = 'chmod -R 0777 '.$newEventMedia;
			exec($cmdMain);
			
			$cmd2 = 'chmod -R 777 '.$this->mediaPath.$this->eventId.'/images';
			exec($cmd2);

			if(!is_dir($imagePath)){
				mkdir($imagePath, 777, true);
			}

			$cmdSub = 'chmod -R 0777 '.$imagePath;
			exec($cmdSub);
			
			
			saveUploadPromoMedia($this->eventMediaTableName,$this->promoMediaField,$eventPromoMediaVal,$imagePath,$uploadArray,$this->eventId,$fileType,$returnUrl,$this->ImgConfig);
			
			//redirect($returnUrl);
		}//end if(strcmp($formType,'promoImage')==0)
	
	}//end if save	
	}
	else
	{		
		if(validation_errors())
		{			
			$eventFurtherDesc['PROMOTIONALIMAGEForm'] = 'style="display:block;"';
			$eventFurtherDesc['mediaId'] = $this->input->post('mediaId');
			$eventFurtherDesc['mediaType'] = $this->input->post('fileType');
			$eventFurtherDesc['mediaTitle'] = $this->input->post('mediaTitle');
			$eventFurtherDesc['mediaDescription'] = $this->input->post('mediaDescription');
			$eventFurtherDesc['launchEventId'] = $this->input->post('LaunchEventId');
			$eventFurtherDesc['eventId'] = $this->eventId;
			$eventFurtherDesc['fileType'] = $this->input->post('fileType');
			$returnUrl = "event/events/eventFurtherDesc/".$this->eventId.'/'.$this->natureId;
			 $msg = array('errors' => validation_errors());	
			 $data['values']['save'] = '';			
		}			
	}

	$ImgConfig = $this->lib_image_config->getImgConfigValue();
	$orderBy = '';

	$eventFurtherDesc['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoMediaField,'eventId',$this->eventId,1,$orderBy);
	//Passing the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause

	$eventFurtherDesc['mediaType'] = $this->ImgConfig['mediaConfig']['mediaType'];

	$eventFurtherDesc['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->eventMediaTableName,'eventId',$this->eventId,1,'');	
	
	$eventFurtherDesc['tableId'] = getMasterTableRecord($this->eventTableName);
	$eventFurtherDesc['recordId'] = $this->eventId;
	$eventFurtherDesc['returnUrl'] = "event/events/eventFurtherDesc/".$this->eventId.'/'.$natureId;
	$eventFurtherDesc['data'] = $getEvent;		
	
	//New code starts			
	$eventPromotionalImages['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
	$eventPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoImageField,'eventId',$this->eventId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
	$eventPromotionalImages['promoElementTable'] = $this->eventMediaTableName;
	$eventPromotionalImages['eventId'] = $this->eventId;
	$eventPromotionalImages['entityMediaType'] = 'mediaEvent';
	$eventPromotionalImages['header'] = $this->load->view('navigation_menu',$eventPromotionalImages,true);
	$eventFurtherDesc['promoElementTable'] = $this->eventMediaTableName;
	$eventFurtherDesc['promoElementFieldId'] = 'mediaId';
	$eventPromotionalImages['promoImageId'] = $this->eventId;
	$eventFurtherDesc['promoImagePath'] = $imagePath;
	$eventPromotionalImages['label'] = $this->lang->language;
	$eventPromotionalImages['promoEntityField'] = $eventFurtherDesc['promoEntityField'] = 'eventId';
	$eventPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultEventImg_s');
	$eventFurtherDesc['eventPromotionalImages'] = $eventPromotionalImages;
	$eventFurtherDesc['promoElementTable'] = $this->eventMediaTableName;
	$eventFurtherDesc['promoImagePath'] = $imagePath;
	$eventFurtherDesc['entityId'] = $this->eventId;
	
	$eventFurtherDesc['browseImgJs'] = '_imgJs';
	$eventFurtherDesc['promoImageId'] = $this->eventId;	
	
	
	$fileMaxSize=$this->config->item('defaultContainerSize');
	if(!$eventId > 0){
		$eventId=0;
	}
	

	$containerWhere=array('EventId'=>$eventId);
	$eventFurtherDesc['containerDetails'] = $this->model_common->getContainerDetails('Events',$containerWhere);
	if(isset($eventFurtherDesc['containerDetails'][0]['containerSize']) && $eventFurtherDesc['containerDetails'][0]['containerSize'] > 0 ){
		
		$containerSize=$eventFurtherDesc['containerDetails'][0]['containerSize'];

		$dirname=$this->mediaPath.$eventId.'/';
		$dirSize=getFolderSize($dirname);
		
		if($natureId==4){ // in case of launch with event also get used size of associted launch
			$LaunchEventData=$this->model_common->getDataFromTabel('LaunchEvent', 'LaunchEventId',  array('EventId'=>$eventId), '', '', '', 1 );
			if(isset($LaunchEventData[0]->LaunchEventId) && $LaunchEventData[0]->LaunchEventId >0){
				$dirUploadLaunch=$this->launchMediaPath.$LaunchEventData[0]->LaunchEventId.'/';
				if(is_dir($dirUploadLaunch)){
					$dirSize=($dirSize+getFolderSize($dirUploadLaunch));
				}
			}
		}
		
		
		$remainingBytes =($containerSize - $dirSize);
		if(!$remainingBytes > 0){
			$remainingBytes =0;
		}
		
		$containerSize=bytestoMB($containerSize,'mb');
		$dirSize=bytestoMB($dirSize,'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
				$remainingSize = 0;
		}
		$dirSize = number_format($dirSize,2,'.','');
		$remainingSize = number_format($remainingSize,2,'.','');
		$fileMaxSize=$remainingBytes;
	}
	$eventFurtherDesc['fileMaxSize']= $fileMaxSize;
	$eventFurtherDesc['userId'] = $this->userId;		
	
	//New code ends	
	//$this->template->load('template','event_furtherDesc',$eventFurtherDesc);	
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true
		  );
	$leftView='dashboard/help_performancesevents';
	$eventFurtherDesc['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','event_furtherDesc',$eventFurtherDesc);
}
	
	/**
	* Loads Session Time Form on page
	**/	

	function eventsession($eventId=0,$sessionId=0)
	{	
			
		$this->eventId = $this->input->post('eventId')>0?$this->input->post('eventId'):$eventId; //Checks if eventId is set or not	
		$this->natureId = $this->input->post('NatureId')>0?$this->input->post('NatureId'):0; //Checks if eventId is set or not
		$userId=$this->userId;
		//If event record not exist then redirect to nofound page
		if(isset($this->eventId) && !empty($this->eventId) && isset($userId)){
			$userDataWhere = array('EventId'=>$this->eventId,'tdsUid'=>$userId);
			checkUsersProjects('Events',$userDataWhere);
		}
		$eventSessionTime['eventId'] = $this->eventId;	
		$eventSessionTime['label'] = $this->lang->language;	
		$eventSessionTime['tableId'] = getMasterTableRecord($this->eventTableName);		
		$eventSessionTime['countries'] = getCountryListById();
		$thisSessionId = $this->input->post('currentSessionId')>0?$this->input->post('currentSessionId'):$sessionId;	
		$currentSessionId = (isset($thisSessionId) && $thisSessionId!='' && $thisSessionId>0)?$thisSessionId:'addsession'; //Checks if sessionId is set or not
		$eventSessionTime['sessionId'] = $currentSessionId;	
		$eventSessionTime['entityId'] = $entityId = getMasterTableRecord('EventSessions');
		$eventSessionTime['moduleMethod']='eventsession';
		$eventSessionTime['eventNatureId'] = $this->natureId;
		//echo '<pre />';print_r($eventSessionTime);
		//die;
		//$this->template->load('template','event/event_session_time',$eventSessionTime);	
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isEvent'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$eventSessionTime['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','event/event_session_time',$eventSessionTime);
	}

	/**
		* Loads Session Time Form on page
	**/	
		
	function launchsession($launchEventId=0,$natureId=3,$eventId=0,$sessionId=0)
	{
		$userId=$this->userId;
		//If launch record not exist then redirect to nofound page
		if(isset($launchEventId) && !empty($launchEventId) && isset($userId)){
			$userDataWhere = array('LaunchEventId'=>$launchEventId,'tdsUid'=>$userId);
			checkUsersProjects('LaunchEvent',$userDataWhere);
		}
		$EventIdArray = getDataFromTabelCommon('LaunchEvent','EventId','LaunchEventId',$launchEventId);
	
		
		$sessionArray = getDataFromTabelCommon('EventSessions','sessionId','launchEventId',$launchEventId);
		if(is_array($sessionArray) && !empty($sessionArray)) $this->sessionId= $sessionArray[0]->sessionId;
		else $this->sessionId = $this->input->post('sessionId')>0?$this->input->post('sessionId'):'addsession'; //Checks if eventId is set or not
		
		
		if(is_array($EventIdArray) && !empty($EventIdArray)) $eventLaunchSession['eventId']= $EventIdArray[0]->EventId;
		else $eventLaunchSession['eventId'] = 0;
		
		
		$eventLaunchSession['label'] = $this->lang->language;	
		$eventLaunchSession['tableId'] = getMasterTableRecord($this->eventTableName);		
		$eventLaunchSession['countries'] = getCountryListById();
		$eventLaunchSession['eventNatureId'] = $natureId;
		$eventLaunchSession['launchEventId'] = $launchEventId;
		$eventLaunchSession['sessionId'] = $this->sessionId;
		$eventLaunchSession['entityId'] = $entityId = getMasterTableRecord('EventSessions');
		$eventLaunchSession['moduleMethod']='launchsession';

		//$this->template->load('template','event/launch_session_time',$eventLaunchSession);	
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isEvent'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$eventLaunchSession['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','event/launch_session_time',$eventLaunchSession);

	}	
	
	function launchpromomaterial($launchEventId=0,$natureId=3,$eventId=0)
	{			
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		if(empty($launchEventId)){
			redirect('event/launch/launchDetail');
		}
		$userId=$this->userId;
		//If launch record not exist then redirect to nofound page
		if(isset($launchEventId) && !empty($launchEventId) && isset($userId)){
			$userDataWhere = array('LaunchEventId'=>$launchEventId,'tdsUid'=>$userId);
			checkUsersProjects('LaunchEvent',$userDataWhere);
		}
		//$this->eventId = $this->input->post('eventId')>0?$this->input->post('eventId'):$eventId; //Checks if eventId is set or not
		$EventIdArray = getDataFromTabelCommon('LaunchEvent','EventId,Type,LaunchEventCreated','LaunchEventId',$launchEventId);
		//echo '<pre />';print_r($EventIdArray);die;
		if(is_array($EventIdArray) && !empty($EventIdArray)){
			$eventPromoMaterial['EventId'] = $navArray['EventId']= $EventIdArray[0]->EventId;
				
			if(@$EventIdArray[0]->Type == 1 || @$EventIdArray[0]->Type == '') $LiveOrOnline = 'Live';
			if(@$EventIdArray[0]->Type == 2) $LiveOrOnline = 'Online';
			$eventPromoMaterial['LaunchType'] = $LiveOrOnline;
		 }
		else {
			$eventPromoMaterial['EventId'] = $navArray['EventId'] = 0;	
			$eventPromoMaterial['LaunchType'] = '';
		}
		if($eventId==0){
			$eventId=$eventPromoMaterial['EventId'];
		}
		
		
		
		$eventPromoMaterial['label'] = $this->lang->language;	
		$eventPromoMaterial['tableName'] = $this->eventMediaTableName;		
		$eventPromoMaterial['LaunchEventCreated'] = $EventIdArray[0]->LaunchEventCreated;	
		$eventPromoMaterial['eventNatureId'] = $navArray['NatureId'] = $natureId;
		$eventPromoMaterial['entityId'] = $eventPromoMaterial['promoImageId'] = $eventPromoMaterial['LaunchEventId'] = $launchEventId;
		$eventPromoMaterial['promoElementTable'] = $this->eventMediaTableName;
		$eventPromoMaterial['promoElementFieldId']='mediaId';
		$orderBy = 'isMain';
		$eventPromoMaterial['mediaType'] = $this->ImgConfig['mediaConfig']['mediaType'];
		$eventPromoMaterial['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoImageField,'launchEventId',$launchEventId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		$eventPromoMaterial['eventPromoImages']['defaultImage'] = $this->config->item('defaultEventImg_s');
		$eventPromoMaterial['entityMediaType'] = '1';
		//$eventPromoMaterial['header'] = $this->load->view('navigation_menu',$navArray,true);
		$launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;		
		
		//New Main folder for new eventid generated
		$newSubMainDestination =  $launchMediaPath.$launchEventId.'/images/';	
		$eventPromoMaterial['promoImagePath'] = $newSubMainDestination;
		$eventPromoMaterial['promoEntityField'] = 'launchEventId';
		$eventPromoMaterial['browseImgJs'] = '_imgJs';			
		$eventPromoMaterial['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->eventMediaTableName,'launchEventId',$launchEventId,1,'');	
		
		
		$fileMaxSize=$this->config->item('defaultContainerSize');
		if(!$launchEventId > 0){
			$launchEventId=0;
		}
		$containerWhere=array('LaunchEventId'=>$launchEventId);
		$eventPromoMaterial['containerDetails'] = $this->model_common->getContainerDetails('LaunchEvent',$containerWhere);
		
		if(isset($eventPromoMaterial['containerDetails'][0]['containerSize']) && $eventPromoMaterial['containerDetails'][0]['containerSize'] > 0 ){
			$containerSize=$eventPromoMaterial['containerDetails'][0]['containerSize'];
			
			$dirname=$this->launchMediaPath.$launchEventId.'/';
			$dirSize=getFolderSize($dirname);
			
			if($natureId==4){ // in case of launch with event also get used size of associted event
				$dirUploadEvent=$this->mediaPath.$eventId.'/';
				if(is_dir($dirUploadEvent)){
					$dirSize=($dirSize+getFolderSize($dirUploadEvent));
				}
			}
			
			$remainingBytes =($containerSize - $dirSize);
			if(!$remainingBytes > 0){
				$remainingBytes =0;
			}
			
			$containerSize=bytestoMB($containerSize,'mb');
			$dirSize=bytestoMB($dirSize,'mb');
			$remainingSize=($containerSize-$dirSize);
			if($remainingSize < 0){
					$remainingSize = 0;
			}
			$dirSize = number_format($dirSize,2,'.','');
			$remainingSize = number_format($remainingSize,2,'.','');
			$fileMaxSize=$remainingBytes;
		}
		$eventPromoMaterial['fileMaxSize']= $fileMaxSize;
		$eventPromoMaterial['userId'] = $this->userId;
		
		
		//$this->template->load('template','event/launch_promo_material',$eventPromoMaterial);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isEvent'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$eventPromoMaterial['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','event/launch_promo_material',$eventPromoMaterial);	
	}	
	
//All Form Related Function	
	
/**
	* Loads Additional Information Form on page
**/
function eventprmaterial($eventId=0,$natureId=2,$type='News')
{
	
		if(!$eventId > 0){
			redirect('event/');
		}
		
		
		$natureId = $this->input->post('NatureId')>0?$this->input->post('NatureId'):$natureId;
		$eventId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;//Checks if eventId is set or not
		$userId=$this->userId;
		//If event record not exist then redirect to nofound page
		if(isset($eventId) && !empty($eventId) && isset($userId)){
			$userDataWhere = array('EventId'=>$eventId,'tdsUid'=>$userId);
			checkUsersProjects('Events',$userDataWhere);
		}
		
		$navArray['NatureId'] = $natureId;
		$navArray['EventId'] = $eventId;
		$navArray['LaunchEventId'] = 0;
		
		$data['header'] = Modules::run("event/menuNavigation",$navArray);
	
		$data['label']=$this->lang->language; 
		
		$data['additionalInfoSection']=array('addInfoNewsPanel','addInfoReviewsPanel','addInfoInterviewsPanel'); 
		

		$data['recordId'] = $eventId;
		$data['EventId'] = $eventId;
		$data['tableId'] = getMasterTableRecord($this->eventTableName);
			
		/*	
		 //To make default display for accordin none,display mode get changed on saving 
			if(strcmp($type,'Reviews')==0){
				$data['reviewDisplayStyle'] = 'style="display:block;"';
			}
			else{
				$data['reviewDisplayStyle'] = 'style="display:none;"';
			}

			if(strcmp($type,'Interviews')==0){
				$data['interviewDisplayStyle'] = 'style="display:block;"';
			}
			else{
				$data['interviewDisplayStyle'] = 'style="display:none;"';
			}		
		*/
			$config = array();
			if(strcmp($this->input->post('formtype'),'News')==0)
			{
				$config = array(
					array(
							 'field'   => 'title',
							 'label'   =>  $this->data['label']['title'],
							 'rules'   => 'trim|required|xss_clean'
					)
				);
			}
			
			if(strcmp($this->input->post('formtype'),'Reviews')==0)
			{
				$config = array(
					array(
							 'field'   => 'reviewstitle',
							 'label'   =>  $this->data['label']['title'],
							 'rules'   => 'trim|required|xss_clean'
					)
				);
			}
			
			$this->form_validation->set_rules($config); 
			$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
			if($this->form_validation->run())
			{	
						
				if(strcmp($this->input->post('submit'),'Save')==0){
					if(strcmp($this->input->post('formtype'),'News')==0){			      
						$data['newsDisplayStyle'] = 'style="display:block;"';
					}
					if(strcmp($this->input->post('formtype'),'Reviews')==0){
						$data['reviewDisplayStyle'] = 'style="display:block;"';
					}
				}//end if save
			}//End If form_validation->run
			else{		
				if(validation_errors()){
					$msg = array('errors' => validation_errors());	
					$data['values']['save'] = '';			
				}			
			}//End else
			//$this->template->load('template','additionalInfo/additional_info',$data);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_pr_material';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','additionalInfo/additional_info',$data);
}	

	/**
		* Loads Launch Event In LIGHTBOX Listing on page
	**/
	function launchEvent()
	{
		$launchEventData['label'] = $this->lang->language;
		
		$launchEventData['launchEvent'] = array();
		
		$this->load->view('launch_event_list',$launchEventData);
	}
	
	
	/**
	 * Delete Related Functions Delete's Event as well the Launch Event 
	**/
	function deleteEvent()
	{
		$eventId = decode($this->input->post('eventId'));
		$flag = $this->input->post('flag');	
		$moveToTemp = $this->input->post('movetotemp');	
		
		if($flag == 0){
			if($moveToTemp==1)
				$this->model_event->publishItem($eventId,$this->eventTableName,'EventId');
			else
				$this->model_event->deleteEvent($eventId,$this->eventTableName,'EventId');
		}
		if($flag == 1)
			$this->model_event->deleteEvent($eventId,$this->launcheventTableName,'LaunchEventId');
		
		$returnUrl = "event/index";
		redirect($returnUrl);
	}
	
			
	function deletePromoMedia()
	{
		$mediaId = $this->input->post('promoMediaId');
		$entityId = $this->input->post('entityId');
		$returnUrl = $this->input->post('returnUrl');
		
		$this->lib_sub_master_media->entityPromoMediaDelete($mediaId,$this->eventMediaTableName);
		
		if($returnUrl =='')
			$currentReturnUrl = "event/events/eventFurtherDesc/".$entityId;
		else 
			$currentReturnUrl = $returnUrl;
		
		redirect($currentReturnUrl);
	}
	
/*
	* Calls the model functions to publish/unpublish the posts
*/
	function publishEvent($eventId)
	{  		
		$data = $this->model_event->publishEvent($eventId);		
		redirect('event/index'); 
	}
	
/*
	* Show the only posts preview
*/
	function previewEvent()
	{	
		$eventId = $this->input->get('UrlToShare');
		
		$data['values'] = $this->model_event->previewEvent(decode($eventId));
		
		$data['values'] = $data['values'][0];
		
		$imagePath = $this->mediaPath.decode($eventId).'/';
		
		$this->lib_event->setEvent($data['values']);
		
	    $eventPreview = $this->lib_event->getValues();
	   
		$eventPreview['label'] = $this->lang->language; //load language variable
		
		$isAjaxHit = $this->input->get('ajaxHit');
		
		if($isAjaxHit) {
			$this->load->view('event_preview',$eventPreview);
		}
		else{
			//$this->template->load('template','event_preview',$eventPreview);	
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
			$leftView='dashboard/help_performancesevents';
			$eventPreview['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','event_preview',$eventPreview);
		}
	}
	
	function previewLaunchEvent()
	{		
		$thisEventId = $this->input->get('UrlToShare');
		
		$data['values'] = $this->model_event->previewEvent(decode($thisEventId),1);
		
		$data['values'] = $data['values'][0];
		
		$imagePath = $this->mediaPath.decode($thisEventId).'/';
				
		$this->lib_event->setEvent($data['values']);
		
	    $eventPreview = $this->lib_event->getValues();
	   
		$eventPreview['label'] = $this->lang->language; //load language variable
		
		$isAjaxHit = $this->input->get('ajaxHit');
		
		if($isAjaxHit){
			$this->load->view('event_preview',$eventPreview);
		}
		else{
			//$this->template->load('template','event_preview',$eventPreview);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
			$leftView='dashboard/help_performancesevents';
			$eventPreview['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','event_preview',$eventPreview);
		}		
	}
	
/**********************************************************************************/
/*********************Dupliating Event and Relations Also**************************/
/**********************************************************************************/
/**
 *In the code below, you make a directory (if it does not exist),
 *then set permissions so you can copy the files. Loop through the
 *files only and copy them.
**/
function copydir($source,$destination)
{
	if(!is_dir($destination)){
		$oldumask = umask(0); 
		mkdir($destination, 01777); // so you get the sticky bit set 
		umask($oldumask);
	}
	
	$dir_handle = @opendir($source) or die("Unable to open");
	while ($file = readdir($dir_handle)) 
	{
		if($file!="." && $file!=".." && !is_dir("$source/$file")) //if it is file
		copy("$source/$file","$destination/$file"); // commented by gurutva //Makes a copy of the file source to dest. 
	}
	closedir($dir_handle);
}//End Function copydir


/**
 * Duplicating event according to four type 
**/
 
public function duplicateEvent($eventId)
{
		
	$dupliateEvent['label'] = $this->lang->language; 
	$dupliateEvent['eventNatureId'] = $this->input->post('NatureId');	
	$dupliateEvent['variables'] = $this->eventVar;

	if($eventId>0)
	{
		 $this->lib_event->getValueToUpdateEvent($eventId); 	 
		 //fetch the session record to get dupliacte for the event  	  
	}

	$dupliateEvent['detailed'] = $this->lib_event->getValues();	

	//Assinged the old folder destination to get coppied in new destination
	$oldMainDestination = $this->mediaPath.$dupliateEvent['detailed']['event']['EventId'].'/';

	//Assinged the old sub folder destination to get coppied in new destination
	$oldSubMainDestination = $this->mediaPath.$dupliateEvent['detailed']['event']['EventId'].'/images/';

	unset($dupliateEvent['detailed']['event']['EventId']);

	unset($dupliateEvent['detailed']['event']['FileId']);

	$finalEventRecordToDuplicate = $dupliateEvent['detailed']['event'];

	//------ New Event Id after duplication -----//
	$this->newEventId = $this->lib_event->saveEvent($finalEventRecordToDuplicate);

	//DUPLICATING SESSION HERE

	if($eventId>0)
	{	 
		 $sesTimeArray = array('tableName'=>'EventSessions');				
		 $fields = $this->db->list_fields($this->db->dbprefix($sesTimeArray['tableName']));
		 foreach ($fields as $field)
		 {
			$sesTimeArray['fieldKeys'][]=$field;
		 } 		
		 $sessTimeObject = new lib_additional_info($sesTimeArray) ;	
		 
		 $ticketsArray = array('tableName'=>'Tickets');				
		 $fields = $this->db->list_fields($this->db->dbprefix($ticketsArray['tableName']));
		 foreach ($fields as $field)
		 {
			$ticketsArray['fieldKeys'][]=$field;
		 } 		
		 $ticketsObject = new lib_additional_info($ticketsArray) ; 
		 
		 $priceSchArray = array('tableName'=>'TicketPriceSchedule');				
		 $fields = $this->db->list_fields($this->db->dbprefix($priceSchArray['tableName']));
		 foreach ($fields as $field)
		 {
			$priceSchArray['fieldKeys'][]=$field;
		 } 		
		 $priceSchObject = new lib_additional_info($priceSchArray) ;
		 
		 //fetch the session record to get duplicate for the event  
		 $eventSession = getDataFromTabelCommon('EventSessions','*','eventId',$eventId);
		
		 if(count($eventSession)>0)
		 {
			foreach($eventSession as $key =>$sesTimeData)
			{				
				$ticketsList = getDataFromTabelCommon('Tickets','TicketCategoryId,Quantity,Price,LaunchEventId','SessionId',$sesTimeData->sessionId);
				
				$ticketPriceSch = getDataFromTabelCommon('TicketPriceSchedule','StartDate,EndDate,Price,TicketCategoryId','SessionId',$sesTimeData->sessionId);
						
				//Now Duplicating the Sessiontime for new eventId
				unset($sesTimeData->sessionId);
				unset($sesTimeData->eventId);
				$sesTimeData->sessionId = 0;
				$sesTimeData->eventId = $this->newEventId;

				$sesPrimaryKey = 'sessionId';			
				$newSessionId = $sessTimeObject->saveAdditionalInfo(object2array($sesTimeData),$sesPrimaryKey,1);
				if(isset($ticketsList) && count($ticketsList)>0)
				{
					foreach($ticketsList as $key => $ticketData)
					{
						$ticketPrimaryKey = 'TicketId';
						$ticketData->TicketId = 0;
						$ticketData->SessionId = $newSessionId;
						$ticketData->EventId = $this->newEventId;
						//echo '<pre />';print_r($ticketData);
						$newTicketId = $ticketsObject->saveAdditionalInfo(object2array($ticketData),$ticketPrimaryKey,1);
						//if(isset($ticketPriceSch) && count($ticketPriceSch)>0)
						//{
							//foreach($ticketPriceSch as $key => $priceSchData)
							//{
							//	$priceSchPrimaryKey = 'PriceScheduleId';
							//	$priceSchData->PriceScheduleId = 0;
							//	$priceSchData->SessionId = $newSessionId;
							//	$priceSchData->TicketId = $newTicketId;
								//echo '<pre />';print_r($priceSchData);
							//	$newPriceSchId = $priceSchObject->saveAdditionalInfo(object2array($priceSchData),$priceSchPrimaryKey,1);
							//}
						//}
					}	
			}//End FOR ticketsList		
		 }//END IF count($ticketsList)>0
		 
		}//END IF count($eventSession)>0
	}//END FOR DUPLICATING SESSION FOR EVENT

//DUPLCATING MEDIA FOR EVENT AND MAKING COPY FOR ALL FOLDER AND FILES 

	$fileType = 1;

	//New Main folder for new eventid generated
	$newMainDestination = $this->mediaPath.$this->newEventId.'/';

	//New Sub Main folder for new eventid generated. THis to used to create the folder and subfolder to be get used to copy the related files
	$newSubMainDestination = $this->mediaPath.$this->newEventId.'/images/';

	$cmdMain = 'chmod -R 0777 '.$newMainDestination;
	exec($cmdMain);

	if(!is_dir($newMainDestination)){
		mkdir($newMainDestination, 777, true);
	}
	$cmdMain = 'chmod -R 0777 '.$newMainDestination;
	exec($cmdMain);

	if(!is_dir($newSubMainDestination)){
		mkdir($newSubMainDestination, 777, true);
	}

	$cmdSub = 'chmod -R 0777 '.$newSubMainDestination;
	exec($cmdSub);

	$this->copydir($oldMainDestination, $newMainDestination );
	$this->copydir($oldSubMainDestination, $newSubMainDestination );
	$dupliateEvent['detailed']['mediaFiles'] = $this->lib_event_promo_image->eventPromotionMediaList($eventId,$mediaType=1);

		foreach($dupliateEvent['detailed']['mediaFiles'] as $key => $mediaArray)
		{
		 unset($mediaArray['mediaId']);
		 unset($mediaArray['filePath']);
		 unset($mediaArray['fileName']);
		 $mediaArray['eventId'] = $this->newEventId;
		 $returnUrl = '/event';

		 $uploadArray = array();

		 saveUploadPromoMedia($this->eventMediaTableName,$this->promoMediaField,$mediaArray,$newSubMainDestination,$uploadArray,$this->newEventId,$fileType,$returnUrl,$this->ImgConfig);
		}
}//END FOR DUPLICATING EVENT


/**
 * Loads Launch Event Form
 * @param $eventId
 * @param $natureId deafult value 3(for launch event)
 * @param $launchEventId
**/
public function launcheventform($launchEventId=0,$natureId=3,$eventId=0)
{     
	 $this->head->add_css($this->config->item('system_css').'upload_file.css');
	 $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
	 $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
	 $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
	 $ImgConfig = $this->lib_image_config->getImgConfigValue();
	$userId=$this->userId;
	//If launch record not exist then redirect to nofound page
	if(isset($launchEventId) && !empty($launchEventId) && isset($userId)){
		$userDataWhere = array('LaunchEventId'=>$launchEventId,'tdsUid'=>$userId);
		checkUsersProjects('LaunchEvent',$userDataWhere);
	}
	 $this->eventId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;//Checks if eventId is set or not

	 if( $eventId > 0 && !($launchEventId >0)){
		 	
		$launchEvenRes=getDataFromTabelCommon('LaunchEvent','LaunchEventId','EventId',$eventId);
		
		if(isset($launchEvenRes[0]->LaunchEventId)){
			$launchEventId=$launchEvenRes[0]->LaunchEventId;
		}
	 }
	 $launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;		
			
	//New Main folder for new eventid generated
	$newMainDestination = $launchMediaPath.$launchEventId.'/';		
		
	//New Sub Main folder for new eventid generated. THis to used to create the folder and subfolder to be get used to copy the related files
	$newSubMainDestination =  $launchMediaPath.$launchEventId.'/images/';
		  
	$entityId = getMasterTableRecord('LaunchEvent');
	$catiD = getEntityCategory($entityId);

	$launchEvent['catiD'] = $catiD;
      		 	
	$localNatureId = $natureId;
		 
	$launchEvent['eventIndustryList'][''] = 'Select Industry';
	 
	$industry = loadIndustry();
	foreach ($industry as $resultIndustry)
	{
		$launchEvent['eventIndustryList'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
	}
	
	 $this->eventId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;//Checks if eventId is set or not
	 $launchEvent['countries'] = getCountryListById();
	 $launchEvent['tableName'] = $this->eventMediaTableName;
	 $primaryKey = 'LaunchEventId';
	 	
	 $addInfoArray = array('tableName'=>'LaunchEvent');
				
	 $fields = $this->db->list_fields($this->db->dbprefix($addInfoArray['tableName']));

	 foreach ($fields as $field)
	 {
		$addInfoArray['fieldKeys'][]=$field;
	 } 
		
	 $addInfoObject = new lib_additional_info($addInfoArray) ;
	
	 $launchEvent['label'] = $this->lang->language;
	
	 $config = array();
		
		$config = array(
			array(
					 'field'   => 'Title',
					 'label'   =>  $launchEvent['label']['title'],
					 'rules'   => 'trim|xss_clean'
			),
			array(
					 'field'   => 'LaunchDate',
					 'label'   =>  $launchEvent['label']['LaunchDate'],
					 'rules'   => 'trim|xss_clean'
			),
		);
		
		$LaunchEventId = $UrlLaunchEventId = $this->input->post('LaunchEventId')>0?$this->input->post('LaunchEventId'):$launchEventId;//Checks if eventId is set or not
		
		if(!$LaunchEventId > 0 && $natureId != 4){
			$sectionId=$this->input->post('sectionId');
			$this->lib_package->setUserContainerId($sectionId);
		}
		if(!isset($UrlLaunchEventId) || $UrlLaunchEventId==0)
		{
			$LaunchEventId = 0;			
			if($this->eventId>0 && $this->eventId!='') $eventArrayValues['orignal'] = getDataFromTabelCommon($addInfoArray['tableName'],'*','EventId',$this->eventId);
			$launchEvent['eventNatureId'] = $this->natureId = $localNatureId;
		}
		else
		{
			$eventArrayValues['orignal'] = $this->model_event->getLaunchEvent($LaunchEventId,$localNatureId,$this->userId);	
			$eventArrayValues = $eventoptionValues = object2array($eventArrayValues['orignal'][0]);
			//echo '<pre />eventoptionValues';print_r($eventoptionValues);die;
			if(isset($eventoptionValues) && count($eventoptionValues)>0) 
			{
				$LaunchEventId = $eventoptionValues['LaunchEventId'];
				$this->natureId = $launchEvent['eventNatureId'] = $eventoptionValues['NatureId'];						
			}		
		}		
	//	echo '<pre />'.$launchEvent['eventNatureId'].$this->natureId;
		//New launch of event then get the detail value of event to get duplicated for launch
		if($LaunchEventId==0) {
						
			$eventArrayValues = $this->lib_event->getValueToUpdateEvent($this->eventId);						
			$LaunchEventId = 0;	
			$launchEvent['count'] = 100;
			$launchEvent['showDelOption'] = 1;			
			$orderBy = 'isMain';
			$launchEvent['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoMediaField,'eventId',$this->eventId,1,$orderBy);
			
		}
		else
		{
			$launchEvent['showDelOption'] = 0;
			
			//Assinged the old folder destination to get coppied in new destination
			$oldMainDestination = $this->mediaPath.$this->eventId.'/';

			//Assinged the old sub folder destination to get coppied in new destination
			$oldSubMainDestination = $this->mediaPath.$this->eventId.'/images/';			
			$launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;		
			
			//New Main folder for new eventid generated
			$newMainDestination = $launchMediaPath.$LaunchEventId.'/';		
				
			//New Sub Main folder for new eventid generated. THis to used to create the folder and subfolder to be get used to copy the related files
			$newSubMainDestination =  $launchMediaPath.$LaunchEventId.'/images/';
			
			$orderBy = 'isMain';			
			$launchEvent['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoMediaField,'launchEventId',$LaunchEventId,1,$orderBy);				
			$launchEvent['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->eventMediaTableName,'launchEventId',$LaunchEventId,1,'');	
		}			
		
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{				
			if(strcmp($this->input->post('submit'),'Save')==0)
			{		
				//$hours = $this->input->post('hh');
				//$mins = $this->input->post('mm');
				//$secs = $this->input->post('ss');
				
				$formType = $this->input->post('formtype');
				
				if($this->eventId == 0) $lEventId = NULL;
				else $lEventId = $this->eventId;
				
				if($formType!= 'promoImage')
				{						
					$formCountry = $this->input->post('Country');
					
					if(!isset($formCountry) || $formCountry=='') $formCountry=0;
					else $formCountry = $this->input->post('Country');
					
					$OrgCountry = $this->input->post('OrgCountry');
					
					if(!isset($OrgCountry) || $OrgCountry=='') $OrgCountry=0;
					else $OrgCountry = $this->input->post('OrgCountry');
					$Rating = $this->input->post('Rating');
					
					if(!isset($Rating) || $Rating=='') $Rating=0;
					else $Rating = $this->input->post('Rating');
					
					$Industry = $this->input->post('Industry');
					if(!isset($Industry) || $Industry=='') $Industry=0;
					else $Industry = $this->input->post('Industry');
					
					$valuesArray = array(
					'LaunchEventId'=> $LaunchEventId,
					'Title'=> $this->input->post('Title'),
					'EventType'=> $this->input->post('EventType'),
					'EventId'=>	 $lEventId,
					'NatureId'=> $this->input->post('NatureId'),
					'OneLineDescription'=> $this->input->post('OneLineDescription'),
					'Description'=> $this->input->post('Description'),
					'Tagwords'=> $this->input->post('Tagwords'),
					//'LaunchDate'=>$this->input->post('LaunchDate'),
					'Address'=> $this->input->post('Address'),
					'Address2'=> $this->input->post('Address2'),
					'City'=> $this->input->post('City'),
					'State'=> $this->input->post('State'),
					'Zip'=> $this->input->post('Zip'),
					'Country'=> $formCountry,
					'Rating'=> $Rating,
					'Type'=> $this->input->post('Type'),
					'URL'=> $this->input->post('URL'),
					//'Time'=>$this->input->post('Time'),
					'tdsUid'=> $this->userId,
					'Industry'=> $Industry,
					'Genre'=> $this->input->post('Genre'),
					'OtherGenre'=> $this->input->post('OtherGenre'),
					'OrgURL'=> $this->input->post('OrgURL'),
					'OrgAddress'=> $this->input->post('OrgAddress'),
					'OrgAddress2'=> $this->input->post('OrgAddress2'),
					'OrgCity'=> $this->input->post('OrgCity'),
					'OrgState'=> $this->input->post('OrgState'),
					'OrgCountry'=> $OrgCountry,
					'OrgZip'=> $this->input->post('OrgZip'),
					'OrgEmail'=> $this->input->post('OrgEmail'),
					'OrgPhone'=> $this->input->post('OrgPhone')
					);
					if($LaunchEventId>0){
					$valuesArray = array_merge($valuesArray,array('LaunchEventModified'=>date("Y-m-d H:i:s")));
					}else 
					$valuesArray = array_merge($valuesArray,array('LaunchEventModified'=>date("Y-m-d H:i:s"),'LaunchEventCreated'=>date("Y-m-d H:i:s")));
					
					$primaryKey = 'LaunchEventId';
					
					//------------For Making time for validation of time--------------------- 
		
					//$seconds = mktime($hours,$mins,$secs);
					
					//Converting in time format to get saved in DB
					
					//if(isset($seconds)) $valuesArray['Time'] = str_pad($hours, 2, "0", STR_PAD_LEFT). ':'.str_pad($mins, 2, "0", STR_PAD_LEFT). ':'.str_pad($secs, 2, "0", STR_PAD_LEFT);
					
					$time = $this->input->post('eventime');
		           // $valuesArray['Time'] =$time;					
					
					
					//------------------------------------------------------------------------
					
					$this->newLaunchEventId = $addInfoObject->saveAdditionalInfo($valuesArray,$primaryKey,1);
					//$launchEvent['returnUrl'] =   "event/launch/launcheventform/".$this->eventId.'/'.$this->natureId.'/'.$LaunchEventId;			
					$launchEvent['returnUrl'] =   "event/launch/launcheventform/".$LaunchEventId;			
					
					//save promitional image only  when we are inserting means creating the record and will not create promotional images at the time of update.....
					
					if($LaunchEventId ==0)
					{				
						$launchEventToCopy['eventPromoImages'] = $this->lib_event_promo_image->eventPromotionMediaList($this->eventId,$mediaType=1);
						
						$oldMainDestination = $this->mediaPath.$this->eventId.'/';

						//Assinged the old sub folder destination to get coppied in new destination
						$oldSubMainDestination = $this->mediaPath.$this->eventId.'/images/';
						
						$launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;	
							
						$cmdlaunchMediaPath = 'chmod -R 777 '.$launchMediaPath;				
						exec($cmdlaunchMediaPath);
						
						$ismainCount=0;	
						
						foreach($launchEventToCopy['eventPromoImages'] as $key => $mediaArray)
						{				
							$fileType= 1;
							
							$mediaArray['mode']	= 'edit';							
							$mediaArray['launchEventId']=$this->newLaunchEventId;
							
							unset($mediaArray['mediaId']);
							unset($mediaArray['filePath']);
							unset($mediaArray['fileName']);
							
							$mediaArray['eventId'] = $this->eventId;							
							$returnUrl = '/event';

							$uploadArray = array();					
							
							//Assinged the old folder destination to get coppied in new destination					
							$this->copydir($oldMainDestination, $newMainDestination );
							$this->copydir($oldSubMainDestination, $newSubMainDestination );
							
							if($ismainCount == 0) $mediaArray['isMain'] = 't'; else $mediaArray['isMain'] = 'f';							
							$ismainCount++;
							
							saveUploadPromoMedia($this->eventMediaTableName,$this->promoMediaField,$mediaArray,$newSubMainDestination,$uploadArray,$this->eventId,$fileType,$returnUrl,$this->ImgConfig);				
						}
						
		//DUPLICATING SESSION HERE

		if($this->eventId>0)
		{	 
			 $sesTimeArray = array('tableName'=>'EventSessions');	
			 			
			 $fields = $this->db->list_fields($this->db->dbprefix($sesTimeArray['tableName']));
			 
			 foreach ($fields as $field)
			 {
				$sesTimeArray['fieldKeys'][]=$field;
			 } 
			 		
			 $sessTimeObject = new lib_additional_info($sesTimeArray) ;	
			 
			 $ticketsArray = array('tableName'=>'Tickets');	
			 			
			 $fields = $this->db->list_fields($this->db->dbprefix($ticketsArray['tableName']));
			 
			 foreach ($fields as $field)
			 {
				$ticketsArray['fieldKeys'][]=$field;
			 } 	
			 	
			 $ticketsObject = new lib_additional_info($ticketsArray) ; 
			 
			 $priceSchArray = array('tableName'=>'TicketPriceSchedule');
			 				
			 $fields = $this->db->list_fields($this->db->dbprefix($priceSchArray['tableName']));
			 
			 foreach ($fields as $field)
			 {
				$priceSchArray['fieldKeys'][]=$field;
			 } 
			 		
			 $priceSchObject = new lib_additional_info($priceSchArray) ;
			 
			 //--Fetch The Session Record To Get Dupliacte For The Event--//
			   
			 $eventSession = getDataFromTabelCommon('EventSessions','*','eventId',$this->eventId);
			
			 if(count($eventSession)>0)
			 {
				foreach($eventSession as $key =>$sesTimeData)
				{				
					$ticketsList = getDataFromTabelCommon('Tickets','TicketCategoryId,Quantity,Price,LaunchEventId','SessionId',$sesTimeData->sessionId);
					
					$ticketPriceSch = getDataFromTabelCommon('TicketPriceSchedule','StartDate,EndDate,Price,TicketCategoryId','SessionId',$sesTimeData->sessionId);
							
					//Now Duplicating the Sessiontime for new eventId
					unset($sesTimeData->sessionId);
					unset($sesTimeData->eventId);
					
					
					$sesTimeData->sessionId = 0;
					
					$sesTimeData->eventId = $this->eventId;
					
					$sesTimeData->launchEventId = $this->newLaunchEventId;
					
					$sesPrimaryKey = 'sessionId';
								
					$newSessionId = $sessTimeObject->saveAdditionalInfo(object2array($sesTimeData),$sesPrimaryKey,1);
					
					if(isset($ticketsList) && count($ticketsList)>0)
					{
						foreach($ticketsList as $key => $ticketData)
						{
							$ticketPrimaryKey = 'TicketId';
							
							$ticketData->TicketId = 0;
							
							$ticketData->SessionId = $newSessionId;
							
							$ticketData->EventId = $this->eventId;
							
							$ticketData->LaunchEventId = $this->newLaunchEventId;
						
							$newTicketId = $ticketsObject->saveAdditionalInfo(object2array($ticketData),$ticketPrimaryKey,1);
							//if(isset($ticketPriceSch) && count($ticketPriceSch)>0)
							//{
								//foreach($ticketPriceSch as $key => $priceSchData)
								//{
								//	$priceSchPrimaryKey = 'PriceScheduleId';
								//	$priceSchData->PriceScheduleId = 0;
								//	$priceSchData->SessionId = $newSessionId;
								//	$priceSchData->TicketId = $newTicketId;
									//echo '<pre />';print_r($priceSchData);
								//	$newPriceSchId = $priceSchObject->saveAdditionalInfo(object2array($priceSchData),$priceSchPrimaryKey,1);
								//}
							//}
								}
							}
						}
					}
				}
			}				
					
			//$baclLink = "event/launch/launcheventform/".$this->eventId.'/'.$this->natureId.'/'.$this->newLaunchEventId;
			$baclLink = "event/launch/launcheventform/".$this->newLaunchEventId;

			redirect($baclLink);				
	}
			
			if($formType == 'promoImage')
			{				
					
		
				$launchMediaPath = "media/".LoginUserDetails('username')."/launchevents/" ;	
					
				$cmdlaunchMediaPath = 'chmod -R 777 '.$launchMediaPath;				
				exec($cmdlaunchMediaPath);
				
				//New Main folder for new eventid generated
//echo '::'.$newMainDestination.':<br />:'.$newSubMainDestination;	die;
				$cmdMain = 'chmod -R 0777 '.$newMainDestination;
				exec($cmdMain);
				
				if(!is_dir($newMainDestination)){
					mkdir($newMainDestination, 0777, true);
				}
				
				$cmdMain = 'chmod -R 0777 '.$newMainDestination;
				exec($cmdMain);
				
				if(!is_dir($newSubMainDestination)){
					mkdir($newSubMainDestination, 0777, true);
				}
				
				$cmdSubMain = 'chmod -R 0777 '.$newSubMainDestination;
				exec($cmdSubMain);				
				
				
				$fileType = $this->input->post('fileType');
				
				$promoMediaFieldValues['mediaId'] = $this->input->post('mediaId');
				$promoMediaFieldValues['mediaType'] = $this->input->post('fileType');
				$promoMediaFieldValues['mediaTitle'] = $this->input->post('mediaTitle');
				$promoMediaFieldValues['mediaDescription'] = $this->input->post('mediaDescription');
				$promoMediaFieldValues['launchEventId'] = $this->input->post('LaunchEventId');			
				$promoMediaFieldValues['eventId'] = $this->eventId;
				$promoMediaFieldValues['fileId'] = $this->input->post('fileId');

				$imagePath = $newSubMainDestination;
				$promoMediaFieldValues['mediaPath'] = $imagePath;			
				
				$cmd1 = 'chmod -R 777 '.$this->mediaPath.$this->eventId;
				exec($cmd1);
				$cmd2 = 'chmod -R 777 '.$this->mediaPath.$this->eventId.'/images';
				exec($cmd2);

				$newEventMedia = $this->mediaPath.$this->eventId;
				$newEventMediaImg = $this->mediaPath.$this->eventId.'/images';

				$cmdMain = 'chmod -R 0777 '.$newEventMedia;
				exec($cmdMain);

				if(!is_dir($newEventMedia))
				{
					mkdir($newEventMedia, 777, true);
				}
				
				$cmdMain = 'chmod -R 0777 '.$newEventMedia;
				exec($cmdMain);

				if(!is_dir($newEventMediaImg))
				{
					mkdir($newEventMediaImg, 777, true);
				}

				$cmdSub = 'chmod -R 0777 '.$newEventMediaImg;
				exec($cmdSub);
				
				//$returnUrl = "event/launch/launcheventform/".$this->eventId.'/'.$this->natureId.'/'.$LaunchEventId;
				$returnUrl = "event/launch/launcheventform/".$LaunchEventId;
				
				$uploadArray = $_FILES;
				
				if($this->eventId ==0) unset($promoMediaFieldValues['eventId']);
				
				if($promoMediaFieldValues['mediaId'] > 0)
				{
					$promoMediaFieldValues['isMain'] = $this->input->post('isMain');
				}
				else if($launchEvent['count'] <=0)
				{
					$promoMediaFieldValues['isMain'] = 't';
				}
				else
				{
						$promoMediaFieldValues['isMain'] = 'f';
				}
				
				$promoMediaFieldValues['launchEventId'] = $LaunchEventId;
				
				saveUploadPromoMedia($this->eventMediaTableName,$this->promoMediaField,$promoMediaFieldValues,$newSubMainDestination,$uploadArray,$this->eventId,$fileType,$returnUrl,$this->ImgConfig);
				
				if(isset($_SERVER['HTTP_REFERER']))
				{
					$baclLink=$_SERVER['HTTP_REFERER'];			
				}
				else
				{
					//$baclLink="event/launch/launcheventform/".$this->eventId.'/'.$this->natureId.'/'.$this->newLaunchEventId;
					$baclLink="event/launch/launcheventform/".$this->newLaunchEventId;
				}
				
				redirect($baclLink);
			}	
				
		}//END SAVE IF
		
		}//END IF form_validation->run
 	
	if($UrlLaunchEventId==0 && $this->eventId==0)
	{
		$launchEvent['data'] = '';
		 
	 }
	else 
		$launchEvent['data'] = $eventArrayValues;
//		echo '<pre />eventArrayValues';print_r($eventoptionValues);
	//echo '$LaunchEventId'.$LaunchEventId;
	if($LaunchEventId>0) $launchEvent['data'] = $eventArrayValues;
	
	 $ratingList = getRatingList();
	 $launchEvent['ratingList'] = $ratingList;
	//-----Staring Setting Hour minute and seconds to get set in stepper of form-----
	
	
	if(isset($launchEvent['data']['Time']) && $launchEvent['data']['Time']!='')
	list($hour, $min, $sec) = explode(":", $launchEvent['data']['Time']);
	else $hour=0; $min=0; $sec=0;
	
	if(substr($hour,0,1) ==0) $hour = substr($hour,1);
	if(substr($min,0,1) ==0) $min = substr($min,1);
	if(substr($sec,0,1) ==0) $sec = substr($sec,1);
	
	$launchEvent['hour'] = $hour;
	$launchEvent['min'] = $min;
	$launchEvent['sec'] = $sec;
	
	//----------------------End of hour,minute and second---------------------------
	
	$launchEvent['PROMOTIONALIMAGEForm'] = 'style="display:none;"';
	
	$launchEvent['tableName'] = $this->eventMediaTableName;
	
	$launchEvent['mediaType'] = $this->ImgConfig['mediaConfig']['mediaType'];
	
	$orderBy = 'isMain';
	
	$launchEvent['data']['LaunchEventId'] = $LaunchEventId;
	
	if(isset($eventoptionValues['EventId']) && $eventoptionValues['EventId']!='') $launchEvent['data']['EventId'] = $eventoptionValues['EventId'];
	else { $launchEvent['data']['EventId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$eventId;}//Checks if eventId is set or not
	
	
	//$launchEvent['returnUrl'] =   "event/launch/launcheventform/".$this->eventId.'/'.$this->natureId.'/'.$LaunchEventId;
	$launchEvent['returnUrl'] =   "event/launch/launcheventform/".$LaunchEventId;
	
	$launchEvent['tableId'] = getMasterTableRecord($this->launcheventTableName);
	//echo '<pre />';print_r($launchEvent);
	//New code starts		
	$launchEventPromotionalImages['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
	//$launchEventPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->eventMediaTableName,$this->promoImageField,'launchEventId',$LaunchEventId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
	$launchEventPromotionalImages['promoElementTable'] = $this->eventMediaTableName;
	$launchEventPromotionalImages['launchEventId'] = $LaunchEventId;
	$launchEventPromotionalImages['entityMediaType'] = '';
	$launchEventPromotionalImages['header'] = $this->load->view('navigation_menu',$launchEventPromotionalImages,true);
	$launchEvent['promoElementTable'] = $this->eventMediaTableName;
	$launchEvent['promoElementFieldId'] = 'mediaId';
	$launchEventPromotionalImages['promoImageId'] = $this->eventId;
	$launchEventPromotionalImages['label'] = $this->lang->language;
	
	$launchEvent['launchEventPromotionalImages'] = $launchEventPromotionalImages;
	
	$launchEvent['promoImagePath'] = $newSubMainDestination;
	$launchEvent['launchMediaPath'] = $newSubMainDestination;
	$launchEvent['promoImageId'] = $launchEvent['entityId'] = $LaunchEventId;
	$launchEvent['promoEntityField'] = 'launchEventId';
	$launchEvent['browseImgJs'] = '_imgJs';

	if($this->natureId == 3) {
		if($LaunchEventId==0)
			$launchEvent['returnBack'] = base_url('event/launch/launchdetail');
		else
			$launchEvent['returnBack'] = base_url('event/launch/launchdetail/'.$LaunchEventId);
	}
	else {
		if($this->eventId==0)
			$launchEvent['returnBack'] = base_url('event/eventwithlaunch/eventwithlaunchdetail');
		else
			$launchEvent['returnBack'] = base_url('event/eventwithlaunch/eventwithlaunchdetail/'.$this->eventId);
		
	}
	
	$fileMaxSize=$this->config->item('defaultContainerSize');
	if(!$launchEventId > 0){
		$launchEventId=0;
	}
	$containerWhere=array('LaunchEventId'=>$launchEventId);
	$launchEvent['containerDetails'] = $this->model_common->getContainerDetails('LaunchEvent',$containerWhere);
	if(isset($launchEvent['containerDetails'][0]['containerSize']) && $launchEvent['containerDetails'][0]['containerSize'] > 0 ){
		$containerSize=$launchEvent['containerDetails'][0]['containerSize'];
		
		$dirname=$this->launchMediaPath;
		$dirSize=getFolderSize($dirname);
		$remainingBytes =($containerSize - $dirSize);
		if(!$remainingBytes > 0){
			$remainingBytes =0;
		}
		
		$containerSize=bytestoMB($containerSize,'mb');
		$dirSize=bytestoMB($dirSize,'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
				$remainingSize = 0;
		}
		$dirSize = number_format($dirSize,2,'.','');
		$remainingSize = number_format($remainingSize,2,'.','');
		$fileMaxSize=$remainingBytes;
	}
	$launchEvent['fileMaxSize']= $fileMaxSize;
	$launchEvent['userId'] = $this->userId;
	
	//$this->template->load('template','launch_event_form',$launchEvent);
	
	$leftData=array(
					'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
					'isDashButton'=>true,
					'isEvent'=>1
		  );
	$leftView='dashboard/help_performancesevents';
	$launchEvent['leftContent']=$this->load->view($leftView,$leftData,true);
	
	$this->template->load('backend_template','launch_event_form',$launchEvent);
	
}

/**
	* Loads Additional Information Form on page
**/
function launchprmaterial($launchEventId=0,$natureId=3,$eventId=0,$type="news")
{
	if($launchEventId>0)
	{		
		$userId=$this->userId;
		//If launch record not exist then redirect to nofound page
		if(isset($launchEventId) && !empty($launchEventId) && isset($userId)){
			$userDataWhere = array('LaunchEventId'=>$launchEventId,'tdsUid'=>$userId);
			checkUsersProjects('LaunchEvent',$userDataWhere);
		}
		$additionalInfoData['additionalInfoSection']=array('addInfoNewsPanel','addInfoReviewsPanel','addInfoInterviewsPanel'); 
		$additionalInfoData['label'] = $this->lang->language;
		
		
		$EventIdArray = getDataFromTabelCommon('LaunchEvent','EventId,NatureId','LaunchEventId',$launchEventId);
		
		if(is_array($EventIdArray) && !empty($EventIdArray)) {
			$additionalInfoData['MyEventId']= $EventIdArray[0]->EventId;
			$additionalInfoData['NatureId'] = $EventIdArray[0]->NatureId;
		}else {
			$additionalInfoData['MyEventId'] = $eventId;
			$additionalInfoData['NatureId'] = $natureId;
		}
		///echo '<pre />';print_r($navArray);
		$additionalInfoData['tableId'] = getMasterTableRecord($this->launcheventTableName);
		$additionalInfoData['header'] = $this->load->view('navigation_menu',$additionalInfoData,true);
		
		//$additionalInfoData['header'] = $this->load->view('navigationMenu',$this->lib_upcomingprojectsimages->keyimages,true);
		$additionalInfoData['recordId'] = $launchEventId;
		
		$config = array();
		if(strcmp($this->input->post('formtype'),'News')==0)
		{
		$config = array(
			array(
					 'field'   => 'title',
					 'label'   =>  $additionalInfoData['label']['title'],
					 'rules'   => 'trim|required|xss_clean'
			),
		);
		}
		
		if(strcmp($this->input->post('formtype'),'Reviews')==0)
		{
		$config = array(
			array(
					 'field'   => 'reviewstitle',
					 'label'   =>  $additionalInfoData['label']['title'],
					 'rules'   => 'trim|required|xss_clean'
			),
		);
		}
		
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		
		if($this->form_validation->run())
		{
			if(strcmp($this->input->post('submit'),'Save')==0){
					
				if(strcmp($this->input->post('formtype'),'News')==0){			      
					$additionalInfoData['newsDisplayStyle'] = 'style="display:block;"';
				}
				if(strcmp($this->input->post('formtype'),'Reviews')==0){			
					$additionalInfoData['reviewDisplayStyle'] = 'style="display:block;"';
				}
				
			}//end if save
		}//End If form_validation->run
		else
		{		
			if(validation_errors())
			{
			$msg = array('errors' => validation_errors());	
			$data['values']['save'] = '';			
			}			
		}//End else
		//echo '<pre />';print_r($additionalInfoData);
		//$this->template->load('template','additionalInfo/additional_info',$additionalInfoData);
		//$this->template->load('template','upcomingProject_additional_info',$additionalInfoData);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_pr_material';
		$additionalInfoData['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','additionalInfo/additional_info',$additionalInfoData);
		
	}else
	{
		$msg = $this->lang->language['enterLaunchDetail'];
		set_global_messages($msg, 'error');
		redirect("event/launch/launchDetail");
	}	
}


/**
 * Set Launch Event Promotional Image as main Image
 * 
 * @param $mediaId
 * 
 * @param $entityId
 * 
 * @param $mediaType
**/	
public function makeFeatured($mediaId,$entityId,$mediaType,$workType='')
{
		$promotionImageId =  $mediaId;
		
		$checkFeaturedImage = chcekFeaturedImageChangeStatus($this->eventMediaTableName,'launchEventId',$entityId,$mediaType);
		
		$this->model_common->changePromotionMediaStatus($this->eventMediaTableName,$promotionImageId,'launchEventId',$entityId);

		$message = $this->lang->language['featuredImageChanged'];
		
		set_global_messages($message, 'success');
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$baclLink=$_SERVER['HTTP_REFERER'];
		}
		else
		{
			$baclLink='';
		}
		
		redirect($baclLink);
}

/**
 * 
 * Delete Promotional Images For Event
 * 
 * @param $mediaId
 * 
 * @param $entityId
 * 
**/
	
	function deletePromotionImage($mediaId, $entityId,$eventType='')
	{
		$getFileType = getMediaFileType($this->eventMediaTableName,'mediaType', $mediaId); // Image or video
		
		if(isset($eventType) && $eventType ==3)
			$result = deletePromotionImage($this->eventMediaTableName,'mediaId',$mediaId,'launchEventId',$entityId);
		else
			$result = deletePromotionImage($this->eventMediaTableName,'mediaId',$mediaId,'eventId',$entityId);
			
		if($getFileType==1)
		{
			$message =  $this->lang->language['workImageDeleted'];			
			set_global_messages($message, 'success');
			
			//For redirecting on previous page after performing action
			if(isset($_SERVER['HTTP_REFERER']))				
				$baclLink=$_SERVER['HTTP_REFERER'];				
			else			
				$baclLink='';		
			
		redirect($baclLink);	
		
		}
		else if($getFileType==2)
		{
			$message =  $this->lang->language['workVideoDeleted']; 			
			set_global_messages($message, 'success');			
			//For redirecting on previous page after performing action
			if(isset($_SERVER['HTTP_REFERER']))
			{
				$baclLink=$_SERVER['HTTP_REFERER'];
			}
			else $baclLink='';
		}
		
		redirect($baclLink);				
	}
	
	function duplicatesession($sessionId=0)
	{
			if(is_numeric($sessionId) && $sessionId>0)
			{	 
				 $sesTimeArray = array('tableName'=>'EventSessions');				
				 $fields = $this->db->list_fields($this->db->dbprefix($sesTimeArray['tableName']));
				 foreach ($fields as $field)
				 {
					$sesTimeArray['fieldKeys'][]=$field;
				 } 		
				 $sessTimeObject = new lib_additional_info($sesTimeArray) ;	
				 
				 $ticketsArray = array('tableName'=>'Tickets');				
				 $fields = $this->db->list_fields($this->db->dbprefix($ticketsArray['tableName']));
				 foreach ($fields as $field)
				 {
					$ticketsArray['fieldKeys'][]=$field;
				 } 		
				 $ticketsObject = new lib_additional_info($ticketsArray) ; 
				 
				 $priceSchArray = array('tableName'=>'TicketPriceSchedule');				
				 $fields = $this->db->list_fields($this->db->dbprefix($priceSchArray['tableName']));
				 foreach ($fields as $field)
				 {
					$priceSchArray['fieldKeys'][]=$field;
				 } 		
				 $priceSchObject = new lib_additional_info($priceSchArray) ;
				 
				 //fetch the session record to get duplicate for the event  
				 $eventSession = getDataFromTabelCommon('EventSessions','*','sessionId',$sessionId);
				//echo $this->db->last_query();
				 if($eventSession && is_array($eventSession) && count($eventSession)>0)
				 {
					foreach($eventSession as $key =>$sesTimeData)
					{				
						
						
						$ticketsList = getDataFromTabelCommon('Tickets','*','SessionId',$sesTimeData->sessionId);
								
						//Now Duplicating the Sessiontime for new eventId
						$sesTimeData->sessionId = 0;
						$sesTimeData->sessionCreated=currntDateTime();
						$sesTimeData->sessionModified=currntDateTime();
						if(!is_numeric($sesTimeData->eventId) || !($sesTimeData->eventId > 0) ){
							$sesTimeData->eventId = 0;
						}
						if(!is_numeric($sesTimeData->launchEventId)){
							$sesTimeData->launchEventId = 0;
						}
						if( !($sesTimeData->eventSellstatus == 'f') && !($sesTimeData->eventSellstatus == 't') ){
							$sesTimeData->eventSellstatus = null;
						}
						if( !($sesTimeData->earlyBirdStatus == 't')){
							$sesTimeData->earlyBirdStatus = 'f';
						}
						
						
						
						$sesPrimaryKey = 'sessionId';			
						$newSessionId = $sessTimeObject->saveAdditionalInfo(object2array($sesTimeData),$sesPrimaryKey,0,1);
						if($newSessionId && is_numeric($newSessionId) && ($newSessionId > 0) && is_array($ticketsList) && count($ticketsList)>0)
						{
							foreach($ticketsList as $key => $ticketData)
							{
								$prevTicketId=$ticketData->TicketId;
								$ticketPrimaryKey = 'TicketId';
								$ticketData->TicketId = 0;
								$ticketData->SessionId = $newSessionId;
								
								
								$ticketData->EventId = $sesTimeData->eventId;
								$ticketData->LaunchEventId = $sesTimeData->launchEventId;
								
								if(!is_numeric($ticketData->Quantity) ){
									$ticketData->Quantity = 0;
								}
								
								if(!($ticketData->Price > 0) ){
									$ticketData->Price = 0;
								}
								
								if($ticketData->isCategoryA !='t'){
									$ticketData->isCategoryA='f';
								}
								
								if($ticketData->isCategoryB !='t'){
									$ticketData->isCategoryB='f';
								}
								if($ticketData->isCategoryC !='t'){
									$ticketData->isCategoryC='f';
								}
								if($ticketData->Free !='f'){
									$ticketData->Free='t';
								}
								
								if(($preSch->StartDate == '') || ($preSch->StartDate == null) || empty($preSch->StartDate) ){
									$preSch->StartDate = currntDateTime();
								}
								
								$newTicketId = $ticketsObject->saveAdditionalInfo(object2array($ticketData),$ticketPrimaryKey,1);
								
								if(($sesTimeData->earlyBirdStatus == 't') && is_numeric($prevTicketId) && ($prevTicketId > 0) && is_numeric($newTicketId) && ($newTicketId > 0)){
									$ticketPriceSch = getDataFromTabelCommon('TicketPriceSchedule','*','TicketId',$prevTicketId);
									if(is_array($ticketPriceSch) && count($ticketPriceSch)>0)
									{
										foreach($ticketPriceSch as $key => $preSch)
										{
											$primaryKey = 'PriceScheduleId';
											$preSch->PriceScheduleId = 0;
											$preSch->TicketId = $newTicketId;
											$preSch->SessionId = $newSessionId;
											
											if(($preSch->StartDate == '') || ($preSch->StartDate == null) || empty($preSch->StartDate) ){
												$preSch->StartDate = currntDateTime();
											}
											
											if(($preSch->EndDate == '') || ($preSch->EndDate == null) || empty($preSch->EndDate) ){
												$preSch->EndDate = currntDateTime();
											}
											
											if(!($preSch->Price > 0)){
												$preSch->Price = 0;
											}
											
											$PriceScheduleId = $priceSchObject->saveAdditionalInfo(object2array($preSch),$primaryKey,1);
											
										}	
									}
								}
							}	
						}//End FOR ticketsList
						
							
				 }//END IF count($ticketsList)>0
				 $message =  $this->lang->language['duplicateSession']; 
					
				 set_global_messages($message, 'success');
				}//END IF count($eventSession)>0
			}			
			
			//For redirecting on previous page after performing action
			if(isset($_SERVER['HTTP_REFERER']))
			{
				$baclLink=$_SERVER['HTTP_REFERER'];
			}
			else			
				$baclLink='';		
		
		redirect($baclLink);	
	}
		
/* Jquery Save For Event (eventform)*/
	function eventjquerysave()
	{
		$updateUserContainerFlag=false;
		$addUserContainerFlag=false;
		$this->userId= $this->isLoginUser();
		$elements = false; //to check whether to add or update the post data
		$files = false;
		
		//Event Id to get add or updated
	    $elementId = $this->input->post('val1');
	    $eventData = $this->input->post('val2');    
	    $fileId = $this->input->post('val3');
	    $data['MediaFile'] = $this->input->post('val4');   
		$primaryKeyForTable = $this->input->post('val5');   
		
		
	    if(isset($primaryKeyForTable) && strcmp($primaryKeyForTable,'EventId')==0){ $primaryTable = $this->eventTableName;$primaryKeyForTable = 'EventId'; }
	    else{ $primaryTable = $this->launcheventTableName;$primaryKeyForTable = 'LaunchEventId'; }
	   // echo '<pre />';print_r($data); die;
	    if($elementId>0)
		{
			$countResult = $this->model_common->countResult($primaryTable,$primaryKeyForTable,$elementId,1);
			if($countResult > 0){
				$elements=true;
			}
		}
				
		//Saving image data in mediafile
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){
 			
 			if(isset($data['MediaFile']['fileSize']) && $data['MediaFile']['fileSize']!=''){
				$fileSize = $data['MediaFile']['fileSize'];		
				$data['MediaFile']['fileSize'] = $fileSize;
			}
			
			if($fileId>0){
				$result=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath,isExternal,fileType','fileId',$fileId,'','',1);
				if($result > 0){
					if($result[0]->isExternal != 't'){
						$filePath = trim($result[0]->filePath.$result[0]->fileName);
						if(!empty($filePath) && is_file($filePath)){
							
							@unlink($filePath);							
						 
						 //If file is image
							 if($result[0]->fileType == 1 || strcmp($result[0]->fileType,'image')==0)
							 {
							 //Deleting the all vesion of file
							 $thumbImgversion_b = addThumbFolder(@$filePath,'_b');
							 if(!empty($thumbImgversion_b) && is_file($thumbImgversion_b)) @unlink($thumbImgversion_b);
							 
							 $thumbImgversion_l = addThumbFolder(@$filePath,'_l');
							 if(!empty($thumbImgversion_l) && is_file($thumbImgversion_l)) @unlink($thumbImgversion_l);
							
							 $thumbImgversion_m = addThumbFolder(@$filePath,'_m'); 
							 if(!empty($thumbImgversion_m) && is_file($thumbImgversion_m)) @unlink($thumbImgversion_m);
							 
							 $thumbImgversion_s = addThumbFolder(@$filePath,'_s');
							 if(!empty($thumbImgversion_s) && is_file($thumbImgversion_s)) @unlink($thumbImgversion_s);
							 
							 $thumbImgversion_xs = addThumbFolder(@$filePath,'_xs');
							 if(!empty($thumbImgversion_xs) && is_file($thumbImgversion_xs)) @unlink($thumbImgversion_xs);
							 
							 $thumbImgversion_xxs = addThumbFolder(@$filePath,'_xxs');
							 if(!empty($thumbImgversion_xxs) && is_file($thumbImgversion_xxs)) @unlink($thumbImgversion_xxs);
							}//End if fileType
						}
					}
					$files=true;
				}
			}
			if($files){
				if(!isset($data['MediaFile']['fileName']) || $data['MediaFile']['fileName']==''){ unset($data['MediaFile']['fileName']);unset($data['MediaFile']['fileSize']);}
				
				$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $fileId);
				//echo $this->db->last_query();
			}else{
				$eventData['FileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);
			}
		}
		
		//echo '<pre />';print_r($eventData);die;
		//if countResult is greater then 1 we have update the evnt else add the existing
		if($elements){
			$data['append'] = false;
			$this->model_common->editDataFromTabel($primaryTable, $eventData, $primaryKeyForTable, $elementId);
			$data['elementId'] = $elementId;
			
			$msg = $this->lang->line('msgSuccessfullyUpdated');
		}else{
			
			if($eventData['NatureId']==1){
				$currentSectionId=$this->config->item('eventNotificationsSectionId');
			}
			elseif($eventData['NatureId']==2){
				$currentSectionId=$this->config->item('eventsSectionId');
			}
			elseif($eventData['NatureId']==3){
				$currentSectionId=$this->config->item('launchesSectionId');
			}
			elseif($eventData['NatureId']==4){
				$currentSectionId=$this->config->item('eventswithLaunchSectionId');
			}
			else{
				$currentSectionId='';
			}
			if($currentSectionId != '' ){
				if($eventData['NatureId']==4 && $primaryTable==$this->launcheventTableName){
					if($eventData['EventId'] > 0){
						$res=$this->model_common->getDataFromTabel($this->eventTableName,'userContainerId',array('EventId'=>$eventData['EventId']),'','','',1);
						if(isset($res[0]->userContainerId) && $res[0]->userContainerId > 0){
							$userContainerId=$res[0]->userContainerId;
						}else{
							$userContainerId=0;
							//redirect('event/index');
						}
					}else{
						$userContainerId=0;
						redirect('event/index');
					}
					
				}else{
					$userContainerId=$this->lib_package->getUserContainerId($currentSectionId);
				}
			}else{
				redirect('event/index');
			}
			
			if($eventData['NatureId']==1){
				$addUserContainerFlag=true;
			}else{
				$eventData['userContainerId']=$userContainerId;
				$updateUserContainerFlag=true;
			}
			
			if($eventData['NatureId']==4 && $primaryTable==$this->launcheventTableName){
				$addUserContainerFlag=false;
				$updateUserContainerFlag=false;
			}
			$data['append'] = true;
			$data['elementId']= $elementId = $this->model_common->addDataIntoTabel($primaryTable, $eventData);
			
			if($primaryTable==$this->eventTableName){
				$entityId=getMasterTableRecord($this->eventTableName);
			}elseif($primaryTable==$this->launcheventTableName){
				$entityId=getMasterTableRecord($this->launcheventTableName);
			}
			if($updateUserContainerFlag && $elementId > 0){
				$this->lib_package->updateUserContainer($userContainerId,$entityId,$elementId,$currentSectionId,$currentSectionId);
			}
			elseif($addUserContainerFlag && $elementId > 0){
				$this->lib_package->addUserContainer($userContainerId,$entityId,$elementId,$currentSectionId,$currentSectionId,$this->eventTableName,'EventId');
			}
			
			addDataIntoLogSummary($primaryTable,$elementId);
			
			
			$msg = $this->lang->line('msgSuccessfullyAdded');
			
		}
		set_global_messages($msg, 'success', true);
			
		
		//echo 'elementId:=>'.$elementId;die;
		$currentEntityId = $elementId;
		if($elementId > 0){
			$this->writeEventCacheFile($primaryTable,$elementId);
		}
		$passArray = array('id'=>$currentEntityId);
		$returnJsonArray = json_encode($passArray);
	
		echo $returnJsonArray;
	}
	
	function writeEventCacheFile($primaryTable,$elementId){
		
				$isEvent=$isLaunch=false;
				if($primaryTable==$this->eventTableName){
					$eventList=$this->model_event->getEventFullDetails($elementId,$this->userId);
					$isEvent=true;
					$entityId=getMasterTableRecord($this->eventTableName);
					
				}elseif($primaryTable==$this->launcheventTableName){
					$eventList=$this->model_event->getLaunchEventFullDetails($elementId,$this->userId);
					$isLaunch=true;
					$entityId=getMasterTableRecord($this->launcheventTableName);
				}
				
				if(isset($eventList[0]) && is_array($eventList[0]) && count($eventList[0] > 0)){
					$event=$eventList[0];
					
					$type =($event['Type']==2)?'online':'live';
					$genre =($event['Genre']==2)?'educational':'entertainment';
						
					if($isEvent){
						$Id=$event['EventId'];
						$NatureId=$event['NatureId'];
						$StartDate=$event['StartDate'];
						$FinishDate=trim($event['FinishDate']);
						if($FinishDate==''){
							$FinishDate=$StartDate;
						}
						$CreatedDate=$event['EventDateCreated'];
						
						if($NatureId==1){
							$cacheFile=$this->dirCache.'eventnotification_User_'.$event['tdsUid'].'_event_'.$event['EventId'].'.php';
							$section='notification';
							$Country=$event['Country'];
							$countryName=$event['countryName'];
							$City=$event['City'];
							$category=($event['EventType']==2)?'launch':'event';
						}else{
							$eventList['promotionalImages']=$this->model_event->getEventPromotionalImages(array('eventId'=>$Id));
							$eventList['eventSessions']=$this->model_event->geteventSessions(array('EventSessions.eventId'=>$Id));
							$cacheFile=$this->dirCache.'PEevent_User_'.$event['tdsUid'].'_event_'.$event['EventId'].'.php';
							$section='event';
							if(isset($eventList['eventSessions'][0]) && is_array($eventList['eventSessions'][0]) && count($eventList['eventSessions'][0]) > 0){
								$session=$eventList['eventSessions'][0];
								$Country=$session['country'];
								$countryName=$session['countryName'];
								$City=$session['city'];
							}else{
								$Country=0;
								$countryName='';
								$City='';
							}
							$category='event';
						}
					}else{
						$Id=$event['LaunchEventId'];
						$eventList['promotionalImages']=$this->model_event->getEventPromotionalImages(array('launchEventId'=>$Id));
						$cacheFile=$this->dirCache.'eventlaunch_User_'.$event['tdsUid'].'_event_'.$event['LaunchEventId'].'.php';
						$section='launch';
						$Country=$event['Country'];
						$countryName=$event['countryName'];
						$City=$event['City'];
						$StartDate=$event['date'];
						$FinishDate=$event['date'];
						$CreatedDate=$event['LaunchEventCreated'];
						$category='launch';
					}
					$StartDate = trim($StartDate);
					$FinishDate = trim($FinishDate);
					
					if($StartDate == ''){
						$StartDate = currntDateTime('Y-m-d');
					}
					if($FinishDate == ''){
						$FinishDate = $StartDate;
					}
					
					if(!is_dir($this->dirCache)){
						@mkdir($this->dirCache, 777, true);
					}
					$cmd3 ='chmod -R 777 '.$this->dirCache;
					exec($cmd3);
					
					$data=str_replace("'","&apos;",json_encode($eventList));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					if (!write_file($cacheFile, $stringData)){					// write cache file
						 echo 'Unable to write the file';
					}
					
					$enterpriseName=pg_escape_string($event['enterpriseName']);
					$enterpriseName=trim($enterpriseName);
					$creative_name=($event['enterprise']=='t')?$enterpriseName:pg_escape_string($event['firstName'].' '.$event['lastName']);
					
					
					$sectionid=$this->config->item('performancesneventsSectionId');
					$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$Id,
						"projectid"=>$Id,
						"sectionid"=>$sectionid,
						"section"=>$section,
						"ispublished"=>$event['isPublished']=='t'?'t':'f',
						"cachefile"=>$cacheFile,
						"item.title"=>pg_escape_string($event['Title']), 
						"item.tagwords"=>pg_escape_string($event['Tagwords']), 
						"item.online_desctiption"=>pg_escape_string($event['OneLineDescription']),
						"item.userid"=>$this->userId, 
						"item.creative_name"=>$creative_name, 
						"item.creative_area"=>pg_escape_string(loginUserDetails('userArea')),
						"item.languageid"=>$event['Language']>0?$event['Language']:0,  
						"item.language"=>$event['Language_local'],
						"item.countryid"=>$Country>0?$Country:0, 
						"item.country"=>$countryName, 
						"item.city"=>pg_escape_string($City), 
						"item.industryid"=>$event['Industry']>0?$event['Industry']:0, 
						"item.industry"=>$event['IndustryName'],
						"item.category"=>$category,
						"item.type"=>$type,
						"item.genre"=>$genre,
						"item.subgenre"=>$event['OtherGenre'],
						"item.element_type"=>$section,
						"item.self_ratingid"=>$event['Rating']>0?$event['Rating']:0,
						"item.self_rating"=>$event['otpion'],
						"item.event_start_date"=>$StartDate, 
						"item.event_end_date"=>$FinishDate,
						"item.sell_option"=>($section=='notification')?'free':'paid',
						"item.creation_date"=>$CreatedDate, 
						"item.publish_date"=>$CreatedDate
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
				}
		
	}
	
	function meetingpoint($entityId=0)
	{		
		$flag= $this->input->post('flag');
		if($flag==1)
			$where = array('launchEventId'=>$entityId); 
		else
			$where = array('eventId'=>$entityId); 
			
		$sessions['meetingpoint'] = $this->model_event->getMeetingPointSessions($where);
		$sessions['primaryTable'] = $this->db->dbprefix('MeetingPoint');
		$sessions['primaryKeyForTable'] = 'session_id';
		$sessions['userId'] = $this->userId;
		//$sessions['entityId'] = getMasterTableRecord('Events');
		//echo '<pre />';print_r($sessions);
		//$this->template->load('template','meeting_point',$sessions);	
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isEvent'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$sessions['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','meeting_point',$sessions);	
	}
	
	function usermeetingpoint($entityId=0,$offSet='',$perPage='')
	{		
		if(!isset($entityId) || $entityId<=0) $entityId = $this->userId;
		$where = array('tdsUid'=>$entityId); 			
			
		$countmeetingpoint = $this->model_event->getEventAndLuanchData($entityId);
		
		$countmp = count($countmeetingpoint);
		$sessions['perPageRecord'] = 1;
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countmp; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$sessions['perPageRecord'] ;
		$pages->paginate();
		$sessions['items_total'] = $pages->items_total;
		$sessions['items_per_page'] = $pages->items_per_page;
		$sessions['pagination_links'] = $pages->display_pages();
		//$totalmeetingpoint = count($countmeetingpoint);
		$totalmeetingpoint = 4 ;
		$sessions['meetingpoint'] = $this->model_event->getEventAndLuanchData($entityId,$pages->offst,$pages->limit);			
		//echo '$sessions:'.$this->db->last_query();
		if($sessions['meetingpoint'] && is_array($sessions['meetingpoint']) && count($sessions['meetingpoint']) > 0){
			foreach($sessions['meetingpoint'] as $mpData){
				 
				$event_id=$mpData['event_id'];
				$user_id=$mpData['user_id'];
				$launch_id=$mpData['launch_id'];
				if($event_id > 0){
					$id=$event_id;
					$where=array('eventId'=>$event_id);
				}elseif($launch_id > 0){
					$id=$launch_id;
					$where=array('launchEventId'=>$launch_id);
				}
				$sessions["session"][$id][]=  $this->model_event->getMeetingPointSessions($where);
			}
		}else{
			$sessions["session"]=false;
		}
		$sessions['primaryTable'] = $this->db->dbprefix('MeetingPoint');
		$sessions['primaryKeyForTable'] = 'session_id';
		$sessions['countmeetingpoint'] = count($sessions['meetingpoint']);
		$sessions['totalmeetingpoint'] = $totalmeetingpoint;
		$sessions['perPage'] = $perPage;
		$sessions['userId'] = $this->userId;
		$sessions['entityId'] = $entityId;
		//$sessions['entityId'] = getMasterTableRecord('Events');
		//echo '<pre />';print_r($sessions);die;
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		
		$breadcrumbItem=array('meetingpoint');
		$breadcrumbURL=array('event/usermeetingpoint');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$sessions['breadcrumbString']=$breadcrumbString;
	    $sessions['pagingLink'] = base_url(lang().'/event/usermeetingpoint/'.$entityId);
	    if($ajaxRequest)
		{   
			$this->load->view('meeting_place_view',$sessions);
		}else{
			//$this->template->load('template','user_meeting_point',$sessions);	
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
			$leftView='dashboard/help_performancesevents';
			$sessions['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','user_meeting_point',$sessions);
		}	
	}
	
	
	/*
	 *************************
	 * This function is used to show user purchase session ticket list
	 ************************* 
	 */  
	 
	 
	
	
	function purchasesessionlist($entityId=0,$offSet='',$perPage='')
	{	
		$userId = $this->userId;
		$limit= (!empty($limit))? $limit :0 ;
		$perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordPurchase');
		$countTotalArray=$this->model_event->get_purchase_session($userId,0,0);
		$countTotal = count($countTotalArray);
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		
		// Add By Amit to check if cookie exists		
		$isCookie = getPerPageCookie('purchasePerPageVal',$perPage);		
		
		$pages->items_per_page=$isCookie ;
		
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;	
		
		$breadcrumbItem=array('purchasedsession');
		$breadcrumbURL=array('event/purchasesessionlist');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
		$getPurchaseDetails = $this->model_event->get_purchase_session($userId,$pages->offst,$pages->items_per_page);
		
		/*
		echo "<pre>";
		print_r($getPurchaseDetails);die();*/
		
		
		$data['purchasesessions'] = $getPurchaseDetails;
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		 if($ajaxRequest)
		{   
			$this->load->view('purchase_session_list',$data);
		}else{
			//$this->template->load('template','purchase_session',$data);	
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
			$leftView='dashboard/help_performancesevents';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','purchase_session',$data);
		}
		
		
			
		/*
		  if(!isset($entityId) || $entityId<=0) $entityId = $this->userId;
		$where = array('tdsUid'=>$entityId); 			
			
		$countmeetingpoint = $this->model_event->getEventAndLuanchData($entityId);
		
		$countmp = count($countmeetingpoint);
		$sessions['perPageRecord'] = 5;
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countmp; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$sessions['perPageRecord'] ;
		$pages->paginate();
		$sessions['items_total'] = $pages->items_total;
		$sessions['items_per_page'] = $pages->items_per_page;
		$sessions['pagination_links'] = $pages->display_pages();
		//$totalmeetingpoint = count($countmeetingpoint);
		$totalmeetingpoint = 4 ;
		$sessions['meetingpoint'] = $this->model_event->getEventAndLuanchData($entityId,$pages->offst,$pages->limit);			
		//echo '$sessions:'.$this->db->last_query();
		if($sessions['meetingpoint'] && is_array($sessions['meetingpoint']) && count($sessions['meetingpoint']) > 0){
			foreach($sessions['meetingpoint'] as $mpData){
				 
				$event_id=$mpData['event_id'];
				$user_id=$mpData['user_id'];
				$launch_id=$mpData['launch_id'];
				if($event_id > 0){
					$id=$event_id;
					$where=array('eventId'=>$event_id);
				}elseif($launch_id > 0){
					$id=$launch_id;
					$where=array('launchEventId'=>$launch_id);
				}
				$sessions["session"][$id][]=  $this->model_event->getMeetingPointSessions($where);
			}
		}else{
			$sessions["session"]=false;
		}
		$sessions['primaryTable'] = $this->db->dbprefix('MeetingPoint');
		$sessions['primaryKeyForTable'] = 'session_id';
		$sessions['countmeetingpoint'] = count($sessions['meetingpoint']);
		$sessions['totalmeetingpoint'] = $totalmeetingpoint;
		$sessions['perPage'] = $perPage;
		$sessions['userId'] = $this->userId;
		$sessions['entityId'] = $entityId;
		//$sessions['entityId'] = getMasterTableRecord('Events');
		//echo '<pre />';print_r($sessions);die;
		$ajaxRequest = $this->input->post('ajaxRequest');
		
		
		$breadcrumbItem=array('meetingpoint');
		$breadcrumbURL=array('event/usermeetingpoint');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$sessions['breadcrumbString']=$breadcrumbString;
	    $sessions['pagingLink'] = base_url(lang().'/event/usermeetingpoint/'.$entityId);
	    if($ajaxRequest)
		{   
			$this->load->view('purchase_session_list',$sessions);
		}else{
			$this->template->load('template','purchase_session',$sessions);	
		}	*/
	}
	
	
	function launchpostprimg($launchId=0)
	{			
		$userId=$this->userId;
		//If launch record not exist then redirect to nofound page
		if(isset($launchId) && !empty($launchId) && isset($userId)){
			$userDataWhere = array('LaunchEventId'=>$launchId,'tdsUid'=>$userId);
			checkUsersProjects('LaunchEvent',$userDataWhere);
		}
		$EventIdArray = getDataFromTabelCommon('LaunchEvent','tdsUid,EventId,Type,LaunchEventCreated,NatureId,Title,OneLineDescription,Industry,FileId','LaunchEventId',$launchId);
		//echo '<pre />';print_r($EventIdArray);die;
		if(is_array($EventIdArray) && !empty($EventIdArray))
		{			
			$data['EventId'] = $navArray['EventId']= $EventIdArray[0]->EventId;
			$data['eventNatureId'] = $data['imageShowcase']['NatureId'] = @$EventIdArray[0]->NatureId;
			
			if(@$EventIdArray[0]->Type == 1 || @$EventIdArray[0]->Type == '') $LiveOrOnline = 'Live';
			if(@$EventIdArray[0]->Type == 2) $LiveOrOnline = 'Online';
			
			$data['LaunchType'] = $LiveOrOnline;
			$data['LaunchEventCreated'] = @$EventIdArray[0]->LaunchEventCreated;
			$data['LaunchTitle'] = @$EventIdArray[0]->Title;
			$data['OneLineDescription'] = @$EventIdArray[0]->OneLineDescription;
			$data['tdsUid'] = @$EventIdArray[0]->tdsUid;
			$data['IndustryId'] = @$EventIdArray[0]->Industry;
			$data['FileId'] = @$EventIdArray[0]->FileId;
			
		}
		else 
		{
			$data['EventId'] = $navArray['EventId'] = 0;	
			$data['LaunchType'] = '';
			$data['LaunchEventCreated'] = @$EventIdArray[0]->LaunchEventCreated;
			$data['eventNatureId'] = $data['imageShowcase']['NatureId'] = @$EventIdArray[0]->NatureId;
			$data['LaunchTitle'] = @$EventIdArray[0]->Title;
			$data['OneLineDescription'] = @$EventIdArray[0]->OneLineDescription;
			$data['tdsUid'] = @$EventIdArray[0]->tdsUid;
			$data['IndustryId'] = @$EventIdArray[0]->Industry;
			$data['FileId'] = @$EventIdArray[0]->FileId;
		}
		
		$data['cravedUser'] = $this->model_event->getCravedUserAnyEvent($launchId);
		
		if(isset($data['cravedUser'][0]) && count($data['cravedUser'][0])>0)
			$data['cravedUser'] =$data['cravedUser'][0];
		else
			$data['cravedUser'] = array($this->userId);
		
		$data['imageShowcase']['listValues']  = $this->model_event->launchPostPrImages($launchId);	
		$data['imageShowcase']['count'] = count($data['imageShowcase']['listValues']);
		$data['imageShowcase']['entityId'] = $data['imageShowcase']['promoImageId'] = $data['imageShowcase']['LaunchEventId'] = $data['imageShowcase']['currentEntityId'] = $launchId;	
		$data['imageShowcase']['mediaType'] = 1;
		$data['imageShowcase']['toggleId'] = 'imageShowcase';
		$data['imageShowcase']['last'] = '';
		$data['imageShowcase']['sectionHeading'] = 'postLaunchPRImages';
		$data['imageShowcase']['tableName'] = $data['imageShowcase']['elementTable'] = $this->eventMediaTableName;
		$data['imageShowcase']['elementFieldId'] = 'launchEventId';
		
		$data['imageShowcase']['mediaPath'] = "media/".LoginUserDetails('username').'/launchevents/postimages';
		$data['imageShowcase']['mediaFileTypes'] = $this->config->item('imageAccept');
		$data['imageShowcase']['imgload'] = 1;
		$data['imageShowcase']['addPromoheading'] = $this->lang->line('addpostLaunchPRImages');
		
		$fileMaxSize=$this->config->item('defaultContainerSize');
		if(!$launchId > 0){
			$launchId=0;
		}
		
		$containerWhere=array('LaunchEventId'=>$launchId);
		
		$NotificationWhere = array('entityId'=>getMasterTableRecord($this->launcheventTableName),'projectId'=>$launchId,'projectType'=>$this->config->item('postLaunchNotificationType'));
		$data['NotificationCount'] = $this->model_common->countResult('Notification',$NotificationWhere);
		$data['NotificationDetails'] = getDataFromTabelCommon('Notification','message,createdDate',$NotificationWhere);
		//$data['NotificationDetails'] = 	object2array($data['NotificationDetails']);
		
		if(isset($data['NotificationDetails']) && is_array($data['NotificationDetails']) && count($data['NotificationDetails'])>0){
			$data['NotificationDetails'] = $data['NotificationDetails'][0];
			$data['NotificationCount'] =count($data['NotificationDetails']);
		}else{
			$data['NotificationDetails'] = array();
			$data['NotificationCount'] =0;	
		}
		
		
		$data['containerDetails'] = $this->model_common->getContainerDetails('LaunchEvent',$containerWhere);
		if(isset($data['containerDetails'][0]['containerSize']) && $data['containerDetails'][0]['containerSize'] > 0 ){
			$containerSize=$data['containerDetails'][0]['containerSize'];
			
			$dirname=$this->launchMediaPath;
			$dirSize=getFolderSize($dirname);
			$remainingBytes =($containerSize - $dirSize);
			if(!$remainingBytes > 0){
				$remainingBytes =0;
			}
		
			$containerSize=bytestoMB($containerSize,'mb');
			$dirSize=bytestoMB($dirSize,'mb');
			$remainingSize=($containerSize-$dirSize);
			if($remainingSize < 0){
					$remainingSize = 0;
			}
			$dirSize = number_format($dirSize,2,'.','');
			$remainingSize = number_format($remainingSize,2,'.','');
			$fileMaxSize=$remainingBytes;
		}
		$data['fileMaxSize']= $fileMaxSize;
		$data['userId'] = $this->userId;
		
		//$this->template->load('template','launch_post_pr_image',$data);
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
						'isDashButton'=>true,
						'isEvent'=>1
			  );
		$leftView='dashboard/help_performancesevents';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','launch_post_pr_image',$data);
	}

	function postLaunchNotification(){
		
		$entityId = getMasterTableRecord($this->launcheventTableName);
		$projectId = $elementId = $this->input->post('projectId');
		$IndustryId = $this->input->post('IndustryId');
		$message = $this->input->post('message');
		$toUsersId = $this->input->post('toUsersId');
		$ownerId = $this->userId;
		$notificationsArray = array('notificationData'=>array('entityId'=>$entityId,
															  'projectId'=>$projectId,
															  'elementId'=>$elementId,
															  'industryId'=>($IndustryId>0)?$IndustryId:0,
															  'message'=>$message,
															  'ownerId'=>$ownerId,	
															  'projectType'=>$this->config->item('postLaunchNotificationType')			 
															  )									
									);
										
		//echo '<pre />zfsdfdf';print_r($notificationsArray);die;
		$notificationId =$this->model_common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
		// $this->model->common->addDataIntoTabel('Notification',$notificationsArray['notificationData']);
		
		$participant = explode(',',$toUsersId);
		foreach($participant as $key => $participantDetail) {
			
			if($participantDetail == $this->userId) $flag ='t';
			else $flag ='f';
			
			$participantsData[] = array('notificationId' => $notificationId,
			'userId' => $participantDetail,
			'status' => 0,
			'isSender' => $flag);
			
		}//End Foreach
		
		$this->model_common->insertBatch('NotificationParticipants',$participantsData);
		set_global_messages('Notification Sent', 'success');
	 redirect(base_url('/event/launch/launchpostprimg/'.$projectId));
	}
	/*Function to load how to publish popup */
	function howToPublish()
	{
		$this->load->view('event_how_to_publish') ;				
	}
	
	public function eventfurtherdescription($eventId=0) {
		$eventId=is_numeric($eventId)?$eventId:0;
		if(!$eventId > 0){
			redirect('event');
		}
		$this->furtherdescription('event',$eventId);
	}
	
	public function launchfurtherdescription($launchEventId=0) {
		$launchEventId=is_numeric($launchEventId)?$launchEventId:0;
		if(!$launchEventId > 0){
			redirect('event');
		}
		$this->furtherdescription('launch',$launchEventId);
	}
	
	public function furtherdescription($eventType='event',$eventOrLaunchId=0) {
		$userId= $this->isLoginUser();
		
		$eventOrLaunchId=is_numeric($eventOrLaunchId)?$eventOrLaunchId:0;
		if(!$eventOrLaunchId > 0){
			redirect('event');
		}
		
		$eventType=($eventType=='event')?'event':'launch';
		
		if($eventType == 'event'){
			$table='Events';
			$where=array($table.'.tdsUid'=>$userId, $table.'.EventId'=>$eventOrLaunchId);
			$fields = "$table.EventId,$table.NatureId,$table.Title,$table.Description,$table.Rating,$table.posterImage,$table.isPublished";
			$dirUploadMedia=$this->mediaPath.$eventOrLaunchId.'/';
			$currentMathod='eventfurtherdescription';
		}else{
			$table='LaunchEvent';
			$where=array($table.'.tdsUid'=>$userId, $table.'.LaunchEventId'=>$eventOrLaunchId);
			$fields = "$table.LaunchEventId,$table.EventId,$table.NatureId,$table.Title,$table.Description,$table.Rating,$table.posterImage,$table.isPublished";
			$dirUploadMedia=$this->launchMediaPath.$eventOrLaunchId.'/';
			$currentMathod='launchfurtherdescription';
		}
		
		
		$furtherDescriptions = $this->model_event->getfurtherdescription($table,$where,$fields);
		
		if($furtherDescriptions && isset($furtherDescriptions[0])){
			$entityId=getMasterTableRecord($table);
			$this->data['entityId']=$entityId;
			$this->data['eventType']=$eventType;
			$this->data['eventOrLaunchId']=$eventOrLaunchId;
			$this->data['dirUploadMedia']=$dirUploadMedia;
			$this->data['currentMathod']=$currentMathod;
			$this->data['FD']=$furtherDescriptions[0];
			
			$whereSuportLinks=array('entityid_to'=>$entityId,'elementid_to'=>$eventOrLaunchId);
			
			$this->load->model('media/model_media');
			
			$this->data['suportLinks']=$this->model_media->suportLinks($whereSuportLinks);
			
			//$this->template->load('template','furtherDescription',$this->data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/performancesevents'),
							'isDashButton'=>true,
							'isEvent'=>1
				  );
			$leftView='dashboard/help_performancesevents';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','furtherDescription',$this->data);
		}else{
			redirect('event');
		}
	}
	
	public function saveFurthrtDescription() {
		$userId= $this->isLoginUser();
		$config = array(
               array(
                     'field'   => 'Rating',
                     'label'   => 'Rating',
                     'rules'   => 'trim|xss_clean'
               ),
               array(
                     'field'   => 'Description',
                     'label'   => 'Description',
                     'rules'   => 'trim|xss_clean'
               )
            );
		
		$this->form_validation->set_rules($config);
		
		$eventOrLaunchId=$this->input->post('eventOrLaunchId');
		
		if(is_numeric($eventOrLaunchId)  && ($eventOrLaunchId > 0) && $this->form_validation->run()){
			
			$eventType=$this->input->post('eventType');
			$isUpdatedSupportingMedia=$this->input->post('isUpdatedSupportingMedia');
			
			$browseId1st = $this->input->post('browseId1st');
			$browseId2nd = $this->input->post('browseId2nd');
			
			$coverImageFileId=0;
			$posterImage='';
			
			if($eventOrLaunchId && is_numeric($eventOrLaunchId) &&  ($eventOrLaunchId > 0) ){
				
				$eventType=($eventType=='event')?'event':'launch';
		
				if($eventType == 'event'){
					$table='Events';
					$where=array($table.'.tdsUid'=>$userId, $table.'.EventId'=>$eventOrLaunchId);
					$fields = "$table.EventId,$table.NatureId,$table.Title,$table.Description,$table.Rating,$table.posterImage,$table.isPublished";
					$dirUploadMedia=$this->mediaPath.$eventOrLaunchId.'/';
				}else{
					$table='LaunchEvent';
					$where=array($table.'.tdsUid'=>$userId, $table.'.LaunchEventId'=>$eventOrLaunchId);
					$fields = "$table.LaunchEventId,$table.EventId,$table.NatureId,$table.Title,$table.Description,$table.Rating,$table.posterImage,$table.isPublished";
					$dirUploadMedia=$this->launchMediaPath.$eventOrLaunchId.'/';
				}
				$entityId=getMasterTableRecord($table);
				
				$FD = $this->model_event->getfurtherdescription($table,$where,$fields);
		
				if($FD && isset($FD[0])){
					$FD=$FD[0];
					
					$coverImageFileId=$FD->fileId;
					$posterImage=$FD->posterImage;
					
					$uploadedFile=0;
			
					$updateData = array(
						'Rating' => pg_escape_string(set_value('Rating')),
						'Description' => pg_escape_string(set_value('Description'))
					);
					$coverImageFile=false;
					
					if(is_numeric($FD->fileId) && $FD->isExternal=='f' && is_dir($FD->filePath) && $FD->fileName !=''){
						$filePath=$FD->filePath;
						$fpLen=strlen($filePath);
						if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
							$filePath=$filePath.DIRECTORY_SEPARATOR;
						}
						$fileName=$FD->fileName;
						$coverImageFile=array('filePath'=>$filePath,'fileName'=>$fileName);
					}
					
					
					$coverImage_fileName=$this->input->post('fileName'.$browseId1st);
					
					$mediaFileData=array();
					if($coverImage_fileName && strlen($coverImage_fileName)>3){
						$uploadedFile++;
						
						$mediaFileData=array(
												'filePath'=>$dirUploadMedia,
												'fileName'=>$coverImage_fileName,
												'fileType'=>1,
												'tdsUid'=>$userId,
												'isExternal'=>'f',
												'fileSize'=>$this->input->post('fileSize'.$browseId1st),
												'rawFileName'=>$this->input->post('fileInput'.$browseId1st),
												'jobStsatus'=>'UPLOADING'
											);
						
						$coverImageFileId=$this->manageCompetitionMediaFile($coverImageFileId,$mediaFileData,$coverImageFile);
						$updateData['FileId']= $coverImageFileId;
					
					}
					
					
					$posterImageName=$this->input->post('fileName'.$browseId2nd);
					if($posterImageName && strlen($posterImageName)>3){
						$uploadedFile++;
						$updateData['posterImage']= $dirUploadMedia.'/'.$posterImageName;
						
						if($posterImage && strlen($posterImage)>3 && is_file($posterImage)){
							$fileInfo=pathinfo($posterImage);
							$dirname=$fileInfo['dirname'];
							$basename=$fileInfo['basename'];
							
							if(is_dir($dirname) && $basename !=''){
								$fpLen=strlen($dirname);
								if($fpLen > 0 && substr($dirname,-1) != DIRECTORY_SEPARATOR){
									$dirname=$dirname.DIRECTORY_SEPARATOR;
								}
								findFileNDelete($dirname,$basename);
							}
						}
					}
					
					$this->model_common->editDataFromTabel($table, $updateData, $where);
					
					if(is_numeric($isUpdatedSupportingMedia) && ($isUpdatedSupportingMedia==1)){
						$this->suportLinksAdd($entityId,$eventOrLaunchId);
					}
					
					$msg=$this->lang->line('furtherDescriptionUpdated');
					set_global_messages($msg, $type='success', $is_multiple=true);
					
					$this->writeEventCacheFile($table,$eventOrLaunchId);
					
					$returnData=array('eventOrLaunchId'=>$eventOrLaunchId,'uploadedFile'=>$uploadedFile,'msg'=>$msg);
					echo json_encode($returnData);
				}
			}
		}
		else{
			redirect('event');
		}
	}
	
	public function manageCompetitionMediaFile($fileId=0,$mediaFileData=array(),$File=false){
		if(is_numeric($fileId) && $fileId > 0){
			$this->model_common->editDataFromTabel('MediaFile', $mediaFileData, array('fileId'=>$fileId));
			if($File && is_array($File) && count($File) > 0){
				findFileNDelete($File['filePath'],$File['fileName']);
			}
		}else{
			$fileId=$this->model_common->addDataIntoTabel('MediaFile', $mediaFileData);
		}
		return $fileId;
	}
	public function suportLinksAdd($entityid_to,$elementid_to){
		if( is_numeric($entityid_to) && ($entityid_to > 0) && is_numeric($elementid_to) && ($elementid_to > 0) ){	
			$insertData =array();
			$dataSupportingMediaFlag=false;
			
			$linkToScriptentityid_from=(int)$this->input->post('linkToScriptentityid_from');
			$linkToScriptelementid_from=(int)$this->input->post('linkToScriptelementid_from');
			
			if($linkToScriptentityid_from > 0 && $linkToScriptelementid_from > 0){
				$dataSupportingMediaFlag=true;
				$insertData[]=array("entityid_to"=>$entityid_to, "elementid_to"=>$elementid_to, "entityid_from"=>$linkToScriptentityid_from, "elementid_from"=>$linkToScriptelementid_from, "order"=>1);
				
			}
			
			$linkToSoundtrackentityid_from=(int)$this->input->post('linkToSoundtrackentityid_from');
			$linkToSoundtrackelementid_from=(int)$this->input->post('linkToSoundtrackelementid_from');
			
			if($linkToSoundtrackentityid_from > 0 && $linkToSoundtrackelementid_from > 0){
				$dataSupportingMediaFlag=true;
				$insertData[]=array("entityid_to"=>$entityid_to, "elementid_to"=>$elementid_to, "entityid_from"=>$linkToSoundtrackentityid_from, "elementid_from"=>$linkToSoundtrackelementid_from, "order"=>2);
				
			}
			
			$linkToPosterentityid_from=(int)$this->input->post('linkToPosterentityid_from');
			$linkToPosterelementid_from=(int)$this->input->post('linkToPosterelementid_from');
			
			if($linkToPosterentityid_from > 0 && $linkToPosterelementid_from > 0){
				$dataSupportingMediaFlag=true;
				$insertData[]=array("entityid_to"=>$entityid_to, "elementid_to"=>$elementid_to, "entityid_from"=>$linkToPosterentityid_from, "elementid_from"=>$linkToPosterelementid_from, "order"=>3);
				
			}
			
			print_r($insertData);
			
			if($dataSupportingMediaFlag){
				  $whereDel=array('entityid_to'=>$entityid_to,'elementid_to'=>$elementid_to);
				  $this->model_common->deleteRowFromTabel('SupportLink', $whereDel);
				  $this->model_common->insertBatch('SupportLink',$insertData);
			}
		}
	}
	   
}//End Class

?>
