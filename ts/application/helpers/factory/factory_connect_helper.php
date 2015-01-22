<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_connect   {
	
	// to hold current language set by user 
	public   	$lang;
	// $view_data	= to hold any data related to view 
	public		$view_data	=	array('login_error_message'=>'');
    
    /*--- constructor function ---*/
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->lang 			= get_session_language();
        $this->init();		
    }
    
    public function init()
    {
         loginCheck();
        /*------------------------------------------*/			
        //Load required Model files
        $this->CI->load->model('connect_model');
        $this->CI->load->library('point_calculation');
        $this->CI->load->library('display_advert');
        $this->CI->load->library('incentive_invitation_system');
        $this->CI->load->model('common_model');
        $this->CI->lang->load('notification');
        $this->CI->lang->load('user_profile');
        $this->CI->load->model('album_model');
        $this->CI->load->library('email_template');
        /*--------------------------------------------------------
        * Comment: function for site is running in Iframe or not
        * -----------------------------------------------------*/
        check_site_reference();
        /*--------------------------------------------------------
        * Comment: function for check user login
        * -----------------------------------------------------*/			
    }
    
    /*
     * function to send email to invited user with a link
     * 
     * */
    
    public function send_invite_email_process($email,$user_id,$name)
    {
        $valid_email = $email;
        $sender      = get_username($user_id);
        $invite_type = encode("friend");
        $invite_id   = encode($user_id);	
        $link        = "<a href='".BASEURL."invitation/add_member/".$invite_id."/".$invite_type."' target='_blank'><br />";
        $link       .= $this->CI->lang->line('email_send_friend_invitation_accept');
        $link       .= "</a><br /><br />";
        $mail_head_data=array('to'=>$email);
        $mail_body_data=array('full_name'=>$sender,'link'=>$link,'sig1'=>'ljas;lkjdfas','to_name'=>$name);
        $is_sent = $this->CI->email_template->send_email('__send_invitation_link_to_friend__',$mail_head_data,$mail_body_data);
        if($is_sent)
            $is_invited=1;
        else $is_invited=0;
		
		$invitation_record_id = $this->CI->connect_model->save_address_book_info($name,$user_id,$email,$is_invited);
		if($is_invited){
			$check = $this->point_calculation->add_point($user_id,21,$invitation_record_id);
		}
        return $invitation_record_id;
    }
    
    
}
