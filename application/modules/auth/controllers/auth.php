<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Description: This controller is use to manage user authengation section
 * like: loign, register, fb login, fb register, forgot password, 
 * 
 * last modified: 25-aug-2014
 */ 

class Auth extends MX_Controller
{
  private $subject;

  /*
  * @Descrioption: Initilize construct 
  */ 
  
  function __construct(){
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('tank_auth');
    $this->load->model('users');
    $this->lang->load('tank_auth');
    $this->head->site_title="Login or Registration";
    parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
  }
  
  //--------------------------------------------------------------------------
  
  /** 
  * Description: Default load function for auth
  * 
  * @return void
  */
  
  public function index(){
    if ($message = $this->session->flashdata('message')) {
      $this->template->load('template','general_message', array('message' => $message));
    } else {
      redirect('auth/login/');
    }
  }
  
  //--------------------------------------------------------------------------
  
  /** 
  * setup Profile on the site (Still not use this method)
  *
  * @return void
  */
  public function setupProfile(){
    
  }
  
  //--------------------------------------------------------------------------

  /** 
  * Email is already exist on the site
  *
  * @return void
  */

  public function emailAlreadyExist(){
    $data['email']=$this->input->get('val1');
    $this->load->view('email_already_exist', $data);
  }
  
  //--------------------------------------------------------------------------
  
  /** 
  * select Page on the site
  *
  * @return void
  */

  function selectPage(){
    $data['email']=$this->input->get('val1');
    $this->load->view('select_page', $data);
  }
  
  //--------------------------------------------------------------------------

  /** 
  * Check Email is already exist on the site
  *
  * @return void
  */
  
  function isEmailExist(){
    $email=$this->input->post('email');
    $res=$this->model_common->countResult('UserAuth','email',$email);
    $data['emaiExist']=false;
    if($res > 0){
      $data['emaiExist']=true;
    }
    echo json_encode($data); 
    exit;
  }
  
  //--------------------------------------------------------------------------
  
  /** 
  * Login user on the site
  *
  * @return void
  */

  function login(){
    /*check how url hit*/
    $isAjaxHit=$this->input->get('ajaxHit')>0?$this->input->get('ajaxHit'):$this->input->post('ajaxHit');
    $data['isAjaxHit'] = $isAjaxHit;
    $data['heading'] = trim(@$this->input->get('val1'));
    //$data['loginHeading'] = 'hellloooo';
    if ($this->tank_auth->is_logged_in()) {									// logged in
      redirect(base_url());
    } elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not active
      redirect(base_url('auth/send_again/'));

    } else {
      
      $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
          $this->config->item('use_username', 'tank_auth'));
      $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

      $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
      $this->form_validation->set_rules('remember', 'Remember me', 'integer');

      // Get login for counting attempts to login
      if ($this->config->item('login_count_attempts', 'tank_auth') AND ($login = $this->input->post('login'))) {
        $login =xss_clean($login);
      } else {
        $login = '';
      }

      /* $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
      if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
        if ($data['use_recaptcha'])
          $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
        else
          $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
      } */
      
      $data['errors'] = array();

