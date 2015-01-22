<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for media (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_performancesnevents extends CI_Model {
	
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
	
	private $upcomingProjectMediaTableName      = 'TDS_UpcomingProjectMedia';
	private $upcomingProjectTableName 			= 'TDS_UpcomingProject';
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	private $eventTableName = 'Events';
	private $launchEventTableName = 'LaunchEvent';
	private $eventMediaTableName = 'EventMedia';
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
	public function getEvents($limit=0,$offset=0)
	{		
		$field = 'EventId,NatureId,EventDateCreated,Title,EventType,OneLineDescription,StartDate,FinishDate,'.$this->eventTableName.'.isPublished,'.$this->eventTableName.'.tdsUid,filePath,fileName';
		
		$orderBy = 'EventDateModified';
		
		$order = 'desc';
		$currentDateTime= currntDateTime();
		$interval=$this->config->item('eventShownForExtraDays');
		$eventShownForExtraDays=getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');	
		
		
		
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$entityId=getMasterTableRecord($this->eventTableName);
		
		$this->db->select($field);
		
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
		$this->db->select('up.firstName, up.lastName');
		$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
		
		$this->db->from($this->eventTableName);	
		$this->db->join($this->tableMediaFile,$this->tableMediaFile.'.fileId = '.$this->eventTableName.'.FileId', 'left');
		
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->eventTableName.'.EventId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->eventTableName.'.tdsUid','left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->eventTableName.".tdsUid");
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$this->eventTableName.'.EventId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		$this->db->where($this->eventTableName.'.isPublished', 't');
		//$this->db->where(array('FinishDate >= '=>"'".$eventShownForExtraDays."'"));
 
		$this->db->order_by($orderBy, $order);
	
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
			 
		$query = $this->db->get();
		
		return $query->result();
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
		$entityId=getMasterTableRecord($table);			

		$limit = 12;
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
		$this->db->select(''.$fetchElementFields.', '.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.tdsUid as projUserId');
		
		$this->db->from($elementTable);
		$this->db->join($this->tableMasterIndustry,$this->tableMasterIndustry.'.IndustryId = '.$elementTable.'.industryId', 'left');
	
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId', 'left');
		//$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->tableProject.".projId", 'left');
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
