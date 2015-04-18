<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for CodeIgniter language files editor.
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
		$this->load->model(array('model_lang','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('default_css').'template.css');
	}
	
	function index(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->language_list();
		}
	}
	
	/**
	 * Get Language list.
	 *
	 * @return void
	 */
	function language_list_old($limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('MasterLang');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] 		= $pages->items_total;
		$data['items_per_page']		= $pages->items_per_page;
		$data['pagination_links'] 	= $pages->display_pages();	
		$data['countTotal'] 		= $countTotal;
		
		$languageList = $this->model_lang->get_language_listing($pages->limit,$pages->offst);
		
		if(isset($languageList) && !empty($languageList)){
			$data['languageList'] = $languageList;
		}else {
			$data['languageList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_lang/lang_listing_view', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_lang/lang_listing', $data);
		}
	}
	
	/**
	* Function to Manage Language.
	*/
	public function language_manage($langId=0)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get Continent data*/
			$data['languagetData'] = $this->model_lang->get_language_details($langId);	
			$this->toad_admin_template->load('toad_admin_template','manage_lang/lang_manage',$data);
		}
	}
	
	/**
	* Insert or Update Language Data.
	*/
    public function update_language()
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$langId 			= $this->input->post('langId');
			$data['Language'] 		= $this->input->post('Language');
			$data['Language_local']	= $this->input->post('Language_local');
			$data['lang_abbr']	= $this->input->post('lang_abbr');
			
			/*Insert or Update Language*/
			if(isset($langId) && !empty($langId)){
				$updateLang = $this->model_lang->update_language($data,$langId);
			}else{
				$addLang = $this->model_lang->add_language($data);
			}
		}
	}
	
	/**
	* Function to update Language status.
	*/
	function updateStatus()
	{
		$langId = $this->input->post('langId');
		$continentStatus = $this->input->post('status');
		if($continentStatus == 0){
			$data['status'] = 'f';
		}else{
			$data['status'] = 't';
		}
		
		if(isset($continentId)){
			$updateActiveStatus = $this->model_lang->update_language($data,$langId);
		}else{
			return false;
		}
	}
	
	/*
	 *********************************** 
	 *  This function is used to show Language grid
	 *********************************** 
	 */ 
	 
	function language_list() {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
		$languageList = $this->model_lang->get_language_listing();
		$data['languageList'] = $languageList;
		$this->toad_admin_template->load('toad_admin_template','lang_listing_new', $data);
	}
	
	/*
	 *********************************** 
	 *  This function is used to update continent record
	 *********************************** 
	 */ 
	
	function language_data_update()
	{
		// This section for update records
		if($this->input->post('langId'))
		{
			$langId = $this->input->post('langId');
			$data['Language'] = $this->input->post('Language');
			$data['Language_local'] = $this->input->post('Language_local');
			$data['lang_abbr'] = $this->input->post('lang_abbr');
			$updateLang = $this->model_lang->update_language($data,$langId);
			//echo "Record updated.";
		}else
		{
			// This section add new record
			$data['Language'] = $this->input->post('Language');
			$data['Language_local'] = $this->input->post('Language_local');
			$data['lang_abbr'] = $this->input->post('lang_abbr');
			$addLang = $this->model_lang->add_language($data);
			echo $addContinent;
		}
	}
	
}
