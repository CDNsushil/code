<?php
class Openapp_setting extends MX_Controller{	
	var $data =array();
	/**	* Constructor	**/	
	public function __construct(){		
		parent::__construct();
		loginCheck();
		// Basic library requirements that are always needed
		
		$this->load->library('openapp/OpenappConfig');
		$this->load->model('admin_paging/pageing_model');
		$this->load->model('oauth_model');
		
		// Files copied from shindig, required to make the security token
		require OpenappConfig::get('library_root') . "/Crypto.php";
		require OpenappConfig::get('library_root') . "/BlobCrypter.php";
		require OpenappConfig::get('library_root') . "/SecurityToken.php";
		require OpenappConfig::get('library_root') . "/BasicBlobCrypter.php";
		require OpenappConfig::get('library_root') . "/BasicSecurityToken.php";


		$this->load->library('profile_template');
		
		$this->load->model('openapp_setting_model');		
		
		}	

	/*-----------------------------------------------------	
	| Comment:  Function for  user account content Privacy	
	-------------------------------------------------------*/	
	public function index(){	
			
		$user_id = $this->session->userdata('user_user_id'); 
		$applications = $this->openapp_setting_model->get_person_applications($user_id);
		//echo "<pre>";	print_r($applications);die;
		//$person = $this->get_person($user_id, true);
		$data['app_categories'] = $this->openapp_setting_model->get_app_categories(); 
		$data['applications'] = $applications;
		$this->load->view('applications_manage',$data);
	}

	public function addapp() {
		$userid = $this->session->userdata('user_user_id');
		$url = trim(urldecode($_GET['appUrl']));
		$app_category = $_GET['app_category'];


		if (preg_match("#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i",$url)) {	
			$ret = $this->openapp_setting_model->add_application($userid, $url,$app_category);		
			if ($ret['app_id'] && $ret['mod_id'] && ! $ret['error']) {

			 $res_key = $this->oauth_model->get_gadget_consumer($ret['app_id'],$userid );

			  // App added ok, goto app settings
			   $this->session->set_flashdata('success_app', 'Application successfully Added');
			  redirect( BASEURL . "opensocial");
			} else {
			  // Using the home controller to display the error on the person's home page
			/*  include_once PartuzaConfig::get('controllers_root') . "/home/home.php";
			  $homeController = new homeController();
			  $message = "Could not add application: {$ret['error']}";
			  $homeController->index($params, $message);*/
			   $this->session->set_flashdata('error_app', $ret['error']);
			  redirect( BASEURL . "opensocial");
			}
		}else{
			$this->session->set_flashdata('error_app', 'Invalid url for application');
			redirect( BASEURL . "opensocial");

		}
	}

	public function application($app_id,$mod_id) {
		$userid = $user_id = $this->session->userdata('user_user_id');
		if (! $user_id || (! isset($app_id) || ! is_numeric($app_id)) || (! isset($mod_id) || ! is_numeric($mod_id))) {
		  redirect( BASEURL);
		  die();
		}
		$app_id = intval($app_id);
		$mod_id = intval($mod_id);
		//$friends = $people->get_friends($id);
		//$friend_requests = isset($id) ? $people->get_friend_requests($id) : array();
		$application = $this->openapp_setting_model->get_person_application($user_id, $app_id, $mod_id);
		$log_id = $this->openapp_setting_model->set_application_log(0,$user_id, $app_id);
		$data['application']=$application;
		$data['application']['viwerid']= $user_id;
		$data['application']['log_id']= $log_id;
		$data['application']['approved']= 0;
		$data['application']['star_rating']= $this->openapp_setting_model->get_apps_star_rating($app_id);
		$data['application']['favorite']= $this->openapp_setting_model->get_application_favorite($user_id,$app_id);
		$this->load->view('application_canvas',$data);
	//	$this->template('applications/application_canvas.php', array('application' => $application, 'person' => $person, 'friend_requests' => $friend_requests, 'friends' => $friends,
		//'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false));
	}	

	public function removeapp($user_id, $app_id, $mod_id) {
	  $res = $this->openapp_setting_model->remove_application($user_id, $app_id, $mod_id);
	  if($res==1){
		  $this->session->set_flashdata('success_app', 'Application successfully removed');
	  }
	  else{
		  $this->session->set_flashdata('error_app', 'Unable to remove application');
		  }
	  redirect('opensocial','refresh');
	}

