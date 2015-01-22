<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_friend_list   {
	
	// to hold current language set by user 
	public   	$lang;
	// $view_data	= to hold any data related to view 
	public		$view_data	=	array('login_error_message'=>'');
	
			public function __construct()
			{
					$this->CI =& get_instance();
					
					$this->lang 			= get_session_language();
					$this->init();		
			}
			
			
        
        public function init(){    					
			
            //Load required Model files
			
            $this->CI->load->library('email');

			// settings for email
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->CI->email->initialize($config);	
			
			$this->CI->load->model('user_profile');
			$this->CI->load->helper('common');
			$this->CI->load->model('common_model');
			$this->CI->load->language('notification');
			$this->CI->load->library('point_calculation');
			$this->CI->load->language('user_profile');
			$this->CI->load->library('display_advert');
			$this->CI->load->language('email');
			$this->CI->load->library('parser');
            /*--------------------------------------------------------
            * Comment: function for site is running in Iframe or not
            * -----------------------------------------------------*/
            check_site_reference();
            /*--------------------------------------------------------
            * Comment: function for check user login
            * -----------------------------------------------------*/			
            loginCheck();
        }
    
    
    /**
     * factory function for normal friend list display
     **/
    public function friend_list_process(){
	
	
       if($this->view_data['is_visitor'] == 0)
		$all_friends = 1;
		else 
		$all_friends = 0;
		
        /*----------------Get data from memcache----------------*/
         $user_friends_data_cached = $this->CI->memcached_library->get('user_friends_data_cached_'.$this->view_data['user_id'].'_'.$all_friends);
        if(!$user_friends_data_cached){
		
            $user_friends = get_user_friends($this->view_data['user_id'],$all_friends);
            $this->view_data['user_friends'] = $user_friends;
            //display adverts
            $page="friend list";
            $result = $this->CI->display_advert->display_advert($page);
            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            /*----------------Set data from memcache----------------*/
            $this->CI->memcached_library->add('user_friends_data_cached_'.$this->view_data['user_id'].'_'.$all_friends,$this->view_data,$this->CI->config->item('friend_list_data_time'));
        }
        else
        {
		
            $this->view_data = $user_friends_data_cached;
        }
		$this->load_view('friends/user_friend_list',$this->view_data);      
    }
    
    
    
    /*
     * Factory method for grid view of friend list
     **/
	public function grid_process()
	{
		$user_id = $this->CI->session->userdata('user_user_id');   
        /*----------------Get data from memcache----------------*/
        $user_friends_data_cached = $this->CI->memcached_library->get('user_friends_data_cached_'.$user_id.'_1');
        if(!$user_friends_data_cached){
            $this->view_data['user_friends'] =  get_user_friends($user_id,1);
            //display adverts
            $page="friend list";
            $result = $this->CI->display_advert->display_advert($page);
            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            /*----------------Set data from memcache----------------*/
            $this->CI->memcached_library->add('user_friends_data_cached_'.$user_id.'_1',$this->view_data,$this->CI->config->item('friend_list_data_time'));
        }//memcache if
        else
        {
           $this->view_data = $user_friends_data_cached;     
        }
		$this->load_view('friends/user_friend_list_grid',$this->view_data);
    }

    
    /*
     * function to set relation
     * */
     
     public function set_relation_process()
     { 
        $relation_id = $this->CI->input->post('r_id');
		$friend_id 	= $this->CI->input->post('f_id');
		$user_id 	= $this->CI->session->userdata('user_user_id');
		if($user_id != "")
		{
			//echo $friend_id.",".$user_id.",".$relation_id;
			$mail_to_id =  send_friend_relation_request($friend_id,$user_id,$relation_id);
			if($mail_to_id != "")
			{
				$to_name = get_username($mail_to_id);
				$from_name1 = get_username($user_id);
				
				$from 		= $this->CI->lang->line('email_mail_from');
				$from_name 	= $this->CI->lang->line('email_mail_from_name');
				$to 		= get_email($mail_to_id);
				$subject    = $this->CI->lang->line('email_send_relation_invitation_subject');
				$hello		= $this->CI->lang->line('email_send_friend_invitation_hello')." ".$to_name;
				$message	= $this->CI->lang->line('email_send_relation_invitation_message')." ".$from_name1.". ";	
				$message   .= "<br />".$this->CI->lang->line('email_send_relation_invitation_message1')."<br />";	

				$signature1	= "<br />".$this->CI->lang->line('email_signature_line1');
				$signature2	= $this->CI->lang->line('email_signature_line2');
				
				// set values to email template
				$data = array(
					'hello_line'	=>	$hello,
					'email_body' 	=> 	$message,
					'email_signature_line1'	=>	$signature1,
					'email_signature_line2'	=>	$signature2	
				);

				// Get mail Template content to buffer
				ob_start();
				$email_message = '';
				echo $this->CI->parser->parse('email_template', $data, true);
                $this->CI->memcached_library->delete('user_friends_data_cached_'.$user_id.'_1');
                $this->CI->memcached_library->delete('user_friends_data_cached_'.$user_id.'_0');
                $this->CI->memcached_library->delete('user_friends_data_cached_'.$friend_id.'_1');
                $this->CI->memcached_library->delete('user_friends_data_cached_'.$friend_id.'_0');
				$email_message=ob_get_contents();
				ob_end_clean();

				$mailResponse 	=	$this->send_email($from,$from_name,$to,$subject,$email_message);
			}
			return true;
		}
		else
		{
			return false;
		}
    }
    
    /*
	* This function send email to user
	* @Input: email function parameters with message
	* @Output: True or False
	*/
	public function send_email($from,$from_name,$to,$subject,$message)
	{
		$this->CI->email->from($from,$from_name);
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);

		if($this->CI->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
     
    /*
     * Function to accept relationship request for friends
     * */
    public function accept_relation_request_process()
	{
		$relation_id = $this->CI->input->post('r_id');
		$friend_id 	 = $this->CI->input->post('f_id');
        $user_id 	 = $this->CI->session->userdata('user_user_id');
        $this->CI->memcached_library->delete('user_friends_data_cached_'.$user_id.'_1');
        $this->CI->memcached_library->delete('user_friends_data_cached_'.$user_id.'_0');
        $this->CI->memcached_library->delete('user_friends_data_cached_'.$friend_id.'_1');
        $this->CI->memcached_library->delete('user_friends_data_cached_'.$friend_id.'_0');
		return accept_friend_relation_request($friend_id,$relation_id);
	}
    
    /*
     * Function to load view
     * */
    public function load_view($view='friends/user_friend_list',$data){
        $this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
    }
			
}
