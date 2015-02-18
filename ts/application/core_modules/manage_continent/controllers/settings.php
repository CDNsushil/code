<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller for CodeIgniter tip files editor.
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
		$this->load->model(array('model_continent','admin_model'));
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
			$this->continent_list_new();
		}
	}
	
	/**
	 * Get Continent list.
	 *
	 * @return void
	 */
	function continent_list($limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('MasterContinent');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$continentList = $this->model_continent->get_continent_listing($pages->limit,$pages->offst);
		
		if(isset($continentList) && !empty($continentList)){
			$data['continentList'] = $continentList;
		}else {
			$data['continentList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_continent/continent_listing_view', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_continent/continent_listing', $data);
		}
	}
	
	/**
	* Function to Manage Continent.
	*/
	public function continent_manage($continentId=0)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get Continent data*/
			$data['continentData'] = $this->model_continent->get_continent_details($continentId);	
			$this->toad_admin_template->load('toad_admin_template','manage_continent/continent_manage',$data);
		}
	}
	
	/**
	* Insert or Update Continent Data.
	*/
    public function update_continent()
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$continentId 			= $this->input->post('continentId');
			$data['continent'] 		= $this->input->post('continent');
			$data['lang']			= $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			
			/*Insert or Update Continent*/
			if(isset($continentId) && !empty($continentId)){
				$updateContinent = $this->model_continent->update_continent($data,$continentId);
			}else{
				$addContinent = $this->model_continent->add_continent($data);
			}
		}
	}
	
	/**
	* Function to update Continent status.
	*/
	function updateStatus()
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$continentId = $this->input->post('continentId');
		$continentStatus = $this->input->post('status');
		if($continentStatus == 0){
			$data['status'] = 'f';
		}else{
			$data['status'] = 't';
		}
		
		if(isset($continentId)){
			$updateActiveStatus = $this->model_continent->update_continent($data,$continentId);
		}else{
			return false;
		}
	}
	
	/*
	 *********************************** 
	 *  This function is used to show continent grid
	 *********************************** 
	 */ 
	 
	function continent_list_new() {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
		$continentList = $this->model_continent->get_continent_listing();
		$data['continentList'] = $continentList;
		$this->toad_admin_template->load('toad_admin_template','continent_listing_new', $data);
	}
	
	/*
	 *********************************** 
	 *  This function is used to update continent record
	 *********************************** 
	 */ 
	
	function continent_data_update()
	{
		// This section for update records
		if($this->input->post('continentId'))
		{
			$continentId = $this->input->post('continentId');
			$data['continent'] = $this->input->post('continent');
			$data['lang'] = $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			
			$updateContinent = $this->model_continent->update_continent($data,$continentId);
			//echo "Record updated.";
		}else
		{
			// This section add new record
			$data['continent'] = $this->input->post('continent');
			$data['lang'] = $this->input->post('lang');
			if($this->input->post('status') == '1')
			{
				$data['status'] = 't';  
			} else {
				$data['status'] = 'f';
			}
			$addContinent = $this->model_continent->add_continent($data);
			echo $addContinent;
		}
	}
	
}
