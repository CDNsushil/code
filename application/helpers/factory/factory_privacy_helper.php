<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
*/

class factory_loop   {
	
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
			
			
        //initialize function
        public function init(){
            $this->CI->load->language('profile_template');
			$this->CI->load->language('privacy');
			$this->CI->load->language('user_profile');
			$this->CI->load->language('wall');
			$this->CI->load->model('privacy/privacy_model');
			$this->CI->load->model('user_profile');
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
    
      /*
      * Factory method to make private loops
      **/
       public function make_loop_process(){
            $list_name = $this->CI->input->post('list_name');
			$user_id   = $this->CI->session->userdata('user_user_id');
			if($this->CI->privacy_model->check_list_name($list_name,$user_id)){
				echo json_encode(array('status'=>'exist','msg'=>'Loop name already exists'));
				return 0;
			}
			$list_arr = $this->CI->input->post('list_members');
			$list_id  = $this->CI->privacy_model->create_sublist($list_name,$user_id);
			if(!empty($list_arr) && count($list_arr)>0){
				$this->CI->privacy_model->create_list_members($list_arr,$list_id);
			}
            $this->CI->memcached_library->delete('private_loop_data_cached_'.$user_id);
			echo json_encode(array('status'=>'success','msg'=>'Loop created successfully'));
       } 
        
        /*
         * Factory method for private loops list
         **/
        public function loop_list_process(){
            $user_id=$this->CI->session->userdata('user_user_id');	
			$this->view_data['user_id'] = $user_id;
            $private_loop_data_cached = $this->CI->memcached_library->get('private_loop_data_cached_'.$user_id);
            if(!$private_loop_data_cached){
                $this->view_data['sublist'] = $this->CI->privacy_model->get_sublist()->result();
                $this->view_data['friend_list'] = $this->CI->privacy_model->get_all_friends();
                $this->CI->memcached_library->add('private_loop_data_cached_'.$user_id,$this->view_data,$this->CI->config->item('memcache_loop_data_time'));
            }else{
                $this->view_data = $private_loop_data_cached;
            }
			$this->view_data['sublist_count'] = count($this->view_data['sublist']);
			$this->CI->load->view('private_loops',$this->view_data);    
        }
        
        /*
         * Factory method for private loops detail
        **/ 
        public function loop_detail_process(){
            $private_loop_member_data_cached = $this->CI->memcached_library->get('private_loop_member_data_cached_'.$list_id);
            if(!$private_loop_member_data_cached){
                $sublist_data = $this->CI->privacy_model->sublist_data($list_id);
                $this->view_data['list_name'] = $sublist_data->sublist_name;
                $this->view_data['list_id'] = $list_id;
                $this->view_data['create_data']= $sublist_data->create_date;
                $this->view_data['member_list'] = $this->privacy_model->get_sublist_members($list_id)->result();
                $this->view_data['member_count']=  count($this->view_data['member_list']);
                $this->view_data['sublist_count'] = $this->privacy_model->get_sublist()->num_rows();
                /* add album data into memcached */
                $this->CI->memcached_library->add('private_loop_member_data_cached_'.$list_id,$this->view_data,$this->CI->config->item('memcache_loop_data_time'));
            }else{
                $this->view_data = $private_loop_member_data_cached;    
            }
            $this->CI->load->view('loop_detail',$this->view_data);    
        }
        
    /*
     * Function to load view
     * */
    public function load_view($view='friends/user_friend_list',$data){
        $this->CI->profile_template->load('profile_includes/profile_template',$view,$data);
    }
			
}
