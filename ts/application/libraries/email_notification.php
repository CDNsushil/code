<?php

class Email_notification {
	
	var $CI = "";
	public function __construct()
    {
        // Do something with $params
		$this->CI =& get_instance();
		//date_default_timezone_set('Asia/Calcutta');
		$this->CI->load->library('email');
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->CI->email->initialize($config);	
		$this->CI->load->library('parser');
		$this->CI->load->library('email_template');
		$this->CI->lang->load('email','english');
		$this->CI->load->model('email_notification_model');
		$this->CI->load->model('user_profile');
    }
	
	public function get_user_emails($user_id_to,$user_id_from,$activity,$report_comment=''){
		$get_user_data_to   = $this->CI->email_notification_model->get_user_email($user_id_to);
	   $email_to_user      = $get_user_data_to->email;
		$name_to_user	     = $get_user_data_to->firstname;
		
		$get_user_data_from = $this->CI->email_notification_model->get_user_email($user_id_from);
		$email_from_user    = $get_user_data_from->email;
		$name_from_user     = $get_user_data_from->firstname;
		$this->send_notification_mail($email_to_user,$email_from_user,$name_to_user,$name_from_user,$activity,$report_comment);
	}
	
	function send_notification_mail($email_to_user,$email_from_user,$name_to_user,$name_from_user,$activity,$report_comment){
		// send a friend request
		$from 		= $this->CI->lang->line('email_mail_from');
		$from_name 	= $this->CI->lang->line('email_mail_from_name');
		$to 		= $email_to_user;	
		$hello		= 'hello '.$name_to_user;
		if($activity=='report'){
			$to 		= $email_from_user;
			$hello		= 'hello '.$name_from_user;			
		}
		$subject    = 'Notification from chatching';
		
		$message	= 'email_notification .';
		
		if($activity == "comment"){
			$message	= $name_from_user.$this->CI->lang->line('comment_message');
		}
		if($activity == 'like'){
			$message	= $name_from_user.$this->CI->lang->line('like_message');
		}
		if($activity == 'post'){
			$message	= $name_from_user.$this->CI->lang->line('post_message');
		}
		if($activity == 'report'){
			$message = "This is to confirm your report on this comment.<br>";
			$message.= $report_comment."<br>";
			$message.= "Rest assured that this report would be evaluated.";		
		}
	
		$signature1	= "<br />".$this->CI->lang->line('email_signature_line1');
		$signature2	= $this->CI->lang->line('email_signature_line2');

		// set values to email template
		$data = array(
					'hello_line'	=>	$hello,
					'email_body' 	=> 	$message,
					'email_signature_line1'	=>	$signature1,
					'email_signature_line2'	=>	$signature2	
				);
		//print_r($data);
		// Get mail Template content to buffer
		ob_start();
			$email_message = '';
			echo $this->CI->parser->parse('email_template', $data, true);
			$email_message=ob_get_contents();
		ob_end_clean();

		$mailResponse 	=	$this->send_email($from,$from_name,$to,$subject,$email_message);
		return true;		
	}
	

	function send_question_mail($email){
		// send a friend request
		$from 		= $this->CI->lang->line('email_mail_from');
		$from_name 	= $this->CI->lang->line('email_mail_from_name');
		$to 		= $email;	
		$hello		= 'hello ';
		
		$subject    = 'Notification from chatching';
		
		$message	= 'email_notification .';
		
		
			$message = "This is to confirm your question on this comment.<br>";
			$message.= "Rest assured that this report would be evaluated.";		
		
	
		$signature1	= "<br />".$this->CI->lang->line('email_signature_line1');
		$signature2	= $this->CI->lang->line('email_signature_line2');

		// set values to email template
		$data = array(
					'hello_line'	=>	$hello,
					'email_body' 	=> 	$message,
					'email_signature_line1'	=>	$signature1,
					'email_signature_line2'	=>	$signature2	
				);
		//print_r($data);
		// Get mail Template content to buffer
		ob_start();
			$email_message = '';
			echo $this->CI->parser->parse('email_template', $data, true);
			$email_message=ob_get_contents();
		ob_end_clean();
		
		$mailResponse 	=	$this->send_email($from,$from_name,$to,$subject,$email_message);
		return true;		
	}

	
	/*
	* @Input: email function parameters with message
	* @Output: True or False
	* @access	public
	* Comment: This function send email to user
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
    
    
    /**
	* function to send email notification for likes and dislikes
	**/
    public function like_email_notification($post_user_id,$like_by,$like_val,$post_type)
    { 
        /*Check for like or Dislike start*/
        if($like_val == 1){
            $state = 'like';
            $like_mail_key = '__like_deslike_notification__';
        }
        else{
            $state = 'dislike';
            $like_mail_key = '__like_deslike_notification__';
        }
        /*Check for like or Dislike end*/

        /*----------------------Check for notification type ID Start------------------------*/

        /* Status like dislike section*/
        if($like_val == 1 && $post_type==2)
        {
            $type  = 'status';
            $notification_type_id = 22;
        }
        else if($like_val== 0 && $post_type==2)
        {
            $type  = 'status';
            $notification_type_id = 23;
        }
        
        /* Comment like dislike section*/
        else if($like_val== 1 && $post_type==5)
        {
            $type  ='comment';
            $notification_type_id = 22;
        }   
        else if($like_val== 0 && $post_type==5)
        {
            $type  = 'comment';
            $notification_type_id = 23;
        }

        /* Video like dislike section*/
        else if($like_val== 1 && $post_type==4)
        {
            $type  = 'Video';
            $notification_type_id = 68;
        }
        else if($like_val== 0 && $post_type==4)
        {
            $type  = 'Video';
            $notification_type_id = 68;
        }
        
        /* Album like dislike section*/
        else if($like_val== 1 && $post_type==7)
        {
            $type  = 'Album';
            $notification_type_id = 40;
        }
        else if($like_val== 0 && $post_type==7)
        {
            $type  = 'Album';
            $notification_type_id = 40;
        }

        /* Image like dislike section*/
        else if($like_val== 1 && $post_type==1)
        {
            $type  = 'Image';
            $notification_type_id = 40;
        }    
        else if($like_val== 0 && $post_type==1)
        {
            $type  = 'Image';
            $notification_type_id = 40;
        }
        /*----------------------Check for notification type ID End------------------------*/

        /*Check if user checked for the notifiaction type in the profile setting*/
        $notification_post_user = check_notification($post_user_id,$notification_type_id);
        if(!empty($notification_post_user))
        {
            if($notification_post_user[0]->email==1)
            { 
                $post_user_email 		= get_email($post_user_id);
                $like_by_name           = get_username($like_by);
                $post_user_name         = get_username($post_user_id);
                $mail_head_data         = array('to'=>$post_user_email);
                /* Set variables for mail body parameters */
                $mail_body_data=array(
                    'host_name' => $post_user_name,
                    'full_name' => $like_by_name,
                    'state'     => $state,
                    'type'      => $type
                );
                $this->CI->email_template->send_email($like_mail_key,$mail_head_data,$mail_body_data);			
            }
            if($notification_post_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
                /*--sms code here--*/	
            }
        }
    }
    
