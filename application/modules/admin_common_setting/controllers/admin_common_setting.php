<?php
class Admin_common_setting extends MX_Controller{	
	var $data = array();

	/**	* Constructor	**/	
	function __construct(){		
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->language('admin_template');
		$this->load->library('admin_template');	
		$this->load->language('wall');		
	}	

	/*
	 * @Input : None
	 * @Output : Returns common settings from database
	 */
	
	function index() {
		$this->get_common_settings();
	}			
			
	/*
	 * @Input : None
	 * @Output : Load common settings view	
	 */
	function get_common_settings(){	
		$data = array();
		$this->admin_template->load('admin/admin_template','common_setting',$data);
	}
}
?>