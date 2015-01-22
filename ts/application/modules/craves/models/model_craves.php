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
class model_craves extends CI_Model {
	
	private $tableLogCrave 		= 'LogCrave'; 
	private $tableLogSummary	= 'LogSummary';
	private $tableUserProfile	= 'UserProfile';
	private $tableUserShowcase	= 'UserShowcase';
	private $tableStockImages	= 'StockImages';
	private $tableProject 		= 'Project';
	private $tableMaElement	    = 'MaElement' ;
	private $tableMediaFile		= 'MediaFile';
	private $tableCompetition	= 'Competition';
	private $tableCompetitionEntry	= 'CompetitionEntry';
	private $tableCompetitionShortlist	= 'CompetitionShortlist';
	
	
	
	
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
	 
	public function craveList($userId=0,$projectType='',$startFromWord='',$searchKey='',$limit=0,$retrunRow=false,$work='',$offset=0,$cravingme=false){

		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$search=$this->db->dbprefix('search');
		
		$projectType=trim($projectType);
		$searchKey=trim($searchKey);
		$searchKey=strtolower($searchKey);
		
		if(!empty($projectType)){
			if($projectType == 'performancesevents'){
				$where['lc.projectType']=$projectType;
			}else{
				$where['search.section']=$projectType;
			}
		}
		
		$this->db->select('lc.*');
		$this->db->select('search.*');
		$this->db->select('(item).*');
		
		$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount');
		
		$this->db->select('sc.profileImageName, sc.stockImageId, sc.creative, sc.associatedProfessional, sc.enterprise, sc.enterpriseName, sc.isPublished');
		$this->db->select('up.firstName,up.lastName');
		$this->db->select('si.stockImgPath, si.stockFilename');
		
		
		
		$this->db->from($this->tableLogCrave.' as lc');
		
		$this->db->join('search', 'search.entityid = lc.entityId AND "'.$search.'"."elementid"="lc"."elementId" ', 'left');
		
		if($cravingme){
			
			//$this->db->distinct('lc."tdsUid"');// added for distict users for creaving me
			
			$where['lc.ownerId']=$userId;
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = lc.tdsUid');
			$this->db->join($this->tableUserShowcase.' as showcase', 'showcase.tdsUid = lc.tdsUid');
			
			$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = showcase."showcaseId" AND "'.$tableLogSummary.'"."entityId"= 93', 'left');
			
			if(!empty($searchKey)){
				$array = array('LOWER(up."firstName")' => $searchKey, 'LOWER(up."lastName")' => $searchKey, 'LOWER(sc."enterpriseName")' => $searchKey);
				$this->db->or_like($array); 
			}
			if(!empty($startFromWord)){
				$array = array('LOWER(up."firstName")' => $startFromWord, 'LOWER(up."lastName")' => $startFromWord, 'LOWER(sc."enterpriseName")' => $startFromWord);
				$this->db->or_like($array); 
			}
			
		}else{
			$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.entityId = lc.entityId AND "'.$tableLogSummary.'"."elementId"="lc"."elementId" ', 'left');
			$where['lc.tdsUid']=$userId;
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = lc.ownerId');
			
			if(!empty($searchKey)){
				$array = array('LOWER((item).title)' => $searchKey, 'LOWER((item).tagwords)' => $searchKey, 'LOWER((item).online_desctiption)' => $searchKey, 'LOWER((item).creative_name)' => $searchKey, 'LOWER((item).creative_area)' => $searchKey);
				$this->db->or_like($array); 
			}
			if(!empty($startFromWord)){
				$this->db->like('LOWER((item).title)', $startFromWord, 'after'); 
			}
		}
		
		
		$this->db->join($this->tableUserShowcase.' as sc', 'sc.tdsUid = up.tdsUid');
		$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
		
		$this->db->where($where);
		
		
		
		if(($work==false))
		{
		   $this->db->where('search.section !=', 'work');
	    }
	
		$this->db->where('search.ispublished','t');
		
		$this->db->order_by("lc.createDate",'DESC');
		
		//$this->db->order_by("lc.tdsUid",'DESC');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($retrunRow)
			$result=$query->num_rows();
		else 
			$result=$query->result();
			
			return $result;
	}
	
