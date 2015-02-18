<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for User Member (enterprise)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_enterprises extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableUserShowcase					= 'UserShowcase';
		
	private $tableMasterRating					= 'MasterRating';	
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
	private $tableMasterIndustry				= 'MasterIndustry';
		
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogInvite						= 'LogInvite';	
	private $tableLogCrave						= 'LogCrave';	
	private $tableLogRating						= 'LogRating';	
	private $tableLogShare						= 'LogShare';	
	private $tableLogShow						= 'LogShow';
	
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	
	/**
	 * getProjectElements fucntion 
	 *
	 * getProjectElements call by  getProject function 
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	public function getProjectElements($projId=0,$elementTblPrefix='Fv', $elementId=0,$orderby='order',$order='ASC',$fetchElementFields='*',$industryType='')
	{
	   // Get Project elemnet data from table : (FvMedia, MaSong), ProjActivity, MediaFile
		$elementTable=$elementTblPrefix.$this->tableElement;
		$table=$this->db->dbprefix($elementTable);	
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);		
		$entityId=getMasterTableRecord($table);			

		$limit = 12;
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".projId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
		$this->db->select(''.$fetchElementFields.', '.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.tdsUid as projUserId,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.craveCount');
		
		$this->db->from($elementTable);
		$this->db->join($this->tableMasterIndustry,$this->tableMasterIndustry.'.IndustryId = '.$elementTable.'.industryId', 'left');
	
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->where($elementTable.'.description !=','');
		$this->db->where($this->tableMasterIndustry.'.IndustryName',$industryType);
		//$this->db->where($this->tableLogSummary.'.entityId',$entityId);
		if($elementId>0){	
			$this->db->where($elementTable.'.elementId',$elementId);
		}		
				
		if($orderby=='order'){
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		
		$this->db->limit($limit);
		 
		$query = $this->db->get();
		
		$result=$query->result();
		
		return $result;
	}		
	
}

/* End of file model_media.php */
/* Location: ./application/module/media/model/model_media.php */
