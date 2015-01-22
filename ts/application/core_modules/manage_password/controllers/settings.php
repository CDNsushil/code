<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users Controller
 * Display the user list and manage the user deletions/banning/purge
 */
class Settings extends MX_Controller
{
	/**
	 * Setup the required permissions
	 *
	 * @return void
	 */
	public function __construct()
    {
		parent::__construct();
		$this->load->language('admin_template'); //you can delete it if you have translation for you language
		$this->load->model(array('model_manage_users','messagecenter/model_message_center'));
		$this->load->library(array('session','language/lang_library','messagecenter/lib_message_center')); //load libraries if youre not doing it in autoload
		$this->head->add_css($this->config->item('system_css').'frontend.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
	}//end __construct()

	//--------------------------------------------------------------------

	/*
	 *
	 * @access public
	 *
	 * @return  void
	 */
	public function index()
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->manage_users();
		}
	}//end index()
	
	/*
	 *  Function to show all user listing
	 */
	public function manage_users() {		
		$data['users'] = $this->model_manage_users->get_users(2);
		$data['getUserType'] = 'allUser';
		$this->toad_admin_template->load('toad_admin_template','manage_password/manage_user_list', $data);
	}
	
	/*
	 *  Function to update Users status 
	 */
	function updateStatus() {
		$tdsUid = $this->input->post('tdsUid');
		$data['active'] = $this->input->post('status');
		$updateActiveStatus = $this->model_manage_users->update_status($data,$tdsUid);
	}
	
	/* 
	 * Function to remove user records 
	 */
	function removeUserRecord() {
		//get users id from post val
		$tdsUid = $this->input->post('tdsUid');
		//make array of user record tables
		$tbl=array('UserProfile','UserShowcase','UserAuth','UserContainer');
		if(isset($tdsUid) && !empty($tdsUid)){
			for($i=0;$i<count($tbl);$i++){
				//remove users record from Users records
				$this->model_manage_users->remove_user_records($tbl[$i],$tdsUid);
			}
		}
	}
	
	/*
	 * Function to get all active users 
	 */
	public function getAllActiveUsers() {		
		$data['users'] = $this->model_manage_users->get_users(1);
		$data['getUserType'] = 'active';
		$this->toad_admin_template->load('toad_admin_template','manage_password/manage_user_list', $data);
	}
	
	/*
	 * Function to get all Inactive users 
	 */
	public function getAllInActiveUsers() {		
		$data['users'] = $this->model_manage_users->get_users(0);
		$data['getUserType'] = 'inactive';
		$this->toad_admin_template->load('toad_admin_template','manage_password/manage_user_list', $data);
	}
	
	/*
	 * Function to send password email to user
	 */
	function setEmails() {
		$userIds = $this->input->post('userIds');
		$from_email = $this->config->item('webmaster_email', '');
		/* while we don't remove restriction (username, password) in .htacess file  from live site*/
		$image_base_url = base_url().'images/email_images/';
		$crave_url = $this->config->item('crave_us');
		/* Set Follow us link*/
		$facebook_url = $this->config->item('facebook_follow_url');
		$linkedin_url = $this->config->item('linkedin_follow_url');
		$twitter_url = $this->config->item('twitter_follow_url');
		$gPlus_url = $this->config->item('google_follow_url');
		$site_url = base_url();
		$where = array('purpose'=>'sendpassword','active'=>1);
		$adminTemplateRes = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
		if(!empty($adminTemplateRes)) {
			$adminTemplate = $adminTemplateRes[0]->templates;
			$searchArray = array("{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}","{site_url}");
			$replaceArray = array($image_base_url,$crave_url,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url,$site_url);
			$adminMailTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
			for($i=0;$i<count($userIds);$i++){
				if(isset($userIds[$i]) && !empty($userIds[$i])){
					/* Send Email to users */
					$userEmail =  $this->model_manage_users->get_user_email($userIds[$i]);
					if(!empty($userEmail)){
						$this->email->from($from_email, $this->config->item('website_name', ''));
						$this->email->to($userEmail);
						$this->email->subject(sprintf($adminTemplateRes[0]->subject));
						$this->email->message($adminMailTemplate);
						$flag = $this->email->send();
					}
				}
			}
		}
	}
	
	
}//end Settings

// End of Admin User Controller
/* End of file settings.php */
/* Location: ./application/core_modules/controllers/settings.php */
