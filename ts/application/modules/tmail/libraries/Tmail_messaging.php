<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Tmail Messaging Library for CodeIgniter
*
* Author: Anoop Singh
*		  anoop.immortal@gmail.com
* Description:  CI library for linking to application's existing user table and creating basis of an internal messaging system
*
*/

class Tmail_messaging
{
	public function __construct()
	{
		$this->ci =& get_instance();
       

        $this->ci->load->model('model_tmail');
        $this->ci->load->helper('language');
        $this->ci->lang->load('tmail');


    }
	function get_User($user_id){
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_MSG_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_MSG_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}

        if ($message = $this->ci->model_tmail->get_User($user_id))
        {
            return $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS), 'retval'=>$message);
        }
        return $status;
	
	
	}
    /*
        function get_message() - will return a single message, including the status for specified user.
        @parameters - $msg_id REQUIRED, $user_id REQUIRED
    */

    function get_message($msg_id, $user_id)
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($msg_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_MSG_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_MSG_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}

        if ($message = $this->ci->model_tmail->get_message($msg_id, $user_id))
        {
            return $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS), 'retval'=>$message);
        }
        return $status;
    }


    /*
        function get_full_thread() - will return a entire thread, including the status for specified user.

        @parameters - $thread_id REQUIRED, $user_id REQUIRED, $order_by OPTIONAL
                    - $full_thread - if true, user will also see messages from thread posted BEFORE user became participant
    */

    function get_full_thread($messageId, $user_id, $full_thread=false, $order_by='asc')
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($messageId)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_THREAD_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_THREAD_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}

        if ($message = $this->ci->model_tmail->get_full_thread($messageId, $user_id, $full_thread, $order_by))
        {
            return $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS), 'retval'=>$message);
        }
        return $status;
    }

    /*
        function get_all_threads() - will return all threads for user, including the status for specified user.

        @parameters - $user_id REQUIRED, $order_by OPTIONAL
                    - $full_thread - if true, user will also see messages from thread posted BEFORE user became participant
    */

    function get_all_threads($user_id,  $full_thread=false, $order_by='asc')
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}

        if ($message = $this->ci->model_tmail->get_all_threads($user_id,  $full_thread, $order_by))
        {
            return $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS), 'retval'=>$message);
        }
        return $status;
    }


    /*
        function update_message_status() - will change status on message for particular user

        @parameters - $msg_id REQUIRED, $user_id REQUIRED, $status_id REQUIRED
                    - $status_id should come from config/Tmail.php list of constants
    */
    function update_message_status($msg_id, $user_id, $status_id  )
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($msg_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_MSG_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_MSG_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}
        if (empty($status_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_STATUS_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_STATUS_ID));return $status;}

        if ($this->ci->model_tmail->update_message_status($msg_id, $user_id, $status_id  ))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_STATUS_UPDATE));
        }
        return $status;
    }

    /*
        function add_participant() - adds user to existing thread

        @parameters - $thread_id REQUIRED, $user_id REQUIRED
    */
    function add_participant($thread_id, $user_id)
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($thread_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_THREAD_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_THREAD_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}

        if (!$this->ci->model_tmail->valid_new_participant($thread_id, $user_id))
        {
            $status = array('err'=>1, 'code'=>1, 'msg'=>lang('tmail_'.MSG_ERR_PARTICIPANT_EXISTS));
            return $status;
        }

        if (!$this->ci->model_tmail->application_user($user_id))
        {
            $status = array('err'=>1, 'code'=>1, 'msg'=>lang('tmail_'.MSG_ERR_PARTICIPANT_NONSYSTEM));
            return $status;       
        }

        if ($this->ci->model_tmail->add_participant($thread_id, $user_id ))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_PARTICIPANT_ADDED));
        }
        return $status;
    }

    /*
        function remove_participant() - removes user from existing thread

        @parameters - $thread_id REQUIRED, $user_id REQUIRED
    */
    function remove_participant($thread_id, $user_id)
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($thread_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_THREAD_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_THREAD_ID));return $status;}
        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}
        
        if ($this->ci->model_tmail->remove_participant($thread_id, $user_id ))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_PARTICIPANT_REMOVED));
        }
        return $status;    
    }

    /*
        function send_new_message() - sends new internal message. This function will create a new thread

        @parameters - $sender_id REQUIRED, $recipients REQUIRED
                    - $recipients may be either a single integer or an array of integers, representing user_ids
    */
    function send_new_message($sender_id, $recipients, $subject='', $body='', $priority=PRIORITY_NORMAL,$type=1,$fileId=0,$elementId=0){
       
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

       // if (empty($sender_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_SENDER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_SENDER_ID));return $status;}
       // if (empty($recipients)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_RECIPIENTS, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_RECIPIENTS));return $status;}

        if ($this->ci->model_tmail->send_new_message($sender_id, $recipients, $subject, $body, $priority,$type,$fileId,$elementId))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_MESSAGE_SENT)); 
        }
        return $status;
    }

    /*
        function reply_to_message() - replies to internal message. This function will NOT create a new thread or participant list

        @parameters - $sender_id REQUIRED, $msg_id REQUIRED
    */
    function reply_to_message($msg_id, $sender_id, $subject='', $body='', $priority=PRIORITY_NORMAL)
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($sender_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_SENDER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_SENDER_ID));return $status;}
        if (empty($msg_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_MSG_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_MSG_ID));return $status;}

        if ($this->ci->model_tmail->reply_to_message($msg_id, $sender_id,  $body, $priority))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_MESSAGE_SENT)); 
        }
        return $status;
    }

    /*
        function get_participant_list() - returns list of participants on given thread. If sender_id set, sender_id will be left off list

        @parameters - $sender_id REQUIRED, $thread_id REQUIRED
    */
    function get_participant_list($thread_id, $sender_id=0)
    {
        $status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($thread_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_THREAD_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_THREAD_ID));return $status;}
        
        if ($participants = $this->ci->model_tmail-> get_participant_list($thread_id, $sender_id))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'retval'=>$participants); 
        }
        return $status;
    }

	function get_user_Inbox($user_id,$offset,$limit)
	{
		
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($user_id)){
			$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));
			return $status;
		}
        
        if ($user_id = $this->ci->model_tmail->get_user_Inbox($user_id,$offset,$limit))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'retval'=>$user_id); 
        }
        return $status;
	}
	
	function get_user_Inbox_Count($user_id)
	{
		
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL),'inbox_count'=>'0');

        if (empty($user_id)){
			$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID),'inbox_count'=>'0');
			return $status;
		}
        
        if ($user_id = $this->ci->model_tmail->get_user_Inbox_Count($user_id))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'inbox_count'=>$user_id); 
        }
        return $status;
	}
	
	
	function get_user_trash($user_id,$offset,$limit)
	{
		
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($user_id)){
			$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));
			return $status;
		}
        
        if ($user_id = $this->ci->model_tmail->get_user_trash($user_id,$offset,$limit))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'retval'=>$user_id); 
        }
        return $status;
	}
	
	
	function get_user_trash_count($user_id)
	{
		
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL),'trash_count'=>'0');

        if (empty($user_id)){
			$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));
			return $status;
		}
        
        if ($user_id = $this->ci->model_tmail->get_user_trash_count($user_id))
        {
            $status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'trash_count'=>$user_id); 
        }
        return $status;
	}
	
	function get_user_sent($user_id,$offset,$limit)
	{
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL));

        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID));return $status;}
        
        if ($user_id = $this->ci->model_tmail->get_user_sent($user_id,$offset,$limit))
        {
			$status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'retval'=>$user_id); 
        }
        
        return $status;
	}
	
	
	function get_user_sent_count($user_id)
	{
		$status = array('err'=>1, 'code'=>MSG_ERR_GENERAL, 'msg'=>lang('tmail_'.MSG_ERR_GENERAL),'sent_count'=>'0');

        if (empty($user_id)){$status = array('err'=>1, 'code'=>MSG_ERR_INVALID_USER_ID, 'msg'=>lang('tmail_'.MSG_ERR_INVALID_USER_ID),'sent_count'=>'0');return $status;}
        
        if ($user_id = $this->ci->model_tmail->get_user_sent_count($user_id))
        {
			$status = array('err'=>0, 'code'=>MSG_SUCCESS, 'msg'=>lang('tmail_'.MSG_SUCCESS)  ,'sent_count'=>$user_id); 
        }
        
        return $status;
	}
	
	
	
	
}
