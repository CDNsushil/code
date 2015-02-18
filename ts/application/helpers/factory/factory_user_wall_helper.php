<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_user_wall   {
	
	// to hold current language set by user 
	//public   	$lang;
	// $view_data	= to hold any data related to view 
	public		$view_data	=	array('login_error_message'=>'');
	
	
	
	
			public function __construct()
			{
					$this->CI =& get_instance();
					 
					//$this->lang 			= get_session_language();
					$this->init();		
			}
			
			
			
			public function init(){
					// session start is used for commet chat
					session_start();
					/*------------------------------------------*/			
					$this->CI->load->library('facebook_library');
					$this->CI->load->library('point_calculation');
					$this->CI->load->library('display_advert');
					$this->CI->load->library('recent_activity');
					$this->CI->load->library('email_template');

					$this->CI->load->helper('common');
					$this->CI->load->helper('facebook_helper');
					$this->CI->load->helper('page');

					$this->CI->load->model('wall/wall_model');
					$this->CI->load->model('facebook_app/facebook_app_model');
					$this->CI->load->model('privacy_setting/privacy_setting_model');
					$this->CI->load->model('user_profile');
					/*--------------------------------------------------------
					* Comment: function for site is running in Iframe or not
					* -----------------------------------------------------*/
					check_site_reference();
					/*--------------------------------------------------------
					* Comment: function for check user login
					* -----------------------------------------------------*/			
					loginCheck();	
					$this->CI->load->language('wall');		
			}
			
			public function news_feed_process() // news feed factory
			{
                $news_feed_cached = $this->CI->memcached_library->get('news_feed_cached_'.$this->view_data['user_id']);//get data from memcache 
                if(!$news_feed_cached){
					$this->view_data['user_profile']=$this->CI->user_profile->get_profile();
					$news_feeds = $this->CI->recent_activity->get_feeds($this->view_data['user_id']);
					echo $this->view_data['user_profile']->facebook_id;die;
					try{
						
						if(isset($this->view_data['user_profile']->facebook_id)){							
								$fb_data =get_data_using_curl('https://graph.facebook.com/me/home?access_token='.$this->session->userdata('fb_access_token'));
								$facebook_feeds = json_decode($fb_data);
								$facebook_feeds =(array)$facebook_feeds->data;							
						}
						
					}catch(Exception $e){
						echo "Facebook not responding";
						$facebook_feeds=array();	
					}
						
					$merge_data = merge_facebook_chatching_feeds($news_feeds,$facebook_feeds);
					//$merge_data =arrange_post_by_freq($merge_data);

					$this->view_data['news_feeds'] = $merge_data;
					$post_id_comma_sap = '';
					$post_type_id_comma_sap = '';
					foreach($news_feeds as $feed){
						$post_id_comma_sap.=$feed['post_record_id'].',';
						$post_type_id_comma_sap.=$feed['post_type_id'].',';
					}
					$like_deslike_arr = get_likes_deslikes($post_id_comma_sap,$this->view_data['user_id'],$post_type_id_comma_sap);
					if(!empty($like_deslike_arr)){
						$this->view_data['likes_deslikes_arr'] = $like_deslike_arr;
					}

					//display adverts
					$page="activity stream";
					$result = $this->CI->display_advert->display_advert($page);
					if($result!=false)
					{
					$this->view_data['display_advert'] = $result;
					}
					//get user loops
					//$loop_list						= $this->CI->privacy_setting_model->get_sublist();
					//$this->view_data['loop_list']	= $loop_list;
                    /*
                     * add data into memcache if not exists 
                     */
                    $this->CI->memcached_library->add('news_feed_cached_'.$this->view_data['user_id'],$this->view_data,$this->CI->config->item('memcache_news_feed_data_time')); 
                }else{
                     $this->view_data = $news_feed_cached;   //assign memcached data to view variable
                }
				 $this->load_view('news_feed',$this->view_data);
			}
		    
		    public function get_wall_process()
			{
				
                $user_wall_cached = $this->CI->memcached_library->get('user_wall_cached_'.$this->view_data['user_id']);//get data from memcache
                if(!$user_wall_cached){
					$this->view_data['user_profile']=$this->CI->user_profile->get_profile();
					$news_feeds = $this->CI->recent_activity->get_wall($this->view_data['user_id']);
					try{
						if(isset($this->view_data['user_profile']->facebook_id)){							
								$fb_data =get_data_using_curl('https://graph.facebook.com/me/feed?access_token='.$this->session->userdata('fb_access_token'));
								$facebook_feeds = json_decode($fb_data);
								$facebook_feeds =(array)$facebook_feeds->data;							
						}
					}catch(Exception $e){
						$facebook_feeds=array();	
					}
					$merge_data = merge_facebook_chatching_feeds($news_feeds,$facebook_feeds);
					$this->view_data['news_feeds'] = $merge_data;
					//display adverts
					$page="wall";
					$result = $this->CI->display_advert->display_advert($page);
					$post_id_comma_sap='';
					$post_type_id_comma_sap = '';
					foreach($news_feeds as $feed){
						$post_id_comma_sap.=$feed['post_record_id'].',';
						$post_type_id_comma_sap.=$feed['post_type_id'].',';
					}
					$like_deslike_arr = get_likes_deslikes($post_id_comma_sap,$this->view_data['user_id'],$post_type_id_comma_sap);
					if(!empty($like_deslike_arr)){
						$this->view_data['likes_deslikes_arr'] = $like_deslike_arr;
					}
					if($result!=false)
					{
						$this->view_data['display_advert'] = $result;
					}
                    $this->CI->memcached_library->add('user_wall_cached_'.$this->view_data['user_id'],$this->view_data,$this->CI->config->item('memcache_news_feed_data_time')); 
                }else{
                     $this->view_data = $user_wall_cached;   //assign memcached data to view variable
                }

					$email 		= get_email(decode($this->CI->uri->segment(3)));
					$viewer_id  = $this->CI->session->userdata('user_user_id');
					$sender     = get_username($viewer_id);
                    $host_name  = get_username(decode($this->CI->uri->segment(3)));
					$mail_head_data=array('to'=>$email);
					$mail_body_data=array('full_name'=>$sender,'host_name'=>$host_name);

					/*--------------notification check----------------*/
					/*$notification_type_id = 18;
					$notification_to_user = check_notification($this->CI->uri->segment(3),$notification_type_id);
					if(!empty($notification_to_user)){ 
						if($notification_to_user[0]->email==1){   /*--1 for check user had activated the email notification--*/
						// Send email to person whome friend request accepted
                      /*  if($this->CI->uri->segment(3)){
                            $this->CI->email_template->send_email('__profile_view_notification__',$mail_head_data,$mail_body_data);				
                        }
					}
					if($notification_to_user[0]->sms==1){*/   /*--1 for check user had activated the sms notification--*/
					/*--sms code here--*/	
					/*}
					}*/
					$this->load_view('get_wall',$this->view_data);			
			}
			 
            public function ajax_feed_process()
            {
                $page_num = $this->CI->input->post('start'); 
                $page_type = $this->CI->input->post('page_type'); 
				//$facebook_feeds =array();
                $user_id = decode($this->CI->input->post('user_id'));
                if($page_type=="wall"){
                    
                    $news_feeds = $this->CI->recent_activity->get_wall($user_id,$page_num);    
                }else{
                    $news_feeds = $this->CI->recent_activity->get_feeds($user_id,$page_num);
                }
                                                
                $this->view_data['news_feeds'] = $news_feeds;
                $this->view_data['user_id']	= $user_id;
                if(count($news_feeds)>0)
                    $status=1;
                else $status=0;
                $tpl = $this->load->view('ajax_feeds',$this->view_data,true);			
                echo json_encode(array('tpl'=>$tpl,'status'=>$status));
            } 
			
            public function ajax_timeline_process()
            {
                $page_num       = $this->CI->input->post('start'); 
                $timeline_year  = $this->CI->input->post('timeline_year'); 
                $timeline_month = $this->CI->input->post('timeline_month'); 
                $page_type      = $this->CI->input->post('page_type'); 
                $user_loop      = $this->CI->input->post('user_loop'); 
                $user_id        = decode($this->CI->input->post('user_id'));
                $logged_user_id = $this->CI->session->userdata('user_user_id');
                //get feed

                
                /*----------------Fetching news feed for page section----------------*/
                if($page_type=="page")
                {
                    $news_feeds = $this->ajax_page_feed($logged_user_id,$user_id,$page_num);
                    $view = 'ajax_page_feed';
                }

                /*----------------Fetching news feed for user wall and activity stream ----------------*/
                else
                {
                    $news_feeds = $this->CI->recent_activity->get_wall($user_id,$page_num,'',$timeline_year,$timeline_month,$page_type,$user_loop);  
                   // print_r($news_feeds);die;
                    $view = 'ajax_feeds';
                    $this->view_data['user_id']	= $user_id;
                }
				$this->view_data['news_feeds'] = $news_feeds;
                if(count($news_feeds)>0)
                    $status=1;
                else $status=0;
                $tpl = $this->CI->load->view($view,$this->view_data,true);			
                echo json_encode(array('tpl'=>$tpl,'status'=>$status));    
            }
            
            /*
             * process news_feed for the page section
             **/

            private function ajax_page_feed($logged_user_id,$page_id,$page_num){
                $this->CI->load->model('page_model');
                $status_val = $this->CI->page_model->get_subscribe_status($logged_user_id,$page_id);
                $this->view_data['subscribe_text']		=	 $status_val[0]; 
                $this->view_data['subscribe_val']		=	 $status_val[1]; 
                $this->view_data['page_id'] = $page_id;
                $this->view_data['action_category_id'] = $this->CI->config->item('__celebrity_page__'); // 3 for celebrity page
                $this->view_data['user_id'] = $logged_user_id;
                $news_feeds = $this->CI->recent_activity->get_page_feeds($page_id,'',$page_num);
                return $news_feeds;
            }
            
            
			public function load_view($view='get_wall',$data){
				$this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
			}
}
