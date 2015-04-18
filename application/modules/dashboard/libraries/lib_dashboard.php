<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasqre Lib_upcomingproject Class
 *
 * manage Lib_upcomingproject details.
 *
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Mayank Kanungo
 * @link		http://www.cdnsol.com/
 */

Class lib_dashboard {
	/***
	create properties
	***/
	var $keys = array
	('contId' =>'',
	 'tdsUid' =>'',
	 'toadUid'=> '', 
	 'firstName'=> '',	
	 'lastName'=> '', 
	 'emailId'=> '',	
	 'phone'=> '',	
	 'profession'=> '',
	 'company'=> '', 
	 'imagePath'=> '', 
	 'toadsquareUrl'=> '', 
	 'address'=> '');

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
	}

	function getValuesFromDB($userId,$sort){
		if($sort == "" || $sort == "#")
			$recordSet = $this->CI->model_message_center->getContactList($userId);
		
		else
			$recordSet = $this->CI->model_message_center->getSortedContactList($userId,$sort);
		
		//print_r($recordSet);
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
				//echo "<pre />"; print_r($object);
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method

			   $getContactList[$projIndex] = $variables;
			}
			// echo "<pre />"; print_r($getContactList);
			return $getContactList;
		}
	 }
	 
	 function getUserValuesFromDB($contId){
		
		$recordSet = $this->CI->model_message_center->getUserContactList($contId);		
		return $recordSet;
	 }
	 
	 function getnextUserValuesFromDB($contId){
		
		$recordSet = $this->CI->model_message_center->getnextUserContactList($contId);		
		return $recordSet;
	 }
	 
	 function getpreviousUserValuesFromDB($contId){
		
		$recordSet = $this->CI->model_message_center->getpreviousUserContactList($contId);		
		return $recordSet;
	 }
	 
	 function getSearchedValuesFromDB($userId,$search){
		
			$recordSet = $this->CI->model_message_center->getSearchedContactList($userId,$search);
		
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
				//echo "<pre />"; print_r($object);
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method

			   $getContactList[$projIndex] = $variables;
			}
			// echo "<pre />"; print_r($getContactList);
			return $getContactList;
		}
	 }

	 function setValues($project_array){
		// echo "<pre />"; print_r($project_array);
		foreach($project_array as $k => $v){
			//echo "<pre />vvv----"; print_r($v);
			//echo "<pre />kkkk----"; print_r($k);
			if(isset($this->keys[$k])){
					$this->keys[$k] = $v;
			}
		}
	 }

	 function getValues(){
		return $this->keys;
	 }

	function getValueToUpdate($contId)
	{
		$data = $this->CI->model_message_center->contactRecordSet($contId);
		$this->setValues($data);
	}

	function save($data)
	{
		$table = 'UserContacts';
		$field = 'contId';
		$val1 = $this->CI->input->post('val1');
		
		if($val1['contId'] > 0){
			$ID = $data['contId'];
			$where = array('contId' => $data['contId']);
			$this->CI->model_common->editDataFromTabel($table, $data, $field, $ID);

			$id = $ID;
		}else{
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);
		}
		
		return $id;
	}

	function checkForEmail($emailId,$userId)
	{
		$result = $this->CI->model_message_center->checkForEmail($emailId,$userId);
		return $result;
	}
	function checkForUserContactEmail($emailId)
	{
		$result = $this->CI->model_message_center->checkForUserContactEmail($emailId);
		return $result;
	}
	function checkForProfileImage($tdsUid)
	{
		$result = $this->CI->model_message_center->checkForProfileImage($tdsUid);
		return $result;
	}
	function checkForstockImage($stockImageId)
	{
		$result = $this->CI->model_message_center->checkForstockImage($stockImageId);
		return $result;
	}
	
	
	function createProperCsv($data)
	{
		echo "<pre />"; print_r($data);
	}
}
