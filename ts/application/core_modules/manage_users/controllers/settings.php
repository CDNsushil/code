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
		$this->load->model(array('model_manage_users'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
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
	
	public function manage_users_old($limit='',$perPage='') {		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit :  $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('UserAuth');
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		
		$data['users'] = $this->model_manage_users->get_users($pages->limit,$pages->offst);
		
		//$this->toad_admin_template->load('toad_admin_template','manage_users/manage_user_list',$data);
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_users/user_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_users/manage_user_list', $data);
		}
	}//end manage_users()

	/*
	 *  Function to show all user listing
	 */
	public function manage_users() {		
		$data['users'] = $this->model_manage_users->get_users(2);
		$data['getUserType'] = 'allUser';
		$this->toad_admin_template->load('toad_admin_template','manage_users/manage_user_list', $data);
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
		$this->toad_admin_template->load('toad_admin_template','manage_users/manage_user_list', $data);
	}
	
	/*
	 * Function to get all Inactive users 
	 */
	public function getAllInActiveUsers() {		
		$data['users'] = $this->model_manage_users->get_users(0);
		$data['getUserType'] = 'inactive';
		$this->toad_admin_template->load('toad_admin_template','manage_users/manage_user_list', $data);
	}
	
	
}//end Settings

// End of Admin User Controller
/* End of file settings.php */
/* Location: ./application/core_modules/controllers/settings.php */
