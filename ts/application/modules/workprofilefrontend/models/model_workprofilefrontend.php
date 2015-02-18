<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 * Description:
	 * The model_workprofile class is meant to handle the processing of Work Profile Frontend section
	 * It include functionality to fetch/add/edit Videos,Images,Written Materials and Audios 
	 Author Name: Amit Wali
	 Date Created: 25 October 2012
	 
*/

class model_workprofilefrontend extends CI_Model {

	private $tabelWorkprofile = 'WorkProfile';
	private $tableProfileSocialLink = 'profileSocialLink';
	private $tableProfileEmpHistory = 'profileEmpHistory';
	private $tableProfileRecommendation = 'profileRecommendation';
	private $tableUserContacts = 'UserProfile';
	
	
	private $tableUsers = 'users';
	private $education = 'WorkProfileEducation';
	
	
	protected $tableName = 'ProfileMedia';
	protected $fieldType = 'mediaType';
	
	private $tableRecommendation = 'Recommendations';	
	private $tableUserAuth		= 'UserAuth';	
	private $tableUserShowcase	= 'UserShowcase';
	private $tableRequestUrl    = 'WorkProfileUrlRequest';
	
	

	// Constructor
	function __construct()
	{
		parent::__construct();
	}

	
	/***
	 
	 * 	Function to Get the Listing of Work
	
	***/
	
	function getWorkDetails($userId)
	{
	    $this->db->select('*');
		$fieldProfile = 'tdsUid';
		$this->db->where($fieldProfile,$userId);
		$workProfileResult = $this->db->get($this->tabelWorkprofile);
		//echo '<pre />workProfileId:';print_r($workProfileResult->result_array());	die;
		return $result =$workProfileResult->result();
		
	
		
	}
	
	
	/***
	 
	 * 	Function to Get the Listing of References 
	
	***/
	
	function getWorkRecommendation($workProfileId)
	 {		
		$field = 'workProfileId';
		$this->db->where($field,$workProfileId);
		$this->db->order_by('position','asc');
		$query = $this->db->get($this->tableProfileRecommendation);
		return $query->result();		
		
	}
	
	
	/***
	 
	 * 	Function to Get the Listing of Employe Video
	
	***/
	
	function showWorkShowcaseMedia($workProfileId=0,$fieldTypeValue)
	{
		
		$whereinfield = $this->tableName.'.'.$this->fieldType;
		$this->db->from($this->tableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->tableName.'.fileId');
		$this->db->where($this->tableName.'.workProfileId',$workProfileId);
		$this->db->where_in($whereinfield,"$fieldTypeValue");
		$dataShowcaseMedia = $this->db->get();
		//echo 'Last Query'.$this->db->last_query();
		//die;
		if(count($dataShowcaseMedia)>0)
			$dataShowcaseMedia = $dataShowcaseMedia->result();
		else
			$dataShowcaseMedia = 0;
			
			 //print_r($dataShowcaseMedia);
		return $dataShowcaseMedia;		
	}
	
	


	/***
	 
	 * 	Function to Get the Employe History
	
	***/

	

	function empHistoryRecordSet($workProfileId)
	{
		if($workProfileId > 0){
			$table = $this->tableProfileEmpHistory;
			$field = 'workProfileId';
			$this->db->where($field,$workProfileId);
			$this->db->where('empArchived','f');
			$dataEmpHistory = $this->db->get($table);
			//echo $this->db->last_query();
			//echo "<pre />"; print_r($dataEmpHistory->row());
			return $dataEmpHistory->result();
		}
	}

	
	/***
	 
	 * 	Function to Get the Work Profile Id Of User
	
	***/

	function checkForSetProfile($userId)
	{
		$this->db->select('workProfileId');
		$fieldProfile = 'tdsUid';
		$this->db->where($fieldProfile,$userId);
		$workProfileResult = $this->db->get($this->tabelWorkprofile);
		//echo '<pre />workProfileId:';print_r($workProfileResult->result_array());
		if($workProfileResult->num_rows()<1)
		{
			return 0;
		}
		else
		{
			$currentWorkProfileId = $workProfileResult->result_array();
			return $currentWorkProfileId[0]['workProfileId'];
		}
	}

	
	
	/***
	 
	 * 	Function to Get user education
	
	***/
	
	function getEducation($userId)
	{		
		 $this->db->select('year_from,year_to,university,degree');
		 $this->db->from($this->education);
		 $this->db->where('tdsUid',$userId);
		 $this->db->order_by("year_from", "desc"); //TO SHOW year ORDER
		 $query = $this->db->get();
		 return $query->result();		 
	}
	
	
	/***
	 
	 * 	Function to Get user education
	
	***/
	
	function getRecommendation($userId,$limit)
	{		
		
		 //$this->db->select('recommendations,created_date');
		 $this->db->select($this->tableRecommendation.'.recommendations, '.$this->tableRecommendation.'.created_date,'.$this->tableUserShowcase.'.tdsUid,'.$this->tableUserShowcase.'.firstName ,'.$this->tableUserShowcase.'.lastName , '.$this->tableUserShowcase.'.profileImageName, '.$this->tableUserAuth.'.username');
		 $this->db->from($this->tableRecommendation);
		 $this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableRecommendation.".from_userid", 'left');
		 $this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableRecommendation.".from_userid", 'left');		 
		 $this->db->where($this->tableRecommendation.'.to_userid',$userId);
		 $this->db->where($this->tableRecommendation.'.is_show_in_cv','t');
		/// $this->db->limit(1,$limit); //TO SHOW Limit
		 $this->db->order_by($this->tableRecommendation.'.id','asc'); 
		 $query = $this->db->get();		
		 //echo $this->db->last_query();
		//echo '<pre />Recommends:';print_r($query->result());	die;
		 return $query->result();		 
	}
	
	
	function checkTokenValidity($elemenetid,$token)	{
		$today = date("Y-m-d H:i:s"); 		          
        $field= 'DATE(expiry_date)';		
		$this->db->select('id');
		$this->db->from($this->tableRequestUrl);
		$this->db->where('id',$elemenetid);
        $this->db->where('access_token',$token);	
        $this->db->where($field.'>=',$today);
		 //echo $this->db->last_query();
		$query = $this->db->get();
        $result = $query->result();       
        
        if($query->num_rows() > 0) {
			return true;
		} else{
			  return false;
			}
		}
		
	function getUrlRequestId($Id)
	{		
		 $this->db->select('*');
		 $this->db->from($this->tableRequestUrl);
		 $this->db->where('id',$Id);		
		 $query = $this->db->get();
		 return $query->result();		 
	}	
		
		
		
		
		
		
}
?>
