<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
	@ this is a factory class for helper of controller 
	@@ class name "factory_"<classname>
	@@ init() method for initilise controller base and load importent library, model etc
	<<<<<<<<<<<<<<<Dhananjay>>>>>>>>>>>>>>>>>>>>>>>>
*/

class factory_account   {
	
	// to hold current language set by user 
	public   	$lang;
	// $view_data	= to hold any data related to view 
	public		$view_data	=	array('login_error_message'=>'');
	
	public 		$dob_year;
	
	public 		$dob_month;
	
	public 		$dob_day;
	
	public 		$dob;
	
	public 		$random_number;
    
	public 		$age;
	
	public 		$minor_age_limit=13;
	
	public 		$upper_age_limit=18;
	
	public 		$not_allow_to_register	=	FALSE;				
	
	public 		$allow_to_register_directly	=	FALSE;
	
	public 		$allow_to_register_with_parent	=	FALSE;	
	
	public		$data_to_process;
	
	/* Secure token for Right Signature API */
	public 	$secure_token = "tbkVy4zzm0kOPapwHG5fG16VdMdvbosWtMKjQ0sX";
	
	
			public function __construct()//constuct
			{
					$this->CI =& get_instance();
					
					$this->lang 			= $this->CI->language;
					$this->minor_age_limit	=	$this->CI->config->item('user_minor_age_limit');		
					$this->upper_age_limit	=	$this->CI->config->item('user_upper_age_limit');					
					$this->init();		
			}
			
			
			public function init(){
				// session start is used for commet chat	
				session_start();
				$this->CI->lang->load('register',$this->lang);
				$this->CI->lang->load('email',$this->lang);
				$this->CI->lang->load('template',$this->lang);
				$this->CI->load->library('parser');	
				$this->CI->load->library('point_calculation');
				$this->CI->load->library('email_template');
				$this->CI->load->library('rightsignature',$this->secure_token);
				$this->CI->load->model('user_model');
				$this->CI->load->model('user_profile');
				$this->CI->load->model('request_accept_model');
				$this->CI->load->model('admin_model');
				$this->CI->load->model('profilepage/profilepage_model');
				$this->CI->config->load('validation');		
				$this->view_data['terms']	=$this->CI->admin_model->get_page_content_by_key('__terms_of_services__',FALSE);
				$this->CI->load->model('video_model');
				$this->CI->load->helper('remote_request');
				$this->CI->config->load('utility');		
				$this->CI->load->helper('common');
			}
			
			
		 
			 /*-------*/	
			 public function check_user_name_in_look_up($username){
				$look_up_array 				= json_decode($this->CI->config->item('word'));
				$allowed_char_for_username 	= "/^[a-zA-Z0-9|_|.|-| ]+$/";
				$checkMatch 				= preg_match($allowed_char_for_username,$username);
				if($checkMatch == 0)
				return FALSE;
				for($i = 0;$i<count($look_up_array); $i++)
				{
				 $res = strstr($username,$look_up_array[$i]);
				 if($res)
					return FALSE;
				}
				return TRUE;
			 }
			
	
			
			public function get_age(){		
				
					$this->dob		=	$this->dob_year."-".$this->dob_month."-".$this->dob_day;
					
					$date_of_birth_time_stamp	=	strtotime($this->dob);
					
					$this->age = date('Y') - date('Y', $date_of_birth_time_stamp);
				    if(date('n') < date('n', $date_of_birth_time_stamp)) 
				    {
				        $this->age=--$this->age;
				    } 
				    elseif(date('n') == date('n', $date_of_birth_time_stamp)) 
				    {
				        if(date('j') < date('j', $date_of_birth_time_stamp)) 
				        {
				            $this->age=$this->age-1;
				        } 
				    } 
			}
		
			
			public function validate_age_limit(){
				if($this->age	<	$this->minor_age_limit){
					$this->not_allow_to_register			=	TRUE;
				}				
				if($this->age	>	$this->upper_age_limit)
				$this->allow_to_register_directly			=	TRUE;
				
				if($this->age	>=	$this->minor_age_limit && $this->age	<	$this->upper_age_limit){
					$this->allow_to_register_with_parent	=	TRUE;
					$this->random_number	=	md5(strtotime('Ymdhis').mt_rand());		
					$this->data_to_process->random_number	=  $this->random_number	;
				}
			}
			
			public function validate_login()	{
					$this->CI->form_validation->set_rules('login_username', 'Username', 'trim|required');
					$this->CI->form_validation->set_rules('login_password', 'Password', 'trim|required');
					if($this->CI->form_validation->run())
						return TRUE;
					else
						return FALSE;
			}
			
