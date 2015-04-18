<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class lib_workprofile {
	/***
	create properties
	***/
	var $keys = array
	('workProfileId' =>'',
	 'tdsUid' =>'',
	 'profileCountry'=> '', 
	 'profileCity'=> '',	
	 'profilePhone'=> '', 
	 'remunerationRate'=> 0,	
	 'profileFName'=> '',
	 'profileLName'=> '', 
	 'synopsis'=> '', 
	 'languagesKnown'=> '', 
	 'nationality'=> '', 
	 'visaAvailable'=> '',	
	 'availability'=> '',	
	 'noticePeriod'=> '', 
	 'remunerationRequired'=> '',	
	 'education'=> '', 
	 'achievmentsAndAwards'=> '', 
	 'referRecom'=> '', 
	 'profileAdd'=> '',	
	 'profileStreet'=> '', 
	 'profileState'=> '',
	 'profileEmail'=> '',
	 'profileZip'=> '', 
	 'fileId'=> 0,
	 'isPublished'=> 't',
	 'countriesInterestWorking'=> '',
	 'minContractMonth'=> '',
	 'maxContractMonth'=> '',
	 'isContractWork'=> 'f',);

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
		$recordSet = $this->CI->model_workprofile->index($userId);
		$projIndex = 0;
		if(!empty($recordSet)){
			$this->setValues($recordSet); 
			$variables = $this->getValues();
			return $variables;
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

	function getValueToUpdate($productId,$catId)
	{
		$data = $this->CI->model_product->productSellRecordSet($productId,$catId);
		$this->setValues($data);
	}

	function save($data)
	{
		$table = 'WorkProfile';
		$field = 'productId';

		if($this->CI->input->post('mode')=="new"){
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);	
			addDataIntoLogSummary($table,$id);
		}else if($this->CI->input->post('mode')=="edit")
		{
			$ID = $data['productId'];
			$where = array('productId' => $data['productId']);
			$this->CI->model_common->editDataFromTabel($table, $data, $field, $ID);

			$id = $ID;
		}else
		{
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);	
			addDataIntoLogSummary($table,$id);
		}
		return $id;
	}
}
