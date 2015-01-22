<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching admin Controller Class
 * Manage Admin details (Admin login,Edit pages etc.)
 * @category	Controller
 * @author		CDN Solutions
 */
 
define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');
class Toad_admin extends MX_Controller {
	// public $paggingConfig =array();
	/**
	* Constructor
	**/	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		/*$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}*/
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->model('report/report_model');
		$this->load->model('violation_report_model');
		$this->load->library('pagination');
		$this->load->model('user_profile');	
		$this->load->model('auth/users');	
		$this->load->library('email');
		$this->load->library('email_notification');
		$this->load->model('admin_users/users_model'); //   User for get user model		
		$this->load->model('admin_paging/pageing_model'); //  User for get user model
		$this->load->model('admin_mail/mail_model'); //  User for get user model
		$this->load->language('app_template'); 
		$this->load->language('email');
		$this->load->library('email_template');
        $this->load->library('form_validation');
		$this->load->library('auth/PasswordHash',$this->config->item('phpass_hash_strength', 'tank_auth'),
						$this->config->item('phpass_hash_portable', 'tank_auth'));
	}
	
	/**
	* Index function by default call when controller get initialised.
	**/
	public function index(){
		if(!$this->login_check()){
			$this->login();
		}else{
			//redirect('toad_admin/toad_admin/dashboard');
			redirect(SITE_AREA_SETTINGS.'manage_language/');
		}
	}
	
	
	/**
	* Comment: Function for toad_admin login		
	**/
	public function login(){
		if($this->input->post('login')){
			/*----Form validation -----*/
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password','password','trim|required');
			if ($this->form_validation->run() == TRUE){	
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				
				/*$admin_name = $this->config->item('admin_username', '');
				$admin_password = $this->config->item('admin_password', '');
				if($admin_name==$username && $password==$admin_password){
					$sessiondata = array(
						'user_id'  	   => $this->config->item('admin_id', ''),
						'username'     => $admin_name,
						'firstname'     => $this->config->item('firstname', ''),
						'lastname'     => $this->config->item('lastname', ''),
						'user_role'    => 1
					);				
					$this->session->set_userdata('session_data', $sessiondata);
					redirect('language');
				}else{
					$this->session->set_flashdata('message',$this->lang->line('wrong_credential_msg'));
					redirect('toad_admin/toad_admin');
				}*/
				//$login_check = $this->admin_model->login($username);
				$login_check = $this->users->get_user_by_email($username);
				//echo '<pre />cgfhf';print_r($login_check);
				//echo '<pre />';print_r($login_check);
				//die;
				if(isset($login_check)){
					$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
					
					if ($hasher->CheckPassword($password, $login_check->password)) {		// password ok
						
							$profileImagePath  = 'media/'.$login_check->username.'/profile_image/';
							$sessiondata = array(
								'user_id'  	   => $login_check->tdsUid,
								'showcaseId'	=> $login_check->showcaseId,
								'creative'	=> $login_check->creative,
								'associatedProfessional'	=> $login_check->associatedProfessional,
								'enterprise'	=> $login_check->enterprise,
								'username'     => $login_check->username,
								'firstname'    => $login_check->firstName,
								'lastname'     => $login_check->lastName,
								'enterpriseName'     => $login_check->enterpriseName,
								'enterprise'     => $login_check->enterprise,
								'user_role'    => $login_check->group,
								'userFullName'	=> $login_check->firstName.' '.$login_check->lastName,
								'userArea'	=> $login_check->optionAreaName,
								'email'		=> $login_check->email,
								'countryId'	=> $login_check->countryId,
								'countryName'	=> $login_check->countryName,
								'seller_currency'	=> $login_check->seller_currency,
								'last_visit'=> $login_check->last_visit,
								'created'	=> $login_check->created,
								'imagePath'	=> (($login_check->stockImageId>0)?$login_check->stockImgPath.'/'.$login_check->stockFilename:$profileImagePath.$login_check->profileImageName),
								'status'	=> ($login_check->active == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED
							);	
							//echo '<pre />';print_r($sessiondata);die;	
							$this->session->set_userdata($sessiondata);	
							$this->session->set_userdata('session_data', $sessiondata);
							redirect('admin/settings/manage_language/');
						}else{
							$this->session->set_flashdata('message',$this->lang->line('wrong_credential_msg'));
							redirect('toad_admin/toad_admin');
						}
					
				}else{
					$this->session->set_flashdata('message',$this->lang->line('wrong_credential_msg'));
					redirect('toad_admin/toad_admin');
				}
			}else{
				$this->session->set_flashdata('message',$this->lang->line('required_fields'));
				redirect('toad_admin/toad_admin');
			}
		}else{
			$this->load->view('admin/login');
		}
	}

	/**
	* function for toad_admin dashboard, display table of all pages from database		
	**/
	public function dashboard(){
		if($this->login_check()){
			$pages = $this->admin_model->get_pages();
			$data_set = $pages->result();
			$template_data['pages'] = $data_set;
			$this->admin_template->load('admin/admin','admin/dashboard',$template_data);
		}else{
			$this->session->set_flashdata('message','Please Login');
			redirect('toad_admin/toad_admin');
		}
	}

	/**
	* Displays Post Form to insert/update the page content
	**/
	public function edit_page($id){
		if($this->login_check()){
			if($this->input->post('edit')){
				/*
				 * set global xss filter to off while saving intro pages content
				 */
				$this->config->set_item('global_xss_filtering', false);
				$this->form_validation->set_rules('page_title','page_title','trim|required');
				if ($this->form_validation->run() == TRUE){
                    $lang_id = $this->input->post('page_lang');
                    $page_id = $this->input->post('page_id');
					$page_arr =  array(
						'page_id' 	  			=> $page_id,
						'page_title' 	  		=> $this->input->post('page_title'),
						'page_meta_keywords'	=> $this->input->post('meta_keywords'),
						'page_meta_description'	=> $this->input->post('meta_description'),
						'page_heading'			=> $this->input->post('heading'),
						'page_subhead'			=> $this->input->post('subhead'),
						'page_content'			=> $this->input->post('FCKeditor'),
						'language_id' 			=> $lang_id
					);
					$content_id='';
					$result = $this->admin_model->edit_page($content_id,$page_arr);
                    /*------------delete memcached when any page get updated---------------*/
                    $this->memcached_library->delete('static_page_data_cached_'.$page_id.'_'.$lang_id);    

					/*
					 * set global xss filter to off while saving intro pages content
					 */
					$this->config->set_item('global_xss_filtering', true);
					
					if($result) {
						
					/*------------------------------------------------------------
										Code for Manage admin activities 
					Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
					--------------------- START ----------------------------------*/
						$user_array = $this->session->userdata('session_data');
						$userId    = $user_array['user_id'];

						$module_name 	   = "Page";
						$module_action    = "Update"; 
						$module_summary   = $this->input->post('page_title');
						$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
					/*-------------------- END -------------------------------*/							
						
						 $this->session->set_flashdata('edit_success','<span>Success!</span> Page saved Successfully');
						 redirect('toad_admin/toad_admin/dashboard');
						 redirect('language');
					 }
				}else{
					redirect('toad_admin/toad_admin/editPage/'.$id);
				}
			}else{
				$template_data['selected_lang'] = 'english';
				if($this->session->userdata('language')){
					$template_data['selected_lang']=$this->session->userdata('language');
				}
				 $language_code = $template_data['selected_lang_code'] = $this->admin_model->get_language_code($template_data['selected_lang']);
				 
				$template_data['lang']=$this->get_language(); 
				$page = $this->admin_model->get_single_page($id,$language_code);
				$data_set = $page->row();
				
				$template_data['page'] = $data_set;
				/*fck editor*/
				$this->load->library('fckeditor');
				$this->fckeditor->ToolbarSets = "MyToolbar";
				$this->fckeditor->BasePath = base_url().'templates/admin_template/fckeditor/';
				$this->fckeditor->Width  = '600';
				$this->fckeditor->Height = '300';
				$this->fckeditor->ToolbarSet = 'Default';
				$this->fckeditor->Value = $data_set->page_content;
				$this->admin_template->load('admin/admin_template','admin/edit_page',$template_data);
			}
		}else{
			$this->session->set_flashdata('message','Please Login!');
			redirect('toad_admin/toad_admin');		
		}
	}

	/**
	* Function for logOut Admin		
	**/
	public function logout(){
		$this->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
		$this->session->sess_destroy();
		//$this->session->sess_destroy();
		$this->session->set_flashdata('message','You are logged out successfully');
		redirect('toad_admin/toad_admin');
	}
	
	/**
	*Function to set language for the admin UI Default laguage is English		
	**/
	public function set_language(){
		if($this->input->post('lang')){
			$language = $this->input->post('lang');
			$page_id  = $this->session->userdata('edit_id'); 
			$this->session->set_userdata('language', $language);
			$this->config->set_item('language', $language);
			redirect('toad_admin/toad_admin/editPage/1');
		}
	}

	/**
	* Function to get available languages from database to populate language select box		
	**/
	public function get_language(){
		return $this->admin_model->get_lang();
	}
	
	/**
	* Function to check language for a specific page	
	**/
	public function check_lang(){
		$page_id = $this->input->post('page_id');
		$lang_id = $this->input->post('lang_id');
		$res = $this->admin_model->check_lang($page_id,$lang_id);
		echo json_encode($res);
	}

	/**
	* Function to check session for admin login	
	**/
	public function login_check(){
		if($this->session->userdata('session_data')){
			return true;
		}else{
			return false;
		}
	}
	
	function get_all_reports(){
		if($this->login_check()){
			$page=$this->uri->segment(4);			
			$page = ($page==""?1:$page);
			$searchTxt =$this->input->post('searchTxt');
			$searchReportType =$this->input->post('searchReportType');
			$issue_type =$this->input->post('searchIssue_type');
			$assign_to =$this->input->post('issued_to');

			// Paging configuration libary
			$config = $this->pageing_model->get_config_paging();

			$data['reports'] = $this->report_model->get_report_list('',$page,$config['per_page'],$searchTxt,$searchReportType,$issue_type,$assign_to);
			
			$config['base_url'] = base_url().'/toad_admin/toad_admin/get_all_reports/';
			$config['total_rows'] = count($this->report_model->get_report_list('','','',$searchTxt,$searchReportType,$issue_type,$assign_to));
			$config['uri_segment'] = 4;	
			
			$this->pagination->initialize($config);

			$data['user_roll']=$this->report_model->get_user_roll();
			$data['report_type_list']=$this->report_model->get_report_type();
			$data['pagging'] = $this->pagination->create_links();
			$data['issue_type'] = $issue_type;
			$data['assign_to'] = $assign_to;
			$data['searchTxt'] = $searchTxt;
			$data['searchReportType'] = $searchReportType;
			
			
			$this->admin_template->load('admin/admin_template','admin/report_list',$data);
		}else{
			redirect('toad_admin/toad_admin');
		}
	}
	
        function get_violation_reports(){
            if($this->login_check()){
                $page=$this->uri->segment(4);			
                $page = ($page==""?1:$page);
                
                $data['reports'] = $this->violation_report_model->get_all();
                
                // Paging configuration libary
                $config = $this->pageing_model->get_config_paging();
                
                $config['base_url'] = base_url().'/toad_admin/toad_admin/get_violation_reports/';
                $config['total_rows'] = count($data['reports']);
                $config['uri_segment'] = 4;	

                $this->pagination->initialize($config);
                $data['pagging'] = $this->pagination->create_links();

                $this->admin_template->load('admin/admin_template','admin/violation_report_list',$data);
            }else{
                redirect('toad_admin/toad_admin');
            }
        }

	function manage_states(){
		if($this->login_check()){
			$country_id = 233;
			if($this->input->post('country')){
				$country_id = $this->input->post('country');
			}
			if($this->uri->segment(4)){
				$country_id = $this->uri->segment(4);		
			}
			
			$states = $this->admin_model->get_state_list($country_id);

			// Paging configuration libary
			$config = $this->pageing_model->get_config_paging();

			$config['base_url'] = base_url().'/toad_admin/toad_admin/manage_states/'.$country_id;
			$config['total_rows'] = $states->num_rows();
			$config['uri_segment'] = 5;			
			$this->pagination->initialize($config);
	
			if($this->uri->segment($config['uri_segment'])>0){
				$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
				$template_data['i']= $start+1;
			}			
			else{ 
				$start =0;
				$template_data['i'] = 1;
			}
			$template_data['country_id'] = $country_id;
			$template_data['paging']     = $this->pagination->create_links();
			$template_data['country']   = $this->admin_model->get_country_list()->result();
			$template_data['states']    = $this->admin_model->get_state_list($country_id,$start,$config['per_page'])->result();
			$this->admin_template->load('admin/admin_template','admin/manage_states',$template_data);
		}else{
			redirect('toad_admin/toad_admin');		
		}	
	}

	function state_list(){
		if($this->login_check()){
			$country_id = $this->input->post('country_id');
			//$country_id = 233;
			$template_data['states'] = $this->admin_model->get_state_list($country_id)->result();
			$list_tpl = $this->load->view('admin/state_list',$template_data,true);
			echo json_encode(array('state_tpl'=>$list_tpl));
		}else{
			redirect('toad_admin/toad_admin');	
		}
	}
	
	function update_state(){
		$state_id = $this->input->post('state_id');
		$ins_value = $this->input->post('ins_value');
		echo $this->admin_model->update_state($state_id,$ins_value);	
	}
	
		
	
	/**
	* Function for delete user data by id
	* Param : user_id 
	* Created date : 7-5-2012	
	**/	
	function user_delete()
	{
		$user_id = $this->uri->segment(4);	
		$this->users_model->user_delete($user_id);
		
	     /*------------------------------------------------------------
						Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------*/
				$user_array			 = $this->session->userdata('session_data');
				$userId    			= $user_array['user_id'];
				$module_name 	   = "User Profile's ";
				$module_action    = "Delete"; 
				$module_summary   = "User ".$user_id;
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/					
		
		$this->session->set_flashdata('message','Advertisement has been deleted successfully.');
		redirect('/toad_admin/toad_admin/', 'location');
	}
	


	/**
	* Function for search according to Activation / Deactivation
	* Created date : 8-5-2012	
	**/	
	function search_staus()
	{
		$newdata = array(
	                   'status_type'  => $_POST['active_val']
	               );
		$this->session->set_userdata($newdata);
	}
	
	
	
	function search_members()
	{
		//---- Check login status  -----
		if($this->login_check()) {
	
			/** ----- Get data according to user character ----- **/
			$user = $this->uri->segment(5);


			if(is_numeric($user)) { 
				$user 	=     $this->uri->segment(6); 
				} else {
				$user 	=      $this->uri->segment(5); 
			}


			$users_list 	=	 $this->users_model->get_users_by_word();

			// Pagination Configuration ----		
			$config     	      = 	$this->pageing_model->get_config_paging();
			$config['base_url']   = 	base_url().'/toad_admin/toad_admin/search_members/'.$this->uri->segment(4).'/'.$user."/";
			$config['total_rows'] = 	$users_list->num_rows();

			if($user) { $config['uri_segment'] = 6; } else { $config['uri_segment'] = 5; }
			$this->pagination->initialize($config);

			$template_data['type_proccess'] =  $this->uri->segment(4);
			if ( $this->uri->segment($config['uri_segment']) > 0 ) {
				$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
				$template_data['i']= $start+1;
			} else { 
				$start		    = 0;
				$template_data['i'] = 1;
			}
			
			$template_data['paging'] 	=  $this->pagination->create_links();


			// Get user list data and assing with pagination variables 

			$template_data['users'] = $this->users_model->get_users_by_word($start,$config['per_page'])->result();
			$this->admin_template->load('admin/admin_template','admin/user_mail_list',$template_data);
		} else {
			redirect('toad_admin/toad_admin');
		}
	}

	/**
	*Function for send email to user and employee
	*Params Users ID array
	* Created : 10-5-2012	
	*/
	function send_mail_user()
	{
		//---- Check login status  -----
		if($this->login_check()) {
		
			$subject = $this->input->post('subject');
			$message = $this->input->post('msg');
			
			$email_ids = array();
			$email_ids = explode(",",$this->input->post('email_ids'));
			foreach($email_ids as $key=>$val)
			{
				/*----------- Get email address by user id ------------*/
				$type = "single";			
				$email_address = $this->users_model->get_email_address($val,$type);

				/*------------ Send email to user by email-address -------------*/
				$send_email    = $this->users_model->send_email_address($email_address,$subject,$message);
			}
			redirect(base_url().'admin_mail');
	    } else {
			redirect('toad_admin/toad_admin');
		}
	}

	
	
	
/******** Code merge by piyush *************/
/***
	* Author: Piyush jain
	* Created : 7-5-2012
	* Function for Change Password
	* Params 	
	*/	
	public function change_password() {

		$user_array = $this->session->userdata('session_data');
		$user_id    = $user_array['user_id'];

		$current_user_password=$this->admin_model->get_user_password($user_id);

		if(!empty($user_id)){$current_user_password1=$current_user_password[0]->password;}

		$current_posted_password = $this->input->post('cpassword');
		$new_password		 = $this->input->post('password');
		$re_type_password 	 = $this->input->post('password_confirm');

		if($this->input->post('change_password'))
			{

			$this->form_validation->set_rules('cpassword', 'cpassword', 'trim|required');
			$this->form_validation->set_rules('password','password','trim|required');
			$this->form_validation->set_rules('password_confirm','password_confirm','trim|required');

			if ($this->form_validation->run() == TRUE){
				if($current_user_password1 == md5($current_posted_password)) {
					if($new_password == $re_type_password) {
					$this->admin_model->update_password(array('password'=>md5($new_password)),$user_id);
					$this->session->set_flashdata('message',$this->lang->line('success_password_change'));
					redirect('toad_admin/toad_admin/change_password');
					} else {
					$this->session->set_flashdata('message',$this->lang->line('new_password_error'));
					}
				} else{
					$this->session->set_flashdata('message',$this->lang->line('old_password_error'));
					redirect('toad_admin/toad_admin/change_password');
				}
			}
			else{
				$this->session->set_flashdata('message',$this->lang->line('required_fields'));
				redirect('toad_admin/toad_admin/change_password');
			    }
		}
			$this->admin_template->load('admin/admin_template','admin/change_password');
	}
	/*--*/


	/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for Manage user activity points
	* Params UserId 	
	*/		
	function manage_user_activity_points($user_id) {
			if(is_numeric($user_id)){
			/*get user point by user id*/
			$get_activity_filter = $this->input->get('activity');	
			
			$config              = 	$this->pageing_model->get_config_paging();
			
			$perpage             = 10;
			$page                = $this->input->get('per_page');
			$page                = ($page>0?$page:1);
				
			$points=$this->admin_model->get_user_points($get_activity_filter,$user_id,$page,$perpage);	
			
			
			$config['base_url'] = base_url().'/admin/admin/manage_user_activity_points/'.$user_id.'?user=&activity='.$get_activity_filter.'';
			$config['page_query_string'] = TRUE;
			$config['total_rows'] = count($this->admin_model->get_user_points($get_activity_filter,$user_id,'',''));
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config);
			
			$data=array();
			$data['result']=$points;
			$data['all_activity_names']  = $this->admin_model->get_activity_names();
			$data['activity_filter_name'] = $get_activity_filter;
			$data['paging']=$this->pagination->create_links();
			$data['total_point']=$this->admin_model->get_total_user_points($user_id);	
			$this->admin_template->load('admin/admin_template','admin/user_activity_points',$data);	
			}
			else{
				//redirect("toad_admin/toad_admin/dashboard");
				redirect("language");
				
				}	
	}
	
	/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for deduct user point
	* Params  	
	*/		
	function delete_points(){
		$point_id =$this->input->post('point_id');
		$this->admin_model->delete_points($point_id);
	}
	
	/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for Get total number of points for user
	* Params  	
	*/
	function get_total_points(){
		$user_id = $this->input->post('user_id');	
		$total=$this->admin_model->get_total_user_points($user_id);
		echo $total[0]->point;
	}

	/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for open update point box
	* Params  	
	*/
	function point_update_box(){
		$point_id = $this->input->post('point_id');
		/*get point by point id*/
		$pointres = $this->admin_model->get_point_by_id($point_id);
		$point    = $pointres[0]->point;
		$data     = array();
		$data     = array('point_id'=>$point_id,'current_point'=>$point,'user_id'=>$this->input->post('user_id'));
		$tpl      = $this->load->view('admin/edit_points',$data,true);
		echo json_encode(array('tpl'=>$tpl));
	}
	
	/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for open confirm delete box
	* Params  	
	*/
	function confirm_delete(){
		$point_id	=	$this->input->post('point_id');
		$user_id	=	$this->input->post('user_id');
		$data	=	array();
		$data	=	array('point_id'=>$point_id,'user_id'=>$user_id);
		$tpl 	= $this->load->view('admin/confirm_delete',$data,true);
		echo json_encode(array('tpl'=>$tpl));
	}

