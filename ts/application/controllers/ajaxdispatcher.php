<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajaxDispatcher extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	function index()  {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email Address','required|valid_email');
			if($this->form_validation->run() == FALSE)  {
			  $data['alert'] = validation_errors('<div class="alert">','</div>');
			} else {
			  $data['alert'] = '<h1>Congrats! This is valid: '.$this->input->post('email').'</h1>';
			}
		
		$this->load->view('ajax_dispatcher',$data);		
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */