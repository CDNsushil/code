<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once('PasswordHash.php');
define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * Tank_auth
 *
 * Authentication library for Code Igniter.
 *
 * @package		Tank_auth
 * @author		Ilya Konyukhov (http://konyukhov.com/soft/)
 * @version		1.0.9
 * @based on	DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */
class Tank_auth
{
	private $error = array();
	public $field = array(
					'loginFlag' =>'',
					'flagPws' =>'',
					'tdsUid' =>'',
					'group' =>'',
					'banned' =>'',
					'active' =>'',
					'codeEmail' =>'',
					'codeMob' =>'',
					'activation_key' =>'',
					'last_ip' =>'',
					'new_email_key' =>'',
					'new_email' =>'',
					'new_password_key' =>'',
					'ban_reason' =>'',
					'email' =>'',
					'password' =>'',
					'username' =>'',
					'pwdDate' =>'',
					'modified' =>'',
					'created' =>'',
					'last_visit' =>'',
					'new_password_requested' =>'',
					'isPerformingArtist' =>'',
					'isEnterprise' =>'',
					'isAssociatedProfessional' =>'',
					'isCreative' =>'',
					'tdsUid' =>'',
					'countryId' =>'',
					'cityId' =>'',
					'displayLang' =>'',
					'secondLang' =>'',
					'firstLang' =>'',
					'promoDesc' =>'',
					'interview' =>'',
					'video' =>'',
					'image' =>'',
					'creativePath' =>'',
					'creativeFocus' =>'',
					'tagwords' =>'',
					'countryName' =>'',
					'cityName' =>'',
					'enterpriseName' =>'',
					'nickName' =>'',
					'lastName' =>'',
					'firstName' =>'');

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('auth/tank_auth', TRUE);
		$this->ci->load->database();
		$this->ci->load->model('auth/users');
		$this->ci->load->library('auth/PasswordHash',$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
		//$this->autologin();
	}

	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and active, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function login($login, $password, $remember, $login_by_username, $login_by_email){
		if ((strlen($login) > 0) AND (strlen($password) > 0)) {
			// Which function to use to login (based on config)
			if ($login_by_username AND $login_by_email) {
				$get_user_func = 'get_user_by_login';
			} else if ($login_by_username) {
				$get_user_func = 'get_user_by_username';
			} else {
				$get_user_func = 'get_user_by_email';
			}
			if (!is_null($user = $this->ci->users->$get_user_func($login))) {	// login ok
				// Does password match hash in database?
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				if ($hasher->CheckPassword($password, $user->password)) {		// password ok

					if ($user->banned == 1) {									// fail - banned
						$this->error = array('banned' => $user->ban_reason);

					} else {

						if ($user->active == 0) {							// fail - not active
							$this->error = array('not_active' => '');

						} else {
							// success
							$this->setUserLoginData($user);
							if ($remember) {
								setcookie("rememberMe[login]", $login, time()+(3600*24*365),"/");
								setcookie("rememberMe[password]", $password, time()+(3600*24*365),"/");
								//$this->create_autologin($user->tdsUid);
							}
							$this->clear_login_attempts($login);
							$this->ci->users->update_login_info(
								$user->tdsUid,
								$this->ci->config->item('login_record_ip', 'tank_auth'),
								$this->ci->config->item('login_record_time', 'tank_auth')
							);
							return true;
						}
					}
				} else {														// fail - wrong password
					$this->increase_login_attempt($login);
					$this->error = array('password' => 'auth_incorrect_password');
				}
			} else {	
				$this->increase_login_attempt($login);
				$this->error = array('login' => 'auth_incorrect_login');
			}
		}
		return FALSE;
	}
	
	function setUserLoginData($user){
		$group_row = $this->ci->users->group_name($user->group);
		$profileImagePath  = 'media/'.$user->username.'/profile_image/'.$user->profileImageName;
		$this->ci->session->set_userdata(array(
				'user_id'	=> $user->tdsUid,
				'showcaseId'	=> $user->showcaseId,
				'creative'	=> $user->creative,
				'associatedProfessional'	=> $user->associatedProfessional,
				'enterprise'	=> $user->enterprise,
                'fans'	=> $user->fans,
				'username'	=> $user->username,
				'firstName'	=> $user->firstName,
				'lastName'	=> $user->lastName,
				'userFullName'	=> $user->firstName.' '.$user->lastName,
				'userArea'	=> $user->optionAreaName,
				'enterpriseName'	=> $user->enterpriseName,
				'email'		=> $user->email,
				'countryId'	=> $user->countryId,
				'countryName'	=> $user->countryName,
				'seller_currency'	=> $user->seller_currency,
				'last_visit'=> $user->last_visit,
				'created'	=> $user->created,
				'imagePath'	=> (($user->stockImageId>0)?$user->stockImgPath.'/'.$user->stockFilename:$profileImagePath),
				'group'		=> $group_row,
				'user_role'		=> $user->group,
				'subscription_end_date'		=> $user->subscription_end_date,
				'subscriptionType'		=> $user->subscriptionType,
				'websiteUrl'		=> $user->websiteUrl,
				'showcaseId'		=> $user->showcaseId,
				'status'	=> ($user->active == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED
		));
	}
	
	
	function loginWithFacebook($login){
		if ((strlen($login) > 0) ) {
			if (!is_null($user = $this->ci->users->get_user_by_email($login,false))) {	// login ok
					if ($user->banned == 1) {									// fail - banned
						$this->error = array('banned' => $user->ban_reason);
					} else {
            
            // if user is registering then not direct allow for login
            $this->setUserLoginData($user);
            
					return true;
				}
				
			} else {	
				$this->increase_login_attempt($login);
				$this->error = array('login' => 'auth_incorrect_login');
			}
		}
		return FALSE;
	}
	
	/**
	 * Logout user from the site
	 *
	 * @return	void
	 */
	function logout()
	{
		$this->delete_autologin();
		$this->ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
		$this->ci->session->sess_destroy();
	}

	/**
	 * Check if user logged in. Also test if user is active or not.
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in($active = TRUE){
		return $this->ci->session->userdata('status') === ($active ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
	}

	/**
	 * Get user_id
	 *
	 * @return	string
	 */
	function get_user_id(){
		return $this->ci->session->userdata('user_id');
	}

	/**
	 * Get username
	 *
	 * @return	string
	 */
	function get_username()
	{
		return $this->ci->session->userdata('username');
	}

	/**
	 * Create new user on the site and return some data about it:
	 * user_id, username, password, email, new_email_key (if any).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	function create_user($username, $email, $password, $firstname, $lastname, $enterprisename, $countryId, $cityName, $email_activation)
	{
		if ((strlen($username) > 0) AND !$this->ci->users->is_username_available($username)) {
			$this->error = array('username' => 'auth_username_in_use');

		} elseif (!$this->ci->users->is_email_available($email)) {
			$this->error = array('email' => 'auth_email_in_use');

		} else {
			// Hash password using phpass
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);

			$data = array(
				'username'	=> $username,
				'password'	=> $hashed_password,
				'email'		=> $email,
				'last_ip'	=> $this->ci->input->ip_address(),
			);

			if ($email_activation) {
				$data['new_email_key'] = md5(rand().microtime());
			}
			if (!is_null($res = $this->ci->users->create_user($data, !$email_activation))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				
        //---------code modified and added by lokendra 13-aug-2014-------------//
          $this->ci->session->set_userdata('joinedUserId',$data['user_id']);
        //---------code modified and added by lokendra 13-aug-2014-------------//
        
				$insertData=array(
								'tdsUid'=>$data['user_id'],
								'firstName'=>$firstname,
								'lastName'=>$lastname,
								'cityName'=>$cityName,
								'countryId'=>$countryId
							 );
				$this->ci->users->create_profile($insertData);
					
				$showCaseData=array(
								'tdsUid'=>$data['user_id'],
								'firstName'=>$firstname,
								'lastName'=>$lastname,
								'enterpriseName'=>$enterprisename
							 );
				$this->ci->model_common->addDataIntoTabel('UserShowcase',$showCaseData);
				
				/*  Assign Free user container in registration time  */
					$uc = new lib_userContainer();
					$uc->assignFreePackageToUaser($data['user_id'],$this->ci->session->userdata('selectedPacakge'));
				/*  Assign Free user container in registration time  */
				
				$cmd3 = 'chmod -R 777 ./media';
				exec($cmd3);
				 if(!is_dir('./media/' . $username)){
					@mkdir('./media/' . $username, 777, true);
				 }
				return $data;
			}
		}
		return NULL;
	}
	
	
	
	function registerWithFB($fbUser=array())
	{
		$returnDta=false;
		if($fbUser && is_array($fbUser) && isset($fbUser['email']) && !empty($fbUser['email']) ){
			$username=random_string('alnum', 8);
			$password=random_string('alnum', 8);
			
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);
			
      
     if($this->ci->session->userdata('selectedPacakge')){
        $selectedPacakge =  $this->ci->session->userdata('selectedPacakge');
          //paid stage
        if($selectedPacakge!="1"){
          $isActivate = "0";
        }else{
          //free stage  
          $isActivate = "1";
        }
      }
      
			$authData=array(
				'username'=>$username,
				'password'=>$hashed_password,
				'email'=>$fbUser['email'],
				'active'=>$isActivate,
				'last_ip'=>$this->ci->input->ip_address(),
				'last_visit'=>date('Y-m-d H:i:s'),
				'created'=>date('Y-m-d H:i:s'),
				'modified'=>date('Y-m-d H:i:s'),
				'fbUid'=>$fbUser['uid']
			);
			$tdsUid = $this->ci->model_common->addDataIntoTabel('UserAuth',$authData);
      
      //---------code modified and added by lokendra 13-aug-2014-------------//
          $this->ci->session->set_userdata('joinedUserId',$tdsUid);
      //---------code modified and added by lokendra 13-aug-2014-------------//
			
			if(is_numeric($tdsUid) && ($tdsUid > 0)){
				$returnDta=array(
					'user_id'   => $tdsUid,		
					'email'	   => $fbUser['email'],
					'password' => $password
				);
				
				if(!empty($fbUser['country'])){
					$countryId=getCountryID($fbUser['country']);
				}else{
					$countryId=0;
				}
				
				$profileData=array(
					'tdsUid'=>$tdsUid,
					'firstName'=>$fbUser['first_name'],
					'lastName'=>$fbUser['last_name'],
					'cityName'=>$fbUser['city'],
					'countryId'=>$countryId
				);
				
				$this->ci->model_common->addDataIntoTabel('UserProfile',$profileData);
				
				$profileImagePath='';
				if(isset($fbUser['userImageUrl']) && !empty($fbUser['userImageUrl'])){
					$url=$fbUser['userImageUrl'];
					$info=pathinfo($url);
					$imageDir  = 'media/'.$username.'/profile_image/';
					if(!is_dir($imageDir)){
						mkdir($imageDir, 0777, true);
					}
					
					if(save_image_form_url($url,$imageDir)){
						$profileImagePath=$info['basename'];
					}
				}
				
				$showcaseData=array(
					'tdsUid'=>$tdsUid,
					'firstName'=>$fbUser['first_name'],
					'lastName'=>$fbUser['last_name'],
					'profileImageName'=>$profileImagePath,
					'dateCreated'=>date('Y-m-d H:i:s'),
					'dateModified'=>date('Y-m-d H:i:s')
				);
				
				$this->ci->model_common->addDataIntoTabel('UserShowcase',$showcaseData);
				
				/*  Assign Free user container in registration time  */
					$uc = new lib_userContainer();
					$uc->assignFreePackageToUaser($tdsUid,$this->ci->session->userdata('selectedPacakge'));
				/*  Assign Free user container in registration time  */
				
				$userData=array('firstName'=>$fbUser['first_name'],'lastName'=>$fbUser['last_name'],'user_id'=>$tdsUid);
				$this->sendWelcomeTmail($userData);
				
				 if(!is_dir('./media/'.$username)){
					@mkdir('./media/'.$username, 0777, true);
				 }
				
			}
			
		}
		
		return $returnDta;
	}

	/**
	 * Check if username available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		return ((strlen($username) > 0) AND $this->ci->users->is_username_available($username));
	}

	/**
	 * Check if email available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		return ((strlen($email) > 0) AND $this->ci->users->is_email_available($email));
	}

	/**
	 * Change email for activation and return some data about user:
	 * user_id, username, email, new_email_key.
	 * Can be called for not active users only.
	 *
	 * @param	string
	 * @return	array
	 */
	function change_email($email)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, FALSE))) {

			$data = array(
				'user_id'	=> $user_id,
				'username'	=> $user->username,
				'email'		=> $email,
			);
			if (strtolower($user->email) == strtolower($email)) {		// leave activation key as is
				$data['new_email_key'] = $user->new_email_key;
				return $data;

			} elseif ($this->ci->users->is_email_available($email)) {
				$data['new_email_key'] = md5(rand().microtime());
				$this->ci->users->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
				return $data;

			} else {
				$this->error = array('email' => 'auth_email_in_use');
			}
		}
		return NULL;
	}

	/**
	 * Activate user using given key
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
	{
		
		if ((strlen($user_id) > 0) AND (strlen($activation_key) > 0)) {
			$res=$this->ci->users->activate_user($user_id, $activation_key, $activate_by_email);
			if($res){
				$userDetails=$this->ci->users->get_user_by_id($user_id,1);
				/* Current register date time */
				$userData=array('firstName'=>$userDetails->firstName,'lastName'=>$userDetails->lastName,'user_id'=>$user_id);
				$this->sendWelcomeTmail($userData);
				return true;
			}
		}
		return FALSE;
	}
	
	function sendWelcomeTmail($userDetails=array())
	{
		$register_date = date("j F Y") . ' at ' . date("G:i");
		/*Set Terms and conditions link */
		$term_link = site_url(lang()).'/cms/downloadtandc';
		$template=getMessageTemplate('welcomemessage','en');
		$data['site_name'] = $this->ci->config->item('website_name', 'tank_auth');
		$dashboard = site_url(lang()).'/dashboard';
		$tips_link = site_url(lang()).'/tips/front_tips';
		$search_link = site_url(lang()).'/search/searchform';
		$term_en_link = site_url(lang()).'/cms/termsncondition';
		$term_fr_link = site_url(lang()).'/cms/termsncondition/French';
		$term_gr_link = site_url(lang()).'/cms/termsncondition/German';
		$emailTemplate="";
		if($template){
			$emailTemplate=$template->templates;
			$emailTemplate=str_replace('\\','',$emailTemplate);
			$emailTemplate=str_replace('{username}',$userDetails['firstName'].' '.$userDetails['lastName'],$emailTemplate);
			//$emailTemplate=str_replace('{siteName}',base_url(),$emailTemplate);
			$emailTemplate=str_replace('{siteName}',$data['site_name'],$emailTemplate);
			$emailTemplate=str_replace('{tips_link}',$tips_link,$emailTemplate);
			$emailTemplate=str_replace('{register_date}',$register_date,$emailTemplate);
			$emailTemplate=str_replace('{term_link}',$term_link,$emailTemplate);
			$emailTemplate=str_replace('{search_link}',$search_link,$emailTemplate);
			$emailTemplate=str_replace('{term_en_link}',$term_en_link,$emailTemplate);
			$emailTemplate=str_replace('{term_fr_link}',$term_fr_link,$emailTemplate);
			$emailTemplate=str_replace('{term_gr_link}',$term_gr_link,$emailTemplate);
			$emailTemplate=str_replace('{dashboard_link}',$dashboard,$emailTemplate);
		}
		 
		$this->ci->load->model('tmail/model_tmail');
		$this->ci->model_tmail->send_new_message(0,$userDetails['user_id'],$template->subject,$emailTemplate,1,9);
	}

	/**
	 * Set new password key for user and return some data about user:
	 * user_id, username, email, new_pass_key.
	 * The password key can be used to verify user when resetting his/her password.
	 *
	 * @param	string
	 * @return	array
	 */
	function forgot_password($login)
	{
		
		if (strlen($login) > 0) {
			if (!is_null($user = $this->ci->users->get_user_by_login($login))) {

				$data = array(
					'user_id'		=> $user->tdsUid,
					'username'		=> $user->username,
					'email'			=> $user->email,
					'new_pass_key'	=> md5(rand().microtime()),
				);

				$this->ci->users->set_password_key($user->tdsUid, $data['new_pass_key']);
				return $data;

			} else {
				$this->error = array('login' => 'auth_incorrect_email_or_username');
			}
		}
		return NULL;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function can_reset_password($user_id, $new_pass_key)
	{
		
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0)) {
			
		return $this->ci->users->can_reset_password(
				$user_id,
				$new_pass_key,
				$this->ci->config->item('forgot_password_expire', 'tank_auth'));
		}
		return FALSE;
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user)
	 * and return some data about it: user_id, username, new_password, email.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass_key, $new_password)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0) AND (strlen($new_password) > 0)) {

			if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

				// Hash password using phpass
				$hasher = new PasswordHash(
						$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
						$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);

				if ($this->ci->users->reset_password(
						$user_id,
						$hashed_password,
						$new_pass_key,
						$this->ci->config->item('forgot_password_expire', 'tank_auth'))) {	// success

					// Clear all user's autologins
					//$this->ci->load->model('user_autologin');
					//$this->ci->user_autologin->clear($user->tdsUid);

					return array(
						'user_id'		=> $user_id,
						'username'		=> $user->username,
						'email'			=> $user->email,
						'new_password'	=> $new_password,
					);
				}
			}
		}
		return NULL;
	}

	/**
	 * Change user password (only when user is logged in)
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function change_password($old_pass, $new_pass)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if old password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($old_pass, $user->password)) {			// success

				// Hash new password using phpass
				$hashed_password = $hasher->HashPassword($new_pass);

				// Replace old password with new one
				$this->ci->users->change_password($user_id, $hashed_password);
				return TRUE;

			} else {															// fail
				$this->error = array('old_password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}

	/**
	 * Change user email (only when user is logged in) and return some data about user:
	 * user_id, username, new_email, new_email_key.
	 * The new email cannot be used for login or notification before it is active.
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	function set_new_email($new_email, $password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$data = array(
					'user_id'	=> $user_id,
					'username'	=> $user->username,
					'new_email'	=> $new_email,
				);

				if ($user->email == $new_email) {
					$this->error = array('email' => 'auth_current_email');

				} elseif ($user->new_email == $new_email) {		// leave email key as is
					$data['new_email_key'] = $user->new_email_key;
					return $data;

				} elseif ($this->ci->users->is_email_available($new_email)) {
					$data['new_email_key'] = md5(rand().microtime());
					$this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
					return $data;

				} else {
					$this->error = array('email' => 'auth_email_in_use');
				}
			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return NULL;
	}

	/**
	 * Activate new email, if email activation key is valid.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_email_key) > 0)) {
			return $this->ci->users->activate_new_email(
					$user_id,
					$new_email_key);
		}
		return FALSE;
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_user($password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$this->ci->users->delete_user($user_id);
				$this->logout();
				return TRUE;

			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}

	/**
	 * Get error message.
	 * Can be invoked after any failed operation such as login or register.
	 *
	 * @return	string
	 */
	function get_error_message()
	{
		return $this->error;
	}

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_autologin($user_id)
	{
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

		$this->ci->load->model('user_autologin');
		$this->ci->user_autologin->purge($user_id);

		if ($this->ci->user_autologin->set($user_id, md5($key))) {
			set_cookie(array(
					'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
					'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
					'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
			));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Clear user's autologin data
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

			$data = unserialize($cookie);

			$this->ci->load->model('user_autologin');
			$this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

			delete_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'));
		}
	}

	/**
	 * Login user automatically if he/she provides correct autologin verification
	 *
	 * @return	void
	 */
	private function autologin()
	{
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {			// not logged in (as any user)

			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) {

					$this->ci->load->model('user_autologin');
					if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

						// Login user
						$this->ci->session->set_userdata(array(
								'user_id'	=> $user->tdsUid,
								'username'	=> $user->username,
								'status'	=> STATUS_ACTIVATED,
						));

						// Renew users cookie to prevent it from expiring
						set_cookie(array(
								'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
								'value'		=> $cookie,
								'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
						));

						$this->ci->users->update_login_info(
								$user->tdsUid,
								$this->ci->config->item('login_record_ip', 'tank_auth'),
								$this->ci->config->item('login_record_time', 'tank_auth'));
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	/**
	 * Check if login attempts exceeded max login attempts (specified in config)
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_max_login_attempts_exceeded($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('auth/login_attempts');
			return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
					>= $this->ci->config->item('login_max_attempts', 'tank_auth');
		}
		return FALSE;
	}

	/**
	 * Increase number of attempts for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('auth/login_attempts');
				$this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}

	/**
	 * Clear all attempt records for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function clear_login_attempts($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('auth/login_attempts');
			$this->ci->login_attempts->clear_attempts(
					$this->ci->input->ip_address(),
					$login,
					$this->ci->config->item('login_attempt_expire', 'tank_auth'));
		}
	}
}

/* End of file Tank_auth.php */
/* Location: ./application/libraries/Tank_auth.php */