      if ($this->form_validation->run() && ( $this->input->post('submit')=='Signin' || $this->input->post('ajaxHit')==1)) {	
        if ($this->tank_auth->login(
            $this->form_validation->set_value('login'),
            $this->form_validation->set_value('password'),
            $this->form_validation->set_value('remember'),
            $data['login_by_username'],
            $data['login_by_email'])) {								// success
            $data['success']=$this->lang->line('auth_message_login');
            $data['user_id']=LoginUserDetails('user_id');
            $data['username']=LoginUserDetails('username');
            $data['email']=LoginUserDetails('email');
            $data['created']=LoginUserDetails('created');
            $data['last_visit']=LoginUserDetails('last_visit');
            set_global_messages($data['success'], $type='success', $is_multiple=true);
        } else {
          $errors = $this->tank_auth->get_error_message();
          if (isset($errors['banned'])) {								// banned user
            if($this->input->post('ajaxHit')==1){
              $data['banned']=$this->lang->line('auth_message_banned').' '.$errors['banned'];
            }else{
              $this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
            }
          } elseif (isset($errors['not_active'])) {				// not active user
            if($this->input->post('ajaxHit')==1){
              $data['banned']=$this->lang->line('auth_message_activateAccount');
            }else{
              redirect(base_url('auth/send_again/'));
            }
            
          } else {													// fail
            foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
          }
        }
      }
      $data['show_captcha'] = FALSE;
      /* if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
        $data['show_captcha'] = TRUE;
        if ($data['use_recaptcha']) {
          $data['recaptcha_html'] = $this->_create_recaptcha();
        } else {
          $data['captcha_html'] = $this->_create_captcha();
        }
      } */
      if($isAjaxHit){
        if($this->input->post('ajaxHit')==1){
          echo json_encode($data); 
          exit;
        }else{
          $this->load->view('login_form', $data);
        }
      }
      else{
        $this->template->load('template','login_form', $data);
      }
    }
  }
  
  //--------------------------------------------------------------------------

  /**
  * Logout user
  *
  * @return void
  */
  
  function logout()
  {
    $this->tank_auth->logout();
    set_global_messages($this->lang->line('auth_message_logged_out'), $type='success', $is_multiple=true);
    redirect('home');
  }
  
  //--------------------------------------------------------------------------

  /**
  * Register user on the site
  *
  * @return void
  */
  
  function register()
  {
      $data['field']=$this->tank_auth->field;
      $isAjaxHit=$this->input->get('ajaxHit')>0?$this->input->get('ajaxHit'):$this->input->post('ajaxHit');
      $data['isAjaxHit'] = $isAjaxHit;
      if ($this->tank_auth->is_logged_in()) {									// logged in
        redirect(base_url('auth/send_again/'));

      } elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not active
        redirect(base_url('auth/send_again/'));

      } elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
        $this->_show_message($this->lang->line('auth_message_registration_disabled'));

      } else {
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|xss_clean');
        $this->form_validation->set_rules('enterpriseName', 'Business Name', 'trim|xss_clean');
        $this->form_validation->set_rules('countryId', 'Country', 'trim|xss_clean');
        $this->form_validation->set_rules('cityName', 'City', 'trim|xss_clean');

        $captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
        $use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
        if ($captcha_registration) {
          if ($use_recaptcha) {
            $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
          } else {
            $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
          }
        }
        $data['errors'] = array();

        $email_activation = $this->config->item('email_activation', 'tank_auth');
        $use_username='';
        if ($this->form_validation->run() && ( $this->input->post('submit')=='Signup' || $this->input->post('ajaxHit')==1)) {
          // validation ok
          $use_username=random_string('alnum', 8);
          if (!is_null($data = $this->tank_auth->create_user(
              $use_username,
              $this->form_validation->set_value('email'),
              $this->form_validation->set_value('password'),
              $this->form_validation->set_value('firstName'),
              $this->form_validation->set_value('lastName'),
              $this->form_validation->set_value('enterpriseName'),
              $this->form_validation->set_value('countryId'),
              $this->form_validation->set_value('cityName'),
              $email_activation))) {									// success
        
            $data['site_name'] = $this->config->item('website_name', 'tank_auth');

            if ($email_activation) {									// send "activate" email
              $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth');

              
              if($this->session->userdata('selectedPacakge')){
                $selectedPacakge =  $this->session->userdata('selectedPacakge');
                //paid stage
                if($selectedPacakge!="1"){
                  $this->_send_email('activate_paid', $data['email'], $data);
                }else{
                  //free stage  
                  $this->_send_email('activate', $data['email'], $data);
                }
              }

              unset($data['password']); // Clear password (just for any case)

              if($this->input->post('ajaxHit')==1){
                $data['success']=$this->lang->line('auth_message_registration_completed_1');
              }else{
                $this->_show_message($this->lang->line('auth_message_registration_step1'));
              }

            } else {
              if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email
              //echo "test";die;
                $this->_send_email('welcome', $data['email'], $data);
              }
              
              unset($data['password']); // Clear password (just for any case)

              if($this->input->post('ajaxHit')==1){
                $data['success']=$this->lang->line('auth_message_registration_completed_1');
              }else{
                $this->_show_message($this->lang->line('auth_message_registration_step1'));
              }
              
            }
          } else {
            
            $errors = $this->tank_auth->get_error_message();
            foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
          }
        }
        if ($captcha_registration) {
          if ($use_recaptcha) {
            $data['recaptcha_html'] = $this->_create_recaptcha();
          } else {
            $data['captcha_html'] = $this->_create_captcha();
          }
        }
        $data['use_username'] = $use_username;
       
        $firstName  = $this->input->post('firstName',$firstName);
        //call stage 4 allowe for paid user
        $this->_allowednextstage($firstName);
        
        $data['captcha_registration'] = $captcha_registration;
        $data['use_recaptcha'] = $use_recaptcha;
        
        $pageKey = 'termsconditions';
        $cms_content = $this->model_common->get_cms_content($pageKey);
        if(!empty($cms_content[0]['description'])){
          $data['description'] = $cms_content[0]['description'];
        } else {
          $data['description'] = '';
        }
        if($isAjaxHit){
          if($this->input->post('ajaxHit')==1){
            echo json_encode($data); 
            exit;
          }else{
            $this->load->view('register_form', $data);
          }
        }
        else{
            //$this->template->load('template','register_form', $data);
            //-----------if any error then redirect on register page------//
            redirect(lang().'/package/packagestagethree');
        }
      }
  }

  //--------------------------------------------------------------------------
  
  /*
  * @Description: This function is used to if user selected any package then
  *  allowe to next stage
  * return void
  */  
  
  private function _allowednextstage($firstName=""){
    
      //-----code added by lokendra for showing username in welcome page-------//
        $this->session->set_userdata('firstName',$firstName);
      //-----code added by lokendra for showing username in welcome page-------//

      //-------set stage 4 if user not selected free-------//
        if($this->session->userdata('selectedPacakge')){
          $selectedPacakge =  $this->session->userdata('selectedPacakge');
          if($selectedPacakge!="1"){
            $packagestage   =  $this->session->userdata('packagestage'); # get stage array
            array_push($packagestage,"4"); # push stage next
            $this->session->set_userdata('packagestage',$packagestage); # set stage 
            
            //sub menu stage for stage 4 your payment details
            $this->session->set_userdata('packagesubstage',array('1')); # set sub-stage of stage 4
            
             //create default campaign for 1 year and 3 year package
             if($this->session->userdata('joinedUserId')){
                $userId   =  $this->session->userdata('joinedUserId');
                $uc = new lib_userContainer();
                $uc->packagedefaultcampaign($userId);
             }
            
          }
        }
        
      //-------set stage 4 if user not selected free-------//

  }

  //--------------------------------------------------------------------------

  /**
  * Send activation email again, to the same or new email address
  *
  * @return void
  */
  
  function send_again()
  {
    if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or active
      redirect('auth/login/');

    } else {
      $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

      $data['errors'] = array();

      if ($this->form_validation->run()) {								// validation ok
        if (!is_null($data = $this->tank_auth->change_email(
            $this->form_validation->set_value('email')))) {			// success

          $data['site_name']	= $this->config->item('website_name', 'tank_auth');
          $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth');

          $this->_send_email('activate', $data['email'], $data);

          $this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

        } else {
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->template->load('template','send_again_form', $data);
    }
  }
  
  //--------------------------------------------------------------------------
  
  /**
   * Activate user account.
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  function activate($user_id=0, $new_email_key='')
  {
    $user_id		= $this->uri->segment(4,0);
    $new_email_key	= $this->uri->segment(5,'');

    // Activate user
    if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
      
      $this->session->set_userdata('activateAccount','activateAccount');
      
      set_global_messages($this->lang->line('auth_message_activation_completed'), $type='success', $is_multiple=true);
      $this->session->set_flashdata('message', $message);
      $this->_show_message($this->lang->line('auth_message_activation_completed'));
      
      /*$this->head->add_css($this->config->item('system_css').'frontend.css');
      $this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
      $this->head->add_js($this->config->item('system_js').'jstween-1.1.min.js');
      
      $userDeatil['registerdUser'] = countResult('UserAuth','tdsUid');
      $userDeatil['loadLoinPopup'] = true;
      $userDeatil['message'] = $this->lang->line('auth_message_activation_completed');
      $this->template->load("frontend",'home',$userDeatil);
      */
      
    } else {																// fail
      set_global_messages($this->lang->line('auth_message_activation_failed'), $type='error', $is_multiple=true);
      $this->_show_message($this->lang->line('auth_message_activation_failed'));
    }
    
  }
  
  //--------------------------------------------------------------------------
  
  /**
  * Generate reset code (to change password) and send it to user
  *
  * @return void
  */
  function forgot_password()
  {
    $isAjaxHit=$this->input->get('ajaxHit')>0?$this->input->get('ajaxHit'):$this->input->post('ajaxHit');
    if ($this->tank_auth->is_logged_in()) {									// logged in
      redirect('');

    } elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not active
      redirect('auth/send_again/');

    } else {
      $this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

      $data['errors'] = array();

      if ($this->form_validation->run() && ( $this->input->post('submit')=='Get a new password' || $this->input->post('ajaxHit')==1)) {								// validation ok
        if (!is_null($data = $this->tank_auth->forgot_password(
            $this->form_validation->set_value('login')))) {

          $data['site_name'] = $this->config->item('website_name', 'tank_auth');
          
          // Send email with password activation link
          $this->_send_email('forgot_password', $data['email'], $data);

          
          if($this->input->post('ajaxHit')==1){
            $data['success']=$this->lang->line('auth_message_new_password_sent');
          }else{
            $this->_show_message($this->lang->line('auth_message_new_password_sent'));
          }

        } else {
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        }
      }
      if($isAjaxHit){
        if($this->input->post('ajaxHit')==1){
          echo json_encode($data); 
          exit;
        }else{
          $this->load->view('forgot_password_form', $data);
        }
        
      }else{
        $this->template->load('template','forgot_password_form', $data);
      }
    }
  }
  
  //--------------------------------------------------------------------------
  
  /**
   * Replace user password (forgotten) with a new one (set by user).
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  function reset_password($user_id=0,$new_pass_key='')
  {
   // $this->head->add_css($this->config->item('system_css').'frontend.css');
    $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
    $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
    
    $data['errors'] = array();
//echo $user_id."--".$new_pass_key;

    if ($this->form_validation->run()) {

        // validation ok
      if (!is_null($data = $this->tank_auth->reset_password(
          $user_id, $new_pass_key,
          $this->form_validation->set_value('new_password')))) {	// success

        $data['site_name'] = $this->config->item('website_name', 'tank_auth');

        // Send email with new password
        $this->_send_email('reset_password', $data['email'], $data);
        
        set_global_messages($this->lang->line('auth_message_new_password_activated'), $type='success', $is_multiple=true);
        
        $this->_show_message($this->lang->line('auth_message_new_password_activated'));

      } else {
        
        set_global_messages($this->lang->line('auth_message_new_password_failed'), $type='error', $is_multiple=true);													// fail
        $this->_show_message($this->lang->line('auth_message_new_password_failed'));
      }
    } else {
      
      // Try to activate user by password key (if not active yet)
      if ($this->config->item('email_activation', 'tank_auth')) {
        $this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
      }
  
      if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
        
        set_global_messages($this->lang->line('auth_message_new_password_failed'), $type='error', $is_multiple=true);
        $this->_show_message($this->lang->line('auth_message_new_password_failed'));
      }
    }
    
    //$this->template->load('frontend','reset_password_form', $data);
    $this->new_version->load('new_version','reset_password_form',$data);
    }
  
  //--------------------------------------------------------------------------
  
  /**
   * Change user password
   *
   * @return void
   */
  function change_password()
  {
    if (!$this->tank_auth->is_logged_in()) {								// not logged in or not active
      redirect('auth/login/');

    } else {
      $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
      $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
      $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

      $data['errors'] = array();

      if ($this->form_validation->run()) {								// validation ok
        if ($this->tank_auth->change_password(
            $this->form_validation->set_value('old_password'),
            $this->form_validation->set_value('new_password'))) {	// success
          $this->_show_message($this->lang->line('auth_message_password_changed'));

        } else {														// fail
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->template->load('template','change_password_form', $data);
    }
  }
  
  //--------------------------------------------------------------------------
  
  /**
   * Change user email
   *
   * @return void
   */
  function change_email()
  {
    if (!$this->tank_auth->is_logged_in()) {								// not logged in or not active
      redirect('auth/login/');

    } else {
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

      $data['errors'] = array();

      if ($this->form_validation->run()) {								// validation ok
        if (!is_null($data = $this->tank_auth->set_new_email(
            $this->form_validation->set_value('email'),
            $this->form_validation->set_value('password')))) {			// success

          $data['site_name'] = $this->config->item('website_name', 'tank_auth');

          // Send email with new email address and its activation link
          $this->_send_email('change_email', $data['new_email'], $data);

          $this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

        } else {
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->template->load('template','change_email_form', $data);
    }
  }
  
  //--------------------------------------------------------------------------
  
  /**
   * Replace user email with a new one.
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  function reset_email()
  {
    $user_id		= $this->uri->segment(3);
    $new_email_key	= $this->uri->segment(4);

    // Reset email
    if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
      $this->tank_auth->logout();
      $this->_show_message($this->lang->line('auth_message_new_email_activated'));

    } else {																// fail
      $this->_show_message($this->lang->line('auth_message_new_email_failed'));
    }
  }

  /**
   * Delete user from the site (only when user is logged in)
   *
   * @return void
   */
  function unregister()
  {
    if (!$this->tank_auth->is_logged_in()) {								// not logged in or not active
      redirect('auth/login/');

    } else {
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

      $data['errors'] = array();

      if ($this->form_validation->run()) {								// validation ok
        if ($this->tank_auth->delete_user(
            $this->form_validation->set_value('password'))) {		// success
          $this->_show_message($this->lang->line('auth_message_unregistered'));

        } else {														// fail
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->template->load('template','unregister_form', $data);
    }
  }

  /**
   * Show info message
   *
   * @param	string
   * @return	void
   */
  function _show_message($message)
  {
    $this->session->set_flashdata('message', $message);
    redirect('home/');
  }

  /**
   * Send email message of given type (activate, forgot_password, etc.)
   *
   * @param	string
   * @param	string
   * @param	array
   * @return	void
   */
   
  function emailTesting()
  {
    $data = array(
        'username'	=> 'sushilmishra',
        'password'	=> 'cdnsm121',
        'email'		=> 'sushilmishra@cdnsol.com',
        'new_email_key'		=> '1234567989',
        'user_id'		=> '85'
      );
    //echo $this->_send_email('welcome_with_fb_paid', 'sushilmishra@cdnsol.com', $data);
    
  } 
   
  private function _send_email($type, $email, &$data)
  {
    $this->load->library('email');
    $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
    //$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
    //$email=array($email,'sushilmishra@cdnsol.com');
    $this->email->to($email);
    //$this->email->message($this->template->load('template','email/'.$type.'-html', $data, TRUE));
    switch ($type)
        {
          case 'welcome':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'welcome_with_fb':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'welcome_with_fb_paid':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'activate':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'activate_paid':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'forgot_password':
          $msgBody = $this->template_body($type,$data);
          break;
          case 'reset_password':
          $msgBody = $this->template_body($type,$data);
          break;
          
          default:
          $msgBody = $this->load->view('email/'.$type.'-html', $data, TRUE);
        }
    
    $this->email->message($msgBody);
    $this->email->subject($this->subject);
    
    //$this->email->set_alt_message($this->template->load('template','email/'.$type.'-txt', $data, TRUE));
    
    $this->email->send();
  }
  
  /**
   * Set template email body
   */
  function template_body($type,$data){
    $data['site_name']=isset($data['site_name'])?$data['site_name']:$this->config->item('website_name', 'tank_auth');
    $where=array('purpose'=>$type,'active'=>1);
        $reportTemplateRes=$this->model_common->getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
    
    if(isset($data['new_pass_key']) && !empty($data['new_pass_key'])){
      $new_pass_key = $data['new_pass_key'];
    }else{
      $new_pass_key = '';
    }
    
    if(isset($data['new_email_key']) && !empty($data['new_email_key'])){
      $new_email_key = $data['new_email_key'];
    }else{
      $new_email_key = '';
    }
    
    if(isset($data['email']) && !empty($data['email'])){
      $email = $data['email'];
    }else{
      $email = '';
    }
    
    if(isset($data['password']) && !empty($data['password'])){
      $password = $data['password'];
    }else{
      $password = '';
    }
    
    if(isset($data['activation_period']) && !empty($data['activation_period'])){
      $activation_period = $data['activation_period'];
    }else{
      $activation_period = $this->config->item('email_activation_expire', 'tank_auth');
    }
    
    $site_base_url =site_base_url();
    
    /* Current register date time */
    //date_default_timezone_set('Europe/Luxembourg');
    //$register_date = date("G:ia") . ' on '. date("j F Y");
    $register_date = date("j F Y") . ' at ' . date("G:i");
    /* while we don't remove restriction (username, password) in .htacess file  from live site*/
    $image_base_url = site_base_url().'images/email_images/';
    $crave_us = $this->config->item('crave_us');
    /*Set Terms and conditions link */
    $term_link = site_url(lang()).'/cms/downloadtandc';
    /* Set Follow us link*/
    $facebook_url = $this->config->item('facebook_follow_url');
    $linkedin_url = $this->config->item('linkedin_follow_url');
    $twitter_url = $this->config->item('twitter_follow_url');
    $gPlus_url = $this->config->item('google_follow_url');
    
    if((isset($data['username'])) && (!empty($data['username'])) &&(strlen($data['username']) > 0)){
      $username = '<tr style="padding-top:9px;">
            <td style="font-size:13px; font-weight:bold; color:#444444; padding-left:32px; width:110px;">User Name	:</td>
            <td style="color:#f15921;font-size:13px; font-weight:bold;"> '.$data['username'].' </td>
            </tr>';
    }
    else{
      $username = '';
    }
    
    switch ($type)
        {
          case 'forgot_password':
          $site_url = site_url('auth/reset_password/'.$data['user_id'].'/'.$new_pass_key);
          $searchArray = array("{site_name}" , "{site_url}" , "{site_base_url}", "{image_base_url}", "{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'],$site_url,$site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          case 'welcome':
          case 'activate':
          $site_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $activation_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $searchArray = array("{site_name}", "{activation_period}" , "{email}" , "{password}" , "{site_url}" , "{site_base_url}", "{activation_url}", "{image_base_url}", "{crave_us}", "{register_date}", "{term_link}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'], $activation_period, $email,$password,$site_url,$site_base_url,$activation_url,$image_base_url,$crave_us,$register_date,$term_link,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          
          case 'activate_paid':
          $site_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $activation_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $purchase_url = site_url().'package/purchases';
          $searchArray = array("{site_name}", "{purchase_url}" , "{activation_period}" , "{email}" , "{password}" , "{site_url}" , "{site_base_url}", "{activation_url}", "{image_base_url}", "{crave_us}", "{register_date}", "{term_link}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'], $purchase_url, $activation_period, $email,$password,$site_url,$site_base_url,$activation_url,$image_base_url,$crave_us,$register_date,$term_link,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          
          case 'welcome_with_fb_paid':
          $site_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $activation_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $purchase_url = site_url().'package/purchases';
          $searchArray = array("{site_name}", "{purchase_url}" , "{activation_period}" , "{email}" , "{password}" , "{site_url}" , "{site_base_url}", "{activation_url}", "{image_base_url}", "{crave_us}", "{register_date}", "{term_link}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'], $purchase_url, $activation_period, $email,$password,$site_url,$site_base_url,$activation_url,$image_base_url,$crave_us,$register_date,$term_link,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          
          case 'welcome_with_fb':
          $site_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $activation_url = site_url('/auth/activate/'.$data['user_id'].'/'.$new_email_key);
          $searchArray = array("{site_name}",  "{email}" , "{password}" , "{site_url}" , "{site_base_url}",  "{image_base_url}", "{crave_us}", "{register_date}", "{term_link}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'],  $email,$password,$site_url,$site_base_url, $image_base_url,$crave_us,$register_date,$term_link,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          
          case 'reset_password':
          $searchArray = array("{site_name}", "{email}" , "{username}" , "{site_base_url}", "{image_base_url}", "{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
          $replaceArray = array($data['site_name'], $email, $username, $site_base_url,$image_base_url,$crave_us,$facebook_url,$linkedin_url,$twitter_url,$gPlus_url);
          break;
          
          default:
          $searchArray = '';
          $replaceArray = '';
        }
    
    
    if($reportTemplateRes) {
      $reportTemplate=$reportTemplateRes[0]->templates;
      $forgotPasswordTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
      $this->subject=$reportTemplateRes[0]->subject;
    }
    else {
      $forgotPasswordTemplate='';
    }
    return $forgotPasswordTemplate;
  }

  /**
   * Create CAPTCHA image to verify user as a human
   *
   * @return	string
   */
  function _create_captcha()
  {
    $this->load->helper('captcha');

    $cap = create_captcha(array(
      'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
      'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
      'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
      'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
      'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
      'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
      'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
      'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
    ));

    // Save captcha params in session
    $this->session->set_flashdata(array(
        'captcha_word' => $cap['word'],
        'captcha_time' => $cap['time'],
    ));

    return $cap['image'];
  }

  /**
   * Callback function. Check if CAPTCHA test is passed.
   *
   * @param	string
   * @return	bool
   */
  function _check_captcha($code)
  {
    $time = $this->session->flashdata('captcha_time');
    $word = $this->session->flashdata('captcha_word');

    list($usec, $sec) = explode(" ", microtime());
    $now = ((float)$usec + (float)$sec);

    if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
      $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
      return FALSE;

    } elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
        $code != $word) OR
        strtolower($code) != strtolower($word)) {
      $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Create reCAPTCHA JS and non-JS HTML to verify user as a human
   *
   * @return	string
   */
  function _create_recaptcha()
  {
    $this->load->helper('recaptcha');

    // Add custom theme so we can get only image
    $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

    // Get reCAPTCHA JS and non-JS HTML
    $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

    return $options.$html;
  }

  /**
   * Callback function. Check if reCAPTCHA test is passed.
   *
   * @return	bool
   */
  function _check_recaptcha()
  {
    $this->load->helper('recaptcha');

    $resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
        $_SERVER['REMOTE_ADDR'],
        $_POST['recaptcha_challenge_field'],
        $_POST['recaptcha_response_field']);

    if (!$resp->is_valid) {
      $this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
      return FALSE;
    }
    return TRUE;
  }
  
  function getUserDataFromFB(){
    $config = $this->config->item('facebook');
        $this->load->library('lib_facebook', $config);
        
    $fbUid = $this->lib_facebook->getUser();
    if($fbUid == 0){
      redirect('home');
    } else {
      //$fbUser = $this->lib_facebook->api('/'.$fbUid);
      $fql = 'SELECT uid, email,first_name,middle_name,last_name,name,religion,birthday_date,sex,hometown_location,current_location FROM user WHERE uid="'.$fbUid.'"';
      $fbUser_result = $this->lib_facebook->api(array(
            'method' => 'fql.query',
            'query' => $fql
      ));
      
      if(isset($fbUser_result[0])){
        $fbUser = $fbUser_result[0];
        $fbUser['city'] = (isset($fbUser['current_location']['city']) && !empty($fbUser['current_location']['city'])) ? $fbUser['current_location']['city'] : ((isset($fbUser['hometown_location']['city']) && !empty($fbUser['hometown_location']['city']))?$fbUser['hometown_location']['city']:'');
        $fbUser['state'] = (isset($fbUser['current_location']['state']) && !empty($fbUser['current_location']['state'])) ? $fbUser['current_location']['state'] : ((isset($fbUser['hometown_location']['state']) && !empty($fbUser['hometown_location']['state']))?$fbUser['hometown_location']['state']:'');
        $fbUser['country'] = (isset($fbUser['current_location']['country']) && !empty($fbUser['current_location']['country'])) ? $fbUser['current_location']['country'] : ((isset($fbUser['hometown_location']['country']) && !empty($fbUser['hometown_location']['country']))?$fbUser['hometown_location']['country']:'');
        $fbUser['zip'] = (isset($fbUser['current_location']['zip']) && !empty($fbUser['current_location']['zip'])) ? $fbUser['current_location']['zip'] : ((isset($fbUser['hometown_location']['zip']) && !empty($fbUser['hometown_location']['zip']))?$fbUser['hometown_location']['zip']:'');
        $picture = $this->lib_facebook->api('/'.$fbUser['uid'].'?fields=picture.height(500).width(500)');
        if(isset($picture['picture']['data']['url'])){
          $fbUser['userImageUrl'] = $picture['picture']['data']['url'];
        }else{
          $fbUser['userImageUrl'] = '';
        }
      }else{
        $fbUser = false;
      }
      return $fbUser;
    }
  }
  
  function LoginOrRegisterWithFB(){
    $fbUser = $this->getUserDataFromFB();
    if($fbUser && is_array($fbUser) && isset($fbUser['email']) && !empty($fbUser['email']) ){
      $userData=$this->users->getUserImage($fbUser['email']);
      
      if($userData && isset($userData[0]->username)){ //login
        $userData=$userData[0];
        $this->loginWithFB($userData,$fbUser);
      }else{ // registered and login first time 
          
        // if user selected package then do action  
        if($this->session->userdata('selectedPacakge')){
            
            // allow for next stage
            $this->_allowednextstage($fbUser['first_name']);
            
            //facebook registered and login while first time
            $this->registerLoginWithFB($fbUser);
            
            //set showwelcome popup
            $this->session->set_userdata('showwelcomepopup',1);
        }else{
           // if not selected any plan then  go
           $msg='Please select package.';
           set_global_messages($msg, 'error', $is_multiple=true);
           $fbJoinUrl = base_url(lang().'/package');
           echo '<script type="text/javascript">if(window.opener && !window.opener.closed){window.close(); window.opener.location = "'.$fbJoinUrl.'"; }</script>';
        }
      }
    }else{
      $msg=$this->lang->line('dataNotFoundFromFb');
      set_global_messages($msg, 'error', $is_multiple=true);
    }
     
    // if user selected any plan then 
    if($this->session->userdata('selectedPacakge')){
      $selectedPacakge =  $this->session->userdata('selectedPacakge');
      // if selected paid then  go
      if($selectedPacakge!="1"){
           $fbJoinUrl = base_url(lang().'/package/membershipselected');
           echo '<script type="text/javascript">if(window.opener && !window.opener.closed){window.close(); window.opener.location = "'.$fbJoinUrl.'"; }</script>';
      }else{
         // if selected free then  go
           $fbJoinUrl = base_url_lang();
           echo '<script type="text/javascript">if(window.opener && !window.opener.closed){window.close(); window.opener.location = "'.$fbJoinUrl.'"; }</script>';
      }
    }else{
      echo '<script type="text/javascript">if(window.opener && !window.opener.closed){window.opener.location.reload(); window.close();}</script>';
    }
    
  }
  
  
  function loginWithFB($userData=array(), $fbUser=array()){ 
    if($userData && isset($userData->username)){
      $imageDir  = 'media/'.$userData->username.'/profile_image/';
      $image=$imageDir.$userData->profileImageName;
      if((strlen($userData->profileImageName) > 4 && (is_file($image))) || (is_numeric($userData->stockImageId) && ($userData->stockImageId > 0))){
        
      }else{
        if(isset($fbUser['userImageUrl']) && !empty($fbUser['userImageUrl'])){
          $url=$fbUser['userImageUrl'];
          $info=pathinfo($url);
          
          if(!is_dir($imageDir)){
            mkdir($imageDir, 0777, true);
          }
          
          if(save_image_form_url($url,$imageDir)){
            $this->model_common->editDataFromTabel('UserShowcase', array('profileImageName'=>$info['basename']), array('showcaseId'=>$userData->showcaseId));
          }
        }
      }
      $updateUserData=array('new_password_key'=>NULL,'new_password_requested'=>NULL,'last_ip'=>$this->input->ip_address(),'last_visit'=>date('Y-m-d H:i:s'));
      
      if($userData->active != 1){
        $updateUserData['active']=1;
      }
      $fbUid= trim($userData->fbUid);
      if(empty($fbUid) || $fbUid == 0 || $fbUid == null || $fbUid == ''){
        $updateUserData['fbUid']=$fbUser['uid'];
      }
      if($userData->postedOnFB !='t'){
        $postedFlag= $this->postedOnFB($fbUser,$userData->tdsUid);
        if($postedFlag){
          $updateUserData['postedOnFB']='t';
        }
      }
      
      $this->model_common->editDataFromTabel('UserAuth', $updateUserData, array('tdsUid'=>$userData->tdsUid));
      
      
      $this->fbLoginProcess($fbUser['email']);
      
    }else{
      redirect('home');
    }
  }
  
  function fbLoginProcess($email=''){
    if(!empty($email)){
      if ($this->tank_auth->loginWithFacebook($email)) {								// success
        $data['success']=$this->lang->line('auth_message_login');
        set_global_messages($data['success'], $type='success', $is_multiple=true);
      } else {
        $errors = $this->tank_auth->get_error_message();
        if (isset($errors['banned'])) {								// banned user
          $msg= $this->lang->line('auth_message_banned');
        } elseif (isset($errors['not_active'])) {				// not active user
          $msg= $this->lang->line('auth_message_activateAccount');
        } else {													// fail
          foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
          $msg= $data['errors'];
        }
        set_global_messages($msg, $type='error', $is_multiple=true);
      }
    }
  }
  
  function registerLoginWithFB($fbUser=array()){
    if($fbUser && is_array($fbUser) && isset($fbUser['email']) && !empty($fbUser['email']) ){
      $userData=$this->tank_auth->registerWithFB($fbUser);
      if($userData){
        
        $postedFlag= $this->postedOnFB($fbUser,$userData['user_id']);
        if($postedFlag){
          $updateUserData = array('postedOnFB'=>'t');
          $this->model_common->editDataFromTabel('UserAuth', $updateUserData, array('tdsUid'=>$userData['user_id']));
        }
        
        if($this->session->userdata('selectedPacakge')){
          $selectedPacakge =  $this->session->userdata('selectedPacakge');
          //paid stage
          if($selectedPacakge!="1"){
            $this->_send_email('welcome_with_fb_paid', $fbUser['email'],$userData);
          }else{
            //free stage  
            $this->_send_email('welcome_with_fb', $fbUser['email'],$userData);
            // direct login if user selected free pacakge
            $this->fbLoginProcess($fbUser['email']);
          }
        }
        
      }
    }else{
      redirect('home');
    }
  }
  
  function postedOnFB($fbUser=array(),$userId=0){
    if($fbUser && is_array($fbUser) && isset($fbUser['uid']) && !empty($fbUser['uid']) ){
      $access_token = $this->lib_facebook->getAccessToken();
      $message     = $this->lang->line('postOnFB');
            
      /*------------------------------------------------------------------
       * code added by lokendra (28-july-2014) for preventing error while login and not allow for fb post start
       *------------------------------------------------------------------*/
       
            $fbuser = $this->lib_facebook->getUser();
      $fbPermisionData = $this->lib_facebook->api('/me/permissions');
      if(!empty($fbPermisionData) && !empty($fbPermisionData['data']) && $fbPermisionData['data'][0]){
        $fbPermisionData = $fbPermisionData['data'][0];
        if(array_key_exists('publish_stream',$fbPermisionData)){
          
          //post on logged in user if allow publish stream
          $statusUpdate = $this->lib_facebook->api($fbUser['uid'].'/feed','POST',array(
            'access_token'=>$access_token,
            'message' => $message                             
          ));
        }else{
          $statusUpdate = false;
        }
      }
      
      /*------------------------------------------------------------------
       * code added by lokendra (28-july-2014) for preventing error while login and not allow for fb post end
       *------------------------------------------------------------------*/
      
      if($statusUpdate && is_numeric($userId) && ($userId > 0)){
        $uc = new lib_userContainer();
        $uc->assignExtraFreePackageToUaser($userId,$tsProductId=2,$quntity=1);
      }
      
      return $statusUpdate;
      
    }
  }
  
  /*
   ******************************** 
   * This method for registation success message show
   ********************************
   */ 
  
  
  public function registersuccessmsgpopup()
  {
    $this->load->view('registersuccessmsgpopup');
  }
  
  //------------------------------------------------------------------------
  
  /*
   * @Description: This method is use to check entered email id not exist/available in database
   * @return string
   * @auther: lokendra-meena
   */ 
  
    public function emailavailablecheck(){
      
        if($this->input->is_ajax_request()){ 
             $email         =  $this->input->post('email');
             $emailStatus   =  $this->users->is_email_available($email);
             
             if(!$emailStatus){
                  $errorMessage         =  $this->lang->line('auth_email_in_use'); // set availabel email error message
                  $errorStatus          =  true; // set email avaialble status
             }else{
                $errorMessage           =  'You can use this email'; // set availabel email message
                $errorStatus            =  false; // set email avaialble status
             }
             echo json_encode(array('errorMessage'=>$errorMessage,'errorStatus'=>$errorStatus));
        }else{
            $errorMessage = "Invalid request.";
            $errorStatus  =  true;
            echo json_encode(array('errorMessage'=>$errorMessage,'errorStatus'=>$errorStatus));
        }
    }
  
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
