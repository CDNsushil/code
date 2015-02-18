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
class model_showproject extends CI_Model {
	
	private $tableAssociativeCreatives 	= 'AssociativeCreatives'; 
	private $tableShowProject			= 'ShowProject';
	private $tableUserAuth				= 'UserAuth';
	private $tableUserProfile			= 'UserProfile';
	private $tableUserShowcase			= 'UserShowcase';
	private $tableLogSummary	        = 'LogSummary';
	private $tableLogCrave	            = 'LogCrave';
	
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	/**
	 * mediaLastInsertDtaData fucntion 
	 *
	 * mediaLastInsertDtaData call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function associativeCreatives ($entityId=0,$elementId=0){
		
		$tableShowProject=$this->db->dbprefix($this->tableShowProject);
		$tableAssociativeCreatives=$this->db->dbprefix($this->tableAssociativeCreatives);
		
		$this->db->select('ac.crtEmail,ac.crtName,ac.crtDesignation,');
		$this->db->select('us.tdsUid');
		$this->db->select($this->tableShowProject.'.id as showprojectid');
		
		$this->db->from($this->tableAssociativeCreatives.' as ac');
		$this->db->join($this->tableUserAuth.' as ua', 'ua.email = ac.crtEmail', 'left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid = ua.tdsUid', 'left');
		
		$this->db->join($this->tableShowProject, $this->tableShowProject.'.entityid = ac."entityId"  AND "'.$tableShowProject.'"."elementid"=ac."elementId" AND "'.$tableShowProject.'"."receiverid"=ua."tdsUid" ', 'left');
		
		$this->db->where('us.tdsUid > ',0);
		$this->db->where('entityId',$entityId);
		$this->db->where('elementId',$elementId);
		$this->db->where('crtStatus','t');
		
		$this->db->order_by('crtName','ASC');
		$query = $this->db->get();
		$this->db->last_query();
		return $result=$query->result_array();
	}
	public function showProjects($userId=0,$projectType='',$searchKey='',$limit=0,$retrunRow=false){
		
		$tableShowProject=$this->db->dbprefix($this->tableShowProject);
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$search=$this->db->dbprefix('search');
		
		$where['receiverid']=$userId;
		$where['status']='t';
		$where['search.ispublished']='t';
		$projectType=trim($projectType);
		
		if(!empty($projectType)){
			$where['section']=$projectType;
		}
		
		$this->db->select('(item).*');
		$this->db->select('search.*');
	
		$this->db->select($this->tableLogSummary.'.craveCount, '.$this->tableLogSummary.'.ratingAvg, '.$this->tableLogSummary.'.viewCount, '.$this->tableLogSummary.'.reviewCount, '.$this->tableLogSummary.'.dvdCount, '.$this->tableLogSummary.'.videoFileCount');
		$this->db->from($this->tableShowProject);
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.entityId = '.$this->tableShowProject.'.entityid AND "'.$tableLogSummary.'"."elementId"="'.$tableShowProject.'"."elementid" ', 'left');
		$this->db->join('search', 'search.entityid = '.$this->tableShowProject.'.entityid AND "'.$search.'"."elementid"="'.$tableShowProject.'"."elementid" ', 'left');
		
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
				$this->db->select($this->tableLogCrave.'.craveId');
				$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.entityId = '.$this->tableShowProject.'.entityid AND "'.$tableLogCrave.'"."elementId"="'.$tableShowProject.'"."elementid" AND "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
		}
		
		$this->db->where($where);
		$this->db->where('search.id >', 0);
		$searchKey=trim($searchKey);
		$searchKey=strtolower($searchKey);
		if(!empty($searchKey)){
			$array = array('LOWER((item).title)' => $searchKey, 'LOWER((item).tagwords)' => $searchKey, 'LOWER((item).online_desctiption)' => $searchKey, 'LOWER((item).creative_name)' => $searchKey, 'LOWER((item).creative_area)' => $searchKey);
			$this->db->or_like($array); 

		}
		
		$this->db->order_by("search.elementid",'DESC');
		if($limit > 0)
		$this->db->limit($limit);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($retrunRow)
			return $query->num_rows();
		else 
			return $result=$query->result();
	}
	public function spDropDwon($userId=0){
		
		$tableShowProject=$this->db->dbprefix($this->tableShowProject);
		$search=$this->db->dbprefix('search');
		$this->db->select('search.section');
		$this->db->from($this->tableShowProject);
		$this->db->join('search', 'search.entityid = '.$this->tableShowProject.'.entityid AND "'.$search.'"."elementid"="'.$tableShowProject.'"."elementid" ', 'left');
		$this->db->where('search.id >', 0);
		$this->db->group_by(array('search.section', 'search.entityid', 'search.elementid', 'receiverid')); 
		$this->db->having('receiverid', $userId); 
		
		$this->db->order_by('search.section','ASC');
		$query = $this->db->get();
		return $result=$query->result();
	}
	
}