/***
	* Author: Piyush jain
	* Created : 8-5-2012
	* Function for update points 
	* Params  	
	*/
	function update_points() {
		$point_id = $this->input->post('point_id');
		$points   = $this->input->post('point');
        $old_val = $this->admin_model->get_point_by_id($point_id) ;  
		// Function for update points 
		$res = $this->admin_model->update_points(array('point'=>$points),$point_id);
                
               // Function for update points log table 
               
               $this->admin_model->update_points_log($point_id,$old_val,$points); 
		
		// Function for get point by point id
		$pointres = $this->admin_model->get_point_by_id($point_id);
		$point1   = $pointres[0]->point;
		echo $point1;
	}
	
	/***
	* Author: Piyush jain
	* Created : 9-5-2012
	* Function for get user activity data
	* Params  	
	*/
	function view_user_activity(){
			$get_user_filter     = $this->input->get('user');
			$get_activity_filter = $this->input->get('activity');
			
			/*get all user names from user master table for user filter dropdown*/			
			$all_users           = $this->admin_model->get_all_users();

			/*get all activity names from activity master table for activity filter dropdown*/
			$all_activity_name   = $this->admin_model->get_activity_names();

			$perpage             = 10;
			$page                = $this->input->get('per_page');
			$page                = ($page>0?$page:1);
			
			/*get user activities table data*/			
			$filter_result       = $this->admin_model->get_user_activity($get_user_filter,$get_activity_filter,$page,$perpage);
			
			$config              = $this->pageing_model->get_config_paging();						

			$config['base_url']  = base_url().'/toad_admin/toad_admin/view_user_activity/?user='.$get_user_filter.'&activity='.$get_activity_filter.'';
			$config['total_rows']= count($this->admin_model->get_user_activity($get_user_filter,$get_activity_filter,$page,0));
			$config['per_page']  = $perpage;
			$config['uri_segment'] = 4;
			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);
			
			

	$data=array();	
	$data['result']               = $filter_result;
	$data['paging']               = $this->pagination->create_links();
	$data['all_users']            = $all_users;
	$data['all_activity_names']   = $all_activity_name;
	$data['user_filter_name']     = $get_user_filter;
	$data['activity_filter_name'] = $get_activity_filter;
	
	$this->admin_template->load('admin/admin_template','admin/view_user_activity',$data);	
	}	
	

