<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users\Models
 */
class User_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->profile_table = $this->db->dbprefix('profiles');
		$this->membership_features = $this->db->dbprefix('membership_features');
		$this->membership_access = $this->db->dbprefix('membership_access');
		$this->memberships = $this->db->dbprefix('memberships');
		$this->membership_payment = $this->db->dbprefix('membership_payment');
		$this->users_table = $this->db->dbprefix('users');
		$this->users_groups = $this->db->dbprefix('groups');
		$this->affiliate_testimonial = $this->db->dbprefix('affiliate_testimonial');
		$this->product_testimonial_log = $this->db->dbprefix('product_testimonial_log');
		
		
		$this->affiliate_banner_log = $this->db->dbprefix('affiliate_banner_log');
		$this->gmail_contact_log = $this->db->dbprefix('gmail_contact_log');
		
	}

	// --------------------------------------------------------------------------
	/**
	 * Get a specified (single) user
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get($params)
	{
		if (isset($params['id']))
		{
			$this->db->where('users.id', $params['id']);
		}

		if (isset($params['email']))
		{
			$this->db->where('LOWER('.$this->db->dbprefix('users.email').')', strtolower($params['email']));
		}

		if (isset($params['role']))
		{
			$this->db->where('users.group_id', $params['role']);
		}

		$this->db
			->select($this->profile_table.'.*, users.*')
			->limit(1)
			->join('profiles', 'profiles.user_id = users.id', 'left');
		
		return $this->db->get('users')->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get recent users
	 *
	 * @param     int  $limit defaults to 10
	 *
	 * @return     object
	 */
	public function get_recent($limit = 10)
	{
		$this->db->order_by('users.created_on', 'desc');
		$this->db->limit($limit);
		return $this->get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get all user objects
	 *
	 * @return object
	 */
	public function get_all()
	{
		$this->db
			->select($this->profile_table.'.*, g.description as group_name, users.*')
			->join('groups g', 'g.id = users.group_id')
			->join('profiles', 'profiles.user_id = users.id', 'left')
			->group_by('users.id');

		return parent::get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a new user
	 *
	 * @param array $input
	 *
	 * @return int|true
	 */
	public function add($input = array())
	{
		$this->load->helper('date');
	
		return parent::insert(array(
			'email' => $input->email,
			'password' => $input->password,
			'salt' => $input->salt,
			'role' => empty($input->role) ? 'user' : $input->role,
			'active' => 0,
			'lang' => $this->config->item('default_language'),
			'activation_code' => $input->activation_code,
			'created_on' => now(),
			'last_login' => now(),
			'ip' => $this->input->ip_address()
		));
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the last login time
	 *
	 * @param int $id
	 */
	public function update_last_login($id)
	{
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}

	// --------------------------------------------------------------------------

	/**
	 * Activate a newly created user
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function activate($id)
	{
		return parent::update($id, array('active' => 1, 'activation_code' => ''));
	}

	// --------------------------------------------------------------------------

	/**
	 * Count by
	 *
	 * @param array $params
	 *
	 * @return int
	 */
	public function count_by($params = array())
	{
		$this->db->from($this->_table)
			->join('profiles', 'users.id = profiles.user_id', 'left');

		if ( ! empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('users.active', $params['active']);
		}

		if ( ! empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}

		if ( ! empty($params['name']))
		{
			$this->db
				->like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']))
				->or_like('profiles.first_name', trim($params['name']))
				->or_like('profiles.last_name', trim($params['name']));
		}

		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get by many
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get_many_by($params = array(),$limit=0,$offset=0)
	{
		if ( ! empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('active', $params['active']);
		}

		if ( ! empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}
		if($limit > 0){
			
			$this->db->limit($limit,$offset);
		}

		if ( ! empty($params['name']))
		{
			$this->db
				->or_like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']));
		}
		$this->db->order_by("users.id", "DESC");
		
		return $this->get_all();
		
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
	 * @Desc   :get all membership details
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
	 * @Desc   :get current user payment details
	 * @param  :void
	 * @return :data object
	 */
	function getUserPaymentDetails()
	{
		
		$where=array('user_id'=>$this->current_user->id);
		$this->db->order_by("id", "DESC");
		$this->db->where($where);
		$query=$this->db->get($this->membership_payment); 
		//echo $this->db->last_query();  die;
		return $query->row();
	}
		
	/**
	 * @Desc   :get current user membership details
	 * @param  :void
	 * @return :array
	 */
	function getCurrentUserMemberships()
	{
		$this->db->select('ut.membership_type,ms.*');
		$this->db->from($this->users_table.' as ut');
	    $this->db->join($this->memberships.' as ms','ms.id =ut.membership_type','left');
		$this->db->where('ut.id',$this->current_user->id);
		$query = $this->db->get();
		return $query->row();
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
	function userMembershipDetails($memId,$userId)
	{
		$this->db->select('ut.membership_expiry_date,ms.membership_days');
		$this->db->from($this->users_table.' as ut');
	    $this->db->join($this->memberships.' as ms','ms.id ='.$memId,'left');
		$this->db->where('ut.id',$userId);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * @Desc  :add payment details for membership
	 * @param :paypal details array
	 * @return:msg
	 */
	function getPaypalResponse($input)
	{
		$user=is_logged_in();
		$data=array(
			'user_id'			=> $input['uid'],
			'membership_id'		=> $input['mid'],
			'amt'				=> $input['PAYMENTINFO_0_AMT'],
			'transaction_id'	=> $input['PAYMENTINFO_0_TRANSACTIONID'],
			'created_at'		=> date('Y-m-d H:i:s'),
		); 
		
		//update membership id in case of upgrade membership
		$userDetails=$this->userMembershipDetails($input['mid'],$input['uid']);
		if(!empty($userDetails)){
			
			$currentDate=date('Y-m-d');
			$expiryDate=date('Y-m-d',strtotime($userDetails->membership_expiry_date));
			$addiDays=$this->common_model->datedaydifference($currentDate,$expiryDate);
			$totalAddiDays=count($addiDays)+$userDetails->membership_days;
			
			$expiryDate=date('Y-m-d',strtotime('+'.$totalAddiDays.' days')); 
			
			$this->db->where('id', $input['uid']);
			$this->db->update($this->users_table,array('membership_type'=>$input['mid'],'membership_date'=>date('Y-m-d H:i:s'),
								'membership_expiry_date'=>$expiryDate,
								));
			
	
			$this->db->insert($this->membership_payment,$data);
			if($this->db->insert_id()){
				$this->session->set_flashdata('success', lang('user:payment_success'));
			}else{
				$this->session->set_flashdata('error','Request Failed Please Try Again.');
			}
			if($user){
				redirect(base_url().'users/membership');
			}
			redirect('users/email/verification');
		}else{
			$this->session->set_flashdata('error','Request Failed Please Try Again.');
			redirect('');
		}
	}
	
	/* @Desc   :update membership details for not paid
	 * @param  :membershipId
	 * @return :msg
	 */
	function updateMembership($mId)
	{
		$user=is_logged_in();
		$this->db->where('id', $user);
        $this->db->update($this->users_table,array('membership_type'=>$mId,'membership_date'=>date('Y-m-d H:i:s')));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	 }
	function getAllTestimonial($limit='',$offset='')
	{
		$this->db->select('ptl.*,ut.first_name,ut.last_name');
		$this->db->from($this->product_testimonial_log.' as ptl');
	    $this->db->join($this->users_table.' as ut','ut.id =ptl.affiliate_id','left');
	    $this->db->order_by("testimonial_id", "DESC");
	    if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * @Desc  :get testimonial details
	 * @param :id
	 * @return:testimonial details
	 */
	function getTestimonial($id)
	{
		
		$this->db->select('ptl.*,ut.first_name');
		$this->db->from($this->product_testimonial_log.' as ptl');
		$this->db->join($this->users_table.' as ut','ut.id =ptl.affiliate_id','left');
		$this->db->where('ptl.testimonial_id',$id);
		
		$query = $this->db->get();
		$testimonial=$query->row();
		return $testimonial;
	}
	/**
	 * @Desc  :send registration email
	 * @param :from,to,subject,emailData(msg and pass)
	 * @return:msg
	 */
	function sendMail($from,$to,$subject='',$emailData='',$fromName='Syrecohk')
	{
		
		$this->load->library('email');
		$this->email->from($from, $fromName);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($this->load->view($emailData['email_template'],$emailData,true));
		
		if (!$this->email->send()) {
			//show_error($this->email->print_debugger()); 
		}
		  else {
			echo 'Your e-mail has been sent!';
		  }
	
		return true;
	}
	/**
	 * @Desc  :insert affiliate banner details
	 * @param :banner details array
	 * @return:insert id
	 */
	function saveAffiliateBannerLog($data=array()){
		if(!empty($data))
		{
			$res = $this->db->insert($this->affiliate_banner_log,$data);
			return $res;
		}
		else{return false;}
	}
	
	/**
	 * @Desc  :export user CSV list
	 * @param :void
	 * @return:void
	 */
	function exportUserCSV()
	{
		//get all user 
		$users = $this->user_m->get_many_by();

		$dataArray=array();
		if(!empty($users)){
			foreach($users as $user)
			{
				$active=($user->active==1)?lang('global:yes'):lang('global:no');
				$sex=($user->sex==0)?'Male':'Female';
				$userBlock=($user->user_block==0)?'No':'Yes';
				$membershipType=($user->membership_type==1)?'Free':'Paid';
								
				$userArray=array('User Name'=>$user->first_name.' '.$user->last_name,
					'Group'						=>$user->group_name,
					'Email Address'				=>$user->email,
					'Active'					=>$active,
					'Block(User Block By admin)'=>$userBlock,
					
					'Sex'						=>$sex,
					'Date Of Birth'				=>date('d M Y',strtotime($user->date_of_birth)),
					'Phone'						=> $user->phone,
					'Address'					=> $user->address,
					'Web-Site Address '			=> $user->domain_name,
					'Registration Date '		 =>date('d M Y',$user->created_on)
					);
					if($user->group_id==3){
						$userArray['Membership Date'] 	   =date('d M Y',strtotime($user->membership_date));
						$userArray['Membership Expiry Date'] =date('d M Y',strtotime($user->membership_expiry_date));
						$userArray['Membership Type']		   =$membershipType;
					}
					array_push($dataArray,$userArray);
			}
		}
		force_download('banner.csv', $this->format->factory($dataArray)
			->{'to_csv'}());
	}
	
	/**
	 * @Desc  :Export gmail contact CSV
	 * @param :void
	 * @return:exppot CSV files
	 */
	function exportGmailContactCSV()
	{
		//get all user 
		$contacts = $this->getGmailContact();
		
		$dataArray=array();
		if(!empty($contacts)){
			foreach($contacts as $contact)
			{
				$contactArray=array('Email'=>$contact->first_name.' '.$contact->last_name,
					'Reference (Affiliate)'	=>$contact->contact_email,
					'Contact Date ' =>date('d M Y',strtotime($contact->created_at))
					);
					
					array_push($dataArray,$contactArray);
			}
		}
		force_download('gmail.csv', $this->format->factory($dataArray)
			->{'to_csv'}());
	}
	/**
	 * @Desc  :get affiliate gmail contact
	 * @param :void
	 * @return:array
	 */
	function getGmailContact($limit=0,$offset=0)
	{
		$this->db->select('gcl.*,ut.first_name,ut.last_name');
		$this->db->from($this->gmail_contact_log.' as gcl');
		$this->db->join($this->users_table.' as ut','ut.id =gcl.affiliate_id','left');
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->order_by("contact_id", "DESC");
		$query = $this->db->get();
		$results=$query->result();
		return $results;
	}
	
	function searchAffiliateContact($searchName)
	{
		
		$firstName='';
		$lastName='';
		if($searchName!=''){
			$searchData=explode(' ',$searchName);
			$firstName=$searchData[0];
			if(array_key_exists('1',$searchData)){
				$lastName=$searchData[1];
			}if($lastName==''){
				$lastName=$firstName;
			}
		}
		//echo $lastName; die;	
		$this->db->select('gcl.*,ut.first_name,ut.last_name');
		$this->db->from($this->gmail_contact_log.' as gcl');
		$this->db->join($this->users_table.' as ut','ut.id =gcl.affiliate_id','left');
		
		$this->db->like('ut.first_name',$firstName, 'after');
		if($lastName!=''){
			$this->db->or_like('ut.last_name', $lastName,'after');
		}
		
		$this->db->order_by("contact_id", "DESC");
		$query = $this->db->get();
		$contactEmail=$query->result();
		
		$data='';
		if(!empty($contactEmail)){
			foreach($contactEmail as $email){
				$data.='<tr>';
				$data.='<td>'.$email->contact_email.'</td>';
				$data.='<td>'.ucwords($email->first_name.' '.$email->last_name).'</td>';
				$data.='<td>'.date('d M Y',strtotime($email->created_at)).'</td>';
				$data.='</tr>';
				
			}
		}
		
		if($data==''){
			$data='<tr><td colspan="3">'.lang('global:no_record_found').'</td></tr>';
		}
		
		return $data;
	}

}
