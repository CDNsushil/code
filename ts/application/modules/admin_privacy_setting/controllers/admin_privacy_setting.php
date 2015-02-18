<?php
class Admin_privacy_setting extends MX_Controller{	
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
			$this->load->model('admin_privacy_setting_model');	
			$this->load->library('admin_template');	
			$this->load->language('wall');		
			}	

			/*-----------------------------------------------------	
			| Comment:  Function for  user account content Privacy	
			-------------------------------------------------------*/	
			function index(){					
				if($this->input->post('saveUserSetting')){
						$this->admin_privacy_setting_model->save_user_account_setting();
						redirect(BASEURL.'admin_privacy_setting');
				}				
				
				$data['user_id']				= $this->session->userdata('user_id');
				$data['user_type_list']			=$this->admin_privacy_setting_model->get_user_type();				
				$data['user_account_setting']	=$this->admin_privacy_setting_model->get_user_account_setting();				
				$data['admin_section_list']		=$this->admin_privacy_setting_model->get_section_list();
								
				
				$this->admin_template->load('admin/admin_template','privacy_setting',$data);
			}			
			
}
?>