/***
	* Author: Piyush jain
	* Created : 9-5-2012
	* Function for get data of Support question and answer
	* Params  	
	*/
	function view_support_q_a(){
			$get_user_filter     = $this->input->get('user');
			$get_q_a_status_filter     = $this->input->get('filter_q_a');				
			$all_users           = $this->admin_model->get_all_users();
			
			$perpage             = 10;
			$page                = $this->input->get('per_page');
			$page                = ($page>0?$page:1);

			$support_data          = $this->admin_model->get_support_q_a($get_user_filter,$get_q_a_status_filter,$page,$perpage);		
			$config                = $this->pageing_model->get_config_paging();						
			$config['base_url']    = base_url().'/toad_admin/toad_admin/view_support_q_a?user='.$get_user_filter.'&filter_q_a='.$get_q_a_status_filter.'';
			$config['page_query_string'] = TRUE;
			$config['total_rows']  = count($this->admin_model->get_support_q_a($get_user_filter,$get_q_a_status_filter,$page,0));
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);
			if($this->uri->segment($config['uri_segment'])>0){
				$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
				$template_data['i']= $start+1;
			}			
			else{ 
				$start =0;
				$template_data['i'] = 1;
			}
	$data = array();
 	$data['support_data']     = $support_data;
	$data['user_filter_name'] = $get_user_filter;
	$data['q_a_status']	  = $get_q_a_status_filter;
	$data['total_ans']        = $this->admin_model->get_total_ans();
	$data['total_question']   = $this->admin_model->get_total_questions();
	$data['all_users']        = $all_users;
	$data['paging']           =  $this->pagination->create_links();
	$this->admin_template->load('admin/admin_template','admin/support',$data);
	}
	
	
	/***
	* Author: Piyush jain
	* Created : 9-5-2012
	* Function for open support answer box for view and update
	* Params  	
	*/
	function open_answer_box(){
		$q_id             = $this->input->post('q_id');
		$data 	          = array();
		$question_res     = $this->admin_model->get_question_by_qid($q_id);
		$data['q_id']     = $question_res[0]->question_id;
		$data['question'] = $question_res[0]->question;
		$data['email'] = $question_res[0]->email;
		$data['user_id'] = $question_res[0]->user_id;
		$data['username'] = $question_res[0]->firstname.' '.$question_res[0]->lastname;
		$tpl = $this->load->view('admin/support_answer_box',$data,true);
		echo json_encode(array('tpl'=>$tpl));
	}
	

	/***
	* Author: Piyush jain
	* Created : 9-5-2012
	* Function for Insert support answer
	* Params  	
	*/
	function insert_support_a(){
		$q_id   = $this->input->post('q_id');
		$ans    = $this->input->post('ans');
		$to     = $this->input->post('email');
		$username = $this->input->post('username');
		$user_id = $this->input->post('user_id');
		$question = $this->input->post('question');
		
		$result = $this->admin_model->insert_support_a(array('question_id'=>$q_id,'answer'=>$ans),$q_id);
		if($result==1){
		/*-------Email Notification to user start--------*/
		$mail_head_data=array('to'=>$to);
		$mail_body_data=array('host_name'=>$username,'question'=>$question);
			$notification_type_id = 103;
			 $notification_post_user = check_notification($user_id,$notification_type_id);
					if(!empty($notification_post_user)){ 
						if($notification_post_user[0]->email==1){ 
							$res = $this->email_template->send_email('__admin_answer_support_question_notification_to_user__',$mail_head_data,$mail_body_data);			
						}
						if($notification_post_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
						/*--sms code here--*/	
						}
					}
		/*-------Email Notification to user End--------*/
		echo  date("d F,Y h:i:s");die;
		}
	}

	/***
	* Author: Piyush jain
	* Created : 10-5-2012
	* Function for Edit support answer
	* Params  	
	*/
	function edit_support_ans($q_id,$uri_segment){
		/* get question from question id */
		$res              = $this->admin_model->get_question_by_qid($q_id);
		$data['a_id']     = $res[0]->answer_id;
		$data['question'] = $res[0]->question;
		$data['answer']   = $res[0]->answer;
		if($this->input->post('update')){
			$this->form_validation->set_rules('support_ans_update', 'support_ans_update', 'trim|required');
			$answer_update = $this->input->post('support_ans_update');
			$ans_id        = $this->input->post('update_answer_id');
			if ($this->form_validation->run() == TRUE){
				/*update support question's answer*/
				$res   = $this->admin_model->update_support_answer(array('answer'=>$answer_update),$ans_id);
				if($res==1){
				$this->session->set_flashdata('message',$this->lang->line('answer_updated_success'));
				redirect('toad_admin/toad_admin/view_support_q_a/'.$uri_segment.'');
				}
			}
			else{
				$this->session->set_flashdata('message',$this->lang->line('answer_updated_error'));
				redirect('toad_admin/toad_admin/edit_support_ans/'.$q_id.'/'.$uri_segment);
			}
		}
		if($this->input->post('cancel')){
			redirect('toad_admin/toad_admin/view_support_q_a');
		}
	$this->admin_template->load('admin/admin_template','admin/edit_support_ans',$data);
	}
	/*------*/
	
	
	/***
	* Author: Piyush jain
	* Created : 14-5-2012
	* Function for open update point box
	* Params  	
	*/
	function point_reward_box(){
		$user_id = $this->input->post('user_id');
		$data     = array();
		$data     = array('user_id'=>$user_id);
		$tpl      = $this->load->view('admin/edit_points',$data,true);
		echo json_encode(array('tpl'=>$tpl));
	}

	/***

	* Author: Piyush jain
	* Created : 14-5-2012
	* Function for Insert Reward points
	* Params  	
	*/
	function insert_reward_point(){
		$user_id   = $this->input->post('user_id');
		$point    = $this->input->post('point');
		$result = $this->admin_model->insert_reward_point(array('user_id'=>$user_id,'point'=>$point,'activity_id'=>'10'),$user_id);
		echo $result;
	}
	
	/********************************************/

	/**
	 * advertisment list
	 * Created : 30/5/2012
	 * */
	function advertisment()
	{
		//---- Check login status  -----
		if($this->login_check()) {
		
		
				/*------- Get Advertisement user list ------*/
					$user_adver = $this->admin_model->get_advertisement_users();
					$template_data['user_adver'] = $user_adver;
				/*------ End -----*/
		
				// Pagination Configuration		
			$advertisment_list = $this->admin_model->get_advertisment_list();

			// Paging configuration libary
			$config = $this->pageing_model->get_config_paging();
			
			$config['base_url'] = base_url().'toad_admin/toad_admin/advertisment/';	

			$config['total_rows'] = count($advertisment_list);

			$config['uri_segment'] = 4; 

			$this->pagination->initialize($config);

			if ( $this->uri->segment($config['uri_segment']) > 0 ) {
				$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
				$template_data['i']= $start+1;
			} else { 
				$start = 0;
				$template_data['i'] = 1;
			}


		$user_id = $this->input->post('user_id');
			if($user_id) {
				$template_data['user_selected'] = $user_id;
			} else {
				$template_data['user_selected'] = 0;
			}
						
			$template_data['paging'] =  $this->pagination->create_links();
			$template_data['advertisment'] = $this->admin_model->get_advertisment_list($start,$config['per_page']);
			$this->admin_template->load('admin/admin_template','admin/advertisment',$template_data); 

	    } else {
			redirect('toad_admin/toad_admin');
		}
	}	

	/***
	* Created : 29-5-2012
	* Function for display state status in map
	*/
	function state_map() {
			
			//---- Check login status  -----
		if($this->login_check()) {
		
			$country_id = 254;
			$start = "";
			$limit = "";
			$states = $this->admin_model->get_state_list($country_id,$start,$limit);
			$data['states'] = $states->result();
			$this->admin_template->load('admin/admin_template','admin/state_map',$data);
	    } else {
			redirect('toad_admin/toad_admin');
		}
	}

