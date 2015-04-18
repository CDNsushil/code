<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter User manage files editor.
 *
 */
class Model_manage_users extends CI_Model {
	private $userAuth 					= 'UserAuth'; 
	private $tableSalesOrder			= 'SalesOrder';
	
	function __construct()
	{
		parent::__construct();  
		
	}
	
	public function get_users($status='')
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
	
	/**
	* Update Users Status.
	*/
	public function update_status($userData,$tdsUid)
	{ 
		$this->db->where('tdsUid', $tdsUid);
		$this->db->update('UserAuth', $userData);
	}
	
	/**
	* Remove Inactive users from user list.
	*/
	public function remove_user_records($table='',$userId)
    {
		//set users id to delete records
		$data = array(
			'tdsUid' => $userId,
		);   
		$this->db->delete($table, $data);       
	}
}
/* End of file model_tips.php */
