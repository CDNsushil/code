<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package	Tank_auth
 * @author	Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Users extends CI_Model
{
	private $table_name				= 'UserAuth';			// user accounts
	private $profile_table_name		= 'UserProfile';	// user profiles
	private $tableUserShowcase		= 'UserShowcase';	// user profiles
	private $tableStockImages		= 'StockImages';	// user profiles
	private $tableMasterCountry		= 'MasterCountry';
	private $UserSearchPreferences	= 'UserSearchPreferences';	// user profiles
	private $UserBuyerSettings		= 'UserBuyerSettings';	// user profiles
	private $UserSellerSettings		= 'UserSellerSettings';	// user profiles
	private $UserSubscription		= 'UserSubscription';	// user profiles

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->table_name			= $ci->config->item('db_table_prefix', 'tank_auth').$this->table_name;
		$this->profile_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;
	}

	/**
	 * Get user record by Id
	 *
	 * @param	int
	 * @param	bool
	 * @return	object
	 */
	function get_user_by_id($user_id=0, $active=0)
	{
		$this->db->where($this->table_name.'.tdsUid', $user_id);
		$this->db->where($this->table_name.'.active', $active ? 1 : 0);
		$this->db->join($this->profile_table_name, $this->profile_table_name.'.tdsUid = '.$this->table_name.'.tdsUid','left');
		$query = $this->db->get($this->table_name);
		if ($query->num_rows()) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by login (username or email)
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_login($login)
	{
		
		$this->db->where('LOWER(username)=', strtolower($login));
		$this->db->or_where('LOWER(email)=', strtolower($login));
		$this->db->where('active !=','2');
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows()) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by username
	 *
	 * @param	string
	 * @return	object
	 */
	function get_user_by_username($username)
	{
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		if ($query->num_rows()) return $query->row();
		return NULL;
	}

	/**
	 * Get user record by email
	 *
	 * @param	string
	 * @return	object
	 */
	
	function get_user_by_email($email='',$active=1)
	{
		$this->db->select($this->table_name.'.*,'.$this->profile_table_name.'.firstName,'.$this->profile_table_name.'.lastName,'.$this->profile_table_name.'.countryId,'.$this->profile_table_name.'.image,'.$this->tableUserShowcase.'.showcaseId,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.optionAreaName,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId,'.$this->tableUserShowcase.'.fans,'.$this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
		$this->db->select($this->UserSubscription.'.endDate as subscription_end_date,'.$this->UserSubscription.'.subscriptionType');
		$this->db->select($this->tableMasterCountry.'.countryName');
		$this->db->select($this->UserSellerSettings.'.seller_currency');
		$this->db->select($this->tableUserShowcase.'.websiteUrl,'.$this->tableUserShowcase.'.showcaseId');
		$this->db->from($this->table_name);
		$this->db->join($this->profile_table_name, $this->profile_table_name.'.tdsUid = '.$this->table_name.'.tdsUid','left');
		$this->db->join($this->UserSellerSettings, $this->UserSellerSettings.'.tdsUid = '.$this->table_name.'.tdsUid','left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->table_name.".tdsUid", 'left');
		$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
		$this->db->join($this->tableMasterCountry, $this->tableMasterCountry.".countryId = ".$this->profile_table_name.".countryId", 'left');
		$this->db->join($this->UserSubscription, $this->UserSubscription.".tdsUid = ".$this->table_name.".tdsUid", 'left');
		$this->db->where('LOWER(email)=', strtolower($email));
		if(is_numeric($active) && ($active==1) ){
			$this->db->where('active',$active);
		}else{
			$this->db->where_not_in('active',2);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()) return $query->row();
		return NULL;
	}
	
	function getUserImage($email='')
	{
		$result= false;
		if(!empty($email)){
			$this->db->select($this->table_name.'.tdsUid,'.$this->table_name.'.username,'.$this->table_name.'.active,'.$this->table_name.'.fbUid,'.$this->table_name.'.postedOnFB');
			$this->db->select($this->tableUserShowcase.'.showcaseId,'.$this->tableUserShowcase.'.profileImageName,'.$this->tableUserShowcase.'.stockImageId');
			$this->db->select($this->tableStockImages.'.stockImgPath,'.$this->tableStockImages.'.stockFilename');
			$this->db->from($this->table_name);
			$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->table_name.".tdsUid", 'left');
			$this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
			$this->db->where('LOWER(email)=', strtolower($email));
			$this->db->where_not_in('active',2);
			$this->db->limit(1);
			$query = $this->db->get();
			$result= $query->result();
		}
		return $result;
	}

	/**
	 * Check if username available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		$this->db->select('1', FALSE);
		$this->db->where('LOWER(username)=', strtolower($username));

		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Check if email available for registering
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		$this->db->select('1', FALSE);
		$this->db->where('active !=','2');
		$this->db->where('LOWER(email)=', strtolower($email));
		$this->db->or_where('LOWER(new_email)=', strtolower($email));
		
		$query = $this->db->get($this->table_name);
		return $query->num_rows() == 0;
	}

	/**
	 * Create new user record
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function create_user($data, $active = TRUE)
	{
		$data['created'] = date('Y-m-d H:i:s');
		$data['active'] = $active ? 1 : 0;

		if ($this->db->insert($this->table_name, $data)) {
			$user_id = $this->db->insert_id();
			//if ($active)	$this->create_profile($user_id);
			return array('user_id' => $user_id);
		}
		return NULL;
	}

	/**
	 * Activate user if activation key is valid.
	 * Can be called for not active users only.
	 *
	 * @param	int
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email)
	{
		$this->db->select('tdsUid');
		$this->db->where('tdsUid', $user_id);
		if ($activate_by_email) {
			$this->db->where('new_email_key', $activation_key);
		} else {
			$this->db->where('new_password_key', $activation_key);
		}
		$this->db->where('active', 0);
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query(); die;
		if ($query->num_rows()) {

			$this->db->set('active', 1);
			$this->db->set('new_email_key', NULL);
			$this->db->where('tdsUid', $user_id);
			$this->db->update($this->table_name);
			//$this->create_profile($user_id);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Purge table of non-active users
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_na($expire_period = 604800)
	{
		$this->db->where('active', 0);
		$this->db->where("created < ", date("Y-m-d",time() - $expire_period));
		$this->db->delete($this->table_name);
	}

	/**
	 * Delete user record
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id)
	{
		$res=$this->delete_profile($user_id);
		
		if($res) {
			$this->db->where('tdsUid', $user_id);
			$this->db->delete($this->table_name);
			return TRUE;
		}
		
		return FALSE;
	}

	/**
	 * Set new password key for user.
	 * This key can be used for authentication when resetting user's password.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set_password_key($user_id, $new_pass_key)
	{
		$this->db->set('new_password_key', $new_pass_key);
		$this->db->set('new_password_requested', date('Y-m-d H:i:s'));
		$this->db->where('tdsUid', $user_id);

		$this->db->update($this->table_name);
		//echo $this->db->last_query(); die;
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	int
	 * @return	void
	 */
	function can_reset_password($user_id, $new_pass_key, $expire_period = 604800)
	{
		$time=(time() - $expire_period);
		$expDate= date('Y-m-d h:i:s',$time); 
		$this->db->select('1', FALSE);
		$this->db->where('tdsUid', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('new_password_requested >', $expDate);

		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		//die;
		//echo "Here".$query->num_rows();
		
		return $query->num_rows();
	}

	/**
	 * Change user password if password key is valid and user is authenticated.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 604800)
	{ 
	
		$time=(time() - $expire_period);
		$expDate= date('Y-m-d h:i:s',$time); 
		$this->db->set('password', $new_pass);
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);
		$this->db->where('tdsUid', $user_id);
		$this->db->where('new_password_key', $new_pass_key);
		$this->db->where('new_password_requested >=', $expDate);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Change user password
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function change_password($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('tdsUid', $user_id);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Set new email for user (may be active or not).
	 * The new email cannot be used for login or notification before it is active.
	 *
	 * @param	int
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function set_new_email($user_id, $new_email, $new_email_key, $active)
	{
		$this->db->set($active ? 'new_email' : 'email', $new_email);
		$this->db->set('new_email_key', $new_email_key);
		$this->db->where('tdsUid', $user_id);
		$this->db->where('active', $active ? 1 : 0);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Activate new email (replace old email with new one) if activation key is valid.
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		$this->db->set('email', 'new_email', FALSE);
		$this->db->set('new_email', NULL);
		$this->db->set('new_email_key', NULL);
		$this->db->where('tdsUid', $user_id);
		$this->db->where('new_email_key', $new_email_key);

		$this->db->update($this->table_name);
		return $this->db->affected_rows() > 0;
	}

	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not active) passwords.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{
		$this->db->set('new_password_key', NULL);
		$this->db->set('new_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_visit', date('Y-m-d H:i:s'));

		$this->db->where('tdsUid', $user_id);
		$this->db->update($this->table_name);
	}

	/**
	 * Ban user
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function ban_user($user_id, $reason = NULL)
	{
		$this->db->where('tdsUid', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 1,
			'ban_reason'	=> $reason,
		));
	}

	/**
	 * Unban user
	 *
	 * @param	int
	 * @return	void
	 */
	function unban_user($user_id)
	{
		$this->db->where('tdsUid', $user_id);
		$this->db->update($this->table_name, array(
			'banned'		=> 0,
			'ban_reason'	=> NULL,
		));
	}

	/**
	 * Create an empty profile for a new user
	 *
	 * @param	int
	 * @return	bool
	 */
	function create_profile($data){
		return $this->db->insert($this->profile_table_name, $data);
		
	}

	/**
	 * Delete user profile
	 *
	 * @param	int
	 * @return	void
	 */
	private function delete_profile($user_id){
		$this->db->where('tdsUid', $user_id);
		$this->db->delete($this->profile_table_name);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
		return false;
	}
	
	/**
	 * Group Name fucntion 
	 *
	 * group_name call by  Trunk Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 * Author : Lalit
	 */
	function group_name($user_group){
		$result = array();
		$this->db->select('name');
		$this->db->from('forum_groups');
		$this->db->where('id',$user_group);
		$query = $this->db->get();
		$result =$query->result();
		if($result)
			return $result[0]->name;
		else
			return false;
	}
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
