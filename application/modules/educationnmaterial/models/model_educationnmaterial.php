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
class model_educationnmaterial extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableProjCategory					= 'ProjCategory';
	private $tableMasterIndustry				= 'MasterIndustry';
	private $tableGenre							= 'Genre';
	private $tableOffers							= 'Offers';
	private $tableMasterRating					= 'MasterRating';	
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
		
	private $tableProjectPromotion 			    = 'ProjectPromotion';
	private $tableProjectShipping			    = 'ProjectShipping';
	
	private $tableAssociativeCreatives		    = 'AssociativeCreatives';
		
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogInvite						= 'LogInvite';	
	private $tableLogCrave						= 'LogCrave';	
	private $tableLogRating						= 'LogRating';	
	private $tableLogShare						= 'LogShare';	
	private $tableLogShow						= 'LogShow';
	private $tableMediaEelementType				= 'MediaEelementType';
	private $tableProjectType				    = 'MasterProjectType';
	private $upcomingProjectMediaTableName      = 'TDS_UpcomingProjectMedia';
	private $upcomingProjectTableName 			= 'TDS_UpcomingProject';
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	
	private $tableUserContainer					= 'UserContainer';

	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	
	/**
	 * getProject fucntion 
	 *
	 * getProject call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	 
	public function getProject($UserId=0,$projectType='',$projectId=0,$elementTblPrefix='Fv',$orderby='order',$order='ASC',$fetchFields='*',$fetchElementFields='*',$elementOrderBy){		
		//Get Project data from table : Project, ProjActivity, users and dicription
		
		$result = $this->getProjectRecord($projectType,$UserId,$projectId,$fetchFields);
		//echo $this->db->last_query(); die;
		if($result && (!empty($elementTblPrefix) )){
				// Call getProjectElements function to get project element data
				foreach($result as $key=>$data){
					$result[$key]->elements=$this->getProjectElements($data->projectid,$elementTblPrefix,0,$elementOrderBy,$order);			
				}
		}
		return $result;
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
	public function getProjectRecord($projectType='',$UserId=0,$projectId=0,$fetchFields='*'){
			$table=$this->db->dbprefix($this->tableProject);			
			$entityId=getMasterTableRecord($table);			
			$this->db->select(''.$fetchFields.', '.$this->tableProject.'.projId as projectid');
			$this->db->from($this->tableProject);
			
			$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->tableProject.".projId", 'left');
						
			$this->db->where($this->tableLogSummary.'.entityId',$entityId);
			$this->db->where($this->tableProject.'.isArchive','f');
			if(!empty($projectType)){
				$this->db->where($this->tableProject.'.projectType',$projectType);				
			}
			if($UserId > 0){
				$this->db->where($this->tableProject.'.tdsUid',$UserId);						
			}
			if($projectId > 0){
				$this->db->where($this->tableProject.'.projId',$projectId);						
			}
			
			$this->db->where($this->tableProject.'.isPublished','t');	
			
			$this->db->order_by($this->tableProject.'.projLastModifyDate', 'DESC'); 
			//$this->db->limit(1);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			return $result=$query->result();
		
		
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
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
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
	
	public function getNews($fetchFileds="*",$userId=0, $section){
		//  Get Project offer data from table : (FvOffer, MaOffer)
		$date=date('Y-m-d');
		$this->db->select($fetchFileds);
		$this->db->from($this->tableProject);		
		$this->db->where_in($this->tableProject.'.projectType',$section);		
		$this->db->order_by($this->tableProject.'.projLastModifyDate', 'DESC'); 
		$this->db->order_by($this->tableProject.'.projectType', 'DESC'); 
		$query = $this->db->get();
		$result = $query->result();
		//echo $this->db->last_query();die;
		return $result;
	}
	
}

/* End of file model_media.php */
/* Location: ./application/module/media/model/model_media.php */
