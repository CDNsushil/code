<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author	Lalit
 */
class Admin_statistics extends MX_Controller
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

			$this->load->model('statistics_model');		
			$this->load->model('admin_model');
			$this->load->language('admin_template');
			$this->load->library('admin_template');
			$this->load->library('pagination');
			$this->load->model('user_profile');		
			$this->load->helper('admin_common_helper');
			$this->load->library('email');
			$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model		

		}

		function index()
		{
			 //---- Check login status  -----
			if($this->login_check())
			{
				$template_data['data'] = "";
				$this->admin_template->load('admin/admin_template','statistics_dash',$template_data);

			} else {
				redirect('admin/admin'); // redirect if user not login
			}
		}

		// Function for display user statistics
		function user_statistics()
		{
			
			// Get numbers of registered users for today
			$template_data['user_count_arr'] = $this->statistics_model->getUsercount();
			$str =  $this->load->view('user_statistics',$template_data,true);
			echo $str;
		}	

		function country_statistics()
		{
			// Get numbers of registered users for today
			//$template_data['recent_user_count'] = $this->statistics_model->getUsercount('recent');

			// Get number of all user of site
			//$template_data['total_user_count']  = $this->statistics_model->getUsercount('all');
			// Get  country list 
			$template_data['country']    = $this->admin_model->get_country_list()->result();

			$str =  $this->load->view('country_statistics',$template_data,true);
			echo $str;
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
