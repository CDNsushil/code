<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class lib_recomamdations {
	/***
	create properties
	***/
	var $keys = array
	('refId' =>'',
	 'workProfileId' =>'',
	 'refFName'=> '', 
	 'refLName'=> '',	
	 'refCompName'=> '', 
	 'refAdd'=> '',	
	 'refCountry'=> '',
	 'refState'=> '', 
	 'refZip'=> '', 
	 'refEmail'=> '', 
	 'refContact'=> '', 
	 'refDescription'=> '',	
	 'refURL'=> '',	
	 'position'=> '', 
	 'refCity'=> '');

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
	}

	function getValuesFromDB($userId){
		$recordSet = $this->CI->model_workprofile->showReferencesRecommendation($userId);
		//echo "<pre />"; print_r($recordSet);
		$projIndex = 0;
		if(!empty($recordSet)){
			foreach($recordSet as $k => $object){
			   $projIndex++;//New Array Index
			   $this->setValues($object); //set the table field values using current class method
			   $variables = $this->getValues();//get the table field values using current class method

			   $WorkReferenceRecommendationList[$projIndex] = $variables;
			}
			return $WorkReferenceRecommendationList;
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
	 
	function getValueToUpdate($profileSocialLinkId)
	{
		$data =  $this->CI->model_workprofile->empReferencesRecommendationsRecordSet($profileSocialLinkId);	
		$this->setValues($data);
	}

	function save($table, $data){
		if($this->CI->input->post('mode')=="new"){
			$this->CI->model_common->addDataIntoTabel($table,$data);	
		}else if($this->CI->input->post('mode')=="edit")
		{
			$where = array('refId' => $data['refId']);
			$this->CI->model_common->editDataFromTabel($table,$data,$where);	
		}
		else
		{
			$this->CI->model_common->addDataIntoTabel($table,$data);
		}
	}
 }
	


