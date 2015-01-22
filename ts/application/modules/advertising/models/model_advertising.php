<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare advirtising Model Class
 *
 *  Fetch data for Advirtising section
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_advertising extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	
	private $tableCampaigns			 		= 'ox_campaigns'; 
	private $tableBanners		     		= 'ox_banners'; 
	private $tableOxUsers			 		= 'ox_users';
	private $tableOxAccount			 		= 'ox_accounts';
	private $tableUserAuth		     		= 'UserAuth';  
	private $tableUserShowcase	     		= 'UserShowcase';  
	private $tableOxClients			 		= 'ox_clients'; 
	private $tableOxManageUsers		 		= 'ox_manage_users'; 
	private $tableOxAccountUserAssoc 		= 'ox_account_user_assoc'; 
	private $tableOxAdZoneAssoc     	 	= 'ox_ad_zone_assoc'; 
	private $tableOxUserPermissionAssoc 	= 'ox_account_user_permission_assoc'; 
	private $tableOxDataBktM 				= 'ox_data_bkt_m'; 
	private $tableOxDataBktC 				= 'ox_data_bkt_c'; 
	private $tableOxCampaignLog				= 'ox_campaign_log'; 
	
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();	  // Call parent constructer	
	}
	
	/*
	 *  This function is used to get existing users Id
	 */ 
	public function getExistingUserId($userId) {
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('id,advirtiserId');	
		$this->db->from($this->tableOxManageUsers);
		$this->db->where('logginUserId',$userId);	
		$query = $this->db->get();
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->result_array();
	}
	
	/*
	 *  This function is used to get user details
	 */ 
	public function getUserData($userId){
		$this->db->set_dbprefix('TDS_'); //Set custom prefix		
	
		$this->db->select($this->tableUserAuth.'.*');
		$this->db->select('us.firstName'); 
		$this->db->from($this->tableUserAuth);
		$this->db->join($this->tableUserShowcase.' as us', 'us.tdsUid = '.$this->tableUserAuth.'.tdsUid');		
		$this->db->where($this->tableUserAuth.'.tdsUid',$userId);
		$query = $this->db->get();
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->result_array();		
	}

	/*
	 *  This function is used to create new ox user
	 */ 
	public function createOxUser($oxUserData){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
		//Insert data into ox_users tbl
		$this->db->insert($this->tableOxUsers,$oxUserData); 
		$oxUserId = $this->db->insert_id();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $oxUserId; 
	}
	
	/*
	 *  This function is used to add user account in ox 
	 */ 
	public function addOxAccount($oxAccountData){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		$this->db->insert($this->tableOxAccount,$oxAccountData); 	
		$accountId = $this->db->insert_id();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $accountId; 
	}
	
	/*
	 *  This function is used to add data for user permission in ox 
	 */ 
	public function addAccountPermission($userPermissionData){	
		//Insert data into ox_account_user_permission_assoc tbl
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->insert($this->tableOxUserPermissionAssoc,$userPermissionData); 
		$accountPermissionId = $this->db->insert_id();
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
	
		return $accountPermissionId; 
	}
	
	/*
	 *  This function is used to add data for user account assoc
	 */ 
	public function addAccountAssoc($oxUserAssocData){	
		//Insert data into ox_account_user_permission_assoc tbl
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->insert($this->tableOxAccountUserAssoc,$oxUserAssocData); 
		$accountAssocId = $this->db->insert_id();
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $accountAssocId; 
	}
	
	/*
	 *  This function is used to add new advertiser 
	 */ 
	public function addAdvertiser($oxClientData){
		$this->db->set_dbprefix('tds_'); //Set custom prefix	
	
		//Insert data into ox_clients tbl
		$this->db->insert($this->tableOxClients,$oxClientData); 
		$advirtiserId = $this->db->insert_id();	
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $advirtiserId; 
	}
	
	/*
	 *  This function is used to add users records
	 */ 
	public function insertUsersRecord($userData){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		//Insert data into ox_manage_users tbl
		$this->db->insert($this->tableOxManageUsers,$userData); 	
		$recordId = $this->db->insert_id();	
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $recordId; 
	}
	
	/*
	 *  This function is used to insert campaign data
	 */ 
	public function addCampaign($data){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		$this->db->insert($this->tableCampaigns,$data); 		
		$campaignId = $this->db->insert_id();	
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $campaignId; 
	}
	
	/*
	 *  This function is used to insert banner data
	 */ 
	public function addOxAdvert($data){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		$this->db->insert($this->tableBanners,$data); 		
		$bannerId = $this->db->insert_id();	
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $bannerId; 
	}
	
	/*
	 *  This function is used to add Ad zone
	 */ 
	public function addOxAdZone($data){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		$this->db->insert($this->tableOxAdZoneAssoc,$data); 		
		$zoneId = $this->db->insert_id();	

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $zoneId; 
	}
	
	/*
	 *  This function is used to get ox users data
	 */
	public function getOxUsersData($userId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix
	
		$this->db->select($this->tableOxManageUsers.'.*');
		$this->db->select('ad.clientname,ad.email,ad.account_id');	
		$this->db->select('ou.contact_name,ou.contact_name,ou.username');
		//$this->db->select('c.campaignid');
		$this->db->from($this->tableOxManageUsers);	
		$this->db->join($this->tableOxClients.' as ad', 'ad.clientid = '.$this->tableOxManageUsers.'.advirtiserId','left');
		$this->db->join($this->tableOxUsers.' as ou', 'ou.user_id = '.$this->tableOxManageUsers.'.oxUserId','left');
		//$this->db->join($this->tableCampaigns.' as c', 'c.clientid = '.$this->tableOxManageUsers.'.advirtiserId','left');
		$this->db->where($this->tableOxManageUsers.'.logginUserId',$userId);
		$this->db->limit(1);
		$query = $this->db->get();		
		//echo $this->db->last_query();
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();	
	}
	
	/*
	 *  This function is used to get campaign details
	 *  @param : advirtiserId 
	 *  @param : campaignId   
	 */ 
	 
	public function getCampaignData($campaignId=0){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableCampaigns);
		$this->db->where($this->tableCampaigns.'.campaignid',$campaignId);
		$query = $this->db->get();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	/*
	 *  This function is used to get campaign details
	 */ 
	public function getCampaignDetails($advirtiserId,$campaignId=0){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableCampaigns);
		$this->db->where($this->tableCampaigns.'.campaignid',$campaignId);
		$this->db->where($this->tableCampaigns.'.clientid',$advirtiserId);
		$query = $this->db->get();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->result_array();		
	}
	
	/*
	 * This function is used to update campaign record
	*/
	function updateCampaign($data,$campaignId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->where('campaignid', $campaignId);
		$this->db->update($this->tableCampaigns, $data);
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
	/*
	 * This function is used to update bannner/advert record
	*/
	function updateOxAdvert($data,$bannerId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
		
		$this->db->where('bannerid', $bannerId);
		$this->db->update($this->tableBanners, $data);
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
	/*
	 *  This function is used to get bannner/advert details
	 */ 
	public function getAdvertDetails($campaignId){
		$this->db->set_dbprefix('tds_'); //Set prefix for opex tables		
		
		$this->db->select('bannerid,htmltemplate,url,html_template_field as htmltemplatefield,storagetype,description as title,width as filewidth,height as fileheight,filename as fileinput,campaignid,advert_order as advertorder,contenttype,banner_sections');
		$this->db->from($this->tableBanners);
		$this->db->where($this->tableBanners.'.campaignid',$campaignId);
		$query = $this->db->get();
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->result();		
		
	}
		
	/*
	 *  This function is used to delete bannner/advert records
	 */ 
	public function deleteAdvertData($table='', $field='', $ID=0, $limit=0){
		$this->db->set_dbprefix('tds_'); //Set custom prefix
				
		$Flag=false;
		if($table!='' && $field!=''){
			if(is_array($ID) && count($ID)){
				$this->db->where_in($field ,$ID);
			}elseif(is_array($field) && count($field) > 0){
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
			}
			if($limit >0){
				$this->db->limit($limit);
			}
			if($this->db->delete($table)){
				$Flag=true;
			}
		}
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $Flag;
	}
	
	
	/*
	 *  This function is used to get banner details
	 */ 
	public function getBannerDetails($bannerId){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableBanners);
		$this->db->where($this->tableBanners.'.bannerid',$bannerId);
		$query = $this->db->get();
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	/*
	 * @description : This function is used to get compaign banner list
	 * @retrun : Compaign and banner data
	 * 
	 */ 
	 
	 
	public function getShowCampaign($advertType=0){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableCampaigns);
		$this->db->join($this->tableBanners.' as tb', 'tb.campaignid = '.$this->tableCampaigns.'.campaignid');		
		$this->db->order_by($this->tableCampaigns.'.id', 'RANDOM');
		$this->db->limit(1);
		$this->db->where($this->tableCampaigns.'.viewed_impression >',0);
		$this->db->where($this->tableCampaigns.'.is_advert','t');
		$this->db->where($this->tableCampaigns.'.is_published','t');
		$this->db->where('tb.advert_order',$advertType);
		$query = $this->db->get();
	
		//echo $this->db->last_query();die();
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	/*
	 *  This function is used to get banner details
	 */ 
	public function getShowBanner($campaignid,$advertType){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableBanners);
		$this->db->where($this->tableBanners.'.campaignid',$campaignid);
		//$this->db->where($this->tableBanners.'.campaignid',29);
		$this->db->where($this->tableBanners.'.advert_order',$advertType);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	
	
	/*
	 *  This function is used to get impression details
	 */ 
	public function getimpression($bannerid){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableOxDataBktM);
		$this->db->where($this->tableOxDataBktM.'.creative_id ',$bannerid);
		$query = $this->db->get();
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	
	/*
	 *  This function is used to get impression details
	 */ 
	public function getimpressioncount($bannerIds){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select_sum('count');
		$this->db->from($this->tableOxDataBktM);
		$this->db->where_in($this->tableOxDataBktM.'.creative_id ',$bannerIds);
		$query = $this->db->get();
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	
	
	
	/*
	 *  This function is used to insert new impression
	 */ 
	public function insertimpression($insertData){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
		
		//Insert data into tableOxDataBktM tbl
		$this->db->insert($this->tableOxDataBktM,$insertData); 
	//	$insertId = $this->db->insert_id();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $oxUserId; 
	}
	
	
	/*
	 * This function is used to update impression
	*/
	function updateimpression($updateData,$bannerid){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->where('creative_id', $bannerid);
		$this->db->update($this->tableOxDataBktM, $updateData);
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
	
	
	/*
	 *  This function is used to get click advert details
	 */ 
	public function getclickadvert($bannerid){
	
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableOxDataBktC);
		$this->db->where($this->tableOxDataBktC.'.creative_id ',$bannerid);
		$query = $this->db->get();
	
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	
	/*
	 *  This function is used to insert new click advert
	 */ 
	public function insertclickadvert($insertData){	
		$this->db->set_dbprefix('tds_'); //Set custom prefix
		
		//Insert data into tableOxDataBktM tbl
		$this->db->insert($this->tableOxDataBktC,$insertData); 
		//$insertId = $this->db->insert_id();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $oxUserId; 
	}
	
	
	/*
	 * This function is used to update click advert
	*/
	function updateclickadvert($updateData,$bannerid){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->where('creative_id', $bannerid);
		$this->db->update($this->tableOxDataBktC, $updateData);
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
	
	
	/*
	 *  This function is used to get campaign details
	 */ 
	public function getCampaignLatest($advirtiserId,$campaignId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('*');
		$this->db->from($this->tableCampaigns);
		$this->db->where($this->tableCampaigns.'.clientid',$advirtiserId);
		if($campaignId > 0){
			$this->db->where($this->tableCampaigns.'.campaignid',$campaignId);
		}else{
			$this->db->order_by($this->tableCampaigns.'.campaignid', 'DESC');
		}
		$this->db->limit(1);
		$query = $this->db->get();
		
		//echo $this->db->last_query();die();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();		
	}
	
	
	/*
	 *  This function is used to get campaign details
	 */ 
	public function getCampaignList($advirtiserId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
	
		$this->db->select('campaignid,campaignname');
		$this->db->from($this->tableCampaigns);
		$this->db->where($this->tableCampaigns.'.clientid',$advirtiserId);
		$this->db->order_by($this->tableCampaigns.'.campaignid', 'DESC');
		$query = $this->db->get();
		
		//echo $this->db->last_query();die();

		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->result();		
	}
	
	
	/*
	 * This function is used to update bannner/advert status by campaignId
	 */
	function updateAdvertByCampaignId($data,$campaignId){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
		
		$this->db->where_in('campaignid', $campaignId);
		$this->db->update($this->tableBanners, $data);
		
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
	/*
	* This function is used to update bannner/advert status by campaignId
	*/
	function getBannerRecords($section=0,$type,$isProject=''){
        $section=((int)$section > 0)? $section : 0;
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
		$this->db->select('bannerid,campaignid,storagetype,url,advert_order,filename,width,height,htmltemplate,contenttype');
		$this->db->from($this->tableBanners);
		$this->db->where("FIND_IN_SET('$section',banner_sections) !=", 0);
		$this->db->where('advert_order',''.$type.'');
		$this->db->order_by('bannerid', 'RANDOM');
		$this->db->limit(1);
		$query = $this->db->get();
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		$rowRes = $query->row();
		$returnRow = '';
		if(isset($rowRes) && !empty($rowRes)) {
			if(isset($isProject) && !empty($isProject)) {
				$returnRow = $rowRes->bannerid; 
			} else {
				$returnRow = $rowRes;
			} 
		} 
		return $returnRow;
	}
	
	
	/*
	 *  This function is used to get campaign log 
	 */ 
	public function getCampaignLog($campaign_id,$banner_id){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
		$this->db->select('*');
		$this->db->from($this->tableOxCampaignLog);
		$this->db->where($this->tableOxCampaignLog.'.campaign_id',$campaign_id);
		$this->db->where($this->tableOxCampaignLog.'.banner_id',$banner_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return $query->row();
	}
	
	/*
	 * This function is used to update / insert advert campaign impression,click log
	 */
	function manageCampaignCountLog($data,$campaign_log_id){
		$this->db->set_dbprefix('tds_'); //Set custom prefix		
		if(isset($campaign_log_id) && !empty($campaign_log_id)) {
			//update campaign log 
			$this->db->where_in('campaign_log_id', $campaign_log_id);
			$this->db->update($this->tableOxCampaignLog, $data);
		} else {
			//insert campaign log
			$this->db->insert($this->tableOxCampaignLog,$data); 
		}
		$this->db->set_dbprefix('TDS_'); //Set prefix for other tables
		return true;
	}
	
}
