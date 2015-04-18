<?php
class Admin_global_setting extends MX_Controller{	
	var $data =array();

	/**	* Constructor	**/	
	function __construct(){		
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->language('admin_template');
		$this->load->helper('common');									
		$this->load->model('admin_global_setting_model');	
		$this->load->library('admin_template');	
		$this->load->language('wall');		
	}	

	/*
	 * @Input : None
	 * @Output : Returns global settings from database
	 */
	
	function index()
	{
		$this->get_global_settings();
	}			
			
	/*
	 * @Input : None
	 * @Output : Get global settings	
	 */
	function get_global_settings(){	
		$admin_global_setting = $this->memcached_library->get('admin_global_setting'); 
		if(!$admin_global_setting){		
			$admin_global_setting           = $this->admin_global_setting_model->get_global_settings();
			$this->memcached_library->add('admin_global_setting',$admin_global_setting,$this->config->item('memcache_user_data_time'));
		}
		$data['settings']  =$admin_global_setting;
		$this->admin_template->load('admin/admin_template','global_setting',$data);
	}

	/*
	 * @Input : None
	 * @Output : Set global settings	
	 */
	function set_global_settings(){					
		if($this->input->post()){
			if($this->admin_global_setting_model->save_global_setting())
			{
				// set message here
				$this->session->set_flashdata('global_setting_saved','Global settings have been saved successfully');
				/** delete data from memcache if there is any new post **/
				$this->memcached_library->delete('admin_global_setting');
				$this->memcached_library->flush();
			}
			redirect(BASEURL.'admin_global_setting');
		}				
	}	
}
?>