	public function cravingmeUserList($userId=0,$projectType='',$startFromWord='',$searchKey='',$limit=0,$offset=0,$retrunRow=false){
		
		$entityId=getMasterTableRecord('UserShowcase');
		
		$projectType=trim($projectType);
		$searchKey=trim($searchKey);
		$searchKey=strtolower($searchKey);
		
		
		if(!empty($projectType) && $projectType != 'members'){
			$where['s.section']=$projectType;
		}
		
		if($projectType == 'members'){
			$where['sc.isPublished']='f';
		}else{
			//$where['sc.isPublished']='t';
		}
		
		$this->db->select('lc.*');
		$this->db->select('s.*');
		$this->db->select('(item).*');
		
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,ls.reviewCount');
		
		$this->db->select('sc.profileImageName, sc.stockImageId, sc.creative, sc.associatedProfessional, sc.enterprise, sc.enterpriseName, sc.isPublished');
		$this->db->select('up.firstName,up.lastName,up.tdsUid');
		$this->db->select('si.stockImgPath, si.stockFilename');
		
		$this->db->distinct('lc."tdsUid"');
		
		$this->db->from($this->tableLogCrave.' as lc');
		
		$this->db->join($this->tableUserShowcase.' as sc', 'sc.tdsUid = lc.tdsUid');
		$this->db->join($this->tableStockImages.' as si', 'si.stockImgId = sc.stockImageId', 'left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = lc.tdsUid');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId=sc.showcaseId AND "ls"."entityId" = '.$entityId.' ', 'left');
		$this->db->join('search as s', 's.elementid=sc.showcaseId AND s.entityid = '.$entityId.'  ', 'left');
		
		$where['lc.ownerId']=$userId;
		
		if(!empty($searchKey)){
			$array = array('LOWER(up."firstName")' => $searchKey, 'LOWER(up."lastName")' => $searchKey, 'LOWER(sc."enterpriseName")' => $searchKey);
			$this->db->or_like($array); 
		}
		if(!empty($startFromWord)){
			$array = array('LOWER(up."firstName")' => $startFromWord, 'LOWER(up."lastName")' => $startFromWord, 'LOWER(sc."enterpriseName")' => $startFromWord);
			$this->db->or_like($array); 
		}
			
		$this->db->where($where);
		
		$this->db->order_by("lc.tdsUid",'DESC');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($retrunRow)
			$result=$query->num_rows();
		else 
			$result=$query->result();
			
			return $result;
	}
	
	public function craveDropDwon($userId=0,$cravingme=false){
		$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
		$search=$this->db->dbprefix('search');
		
		if($cravingme){
			$having['ownerId']=$userId;
			// ADD BY AMIT FOR DISTINCT SECTIONS CRAVED BY USER issue 1066
			//$this->db->distinct(' "'.$this->db->dbprefix($this->tableLogCrave).'"."projectType" ,"'.$this->db->dbprefix($this->tableLogCrave).'"."tdsUid" ');
		}else{
			$having['tdsUid']=$userId;
		}
		
		$this->db->select($this->tableLogCrave.'.projectType');
		$this->db->from($this->tableLogCrave);
		$this->db->join('search', 'search.entityid = '.$this->tableLogCrave.'.entityId AND "'.$search.'"."elementid"="'.$tableLogCrave.'"."elementId" ', 'left');
		
		$this->db->where('search.id >', 0);
		
		$this->db->where('search.ispublished','t');
		
		$this->db->group_by(array('search.section', 'search.entityid', 'search.elementid', 'ownerId' , 'tdsUid', 'projectType')); 
		
		$this->db->having($having); 
		
		$this->db->order_by($this->tableLogCrave.'.projectType','ASC');
		
		//if($cravingme)		
		// $this->db->order_by($this->tableLogCrave.'.tdsUid','ASC'); // ADD BY AMIT FOR DISTINCT SECTIONS CRAVED BY USER issue 1066
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		return $result=$query->result();
	}
	
	
	/*
	 ********************************* 
	 * This function is used to get my playlist data 
	 ********************************* 
	 */ 
	
