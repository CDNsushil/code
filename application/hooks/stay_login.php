<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  This class is impliment for Stay login with respect to ip 
*  spefice section for stay login  user
* 
*  @access: public
*  @auther: Amit Neema
*  @package: library codiengniter
*  @year : 2015
*  
*/ 

class stay_login{
    
    
    public $message             =  "Yon can't access this section.";
    public $getClassName        =  NULL;
    public $getMethodName       =  NULL;
    public $fansPrivilege       =  array();
    public $userdata            =  array();
    private $CI;
    
    
    //---------------------------------------------------------------------
    
    public function stay_login(){
        
        $this->CI = &get_instance();
    }
    
    // ---------------------------------------------- 
    /* 
*  @access: public
*  @auther: Amit Neema
*  @function : user_ stay_login For applying browser dependent session
*  @year : 2015
    */
    public function user_stay_login()
    {
		$this->CI->load->library('auth/tank_auth');
		$this->CI->load->library('user_agent');
		$this->CI->load->database();
		$browser_name =  $this->CI->agent->browser();
		
		// get Ip system address
		 $system_ipaddress = $_SERVER['REMOTE_ADDR'];
		
		
		$where          =   array('system_ip'=>$system_ipaddress);
		$getUserData   =   $this->CI->model_common->getDataFromTabel('UserAuth', 'email,system_ip,browser_name', $where, '', 'tdsUid', 'DESC', 1);
		$browserArray = array();
		if(!empty($getUserData)){
			$getUserData = $getUserData['0'];
			$browserArray = (array)json_decode($getUserData->browser_name);
			if(in_array($browser_name,$browserArray)){
				$emailId = $getUserData->email;
				
				$this->CI->tank_auth->loginWithFacebook($emailId);
				//redirect(base_url_lang('home'));
			}
		}
	}   
    
}
