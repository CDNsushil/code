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
		$this->load->model(array('model_manage_suggestions'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->head->add_css($this->config->item('system_css').'frontend.css');
	}//end __construct()

	/*
	 * @access public
	 * @return  void
	 */
	public function index()
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->manage_suggestions();
		}
	}//end index()
	
	public function manage_suggestions_old($limit='',$perPage='')
	{		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_manage_suggestions->get_suggestions();
		$pages = new Pagination_ajax;
		$pages->items_total = count($countTotal); // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
			
		$data['suggestions'] = $this->model_manage_suggestions->get_suggestions($pages->limit,$pages->offst);
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_suggestions/suggestions_list', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_suggestions/manage_suggestions_list',$data);		
		}
		
	}//end manage_users()

	/*
	 *********************************** 
	 *  This function is used to show suggestions grid
	 *********************************** 
	 */ 
	 
	function manage_suggestions() {
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$this->head->add_css($this->config->item('editable_plugins').'demo_page.css');
		$this->head->add_css($this->config->item('editable_plugins').'demo_table.css');
		$this->head->add_js($this->config->item('editable_plugins').'jquery.dataTables.js');
		$suggestions = $this->model_manage_suggestions->get_suggestions();
		$data['suggestions'] = $suggestions;
		$this->toad_admin_template->load('toad_admin_template','suggetion_listing_new', $data);
	}

}//end Settings

