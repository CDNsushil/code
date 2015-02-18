<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for User Member (FrontEnd Products)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_works extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	private $tablework = 'Work';
	private $tableUserShowcase					= 'UserShowcase';
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogCrave						= 'LogCrave';
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
				
		if($orderby=='order')
		{
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else
		{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		
		$this->db->limit($limit);
		 
		$query = $this->db->get();
		
		$result=$query->result();
		//echo $this->db->last_query();die;
		return $result;
	}	
	
	function getWorks($where='',$limit=0,$offset=0)
	{			
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$entityId=getMasterTableRecord($this->tablework);
		
		$workPromotionMedia=$this->db->dbprefix('workPromotionMedia');
		
		$this->db->select('w.workId,w.tdsUid,w.workTitle,w.workShortDesc,w.workType,w.isPublished,w.isUrgent,w.workExperiece,w.workExpireDate,w.workPublisheDate');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
		$this->db->select('up.firstName, up.lastName');
		$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
			
		$this->db->from($this->tablework.' as w');
		$this->db->join("workPromotionMedia", "workPromotionMedia.workId = w.workId AND \"".$workPromotionMedia."\".\"isMain\"='t' ", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = workPromotionMedia.fileId", 'left');
		
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = w.workId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = w.tdsUid','left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = w.tdsUid");
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$this->db->select($this->tableLogCrave.'.craveId');
			$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = w.workId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		if(is_array($where) && count($where) > 0){
			$this->db->where($where);
		}
		
		$this->db->order_by('workModifiedDate', 'desc');
		
		if(is_numeric($limit) && ($limit > 0)){
			$this->db->limit($limit,$offset);
		}
		
		$query =  $this->db->get();	
		
		return $query->result();	
	}	
	
}

/* End of file model_products.php */
/* Location: ./application/module/media/model/model_media.php */
