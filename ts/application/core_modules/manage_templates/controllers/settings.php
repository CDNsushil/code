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
		$this->load->model(array('model_manage_templates'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->head->add_css($this->config->item('system_css').'frontend.css');
	}//end __construct()

	/*
	 * @access public
	 * @return  void
	 */
	public function index()
	{
		$this->email_tmp();
	}//end index()
	
	public function email_tmp($limit='',$perPage='')
	{		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_manage_templates->get_email_templates('email');
		$pages = new Pagination_ajax;
		$pages->items_total = count($countTotal); // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$data['email_templates'] = $this->model_manage_templates->get_email_templates('email',$pages->limit,$pages->offst);
		$data['heading'] = 'Email Templates';
		$data['section'] = 'email';
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_templates/template_list', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_templates/manage_templates_list',$data);	
		}			
	}//end manage_users()
	
	public function tmail_tmp($limit='',$perPage='')
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_manage_templates->get_email_templates('tmail');
		$pages = new Pagination_ajax;
		$pages->items_total = count($countTotal); // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
					
		$data['email_templates'] = $this->model_manage_templates->get_email_templates('tmail',$pages->limit,$pages->offst);
		$data['heading'] = 'Tmail Templates';
		$data['section'] = 'tmail';
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_templates/template_list', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_templates_list',$data);	
		}
			
	}//end manage_users()

	public function detail($id=0)
	{		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($id>0){
		
		$where=array('id'=>$id,'active'=>1);
		$data['template_view'] = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
		}
		else
			$data['template_view'] =0;
		$this->toad_admin_template->load('toad_admin_template','detail',$data);		
	}//end manage_users()

	

}//end Settings

