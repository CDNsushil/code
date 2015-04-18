<?php
class lib_sub_master_media{

private $tableName = '';
private $entityMedia = array();	 
 /**
 * Constructor
 */
function __construct(){
   //entity own constructor code
   log_message('debug', "Event Class Initialized");
  //My own constructor code

		$this->now = time();
		$this->CI =& get_instance();
		//load libraries
		$this->CI->load->database();
		$this->CI->load->library('upload');
		$this->CI->load->library('lib_image_config');
	 //My own constructor code
	
	
}

 public function getPromoImageValue()
 { 	
 
  $variables['entityMedia'] = $this->entityMedia;
  
  return $variables;

 }//function getValues


public function setPromoImageValue($entityTableName,$entity_promo_image_array,$object)
{ 	
	
	
	$entityMedia = '';

	foreach($entity_promo_image_array as $k)
	{
		if($entityMedia == '' )
		 $entityMedia = $k;
		else
		 $entityMedia = $entityMedia.','.$k;
	}
	
	$newArray = explode(",", $entityMedia);

	//Setting the key value for table
	foreach($object as $k => $v)
	{
		$this->entityMedia[$k] = $v;
	}

	return $this->entityMedia;
} //function setEventValues



public function entitypromotionmedialist($entityTableName,$entity_promo_image_array,$whereField,$entityId,$mediaType=1,$orderBy='',$flag='',$postLaunchPR=0)
{

	$ImgConfig = $this->CI->lib_image_config->getImgConfigValue();

	$promoMediaList = '';
	$this->tableName = $entityTableName;
	//echo $orderBy;
	$entityPromoMediaList =  $this->CI->model_common->entitypromotionmedialist($this->tableName,$entity_promo_image_array,$whereField,$entityId,$mediaType,$orderBy,$flag,$postLaunchPR);   

	$eventPromotionMediai = 0;
	
	foreach($entityPromoMediaList as $k => $object)
	{
		//echo '<pre />';print_r($object);
		$newTabelFields = $this->setPromoImageValue($this->tableName,$entity_promo_image_array,$object); //set the table field values using current class method

		$variables = $this->getPromoImageValue();//get the table field values using current class method

		$variables['entityMedia']['entityId']=$object->$whereField;
		$variables['entityMedia']['filePath']=$object->filePath;
		$variables['entityMedia']['fileName']=$object->fileName;
		
		$promoMediaList[$eventPromotionMediai] = $variables['entityMedia'];
		$eventPromotionMediai++;
	}

	return $promoMediaList;
}

/**
 * 
 * Save Promotional Media (Image)
 * @params array // Promo Image Array
 * @params string // Table Name
 * 
**/

public function savePromoMedia($saveEventPromoImageData,$entityTableName)
{

	if(isset($saveEventPromoImageData['mediaId']))	
		$mediaId = $saveEventPromoImageData['mediaId'];
	else
		$mediaId = 0;

	if(!isset($saveEventPromoImageData['mediaId']) || $saveEventPromoImageData['mediaId'] ==0) 
	{
		unset($saveEventPromoImageData['mediaId']); 
		$this->CI->model_common->insertPromoMedia($saveEventPromoImageData,$entityTableName);
	}
		
	 if($mediaId >0) 
	 {
		$eventPromoImageIdToEdit= $mediaId;
		unset($saveEventPromoImageData['mediaId']);
		$this->CI->model_common->updatePromoMedia($saveEventPromoImageData,$eventPromoImageIdToEdit,$entityTableName);
	 }
	 	 	
}//End saveEventPromoImage


/**
 * 
 * Delete Promotional Media (Image)
 * @params int // mediaId
 * @params string // Table Name
 * 
**/

public function entityPromoMediaDelete($mediaId,$entityTableName)
{
	$this->CI->model_common->deletePromoMedia($mediaId,$entityTableName);
}


/*
 * Upload Promotional Media (Image)
*/
public function do_upload($imageFile,$mediaPath,$eventId='',$mediaType=1,$userfile='userfile',$fileMaxSize='')
{
		$fileMaxSize = ($fileMaxSize !='')?$fileMaxSize:$this->CI->config->item('image5MBSize');
		$data = '';
		$mergeError = 'Error in Uploading file: ';
		if($mediaType==1)
		{
			$mediaType = 'images';
			$config['allowed_types'] = $this->CI->config->item('imageMimeType');
			$config['max_size']		=  $fileMaxSize;
			$config['remove_spaces']= TRUE;
		}
		else if($mediaType==2)
		{
			$mediaType = 'video';
			$config['allowed_types'] 	= $this->CI->config->item('videoUploadAccept');
			$config['max_size']		=  $this->CI->config->item('videoSize');
			$mergeError = 'Error in Uploading video: ';
		}
		else if($mediaType==3)
		{
			$mediaType = 'audio';
			$config['allowed_types'] 	= $this->CI->config->item('audioAccept');
			
		}
		else if($mediaType==4)
		{
			$mediaType = 'documents';
			$config['allowed_types'] 	= $this->CI->config->item('writtenMaterialAccept');
		}
		elseif($mediaType=='pressRelease')
		{
			$config['allowed_types'] = $this->CI->config->item('prNewsAccept');
			$config['max_size']		=  $fileMaxSize;
			$config['remove_spaces']= TRUE;
		}
		else 
		{
			$mediaType = 'images';
			$config['allowed_types'] = $this->CI->config->item('imageAccept');
			$config['remove_spaces']= TRUE;
		}
		$currentMediaPath = $mediaPath;
		$cmd = 'chmod -R 777 '.$currentMediaPath;
		exec($cmd);
		
		if(!is_dir($currentMediaPath)){
			mkdir($currentMediaPath, 777, true);
		}
		$cmd = 'chmod -R 777 '.$currentMediaPath;
		exec($cmd);
		
		$_FILES['userfile']['name']     = $imageFile[$userfile]['name'];
		$_FILES['userfile']['type']     = $imageFile[$userfile]['type'];
		$_FILES['userfile']['tmp_name'] = $imageFile[$userfile]['tmp_name'];
		$_FILES['userfile']['error']    = $imageFile[$userfile]['error'];
		$_FILES['userfile']['size']     = $imageFile[$userfile]['size'];
		
		if(!empty($_FILES['PromoVideo']))
		Unset($_FILES['PromoVideo']);
		$this->CI->upload->initialize($config);
		$this->CI->upload->set_upload_path($mediaPath);
		$this->CI->load->library('upload', $config);
		if (!$this->CI->upload->do_upload()){
			$data = array('error' => $mergeError.$_FILES['userfile']['name'].':'.$this->CI->upload->display_errors());
		}
		else{
			$data = array('upload_data' => $this->CI->upload->data());
		}
		
		return $data;
	}

	public function countPromotionMedia($entityTableName,$entityId,$entityIdValue, $mediaType,$flag)
	{
		$recordSet = $this->CI->model_common->countPromotionMedia($entityTableName, $entityId,$entityIdValue, $mediaType, $flag);
		return $recordSet;
	}
	
}//End Class
?>
