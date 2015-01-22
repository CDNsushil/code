<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for frotned membership module 
 * @author		:Rajendra Patidar
 * @package		:Mebership
 *
 */
class Frontend_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		
		
		$this->user = $this->db->dbprefix('users');
		$this->memberships = $this->db->dbprefix('memberships');
		$this->membership_features = $this->db->dbprefix('membership_features');
		$this->membership_access = $this->db->dbprefix('membership_access');
		$this->membership_registration = $this->db->dbprefix('membership_registration');
		$this->membership_payment = $this->db->dbprefix('membership_payment');
	}

	/**
	 * @Desc   :get all enabled membership details
	 * @param  :void
	 * @return :array
	 */
	public function getMemberships()
	{
		$where=array('membership_status'=>'0');
		$this->db->order_by("id", "DESC");
		$this->db->where($where);
		$query=$this->db->get($this->memberships); 
		//$this->db->last_query();  
		return $query->result();
	}
	/**
	 * @Desc   :get  membership details
	 * @param  :array for field
	 * @return :object
	 */
	public function getMembershipsDetails($where)
	{
		$this->db->where($where);
		$query=$this->db->get($this->memberships); 
		return $query->row();
	}
	
	/**
	 * Desc   :get array of enabled features
	 * @param :void
	 * @return:array
	 */
	public function getFeatures()
	{
		$this->db->order_by("id", "DESC");
		$where=array('feature_status'=>'0');
		$this->db->where($where);
		$query = $this->db->get($this->membership_features);
        return $query->result();
	}
	/**
	 * Descrip:get membership feature details
	 * @param :id
	 * @return:object of feature
	 */
	public function getFeatureData($params = array())
	{
		$this->db->where($params); 
		$query = $this->db->get($this->membership_features);
        return $query->row();
	}
	
	/**
	 * @Desc  :an array of all selected features
	 * @param :void
	 * @return:array
	 */
	public function getAllSelectFeatures($param=array())
	{
		$query = $this->db->get_where($this->membership_access,$param);
        return $query->result();
	}
	/**
	 * @Desc  :an array of selected features
	 * @param :membershipId
	 * @return:array
	 */
	public function getFeaturesByMembershipId($membershipId)
	{
		$this->db->select('mf.*,ms.membership_price');
		$this->db->from($this->membership_access.' as ma');
	    $this->db->join($this->membership_features.' as mf','ma.feature_id =mf.id','left');
	     $this->db->join($this->memberships.' as ms','ms.id =ma.membership_id','left');
		$this->db->where('ma.membership_id',$membershipId);
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * @Desc  : insert membership registration for merchant and referral
	 * @param : array $input The data to insert
	 * @return: insertId
	 */
	public function insert($input = array(), $skip_validation = false)
	{
		    $data=array(
			'first_name'		=> $input['first_name'],
			'last_name'			=> $input['last_name'],
			'email'				=> $input['email'],
			'phone'				=> $input['phone'],
			'company_name'		=> $input['company_name'],
			'domain_name'		=> $input['domain_name'],
			'registration_type'	=> $input['user_type'],
			'created_at'		=> date('Y-m-d H:i:s')
			
		); 
		
		$this->db->insert($this->membership_registration,$data);
		return $this->db->insert_id();
	}
	
	/**
	 * @Desc  : get membership registration details
	 * @param : id
	 * @return: data
	 */
	function getMembershipRegistration($where)
	{
		$query = $this->db->get_where($this->membership_registration,$where);
        return $query->row();
	}
		/**
	 * @Desc  :add payment details for membership
	 * @param :paypal details array
	 * @return:msg
	 */
	function getPaypalResponse($input)
	{
		$userId=is_logged_in();	
		$data=array(
			'user_id'			=> $input['uid'],
			'membership_id'		=> $input['mid'],
			'amt'				=> $input['PAYMENTINFO_0_AMT'],
			'transaction_id'	=> $input['PAYMENTINFO_0_TRANSACTIONID'],
			'created_at'		=> date('Y-m-d H:i:s'),
		); 
		
		//update membership id in case of upgrade membership
		$this->db->where('id', $input['uid']);
        $this->db->update($this->user,array('membership_type'=>$input['mid']));
		
		
		$this->db->insert($this->membership_payment,$data);
		if($this->db->insert_id()){
			$this->session->set_flashdata('success', lang('membership:payment_success'));
		}else{
			$this->session->set_flashdata('error','');
		}
		redirect(base_url().'membership');
	}

}
