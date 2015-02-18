<?php
/**
 * Admin Theme
 * Manage Theme 
 * @category	Controller
 * @author		Lalit
 */
class Admin_theme extends MX_Controller
{
		//Constructor
		function __construct()
		{
		parent::__construct();
		//Load the report model

		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('theme_model');
		$this->load->helper('common');

		$this->load->model('admin_users/users_model');
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->model('user_profile');		
		

		}
		
	/**
	* Author Lalit
	* Function for Send emails to User and Employee
	* Created : 9-5-2012	
	*/
	function index()
	{
			$data	=	 array();

				// Created date : 21-05-2012
					$data['theme_options']  	= $this->theme_model->get_theme_temp();
					$data['theme_active']  		= $this->theme_model->get_theme_active();
				//------ End -------
				$this->load->view('admin_theme',$data);
	}


/**
	 *Created 21-5-2012
	 * Function for store theme option data 
	 * Author Lalit
	 **/
	 function update_theme()
	 {
		$this->theme_model->save_theme_data();
		redirect('profile/settings');
	 }
	
	/**
	 * Created : 21-5-2012
	 * Author Lalit
	 * */
	 function set_theme_preview()
	 {
		 $temp_session = $this->input->post('theme_session');

		$newdata = array(
                   'theme_session' => $temp_session
               );
		$this->session->set_userdata($newdata);
		
		echo "Session created";
	 }
	
		
}

?>
