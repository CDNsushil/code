<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User controller for the users module (frontend)
 *
 * @author		 Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Controllers
 */
class Users extends Public_Controller
{
	/**
	 * Constructor method
	 *
	 * @return \Users
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->helper('cookie');
		$this->load->model('user_m');
		
		
		$this->lang->load('user');
		$this->load->library('form_validation');
		$this->load->library('payments_pro');

		$this->load->helper('captcha');
		
		$this->template->append_css('module::user.css');
		//check for merchant membership expiry date

		
		$userGroup=userGroup();
		if($userGroup==3){
			checkExpiryMemberhipDate();
		}
			
			
	}

	/**
	 * Show the current user's profile
	 */
	public function index()
	{
		//prevent access of admin
		$userGroup=userGroup(); 
		if($userGroup==1){
			redirect('');
		}
		
		if (isset($this->current_user->id))
		{
			$this->view($userGroup);
		}
		else
		{
			redirect('users/register');
		}
		
	}
	
	
	function home()
	{
		 $this->template->build('home');
	}
	/**
	 * View a user profile based on the username
	 *
	 * @param string $username The Username or ID of the user
	 */
	public function view($username = null)
	{
		
		// work out the visibility setting
		switch (Settings::get('profile_visibility'))
		{
			case 'public':
				// if it's public then we don't care about anything
				break;

			case 'owner':
				// they have to be logged in so we know if they're the owner
				$this->current_user or redirect('users/login/users/view/'.$username);

				// do we have a match?
				$this->current_user->username !== $username and redirect('404');
				break;

			case 'hidden':
				// if it's hidden then nobody gets it
				redirect('404');
				break;

			case 'member':
				// anybody can see it if they're logged in
					
				$this->current_user or redirect('users/login/users/view/'.$username);
				break;
		}

		// Don't make a 2nd db call if the user profile is the same as the logged in user
		if ($this->current_user && $username === $this->current_user->username)
		{
			$user = $this->current_user;
		}
		// Fine, just grab the user from the DB
		else
		{
			$user = $this->ion_auth->get_user($username);
		
		}

		// No user? Show a 404 error
		$user or show_404();
		
	
		
		$data['memberships']=$this->user_m->getMemberships();
		$data['_user']=$user;
		$membership=$this->user_m->getCurrentUserMemberships();
	
		$data['userMembership']=$membership;
		//get logged in user payment details 
		$payment=$this->user_m->getUserPaymentDetails();
		if(!empty($payment)){
			$regi_date=$payment->created_at;
			
			if(!empty($membership)){
				$mDay=$membership->membership_days;
				//to calcualte expire date
				 $date=strtotime($regi_date);  
				 $data['expiryDate'] = date('d M Y',strtotime('+'.$mDay.' days',$date)); 
			}
			
			
			$currentDate=date('Y-m-d');
			$regisDate=date('Y-m-d',strtotime($data['expiryDate']));
			$data['daysDiff']=$this->common_model->datedaydifference($currentDate,$regisDate);
		
		
		}
		
	
		 $this->template->build('profile/view', $data);
	}
	/**
	 *Login for Merchant
	 */
	public function login_m()
	{
		//prevent access 
		$userId=is_logged_in(); 
		if($userId){
			redirect('');
		}
		
		$memId='';
		// Get the user data
		$user = (object) array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),

		);  

		$validation = array(
		array(
			'field' => 'email',
			'label' => lang('global:email'),
			'rules' => 'required|trim|callback__check_login'
		),
		array(
			'field' => 'password',
			'label' => lang('global:password'),
			'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'
		), 
		
		);
	
		// Set the validation rules
		$this->form_validation->set_rules($validation);
		if($_POST){
			$memId=$this->input->post('memId');	
		}
		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() or $this->current_user)
		{
				//get user by email and group id
				 $userBlock=$this->ion_auth->get_user_by_email($user->email,'3');
				
				if(!empty($userBlock) && $userBlock->group_id==2){
					//check for affiliate user only
					$this->ion_auth->logout();
					if (!$this->input->is_ajax_request()){
							
							set_global_messages(lang('user:unauthorized_access'),'error');
							redirect('register/id/'.encode($memId));
					}	
				}
				if(!empty($userBlock) && $userBlock->user_block==0){
					if($this->input->post('remember_user')){
						$rememberCode=encode($userBlock->email).'_'.encode($this->input->post('password'));
						setcookie('muser', $rememberCode, time() + (86400 * 30), "/");
					}else{
						setcookie("muser", "", time()-3600,"/");
					}
					 set_global_messages(lang('user:logged_in'),'success');
					 redirect('merchant/dashbord');
				}else if($userBlock->user_block==1){
						//allow third party devs to do things right before the user leaves
						$this->ion_auth->logout();
						if (!$this->input->is_ajax_request()){
								set_global_messages(lang('user:user_block_msg'),'error');
								redirect('register/id/'.encode($memId));
						}	
				 } 
		
			// Don't allow protocols or cheeky requests
			
		}else{
			
			set_global_messages(lang('user:invalid_user_pass'),'error');
			redirect('register/id/'.encode($memId));
		}

		
	}

	/**
	 *Login for affiliate
	 */
	public function login()
	{
		//echo get_cookie('ruser'); die;
		// Get the user data
		//prevent access 
		$userId=is_logged_in(); 
		if($userId){
			redirect('');
		}
	
		$bannerId='';
		$user = (object) array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);

		$validation = array(
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'required|trim|callback__check_login'
			),
			array(
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'
			),
		);
		
		if ($_POST){
			 $bannerId=$this->input->post('banner_id');
			
		}
	
		// Set the validation rules
		$this->form_validation->set_rules($validation);
		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() or $this->current_user)
		{
			// Kill the session
			$this->session->unset_userdata('redirect_to');
	
			// trigger a post login event for third party devs
			Events::trigger('post_user_login');
			
			if ($this->input->is_ajax_request())
			{
				$user = $this->ion_auth->get_user_by_email($user->email);
				
				$user->password = '';
				$user->salt = '';
				
				exit(json_encode(array('status' => true, 'message' => lang('user:logged_in'), 'data' => $user)));
			}
			else
			{
				//get user by email and group id
				 $userBlock=$this->ion_auth->get_user_by_email($user->email,2);
				
				if(!empty($userBlock) && $userBlock->group_id==3){
					//check for affiliate user only
					$this->ion_auth->logout();
					if (!$this->input->is_ajax_request()){
							$this->session->set_flashdata('error', lang('user:unauthorized_access'));
							redirect('register');
					}	
				}
		
				if(!empty($userBlock) && $userBlock->user_block==0){
					
					if($this->input->post('remember_user')){
						$rememberCode=encode($userBlock->email).'_'.encode($this->input->post('password'));
						//set_cookie('ruser',$rememberCode);
						
						setcookie('ruser', $rememberCode, time() + (86400 * 30), "/");
						//echo $_COOKIE[$cookie_name];

					    //die;
					}else{
						setcookie("ruser", "", time()-3600,"/");
					}
					 $banner_id = escape_tags(decode($this->input->post('banner_id')));
					 $bannerExist=$this->common_model->getDataFromTabel('affiliate_banner_log','*',array('affiliate_id'=>$userBlock->id,'banner_id'=>$banner_id));
					if(empty($bannerExist)){
						 if(!empty($banner_id)){
							$this->user_m->saveAffiliateBannerLog(array('banner_id'=>$banner_id,'affiliate_id'=>$userBlock->id));
						 }
					}
					 $this->session->set_flashdata('success', lang('user:logged_in'));
				}else if($userBlock->user_block==1){
						//allow third party devs to do things right before the user leaves
						$this->ion_auth->logout();
						if (!$this->input->is_ajax_request()){
								$this->session->set_flashdata('error', lang('user:user_block_msg'));
								if($bannerId!=''){
									
									redirect('register/banner_id/'.$bannerId);
								}else{
									redirect('register');
								}
						}	
				}
			}

			redirect('users/my-profile');
			
		}else{
			$this->session->set_flashdata('error', lang('user:invalid_user_pass'));
		
			if($bannerId!=''){
				redirect('register/banner_id/'.$bannerId);
			}else{
				redirect('register');
			}
		}
		

	}

	/**
	 * Method to log the user out of the system
	 */
	public function logout()
	{
		// allow third party devs to do things right before the user leaves
		Events::trigger('pre_user_logout');

	   $this->ion_auth->logout();

		if ($this->input->is_ajax_request())
		{
			
			exit(json_encode(array('status' => true, 'message' => lang('user:logged_out'))));
		}
		else
		{
		
			$this->session->set_flashdata('success', lang('user:logged_out'));
			redirect('');
		}
	}

	/**
	 * Method to register a new user
	 * Param: membership Id
	 */
	public function register($id = '')
	{
		$membershipId='';
		$membership_type='';
		$group_id='2'; //set merchant user by default
		
		$data = array();
		$banner = $this->uri->segment(2);
		$banner_id = '';
		$userId=is_logged_in();
		
		if($banner=='banner_id'){
			$banner_id = decode($id);
			$id = '';
		}
		if ($this->current_user)
		{
			
			if(!empty($banner_id) && $group_id==2){
				$bannerExist=$this->common_model->getDataFromTabel('affiliate_banner_log','*',array('affiliate_id'=>$userId,'banner_id'=>$banner_id));
				if(empty($bannerExist)){
					$this->user_m->saveAffiliateBannerLog(array('banner_id'=>$banner_id,'affiliate_id'=>$userId));
				}
				redirect('affiliate/banners');
			}else{
				 $this->session->set_flashdata('error', lang('user:already_logged_in'));
				 redirect();
				}
		}
		// Captcha parameters:
		$captchaConfig = array(
		  	'CaptchaId' => 'LoginCaptcha', // a unique Id for the Captcha instance
		  	'UserInputId' => 'CaptchaCode' // Id of the Captcha code input textbox
		);
		// load the BotDetect Captcha library
		$this->load->library('captchahandler/botdetect/BotDetectCaptcha', $captchaConfig);

		// make Captcha Html accessible to View code
		$data['captchaHtml'] = $this->botdetectcaptcha->Html();
		
		
		if($id!=''){
			$membershipId=decode($id); 
			$group_id=3;
		}
			

		/* show the disabled registration message */
		if (! Settings::get('enable_registration'))
		{
			$this->template
				->title(lang('user:register_title'))
				->build('disabled');
			return;
		}

		// Validation rules
		$validation = array(
			array(
				'field' => 'first_name',
				'label' => lang('user:first_name'),
				'rules' => 'required|max_length[60]',
			),
			array(
				'field' => 'last_name',
				'label' => lang('user:last_name'),
				'rules' => 'max_length[60]|required',
			),
			array(
				'field' => 'password',
				'label' => lang('user:password'),
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'
			),
			array(
				'field' => 'email',
				'label' => lang('user:email'),
				'rules' => 'required|max_length[150]|valid_email|callback__email_check',
			),
				array(
				'field' => 'phone',
				'label' => lang('user:phone'),
				'rules' => 'required|max_length[13]'
			),
			array(
				'field' => 'company_name',
				'label' => lang('user:company_name'),
				'rules' => 'trim|max_length[150]'
			),
			array(
				'field' => 'domain_name',
				'label' => lang('user:website_address'),
				'rules' => 'trim|max_length[250]'
			),
			array(
				'field' => 'sex',
				'label' => lang('user:sex'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'address',
				'label' => lang('user:address'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'date_of_birth',
				'label' => lang('user:date_of_birth'),
				'rules' => 'trim|required'
			),
			
			array(
				'field' => 'CaptchaCode',
				'label' => lang('user:CaptchaCode'),
				'rules' => 'trim|required|max_length[10]'
			),
			array(
				'field' => 'confirm_password',
				'label' => lang('user:confirm_password'),
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'

			),
			array(
				'field' => 'membership_type',
				'label' => lang('user:membership_type'),
				'rules' => 'trim|'
			),
			array(
				'field' => 'term_condition',
				'label' => lang('user:term_condition'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'direct_deposit',
				'label' => 'Direct Deposit',
				'rules' => 'trim|required'
			),
		
		);
		
		// --------------------------------
		// Merge streams and users validation
		// --------------------------------
		// Why are we doing this? We need
		// any fields that are required to
		// be filled out by the user when
		// registering.
		// --------------------------------

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

		// Remove display_name
		foreach ($profile_validation as $key => $values)
		{
			if ($values['field'] == 'display_name')
			{
				unset($profile_validation[$key]);
				break;
			}
		}

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($validation, $profile_validation));

		// Get user profile data. This will be passed to our
	
		// the register form
		$profile_data = array();


		// --------------------------------

		// Set the validation rules
		$this->form_validation->set_rules($validation);

		$user = new stdClass();

		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$user->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}

		// Are they TRYing to submit?
		if ($_POST)
		{
			
			// captcha code input field is required
			$this->form_validation->set_rules('CaptchaCode', 'Captcha Code', 'required');
		
			$cap=$this->session->userdata('cap_word'); 
			$capWord=$this->input->post('captcha_code'); 
			$group_id = $this->input->post('group_id'); 
			if($group_id==3){
				$this->form_validation->set_rules('membership_type',lang('user:membership_type'),'trim|required|');
				$this->form_validation->set_rules('domain_name',lang('user:website_address'),'trim|required|');
				
			}
			$membershipId = escape_tags($this->input->post('membershipId'));
			$membership_type = escape_tags($this->input->post('membership_type')); 
			if ($this->form_validation->run())
			{
					// validate the user-entered Captcha code when the form is submitted
					$code = $this->input->post('CaptchaCode');
					 $isHuman = $this->botdetectcaptcha->Validate($code); 
					if($isHuman){
						$first_name = escape_tags($this->input->post('first_name'));
						$last_name = escape_tags($this->input->post('last_name'));
						$email = escape_tags($this->input->post('email'));
						$password = escape_tags($this->input->post('password'));
						$phone = escape_tags($this->input->post('phone'));
						$company_name = escape_tags($this->input->post('company_name'));
						$domain_name = escape_tags($this->input->post('domain_name'));
						$banner_id = escape_tags(decode($this->input->post('banner_id')));
						$sex = escape_tags($this->input->post('sex'));
						$dateOfBirth = $this->input->post('date_of_birth');
						$address = $this->input->post('address');
						
						$fieldData=array('first_name'=>$first_name,
										'last_name'=>$last_name,
										'email'=>$email,
										'password'=>$password,
										'phone'=>$phone,
										'sex'=>$sex,
										'date_of_birth'=>$dateOfBirth,
										'address'=>$address,
										'phone'=>$phone,
										'company'=>$company_name,
										'domain_name'=>$domain_name,
										'membership_type'=>$membership_type,
										'active'=>'0'
										);
						
						// --------------------------------
						// Auto-Username
						// --------------------------------
						// There are no guarantees that we 
						// will have a first/last name to
						// work with, so if we don't, use
						// an alternate method.
						// --------------------------------

						if (Settings::get('auto_username'))
						{
							if ($this->input->post('first_name') and $this->input->post('last_name'))
							{
								$this->load->helper('url');
								$username = url_title(escape_tags($this->input->post('first_name')).'.'.escape_tags($this->input->post('last_name')), '-', true);

								// do they have a long first name + last name combo?
								if (strlen($username) > 19)
								{
									// try only the last name
									$username = url_title(escape_tags($this->input->post('last_name')), '-', true);

									if (strlen($username) > 19)
									{
										// even their last name is over 20 characters, snip it!
										$username = substr($username, 0, 20);
									}
								}
							}
							else
							{
								// If there is no first name/last name combo specified, let's
								// user the identifier string from their email address
								$email_parts = explode('@', $email);
								$username = $email_parts[0];
							}

							// Usernames absolutely need to be unique, so let's keep
							// trying until we get a unique one
							$i = 1;
							
							$username_base = $username;

							while ($this->db->where('username', $username)
								->count_all_results('users') > 0)
							{
								// make sure that we don't go over our 20 char username even with a 2 digit integer added
								$username = substr($username_base, 0, 18).$i;

								++$i;
							}
						}
						else
						{
							// The user specified a username, so let's use that.
							$username = escape_tags($this->input->post('username'));
						}
						// --------------------------------

						// Do we have a display name? If so, let's use that.
						// Othwerise we can use the username.
						if ( ! isset($profile_data['display_name']) or ! $profile_data['display_name'])
						{
							$profile_data['display_name'] = $username;
							$profile_data['phone'] = $phone;
						}

						// We are registering with a null group_id so we just
						// use the default user ID in the settings.
						  $id = $this->ion_auth->register($fieldData, $group_id, $profile_data); 
						  $bannerExist=$this->common_model->getDataFromTabel('affiliate_banner_log','*',array('affiliate_id'=>$id,'banner_id'=>$banner_id));
						if(empty($bannerExist)){	
						  if(!empty($banner_id)){
							$this->user_m->saveAffiliateBannerLog(array('banner_id'=>$banner_id,'affiliate_id'=>$id));
						  }
						}
						if($group_id!=0){
							
							$adminEmail=getAdminEmail();
							$siteurl=base_url().'users/email/verification';
							$fromName=$this->config->item('email_from_name');
							$userType=($group_id==2)?'Affiliate':'Merchant';
							
							$to=$this->input->post('email');
							$subject='Email Varification';
							$from=$adminEmail;
							$emailData = array(
							'email_template'=>'email_template',
							'name'=>$this->input->post('first_name'),
							'email_id'=>$this->input->post('email'),
							'password'=>$this->input->post('password'),
							'activation_url'=>$siteurl,
							'activation_code'=>encode($id),
							'user_type'=>$userType,
							
							); 
							
							//function to send mail
							$this->user_m->sendMail($from, $to, $subject,$emailData,$fromName);
						
							
							$param=array('mid'=>$membership_type,'uid'=>$id);
						
							$this->paypalPayment($param);
						}
					
						// Try to create the user
						if ($id> 0)
						{
							
						}
						// Can't create the user, show why
						else
						{
							$this->template->error_string = $this->ion_auth->errors();
						}
					}else{	
						
							set_global_messages(lang('user:pls_enter_valid_captcha_msg'),'error');
					}
			}
			else
			{
				// Return the validation error
			
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->template->error_string;
				
				set_global_messages($msg,'error',true);
			}
		}
		// Is there a user hash?
		else {
			if (($user_hash = $this->session->userdata('user_hash')))
			{
				// Convert the array to an object
				$user->email = ( ! empty($user_hash['email'])) ? $user_hash['email'] : '';
				$user->username = $user_hash['nickname'];
			}
		}
		// --------------------------------
		// Create profile fields.
		// --------------------------------

		// Anything in the post?

		$this->template->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $profile_data));

		// --------------------------
		//check remember me for merchant and affiliate
		$rememberCode=get_cookie('ruser');
		if($group_id==3){
			$rememberCode=get_cookie('muser');
		}
	
		$rememberArray=explode('_',$rememberCode);
	
		
		if(!empty($rememberArray[0])){
			$data['login_email']=decode($rememberArray[0]);
			$data['login_pass']=decode($rememberArray[1]);
		}
		//echo $membershipId; die;
		if($membershipId!=''){
			$data['features']=$this->user_m->getFeaturesByMembershipId($membershipId);
		}else{
			$data['features']=$this->user_m->getFeaturesByMembershipId($membership_type);
		}
		
		$data['membershipId']=$membershipId;	
		$data['group_id']=$group_id;	
		$data['memberships']=$this->user_m->getMemberships();
		$data['banner_id']=encode($banner_id);
		$this->template
			->title(lang('user:register_title'))
			->set('_user', $user)
			->build('register',$data);
	}
	

	// --------------------------------------------------------------------------
		
	/**
	 * Activate a user
	 *
	 * @param int $id The ID of the user
	 * @param string $code The activation code
	 *
	 * @return void
	 */
	public function activate($id = 0, $code = null)
	{
		// Get info from email
		if ($this->input->post('email'))
		{
			$this->template->activate_user = $this->ion_auth->get_user_by_email($this->input->post('email'));
			$id = $this->template->activate_user->id;
		}

		$code = ($this->input->post('activation_code')) ? $this->input->post('activation_code') : $code;

		// If user has supplied both bits of information
		if ($id and $code)
		{
			// Try to activate this user
			if ($this->ion_auth->activate($id, $code))
			{
				$this->session->set_flashdata('activated_email', $this->ion_auth->messages());

				// trigger an event for third party devs
				Events::trigger('post_user_activation', $id);
				redirect('users/activated');
			}
			else
			{
				$this->template->error_string = $this->ion_auth->errors();
			}
		}

		$this->template
			->title(lang('user:activate_account_title'))
			->set_breadcrumb(lang('user:activate_label'), 'users/activate')
			->build('activate');
	}

	/**
	 * Activated page.
	 *
	 * Shows an activated messages and a login form.
	 */
	public function activated()
	{
		//if they are logged in redirect them to the home page
		if ($this->current_user)
		{
			redirect(base_url());
		}

		$this->template->activated_email = ($email = $this->session->flashdata('activated_email')) ? $email : '';

		$this->template
			->title(lang('user:activated_account_title'))
			->build('activated');
	}

	/**
	 * Reset a user's password
	 *
	 * @param bool $code
	 */
	
	public function reset_pass($groupId = null)
	{
	
		$groupId=decode($groupId); 
		//check groupId
		$data['group_id'] = (!empty($groupId))? $groupId : 3; // group_id=3 for merchant & group_id = 2 for Affiliate
		$data['userType'] = ($data['group_id']==2)?'Affiliate':'Merchant';
	
		//$this->template->title(lang('user:reset_password_title'));

		//if user is logged in they don't need to be here
		if ($this->current_user)
		{
			$this->session->set_flashdata('error', lang('user:already_logged_in'));
			redirect('');
		}
			
		if ($_POST)
		{
			
			//$uname = (string) $this->input->post('user_name');
			$email = (string) $this->input->post('email');
			//check email exists
			$registerEmail=$this->common_model->getDataFromTabel('users','email',array('email'=>$email,'group_id'=>$groupId));
			if(!empty($registerEmail)){
				if (! $email)
				{
				
					// they submitted with an empty form, abort
					$this->template->set('error_string', $this->ion_auth->errors())
						->build('reset_pass');
				}
		
				if ( ! ($user_meta = $this->ion_auth->get_user_by_email($email,$data['group_id'])))
				{
					$user_meta = $this->ion_auth->get_user_by_username($email,$data['group_id']);
				}
			
				// have we found a user?
				
					$pass=ucfirst($user_meta->first_name).rand(100,10000);	
					$groupId=$data['group_id']; 
					
					//user forgot pass 
					$new_password = $this->ion_auth->forgotten_password($pass,$email,$groupId);

					if ($new_password)
					{
						//set success message
						//$this->template->success_string = lang('forgot_password_successful');
						$this->session->set_flashdata('success', 'New password has been sent.Please check your email address.');
						if($groupId==1){
							redirect('admin/login');
						}else{
							redirect('users/forgot-password/'.encode($groupId).'');
						}
					}
					else
					{
						// Set an error message explaining the reset failed
						//$this->template->error_string = $this->ion_auth->errors();
						$this->session->set_flashdata('error', $this->ion_auth->errors());
						
					}
			}else{
					//$this->session->set_flashdata('error', "Email account does not exists.");
					set_global_messages('Email account does not exists.', 'error');
			}
		}
		$data['group_id']=$groupId;
		$this->template
			->build('reset_pass',$data);
		
		//$this->template->build('reset_pass',$data);
	} 

	/**
	 * Password reset is finished
	 */
	public function reset_complete()
	{

		//if user is logged in they don't need to be here. and should use profile options
		if ($this->current_user)
		{
			$this->session->set_flashdata('error', lang('user:already_logged_in'));
			redirect('users/my-profile');
		}

		$this->template
			->title(lang('user:password_reset_title'))
			->build('reset_pass_complete');
	}

	/**
	 * Edit Profile
	 *
	 * @param int $id
	 */
	public function edit($id = 0)
	{
		//prevent access of admin
		$userGroup=userGroup(); 
		if($userGroup==1){
			redirect('');
		}
		if ($this->current_user and $this->current_user->group === 'admin' and $id > 0)
		{
			$user = $this->user_m->get(array('id' => $id));
			
			// invalide user? Show them their own profile
			$user or redirect('profile/edit');
		
		}
		else
		{
			$user = $this->current_user or redirect('users/login/users/edit'.(($id > 0) ? '/'.$id : ''));
		}
	
		$profile_data = array(); // For our form

		// Get the profile data
		$profile_row = $this->db->limit(1)
			->where('user_id', $user->id)->get('profiles')->row();

		// If we have API's enabled, load stuff
		if (Settings::get('api_enabled') and Settings::get('api_user_keys'))
		{
			$this->load->model('api/api_key_m');
			$this->load->language('api/api');

			$api_key = $this->api_key_m->get_active_key($user->id);
		}
		
		$this->validation_rules = array(
			array(
				'field' => 'first_name',
				'label' => lang('user:first_name'),
				'rules' => 'required|max_length[60]',
			),
			array(
				'field' => 'last_name',
				'label' => lang('user:last_name'),
				'rules' => 'trim|max_length[60]',
			),
			array(
				'field' => 'email',
				'label' => lang('user:email'),
				'rules' => 'required|max_length[150]|valid_email|',
			),
				array(
				'field' => 'phone',
				'label' => lang('user:phone'),
				'rules' => 'required|max_length[13]'
			),
			array(
				'field' => 'company',
				'label' => lang('user:company_name'),
				'rules' => 'trim|max_length[150]'
			),
			array(
				'field' => 'domain_name',
				'label' => lang('user:website_address'),
				'rules' => 'trim|max_length[250]'
			),
			array(
				'field' => 'sex',
				'label' => lang('user:website_address'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'address',
				'label' => lang('user:address'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'date_of_birth',
				'label' => lang('user:date_of_birth'),
				'rules' => 'trim|required|max_length[10]'
			),
			
			array(
				'field' => 'password',
				'label' => lang('user:password'),
				'rules' => 'min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'

			),
			
			array(
				'field' => 'confirm_password',
				'label' => lang('user:confirm_password'),
				'rules' => 'min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']'

			),
		
		);

		// --------------------------------
		// Merge streams and users validation
		// --------------------------------

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $profile_row->id);

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
			
		// --------------------------------
		if($_POST){
			if($this->input->post('password')!='' || $this->input->post('confirm_password')!=''){
				
				if($this->input->post('password')!=$this->input->post('confirm_password')){
					$this->session->set_flashdata('error', 'Password does not match!');
					redirect('users/my-profile/edit');
				}
				
				 $this->form_validation->set_rules('password', 'Password', 'trim|required');
				 $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
			}
		}
		
		if($user->group_id==3){
				//$this->form_validation->set_rules('membership_type',lang('user:membership_type'),'trim|required|');
				$this->form_validation->set_rules('domain_name',lang('user:website_address'),'trim|required|');
				
			}
		$this->form_validation->set_rules($this->validation_rules);
		// Settings valid?
		if ($this->form_validation->run())
		{
	
			if(!empty($user)){
				$user_data['first_name']=$this->input->post('first_name');
				$user_data['last_name']=$this->input->post('last_name');
				$user_data['phone']=$this->input->post('phone');
				$user_data['company']=$this->input->post('company');
				
				$user_data['group_id']=userGroup();
				
				$user_data['sex'] = $this->input->post('sex');
				$user_data['date_of_birth'] = $this->input->post('date_of_birth');
				$user_data['address'] = $this->input->post('address');
				$user_data['domain_name']=$this->input->post('domain_name');
				
				if($this->input->post('password')!=''){
					$user_data['password']=$this->input->post('password');
				}
				
				
			}
			
			if ($this->ion_auth->update_user($user->id, $user_data) !== false)
			{
				Events::trigger('post_user_update');
				$this->session->set_flashdata('success', $this->ion_auth->messages());
				redirect('users/my-profile');
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('users/my-profile/edit');
			}

			
		}
		else
		{
			
			// -----------user error---------------------
			$error_string=$this->form_validation->error_string();
		
			set_global_messages($error_string, 'error');	
			// Grab user data
			// --------------------------------
			// Currently just the email.
			// --------------------------------		
			
			if (isset($_POST['email']))
			{
				$user->email = $_POST['email'];
			}
				
		}

		// --------------------------------
		// Grab user profile data
		// --------------------------------

		foreach ($assignments as $assign)
		{
			if (isset($_POST[$assign->field_slug]))
			{
				$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
			}
			else
			{
				$profile_data[$assign->field_slug] = $profile_row->{$assign->field_slug};
			}
		}

		// --------------------------------
		// Run Stream Events
		// --------------------------------
	
		$profile_stream_id = $this->streams_m->get_stream_id_from_slug('profiles', 'users');
		$this->fields->run_field_events($this->streams_m->get_stream_fields($profile_stream_id), array());

		// ----------get all membership----------------------
		$membershipId='';
		$memberships=$this->user_m->getMemberships();
		if(!empty($user)){
			$membershipId=$user->membership_type;
		}
		$features=$this->user_m->getFeaturesByMembershipId($membershipId);
		
		// Render the view
		$this->template->build('profile/edit', array(
			'_user' => $user,
			'features'=>$features,
			'memberships'=>$memberships,
			'display_name' => $profile_row->display_name,
			'profile_fields' => $this->streams->fields->get_stream_fields('profiles', 'users', $profile_data),
			'api_key' => isset($api_key) ? $api_key : null,
			
		));
	}

	/**
	 * Callback method used during login
	 *
	 * @param str $email The Email address
	 *
	 * @return bool
	 */
	public function _check_login($email)
	{
			
		$remember = false;
		if ($this->input->post('remember') == 1)
		{
			$remember = true;
		}
		$groupId=$this->input->post('group_id');
		if ($this->ion_auth->login($email, $this->input->post('password'), $remember,$groupId))
		{
			return true;
		}
			
		Events::trigger('login_failed', $email);
		error_log('Login failed for user '.$email);

		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return false;
	}

	/**
	 * Username check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $username The username to check.
	 *
	 * @return bool
	 */
	public function _username_check($username)
	{
		if ($this->ion_auth->username_check($username))
		{
			$this->form_validation->set_message('_username_check', lang('user:error_username'));
			return false;
		}

		return true;
	}

	/**
	 * Email check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $email The email to check.
	 *
	 * @return bool
	 */
	public function _email_check($email)
	{
		$groupId=$this->input->post('group_id');
		if ($this->ion_auth->email_check($email,$groupId))
		{
			
			$this->form_validation->set_message('_email_check', lang('user:error_email'));
			return false;
		}
		return true;

	}
	
	function getCancelPaypalResponse()
	{
		$this->session->set_flashdata('success', "Membership request has been cancelled.");
		redirect('users/membership');
	}

	/*
	 * @Description	:set upgrade paypal payment
	 * @param		:membershipId
	 * @return		:msg
	*/
	function setPaypalPayment($mid='')
	{
		$membership=$this->user_m->getMembershipsDetails(array('id'=>$mid));
		
		$userId=is_logged_in();
		if(!empty($membership) && $membership->membership_price >0)
		{
			
			$data['amt']=$membership->membership_price;
			$data['return_url']=base_url().'users/getPaypalResponse/?amt='.$data['amt'].'&mid='.$mid.'&uid='.$userId;
			$data['cancel_url']=base_url().'users/getCancelPaypalResponse/';
			$data['currency_code']='USD';
			
			$this->payments_pro->Set_express_checkout($data);
			return true;
		}
		redirect('users/membership');
	}
	/*
	 * @Description	:This funtion used to send membership details to paypal
	 * @param		:array for param
	 * @return		:void
	*/
	function paypalPayment($param=array())
	{
				
		$membership=$this->user_m->getMembershipsDetails(array('id'=>$param['mid']));

		if(!empty($membership) && $membership->membership_price >0)
		{
			$data['amt']=$membership->membership_price;
			$data['return_url']=base_url().'users/getPaypalResponse/?amt='.$data['amt'].'&mid='.$param['mid'].'&uid='.$param['uid'];
			$data['cancel_url']=base_url().'users/getCancelPaypalResponse/';
			$data['currency_code']='USD';
		
			$this->payments_pro->Set_express_checkout($data);
			return true;
		}
		else
		{
			$this->user_m->updateMembership($param['mid']);
			$this->session->set_flashdata('success', "Account created successfully! Please check your email address.");
			redirect('users/email/verification');
			
		}
	}
	
	/*
	 * @Description	:This funtion used to get paypal response
	 * @param		:void
	 * @return		:msg
	*/
	function getPaypalResponse()
	{
		$user=is_logged_in();
		if(isset($_REQUEST['PayerID']))
		{
			$result=$this->payments_pro->Do_express_checkout_payment($_REQUEST);
		
			if($result['ACK']=='Success'){
				$result['mid']=$_REQUEST['mid'];
				$result['uid']=$_REQUEST['uid'];
				$this->user_m->getPaypalResponse($result);
			}
			
		}else{
				$this->session->set_flashdata('error',lang('user:regis_error'));
				if($user){
					redirect('users/my-profile');
				}else{
					redirect('users/email/verification');
				}
		}
		$this->session->set_flashdata('error','Request Failed Please Try Again.');
		redirect('users/membership');
		
	}

	
	/*
	 * @Description	:This funtion used to add review of user (testimonial)
	 * @param		:void
	 * @return		:msg
	*/
	function addtestimonial()
	{
		//prevent access of admin
		$userGroup=userGroup(); 
		if($userGroup==1){
			redirect('');
		}
				
		$testimonial = new stdClass();
		//set validate fields
		$validation=$this->validation_rules = array(
			array(
				'field' => 'topic',
				'label' => lang('user:topic'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => lang('global:description'),
				'rules' => 'trim|required|'
			)
		);	
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);
			if ($this->form_validation->run())
			{
				if ($id =$this->user_m->addTestimonial($this->input->post()))
				{
				
					$this->session->set_flashdata('success',lang('user:success_testimonials'));
				}
				else
				{
					$this->session->set_flashdata('error', lang('global:error_msg'));
				}
				redirect('users/testimonial');
			}
		}
	
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$testimonial->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
	
	
		$this->template
			->set('_testimonial', $testimonial)
		->build('add_testimonial',$data); 
	}
	/*
	 * @Description	:This funtion used to show testimonial
	 * @param		:void
	 * @return		:testimonial details
	*/
	function testimonial()
	{
		$page='';
		//get all testimonials
		$testimonials=$this->user_m->getAllTestimonial();
		//to add pagination 
		$uri=base_url()."users/testimonial?";
		$config=$this->common_model->getPagination(count($testimonials),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data["links"] = $this->pagination->create_links(); 
		
		$data['testimonials']=$this->user_m->getAllTestimonial($config["per_page"],$page);
		$this->template
		->build('testimonial',$data); 
	}
	/*
	 * @Description	:This funtion used to show upgrad membership
	 * @param		:void
	 * @return		:void
	*/
	function membership()
	{
		
		$userLogin=is_logged_in();
		if(!$userLogin){
			redirect('');
		}
		
		$data['memberships']=$this->user_m->getMemberships();
		
		if($userLogin){
			$data['_user']=$this->current_user;
		}
	
		
		$membership=$this->user_m->getCurrentUserMemberships();

		$data['userMembership']=$membership;
		//get logged in user payment details 
	
		//$payment=$this->user_m->getUserPaymentDetails();
		$userMembership=$this->common_model->getDataFromTabel('users','membership_date,membership_type,membership_expiry_date',array('id'=>$userLogin));
		if(!empty($userMembership)){
			$userMem=$userMembership[0];
			$regi_date=date('Y-m-d',strtotime($userMem->membership_date)); 
					
			if(!empty($membership)){
				$mDay=$membership->membership_days;
			
				//to calcualte expire date
					
				 $date=strtotime($regi_date); 
				 $data['expiryDate'] = date('d M Y',strtotime('+'.$mDay.' days')); 
			}
			
			
			$currentDate=date('Y-m-d');
			$expiryDate=date('Y-m-d',strtotime($userMem->membership_expiry_date));
			//$regisDate=date('Y-m-d',strtotime($data['expiryDate']));
			if(strtotime($currentDate)<=strtotime($expiryDate)){
				$data['daysDiff']=$this->common_model->datedaydifference($currentDate,$expiryDate);
			}else{
				$data['daysDiff']=array();
			}
				
		}

		 $this->template->build('membership/upgrade', $data); 
	}
	/*
	 * @Description	:This funtion used to email verification
	 * @param		:void
	 * @return		:msg
	*/
	function emailverification()
	{
		
		$userLogin=is_logged_in();
		if($userLogin){
			redirect();
		}
		$validation = array(
		array(
			'field' => 'activation_code',
			'label' => lang('user:activation_code'),
			'rules' => 'required|trim'
			)
			
		);
		if ($_POST)
		{
			// Set the validation rules
			$this->form_validation->set_rules($validation);
			
			// If the validation worked, or the user is already logged in
			if ($this->form_validation->run() or $this->current_user)
			{
				 $code=$this->input->post('activation_code');
				 $decryptId=decode($code);
				 $msg='Please enter valid activation code.';
				 
				 checkEncryptId($decryptId,$code,'users/email/verification',$msg);
				 
				 $userData=$this->common_model->getDataFromTabel('users','*',array('id'=>decode($code)));
				 if(!empty($userData)){
					$userBlock=$userData[0];
					if(!empty($userBlock)){
						if($userBlock->active==1)
						{
							$this->ion_auth->logout();
							if (!$this->input->is_ajax_request()){
									$this->session->set_flashdata('error', lang('user:user_already_active'));
									redirect('');
							}	 
						}
								
						$this->user_m->activate($userBlock->id);
						//to login user 
						$this->force_login($userBlock->id);
						
						if(!empty($userBlock) && $userBlock->group_id==2){
							//check for affiliate user only
						
								$this->session->set_flashdata('success', lang('user:logged_in'));
								redirect('users/my-profile');
						}
						
						if(!empty($userBlock) && $userBlock->user_block==0){
							 $this->session->set_flashdata('success', lang('user:logged_in'));
							 redirect('users/my-profile');
						}else if($userBlock->user_block==1){
								//allow third party devs to do things right before the user leaves
								$this->ion_auth->logout();
								if (!$this->input->is_ajax_request()){
										$this->session->set_flashdata('error', lang('user:user_block_msg'));
										redirect('register');
								}	
						 } 
					}
					redirect('');
				}else
				{
					$this->session->set_flashdata('error', 'Please enter valid activation code.');
						redirect('users/email/verification');
				}
			}
			else{
				$this->template->error_string = $this->form_validation->error_string();
			}
		}
			$this->template
			->build('email_verification'); 
	}
	
	public function force_login($userId)
	{
		if ($this->ion_auth->force_login($userId))
		{
			return true;
		}
		$this->form_validation->set_message('force_login', $this->ion_auth->errors());
		return false;
	}
	/**
	 * @Desc  :get testimonial details
	 * @param :id
	 * @return:show testimonial details
	 */
	function viewtestimonial($id='')
	{
		$id=decode($id);
		// Make sure we found data
		$id or redirect('users/testimonial');
		
		$testimonial = $this->user_m->getTestimonial($id);
		$this->template
		->set('testimonial', $testimonial)
		->build('view_testimonial'); 
	}
	
	
}
