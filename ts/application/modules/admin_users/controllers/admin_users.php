<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Admin_users extends MX_Controller
{
		//Constructor
		function __construct()
		{
			parent::__construct();
			//Load the report model
			$this->load->model('users_model');
			
			date_default_timezone_set('Asia/Calcutta');
			$language = 'english';
			if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->helper('form');
		$this->load->model('common_model');
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->library('pagination');
		$this->load->model('user_profile');		
		
		$this->load->library('email');
		$this->load->model('admin_users/users_model'); // Added by lalit - User for get user model	
		$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model		
		$this->load->model('admin_mail/mail_model'); // Added by lalit - User for get user model
		$this->load->model('admin_privacy_setting/admin_privacy_setting_model');	

		}

/********** Code merge by lalit */
	
	/**
	* Author Lalit
	* Function for display user's data 
	* Created date : 7-5-2012	
	**/
	function index() {

	      //---- Check login status  -----
		if($this->login_check())
		{
			

			
		// Pagination Configuration		
			$users_list = $this->users_model->get_users_list();
		/*-------------  Variable use for filter  ----------*/
			$filter	      =  $this->input->post('filter');

			$filter_new   =  $this->uri->segment(2);
			


			// Paging configuration libary
			$config = $this->pageing_model->get_config_paging();
			if($filter) { 
			$config['base_url'] = base_url().'/admin_users/index/'.$filter.'/';	
			} else { 
			$config['base_url'] = base_url().'/admin_users/index/'.$this->uri->segment(3).'/';	
			}

			$config['total_rows'] = $users_list->num_rows();

			if($filter) { $config['uri_segment'] = 5; } else { $config['uri_segment'] = 4; }

			$this->pagination->initialize($config);

			if ( $this->uri->segment($config['uri_segment']) > 0 ) {
				$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
				$template_data['i']= $start+1;
			} else { 
				$start = 0;
				$template_data['i'] = 1;
			}
			
			$template_data['paging'] =  $this->pagination->create_links();

			// Get user list data and assing with pagination variables 
			$template_data['users'] = $this->users_model->get_users_list($start,$config['per_page'])->result();
	
			if($this->uri->segment(3) == 'today') {
				 $template_data["today"] = "today";
			} else { $template_data["today"] = ""; }

			if($filter) {	$template_data["filter_post"]    =  $this->input->post('filter'); 
			} else {	
			 $template_data["filter_post"] =  $this->uri->segment(3);
			}

			$this->admin_template->load('admin/admin_template','users_list',$template_data);

		} else {
			redirect('admin/admin'); // redirect if user not login
		}		
	}


		
	/**
	* Author Lalit
	* Function for display user's Profile by user_id
	* Param : user_id 
	* Created date : 7-5-2012	
	**/
	function user_profile(){

	      //---- Check login status  -----
		if($this->login_check()) {

			if($this->uri->segment(3)){
				$user_id = $this->uri->segment(3);	
				
				// Get user list data and assing with pagination variables 
				$get_type = "";
				$template_data['users'] = $this->users_model->get_users_profile($user_id,$get_type);

				//--------------------- Function get dob ------------------------------
				$template_data['dob'] = $this->users_model->get_dob($template_data['users'][0]->dob);
			
				//---------------------- Function for point ----------------------------
				$template_data['point'] = $this->user_profile->get_user_points($user_id);

				$this->admin_template->load('admin/admin_template','users_profile',$template_data);
			}
		
		} else {
			redirect('admin/admin'); // redirect if user not login
		}

	}


/**
	* Author Lalit
	* Function for edit user data by id
	* Param : user_id 
	* Created date : 7-5-2012	
	**/	
	function user_edit()
	{
      //---- Check login status  -----
		if($this->login_check()) {

			if($this->uri->segment(3)) {
				$user_id = $this->uri->segment(3);
				// get country; state; city data
			$country_query = $this->common_model->get_country();
			if($country_query!=false) $data['country_query'] = $country_query;
			//print_r( $data['country_query']->result()) 	;die;
			if(isset($country_id) && $country_id>0)	
			{			
				$state_query = $this->common_model->get_states_by_country($country_id);
				if($state_query!=false) $data['state_query'] = $state_query;
			}	
			else
			{
				$data['state_query'] = array();
			}
			
			if(isset($state_id) && $state_id>0 && $country_id>0)		
			{
				$city_query = $this->common_model->get_cities_by_state($state_id);
				if($city_query!=false) $data['city_query'] = $city_query;
			}	
			else
			{
				$data['city_query'] = array();
			}

				$template_data['c_s_c'] = $this->users_model->get_user_country_state_city($user_id);
				$country_id = 233;
				$template_data['country_id'] = $country_id;

				$get_type = "all_data";
				$template_data['users'] = $this->users_model->get_users_profile($user_id,$get_type);    // Get User Data
				$template_data['dob']   = $this->users_model->get_dob($template_data['users'][0]->dob); // Get DOB
				$template_data['point'] = $this->user_profile->get_user_points($user_id); 		// Get User Point
				$template_data['user_type_list']			=$this->admin_privacy_setting_model->get_user_type();	
				$template_data['user_id'] = $user_id;
				// Get  country list 
				$template_data['country']    = $this->admin_model->get_country_list()->result();
				//echo "<pre>";print_r($template_data);die;
				$this->admin_template->load('admin/admin_template','users_edit',$template_data);
		        }
		} else {
			redirect('admin/admin'); // redirect if user not login
		}
	}	


	/**
	* Author Lalit
	* Function for User updation
	* Param : user_id 
	* Created : 8-5-2012	
	**/	
	function user_update()
	{
		$user_id = $this->input->post('user_id');
		$this->users_model->user_profile_update();

	   	/*------------------------------------------------------------
							Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------*/
				$user_array = $this->session->userdata('session_data');
				$userId    = $user_array['user_id'];
				$module_name 	   = "User Profile's ";
				$module_action    = "update"; 
				$module_summary   = "User ".$this->input->post('name')." ".$this->input->post('lastname');
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/							
							
		
		$this->session->set_flashdata('message','Data updated');
		redirect('admin_users/user_profile/'.$user_id);
	}

	/**
	*Author Lalit
	*Function for change user activation status
	*Params activation value
	* Created : 8-5-2012	
	*/
	function activation_status()
	{
		$template_data['user_id'] = $_POST['user_id'];
		$template_data['activation_val'] = $_POST['activation_val'];
		$str =  $this->load->view('admin_users/activation_temp',$template_data,true);
		echo $str;
	}

	/**
	*Author Lalit
	*Function for change user activation status
	*Params activation value
	* Created : 8-5-2012	
	*/
	function update_deactication()
	{
		$user_id = $this->input->post('user_id');
		$this->users_model->update_user_activation();
		
		
		/*--------------------------------------------------------------------------
							Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------------------*/
				$user_array 		= $this->session->userdata('session_data');
				$userId    			= $user_array['user_id'];
				$module_name 	   = "User Profile's ";
				$module_action    = "Status updated"; 
				$module_summary   = "User ".get_firstname($user_id);
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*------------------------------ END --------------------------------------*/	
		
		redirect('admin_users/user_profile/'.$user_id);
	}

	/**
	* Function to check session for admin login	
	**/
	public function login_check(){
		if($this->session->userdata('session_data')){
			return true;
		}else{
			return false;
		}
	}
	
        // Created for deletion of user previously named as delete_user  
	function delete_user_old($user_id){
		$res = $this->users_model->delete_user($user_id);
		if($res){
			$this->session->set_flashdata('message',$this->lang->line('user_successfully_deleted'));
			redirect('admin_users');
			}
		else{
			$this->session->set_flashdata('message',$this->lang->line('unable_to_delete_this_user'));
			redirect('admin_users');
			}
		}


       /**
	 
         * Function to set delete flag in user table 
         * Param : user_id 
         * Amit Wali
         * Created on 05-07-12	

	**/
  
         function  delete_user($user_id) {
 
             $this->users_model->delete_user_temp($user_id);
             
           /*------------------------------------------------------------
							Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------*/
				$user_array			 = $this->session->userdata('session_data');
				$userId    			= $user_array['user_id'];
				$module_name 	   = "User Profile's ";
				$module_action    = "Delete"; 
				$module_summary   = "User ".get_firstname($user_id);
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/							
			
			
             $this->session->set_flashdata('message','User Temporarily Deleted');
	     redirect('admin_users');               

         }
		
		
}

?>
