<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class aanaBase
{

	public $_aana_register;
    private static $ref;
    public $ci;
	
	private function __construct(){
		$this->ci =& get_instance();
	}
	
	private function getObjects(){
		$CI_package=new CI_Package();
		$CI_Views=new CI_Views();
		self::$ref->_aana_register[get_class($CI_package)]=$CI_package;
		self::$ref->_aana_register[get_class($CI_Views)]=$CI_Views;
	}
	
	public static function getRef(){
		if(!is_object(self::$ref))
        {
            self::$ref=new aanaBase();
			self::$ref->getObjects();
	    }
        return self::$ref;
	}
	
	public function name($name){
		return array("name"=>"Hello ".$name." ...","id"=>"1","address"=>"140 industry house");
	}
	/*
	*	Check If user is logged in or not
	*/
	public function isLoginUser(){
		$user_id=$this->session->userdata('user_id');
		if($user_id > 0){
			$userPackageKey=$this->input->post('userPackageKey');
			if(is_numeric($userPackageKey)){
				$this->session->set_userdata('userSelectedPackageKey',$userPackageKey);			
			}else{
				//echo "unset";
			}
			return $user_id;
		}else{
			$isAjaxHit=$this->input->get('ajaxHit')>0?$this->input->get('ajaxHit'):$this->input->post('ajaxHit');
			if($isAjaxHit > 0){
				redirect('home');
				//echo $expiredSession = '<div class="popup_box"><div onclick="$(this).parent().trigger(\'close\');" class="popup_close_btn"></div><div id="popupImagesContainer" class=""> 
				//'.$this->lang->line('sessionExpired').'</div></div>';
				//echo "<pre>";
				//print_r($this->load);
				//echo $this->load->view('ajaxLogin',"",true);
				//$data['sessionExpired']=$this->lang->line('sessionExpired');
				//include('ajaxLogin.php',$data);
				//die;
			}else{
				set_global_messages($this->lang->line('loginFirst'), 'error');
				redirect('home');
			}
		}
	}
	
	
	public function LoginUserDetails($field='username'){
		$user_id=$this->session->userdata('user_id');
		if($user_id > 0){
			return $this->session->userdata($field);
		}else{
			set_global_messages($this->lang->line('loginFirst'), 'error');
			redirect('home');
		}
	}
	
	
	function __invoke($param1)
    {
        echo __METHOD__ . PHP_EOL;
	}

}
/* AUTOLOAD Library as requested */
function __autoload($class)
{
    if(file_exists($class . '.php'))
	{
		@include($class . '.php');
	}	
    // Check to see whether the include declared the class
    if (!class_exists($class, false)) {
        trigger_error("Unable to load class: $class", E_USER_WARNING);
    }
}
