<?php
/**
 * Users Model
 * Manage User record etc
 * @category	Users
 * @author	CDN Solution
 */
class Users_model extends CI_Model
{
	private $read_db;	// private variable to store db read reference

	//Constructor
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);			
	}

	/**
	* function to get User list
	*/
	function get_users_list($start='', $limit='')
	{
		$type_post	=  $this->input->post('filter');
		$type_uri 	=  $this->uri->segment(3);
		$user_search 	=  $this->input->post('user_search');

		/*---------------- FILTER -----------------
			Condition for active and deactive user		
		-------------------------------------------*/
		 if($type_post == 'active' || $type_uri == 'active') {
			$this->read_db->where('user.published','1');
		 } else if($type_post == 'deactivated' || $type_post == 'deactivated') {
			$this->read_db->where('user.published','0');
			$this->read_db->or_where('user.published','2');
			$this->read_db->or_where('user.published','3');
		 }
				
			/*---------------- FILTER -----------------
			    Condition to get user's registered today		
			-------------------------------------------*/
			if($this->uri->segment(3) == 'today') {
				$curdate = date('Y-m-d');
				$this->read_db->like('created_at',$curdate);
			 }
			 /*---------------- FILTER -----------------
			    Condition to get user's registered in a week		
			-------------------------------------------*/
			if($this->uri->segment(3) == 'week') {
				$last_week_datetime = date("Y-m-d H:i:s", strtotime("-8 days"));
				$this->read_db->where('created_at >=',$last_week_datetime);
			 }
			 /*---------------- FILTER -----------------
			    Condition to get user's registered in a month		
			-------------------------------------------*/
			 if($this->uri->segment(3) == 'month') {
				$last_month_datetime = date("Y-m-d H:i:s", strtotime("-1 month"));
				$this->read_db->where('created_at >=',$last_month_datetime);
			 }
			 /*---------------- FILTER -----------------
			    Condition to get user's registered year		
			-------------------------------------------*/
			 if($this->uri->segment(3) == 'year') {
				$last_year_datetime = date("Y-m-d H:i:s", strtotime("-1 Year"));
				$this->read_db->where('created_at >=',$last_year_datetime);
			 }
			 /*---------------- FILTER -----------------
			    Condition to male user's 		
			-------------------------------------------*/
			 if($this->uri->segment(3) == 'male') {
				$this->read_db->where('sex','1');
			 }
			 /*---------------- FILTER -----------------
			    Condition to female user's 		
			-------------------------------------------*/
			 if($this->uri->segment(3) == 'female') {
				$this->read_db->where('sex','0');
			 }
			 /*---------------- FILTER -----------------
			    Condition to other user's 		
			-------------------------------------------*/
			 if($this->uri->segment(3) == 'other') {
				$this->read_db->where('sex','2');
			 }
			 /*---------------- FILTER -----------------
			    Condition to get under 20yrs user's  		
			-------------------------------------------*/
					/*-----post date array-------*/
		$datetime_before_20_year = date("Y-m-d", strtotime("-20 Year"));
		$datetime_before_29_year = date("Y-m-d", strtotime("-29 Year"));
		$datetime_before_30_year = date("Y-m-d", strtotime("-30 Year"));
		$datetime_before_39_year = date("Y-m-d", strtotime("-39 Year"));
		$datetime_before_40_year = date("Y-m-d", strtotime("-40 Year"));
		$datetime_before_49_year = date("Y-m-d", strtotime("-49 Year"));
		$datetime_before_50_year = date("Y-m-d", strtotime("-50 Year"));
		$datetime_before_59_year = date("Y-m-d", strtotime("-59 Year"));
		$datetime_before_60_year = date("Y-m-d", strtotime("-60 Year"));
		$datetime_before_69_year = date("Y-m-d", strtotime("-69 Year"));
		$datetime_before_70_year = date("Y-m-d", strtotime("-70 Year"));
					/*------------------------*/	
		if($this->uri->segment(3) == 'under20'){
			 $this->read_db->where('dob >=',$datetime_before_20_year);
		}
		if($this->uri->segment(3) == '20to29'){
			 $this->read_db->where('dob <=',$datetime_before_20_year);
			 $this->read_db->where('dob >=',$datetime_before_29_year);
		}
		if($this->uri->segment(3) == '30to39'){
			 $this->read_db->where('dob <=',$datetime_before_30_year);
			 $this->read_db->where('dob >=',$datetime_before_39_year);
		}
		if($this->uri->segment(3) == '40to49'){
			 $this->read_db->where('dob <=',$datetime_before_40_year);
			 $this->read_db->where('dob >=',$datetime_before_49_year);
		}
		if($this->uri->segment(3) == '50to59'){
			 $this->read_db->where('dob <=',$datetime_before_50_year);
			 $this->read_db->where('dob >=',$datetime_before_59_year);
		}
		if($this->uri->segment(3) == '60to69'){
			 $this->read_db->where('dob <=',$datetime_before_60_year);
			 $this->read_db->where('dob >=',$datetime_before_69_year);
		}
		if($this->uri->segment(3) == 'over70'){
			 $this->read_db->where('dob <=',$datetime_before_70_year);
		}
		$type_search = $this->input->post('search');
			if($type_search) {	
			
				$country = $this->input->post('country');
				$gender  = $this->input->post('gender');

				$this->read_db->select('user.user_id,user.firstname,user.email,user.lastname');
				$this->read_db->join('user_profile', 'user_profile.user_id = user.user_id', 'left');
				$this->read_db->join('country','country.country_id = user_profile.country_id','left');
				$this->read_db->order_by("country.country_name", "asc"); 
				$this->read_db->where("user_profile.country_id !=","NULL");			
				$this->read_db->where("user_profile.country_id",$country);			
				if($gender!='2') {	
					$this->read_db->where("user.sex",$gender);
				}
			}				

			/*---------------- FILTER -----------------
				    Condition for COUNTRY		
			-------------------------------------------*/
			 if ($type_post == 'country' || $type_uri == 'country') {
				$this->read_db->select('user.user_id,user.firstname,user.email,user.lastname');
				$this->read_db->join('user_profile', 'user_profile.user_id = user.user_id', 'left');
				$this->read_db->join('country','country.country_id = user_profile.country_id','left');
				$this->read_db->order_by("country.country_name", "asc"); 
				$this->read_db->where("user_profile.country_id !=","NULL");
			 }

			/*---------------- FILTER -----------------
				    Condition for age		
			-------------------------------------------*/
			 if ($type_post == 'age' || $type_uri == 'age') {
				$this->read_db->select('user.user_id,user.firstname,user.email,user.lastname');
				$this->read_db->order_by("user.dob", "desc"); 

			 }
			
			/*---------------- SEARCH -----------------
				Search by Name or UserId 
			-------------------------------------------*/
			if ($user_search) {
				if (is_numeric($user_search)) {
					$this->read_db->where("user.user_id",$user_search);			
				} else {	
					$this->read_db->like('user.firstname',$user_search);
				}
			}

                            $this->read_db->where("user.user_role","1");			
			if($limit !=""){
				$this->read_db->limit($limit,$start);	
			}
			$result = $this->read_db->get('user');
			return $result;
		}
		
		/**
		* Function for display user profile data
		* @Param user_id
		* Return user Array
		* Author Lalit
		*/
		function get_users_profile($user_id, $get_type) {
 
			if($get_type!="") {
				$this->read_db->select('user.firstname,user.lastname,user.email,user.firstname,user.sex,user.dob,user.age,country.country_name,user.user_role');
				$this->read_db->select('user_profile.address,user_profile.address2,user_profile.zipcode');
				$this->read_db->from('user');
				$this->read_db->join('user_profile', 'user_profile.user_id = user.user_id', 'left');
				$this->read_db->join('country','country.country_id = user_profile.country_id','left');
				$this->read_db->where('user.user_id',$user_id);
			} else {
				$this->read_db->select('user.*,country.country_name');
				$this->read_db->from('user');
				$this->read_db->join('user_profile', 'user_profile.user_id = user.user_id', 'left');
				$this->read_db->join('country','country.country_id = user_profile.country_id','left');
				$this->read_db->where('user.user_id',$user_id);
			}
			$result = $this->read_db->get();
			$return_data = $result->result();
			return $return_data;
 		}


	/**
	*Function for get user date of birth 	
	* Author Lalit
	*/	
	function get_dob($dob)
	{
		$birthday = $dob;
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)
		$year_diff--; 
		
		return $year_diff;
	}

	function user_delete($user_id='')
	{
		if($user_id!="" && $user_id>0)
		{
			$this->db->delete('user', array('user_id'=>$user_id));
		}
	}

	/***
	* Author Lalit
	* Function for update user profile data
	* Param Data array 	
	*/
	function user_profile_update()
	{		
		$data = array(
			'firstname'	=>	$this->input->post('name'),
			'lastname'	=>	$this->input->post('lastname'),
			'email'		=>	$this->input->post('email'),
			'dob'		=>	$this->input->post('dob'),
			'sex'		=>	$this->input->post('gender')
		);
				
		$session_user_data =$this->session->userdata('session_data');
		if($session_user_data['user_role']==1){
			$data['user_role']=$this->input->post('user_role');
		}
		$this->db->where('user_id',$this->input->post('user_id'));
		$this->db->update('user',$data);
		
		// Update user country id 	
		if($this->input->post('state') !='' || $this->input->post('city') !='')
		{
		$data = array(
			'country_id'	=>	$this->input->post('country'),
			'state_id'	=>	$this->input->post('state'),
			'city_id'	=>	$this->input->post('city')
		);
		}
		else{
		$data = array(
			'country_id'	=>	$this->input->post('country'),
			'state_id'	=>	NULL,
			'city_id'	=>	NULL
		);}
		$this->db->where('user_id',$this->input->post('user_id'));
		$this->db->update('user_profile',$data);

	}
	
	/***
	* Author Lalit
	* Function for get user data by searching word
	*/
	function get_users_by_word($start='', $limit='')
	{	
			 $user 	  	 =  $this->uri->segment(4);
			$user_type 	 =  $this->uri->segment(3);
			$post_user_type  =  $this->input->post('user_type');


			if(!$user) { $user='a'; } 

			$this->read_db->like('user.firstname',$user,'after');

			if($limit !="") {
				$this->read_db->limit($limit,$start);	
			}

			if($post_user_type=="employee") 
			{
				$this->read_db->where("user.user_role !=","0"); 
			} 
			else {	
				if($user_type=="users" || $user_type=="Mailing" || $user=='a') {
					$this->read_db->where("user.user_role","1"); 
				} else { 		
					$this->read_db->where("user.user_role !=","1"); 
				}
			}
	

			$result = $this->read_db->get('user');
			return $result;	
	}

	/**
	* Function for update user activation status
	*/		
	function update_user_activation()
	{
		$data = array(
			'published'	=>	$this->input->post('deactivate'),
		);
		$this->db->where('user_id',$this->input->post('user_id'));
		$this->db->update('user',$data);
	}

	/**
	* Author Lalit
	*Function for get email address by id
	*/
	function get_email_address($id,$type)
	{
		$this->db->select('email');

		if($type=="IN") { 		

		/*--- Condition for get multipal email ids ---*/
			$ids 		= explode(",",$id);	
			
			$this->read_db->where_in('user_id',$ids);
			$result 	= $this->read_db->get('user');
			$email_ids 	= $result->result();	
		} else {
		echo $id;exit("out");
		/*--- Condition for get single email id ---*/
			$this->read_db->where('user_id',$id);
			$result 	= $this->read_db->get('user');
			$email 		= $result->result();	
			$email_ids 	=  $email[0]->email;
		}
		return $email_ids;
	}
	
	/**
	*Function for send email by email address
	*/
	function send_email_address($email_address,$subject,$message)
	{
	    //------ Send email -------	
		$this->email->from('your@example.com', 'Your Name');
		$this->email->to($email_address);

	//	$this->email->cc('another@another-example.com');
	//	$this->email->bcc('them@their-example.com');

		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();

	//	echo $this->email->print_debugger(); 
	}
	
	/*----------fetch country, city, state of user------------*/
	function get_user_country_state_city($user_id) {
		$this->read_db->select('user_profile.country_id,user_profile.state_id,user_profile.city_id,state.state_name,city.city_name');
		$this->read_db->from('user_profile');
		$this->read_db->join('state','state.state_id = user_profile.state_id');
		$this->read_db->join('city','city.city_id = user_profile.city_id');
		$this->read_db->where('user_profile.user_id',$user_id);
		$query = $this->read_db->get();
		return $res = $query->result();
		}
	
	/*----------Delete User------------*/
	function delete_user($user_id){
		$this->db->delete('action', array('user_id' => $user_id));
		$this->db->delete('active_session', array('user_id' => $user_id));
		$this->db->delete('address_book', array('user_id' => $user_id));
		$this->db->delete('advert', array('user_id' => $user_id));
		$this->db->delete('album', array('user_id' => $user_id));
		$this->db->delete('admin_support_answer', array('user_id' => $user_id));
		$this->db->delete('admin_support_question', array('user_id' => $user_id));
		$this->db->delete('application_settings', array('person_id' => $user_id));
		$this->db->delete('app_notification', array('user_id' => $user_id));
		$this->db->delete('eventcal', array('user_id' => $user_id));
		$this->db->delete('face', array('user_id' => $user_id));
		$this->db->delete('friends', array('from_user_id' => $user_id));
		$this->db->delete('friends', array('to_user_id'=>$user_id));
		$this->db->delete('friend_invites', array('user_id' => $user_id));
		$this->db->delete('group', array('user_id' => $user_id));
		$this->db->delete('group_member', array('user_id' => $user_id));
		$this->db->delete('incentive_request', array('user_id' => $user_id));
		$this->db->delete('invite_report', array('user_id' => $user_id));
		$this->db->delete('media', array('user_id' => $user_id));
		$this->db->delete('messages', array('from' => $user_id,'to'=>$user_id));
		$this->db->delete('notification', array('from_user_id' => $user_id));
		$this->db->delete('notification_setting', array('user_id' => $user_id));
		$this->db->delete('oauth_consumer', array('user_id' => $user_id));
		$this->db->delete('oauth_token', array('user_id' => $user_id));
		$this->db->delete('page', array('user_id' => $user_id));
		$this->db->delete('page_concert', array('user_id' => $user_id));
		$this->db->delete('page_member', array('user_id' => $user_id));
		$this->db->delete('page_member', array('user_id' => $user_id));
		$this->db->delete('page_points', array('user_id' => $user_id));
		$this->db->delete('page_press', array('user_id' => $user_id));
		$this->db->delete('page_project', array('user_id' => $user_id));
		$this->db->delete('parent_level', array('user_id' => $user_id));
		$this->db->delete('pending_incentive_request', array('user_id' => $user_id));
		$this->db->delete('person_applications', array('person_id' => $user_id));
		$this->db->delete('point', array('user_id' => $user_id));
		$this->db->delete('report', array('user_id' => $user_id));
		$this->db->delete('show_alert', array('user_id' => $user_id));
		$this->db->delete('sublist', array('user_id' => $user_id));
		$this->db->delete('sublist_member_list', array('member_user_id' => $user_id));
		$this->db->delete('tags', array('user_id' => $user_id));
		$this->db->delete('ticker', array('user_id' => $user_id));
		$this->db->delete('transaction', array('user_id' => $user_id));
		$this->db->delete('users_comments', array('user_id' => $user_id));
		$this->db->delete('users_like_dislike', array('user_id' => $user_id));
		$this->db->delete('user_account_permission', array('user_id' => $user_id));
		$this->db->delete('user_product_click', array('user_id' => $user_id));
		$this->db->delete('user_profile', array('user_id' => $user_id));
		$this->db->delete('user_security_question', array('user_id' => $user_id));
		$this->db->delete('view_count', array('user_id' => $user_id));
		$this->db->delete('wall', array('user_id' => $user_id)); 
		$this->db->query("delete from  ox_banners where user_id='$user_id'");
		$res = $this->db->delete('user', array('user_id' => $user_id));
		return $res;
		}
	/*----------------------*/

  	/**
     * Function to set delete flag in user table 
     * Created on 05-07-12
	*/

    function delete_user_temp($user_id) 
	{
        $this->db->set('published','4'); 
        $this->db->where('user_id', $user_id);
		$this->db->update('user'); 
    }


	/*fucntions for sending bulk mails*/
	function get_qualified_users_by_word($word,$start='', $limit='')
	{

			if(!$word) { $user='a'; } 

			$this->read_db->like('user.firstname',$word,'after');
			$this->read_db->join('user_profile','user.user_id = user_profile.user_id');
			$this->read_db->where('user_profile.is_register_for_points',1);
			$this->read_db->where('user.published',1);
			if($limit !="") {
				$this->read_db->limit($limit,$start);	
			}

			$result = $this->read_db->get('user');
			return $result;	
	}

	function get_nonqualified_users_by_word($word,$start='', $limit='')
	{

			if(!$word) { $user='a'; } 

			$this->read_db->like('user.firstname',$word,'after');
			$this->read_db->join('user_profile','user.user_id = user_profile.user_id');
			$this->read_db->where('user_profile.is_register_for_points ',0);
			$this->read_db->where('user.published',1);
			if($limit !="") {
				$this->read_db->limit($limit,$start);	
			}

			$result = $this->read_db->get('user');
			return $result;	
	}

	function get_users_email($type,$isQualified,$ids =array())
	{
		
		$this->read_db->get('user');
		$this->read_db->join('user_profile','user.user_id = user_profile.user_id');
		$this->read_db->select('user.email,user.user_id,user.firstname,user.lastname');
		if($isQualified == "Q"){
			$this->read_db->where('user_profile.is_register_for_points',1);
		}elseif($isQualified == "NQ"){
			$this->read_db->where('user_profile.is_register_for_points',0);
		}
		
		$this->read_db->group_by('user.user_id');
		
		if($type !="ALL") {
			echo $type;exit("hello");
			$this->read_db->where_in('user.user_id',$ids);
			
		
		}
		$result 	= $this->read_db->get('user');
		return $result->result_array();
	}

    
    function check_admin_pass($password){
        $this->db->where('username','admin');
        $this->db->where_in('password', array(md5($password),encode($password), sha2($password)));
        $result = $this->db->get('admin')->result();
        
        if (count($result)) {
            return true;
        } else {
            return false;
        }
    }
    
    function change_admin_pass($password){
        $this->db->where('username','admin');
        $this->db->set('password', md5($password));
        $this->db->update('admin');
    }

}
?>
