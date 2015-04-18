<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  This class is impliment for checking user type is fans and show 
*  spefice section for fans type user
* 
*  @access: public
*  @auther: lokendra meena
*  @package: library codiengniter
*  @year : 2015
*  
*/ 

class fans_authentication{
    
    
    public $message             =  "Yon can't access this section.";
    public $getClassName        =  NULL;
    public $getMethodName       =  NULL;
    public $fansPrivilege       =  array();
    public $userdata            =  array();
    private $CI;
    
    
    //---------------------------------------------------------------------
    
    public function fans_authentication(){
        
        $this->CI = &get_instance();
    }
    
    //---------------------------------------------------------------------
    
    public function fans_user_action(){
        
        //get current login user data
        $this->userdata = $this->CI->session->userdata;
        
        //get fans user not allow module  array
        $this->fansPrivilege = $this->CI->config->item('fans_privilege');

        //check user should be fans type
        if(!empty($this->userdata['fans']) && $this->userdata['fans']=="t"){
            
            $this->getClassName    =  $this->CI->router->fetch_class(); // get class name
            $this->getMethodName   =  $this->CI->router->fetch_method(); // get method name
            
            if(isset($this->fansPrivilege[$this->getClassName])){
                
                //condition entire module is not allow 
                if(empty($this->fansPrivilege[$this->getClassName])){
                    $this->_erroraction();
                }else{
                    // condition for specific module method not allow
                    if(in_array($this->getMethodName,$this->fansPrivilege[$this->getClassName])){
                        $this->_erroraction();
                    }
                }
            }
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
    *  @access: private
    *  @description: This method is use to error message and redirect  to home
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    private function _erroraction(){
        set_global_messages($this->message, 'error', true);
        redirect(base_url_lang('home'));
    }
    
}
