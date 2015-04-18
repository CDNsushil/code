<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_video   {
	
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
            $this->CI->load->helper('common');
            $this->CI->load->model('user_profile');
            $this->CI->load->model('video_model');
            $this->CI->load->model('wall/wall_model');
            $this->CI->load->language('user_profile');
            $this->CI->load->library('plupload');
            $this->CI->load->library('display_advert');
            $this->CI->load->language('template');
            $this->CI->load->language('video');
            $this->CI->load->helper('remote_request');
			
            /*--------------------------------------------------------
            * Comment: function for site is running in Iframe or not
            * -----------------------------------------------------*/
            check_site_reference();
            /*--------------------------------------------------------
            * Comment: function for check user login
            * -----------------------------------------------------*/			
            loginCheck();
        }
        
        /*
         * function to display list of videos
         * */
        function video_list_process()
        {
            $user_video_data_cached = $this->CI->memcached_library->get('user_video_data_cached_'.$this->view_data['user_id']);
            if($user_video_data_cached===FALSE){
                $this->view_data['video_data']		=	$this->CI->video_model->get_video_detail($this->view_data['user_id']);
                $this->CI->memcached_library->add('user_video_data_cached_'.$this->view_data['video_data'],$this->view_data,$this->CI->config->item('memcache_video_data_time'));
            }else{
                $this->view_data = $user_video_data_cached;
            }
            //display adverts
            $page="video";
            $result = $this->CI->display_advert->display_advert($page);
            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            $this->load_view('video/video',$this->view_data);      
        }
    
    /*
     * Fucntion to open popip of a video
     * */
        
    function video_popup_process()
    {
		$this->view_data['image_path']  = $this->CI->input->post('image_path');
		$this->view_data['post_id']	    = $this->CI->input->post('post_id');
		$this->view_data['post_type']	= $this->CI->input->post('post_type');
		$this->view_data['media_id']    = $this->CI->input->post('media_id');
		$this->view_data['post_user_id']= $this->CI->input->post('post_user_id');
		$this->view_data['image_name']	= $this->CI->input->post('image_name');
		$this->view_data['image_text']	= $this->CI->input->post('image_text');
		$this->view_data['video_image_url']	= $this->CI->input->post('video_image_url');
		/* for image tagging*/
		$this->view_data['loggedUserId']=$this->CI->session->userdata('user_user_id');	
		/* end for image tagging */
		// call set view count
		$this->set_view_count($this->view_data['media_id'], $this->view_data['post_type'], $this->view_data['post_user_id']);
		$tpl = $this->CI->load->view('video/video_popup',$this->view_data,true);
		echo json_encode(array('tpl'=>$tpl));	
	}
    
    /*
     * Function to save video
    */
    function save_video_procass()
	{
        $user_id = $this->CI->session->userdata('user_user_id');
		$location = get_location($user_id);	
		if(!$location) $location = "";	
		
		$image_name  = $this->CI->input->post('media_name');
		
		$status  = $this->CI->input->post('status');
		if(!isset($status)) $status = 1;
		
		// code to get video duration starts
		$video_complete_url = getimage('media', 2, $user_id, $image_name, '', '', '');
		$duration = '';
		
		/*ob_start();
		passthru("ffmpeg -i \"{$video_complete_url}\" 2>&1 | grep \"Duration\" | cut -d ' ' -f 4 | sed s/,//");
		$duration = ob_get_contents();
		ob_end_clean();
		
		if($duration!=''){
			$duration_parts = explode(":",$duration);
			if(count($duration_parts)>0){
				if($duration_parts[2] < 10) $duration_parts[2] = "0".(int)$duration_parts[2];
				else $duration_parts[2] = (int)$duration_parts[2];
			
				if($duration_parts[0] == "00")
				$duration = $duration_parts[1].":".$duration_parts[2];
				else
				$duration = $duration_parts[0].":".$duration_parts[1].":".(int)$duration_parts[2];
			}
		}
		// code to get video duration ends
		*/
		$media_arr = array(
					'media_name'    =>$image_name,
					'user_id'	    =>$user_id,
					'post_user_id'	=>$user_id,
					'media_text'    =>$this->CI->input->post('media_text'),
					'media_type'    =>$this->CI->input->post('media_type'),
					'location'	    =>$location,
					'action_category_id'	 => '1',
					'video_duration'	 => $duration,
					'status'	 => $status
			);
		$media_id = $this->CI->video_model->store_media($media_arr);
		
		// call helper function to send request on remote server for video conversion process
		process_video_conversion($image_name, $media_id);
	}
    
    
    /*
     * function to fetch view count of a video
     * */
     
    function set_view_count($post_record_id, $post_type, $user_id)
	{
		$ip_address = $_SERVER['REMOTE_ADDR'];
		//echo $post_record_id."#".$post_type."#".$user_id."#".$ip_address; die;
		$this->CI->video_model->set_view_count($post_record_id, $post_type, $user_id, $ip_address);
	}
     
     
    
    /*
     * Function to load view
     * */
    public function load_view($view='video/video',$data){
        $this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
    }
			
}
