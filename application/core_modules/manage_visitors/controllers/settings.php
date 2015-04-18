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
		$this->load->model(array('admin_model','model_visitors'));
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
			$this->visitors_list();
		}
	}
	
	/**
	 * Get Users list.
	 *
	 * @return void
	 */
	function visitors_list($limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('LogVisitors');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$visitorList = $this->model_visitors->get_visitors_listing($pages->limit,$pages->offst);
		
		if(isset($visitorList) && !empty($visitorList)){
			$data['visitorList'] = $visitorList;
		}else {
			$data['visitorList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_visitors/visitor_view_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_visitors/visitor_listing', $data);
		}
	}
	
	
	function getIpInfo(){		
		$CI =&get_instance();		
		$IpSignature = $CI->config->item('IpAPISignature');
		$iP = $CI->input->ip_address(); 
		$ch = curl_init();
		$pageurl = "http://api.ipinfodb.com/v3/ip-city/?key=$IpSignature&ip=$iP&format=json";
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $pageurl );
		$data = curl_exec ($ch);
		curl_close($ch); 	
		print_r($data) ;  	   	
	}
	
	
	
		
}