	function getMyPlaylistData($userId,$offset=0,$limit=0){
		
		$entityId=getMasterTableRecord('MaElement'); // set entity Id
		$projType='12'; // music category= music set proj Type
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableMediaFile=$this->db->dbprefix($this->tableMediaFile);
		$this->db->select($this->tableLogCrave.'.*');
		$this->db->select($this->tableMaElement.'.*');
		$this->db->select($this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.ratingAvg');
		$this->db->select($this->tableMediaFile.'.*');
		$this->db->from($this->tableLogCrave);
		
		$this->db->join($this->tableMaElement, $this->tableMaElement.'.elementId  = '.$this->tableLogCrave.'.elementId');
		$this->db->join($this->tableProject, $this->tableProject.'.projId  = '.$this->tableMaElement.'.projId');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableMaElement.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId);
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.'.fileId  = '.$this->tableMaElement.'.fileId AND "'.$tableMediaFile.'"."isExternal" = false');		
		
		$this->db->where($this->tableLogCrave.'.tdsUid',$userId);
		$this->db->where($this->tableLogCrave.'.entityId',$entityId);
		$this->db->where($this->tableLogCrave.'.deletedPlayList','f');
	
		$this->db->where($this->tableProject.'.isPublished','t');
		$this->db->where($this->tableMaElement.'.isPublished','t');
		//$this->db->where($this->tableMaElement.'.isPrice','f');
		$this->db->where($this->tableProject.'.projType',$projType);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get();
		return $result=$query->result_array();
	}
	
	/*
	 ********************************* 
	 * This function is used to get users short list data
	 ********************************* 
	 */ 
	function getCompetitionShortData($userId,$competitionId) {
		$this->db->select($this->tableCompetition.'.*');
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->from($this->tableCompetitionShortlist);
		$this->db->join($this->tableCompetitionEntry, $this->tableCompetitionEntry.'.competitionEntryId  = '.$this->tableCompetitionShortlist.'.competitionEntryId');
		$this->db->join($this->tableCompetition, $this->tableCompetition.'.competitionId  = '.$this->tableCompetitionShortlist.'.competitionId');
		$this->db->where($this->tableCompetitionShortlist.'.userId',$userId);
		if(isset($competitionId) && !empty($competitionId)) {
			$this->db->where($this->tableCompetitionShortlist.'.competitionId',$competitionId);
		}
		$query = $this->db->get();
		return $result=$query->result_array();
	}
	
	/*
	 ********************************* 
	 * This function is used to get users competition data
	 ********************************* 
	 */ 
	function getCompetitionData($userId) {
		$tableCompetitionShortlist=$this->db->dbprefix($this->tableCompetitionShortlist);
		$tableCompetition=$this->db->dbprefix($this->tableCompetition);
		$this->db->select($this->tableCompetitionShortlist.'"'.'."competitionId", COUNT("'.$tableCompetitionShortlist.'"."competitionId"),'.$this->tableCompetition.'.title'); 
		$this->db->from($this->tableCompetitionShortlist);
		$this->db->join($this->tableCompetition, $this->tableCompetition.'.competitionId  = '.$this->tableCompetitionShortlist.'.competitionId');
		$this->db->group_by($tableCompetitionShortlist.'.competitionId,'.$tableCompetition.'.title');  
		$this->db->where($this->tableCompetitionShortlist.'.userId',$userId);
		$query = $this->db->get();
		return $result=$query->result_array();
	}
}
