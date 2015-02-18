<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare dashboard Model Class
 *
 *  
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_dashboard extends CI_Model {
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	private $tableUserShowcase					= 'UserShowcase';	// user profiles
	private $UserSearchPreferences				= 'UserSearchPreferences';	// user profiles
	private $UserBuyerSettings					= 'UserBuyerSettings';	// user profiles
	private $UserSellerSettings					= 'UserSellerSettings';	// user profiles
	private $tableMessages						= 'tmail_messages';
    private $tableParticipants					= 'tmail_participants';
    private $tableStatus						= 'msg_status';
    private $tableThreads						= 'tmail_threads';
    private $tableWorkProfileRequest            = 'WorkProfileRequest';
    private $tableAttachment                    = 'tmail_attachment';
    private $tableWorkApplication               = 'WorkApplication';
    private $tableWork                          = 'Work';
    private $tableMasterIndustry                = 'MasterIndustry';
    private $tableRequestUrl                    = 'WorkProfileUrlRequest';
    private $LogCrave                           = 'LogCrave';
    private $LogSummary                         = 'LogSummary';
    private $tableProduct                       = 'Product';
    private $tablework 							= 'Work';
	private $tabelWorkApplication 				='WorkApplication';
	
	private $tableCollaboration = 'Collaboration'; 
	private $tableCollaborationMembers = 'CollaborationMembers'; 
	private $tabelProfileSocialLink 		    ='profileSocialLink';
	private $tabelprofileSocialMediaIcon	    ='profileSocialMediaIcon';
	
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
	public function getMembershipPackageList(){
		$this->db->select('*');
		$this->db->from('MasterPackage');
		$this->db->where('MasterPackage.pkgId != ',1);
		$this->db->order_by("MasterPackage.pkgId", "asc"); 
		$query = $this->db->get();
		return $result=$query->result(); 
	}
	public function ConsumptionTax($where=''){
		$this->db->select('ConsumptionTax.countryId,ConsumptionTax.stateId,ConsumptionTax.taxName,ConsumptionTax.taxPercentage');
		$this->db->select('MasterCountry.countryName');
		$this->db->select('MasterStates.stateName');
		$this->db->from('ConsumptionTax');
		$this->db->join('MasterCountry','MasterCountry.countryId = ConsumptionTax.countryId','left');
		$this->db->join('MasterStates','MasterStates.stateId = ConsumptionTax.stateId','left');
		if(is_array($where)){
			$this->db->where($where);
		}
		$this->db->order_by("stateId", "ASC"); 
		$query = $this->db->get();
		return $result=$query->result_array(); 
	}
		
	public function getContainerList(){
			$this->db->select('*');
			$this->db->from('MasterPackage');
			$this->db->join('UserContainer','UserContainer.pkgId = MasterPackage.pkgId');
			$this->db->order_by("MasterPackage.pkgId", "desc"); 
			$query = $this->db->get();
			return $result=$query->result();
		}
	
	public function getUserProfileData($userId)
	{
		$this->db->select($this->UserSearchPreferences.'.*');
		$this->db->select($this->UserSellerSettings.'.*, '.$this->UserSellerSettings.'.id as "userSellerSettingsId"');
		$this->db->select($this->UserBuyerSettings.'.*, '.$this->UserSellerSettings.'.id as "userBuyerSettingsId"');
		$this->db->select($this->tableUserProfile.'.*');
		$this->db->select($this->tableUserAuth.'.password,'.$this->tableUserAuth.'.email,'.$this->tableUserAuth.'.new_email,'.$this->tableUserAuth.'.new_email_key,');
		$this->db->select($this->tableUserShowcase.'.enterpriseName');
        $this->db->from($this->tableUserProfile);
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableUserProfile.'.tdsUid','left');
		$this->db->join($this->UserSearchPreferences, $this->UserSearchPreferences.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->UserSellerSettings, $this->UserSellerSettings.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->UserBuyerSettings, $this->UserBuyerSettings.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
        $this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->where($this->tableUserProfile.'.tdsUid', $userId);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()) return $query->result();
		return false;
	}
	/*Get user showcase lang */
	public function getUserShowcaseLanguage($showcaseId){
		$this->db->select('*');
		$this->db->from('UserShowcaseLang');
		$this->db->where('showcaseId',$showcaseId);
		$this->db->order_by("showcaseLangId", "ASC"); 
		return $this->db->get()->result();
	}
	/*Get Language of users showcase */
	public function getLangName($langId){
		$this->db->select('*');
		$this->db->from('MasterLang');
		$this->db->where('langId',$langId);
		return $this->db->get()->row();
	}
	
	/*Get getMettingPoint of user  */
	public function getMettingPoint($userId){
		$currentDateTime = currntDateTime();
		$meetingPointQuery = 'SELECT  "TDS_MeetingPoint"."id"
		FROM "TDS_MeetingPoint"
		 LEFT JOIN "TDS_EventSessions"
		ON "TDS_EventSessions"."sessionId" ="TDS_MeetingPoint"."session_id" 
		 LEFT JOIN "TDS_LaunchEvent"
		ON "TDS_LaunchEvent"."LaunchEventId" ="TDS_EventSessions"."launchEventId" 
		 LEFT JOIN "TDS_Events"
		ON "TDS_Events"."EventId" ="TDS_EventSessions"."eventId" 
		 WHERE  "TDS_MeetingPoint"."user_id"=\''.$userId.'\' AND  ("TDS_EventSessions"."date" >= \''.$currentDateTime.'\')';
		
		$executedQuery = $this->db->query($meetingPointQuery);		
		return $executedQuery->num_rows(); 
	}
	
	//To get count for work applied by logged in user
	function getWorkAppliedFor($user_id){			
		   		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);		   
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           $tableWorkApplication = $this->db->dbprefix($this->tableWorkApplication);
           $tableWork = $this->db->dbprefix($this->tableWork);
           $tableMasterIndustry =  $this->db->dbprefix($this->tableMasterIndustry);
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
          
			$sql = ' SELECT 
				    wa."workId"					
					FROM "'.$tableMessages.'" m
					JOIN "'.$tableWorkApplication.'" wa ON (wa."tmailId" = m.id)
					JOIN "'.$tableWork.'" w ON (w."workId" = wa."workId") 
					JOIN "'.$tableUser.'" u ON (u."tdsUid" = w."tdsUid") 					
					JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = w."tdsUid") 				
					JOIN "'.$tableMasterIndustry.'" i ON (i."IndustryId" = w."workIndustryId")
					JOIN "'.$tableParticipants.'" p ON (p."msg_id" = m."id")		
								
					WHERE wa."tdsUid" = '.$user_id.' AND p.is_sender = true AND p.status!=2 AND p.status!=3					
					group by wa."workId" 
					order by wa."workId" DESC				
				';			
			
			$query = $this->db->query($sql);
			$res = $query->num_rows();
			
			return $res;
	}
	
	//To get count for work application received for logged in user
	function getWorkAppReceived($userId){
			
		   $tableMessages=$this->db->dbprefix($this->tableMessages);		   
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           $tableWorkApplication = $this->db->dbprefix($this->tableWorkApplication);
           $tableWork = $this->db->dbprefix($this->tableWork);
           $tableMasterIndustry =  $this->db->dbprefix($this->tableMasterIndustry);
           $tableAttachment = $this->db->dbprefix($this->tableAttachment);
           $tableRequestUrl = $this->db->dbprefix($this->tableRequestUrl);
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
          
		  $sql = ' SELECT DISTINCT (wa."appId")										
					FROM "'.$tableMessages.'" m
					JOIN "'.$tableWorkApplication.'" wa ON (wa."tmailId" = m.id)					
					JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 					
					JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = wa."tdsUid")  
					JOIN "'.$tableWork.'" w ON (w."workId" = wa."workId") 
					JOIN "'.$tableMasterIndustry.'" i ON (i."IndustryId" = w."workIndustryId") 
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = wa."tmailId") 
					LEFT JOIN "'.$tableRequestUrl.'" tr ON (attachment)."elementid" = tr."id"	
					LEFT JOIN "'.$tableParticipants.'" p ON (p."msg_id" = m."id")					
					WHERE p.is_sender = false 
					AND p.status!=2 
					AND p.status!=3	
					AND w."tdsUid"='.$userId.'	
				';
			
			$query = $this->db->query($sql);
			$res = $query->num_rows();
		
			return $res;
	}
	
	/*Get Language of users showcase */
	public function UserProjectsMoveInTrash($projectField=''){
		if(isset($projectField['table']) && isset($projectField['primeryField']) && isset($projectField['publishedField']) && isset($projectField['elementId'])){
			if( $this->db->table_exists($projectField['table']) ){
				$edtitData=false;
				if ($this->db->field_exists($projectField['primeryField'], $projectField['table'])){
					
					if ($this->db->field_exists($projectField['publishedField'], $projectField['table'])){
						$edtitData[$projectField['publishedField']]='f';
					}
					if ($this->db->field_exists($projectField['archiveField'], $projectField['table'])){
						$edtitData[$projectField['archiveField']]='t';
					}
					
					if ($this->db->field_exists($projectField['ModifiedDateField'], $projectField['table'])){
						$edtitData[$projectField['ModifiedDateField']] = currntDateTime();
					}
					
					if($edtitData){
						$this->db->where_in($projectField['primeryField'],$projectField['elementId']); 
						$this->db->update($projectField['table'] , $edtitData);
					}
				} 
			}
		}
	}
	
	/*Get Language of users showcase */
	public function UserProjectsMoveFromTrash($projectField=''){
		if(isset($projectField['table']) && isset($projectField['primeryField']) && isset($projectField['publishedField']) && isset($projectField['elementId'])){
			if( $this->db->table_exists($projectField['table']) ){
				$edtitData=false;
				if ($this->db->field_exists($projectField['primeryField'], $projectField['table'])){
					
					if ($this->db->field_exists($projectField['publishedField'], $projectField['table'])){
						$edtitData[$projectField['publishedField']]='t';
					}
					if ($this->db->field_exists($projectField['archiveField'], $projectField['table'])){
						$edtitData[$projectField['archiveField']]='f';
					}
					
					if ($this->db->field_exists($projectField['ModifiedDateField'], $projectField['table'])){
						$edtitData[$projectField['ModifiedDateField']] = currntDateTime();
					}
					
					if($edtitData){
						$this->db->where_in($projectField['primeryField'],$projectField['elementId']); 
						$this->db->update($projectField['table'] , $edtitData);
					}
				} 
			}
		}
	}
	
	/*
	 * Function to get email ids
	 */
	function checNewEmail($secEmail){
		$this->db->select('email');
		$this->db->from('UserAuth');
		$this->db->where('email',$secEmail);
		return $this->db->get()->result();
	}
	
	/*
	 * Function to check secondary email with existing emails
	 */
	function checkExistingEmails($secEmail){
		
		$this->db->select('1', FALSE);
		$this->db->where('active !=','2');
		$this->db->where('LOWER(email)=', strtolower($secEmail));
		$this->db->or_where('LOWER(new_email)=', strtolower($secEmail));
		
		$query = $this->db->get('UserAuth');
		return $query->num_rows() == 0;
	}
	
	function assignedCollaborationToUser($where=array(),$orderBy='clb.lastModifyDate',$order='DESC'){
	
		$this->db->select('cm.memberId,cm.collaborationId,cm.userId,cm.createdDate');
		$this->db->select('clb.title,clb.shortDescription,clb.startDate,clb.endDate,clb.coverImage');
		
		$this->db->from($this->tableCollaborationMembers.' as cm');
		$this->db->join($this->tableCollaboration.' as clb', 'clb.collaborationId=cm.collaborationId');
		
		$this->db->where($where);
		$this->db->order_by( $orderBy, $order);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	/**
	 * Function to insert social media data
	 */
	function addSocialMediaData($data)
	{
		if(isset($data['profileSocialLinkId']) && !empty($data['profileSocialLinkId'])) {
			$socialUpdateData = array(
				'socialLink'=>$data['socialLink'],
				'profileSocialLinkType'=>$data['profileSocialLinkType'],
				'socialLinkDateModified'=>date("Y-m-d H:i:s"),							
			);	
			$this->db->where('profileSocialLinkId',$data['profileSocialLinkId']);	
			$this->db->update($this->tabelProfileSocialLink,$socialUpdateData);
		} else {
			$this->db->insert($this->tabelProfileSocialLink,$data);
		}
		return true;
	}
	
	/**
	 * Function to get users social media data  
	 */
	function getSocialMediaData($userId)
	{
		$this->db->select('psl.*');
		$this->db->select('smi.profileSocialMediaName,smi.profileSocialMediaPath');
		$this->db->from($this->tabelProfileSocialLink.' as psl');
		$this->db->join($this->tabelprofileSocialMediaIcon.' as smi','smi.profileSocialMediaId = psl.profileSocialLinkType');
		$this->db->where('userId',$userId);
		return $this->db->get()->result();
	}
	
	/**
	* Remove social media link data
	*/
	public function removeSocialMediaData($socialMediaId)
    {
		$data = array('profileSocialLinkId' => $socialMediaId,);   
		$this->db->delete($this->tabelProfileSocialLink, $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/**
	 * Function to update social media section
	 */
	function updateSocialMediaSections($socialLinkId,$data)
	{
		$this->db->where('profileSocialLinkId',$socialLinkId);	
		$this->db->update($this->tabelProfileSocialLink,$data);
		return true;
	}
}
