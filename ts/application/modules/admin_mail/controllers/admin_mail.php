<?php
/**
 * Chatching report Controller Class
 * Manage content reports etc
 * @category	Controller
 * @author		CDN Solutions
 */
class Admin_mail extends MX_Controller
{
		//Constructor
		function __construct()
		{
		parent::__construct();
		//Load the report model
		$this->load->model('mail_model');

		date_default_timezone_set('Asia/Calcutta');
		$language = 'english';
		if($this->session->userdata('language')){
			$language = $this->session->userdata('language');
		}
		$this->load->model('admin_users/users_model');
		$this->load->model('admin_model');
		$this->load->language('admin_template');
		$this->load->library('admin_template');
		$this->load->library('pagination');
		$this->load->model('user_profile');		
		$this->load->helper('common' );
		$this->load->library('email');

	
		$this->load->model('admin_paging/pageing_model'); // Added by lalit - User for get user model		

		}
		
	/**
	* Author Lalit
	* Function for Send emails to User and Employee
	* Created : 9-5-2012	
	*/
	function index()
	{
	
		if($this->login_check()) {
		$template_data['data'] = "test";
			$this->admin_template->load('admin/admin_template','email_send',$template_data);
		}else{
			redirect('admin/admin');		
		}	
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

	/**
	* Author Lalit
	* Params activation value
	* Created : 9-5-2012	
	*/
	function create_message()
	{
		$user_type = $this->input->post('user_type');
		$template_data['user_type'] = $user_type;
		$str 	  =  $this->load->view('create_message',$template_data,true);
		echo $str;
	}

/**
	* Author Lalit
	* Function for send email to user all and custom
	* Params activation value
	* Created : 9-5-2012	
	*/
	function admin_mail_send()
	{
	      //---- Check login status  -----
		if($this->login_check()) {

			$send_type = $this->input->post('send_type'); // Send type - ALL / CUSTOME
			$user_type = $this->input->post('user_type'); // User type - USER / EMPLOYEE

			if($send_type=='all')
			{
				/*---------------------------------------
			    	     Function for send mail to all users 
				------------------------------------------*/
				if($user_type=="users")
				{
					$type="NOTIN";
					//---------- Mail will send to all site users ----------//
					//Need to create a function which able to send mail to all users
					 foreach($this->input->post('chk') as $key=>$val) {
						/*----------- Get email address by user id ------------*/
							
						$email_address = $this->users_model->get_email_address($val,$type);
		
						/*------------ Send email to user by email-address -------------*/
						$send_email    = $this->user_model->send_email_address($email_address);
					 } 

				} else {
					//Need to create a function which able to send mail to all members
				}

			}

			// Condition wil be check to send mail custom to user or employee
			if($send_type=="custom") 
			{
				/*---------------------------------------------------
				    	     Mail send to user by custom 
				-----------------------------------------------------*/
					// Need to create another template which have all user in alphabetic A-Z order 
					$template_data['user_type'] = $user_type;
			
					//  Get data according to user character 
					$users_list 	        = 	$this->users_model->get_users_by_word();

					// Paging configuration libary
					$config 	        = 	$this->pageing_model->get_config_paging();
					$config['base_url'] 	=	 base_url().'admin_mail/search_members/'.$user_type.'/A/';
					$config['total_rows']   = 	$users_list->num_rows();
					$config['uri_segment']  = 	5;
					$this->pagination->initialize($config);

					if ( $this->uri->segment($config['uri_segment']) > 0 ) {
						$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
						$template_data['i']= $start+1;
					} else { 
						$start = 0;
						$template_data['i'] = 1;
					}
					$template_data['paging'] =  $this->pagination->create_links();

					// Get user list data and assing with pagination variables 
					$template_data['users'] = $this->users_model->get_users_by_word($start,$config['per_page'])->result();

					$this->admin_template->load('admin/admin_template','send_mail_custom',$template_data);
			}
		} else {
			// Redirect to home
			redirect('admin/admin');		
		}
	}

	function search_members()
	{
		//---- Check login status  -----
		if($this->login_check()) {
	
			/** ----- Get data according to user character ----- **/
			$user = $this->uri->segment(4);
			$searchFilter='';
			$segment=4;
			if(!is_numeric($user)) { 
				$user 	=      $this->uri->segment(5); 
				$searchFilter 	=      $this->uri->segment(4); 
				$segment=5;
			}


			$users_list 	=	 $this->users_model->get_users_by_word();
			
			// Pagination Configuration ----		
			$config     	      = 	$this->pageing_model->get_config_paging();
			$config['base_url']   = 	base_url().'/admin_mail/search_members/'.$this->uri->segment(3).'/'.($searchFilter==''?'':$searchFilter.'/');

			$config['total_rows'] = 	$users_list->num_rows();

			 $config['uri_segment'] = $segment;

			$this->pagination->initialize($config);

			$template_data['type_proccess'] =  $this->uri->segment(3);
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
			$this->admin_template->load('admin/admin_template','user_mail_list',$template_data);

		} else {
			redirect('admin/admin');
		}
	}

/**
	* Authore : Lalit
	* Created : 10/05/2012
	* Create members mailing list in csv , xls or txt formate
	*/	
	function admin_mailing_creat()
	{
		  //---- Check login status  -----
		if($this->login_check()) {
			$template_data['mailing'] = "mailing";
			$template_data['user_type'] = "Mailing";

			/* Display User list which started by word A list */

			// Get data according to user character
			$users_list = $this->users_model->get_users_by_word();

			// Pagination Configuration		
			$config     		= 	$this->pageing_model->get_config_paging();
			$config['base_url'] 	=	 base_url().'admin_mail/admin_mailing_creat/Mailing/A/';
			$config['total_rows'] 	= 	$users_list->num_rows();
			$config['uri_segment']  = 	5;

			$this->pagination->initialize($config);

				if ($this->uri->segment($config['uri_segment']) > 0) {
					$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
					$template_data['i']= $start+1;
				} else { 
					$start = 0;
					$template_data['i'] = 1;
				}
			
			$template_data['paging'] =  $this->pagination->create_links();

			// Get user list data and assing with pagination variables 
			$template_data['users'] = $this->users_model->get_users_by_word($start,$config['per_page'])->result();

			$this->admin_template->load('admin/admin_template','send_mail_custom',$template_data);
		} else {
			// Redirect to home
			redirect('admin/admin');		
		}
	}

/**
	* Author Lalit
	* Function for create csv
	* Created : 9-5-2012	
	*/
	function create_mailing_list()
	{
		$str 	   = "";
		$send_type = $this->input->post('send_type');

		if($this->input->post('chk'))
			{
				
		// Create email ids list for get email address
		foreach($this->input->post('chk') as $key=>$val) { 
			 $str .= $val.","; 
		}
		$emails    = substr($str,0,-1);

		// Get email address ARRAY by user id
		$type 	       =   "IN";
		$email_address = $this->users_model->get_email_address($emails,$type); 


		/*---------------- Condition - 1  --------------------
		  If ADMIN want to create CSV file of email list 
		--------------------------------------------------*/
		if($send_type=='CSV')
		{
			/*-----------	Formate of CSV  ---------------*/
			  header("Content-type:text/octect-stream");
			  header("Content-Disposition:attachment;filename=data.csv");

			for($counter=0;$counter<count($email_address);$counter++)
			{
	 		       print '"'.$email_address[$counter]->email."\"\n";
			}exit;
		  }


		/*---------------- Condition - 2  --------------------
		  If ADMIN want to create XLS file of email list 
		--------------------------------------------------*/
		if($send_type=="XLS")
		{
			/*----------    Formate of XLS    ----------------*/
			header ( "Content-type: application/vnd.ms-excel" );
			header ( "Content-Disposition: attachment; filename=data.xls" );

			for($counter=0;$counter<count($email_address);$counter++)
			{
	 		       print '"'.$email_address[$counter]->email."\"\n";
			}exit;
		}	

		/*---------------- Condition - 3  --------------------
		  If ADMIN want to create Txt file of email list 
		--------------------------------------------------*/
		if($send_type=="Txt")
		{
			/*-----------	Formate of CSV  ---------------*/
			  header("Content-type:text/text-stream");
			  header("Content-Disposition:attachment;filename=data.txt");

			for($counter=0;$counter<count($email_address);$counter++)
			{
	 		       print '"'.$email_address[$counter]->email."\"\n";
			}exit;
		}	

	} else {
			$this->session->set_flashdata('error_message', 'Please select checkbox');
			redirect('admin_mail/admin_mailing_creat');
	}
	
	}
	
		/**
	* Author Lalit
	* Function for create mail box
	* Created : 14 - 5 -2012
	*/
	function create_mail_box()
	{
	//---- Check login status  -----
		if($this->login_check()) {

		$template_data['email_ids'] = substr($this->input->post('email_ids'),0,-1);
		$str 	  =  $this->load->view('admin_mail_box',$template_data,true);
		echo $str;
	         } else {
			redirect('admin/admin');
		}
	}

	function send_email_advert(){
		$data=array();
		$data['email_id']=$this->input->post('email_id');
		$loggedData=$this->session->userdata('session_data');
		//$data['email_info']=$this->mail_model->send_mail($data['email_id']);
		
		$list_tpl = $this->load->view('advert_mail',$data,true);
		echo json_encode(array('tpl'=>$list_tpl));
	}
	
	function send_advertMail()
	{
		$data=array();
		$data['from']=$this->input->post('from');
		$data['fromname']=$this->input->post('fromname');
		$data['email_id']=$this->input->post('email_id');
		$data['subject']=$this->input->post('subject');
		$data['content']=$this->input->post('content');
		send_email($data['from'],$data['fromname'],$data['email_id'],$data['subject'],$data['content']);
		
			/*------------------------------------------------------------
							Code for Manage admin activities 
			Advertise ( Admin name ) update ( module action ) page ( module name ) ( summary )on date ( create date) 
		--------------------- START ----------------------------------*/
				$user_array = $this->session->userdata('session_data');
				$userId    = $user_array['user_id'];
				$module_name 	   = "";
				$module_action    = "Mail send to"; 
				$module_summary   = $this->input->post('email_id');
				$activity_result  = $this->admin_model->manage_activity($userId,$module_name,$module_summary,$module_action);		
		/*-------------------- END -------------------------------*/							
					
					
	}

	function qualified_members_list()
	{
		  //---- Check login status  -----
		if($this->login_check()) {
			

			/* Display User list which started by word A list */

			// Get data according to user character
			$word	  	 =  $this->uri->segment(3);
			$users_list = $this->users_model->get_qualified_users_by_word($word);
			if(!$word){
				$word = "A";
			}
			// Pagination Configuration		
			$config     		= 	$this->pageing_model->get_config_paging();
			$config['base_url'] 	=	 base_url().'admin_mail/qualified_members_list/'.$word;
			$config['total_rows'] 	= 	$users_list->num_rows();
			$config['uri_segment']  = 	4;

			$this->pagination->initialize($config);

				if ($this->uri->segment($config['uri_segment']) > 0) {
					$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
					$template_data['i']= $start+1;
				} else { 
					$start = 0;
					$template_data['i'] = 1;
				}
			
			$template_data['paging'] =  $this->pagination->create_links();

			// Get user list data and assing with pagination variables 
			$template_data['users'] = $this->users_model->get_qualified_users_by_word($word,$start,$config['per_page'])->result();

			$this->admin_template->load('admin/admin_template','qualified_members_list',$template_data);
		} else {
			// Redirect to home
			redirect('admin/admin');		
		}
	}

	function nonqualified_members_list()
	{
		  //---- Check login status  -----
		if($this->login_check()) {
			

			/* Display User list which started by word A list */

			// Get data according to user character
			$word	  	 =  $this->uri->segment(3);
			$users_list = $this->users_model->get_nonqualified_users_by_word($word);
			if(!$word){
				$word = "A";
			}
			// Pagination Configuration		
			$config     		= 	$this->pageing_model->get_config_paging();
			$config['base_url'] 	=	 base_url().'admin_mail/nonqualified_members_list/'.$word;
			$config['total_rows'] 	= 	$users_list->num_rows();
			$config['uri_segment']  = 	4;

			$this->pagination->initialize($config);

				if ($this->uri->segment($config['uri_segment']) > 0) {
					$start = ($this->uri->segment($config['uri_segment'])-1)*$config['per_page'];
					$template_data['i']= $start+1;
				} else { 
					$start = 0;
					$template_data['i'] = 1;
				}
			
			$template_data['paging'] =  $this->pagination->create_links();

			// Get user list data and assing with pagination variables 
			$template_data['users'] = $this->users_model->get_nonqualified_users_by_word($word,$start,$config['per_page'])->result();

			$this->admin_template->load('admin/admin_template','nonqualified_members_list',$template_data);
		} else {
			// Redirect to home
			redirect('admin/admin');		
		}
	}

	function send_bulk_mail(){
		$this->load->library('test_amazonses');
		$send_type = $this->input->post('send_type');
		$is_qualified = $this->input->post('user_type');
		if($send_type == "Send All"){
			$userEmails = $this->users_model->get_users_email('ALL',$is_qualified);
		}else{
			if($this->input->post('chk'))
			{	
				$ids = $this->input->post('chk');
				
				$userEmails = $this->users_model->get_users_email('',$is_qualified,$ids);
			}
		}
		
		foreach($userEmails as $usrArr){
			/*amazon ses mail send*/
			
			
        
			/*end of amaozon ses send mail*/
			$email_key = '__account_register_parent_verification__with_password__';
			$mail_head_data['to'] = $usrArr['email'];
			$mail_body_data['full_name'] = $usrArr['firstname']." ".$usrArr['lastname'];
			$res = $this->test_amazonses->send_email_template($email_key,$mail_head_data,$mail_body_data);
			if($is_qualified)
				redirect('admin_mail/qualified_members_list');
			else
				redirect('admin_mail/nonqualified_members_list');
		}
		

	}
}