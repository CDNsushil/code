<?php
class Lib_event_promo_image{

private $eventMedia = array('mediaId' => '',
			'mediaType' =>'',
			'mediaTitle' =>'',
			'mediaDescription' =>'',
			'mediaPath' =>'',
			'eventId' =>'',
			'fileId' =>'',
			'launchEventId' =>''			
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
 
  $variables['eventMedia'] = $this->eventMedia;
  
  return $variables;

 }//function getValues

 
public function setEventPromoImage($event_promoImage_array)
 { 	
  foreach($event_promoImage_array as $k => $v){
   if(isset($this->eventMedia[$k])){
    $this->eventMedia[$k] = $v;
   }
  }
	return $this->eventMedia;
 } //function setEventValues


public function saveEventPromoImage($saveEventPromoImageData){
	
$mediaId = $saveEventPromoImageData['MediaId'];
if($saveEventPromoImageData['MediaId'] ==0) {
 unset($saveEventPromoImageData['MediaId']);
  $this->CI->model_event->insertEventPromoImage($saveEventPromoImageData);
 }
	
 if($mediaId >0) {
  $eventPromoImageIdToEdit= $saveEventPromoImageData['MediaId'];
  unset($saveEventPromoImageData['MediaId']);
  $this->CI->model_event->updateEventPromoImage($saveEventPromoImageData,  $eventPromoImageIdToEdit);
 }	 	
}//End saveEventPromoImage




 public function eventPromotionMediaList($eventId,$mediaType=1)
 {		 
  $promoMediaList = $this->CI->model_event->eventPromotionMediaList($eventId,$mediaType);   

  $eventPromotionMediai = 0;

  foreach($promoMediaList as $k => $object)
  {	
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