/**
 * Delete advertisment
 * Created : 30/5/2012
 * Param Delete id
 * */
function advertis_delete()
{
		//---- Check login status  -----
		if($this->login_check()) {
			$delete_id = $this->uri->segment(4);

	
		 /*------------------------------------------------------------
						Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------*/
				$user_array			 = $this->session->userdata('session_data');
				$module_name 	   = "Advertisment ";
				$module_action    = "Delete"; 
				$userId    			=	 $user_array['user_id'];

				$title 		  = $this->admin_model->get_activity_title('ox_banners','bannertext','bannerid',$delete_id);
				if(empty($title)) { $title = ""; } else { $title = $title[0]->bannertext; } 
				$module_summary   = $title;
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/					
	
					
			/*--------------------------------------------
			* Common function for delete data 
			* First parameter - delete_id  
			* Second - delete key
			* Third - table name 
			* Fourth - table type 
			---------------------------------------------*/
			$this->admin_model->delete_common($delete_id,'bannerid',"ox_banners",'custom');
			
			redirect('toad_admin/toad_admin/advertisment');
	    } else {
			redirect('toad_admin/toad_admin');
		}
}
/*--------------------------------------------
* function for view advertisment data 
* parameter - banner_id  
---------------------------------------------*/
 function advertis_view()
 {
		//---- Check login status  -----
		if ($this->login_check()) {
			$ads_id = $this->uri->segment(4);			
			$data	  = array();
			
		/*------------------------------------------------------------
					Code for Manage admin activities 
			Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		--------------------- START ----------------------------------*/
		$module_name 	   = "Advertisment";
		$module_action    = "view";
		$user_array 		=	 $this->session->userdata('session_data');
		$userId    			=	 $user_array['user_id'];
				 
		// Get title from id for Advertisment
		// pera 1 - tablename, 2 - title for display , 3 - table primary key , 4 - id 
		$title 				= $this->admin_model->get_activity_title('ox_banners','bannertext','bannerid',$ads_id);
		if(empty($title))	{	$title = ""; } else { $title = $title[0]->bannertext; }
		$module_summary   = $title;
		
		$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);
				
		/*-------------------- END -------------------------------*/		


			$data['ads_info']= $this->admin_model->get_ads_detail($ads_id);
			$data['ads_id']= $ads_id;

			$this->admin_template->load('admin/admin_template','admin/advert_view',$data);
	    } else {
			redirect('toad_admin/toad_admin');
		}
}



	/**
	 * Status change advertisment
	 * Created : 30/5/2012
	 * */
	function advertis_status()
	{
		//---- Check login status  -----
		if($this->login_check()) 
		{
			$data_id = $this->uri->segment(4);
			$update_status = $this->uri->segment(5);
		
			if($update_status==0) { $new_status = "Deactivate"; } else { $new_status = "Activate"; }

/*------------------------------------------------------------
						Code for Manage admin activities 
		 	Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		 --------------------- START ----------------------------------*/
				$user_array			 = $this->session->userdata('session_data');
				$module_name 	   = "Advertisment ";
				$module_action    = "Status Updated as ".$new_status; 
				$userId    			=	 $user_array['user_id'];

				$title 		  = $this->admin_model->get_activity_title('ox_banners','bannertext','bannerid',$data_id);
				if(empty($title)) { $title = ""; } else { $title = $title[0]->bannertext; } 
				$module_summary   = $title;
				
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/	

			
			$this->admin_model->status_ch_common($data_id,$update_status,'bannerid',"ox_banners",'custom');
			redirect('toad_admin/toad_admin/advertisment');
	    }
		else 
		{
			redirect('toad_admin/toad_admin');
		}
	}
	
