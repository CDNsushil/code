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

Class Lib_upcomingprojects {
	/***
	create properties
	***/
	var $keys = array('projId' =>'', 'tdsUid' =>'',	'projTitle'=> '', 'proShortDesc'=> '',	'projTag'=> '', 'projDescription'=> '',	'projGenre'=> '','projLanguage'=> '', 'projRating'=> '', 'projCreateDate'=> '', 'projPublisheDate'=> '', 'projEntryTime'=> '',	'projStatus'=> '',	'projIndustry'=> '', 'projCountry'=> '',	'projCity'=> '', 'projReleaseDate'=> '', 'projAddress'=> '', 'projStreet'=> '',	'projZip'=> '', 'isEducationMaterial'=> '',	'isEvent'=> '',	'projUpType'=> '',	'askForDonation'=> '',	'projType'=> '','projTypeOther'=>'','projGenreFree'=>'','projCategory'=>'','isPublished'=>'','projAddress2'=>'','projModifiedDate'=>'','rating'=>'','userContainerId'=>0);

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
		$this->CI->load->model('model_upcomingprojects');
	}

	 /**METHODS**/

	/* function getValuesFromDB($userId){
		 //getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0 ){
		$recordSet = $this->CI->model_common->getDataFromTabel('TDS_UpcomingProject', '*',  'userId', $userId, '', '', 0 );
		$this->setValues($recordSet);
		$data = $this->getValues();
		return $recordSet;
	 }*/

	 function getValuesFromDB($userId=0,$projId=0,$isPublished=1,$isArchive='f',$offset=0,$limit=0){
		 
		$upcomingProjectList = $this->CI->model_upcomingprojects->getupcomingdetail($userId,$projId,$isPublished,$isArchive,$offset,$limit);
		//$recordSet = $this->CI->model_common->getDataFromTabel('TDS_UpcomingProject', '*',  'tdsUid', $userId, 'projId', 'asc', 0 );
		//echo "<pre />"; print_r($recordSet);die;
		
		/*
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method
			   $upcomingProjectList[$projIndex] = $variables;
			}
			
			return $upcomingProjectList;
		}
		*/
		return $upcomingProjectList;
	 }
	 
	 function deletedItems($userId){
		 
		$recordSet = $this->CI->model_upcomingprojects->deletedItems($userId);
		//$recordSet = $this->CI->model_common->getDataFromTabel('TDS_UpcomingProject', '*',  'tdsUid', $userId, 'projId', 'asc', 0 );
		//echo "<pre />"; print_r($recordSet);
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method

			   $upcomingProjectList[$projIndex] = $variables;
			}
			return $upcomingProjectList;
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

	 function save($data){
		
			if($this->CI->input->post('mode')=="new"){
				$up_projId = $this->CI->model_upcomingprojects->insertRecord('TDS_UpcomingProject',$data);	
			}else
			{
				$where = array('projId' => $data['projId']);
				$up_projId = $this->CI->model_upcomingprojects->updateRecord('TDS_UpcomingProject',$data,$where);	
			}
			return $up_projId;
	 }

	function getValueToUpdate($projId)
	{
		$data = $this->CI->model_upcomingprojects->getValueToUpdate($projId);	
		$this->setValues($data);
	}
}
