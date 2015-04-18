<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_page   {
	
	// to hold current language set by user 
	public   	$lang;
	// $view_data	= to hold any data related to view 
	public		$view_data	=	array('login_error_message'=>'');
	
	public function __construct()
	{
			$this->CI =& get_instance();
			$this->init();		
	}

    public function init()
    {

		$this->CI->load->helper('common');
		$this->CI->load->helper('page');
		$this->CI->load->model('page_model');
		$this->CI->load->model('album_model');
		$this->CI->load->model('wall/wall_model');
		$this->CI->load->model('common_model');
		$this->CI->load->library('point_calculation');
		$this->CI->load->library('display_advert');
		$this->CI->load->library('plupload');
		$this->CI->load->library('recent_activity');
		$this->CI->load->language('create_page');
		$this->CI->load->language('notification');
		$this->CI->load->language('user_profile');
		$this->CI->load->language('wall');
        $this->CI->load->language('donate');
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
     * Factory method for get_page
     **/
    public function get_page_process()
	{
        $status_val = array();
        $page_id = $this->view_data['page_id'];
        //$user_id = $this->CI->session->userdata('user_user_id');
        $page_info			= $this->CI->page_model->get_page_by_id($page_id);
        if(!$page_info){
             redirect(BASEURL);   
        }
        $user_id = $this->CI->page_model->get_page_owner($page_id);
        $this->view_data['user_id'] 			= $user_id;
        $this->view_data['news_feeds'] 			= $this->CI->recent_activity->get_page_wall($user_id,$page_id,'wall');
        
        $this->view_data['page_info'] 			= $page_info;
        $this->view_data['page_total_members']  = $this->CI->page_model->get_page_total_members($page_id);
        $this->view_data['action_category_id'] 	= $page_info[0]->action_category_id; // 3 for celebrity page 
		
		if($page_info[0]->action_category_id==5) {
			$this->view_data['banner_img']	= $this->CI->page_model->get_banner_image($page_id);
		}
		
        //display adverts
        $page		=	"page";
        $result  = $this->CI->display_advert->display_advert($page);
        if($result!=false)
        {
            $this->view_data['display_advert'] = $result;
        }
        // Load Template	
        $logged_user_id = $this->CI->session->userdata('user_user_id');	
        $status_val = $this->CI->page_model->get_subscribe_status($logged_user_id,$page_id);
        $this->view_data['subscribe_text']	=	$status_val[0]; 
        $this->view_data['subscribe_val']	=	$status_val[1]; 
        $this->load_view('page/get_wall',$this->view_data);
	}
    
    
    public function get_feed_process()
    {
        $page_id = $this->view_data['page_id'];
        //$user_id = $this->CI->session->userdata('user_user_id');
        $page_info			= $this->CI->page_model->get_page_by_id($page_id);
        if(!$page_info){
             redirect(BASEURL);   
        }
        $user_id = $this->CI->page_model->get_page_owner($page_id);
        $this->view_data['news_feeds'] = $this->CI->recent_activity->get_page_feeds($page_id);
        $this->view_data['page_info']  = $this->CI->page_model->get_page_by_id($page_id);
        $this->view_data['page_total_members'] = $this->CI->page_model->get_page_total_members($page_id);
        $this->view_data['action_category_id'] 	= $page_info[0]->action_category_id; // 3 for celebrity page 
        $this->view_data['user_id'] = $user_id;
        
        // Load Template		
        $logged_user_id = $this->CI->session->userdata('user_user_id');
        $status_val = $this->CI->page_model->get_subscribe_status($logged_user_id,$page_id);
    
        $this->view_data['subscribe_text']		=	 $status_val[0];
        $this->view_data['subscribe_val']		=	 $status_val[1]; 
        
        //display adverts
        $page="celebrity_page";
        $result = $this->CI->display_advert->display_advert($page);
        if($result!=false)
        {
            $this->view_data['display_advert'] = $result;
        }
        $this->load_view('page/get_wall',$this->view_data);
    }

    /*
     * function for edit image for page section 
     * */
    
    public function  edit_image_process()
    {
        $action_category_id = $this->CI->config->item('__celebrity_page__'); // celebrity page action category id
        $user_id            = $this->CI->session->userdata('user_user_id');
        
        // create new profile pictures album if not exists and insert record in media
        $profile_picture	=	$this->CI->input->post('profile_picture');
        $page_id	        =	$this->CI->input->post('page_id');
        $res['edit_image_result'] = $this->CI->album_model->create_profile_album($user_id, $profile_picture, $action_category_id, $page_id);
		$res['edit_image_result'] = $page_id;
		return $res;
    }
    
    
    
    public function update_profile()
	{
        $user_id = $this->CI->session->userdata('user_user_id');
        // check if already having entry in point table for profile activity
        $result = $this->CI->point_calculation->get_user_points_by_activity($user_id,7);
        
        if($result==false)
        {
            // check if all fields filled by user then award some points once only
            $result = $this->CI->user_profile->check_profile_info();
            if($result)
            {
                $this->CI->point_calculation->add_point($user_id,7,$user_id);
            }
        }
    }
    
    
    public function open_page_image_galary_process()
    {
        $this->view_data['image_path']   = $this->CI->input->post('image_path');
		$this->view_data['post_id']	 	 = $this->CI->input->post('post_id');
		$this->view_data['post_type']	 = $this->CI->input->post('post_type');
		$this->view_data['media_id']     = $this->CI->input->post('media_id');
		$this->view_data['page_id']      = $this->CI->input->post('page_id');
		$this->view_data['image_name']	 = $this->CI->input->post('image_name');
		$this->view_data['image_text']	 = $this->CI->input->post('media_text');
		$this->view_data['album_id']	 = $this->CI->input->post('album_id');
		$this->view_data['action_category_id']	    = $this->CI->input->post('action_category_id');
		/* for image tagging*/
		$this->view_data['loggedUserId'] = $this->CI->session->userdata('user_user_id');	
		$tagList                         = $this->CI->wall_model->getImageTagList();
		$this->view_data['tagList'] 	 = $tagList;
		$friendsList                     = $this->CI->wall_model->getFriendsListForImageTag();	
		$this->view_data['friendsList']  = $friendsList;   
    }
    
    
    public function concert_update()
	{
		$concert_id = $this->CI->input->post('concert_id');
		$this->view_data['data'] = $this->CI->page_model->concert_update($concert_id);
        // get country; state; city data
        $country_query = $this->CI->common_model->get_country();
        if($country_query!=false) $this->view_data['country_query'] = $country_query;
        
        if(isset($country_id) && $country_id>0)	
        {			
            $state_query = $this->CI->common_model->get_states_by_country($country_id);
            if($state_query!=false) $this->view_data['state_query'] = $state_query;
        }	
        else
        {
            $this->view_data['state_query'] = array();
        }
        
        if(isset($state_id) && $state_id>0 && $country_id>0)		
        {
            $city_query = $this->CI->common_model->get_cities_by_state($state_id);
            if($city_query!=false) $this->view_data['city_query'] = $city_query;
        }	
        else
        {
            $this->view_data['city_query'] = array();
        }
		$tpl = $this->CI->load->view('page/concert_update', $this->view_data,true);
		echo json_encode(array("tpl"=>$tpl));
    }    
    
    
    function get_gallery_image()
	{
		$media_id    = $this->CI->input->post('media_id');
		$page_id     = $this->CI->input->post('page_id');
		$album_id    = $this->CI->input->post('album_id');
		$type        = $this->CI->input->post('type');
		$action_category_id    = $this->CI->input->post('action_category_id');
		
		$media_arr = $this->CI->album_model->get_gallery_image($media_id, $page_id, $album_id, $type, $action_category_id);
		if($media_arr != false)
		{
		
			$media_name = $media_arr[0]->media_name;
			$media_id   = $media_arr[0]->media_id;
			$media_text = $media_arr[0]->media_text;
		
			$media_path = getimage('page', 5, $page_id, $media_name, '', '', $album_id);
			
			$this->view_data['image_path']  = $media_path;
			$this->view_data['post_type']	= 1;
			$this->view_data['media_id']    = $media_id;
			$this->view_data['page_id']     = $page_id;
			$this->view_data['image_name']	= $media_name;
			$this->view_data['image_text']	= $media_text;
			$this->view_data['album_id']	= $album_id;
			$this->view_data['action_category_id']	 = $action_category_id;
			
			/* for image tagging*/
			$this->view_data['loggedUserId'] = $this->CI->session->userdata('user_user_id');	
			$tagList                         = $this->CI->wall_model->getImageTagList();
			$this->view_data['tagList']      = $tagList;
			$friendsList                     = $this->CI->wall_model->getFriendsListForImageTag();	
			$this->view_data['friendsList']  = $friendsList;
			/* end for image tagging */
			
			$tpl = $this->CI->load->view('page/album/album_popup',$data,true);
			echo json_encode(array('tpl'=>$tpl));	
		}
		else 
		echo 0;
	}	
    
     /*
     * Function to load view
     * */
    public function load_view($view='page/page_template',$data){
        $this->CI->profile_template->load('page/page_template',$view,$data);
    }
	
	/**
	* Function for get banner image for buisness page
	*/
}
