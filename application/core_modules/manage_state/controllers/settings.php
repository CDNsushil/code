<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for CodeIgniter state files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */

class Settings extends MY_Controller{
	function __construct(){
		parent::__construct();
			
		$this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
		$this->load->model(array('model_managestates','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('default_css').'template.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
	}
	
	function index(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->state_list();
		}
	}
	
	/**
	 * Get States list.
	 *
	 * @return void
	 */
	function state_list_old($limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('MasterStates');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$stateList = $this->model_managestates->get_state_listing($pages->limit,$pages->offst);
		
		if(isset($stateList) && !empty($stateList)){
			$data['stateList'] = $stateList;
		}else {
			$data['stateList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_state/state_listing_view', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_state/state_listing', $data);
		}
	}
	
	/**
	* Function to Manage State.
	*/
	public function state_manage($stateId=0)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get State data*/
			$data['stateData'] = $this->model_managestates->get_state_details($stateId);	
			$this->toad_admin_template->load('toad_admin_template','manage_state/state_manage',$data);
		}
	}
	
	/**
	* Insert or Update State Data.
	*/
    public function update_state()
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$stateId 				= $this->input->post('stateId');
			$data['stateName'] 		= $this->input->post('stateName');
			$data['stateCode'] 		= $this->input->post('stateCode');
			$data['countryId']		= $this->input->post('countryId');
			$data['lang']			= $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			
			/*Insert or Update State*/
			if(isset($stateId) && !empty($stateId)){
				$updateCountry = $this->model_managestates->update_state($data,$stateId);
			}else{
				$addCountry = $this->model_managestates->add_state($data);
			}
		}
	}
	
	/* Function to update Status status */
	function updateStatus()
	{
		$stateId = $this->input->post('stateId');
		$stateStatus = $this->input->post('status');
		if($stateStatus == 0){
			$data['status'] = 'f';
		}else{
			$data['status'] = 't';
		}
		
		if(isset($stateId)){
			$updateActiveStatus = $this->model_managestates->update_state($data,$stateId);
		}else{
			return false;
		}
	}
	
	/*
	 *********************************** 
	 *  This function is used to show country grid
	 *********************************** 
	 */ 
	 
	function state_list() {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limitRequest = $this->input->post('pageLimit');
		if(isset($limitRequest) && !empty($limitRequest)){
			$limit1 = $limitRequest;
			$perPage1 = $limitRequest;
		}else{
			$limit1 = 10;
			$perPage1 = 10;
		}
		
		$limit= (!empty($limit))? $limit : $limit1;
		$perPage=(!empty($perPage)) ? $perPage : $perPage1;
		$countTotal = $this->model_common->countResult('MasterStates');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$stateList = $this->model_managestates->get_state_listing($pages->limit,$pages->offst);
		$data['stateList'] = $stateList;
		//echo "<pre>";
		//print_r($data);die;
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			
			$this->load->view('state_view', $data);
		}else{
			//$this->toad_admin_template->load('toad_admin_template','state_listing_new', $data);
			$this->toad_admin_template->load('toad_admin_template','state_listing', $data);
		}
		
		//$stateList = $this->model_managestates->get_state_listing();
		//$data['stateList'] = $stateList;
		//$this->toad_admin_template->load('toad_admin_template','state_listing_new', $data);
	}
	
	/*
	 *********************************** 
	 *  This function is used to update state record
	 *********************************** 
	 */ 
	
	function state_data_update()
	{
		// This section for update records
		if($this->input->post('stateId'))
		{
			$stateId = $this->input->post('stateId');
			$data['stateName'] = $this->input->post('stateName');
			$data['stateCode'] = $this->input->post('stateCode');
			$data['countryId'] = $this->input->post('countryId');
			$data['lang'] = $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			
			$updateState = $this->model_managestates->update_state($data,$stateId);
			//echo "Record updated.";
		}else
		{
			// This section add new record
			$data['stateName'] = $this->input->post('stateName');
			$data['stateCode'] = $this->input->post('stateCode');
			$data['countryId'] = $this->input->post('countryId');
			$data['lang'] = $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			$addState = $this->model_managestates->add_state($data);
			echo $addState;
		}
	}
	
}
