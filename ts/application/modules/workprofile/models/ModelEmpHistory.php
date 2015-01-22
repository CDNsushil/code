<?php
/*
	 Description:
	 * The ModelEmpHistory class is meant to handle the processing of the ModelEmpHistory section
	 * It include functionality to fetch/add/edit ModelEmpHistory content for logged in user 
	 Author Name: Gurutva Singh
	 Date Created: 24 January 2012
	 Date Modified: 9 Februray 2012 by Gurutva Singh	
*/
Class ModelEmpHistory extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	function index($EmpHistoryId)
	{			
		if($EmpHistoryId !=0){
			$empHistoryIdField = $EmpHistoryId;
			$table = 'ProfileEmpHistory';
			$field = 'empHistId';
			$this->db->where($field,$empHistoryIdField);
			$dataEmpHistory = $this->db->get($table);	
			$dataEmpHistory = $dataEmpHistory->result_array();	
			$dataEmpHistory = $dataEmpHistory[0];		
		}  
		else{
			$dataEmpHistory['compName'] = '';
			$dataEmpHistory['empStartDate'] = '';
			$dataEmpHistory['empEndDate'] = '';
			$dataEmpHistory['compAdd'] = '';
			$dataEmpHistory['compDesc'] = '';
			$dataEmpHistory['empAchivments'] = '';
			$dataEmpHistory['empDesignation'] = '';
		}
		return $dataEmpHistory;	
	}
/**
	* showWorkShowcaseVideos method fetches the records form Profile Media of Type Videos
	* giving the values in the options array priority.
	*
	* @param int $workProfileId
	* @return array
*/
	function showEmpHistory($workProfileId){
		$table = 'ProfileEmpHistory';
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$dataEmpHistory = $this->db->get($table);	
		$dataEmpHistory = $dataEmpHistory->result_array();	
		//$dataEmpHistory = $dataEmpHistory[0];
		return $dataEmpHistory;
	}
/**
	* showEmpHistoryPerRecord method fetches the records form Work Profile
	* giving the values in the options array priority.
	*
	* @param int $workProfileId
	* @return array
*/
	function showEmpHistoryPerRecord($workProfileId=0){
	
		$table = 'ProfileEmpHistory';
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$dataEmpHistory = $this->db->get($table);	
		$dataEmpHistory = $dataEmpHistory->result_array();	
		//$dataEmpHistory = $dataEmpHistory[0];
		$dataEmpHistory['workProfileId'] = $workProfileId;
		return $dataEmpHistory;	
	}
/**
	* updatePost method Inserts a record in the "WorkProfile" table.
	*
	* Post: Values
	* --------------
	* compName            (required)
	* compAdd		  (required)
	* empAchivments		  (required)
	* empDesignation	  	      (required)
	* empPublish	  (required)
	* @param int workProfileId
*/
	function updatePost(){	
		foreach($_POST['EmpHisId'] as $id =>$stats) {
		
			$this->workProfileId   = $_POST['workProfileId']; 
			//$this->empHistoryId   = $stats; 
			$this->compName = $_POST['compName'][$id];
			
			//if($_POST['compAdd'][$id] != '')	
			$this->compAdd = $_POST['compAdd'][$id];
					
			//if($_POST['compDesc'][$id] != '')
			$this->compDesc = $_POST['compDesc'][$id];
			
			//if($_POST['empAchivments'][$id] != '')
			$this->empAchivments = $_POST['empAchivments'][$id];
			
			//if($_POST['empDesignation'][$id] != '')
			$this->empDesignation = $_POST['empDesignation'][$id];
			
			if(isset($_POST['empPublish'][$id]) && $_POST['empPublish'][$id] == 1)	$this->empPublish = 't';
			else $this->empPublish = 'f';
			
			$field = 'empHistId';
			 
			if($stats == 0) {
				
				$this->db->insert('ProfileEmpHistory' , $this);
			}
			else {
				$this->db->where($field,$stats);			
				$this->db->update('ProfileEmpHistory',$this);
			}
			//echo 'Update '.$_POST['compName'][$stats].'<br />';
		 }
	
		return $this->workProfileId;		
	}
	
	function addMore($data){
	$this->load->view('addMore',$data);
	}
	
	
}

?>