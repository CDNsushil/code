<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Rajendra
 * @package home\Controllers
 */
 class Home extends Public_Controller {
        public function __construct(){
			parent::__construct();
	
		$this->load->library('form_validation');
		$this->load->model('home_model');
		$userId=is_logged_in();
		
    }
    /*
	* @Desc:load home form
	* @param:void
	* @return:void
	*/
	function index() {
	//get top contant of home
        
        $this->template
			->title($this->module_details['name'], $this->module_details['name'])
            ->append_metadata($this->load->view('fragments/wysiwyg', array() , true))
            ->set('slug', 'home')
			->build('home');
        //$this->template->build('home',$data); 
	}
	/*
	* @Desc:load aboutus page
	* @param:void
	*/
	function aboutus() {
	
		$this->template->build('aboutus'); 
	
	}
    public function editPageContents(){
        $post = $this->input->post();
        if(isset($post['id']) && (int)$post['id'] > 0){
            $res = $this->common_model->savePageContents($post);
            if($res){
               echo $post['description'];
            }
        }
    }
}
?>
