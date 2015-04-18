<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for media (Player)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class model_player extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableProjCategory					= 'ProjCategory';
	private $tableMasterIndustry				= 'MasterIndustry';
		
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
	
	private $tableMediaEelementType				= 'MediaEelementType';
	private $tableProjectType				    = 'MasterProjectType';
	
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	*/
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	
	
	/**
	 * getProjectRecord fucntion 
	 *
	 * get Project detail from database
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	public function getProjectRecord($projectId=0,$fetchFields='*'){
		
			$table = $this->db->dbprefix($this->tableProject);			
			
			$entityId = getMasterTableRecord($table);			
			
			$this->db->select(''.$fetchFields.', '.$this->tableProject.'.projId as projectid');
			
			$this->db->from($this->tableProject);
					
			if($projectId > 0){
				$this->db->where($this->tableProject.'.projId',$projectId);						
			}
			
			$this->db->order_by($this->tableProject.'.projLastModifyDate', 'DESC'); 
			
			$query = $this->db->get();
			
			return $result=$query->result();	
		
				
	}
	
	/**
	 * getVideo fucntion 
	 *
	 * @access	private
	 * @param	recordId
	 * @return	Object
	 * 
	 */
	public function getFile($recordId=0)
	{
		
		$fetchElementFields=" fileId,filePath,fileName";
		
		$this->db->select($fetchElementFields);		
		
		$this->db->from($this->tableMediaFile);	
		
		if($recordId>0){	
			$this->db->where($this->tableMediaFile.'.fileId',$recordId);
		}	
		$query = $this->db->get();
		
		$result=$query->result();
		//echo $this->db->last_query();//print_r($result);
		/*SELECT "TDS_ProfileMedia"."fileId", "filePath", "fileName" 
			FROM 
				"TDS_ProfileMedia" 
			
			WHERE "TDS_MediaFile"."fileId" = '4205'*/
		//die;
		echo "<pre>";print_r($result);die;
		return $result;
	}
	
	
	/*
	 *************************************** 
	 * This function use for player module for view padi view
	 *************************************** 
	 */  		 	
	
	function paidVideoDataByProjectId($projectId,$userId,$entityId)
	{
		$this->db->select('dwnMaxday,dwnDate,itemInfo');
		$this->db->from('SalesItemDownload');
		$this->db->where('"elementId" = '.$projectId.' AND "entityId" = '.$entityId.' AND "userId" = '.$userId);
		$this->db->order_by('dwnId','DESC');	
		$query =  $this->db->get();
		//echo $this->db->last_query();die();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->first_row();
		return $result;
	}
	
	
	/*
	 *************************************** 
	 * This function use for player module for view padi view
	 *************************************** 
	 */  		 	
	
	function paidVideoDataByElementId($projectId,$elementId,$entityId,$userId)
	{
		$this->db->select('dwnMaxday,dwnDate');
		$this->db->from('SalesItemDownload');
		$this->db->where('"projId" = '.$projectId.' AND "elementId" = '.$elementId.' AND "entityId" = '.$entityId.' AND "userId" = '.$userId);
		$this->db->order_by('dwnId','DESC');	
		$query =  $this->db->get();
		//echo $this->db->last_query();die();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->first_row();
		return $result;
	}
	
	
	/*
	 ***************************************** 
	 * This function is used to get paid element status
	 ****************************************  
	 */ 
	
	function getElementPaidStatus($elementId)
	{
		
		$this->db->select('FvElement.*');	
		$this->db->from('FvElement');
		//$this->db->join('MediaEelementType','MediaEelementType.elementTypeId = FvElement.mediaTypeId');		
		$this->db->where('FvElement.elementId',$elementId);	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->first_row();
		return $result;
	}
		
	
	
	/*
	 ***************************************** 
	 * This function is used to get paid element status
	 ****************************************  
	 */ 
	
	function getEMElementPaidStatus($elementId)
	{
		
		$this->db->select('EmElement.*');	
		$this->db->from('EmElement');
		//$this->db->join('MediaEelementType','MediaEelementType.elementTypeId = EmElement.mediaTypeId');		
		$this->db->where('EmElement.elementId',$elementId);	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->first_row();
		return $result;
	}
		
	
	
	
}

/* End of file model_media.php */
/* Location: ./application/module/media/model/model_media.php */
