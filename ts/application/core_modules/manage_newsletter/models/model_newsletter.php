<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter messaging files editor.
 *
 */
class Model_newsletter extends CI_Model {
	private $userAuth = 'UserAuth'; 
	private $emailNewsletterLog = 'EmailNewsletterLog'; 
	private $emailNewsletter = 'EmailNewsletter';
	
	function __construct()
	{
		parent::__construct();  
		
	}
	
	/*
	 * function to get all active users listing
	 */
	public function get_users($limit=0,$offset=0)
	{
		$this->db->select('UserShowcase.tdsUid as AuthUid,username,email,active,banned,firstName,lastName,creative,associatedProfessional,enterprise');
		$this->db->from($this->userAuth);
		$this->db->join('UserShowcase','UserShowcase.tdsUid = UserAuth.tdsUid','left');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('active !=',2);
		$this->db->where('banned !=',1);
		$this->db->order_by('authuid','Asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*
	 * Function to get users email detail
	 */
	public function get_user_email($userId)
	{	
		$this->db->select('email');
		$this->db->from($this->userAuth);
		$this->db->where('tdsUid',$userId);
		$query = $this->db->get();
		$result =$query->result();
		if(count($result) > 0 )
		{
			return $result[0]->email;
		} 
		else
		{
			return 0;
		}
	}
	
	/*
	 *  Function to add admins email log
	 */
	public function insert_email_log($msgData)
	{ 	
		$this->db->insert('EmailNewsletterLog', $msgData);
		return $this->db->insert_id();	     
	}
	
	/*
	 * function to get Admins message log
	 */
	public function get_message_log($limit=0,$offset=0)
	{
		$this->db->select('*');
		$this->db->from($this->emailNewsletterLog);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		//$this->db->where('type',0);
		$this->db->order_by('sentDate','Asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*
	 * function to get Admins newsletter list
	 */
	public function get_newsletter_list($limit=0,$offset=0)
	{
		$this->db->select('*');
		$this->db->from($this->emailNewsletter);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		//$this->db->where('type',0);
		//$this->db->order_by('createdAt','Asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	/*
	 * Function to get message details
	 */
	public function get_msg_details($msgId=0)
	{	
		$this->db->select('*');
		$this->db->from($this->emailNewsletterLog);
		$this->db->where('id',$msgId);
		$this->db->limit(1);
		$query = $this->db->get();
		$result =  $query->row();
		return $result;
	}
	
	/*
	 * Function to get sent newsletter log details
	 */
	public function get_sent_newletter_log($newsletterId=0)
	{	
		$this->db->select('participantIds');
		$this->db->distinct('participantIds');
		$this->db->from($this->emailNewsletterLog);
		$this->db->where('newsletterId',$newsletterId);
		$query = $this->db->get();
		$result =  $query->result_array();
		return $result;
	}
	
	/*
	 * Function to get nesletter details
	 */
	public function get_newsletter_detail($newsletterId=0)
	{	
		$this->db->select('*');
		$this->db->from($this->emailNewsletter);
		$this->db->where('id',$newsletterId);
		$this->db->limit(1);
		$query = $this->db->get();
		$result =  $query->row();
		return $result;
	}
	
	
	/**
	* Remove message from log
	*/
	public function remove_message($msgId)
    {
		// If the admin is tryring to delete a topic then delete it.
		$data = array(
			'id' => $msgId,
		);
            
		$this->db->delete('EmailNewsletterLog', $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/**
	* Remove newsletter from log
	*/
	public function remove_newsletter($newsletterId)
    {
		// If the admin is tryring to delete a topic then delete it.
		$data = array(
			'id' => $newsletterId,
		);
            
		$this->db->delete($this->emailNewsletter, $data);
            
		if($this->db->affected_rows() > 0)
		{
			return true;
		}else{
			return false;
		}       
	}
	
	/*
	 * Get Users listing for griding
	 */
	public function get_users_listing($status='')
	{
		$this->db->select('UserAuth.tdsUid as AuthUid,UserAuth.username,UserAuth.email,UserAuth.active,UserAuth.new_password_key,UserAuth.created,UserAuth.last_visit,UserAuth.banned,UserProfile.firstName,UserProfile.lastName, MasterCountry.countryName');
		$this->db->from($this->userAuth);
		$this->db->join('UserProfile','UserProfile.tdsUid = UserAuth.tdsUid','left');
		$this->db->join('MasterCountry','MasterCountry.countryId = UserProfile.countryId','left');
		$this->db->where('UserAuth.banned','0');
		if($status==1){
			$this->db->where('UserAuth.active','1');
		}
		else if($status==0){
			$this->db->where('UserAuth.active','0');
		}else{
			$this->db->where('UserAuth.active !=','2');
		}
		
		$this->db->order_by('UserAuth.tdsUid','Desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*
	 *  Function to add newsletters
	 */
	public function insert_newsletter($newsletterData)
	{ 	
		$this->db->insert($this->emailNewsletter, $newsletterData);
		return $this->db->insert_id();	     
	}
	
	/*
	 *  Function to update newsletters
	 */
	public function update_newsletter($newsletterData,$newsletterId)
	{	
		$this->db->where('id',$newsletterId);
		$this->db->update($this->emailNewsletter, $newsletterData);
		return true;	     
	}
	
}
/* End of file model_messaging.php */