    /**
    * function to send email notification for comment
    **/
    function send_comment_notification($post_user_id,$user_id,$post_type_id)
    {
        $email_key = '__comment_on_post_notification__';
        if($post_type_id==1){
            $notification_type_id = 32;
            $post_type = 'Photo';
        }
        else if($post_type_id==4){
            $notification_type_id = 65;
            $post_type = 'Video';
        }
        else{
            $notification_type_id = 20;
            $post_type = 'Post';
        }
       
        $notification_post_user = check_notification($post_user_id,$notification_type_id);
        if(!empty($notification_post_user)){
            if($notification_post_user[0]->email==1){
                $post_user_email = get_email($post_user_id);
                $comment_by_name = get_username($user_id); 
                $post_user_name  = get_username($post_user_id);
                $mail_head_data1 = array('to'=>$post_user_email);
                $mail_body_data=array('host_name'=>$post_user_name,'full_name'=>$comment_by_name,'post_type'=>$post_type);
                $this->CI->email_template->send_email($email_key,$mail_head_data1,$mail_body_data);			
            }
            if($notification_post_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
            /*--sms code here--*/	
            }
        }
        /*--------------notification check----------------*/    
    }

    /*-------------------------
     * send notification for when user tagged in status text, image or in the comment tag
    ---------------------------*/    
    public function send_tagging_notification($from_user_id='',$to_user_id='',$post_user_id='',$post_type_id='')
    {
        $to_email 		= get_email($to_user_id);
        $to_name 		= get_username($to_user_id);
        $sender  		= get_username($from_user_id);
        $mail_head_data	= array('to'=>$to_email);
        /*-------------For image tagging---------------*/
        if($post_type_id == 1)
        {
            $notification_type_id = 34;
            $mail_body_data=array('full_name'=>$sender,'send_to_name'=>$to_name);
            $email_key = "__notification_to_tagged_user_in_pic__";
        }
        /*-------------For status tagging---------------*/
        else if($post_type_id == 2)
        {
            $notification_type_id = 61;
            $mail_body_data	= array('full_name'=>$sender,'host_name'=>$to_name);
            $email_key = "__notification_to_tagged_user_on_profile__";
        }
        /*-------------For comment tagging---------------*/
        else if($post_type_id == 5)
        {
            $notification_type_id = 36;
            $mail_body_data       = array('host_name'=>$sender,'full_name'=>$to_name,'post_user'=>$to_name); 
            $email_key = "__comment_on_post_notification__";
        }
        /*--------------notification check----------------*/
        $notification_to_user = check_notification($to_user_id,$notification_type_id);
        if(!empty($notification_to_user))
        {
            if($notification_to_user[0]->email==1)/*--1 for check user had activated the email notification--*/
            {
                // Send email to person whome friend request accepted
                $this->CI->email_template->send_email($email_key,$mail_head_data,$mail_body_data);				
            }
            if($notification_to_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
            /*--sms code here--*/	
            }
        }

    }
    
    function email_notification_to_noncc_memeber($user_id,$action='upload_media',$media_type='photo'){
        $sender = get_username($user_id);
        if($action=='upload_media'){
            $email_key = "__upload_media_notification_nonfriend__";
            $mail_body_data	= array('full_name'=>$sender,'media'=>$media_type);
        }else if($action=='commented_on_post'){
            $email_key = "__commented_on_post_notification_nonfriend__";
            $mail_body_data	= array('full_name'=>$sender);
        }else if($action=='like_post'){
            $email_key = "__like_a_post_notification_nonfriend__";
            $mail_body_data	= array('full_name'=>$sender);
        }
        else if($action=='status_update'){
            $email_key = "__updated_status_notification_nonfriend__";
            $mail_body_data	= array('full_name'=>$sender);
        }
        $non_CC = $this->CI->user_profile->get_non_registered_friends($user_id);
        if($non_CC!=FALSE && count($non_CC)>0){
            foreach($non_CC as $non){
               $non_friend_email = $non->email_to;
               $mail_head_data = array('to'=>$non_friend_email);
               $this->CI->email_template->send_email($email_key,$mail_head_data,$mail_body_data);
            }
        }
    }
    
}// end class

/* End of file email_notification.php */
