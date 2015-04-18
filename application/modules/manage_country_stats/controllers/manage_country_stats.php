<?php
/**
 * Chatching Admin Manage Country stats Controller Class
 * Manage Admin country stats etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Manage_country_stats extends MX_Controller
{
		//Constructor
		function __construct()
		{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('manage_country_stats_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->model('report/report_model');
		$this->load->library('pagination');
		$this->load->model('user_profile');		
		$this->load->library('email');
		$this->load->helper('admin_common_helper');
		$this->load->model('admin_users/users_model'); // Added by lalit - User for get user model		
		$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model
		$this->load->model('admin_mail/mail_model'); // Added by lalit - User for get user model
		$this->load->language('app_template'); // Added by lalit
		}

/********** Code merge by */
	
	/**
	* Author CDNSOL
	* Function for display user's data 
	* Created date : 6-6-2012	
	**/
	function index() {

	      //---- Check login status  -----
		if($this->login_check())
		{
							/*------- Get Country list ------*/
					$search_country = $this->input->get('search_country');
					$template_data['search_country'] = $search_country;
					
				/*------ End -----*/
		
				/*------------------pagination-------------------*/
			$perpage            	 = 10;
			$page           	     = $this->input->get('per_page');
			$page       	         = ($page>0?$page:1);
			
			$config               	 = $this->pageing_model->get_config_paging();
			$config['base_url']      = base_url().'manage_country_stats?search_country='.$search_country;
			$config['page_query_string'] = TRUE;
			$template_data['country_arr']	 = $this->manage_country_stats_model->get_country_list($search_country,$page,$perpage);
			$country_arr = $this->manage_country_stats_model->get_country_list($search_country,$page,0);
			$config['total_rows']  = $country_arr->num_rows();
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);
			$template_data['paging']           =  $this->pagination->create_links();
				/*-------------------------------------*/
			
			$this->admin_template->load('admin/admin_template','manage_country_stats_list',$template_data); 

		} else {
			redirect('admin/admin'); // redirect if user not login
		}		
	}


		
	/**
	* Author CDNSOL
	* Function for display user's list by country_id
	* Param : Country Id 
	* Created date : 6-6-2012	
	**/
	function user_list($country_id){

	      //---- Check login status  -----
		if($this->login_check()) {
			$gender = $this->input->get('gender');
			$search_user = $this->input->get('user_search');
			/*------------------pagination-------------------*/
			$perpage            	 = 10;
			$page           	     = $this->input->get('per_page');
			$page       	         = ($page>0?$page:1);
			
			$config               	 = $this->pageing_model->get_config_paging();
			$config['base_url']      = base_url().'manage_country_stats/user_list/'.$country_id.'?gender='.$gender.'&user_search='.$search_user;
			$config['page_query_string'] = TRUE;
			$template_data['users']	 = $this->manage_country_stats_model->get_user_list($country_id,$search_user,$gender,$page,$perpage);
			$user_arr = $this->manage_country_stats_model->get_user_list($country_id,$search_user,$gender,$page,0);
			$config['total_rows']  = $user_arr->num_rows();
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);
			$template_data['paging']           =  $this->pagination->create_links();
			$template_data['search_user'] = $search_user;
				/*-------------------------------------*/
			
			$this->admin_template->load('admin/admin_template','user_list',$template_data);
		
		}else{
			redirect('admin/admin'); // redirect if user not login
		}

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


		
}

?>
