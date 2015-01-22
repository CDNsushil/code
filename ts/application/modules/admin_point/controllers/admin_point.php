<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author	Lalit
 */
class Admin_point extends MX_Controller
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

			$this->load->model('point_model');
			$this->load->language('admin_template');
			$this->load->library('admin_template');
			$this->load->library('pagination');
			$this->load->model('user_profile');		
		
			$this->load->library('email');
			$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model		

		}

		function index()
		{

			//---- Check login status  -----
			if($this->login_check())
			{
				$template_data['data'] = "";
				$this->admin_template->load('admin/admin_template','point_dash',$template_data);
			} else {
				redirect('admin/admin'); // redirect if user not login
			}
		}

		
		function point_activity()
		{
			//---- Check login status  -----
			if($this->login_check())
			{
				$table_name  =  $this->uri->segment(3);
				$template_data['data'] = $this->point_model->get_activity($table_name); // First para: table_name

				if($table_name=="activity") { $template_name = 'point_activity'; } else { $template_name = 'point_distribution'; } 
 
				$this->admin_template->load('admin/admin_template',$template_name,$template_data);
			} else {
				redirect('admin/admin'); // redirect if user not login
			}
		}



		function update_point()
		{
			//---- Check login status  -----
			if($this->login_check())
			{
				$template_data['table_name']  = $this->input->post('table_name');
				$template_data['col_name']    = $this->input->post('col_name');
				$template_data['val']  	      = $this->input->post('val');
				$template_data['whr_col']     = $this->input->post('whr_col');
				$template_data['whr_id']      = $this->input->post('whr_id');

				$str =  $this->load->view('point_update',$template_data,true);
				echo $str;
			} else {
				redirect('admin/admin'); // redirect if user not login
			}

		}

		function update_save()
		{
			//---- Check login status  -----
			if($this->login_check())
			{	
				$table_name = $this->input->post('table_name');
				$this->point_model->update_save();
				$template_data['data'] = $this->point_model->get_activity($table_name); 	// First para: table_name
				if($table_name=="activity") { $template_name = 'point_activity'; } else { $template_name = 'point_distribution'; } 
				$this->admin_template->load('admin/admin_template',$template_name,$template_data);
			} else {
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