	public function all_application() {
		$search = $this->input->get('search');
		$cat 	= $this->input->get('cat_search');
		if($search=="Search App by Title or description"){
			$search="";
			}
		/***********************************/
		
		
		/*$perpage             = 5;
		$page                = $this->input->get('per_page');
		$page                = ($page>0?$page:1);
		
		/******************Paging*****************  /
		$pagingConfig['per_page'] = 5;			
		$pagingConfig['num_links'] = 2;
		$pagingConfig['use_page_numbers'] = TRUE;
		$pagingConfig['full_tag_open'] = '<ul class="pagination">';
		$pagingConfig['full_tag_close'] = '</ul>';
		$pagingConfig['num_tag_open'] = '<li>';
		$pagingConfig['num_tag_close'] = '</li>';
		$pagingConfig['first_tag_open'] = '<li>';
		$pagingConfig['first_tag_close'] = '</li>';
		$pagingConfig['last_tag_open'] = '<li>';
		$pagingConfig['last_tag_close'] = '</li>';
		$pagingConfig['cur_tag_open'] = '<li class="page"><a>';
		$pagingConfig['cur_tag_close'] = '</a></li>';
		$pagingConfig['next_tag_open'] = '<li>';
		$pagingConfig['next_tag_close'] = '</li>';
		$pagingConfig['last_link'] = '>>';
		$pagingConfig['first_link'] = '<<';
		$pagingConfig['prev_tag_open'] = '<li>';
		$pagingConfig['prev_tag_close'] = '</li>';
		
		$pagingConfig['base_url']    = base_url().'/opensocial/all_application?search='.$search.'&cat_search='.$cat;
		$pagingConfig['page_query_string'] = TRUE;*/
		$applications = $this->openapp_setting_model->get_all_applications($search);
		/*$pagingConfig['total_rows']  = count($this->openapp_setting_model->get_all_applications($search,$cat,$page,0));
		$pagingConfig['uri_segment'] = 4;
		$this->pagination->initialize($pagingConfig);
		/******************************************/
		//$applications->star_rating= $this->openapp_setting_model->get_apps_star_rating($applications->id);
		//$data['app_categories'] = $this->openapp_setting_model->get_app_categories(); 
		$data['applications'] = $applications;
		$data['user_id'] = $this->session->userdata('user_user_id');
		//$data['paging']       = $this->pagination->create_links();
		$this->load->view('all_app_manage',$data);
	}

	public function admin_manage_openapp(){
		$category 	 = $this->input->get('category');				
		$all_apps  				 = $this->openapp_setting_model->get_all_openapp();
		$perpage            	 = 10;
		$page           	     = $this->input->get('per_page');
		$page       	         = ($page>0?$page:1);
		$app_data	          	 = $this->openapp_setting_model->get_all_openapp($category,$page,$perpage);		
		$config               	 = $this->pageing_model->get_config_paging();						
		$config['base_url']      = base_url().'admin_manage_openapp?category='.$category.'';
		$config['page_query_string'] = TRUE;
		$config['total_rows']  = count($this->openapp_setting_model->get_all_openapp($category,$page,0));
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
			
			$data = array();
			$data['app_data']     = $app_data;
			$data['app_categories']     = $this->openapp_setting_model->get_app_categories();
			//$data['user_filter_name'] = $get_user_filter;
			$data['category']	  = $category;
			$data['paging']           =  $this->pagination->create_links();
			$this->load->view('view_openapp',$data);
	}

	public function udpate_app_status() { 
	$app_id = $this->input->post('app_id');
	$action = $this->input->post('action');
	$res = $this->openapp_setting_model->udpate_app_status($app_id,$action);
	echo $res;die;
	}

	public function admin_preview($user_id,$app_id,$mod_id){
		$id = isset($userid) && is_numeric($userid) ? $userid : false;
		if (! $id || (! isset($app_id) || ! is_numeric($app_id)) || (! isset($mod_id) || ! is_numeric($mod_id))) {
		  redirect( BASEURL);
		  die();
		}
		$app_id = intval($app_id);
		$mod_id = intval($mod_id);
		//$person = $people->get_person($id, true);
		//$friends = $people->get_friends($id);
		//$friend_requests = isset($id) ? $people->get_friend_requests($id) : array();
		$application = $this->openapp_setting_model->get_person_application($id, $app_id, $mod_id);
		$data['application']=$application;
		$this->load->view('application_canvas',$data);
	}


