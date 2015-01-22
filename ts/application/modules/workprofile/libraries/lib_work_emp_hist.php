<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class lib_work_emp_hist {
	/***
	create properties
	***/
	var $keys = array
	('empHistId' =>'',
	 'workProfileId' =>'',
	 'compName'=> '', 
	 'compAdd'=> '',	
	 'empStartDate'=> '', 
	 'empEndDate'=> '',	
	 'empStatus'=> '',
	 'compDesc'=> '', 
	 'empAchivments'=> '', 
	 'empDesignation'=> '', 
	 'empPublish'=> '', 
	 'position'=> '',	
	 'compCountry'=> '',	
	 'compState'=> '', 
	 'compZip'=> '',
	 'period'=> '', 	
	 'compCity'=> '');

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
		$recordSet = $this->CI->model_workprofile->showEmpHistory($userId);
		
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

	function getValueToUpdate($empHistId)
	{
		$data =  $this->CI->model_workprofile->empHistoryRecordSet($empHistId);
		$this->setValues($data);
	}

	function save($table, $data)
	{
	
		
		if($this->CI->input->post('mode')=="new")
		{
			//echo '<pre />Add';echo $table ; print_r($data);die;
			$this->CI->model_common->addDataIntoTabel($table,$data);	
		}
		else if($this->CI->input->post('mode')=="edit")
		{
			//echo '<pre />Edit'.$table;print_r($data);die;
			$where = array('empHistId' => $data['empHistId']);
			$this->CI->model_common->editDataFromTabel($table,$data,$where);	
		}
		else
		{
			//echo '<pre />else'.$table;print_r($data);die;
			$this->CI->model_common->addDataIntoTabel($table,$data);
		}
	}

}
