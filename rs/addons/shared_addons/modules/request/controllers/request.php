<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Rajendra
 * @package request\Controllers
 */
 class Request extends Public_Controller {
        public function __construct(){
			parent::__construct();
	
		$this->load->library('form_validation');
	
	
		$userId=is_logged_in();
		
    }

	function index() {
	
	
	
	}
	

	
}
?>