	public function app_setting($app_id){

	  $data['res_key'] = $this->oauth_model->get_gadget_consumer($app_id);
	  $this->load->view('app_setting',$data);
	  }
	public function sidebar_block(){
		$applications = $this->openapp_setting_model->get_all_applications();
		$rand = (count($applications) >5)?  5: count($applications) ;
		$rand_keys = array_rand($applications,	$rand );
		foreach($rand_keys as $key){ 
		if($applications[$key]->app_category_id ==2)
			$applist['game'][] = $applications[$key];
		else
			$applist['app'][] = $applications[$key];
		}
		$data['data']= $applist;
		$this->load->view('sidebar_block',$data);
	}  
	public function set_application_log($log_id){
		$log_id = $this->openapp_setting_model->set_application_log($log_id);
	}
	public function set_application_activity($type,$app_id,$op){
		$user_id = $this->session->userdata('user_user_id');
		switch($type){
		case 'favorite':
			echo $this->openapp_setting_model->set_application_activity($user_id,$app_id,$op);
		}

	}
	public function friends_recently_played($user_id,$app_id){
		$data = array();
		$friend = $this->openapp_setting_model->friends_recently_played($user_id,$app_id);
		$data['friends']=$friend;
		$this->load->view('friends_recently_played',$data);
	}
	public function friends_most_played_games($user_id){
		$data = array();
		$data = array();
		$apps = $this->openapp_setting_model->friends_apps_most_using($user_id,'game');
		$data['apps']=$apps;
		$this->load->view('friends_most_played_games',$data);
	}
	public function friends_playing_now($user_id){
		$data = array();
		$friend = $this->openapp_setting_model->friends_playing_now($user_id);
		$data['friends']=$friend;
		$this->load->view('friends_playing_now',$data);
	} 
	public function friends_apps_most_using ($user_id){
		$data = array();
		$apps = $this->openapp_setting_model->friends_apps_most_using($user_id,'app');
		$data['apps']=$apps;
		$this->load->view('friends_apps_most_using',$data);
	} 
	public function invites_from_friends (){
		$data = array();
		$user_id = $this->session->userdata('user_user_id');
		$data = $this->openapp_setting_model->invites_from_friends($user_id);
		$data['requests']=$data;
		$this->load->view('invites_from_friends',$data);
	}

	public function invites_from_friends_request(){
		$post = $this->input->post();
		$app_id = $post['app_id'];
		unset($post['app_id']);
		foreach($post as $key => $value){
		if(is_int($key))
			$friend_ids[] = $key;
		}
		$friend_ids = implode(',',$friend_ids);
		$user_id = $this->session->userdata('user_user_id');
		$rows = $this->openapp_setting_model->invites_from_friends_request($user_id,$app_id,$friend_ids);
		echo "Request sent to $rows friends.";
	} 

	public function invites_from_friends_responce($action_id,$status){
		isAjax();
		if($status == 0 || $status == 1)
			echo $this->openapp_setting_model->invites_from_friends_responce($action_id,$status);
		else
			echo 0; // error
	} 
	public function invites_friends_request_form($app_id){
		$user_id = $this->session->userdata('user_user_id');
		$rows = get_user_friends($user_id);
		$temp = array();
		foreach($rows as $row){
			if(!in_array($row->friend_id,$temp)){
					$temp[] = $row->friend_id;
				$profile_image_dimention = $this->config->item('__48X48__');
				$row->pic = getimage('user', 2, $row->friend_id,'','','','',$profile_image_dimention);
			$result[] = $row;
			}
		}
		$data['friends'] = $result;
		$data['app_id'] = $app_id;
		$tpl = $this->load->view('invites_friends_request_form',$data,true);
		echo $tpl;
	} 

	public function  update_oauth_permission($params='') {
		$openSocialApp=$this->session->userdata('user_user_id');
		$data = $this->input->post();
		$this->openapp_setting_model->set_oauth_permission($data);
	}

	public function get_person_application_setting() {
		$user_id = $this->session->userdata('user_user_id');
		$data['user_app_setting'] = $this->openapp_setting_model->get_person_application_setting($user_id);
		$this->load->view('user_application_setting',$data);
	}

	public function save_user_setting() {
		$user_id = $this->session->userdata('user_user_id');
		$profile_data = $this->input->post('profile_data');
		$friend_data = $this->input->post('friend_data');
		$wall_data = $this->input->post('wall_data');
		$app_id = $this->input->post('app_id');
		foreach($app_id as $key=>$value){
			if(isset($profile_data[$key])){$profile = $profile_data[$key];}else{$profile=0;}
			if(isset($friend_data[$key])){$friend = $friend_data[$key];}else{$friend=0;}
			if(isset($wall_data[$key])){$wall=$wall_data[$key];}else{$wall=0;}
			$data = array('profile_data'=>$profile,'friend_data'=>$friend,'wall_data'=>$wall);
			$this->openapp_setting_model->save_user_setting($data,$user_id,$key);
		}
		redirect('profile/settings');
	}

	public function get_apps_star_rating($app_id){
		isAjax();
		$rating = $this->openapp_setting_model->get_apps_star_rating($app_id);
		echo $rating;
	} 
	public function set_apps_star_rating(){
			$post = $this->input->post();
		$user_id = $this->session->userdata('user_user_id');
		echo  $this->openapp_setting_model->set_apps_star_rating($post,$user_id);
	} 
}
?>
