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
	
	
			public function __construct()
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
				$this->CI->load->model('user_model');
				$this->CI->load->model('user_profile');
				$this->CI->load->model('request_accept_model');
				$this->CI->load->model('admin_model');
				$this->CI->config->load('validation');		
				$this->view_data['terms']	=$this->CI->admin_model->get_page_content_by_key('__terms_of_services__',FALSE);
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
						
						$response	=	$this->CI->user_model->checkLogin($login_username,$login_password );
						if($response['status']){
							redirect($response['redirect']);
						}else{
							if($response['redirect']){
									$this->CI->session->set_flashdata('login_error_message',$response['message']);
									redirect($response['redirect']);
							}
									$this->view_data['login_error_message']	=	$response['message'];
						}
			}
			
			
			public function process_registration(){

//                                         $question= $this->CI->input->post('question');
//                                
//                                if($this->CI->input->post('question1'))
//                                         $question.=','.$this->CI->input->post('question1');
//
//                                  if($this->CI->input->post('question2'))
//                                         $question.=','.$this->CI->input->post('question2');

				$this->data_to_process = new stdClass;
				$this->data_to_process->username	=	$this->CI->input->post('username');
				$this->data_to_process->password	=	$this->CI->input->post('password');
				$this->data_to_process->firstname	=	$this->CI->input->post('firstname');
				$this->data_to_process->lastname	=	$this->CI->input->post('lastname');
				$this->data_to_process->email		=	$this->CI->input->post('email');
				$this->data_to_process->sex			=	$this->CI->input->post('sex');				
				$this->data_to_process->answer		=	'no123123123';
//                                $this->data_to_process->answer1		=	$this->CI->input->post('answer1');
//                                $this->data_to_process->answer2		=	$this->CI->input->post('answer2'); 
				$this->data_to_process->timezones	=	$this->CI->input->post('timezones');
				$this->data_to_process->parent_email    =	$this->CI->input->post('parent_email');
//				$this->data_to_process->security_question	= $question;				
				$this->data_to_process->parent_id	=	$this->view_data['parent_id'];
				$this->data_to_process->invite_id	=	$this->view_data['invite_id'];
				$this->data_to_process->request_type=	$this->view_data['request_type'];
				$this->data_to_process->fullname	=	$this->data_to_process->firstname.' '.$this->data_to_process->lastname;		
				$this->data_to_process->check_password_for_email	=	$this->CI->input->post('check_password_for_email');	
                                
                                if ($this->CI->input->post('account_type') == 1) {
                                    $this->data_to_process->dob = $this->dob;		
                                } else {
                                    $this->data_to_process->dob = date('Y-m-d');	
                                }
                                
                                $this->data_to_process->random_number			=	$this->random_number;		
				$this->data_to_process->allow_to_register_directly			=	$this->allow_to_register_directly;		
				$this->data_to_process->created_at	=	date('Y-m-d H:i:s');
				$result 	   						= 	$this->CI->user_model->register($this->data_to_process);
				
				
				if($result > 0) 
				{	
						$account_holder_name	=	$this->data_to_process->fullname;
						$mail_body_data	= 	array(
												"full_name"=>$account_holder_name,
												"child_name"=>$account_holder_name,
												"password"=>$this->data_to_process->password,
												"username"=>$this->data_to_process->username,
												"verification_link"=>BASEURL."account/parent_approval/".base64_encode($this->random_number)
												);
						$mail_head_data	=	array('to'=>$this->data_to_process->email);
						/*------------------*/
						if($this->data_to_process->check_password_for_email){
							$email_template_key_sup="_with_password__";
						}
						else
							$email_template_key_sup="__";
						
						/*------------------*/
						if($this->allow_to_register_with_parent){
							$email_key	='__account_register_parent_verification'.$email_template_key_sup;
							$mail_head_data['to']  			= $this->data_to_process->parent_email;
							$mail_body_data['full_name']	= $account_holder_name;
                            $mail_body_data['link']	= BASEURL."account/parent_approval/".base64_encode($this->random_number);
						}
						else{
							$email_key='__account_register_confirmation'.$email_template_key_sup;
						}
						$this->CI->email_template->send_email($email_key,$mail_head_data,$mail_body_data);
						/*------------------------------------------------------------------------------------*/
						$this->CI->point_calculation->add_point($result,'registration',$result);
						
						redirect(BASEURL.'create_profile');
					}else{
							
					}
			}
			
			public function load_view($view='register'){
				$this->view_data['invite_id']					= 	$this->CI->input->post('invite_id');
				$this->view_data['parent_id_encoded']			= 	$this->CI->input->post('parent_id');
				$this->view_data['request_type']				= 	$this->CI->input->post('request_type');
				$this->CI->template->load('template', $view,$this->view_data);
			}
}
