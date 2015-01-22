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

Class lib_work {
	/***
	create properties
	***/
	var $keys = array
	('workId' =>'',
	 'tdsUid' =>'',
	 'workTitle'=> '', 
	 'workDesc'=> '',	
	 'workShortDesc'=> '', 
	 'workTag'=> '',	
	 'workCity'=> '',
	 'workCityId'=> '', 
	 'workCountry'=> '', 
	 'workCountryId'=> '', 
	 'workLang1'=> '', 
	 'workLang2'=> '',	
	 'workLang3'=> '',	
	 'workPrice'=> '', 
	 'workLink'=> '',	
	 'workRecommendation'=> '', 
	 'workExperiece'=> '', 
	 'isUrgent'=> '', 
	 'workCreateDate'=> '',	
	 'workPublisheDate'=> '', 
	 'workExpireDate'=> '', 
	 'workType'=> '', 
	 'workRemuneration'=> '', 
	 'workReview'=> '', 
	 'workIndustryId'=> '', 
	 'workArchived'=> '', 
	 'workModifiedDate'=> '', 
	 'workEntryTime'=> '',
	 'workRenumUnit'=> '',
	 'workTypeAdditional'=> '',
	 'workCompany'=> '',
	 'workTypeDesc'=> '',
	 'userContainerId'=> 0,
	 );

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
	}
	function getWorks($workType='offered')
	{	
		 return $this->CI->model_work_offered->getWorks($workType);
	}
	
	function getworkdetail($userId=0,$workId=0,$workType='offered',$isPublished=1,$isArchive='f',$offset=0,$limit=0)
	{	
		 return $this->CI->model_work_offered->getworkdetail($userId,$workId,$workType,$isPublished,$isArchive,$offset,$limit);
	}
	
	function getValuesFromDB($userId, $workType, $deletedItems){
		$recordSet = $this->CI->model_work_offered->getWork($userId,$workType,$deletedItems);
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method

			   $getWorkList[$projIndex] = $variables;
			}
			return $getWorkList;
		}
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

	function getValueToUpdate($workId)
	{
		$data = $this->CI->model_work_offered->workOfferedForm($workId);
		$this->setValues($data);
		
	}

	function save($data)
	{
		$table = 'Work';
		$field = 'workId';

		if($this->CI->input->post('mode')=="new"){
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);	
			addDataIntoLogSummary($table,$id);
		}else
		{
			$ID = $data['workId'];
			$where = array('workId' => $data['workId']);
			$this->CI->model_common->editDataFromTabel($table, $data, $field, $ID);

			$id = $ID;
		}
		return $id;
	}
	
	
}
