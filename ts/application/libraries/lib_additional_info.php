<?php
class lib_additional_info{

private $tableName = '';
private $fieldKeys = array();
var $keys = array
	('profileSocialLinkId' =>'',
	 'socialLink' =>'',
	 'profileSocialMediaId'=> '', 
	 'profileSocialLinkType'=> '',	
	 'workProfileId'=> '', 
	 'socialLinkDateCreated'=> '',	
	 'socialLinkDateModified'=> '',
	 'position'=> '',
	 'profileSocialMediaName'=> '',
	 'profileSocialMediaPath'=> '');
	 
 /**
 * Constructor
 */
function __construct($infoArray=array('tableName'=>'','fieldKeys'=>array()))
{

	$this->tableName = $infoArray['tableName'];
	$this->fieldKeys = $infoArray['fieldKeys'];	

	$this->now = time();
	$this->CI =& get_instance();
	//load libraries
	$this->CI->load->database();
	$this->CI->load->library('upload');
	$this->CI->load->library('lib_image_config');
	
}

public function setFieldKeys($tableFieldArray)
{ 	
 
  $this->fieldKeys = $tableFieldArray;  
  return $this->fieldKeys;

}//function getValues

 public function getFieldKeys()
 { 	
 
  $say['fieldKeys']=$this->fieldKeys;  
  $say['tableName']=$this->tableName;  
  return  $say;

 }//function getValues
 
 public function listAdditionalInfo($whereArray,$orderBy='',$limit=0,$flagPosition=0)
 {
	  $addInfoListArray = $this->CI->model_common->listAdditionalInfo($this->tableName,$whereArray,$orderBy,'',$limit=0,$flagPosition);
	  return $addInfoListArray;
 }
 
 //If Flag=0 is used to include position field 
 public function saveAdditionalInfo($fieldValues,$primaryKey,$flag)
 {   
  //echo "Flag=".$flag;
  //die();
   $returnId = $this->CI->model_common->saveAdditionalInfo($this->tableName,$fieldValues,$primaryKey,$flag); 
   return $returnId;
 }
	
 public function delAdditionalInfo($primaryKey,$newsIdForDelete)
 { 
  
   $this->CI->model_common->deleteRowFromTabel($this->tableName,$primaryKey,$newsIdForDelete); 
 }
 
 public function shiftCellAdditionalInfo($primaryKey,$currentId,$currentPos,$swapId,$swapPos)
 { 
   $this->CI->model_common->shiftCellAdditionalInfo($this->tableName,$primaryKey,$currentId,$currentPos,$swapId,$swapPos); 
 }
 
 
  function setValues($project_array){
		foreach($project_array as $k => $v){
			if(isset($this->keys[$k])){
					$this->keys[$k] = $v;
			}
		}
	 }
	 function getValues(){
		return $this->keys;
	 }
	 
	function getValuesFromDB($entityId){
		
		$recordSet = $this->CI->model_common->getSocialMedia($entityId);
		
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method
			   $WorkSocialMediaList[$projIndex] = $variables;
			}
			
			return $WorkSocialMediaList;
		}
	}
	
	function getValuesFromSocialMedia($whereArray){
		
		$recordSet = $this->CI->model_common->getDetailSocialMedia($whereArray);
		
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method
			   $WorkSocialMediaList[$projIndex] = $variables;
			}
			//echo '<pre />';print_r($WorkSocialMediaList);die;
			return $WorkSocialMediaList;
		}
	}
}//End Class
?>
