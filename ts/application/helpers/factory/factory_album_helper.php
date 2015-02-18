<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_album   {
	
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
		$this->CI->load->model('album_model');
		$this->CI->load->model('page_model');
		$this->CI->load->model('wall/wall_model');
		$this->CI->load->language('user_profile');
		$this->CI->load->language('wall');
		$this->CI->load->language('message');
		$this->CI->load->language('album');
		$this->CI->load->library('point_calculation');
		$this->CI->load->library('plupload');
		$this->CI->load->library('display_advert');
		$this->CI->load->model('message/message_model');
		$this->CI->load->helper('page');
        /*--------------------------------------------------------
        * Comment: function for site is running in Iframe or not
        * -----------------------------------------------------*/
        check_site_reference();
        /*--------------------------------------------------------
        * Comment: function for check user login
        * -----------------------------------------------------*/			
        loginCheck();
    }
    
    public function album_list_process(){
       
		
		//get album data by action category id ( 1 for user data )
        /* get memcached data for album  */
        $user_id = $this->view_data['user_id'];
        $icon_show =  $this->view_data['icon_show'];
        $this->view_data['page_status'] = 0;
        $album_data_cached = $this->CI->memcached_library->get('album_data_cached_'.$user_id);

        if(!$album_data_cached || true){ //@todo: need to make it work for mamcache.
            $action_category_id = 1;
            //$data['user_id']		=	$user_id;
            $this->view_data['action_category_id']	=	$action_category_id;
            //$data['user_points']	=	$this->user_profile->get_user_points($user_id);
            $this->view_data['album_data']		    =	$this->CI->album_model->get_album_detail($user_id,$action_category_id);
            $this->view_data['recent_photo_data']	=	$this->CI->album_model->get_recent_added_photo($user_id,8,$action_category_id);
            //display adverts on user album page
            $page="album";	
            $this->view_data['point_summery_box']   = $this->CI->config->item('_point_summery_box');		
        
            $result = $this->CI->display_advert->display_advert($page);
            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            /* add album data into memcached */
             $this->CI->memcached_library->add('album_data_cached_'.$user_id,$this->view_data,$this->CI->config->item('memcache_album_data_time'));
        }else{
            $this->view_data = $album_data_cached;
        }
		$this->load_view('album/album',$this->view_data);     
    }
    
    
    public function page_process()
    {
        // get page action category id by page id 
        /* get memcached data for album  */
        $page_id = $this->view_data['page_id'];
        $this->view_data['page_status'] = 1;
        $logged_user_id = $this->CI->session->userdata('user_user_id');
        $page_album_data_cached = $this->CI->memcached_library->get('page_album_data_cached_'.$page_id);
 			$page_album_data_cached = ""; // need to remove after test ( Remember) 
       
        if(!$page_album_data_cached) {
		
            $page_info                      = $this->CI->page_model->get_page_by_id($page_id);
            $this->view_data['page_info']   = $page_info;
            $page_owner = $page_info[0]->user_id;
            $logged_user_id = $this->CI->session->userdata('user_user_id');
            if($logged_user_id == $page_owner){
                $icon_show = 0;    
            }else{ $icon_show=1; }
            $this->view_data['user_id'] 		  =  $page_owner;
            $this->view_data['logged_user_id'] =  $logged_user_id;
            $this->view_data['icon_show']		  = $icon_show;
            $action_category_id  = $this->view_data['page_info'][0]->action_category_id;
            $this->view_data['action_category_id']   = $action_category_id;
            $this->view_data['album_data']		     = $this->CI->album_model->get_album_detail('',$action_category_id,$page_id);
			//print_r($this->view_data['album_data']); die('----------------');
			
            $this->view_data['recent_photo_data']	 = $this->CI->album_model->get_recent_added_photo('','',$action_category_id,$page_id);
            $this->view_data['point_summery_box']    = $this->CI->config->item('_point_summery_box');		
            //display adverts
            $page="celebrity_page";
            $result = $this->CI->display_advert->display_advert($page);
            
            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            /* add page album data into memcached */
            $this->CI->memcached_library->add('page_album_data_cached_'.$page_id,$this->view_data,$this->CI->config->item('memcache_album_data_time'));
        }else{
            $this->view_data = $page_album_data_cached;    
        }
        $this->load_page_view('album/album',$this->view_data);  
    }
    
    
    public function save_album_photo_process()
    {
        $user_id  = $this->CI->session->userdata('user_user_id');
        $album_id = $this->CI->input->post('album_id');
		$location = get_location($user_id);
		if(!$location) $location = "";

		$image_detail = $this->CI->input->post('media_name');
		foreach($image_detail as $key => $media_text)
		{
			$media_arr = array(
					'media_name'    =>$key.".jpg",
					'media_text'    => $media_text,
					'user_id'	    =>$user_id,
					'post_user_id'	=>$user_id,
					//'media_text'=>$this->input->post('media_text'),
					'media_type'    => $this->input->post('media_type'),
					'album_id'      => $album_id,
					'location'	    => $location,
					'action_category_id' => 1
			);
			$media = $this->CI->album_model->store_media($media_arr);

			/**---------------------------------------------------------
			 * Comment:for point calculation for photo post 						
			 * activity type  13 : upload image
			 * ---------------------------------------------------------**/							
			$this->CI->point_calculation->add_point($user_id,13,$media);
            /* Delete memcached data if user upload new photo in any specific album*/
            $this->CI->memcached_library->delete('album_photo_data_cached_'.$album_id);
	    }
		    
    }
    
    /*
     * Factory method for album photo of a user
     * */
      function album_photo_user_process() {
         $media_type 	= $this->view_data['media_type']; // media type 1 for media album image
		   $album_id  	   = $this->view_data['album_id'];
         $user_id       = $this->view_data['user_id'];
         $icon_show     = $this->view_data['icon_show'];
               
        /* get memcached data for album  */
        $album_photo_data_cached = $this->CI->memcached_library->get('album_photo_data_cached_'.$album_id);
	     if(!$album_photo_data_cached)
        {
            $this->view_data['album_photo']			 = 	$this->CI->album_model->get_album_photo($album_id, $media_type);
            if(count($this->view_data['album_photo'])>0)
            {
				/**---------------------------------------------------------
				 * Comment:for point calculation for view own album per day once
				 * activity type  18 : view album photo
				 * ---------------------------------------------------------**/							
				// get visitor id on forth segment; else get user id by session
				if($this->CI->uri->segment(2) == "album_photo" && $this->CI->uri->segment(3)==1 && $this->CI->uri->segment(4) && decode($this->CI->uri->segment(4)) != $this->CI->session->userdata('user_user_id'))
				{
					$user_id=decode($this->CI->uri->segment(4));
					// logged in user ID
					$logged_user_id = $this->CI->session->userdata('user_user_id'); 
					$this->CI->point_calculation->add_point($user_id,$this->CI->config->item('_activity_view_album_'),'',$logged_user_id);
				}
			}
			
            $this->view_data['album_photo_points']	 = 	$this->CI->album_model->get_album_image_point($album_id);

            /*--------------------------------------------------------------------------------------
             * Comment : condition for avoid see other user album
             * ------------------------------------------------------------------------------------*/
             if(count($this->view_data['album_photo'])==0 && $this->CI->session->userdata('user_id')!=$user_id){
                 redirect(BASEURL.'album');
             }
            $this->view_data['album_detail']		 =	$this->CI->album_model->get_album_data($album_id);
            $this->view_data['page_id'] 			 =  '';
            
            //display adverts
            $page		=	"album";
            $result  = $this->CI->display_advert->display_advert($page);
            
            if($result!=false)
            {
                $this->view_data['display_advert'] 	=	 $result;
            }
            /* add album data into memcached */
            $this->CI->memcached_library->add('album_photo_data_cached_'.$album_id,$this->view_data,$this->CI->config->item('memcache_album_data_time'));
        }else{
            $this->view_data = $album_photo_data_cached;   
        }
        $this->load_view('album/album_photo',$this->view_data);   
    }
    
    /*
     * Factory method for album photo of a page
     * */
    public function album_photo_page_process()
    {
        $media_type  = $this->view_data['media_type']; // media type 1 for media album image
		$album_id    = $this->view_data['album_id'];
        $page_id     = $this->view_data['page_id'];
        $action_category_id = $this->view_data['action_category_id'];
        /* get memcached data for album  */
        $album_photo_data_cached = $this->CI->memcached_library->get('album_photo_data_cached_'.$album_id);
        if(!$album_photo_data_cached)
        {        
            $this->view_data['album_photo']		= $this->CI->album_model->get_album_photo($album_id, $media_type);
            //echo "<pre>";print_r($this->view_data['album_photo']);die('-------------');
            $this->view_data['album_detail']	= $this->CI->album_model->get_album_data($album_id);
            $page_info                          = $this->CI->page_model->get_page_by_id($page_id);
            $this->view_data['page_info']       = $page_info;
            $page_owner     = $page_info[0]->user_id;
            $logged_user_id = $this->CI->session->userdata('user_user_id');
            if($logged_user_id == $page_owner){
                $icon_show = 0;    
            }else{ $icon_show=1; }
            $this->view_data['icon_show'] = $icon_show;
            
            $this->view_data['album_photo_points']	 = 	$this->CI->album_model->get_album_image_point($album_id);
            //display adverts
            if($action_category_id == 3)
            $page		=	"celebrity_page";
            else if($action_category_id == 4)
            $page		=	"charity_page";
            else if($action_category_id == 5)
            $page		=	"business_page";
			else if($action_category_id == 6)
            $page		=	"charity_profile_page";
            
            $result 	=	$this->CI->display_advert->display_advert($page);

            if($result!=false)
            {
                $this->view_data['display_advert'] = $result;
            }
            /* add album data into memcached */
            $this->CI->memcached_library->add('album_photo_data_cached_'.$album_id,$this->view_data,$this->CI->config->item('memcache_album_data_time'));
        }else{
            $this->view_data = $album_photo_data_cached;   
        }
        $this->load_page_view('album/album_photo',$this->view_data);    
    }
    
    
    public function open_image_galary_process()
    {
        $media_id 			 = $this->CI->input->post('media_id');
        $user_id 				 = $this->CI->input->post('post_user_id');
 		  $album_id 			 = $this->CI->input->post('album_id');
 		  $action_category_id = $this->CI->input->post('action_category_id');     
        
        $image_popup_cached = $this->CI->memcached_library->get('image_popup_cached_'.$media_id);
        $image_popup_cached = "";
        if(!$image_popup_cached){
            $this->view_data['image_path']    = $this->CI->input->post('image_path');
            $this->view_data['post_id']	    = $this->CI->input->post('post_id');
            $this->view_data['post_type']	    = $this->CI->input->post('post_type');
            $this->view_data['media_id']      = $media_id;
            $this->view_data['post_user_id']  = $this->CI->input->post('post_user_id');
            $this->view_data['image_name']	 = $this->CI->input->post('image_name');
            $this->view_data['image_text']	 = $this->CI->input->post('media_text');
            $this->view_data['album_id']	  	 = $album_id;
            $this->view_data['action_category_id']	    = $action_category_id;
            //$comment_count =  Modules::run('comment/comment_count',$media_id,$this->view_data['post_type']);
            $this->view_data['comment_couter']  = "";
            $this->view_data['total_points_alb']  = $this->CI->input->post('total_points_alb');
            /* for image tagging*/
            $this->view_data['loggedUserId'] = $this->CI->session->userdata('user_user_id');
            $tagList = $this->CI->wall_model->getImageTagList();
            $this->view_data['tagList'] 	 = $tagList;
            $friendsList = $this->CI->wall_model->getFriendsListForImageTag();	
            $this->view_data['friendsList'] = $friendsList;
       
            /* end for image tagging */
            /* add album data into memcached */
            $this->CI->memcached_library->add('image_popup_cached_'.$media_id,$this->view_data,$this->CI->config->item('memcache_album_data_time'));
        }else{
            $this->view_data = $image_popup_cached;
        }
		$tpl = $this->CI->load->view('album/album_popup',$this->view_data,true);
		echo json_encode(array('tpl'=>$tpl));	
    }
    
    
    
    
    public function get_image_galary_process()
    {
        $media_id   = $this->CI->input->post('media_id');
		$user_id    = $this->CI->input->post('user_id');
		$album_id   = $this->CI->input->post('album_id');
		$type       = $this->CI->input->post('type');
        //$comment_count =  Modules::run('comment/comment_count',$media_id,$type);
		$action_category_id    = $this->CI->input->post('action_category_id');
		$media_arr = $this->CI->album_model->get_gallery_image($media_id, $user_id, $album_id, $type, $action_category_id);
	
		if($media_arr != false)
		{
			$media_name = $media_arr[0]->media_name;
			$media_id   = $media_arr[0]->media_id;
			$media_text = $media_arr[0]->media_text;
		
			if($action_category_id == 1)
			{
                $album_popup_dimention = $this->CI->config->item('__746x556__');  // get album cover dimentions
				$media_path = getimage('media', 5, $user_id, $media_name, '', '', $album_id,$album_popup_dimention);
			}	
			else
			{
				// here user id will be page id as passed from view
				$media_path = getimage('page', 5, $user_id, $media_name, '', '', $album_id,$album_popup_dimention);
			}	
			
			$this->view_data['image_path']   = $media_path;
			$this->view_data['post_type']	 = 1;
			$this->view_data['media_id']     = $media_id;
			$this->view_data['post_user_id'] = $user_id;
			$this->view_data['image_name']	 = $media_name;
			$this->view_data['image_text']	 = $media_text;
			$this->view_data['album_id']	 = $album_id;
			$this->view_data['action_category_id']	 = $action_category_id;
			$this->view_data['comment_couter']	 = "";
			$this->view_data['total_points_alb']	 = '';
			
			/* for image tagging*/
			$this->view_data['loggedUserId']=$this->CI->session->userdata('user_user_id');	
			$tagList = $this->CI->wall_model->getImageTagList();
			$this->view_data['tagList'] = $tagList;
			$friendsList = $this->CI->wall_model->getFriendsListForImageTag();	
			$this->view_data['friendsList'] =$friendsList;
			/* end for image tagging */
			
			$tpl = $this->CI->load->view('album/album_popup',$this->view_data,true);
			echo json_encode(array('tpl'=>$tpl));	
		}
		else 
		echo 0;    
    }
    
    
        
    /*
     * Function to load view
     * */
    public function load_view($view='album/album',$data){
        $this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
    }
    
    /*
     * Function to load page view
     * */
    public function load_page_view($view='album/album',$data){
        $this->CI->profile_template->load('page/page_template',$view,$data);
    }
    
 
			
}