			public function process_login(){
						
						$login_username  	= $this->CI->input->post('login_username'); 
						$login_password  	= $this->CI->input->post('login_password');
						$ajax_msg 			= $this->CI->input->post('ajax_msg');
					
						// Condition added for ajax post  - validation
						$response	=	$this->CI->user_model->checkLogin($login_username,$login_password );
						
						if($ajax_msg==1) 
						{ 
							if(isset($response['parent_app']))
							{
									return $response['message'];
							} else { return "no"; }
						}

						
						if($response['status']){
							/*------------- call global settings helper function starts ----------------*/
								$global_setting_option = '__cloud_front_url__';
								$global_setting_url = get_global_settings($global_setting_option);
								
								$this->CI->session->set_userdata('global_setting_url', $global_setting_url);
							/*------------- call global settings helper function ends ----------------*/

							//----- check if page info exists then insert page info into page table starts ----
							$page_info_encoded = $this->CI->input->post('page_info_encoded');
							if(isset($page_info_encoded) && $page_info_encoded!=''){
								// call page model here
								$this->CI->profilepage_model->save_page_info();
							}
							//------ page insert ends -----
						
							redirect($response['redirect']);
						}else{
						
							if($response['redirect'] || $this->CI->input->post('linkfb')){								
									$this->CI->session->set_flashdata('login_error_message',$response['message']);
									if($this->CI->input->post('linkfb')){
										$this->CI->session->set_flashdata('fblogin_error_message',$response['message']);
										redirect(BASEURL.'account/link_fb');
									}else{
										redirect($response['redirect']);
									}
							}
							$this->view_data['login_error_message']	=	$response['message'];
						}
			}
			
			
			
			
			
			
			public function process_registration(){
                                $this->random_number = rand(1,99999);
                                $this->email_verify_code = base64_encode(rand(1,99999));
                                        
                                $save['username'] = $this->CI->input->post('username');
                                $save['password'] = sha2($this->CI->input->post('password'));
                                $save['firstname'] = $this->CI->input->post('firstname');
                                $save['lastname'] = $this->CI->input->post('lastname');
                                $save['email'] = $this->CI->input->post('email');
                                $save['sex'] = $this->CI->input->post('sex');
                                $save['parent_email'] = $this->CI->input->post('parent_email');
                                $save['parent_id'] = $this->CI->input->post('parent_id');
                                //$save['random_number'] = $this->CI->input->post('random_number');
                                $save['random_number'] = $this->random_number;
                                $save['created_at'] = date('Y-m-d H:i:s');
                                $save['user_ip'] = $_SERVER['REMOTE_ADDR'];
                                $save['account_type'] = $this->CI->input->post('account_type');
                                
                                if ($this->CI->input->post('account_type') == 1) {
                                    $save['dob'] = $this->dob;
                                } else {
                                    $save['dob'] = date('Y-m-d');	
                                    $save['business_name'] = $this->CI->input->post('business_name');
                                    $save['ein'] = $this->CI->input->post('ein');
                                }
                                
                                $options['request_type'] = $this->view_data['request_type'];
                                $options['invite_id'] = $this->view_data['invite_id'];
                                $options['fullname'] = $save['firstname'].' '.$save['lastname'];
                                
                                $result = $this->CI->user_model->register($save, $options);
                                
                                $account_holder_name = $options['fullname'];
                                $mail_body_data	= array(
                                    "full_name"=>$account_holder_name,
                                    "child_name"=>$account_holder_name,
                                    "email_verification_link"=>BASEURL."account/verify_user_email/".$this->email_verify_code,
                                    "password"=>$save['password'],
                                    "username"=>$save['username']
                                    );
                                
                                $mail_head_data	= array('to'=>$save['email']);
                                
                                /*------------------*/
                                $email_template_key_sup="__";
                                /*------------------*/
                                
                                if ($save['parent_email'] != '') {
                                    $email_key = '__account_register_parent_verification'.$email_template_key_sup;
                                    $mail_head_data['to'] = $save['parent_email'];
                                    $mail_body_data['full_name'] = $account_holder_name;
                                    $mail_body_data['link'] = BASEURL."account/parent_approval/".base64_encode($this->random_number);
                                    //$mail_body_data['parent_consent_form_link'] = BASEURL."account/parent_consent_form";
									$res1 = $this->CI->email_template->send_email($email_key,$mail_head_data,$mail_body_data);

                                    /**************Email to child for register successfully*****************/
                                    $email_key1	= '__account_register_notification_to_child__';
                                    $mail_head_data1['to'] = $save['email'];
                                    $mail_body_data1['full_name']=$account_holder_name;
									$res1 = $this->CI->email_template->send_email($email_key1,$mail_head_data1,$mail_body_data1);
                                    /**************Email to child for register successfully*****************/

//                                    $response = $this->CI->rightsignature->getDocuments($mail_head_data['to'],$document_url);	 
                                } else {
                                    $email_key='__account_register_confirmation'.$email_template_key_sup;
                                }
                                    
                                $res=$this->CI->email_template->send_email($email_key,$mail_head_data,$mail_body_data);
                                /*------------------------------------------------------------------------------------*/
                                //$this->CI->point_calculation->add_point($result,'registration',$result);

                                // divide bonus point to all inviters (task #2390)
                                $invitations  = is_invitation(); // call helper function
                                $point_distribute = 100/count($invitations); // set how much point distribute to each inviter
                                
                                foreach($invitations as $invitations_obj)
                                { 
                                    $this->CI->point_calculation->add_point($invitations_obj->user_id,$this->CI->config->item('_activity_bonus_point_'),0,$this->CI->session->userdata('user_user_id'),$point_distribute);
                                }
						
                                redirect(BASEURL.'create_profile');
			}
			
			public function load_view($view='register'){
				$this->view_data['invite_id']					= 	$this->CI->input->post('invite_id');
				$this->view_data['parent_id_encoded']			= 	$this->CI->input->post('parent_id');
				$this->view_data['request_type']				= 	$this->CI->input->post('request_type');
				$this->CI->template->load('template', $view,$this->view_data);
			}
}
