<?php
class Lib_event{

private $event = array('maineventid' => '',
'EventId' => '',
'NatureId' =>'',
'Title' =>'',
'EventType' =>'',
'OneLineDescription' =>'',
'Tagwords' =>'',
'Industry' =>'',
'Genre' =>'',
'OtherGenre' =>'',
'Language' =>'',
'Type' =>'',
'StartDate' =>'',
'FinishDate' =>'',
'Time' =>'',
'Category' =>'',
'Description' =>'',
'Rating' =>'',
'CompanyName' =>'',
'Image' =>'',
'URL' =>'',
'Address' =>'',
'City' =>'',
'State' =>'',
'Country' =>'',
'Zip' =>'',
'EventPublish' =>'',
'Genre' =>'',
'OtherGenre' =>'',
'FileId' =>'',
'filePath' =>'','fileName' =>''

);


private $eventMedia = array('MediaId' => '',
			'MediaType' =>'',
			'MediaTitle' =>'',
			'MediaDescription' =>'',
			'MediaPath' =>'',
			'EventId' =>'',
			'FileId' =>'',
			'LaunchEventId' =>''			
		      );

private $supportLinks = array('LinkId' => '',
			'EventId' =>'',
			'Title' =>'',
			'URL' =>''			
		      );

private $associativeCreatives = array('crtId' => '',
			'entityId' =>'',
			'elementId' =>'',
			'entityType' =>'',
			'crtDesignation' =>'',
			'crtName' =>'',
			'crtStatus' =>'',
			'crtLoadId' =>''			
		      );

 	 
 /**
 * Constructor
 */
function __construct(){
	
   //My own constructor code
   log_message('debug', "Event Class Initialized");
	$this->now = time();
	$this->CI =& get_instance();
	//load libraries
	$this->CI->load->database();
	
}

 public function getValues()
 { 	
  $variables['event'] = $this->event;
  $variables['eventMedia'] = $this->eventMedia;
  $variables['supportLinks'] = $this->supportLinks;
  $variables['associativeCreatives'] = $this->associativeCreatives;
  return $variables;

 }//function getValues

 public function setEvent($event_notification_array)
 { 	
  if(count($event_notification_array)>0)
  foreach($event_notification_array as $k => $v){
	
  if(array_key_exists($k, $this->event)){
    $this->event[$k] = $v;
  }else  $this->event[$k] ='';
  }
	return $this->event;
 } //function setEventValues

public function setEventPromoImage($event_promoImage_array)
 { 	
  foreach($event_promoImage_array as $k => $v){
   if(isset($this->eventMedia[$k])){
    $this->eventMedia[$k] = $v;
   }
  }
	return $this->eventMedia;
 } //function setEventValues
 
 public function saveEvent($saveData){	

	if(!isset($saveData['EventId'])||$saveData['EventId'] ==0) 
	{ 
	unset($saveData['EventId']);
	unset($saveData['maineventid']);
	unset($saveData['filePath']);
	unset($saveData['fileName']);
	
	 return $this->CI->model_event->insertEvent($saveData);
	}
	
	if($saveData['EventId'] >0) {
	 $eventIdToEdit= $saveData['EventId'];
	 unset($saveData['maineventid']);
	 unset($saveData['filePath']);
	 unset($saveData['fileName']);
	
	 $this->CI->model_event->updateEvent($saveData,$eventIdToEdit);
	}
 }


 public function getValueToUpdateEvent($eventId){	
	$setKeys = $this->CI->model_event->getEventToUpdate($eventId);
	$this->setEvent($setKeys[0]);	
	return $setKeys[0];

 }

 public function eventList()
 {
	 	
  $eventList = $this->CI->model_event->eventList(); 
  $eventi = 0;
  if(count($eventList)>0){
  foreach($eventList as $k => $object){	

   //New Array Index

  // $this->setEvent($object); //set the table field values using current class method
  // $variables = $this->getValues();//get the table field values using current class method
   $eventList[$eventi] = $object;//$variables['event'];
   if(isset($object['LaunchEventId'])){
	     $eventList[$eventi]['LaunchEventId'] = $object['LaunchEventId'];
   
   }
   if(isset($object['filePath']))
   $eventList[$eventi]['filePath'] = $object['filePath'];
   
   if(isset($object['fileName']))
   $eventList[$eventi]['fileName'] = $object['fileName'];
   
$this->CI->db->select('sessionId,date,startTime,endTime,eventId,position,address,city,state,country,zip,url');
$this->CI->db->from('EventSessions');

if((isset($object['NatureId']) && $object['NatureId']==4) && (isset($object['EventId'])))
{
	
	$this->CI->db->where('EventSessions.eventId', $object['EventId']);
	$launchOption = array(0, NULL);
	$this->CI->db->where_in('EventSessions.launchEventId',$launchOption);
	
}

if((isset($object['NatureId']) && $object['NatureId'] != 3 && $object['NatureId'] != 4) && (isset($object['EventId']) || ($object['EventId']>0)))
{
	$this->CI->db->where('EventSessions.eventId', $object['EventId']);
}

if((isset($object['NatureId']) && $object['NatureId'] == 3) && (!isset($object['EventId'])))
{
	$this->CI->db->where('EventSessions.launchEventId', $object['LaunchEventId']);
}	
$querySession = $this->CI->db->get();
$eventList[$eventi]['sessionList']['common'] = $querySession->result_array();
foreach($eventList[$eventi]['sessionList']['common'] as $sessionKey => $sessionValue)
{ 
	
$EventSessId = $eventList[$eventi]['sessionList']['common'][$sessionKey]['sessionId'];

$this->CI->db->select('SessionId,Quantity,Price,MasterTicketCategories.Title,MasterTicketCategories.TicketCategoryId ');
$this->CI->db->from('Tickets');

$this->CI->db->where("Tickets.SessionId = ".$EventSessId."");
$this->CI->db->join('MasterTicketCategories', 'MasterTicketCategories.TicketCategoryId = Tickets.TicketCategoryId');
	
$querySessionTickets = $this->CI->db->get();
//echo $this->CI->db->last_query();
$eventList[$eventi]['sessionList']['common'][$EventSessId] = $querySessionTickets->result_array();
}
$eventi++;
}
}
//echo '<pre />';print_r($eventList);
return $eventList;
 }	 	

 public function eventPromotionMediaList($eventId,$mediaType=1){	
  $promoMediaList = $this->CI->model_event->eventPromotionMediaList($eventId,$mediaType); 
  

  $eventPromotionMediai = 0;

  foreach($promoMediaList as $k => $object){	

   //New Array Index

   $this->setEventPromoImage($object); //set the table field values using current class method
  
   $variables = $this->getValues();//get the table field values using current class method
   $variables['eventMedia']['filePath']=$object->filePath;
   $variables['eventMedia']['fileName']=$object->fileName;
   $promoMediaList[$eventPromotionMediai] = $variables['eventMedia'];
$eventPromotionMediai++;
  }

  return $promoMediaList;
 }

}//End Class
?>
