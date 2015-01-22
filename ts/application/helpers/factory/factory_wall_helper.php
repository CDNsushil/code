<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_wall{
	
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
				$this->CI->load->model('wall_model');
                $this->CI->load->model('album_model');
                $this->CI->load->library('plupload');
                $this->CI->load->library('email_notification');
                $this->CI->load->library('recent_activity');
                $this->CI->load->library('point_calculation');
                $this->CI->load->library('notification');
                $this->CI->load->library('facebook_library');
                $this->CI->load->language('wall');
                $this->CI->load->library('email_template');
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
	* Function to updates the wall status text of the user 
	**/
	function store_status_update_process(){
        $wall_content       = $this->CI->input->post('wall_content');
            $post_type_id       = $this->CI->input->post('post_type_id');
			$wall_content       = $this->CI->input->post('wall_content');
            $action_category_id = $this->CI->input->post('post_from');
            $user_id            = $this->CI->session->userdata('user_user_id');
            $wall_for_id        = $this->CI->input->post('wall_for_id');
            
            /*-----------------Check if user logged in using facebook and post status to facebook START---------------------*/
			if($this->input->post('fb_post')==1){
				$this->facebook_post($wall_content);
			}
            /*-----------------Check if user logged in using facebook and post status to facebook END---------------------*/

			$location = get_location($user_id);
			$wall_link_title='';
			$image_src = '';
			/*======= For group posting start =====*/
			if(!isset($action_category_id) && $action_category_id=="") $action_category_id = 1;
	
			$action_category_record_id='';
			$image_src=''; $wall_link_title='';
			if($action_category_id!=1)
				$action_category_record_id = $this->CI->input->post('post_from_id');
			/*======= For group posting end =====*/
			
            /*------Check if posted content is link start-------*/
			if($post_type_id==3){
				$link_arr  = $this->post_link($wall_content);
                $image_src = $link_arr['image_src'];
                $wall_link_title = $link_arr['wall_link_title']; 
			}
            /*------Check if posted content is link end-------*/

			if(!$location) $location = "";	
			$wall_arr = array(
				'wall_content'	    =>$wall_content,
				'wall_for_id'	    =>$wall_for_id,
				'location'		    =>$location, 
				'user_id' 		    =>$user_id,
				'post_type'		    =>$post_type_id,
				'action_category_id'=> $action_category_id,
				'wall_link_title'   => $wall_link_title,
				'wall_link_image'   => $image_src
			);
			
			$new_wall_id = $this->CI->wall_model->store_wall_status($wall_arr);
			if($new_wall_id)
            {
				$msg = "success";
				$content = $this->CI->wall_model->get_wall_by_id($new_wall_id);
				$data['content'] = $content;
				if($post_type_id==2)
					$tpl = $this->CI->load->view('wall_append',$data,true);
				else $tpl = $this->CI->load->view('link_append',$data,true);
                echo json_encode(array('msg'=>$msg,'tpl'=>$tpl));
            	
                /*----------process notification and activity libaries---------*/	
				//$this->process_notification($wall_content,$wall_for_id,$post_type_id,$new_wall_id,$action_category_id,$action_category_record_id,$user_id);

                /** delete data from memcache if there is any new post **/
				$this->CI->memcached_library->delete('news_feed_cached_'.$user_id);
            }
	}

    /**
	* Function to post link 
	**/
    public function post_link($wall_content)
    {
        $html = file_get_contents($wall_content);			
        preg_match_all('/<img[^<]+?>/', $html, $matches);
        $doc = new DOMDocument();
        $doc->loadHTML($matches[0][0]);
        $imageTags = $doc->getElementsByTagName('img');		
        foreach($imageTags as $tag) {
             $image_src	= str_replace(" ","%20",$tag->getAttribute('src'));		         
        }
        $urlData = explode("/",$wall_content);
        $mainUrl = $urlData[0].'//'.$urlData[2].'/';
        if(strpos($image_src, 'http')===false)
        $image_src=$mainUrl.$image_src;
        $image_src		=	BASEURL.'resize/index/164/87/'.base64_encode(urlencode($image_src));
        
          $res = preg_match("/<title>(.*)<\/title>/siU",$html, $title_matches);
          if (!$res){ 
            $wall_link_title=$wall_content; 
          }else{
            $title = preg_replace('/\s+/', ' ', $title_matches[1]);
            $wall_link_title = trim($title);					
          }
          $link_arr = array('image_src' => $image_src,'wall_link_title'=>$wall_link_title);
          
          return $link_arr;
    }


			public function load_view($view='get_wall',$data){
				$this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
			}
}