/**
	 * Created : 30/5/2012
	 * Function for update age for state
	 * */
	 function age_update_box()
	 {
		 $state_id = $this->input->post('state_id');
		 $age_limit = $this->input->post('age_limit');
		 $state_name = $this->input->post('state_name');

		 
		$data     = array();
		$data['state_id']  = $state_id;
		$data['age_limit'] = $age_limit;
		$data['state_name'] = $state_name;

		
		$tpl      = $this->load->view('admin/age_update_box',$data,true);
		echo json_encode(array('tpl'=>$tpl)); 
	 }
	
	function update_age_limit()
	{
		$result = $this->admin_model->update_age_limit();
		
		$state_id 	= $this->input->post('state_id');
		
		/*------------------------------------------------------------
							Code for Manage admin activities 
			Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		--------------------- START ----------------------------------*/
			  $user_array = $this->session->userdata('session_data');
			  $userId    = $user_array['user_id'];

			 $title 		  = $this->admin_model->get_activity_title('cc_state','state_name','state_id',$state_id);
			 if(empty($title)) { $title = ""; } else { $title = $title[0]->state_name; }  

				$module_name 	   = "States age for ".$title;
				$module_action    = "Update"; 
				$module_summary   = $this->input->post('update_age');
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/							
						
						
		redirect('toad_admin/toad_admin/manage_states');
	}

	function invite_report()
	{
		$config['base_url'] = BASEURL.'toad_admin/toad_admin/invite_report';
		$config['total_rows'] = $this->admin_model->get_num_invite_report();
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$template_data = array();
		$template_data['record'] = $this->admin_model->get_invite_report($config['per_page'], $this->uri->segment(4));
		$template_data['paging'] =  $this->pagination->create_links();
		$this->admin_template->load('admin/admin_template','admin/invite_report',$template_data); 
	}
	
	function admin_manage_activity()
	{
		$config['base_url']    = BASEURL.'toad_admin/toad_admin/admin_manage_activity';
		$config['total_rows']  = $this->admin_model->get_num_manage_activity();
		$config['per_page']    = 20;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$template_data 				= array();
		$template_data['activity'] =  $this->admin_model->get_admin_activity($config['per_page'], $this->uri->segment(4));
		$template_data['paging']   =  $this->pagination->create_links();
		$this->admin_template->load('admin/admin_template','admin/admin_activity',$template_data); 
	}	
	
    
    function charity_page_list()
    {
        $template_data['page_data'] = $this->admin_model->get_charity_page_list();
        $this->admin_template->load('admin/admin_template','admin/charity_page_list',$template_data);
    }
	
    
    function approve_charity_page()
    {
        $page_id     = $this->input->post('page_id');
        $page_status = $this->input->post('page_status');
        $response = $this->admin_model->update_charity_page($page_id,$page_status);
        
        if($page_status==0) { $new_status = "Active"; } else { $new_status = "Deactivate"; }
	/*------------------------------------------------------------
							Code for Manage admin activities 
			Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		--------------------- START ----------------------------------*/
			  $user_array = $this->session->userdata('session_data');
			  $userId    = $user_array['user_id'];

			 $title 		  = $this->admin_model->get_activity_title('cc_page','page_title','page_id',$page_id);
			 if(empty($title)) { $title = ""; } else { $title = $title[0]->page_title; }  

				$module_name 	   = "Charity page";
				$module_action    = "Update as ".$new_status;      
				$module_summary   = $title;        
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/							
		        
            
        if($page_status == 0)
        {
            echo 2;die; 
        }
        else if($page_status == 1)
        {
            echo 1;die;
        }
        $this->memcached_library->flush();
        
    }
    
    function admin_manage_vulgar() {
        if($this->login_check()){
                if ($this->input->post('new_list_lang_id')) {
                    $save['update_date'] = date('Y-m-d H:i:s');
                    $save['language_id'] = $this->input->post('new_list_lang_id');
                    $this->vulgar_word_model->save($save);
                }
                
                $data['list'] = $this->vulgar_word_model->get_full_list();
                $data['all_languages'] = $this->vulgar_word_model->all_languages();
                
                $this->admin_template->load('admin/admin_template','admin/vulgare_words',$data);
        }else{
                redirect('toad_admin/toad_admin');
        }
    }
    
    function admin_vulgar($vulgar_id) {
        if($this->login_check()){
                if ($vulgar_id) {
                    if ($this->input->post('words')) {
                        $save['update_date'] = date('Y-m-d H:i:s');
                        $save['id'] = $vulgar_id;
                        $save['words'] = ' ' . $this->input->post('words') . ',';
                        $this->vulgar_word_model->save($save);
                    }
                    
                    $data['vulgar'] = $this->vulgar_word_model->get_one($vulgar_id);
                    $data['vulgar']->words = substr($data['vulgar']->words, 1);
                    $data['vulgar']->words = substr($data['vulgar']->words, 0, -1);
                    
                    $this->admin_template->load('admin/admin_template','admin/vulgare_edit',$data);
                } else {
                    redirect('toad_admin/toad_admin/admin_manage_vulgar');
                }
        }else{
                redirect('toad_admin/toad_admin');
        }
    }
    function dont_contact_emails()
    {
        if(!$this->login_check())
        {
            redirect('toad_admin/toad_admin');
        }
        $this->load->model("email_model");
        if(!empty($_POST))
        {
            $this->email_model->save_dont_contact_email($_POST);
        }
        $data['emails'] = $this->email_model->get_dont_contact_email();
        $this->admin_template->load('admin/admin_template','admin/dont_contact_emails',$data);

    }
	
    function admin_manage_reserved_names() {
        if($this->login_check()){
                if ($this->input->post('new_name')) {
                    $username = $this->input->post('new_name');
                    $result = TRUE;
                    
                    $not_reserved = $this->reserved_name_model->check_reserved($username);
                    if ($not_reserved) {
                        $this->load->model('user_model');
                        $checkUserExistance = $this->user_model->checkUsername($username);
                        if(!$checkUserExistance)
                        {	
                            $error = 'Username already exist';
                            $result = FALSE;
                        }
                    } else {
                        $error = 'Username already reserved';
                        $result = FALSE;
                    }
                    
                    if ($result) {
                        $save['username'] = $username;
                        $save['created'] = date('Y-m-d H:i:s');
                        $this->reserved_name_model->save($save);
                    } else {
                        $this->session->set_userdata(array('error' => $error, 'creating_username' => $username));
                    }
                }
                
                $data['names'] = $this->reserved_name_model->get_all();
                $this->admin_template->load('admin/admin_template','admin/reserved_names',$data);
        }else{
                redirect('toad_admin/toad_admin');
        }
    }
    
    function delete_reserved_name($id) {
        if($this->login_check()){
            $this->reserved_name_model->delete($id);
            redirect('toad_admin/toad_admin/admin_manage_reserved_names');
        } else {
            redirect('toad_admin/toad_admin');
        }
    }
    
    function availible_countries() {
        if($this->login_check()){
            $data['countries'] = $this->common_model->get_all_countries();
            $this->admin_template->load('admin/admin_template','admin/availible_countries',$data);
        } else {
            redirect('toad_admin/toad_admin');
        }
    }
    
    function change_country_availible_date() {
        if($this->login_check()){
            $id = $this->input->post('id');
            $date = $this->input->post('date');
            
            $this->common_model->update_country_availible_date($id, $date);
        }
    }
    
    function consulting_agreement() {
        if($this->login_check()){
            $this->load->model('user_model');
            
            $data['users'] = $this->user_model->get_all_for_consulting_agreement();
            $this->admin_template->load('admin/admin_template','admin/consulting_agreement',$data);
        } else {
            redirect('toad_admin/toad_admin');
        }
    }
    

    function unsubscribe() {
        if($this->login_check()){
            $this->load->model('user_model');
            $data['unsubscribe_list'] = $this->user_model->get_unsubscribed();
            $this->admin_template->load('admin/admin_template','admin/unsubscribe',$data);
        }
    }

    public function settings() {
        if($this->login_check()){
            $data['success'] = false;
            
            $this->form_validation->set_rules('old_password','Old password', 'trim|required|callback__check_pass');
            $this->form_validation->set_rules('new_password','New password','trim|min_length[6]|matches[repeat_password]|required');
            $this->form_validation->set_rules('repeat_password','Repeat password','trim|min_length[6]|required');

            if ($this->form_validation->run($this) == TRUE){
                $this->users_model->change_admin_pass($this->input->post('new_password'));
                $data['success'] = true;
            }
            
            $this->admin_template->load('admin/admin_template','admin/settings',$data);

        } else {
            redirect('toad_admin/toad_admin');
        }
    }

    function _check_pass($pass) {
        if (!$this->users_model->check_admin_pass($pass)) {
                $this->form_validation->set_message('_check_pass', 'The Old password is wrong');
                return FALSE;
        } else {
                return TRUE;
        }
    }

}//End of Class Admin
/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */
