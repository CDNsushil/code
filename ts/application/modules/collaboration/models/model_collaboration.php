<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare Collaboration Model Class
 *
 *  Fetch data for Collaboration
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_Collaboration extends CI_Model {
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	private $tableCollaboration = 'Collaboration'; 
	private $tableCollaborationAccess = 'CollaborationAccess'; 
	private $tableCollaborationMedia = 'CollaborationMedia'; 
	private $tableCollaborationMediaExchange = 'CollaborationMediaExchange'; 
	private $tableCollaborationMembers = 'CollaborationMembers'; 
	private $tableCollaborationMembersAccess = 'CollaborationMembersAccess'; 
	private $tableCollaborationMilestoones = 'CollaborationMilestoones'; 
	private $tableCollaborationTaskAssignee = 'CollaborationTaskAssignee'; 
	private $tableCollaborationTasks = 'CollaborationTasks'; 
	private $tableCollaborationComments = 'CollaborationComments'; 
	
	private $tableUserShowcase			= 'UserShowcase';
	private $tableMediaFile				= 'MediaFile';
	private $tableLogSummary			= 'LogSummary';	
	private $tableUserContainer			= 'UserContainer';
	private $tableUserAuth				= 'UserAuth';
	private $tableUserProfile			= 'UserProfile';
	private $tableStockImages			= 'StockImages';
	private $tableLogCrave				= 'LogCrave';
	private $tableMasterLang			= 'MasterLang';
	private $tableMasterCountry			= 'MasterCountry';
	private $tableMasterIndustry		= 'MasterIndustry';
	private $tblContinent				= 'MasterContinent';
	private $tblTmailParticipants		= 'tmail_participants';
	private $tblTmailMessages			= 'tmail_messages';
	
	private $tableAttachment            = 'tmail_attachment';
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	public function getCollaborationDetails($where=array(), $limit=1, $orderBy='clb.lastModifyDate', $order='DESC'){
			$this->db->select('clb.*');
			$this->db->select('cont.containerSize,cont.expiryDate');
			
			$this->db->select('ind.IndustryName');
			$this->db->select('lang.Language,lang.Language_local');
			$this->db->select('cnt.countryName');
			
			$this->db->from($this->tableCollaboration.' as clb');
			$this->db->join($this->tableUserContainer.' as cont', 'cont.userContainerId=clb.userContainerId');
			
			$this->db->join($this->tableMasterLang.' as lang', 'lang.langId = clb.langId1', 'left');
			$this->db->join($this->tableMasterCountry.' as cnt', 'cnt.countryId = clb.countryId', 'left');
			$this->db->join($this->tableMasterIndustry.' as ind', 'ind.IndustryId = clb.industryId', 'left');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			$this->db->limit($limit);	
			
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
	}
	
	public function getCollaborationMedia($where=array(), $limit=0, $orderBy='mf.fileCreateDate', $order='DESC'){
			$this->db->select('cm.*');
			$this->db->select('mf.*');
			
			$this->db->from($this->tableCollaboration.' as clb');
			$this->db->join($this->tableCollaborationMedia.' as cm', 'cm.collaborationId=clb.collaborationId');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=cm.fileId');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
	}
	
	public function getMediaExchange($where=array(), $orderBy='mf.fileCreateDate', $order='DESC', $limit=0){
			$this->db->select('cm.*');
			$this->db->select('mf.*');
			
			$this->db->from($this->tableCollaborationMediaExchange.' as cm');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=cm.fileId');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();
	}
	

	public function getCollaborationMembers($where=array(), $limit=0, $orderBy='us.firstName', $order='ASC'){
		$this->db->select('up.firstName, up.lastName,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName');
		$this->db->select('u.tdsUid,u.email');
		$this->db->select('cm.collaborationId,cm.memberId,cm.userId');
		$this->db->select('ma.accessId,ma.memberAccessId');
		
		
		$this->db->from($this->tableCollaboration.' as clb');
		$this->db->join($this->tableCollaborationMembers.' as cm', 'cm.collaborationId=clb.collaborationId','left');
		$this->db->join($this->tableCollaborationMembersAccess.' as ma', 'ma.memberId=cm.memberId AND ma."collaborationId"=clb."collaborationId"','left');
			
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=cm.userId','left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=cm.userId','left');
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid=cm.userId','left');
		
		$this->db->where($where);
		$this->db->order_by( $orderBy, $order);
		
		if(is_numeric($limit) && $limit >= 1){
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
		
		
		return $result;
	}
	
	public function getMEmembersDetails($membersId=array(), $orderBy='up.firstName', $order='ASC'){
		$this->db->select('up.firstName, up.lastName,up.tdsUid,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName');
		
		$this->db->from($this->tableCollaborationMembers.' as cm');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=cm.userId','left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=cm.userId','left');
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid=cm.userId','left');
		
		$this->db->where_in('cm.memberId', $membersId);
		
		$this->db->order_by( $orderBy, $order);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	/**
	* Get Users listing.
	*/
	public function getUsersListing($like='',$limit=0,$offset=0)
	{
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		if(!empty($like)) {
			$likes = explode(' ',$like);
			$like_array= array();
			foreach($likes as $like){
				if(!empty($like)){
					$this->db->or_like(array('LOWER("firstName")'=>strtolower($like),'LOWER("lastName")'=>strtolower($like)));
				}
			}
			
		}
		
		$this->db->where(array('isBlocked'=>'f','isExpired'=>'f','isArchive'=>'f'));
		$this->db->order_by('firstName asc');
		$q = $this->db->get_where('UserShowcase');
		//echo $this->db->last_query();
		return $q->result();
	}
	
	/*
	 * Insert collaboration user
	 */
	 public function insertMember($data) {
		$this->db->insert($this->tableCollaborationMembers, $data);
		$insertedId = $this->db->insert_id();
	
		return $memberId ;
	 }
	 
	/*
	 * Remove Collaboration member record
	 */
	public function removeColMember($memberId) {
		$data = array(
			'memberId' => $memberId,
		); 
		$this->db->delete($this->tableCollaborationMembers, $data);    
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}   
	}
	
	public function getCollaborationMilestones($where=array(),$orderBy='cm.startDate', $order='ASC', $limit=0, $offset=0){
			$this->db->select('cm.*');
			
			$this->db->from($this->tableCollaboration.' as clb');
			$this->db->join($this->tableCollaborationMilestoones.' as cm', 'cm.collaborationId=clb.collaborationId');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	public function getCollaborationTodos($where=array(),$orderBy='ct.startDate', $order='ASC', $limit=0, $offset=0){
			$this->db->select('ct.*');
			$this->db->select('ta.memberId');
			$this->db->select('tm.userId');
			
			$this->db->select('ua.username');
			$this->db->select('up.firstName, up.lastName,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName,us.profileImageName');
			$this->db->select('us.stockImageId,si.stockImgPath,si.stockFilename');
			
			$this->db->from($this->tableCollaboration.' as clb');
			$this->db->join($this->tableCollaborationTasks.' as ct', 'ct.collaborationId=clb.collaborationId');
			$this->db->join($this->tableCollaborationTaskAssignee.' as ta', 'ta.taskId=ct.taskId', 'left');
			$this->db->join($this->tableCollaborationMembers.' as tm', 'tm.memberId=ta.memberId', 'left');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=tm.userId','left');
			$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=tm.userId','left');
			$this->db->join($this->tableUserAuth.' as ua', 'ua.tdsUid=tm.userId','left');
			$this->db->join($this->tableStockImages.' as si', "si.stockImgId = us.stockImageId", 'left');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			return $query->result();
	}
	public function getTodosComments($where=array(),$orderBy='tc.date', $order='DESC', $limit=0, $offset=0){
			$this->db->select('tc.*');
			$this->db->select('ua.username');
			$this->db->select('up.firstName, up.lastName,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName,us.profileImageName');
			$this->db->select('us.stockImageId,si.stockImgPath,si.stockFilename');
			$this->db->select('mf.*');
			
			$this->db->from($this->tableCollaborationComments.' as tc');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=tc.userId','left');
			$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=tc.userId','left');
			$this->db->join($this->tableUserAuth.' as ua', 'ua.tdsUid=tc.userId','left');
			$this->db->join($this->tableStockImages.' as si', "si.stockImgId = us.stockImageId", 'left');
			
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=tc.fileId','left');
			
			$this->db->where($where);
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	/*
	 * Function to get users communication tmail records
	 */

	public function getCommunicationTmail($userId,$limit=0,$offset=0) {
		$this->db->select('tp.msg_id,tp.user_id,tp.status');
		$this->db->select('tm.subject,tm.body,tm.cdate,tm.sender_id,tm.id');
		$this->db->from($this->tblTmailParticipants.' as tp');
		$this->db->join($this->tblTmailMessages.' as tm', 'tm.id=tp.msg_id');
		$this->db->where(array('tp.user_id'=>$userId,'tp.is_sender'=>'f','tp.status !='=>2,'tm.type'=>11));
		$this->db->order_by( 'tp.msg_id','DESC');
		
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}	
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*
	 * Function to get users communication tmail records
	 */

	public function getCommunication($where=array(),$limit=0,$offset=0) {
		$this->db->select('tm.*');
		
		$this->db->select('ua.username');
		$this->db->select('up.firstName, up.lastName,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName,us.profileImageName');
		$this->db->select('us.stockImageId,si.stockImgPath,si.stockFilename');
		
		$this->db->select('mf.*');
		
		$this->db->from($this->tblTmailMessages.' as tm');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=tm.sender_id','left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=tm.sender_id','left');
		$this->db->join($this->tableUserAuth.' as ua', 'ua.tdsUid=tm.sender_id','left');
		$this->db->join($this->tableStockImages.' as si', "si.stockImgId = us.stockImageId", 'left');

		
		$this->db->join($this->tableAttachment.' as ta', 'ta.msg_id=tm.id','left');
		$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=ta.fileId','left');
			
		$this->db->where($where);
		$this->db->where(array('tm.type'=>11));
		$this->db->order_by( 'tm.id','DESC');
		
		
		
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}	
		
		$query = $this->db->get();
		return $query->result();
	}
	
	/*
	 * Function used to get tmail msg data
	 */
	public function getTmailData($msgId,$userId,$type) {
		$this->db->select('tm.subject,tm.body,tm.cdate,tm.sender_id,tm.thread_id,tm.type');
		$this->db->select('tp.id as pr_id');
		$this->db->select('us.firstName,us.lastName');
		$this->db->from($this->tblTmailMessages.' as tm');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=tm.sender_id');
		$this->db->join($this->tblTmailParticipants.' as tp','tp.thread_id=tm.thread_id', 'left');
		$this->db->where(array('tm.id'=>$msgId,'tp.user_id'=>$userId,'us.tdsUid'=>$userId));
		$query = $this->db->get();
		//$result = $query->row();
		return $query->result_array();
	}
	
	public function getAssignedMilestonData($where=array(),$orderBy='cm.createdDate', $order='ASC', $limit=0, $offset=0){
			$this->db->select('cm.milestoneId,cm.title');
			
			$this->db->from($this->tableCollaboration.' as clb');
			$this->db->join($this->tableCollaborationTasks.' as ct', 'ct.collaborationId=clb.collaborationId');
			$this->db->join($this->tableCollaborationMilestoones.' as cm', 'cm.milestoneId=ct.milestoneId');
			
			$this->db->where($where);
			$this->db->group_by(array('cm.milestoneId','cm.title'));
			$this->db->order_by( $orderBy, $order);
			
			if(is_numeric($limit) && $limit >= 1){
				$this->db->limit($limit);
			}	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	/*
	 * Function used to get msg attachment data
	 */
	public function getAttachmentData($msgId) {
		$this->db->select('ta.fileId,ta.id');
		$this->db->select('mf.filePath,mf.fileName,mf.jobStsatus,mf.rawFileName');
		$this->db->from($this->tableAttachment.' as ta');
		$this->db->join($this->tableMediaFile.' as mf', 'ta.fileId=mf.fileId');
		$this->db->where(array('ta.msg_id'=>$msgId));
		$this->db->limit(1);
		$query = $this->db->get();
		return $result = $query->row();
	}
	
	function assignedCollaborationToUser($where=array(),$orderBy='clb.lastModifyDate',$order='DESC'){
	
		$this->db->select('cm.memberId,cm.userId,cm.createdDate');
		$this->db->select('clb.*');
		$this->db->select('up.firstName, up.lastName,us.showcaseId,us.creative,us.associatedProfessional,us.enterprise,us.isPublished,us.enterpriseName');
		
		
		$this->db->select('ind.IndustryName');
		$this->db->select('lang.Language,lang.Language_local');
		$this->db->select('cnt.countryName');
			
			
			
		
		$this->db->from($this->tableCollaborationMembers.' as cm');
		$this->db->join($this->tableCollaboration.' as clb', 'clb.collaborationId=cm.collaborationId');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid=clb.userId','left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=clb.userId','left');
		$this->db->join($this->tableMasterLang.' as lang', 'lang.langId = clb.langId1', 'left');
		$this->db->join($this->tableMasterCountry.' as cnt', 'cnt.countryId = clb.countryId', 'left');
		$this->db->join($this->tableMasterIndustry.' as ind', 'ind.IndustryId = clb.industryId', 'left');
		
		$this->db->where($where);
		$this->db->order_by( $orderBy, $order);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	/*
	 * Function to get users communication  sent tmail records
	 */
	public function getCommunicationSentTmail($userId,$limit=0,$offset=0) {
		$this->db->select('tm.subject,tm.body,tm.cdate,tm.sender_id,tm.id');
		$this->db->select('tp.msg_id,tp.user_id,tp.status');
		$this->db->from($this->tblTmailMessages.' as tm');
		$this->db->join($this->tblTmailParticipants.' as tp', 'tp.msg_id=tm.id');
		$this->db->where(array('tm.sender_id'=>$userId,'tp.is_sender'=>'f','tp.status !='=>2,'tm.type'=>11));
		$this->db->order_by( 'tm.id','DESC');
		
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}	
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*
	 * Function used to get sent tmail msg data
	 */
	public function getSentTmailData($msgId,$userId) {
		$this->db->select('tm.subject,tm.body,tm.cdate,tm.sender_id,tm.thread_id,tm.type');
		$this->db->select('tp.id as pr_id,tp.user_id');
		$this->db->select('us.firstName,us.lastName');
		$this->db->from($this->tblTmailParticipants.' as tp');
		$this->db->join($this->tblTmailMessages.' as tm','tm.thread_id=tp.thread_id', 'left');
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid=tp.user_id');
		$this->db->where(array('tm.id'=>$msgId,'tp.user_id'=>$userId));
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getMembersAccess($where=array()) {
		$this->db->select('ma.accessId');
		$this->db->from($this->tableCollaborationMembers.' as cm');
		$this->db->join($this->tableCollaborationMembersAccess.' as ma', 'ma.memberId=cm.memberId AND ma."collaborationId"=cm."collaborationId"');
		
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}

}
