<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_comment   {
	
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
					/*------------------------------------------*/			
					$this->CI->load->model('comment_model');
                    $this->CI->load->model('wall/wall_model');
                    $this->CI->load->library('recent_activity');
                    $this->CI->load->library('notification');
                    $this->CI->load->library('point_calculation');
                    $this->CI->load->language('wall');
                    $this->CI->load->library('email_template');
                    $this->CI->load->library('email_notification');
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
         * @Input :post_type,post_id,view_type
         * @Output: Returns user comment_form
         * @Access: Public
         * Comment: function to load comment form for various sections 
        */
        public function comment_view_process()
        {
			$post_id        	 = $this->post_id;
            $post_type_id  		 = $this->post_type_id;
            $post_user_id 	     = $this->post_user_id;
            $comment_count 		 = $this->comment_count;
            $comment_data_cached = '';
            $comment_data_cached = $this->CI->memcached_library->get('comment_data_cached_'.$post_id.'_'.$post_type_id);
            if(!$comment_data_cached){
				//$comments = $this->CI->comment_model->get_comment($post_id,$post_type_id,$limit=6,$start=0);
                //print_r($comments);die;
                //$comment_data     = ($comment_count !=0?$this->CI->comment_model->get_comment($post_id,$post_type_id,$limit=6,$start=0):array());
                $comment_data     = $this->CI->comment_model->get_comment($post_id,$post_type_id,$limit=6,$start=0);
				$this->view_data['comments'] = $comment_data;
				/*---------like deslike array on all comments----------*/
					$comment_id_comma_sap = '';
					foreach($comment_data as $comment){
						$comment_id_comma_sap.=$comment->comment_id.',';
					}
					$like_deslike_arr = get_likes_deslikes($comment_id_comma_sap,$this->CI->session->userdata('user_user_id'),5);
					if(!empty($like_deslike_arr)){
						$this->view_data['likes_deslikes_arr'] = $like_deslike_arr;
					}
                /*-------------------*/
                
                $this->view_data['comment_count'] = ($comment_count !=0?$this->CI->comment_model->get_comment_count($post_id,$post_type_id):$comment_count);
                $this->view_data['post_id']       = $post_id;
                $this->view_data['post_type_id']  = $post_type_id;
                $this->view_data['post_user_id']  = $post_user_id;
                $this->CI->memcached_library->add('comment_data_cached_'.$post_id.'_'.$post_type_id,$this->view_data,$this->CI->config->item('memcache_user_comment_data_time'));
            }else{
                $this->view_data = $comment_data_cached;    
            }
        }
    		
    /**
	 * @Input :Null
	 * @Output: Returns user comment
	 * @Access: Public
	 * Comment: function to store users comments 
    */
	function store_comment_process()
    {
        $post_id 		= $this->post_id;
        $post_type_id 	= $this->post_type_id;
        $comment 		= $this->comment;
        $post_user_id   = $this->post_user_id;
        $image 			= $this->image_comment;
        $user_id        = $this->user_id;
        $action_category_id = $this->action_category_id;
        $action_category_record_id = $this->action_category_record_id;
        $comment_arr = array('user_id'=>$user_id,'comment'=>$comment,'post_id'=>$post_id,'post_type_id'=>$post_type_id);
        $success = $this->CI->comment_model->store_comment($comment_arr);
        if($success > 0)
        {
            /*---   award point on recieving comment---*/
            $_activity_comment_ = $this->CI->config->item('_activity_comment_');
            $_activity_recieve_comment_ = $this->CI->config->item('_activity_recieve_comment_');
            
            if($post_user_id != $user_id)
            {
				if($post_type_id == 7)
				{
					//for task #2549 point awarded to sender
					$this->CI->point_calculation->add_point($user_id,$this->CI->config->item('_activity_post_comment_album_'),$success,$post_user_id);
				}
				if($post_type_id == 1)
				{
					 $last_commented_user_id  =  $this->CI->comment_model->get_last_comment($post_id); 	// get last comment posted user ID of this post
	
					 if($last_commented_user_id && ($last_commented_user_id != $user_id))
					 {
						 // task no. 1908
						 $this->CI->point_calculation->add_point($last_commented_user_id,$this->CI->config->item('_activity_post_comment_album_photo_'),$success,$user_id);
					 }
				}
				if($post_type_id == 2)
				{
					// for task #2816
					$this->CI->point_calculation->add_point($post_user_id,$_activity_recieve_comment_,$success,$user_id);
				}
			}
			else
			{
				/*---   award point on comment---*/
				//$this->CI->point_calculation->add_point($user_id,$_activity_comment_,$success,$user_id);
			}
            $com_arr['comment_id'] = $success;
            $comment = $this->CI->comment_model->get_single_comment($com_arr);
            $this->view_data['post_id'] = $post_id;
            $this->view_data['post_type_id'] = $post_type_id;
            $this->view_data['com']	 = $comment->row();
            $comment_count = $this->CI->comment_model->get_comment_count($post_id,$post_type_id);
            $this->CI->memcached_library->delete('image_popup_cached_'.$post_id);
            $tpl2 = '';
            if($image==1 || $image==2 || $image==3){
                $tpl2 = $this->CI->load->view('comment_append',$this->view_data,true);
                $tpl  = $this->CI->load->view('image_comment_append',$this->view_data,true);
            }
            else
                $tpl=$this->CI->load->view('comment_append',$this->view_data,true);
             /*----------------- ajax response --------------------*/
            echo json_encode(array('comment_count' => $comment_count,'tpl'=>$tpl,'tpl2' => $tpl2));

            /*---------calling all notification and activity library functions--------*/
            $this->notification_activity_process($user_id,$post_user_id,$post_type_id,$post_id,$action_category_record_id,$action_category_id,$success);
        }
    }
            
    
     /*---------function to call notification and activity library functions--------*/ 
     function notification_activity_process($user_id,$post_user_id,$post_type_id,$post_id,$action_category_record_id,$action_category_id,$success)
     {
        /*-----------------delete comments old comments cache from memcached--------------------*/
        $this->CI->memcached_library->delete('comment_data_cached_'.$post_id.'_'.$post_type_id);

        /**for Recent activity to show news feeds and wall sections**/
        $this->CI->recent_activity->add_recent_activity($user_id,5,$success,'',$action_category_id,$action_category_record_id);
        //$this->CI->point_calculation->add_point($user_id,5,$success,$post_user_id);
        /**---------------------------------------------------------
         * Comment:for point calculation for receive comment on post
         * activity type  20 : receive comment on post
         * ---------------------------------------------------------**/							
        //$this->CI->point_calculation->add_point($post_user_id,20,$success,$user_id); 

        /*if Post user and Comment user is different then Email notification sent to Post user Email Address*/
        if($post_user_id != $user_id)
            $this->CI->email_notification->send_comment_notification($post_user_id,$user_id,$post_type_id);

        /*------------------send notification for tagging activity start---------------------*/
        $tagged_users_id = $this->CI->comment_model->get_tagged_users($post_id);
        foreach($tagged_users_id as $tagged_users)
        {
            $this->CI->email_notification->send_tagging_notification($user_id,$tagged_users->tagged_user_id,$post_user_id,5);
        }

        /*------------------send notification for tagging activity end---------------------*/
        /*for notification and ticker*/
        $this->CI->notification->send_notification(4,$user_id,$post_user_id,$post_type_id,$post_id,$action_category_record_id,$action_category_id);
     }

}
