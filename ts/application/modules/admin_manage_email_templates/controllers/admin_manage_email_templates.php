<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Admin_manage_email_templates extends MX_Controller
{
		//Constructor
		function __construct()
		{$this->config->set_item('global_xss_filtering', false);
		parent::__construct();

		
		if(!$this->login_check()) {
			redirect('admin/admin');
		}
		//Load the report model
		$this->load->model('manage_email_templates_model');

		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('admin_users/users_model');
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->library('pagination');
		$this->load->model('user_profile');		
		$this->load->helper('common' );
		$this->load->library('email');

	
		$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model		

		}
		
	/**
	* Author Lalit
	* Function for Send emails to User and Employee
	* Created : 9-5-2012	
	*/
	function index()
	{
	
		if($this->login_check()) {
		$template_data['data'] = "test";
			$this->admin_template->load('admin/admin_template','view_email',$template_data);
		}else{
			redirect('admin/admin');		
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

	/**
	* Author Lalit
	* Params activation value
	* Created : 9-5-2012	
	*/
	function create_message()
	{
		$user_type = $this->input->post('user_type');
		$template_data['user_type'] = $user_type;
		$str 	  =  $this->load->view('create_message',$template_data,true);
		echo $str;
	}

/**
	* Author Lalit
	* Function for send email to user all and custom
	* Params activation value
	* Created : 9-5-2012	
	*/
	function view_email_template()
	{	
		$page = $this->manage_email_templates_model->view_email_list();
				$data_set = $page->result();
				$template_data['result'] = $data_set;
		$this->load->library('fckeditor');
				$this->fckeditor->ToolbarSets = "MyToolbar";
				$this->fckeditor->BasePath = base_url().'templates/admin_template/fckeditor/';
				$this->fckeditor->Width  = '600';
				$this->fckeditor->Height = '300';
				$this->fckeditor->ToolbarSet = 'Default';
				$this->fckeditor->Value = "";
		$this->admin_template->load('admin/admin_template','view_email',$template_data);
	}
	
	function update_email_template()
	{
        $key  = $this->uri->segment(3);
		if($this->input->post('key')){
		$key_id=$this->input->post('emailId');
			$page_arr =  array(
						'language_id' 	  			=> $this->input->post('language_id'),
						'key' 	  		=> $this->input->post('key'),
						'subject'	=> $this->input->post('subject'),
						'body'			=> $this->input->post('FCKeditor'),
						'body_text'			=> $this->input->post('body_text'),
						'resend_period'			=> $this->input->post('resend_period'),
						'resend_limit'			=> $this->input->post('resend_limit'),
						'preferred_method'			=> $this->input->post('preferred_method'),
						'from_name'			=> $this->input->post('from_name'),
						'from_email'			=> $this->input->post('from_email')
						
					);
		$result = $this->manage_email_templates_model->edit_page($key_id,$page_arr);
					 if(isset($result)){
                         $this->session->set_flashdata('edit_success','<span>Success!</span> Page saved Successfully');$this->msg="email template updated successfully";
						 redirect('admin_manage_email_templates/view_email_template',$this->msg);
					 }
				else{
					redirect('admin_manage_email_templates/editPage/'.$id);
				}
		}
		
		$page = $this->manage_email_templates_model->update_email_list($key);
		$template_data['result'] = $page->result();
		//echo "<pre>";print_r($template_data['result'][0]->body);die;
		$this->load->library('fckeditor');
				$this->fckeditor->ToolbarSets = "MyToolbar";
				$this->fckeditor->BasePath = base_url().'templates/admin_template/fckeditor/';
				$this->fckeditor->Width  = '600';

				$this->fckeditor->Height = '300';
				$this->fckeditor->ToolbarSet = 'Default';
				$this->fckeditor->Value = $template_data['result'][0]->body;
		$this->admin_template->load('admin/admin_template','update_email',$template_data);
	}
	
	
}

?>
