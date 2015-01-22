<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Rajendra
 * @package membership\Controllers
 */
 class Affiliate extends Public_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('affiliate_model');
		$this->lang->load('affiliate');
		$this->load->helper('frontend','email');
		$this->load->helper('email');
		$this->template->append_css('module::affiliate.css');
		$this->template->append_js('module::affiliate.js');
		$this->template->append_js('module::address_books.js');
		$this->template->append_js('module::bootstrap-tooltip.js');
	
		$userId=is_logged_in();
		$this->_sn_loader();	
		if(!empty($userId) && $this->method!='index'){
			//check for valid user
			isAffiliateUser();
		}elseif($this->method!='index'){
			redirect('affiliate');
		}
		
	}
	
	public function index() {
		
		//$userId=is_logged_in();
		 $this->template
			->title($this->module_details['name'], $this->module_details['name'])
            ->append_metadata($this->load->view('fragments/wysiwyg', array() , true))
            ->set('slug', 'affiliates')
			->build('index');
			
	}
	
	
	public function dashbord() {
		
		$this->template
		->build('dashbord'); 
	}
	/**
	 *@Desc: get all banners
	 *@Param:void
	 *@Return: banners array
	 */
	public function banners()
	{
		//get all meerchant banner
		$banners=$this->common_model->getDataFromTabel('merchant_banner');
		$userId=is_logged_in();
		$data['form_heading']=lang('affiliate:view_banners');
		$data['banners']=$this->affiliate_model->get_affiliates_banners($userId);
		
		$this->template
		->build('banners',$data); 
	}
	/**
	 *@Desc: get banner details
	 *@Param: banner id
	 *@Return: object
	 **/
	public function viewbanner($id)
	{
		$userId=is_logged_in();
		$id=decode($id);
		$results = $this->common_model->getDataFromTabel('merchant_banner','', array('banner_id'=>$id));
		// Make sure we found data
		$id or redirect('affiliate/banners');
		$results or redirect('affiliate/banners');
		if(!empty($results)){
			$banner=$results[0];
			//add sidebar
		
			$data['form_heading']= lang('merchant:view_banners');
			$authUrl = $this->gClient->createAuthUrl();
			$data['gmail_oauth_url'] = $authUrl;
			$configuration = $this->common_model->getDataFromTabel('admin_configuration','*');
		
			if(!empty($configuration)){
				$configData=$configuration[0];
			
				$data["config"]=$configData;
			}
			/*---Gmail Oauth start---*/
			
			$testiData['testiData']=$testiDetails=$this->common_model->getDataFromTabel('product_testimonial_log','*',array('affiliate_id'=>$userId,'banner_id'=>$id));
			
			$testiData['banner_id']=$id;
			
			$testiData['affi_frnd_emails']=$this->affiliate_model->getAffiliateGmailContact();
		
			$data['email_popup']=$this->load->view('email_popup',$testiData,true);
			
			$data['testi_content']=$this->load->view('add_testimonial_popup',$testiData,true);
			
			$this->template
			->set('_banner', $banner)
			->build('view_banner',$data); 
		}
	}
	
		/**
	 *@Desc :  Remove product testimonial
	 *@Param:  Banner Id
	 *@Return: msg
	 **/
	function removeProductTesti($pid)
	{
		
		$userId=is_logged_in();
		$id=decode($pid);
		$deleteRow=$this->common_model->deleteRow('product_testimonial_log',array('banner_id'=>$id,'affiliate_id'=>$userId));
	
		if($deleteRow){
			$this->session->set_flashdata('success','Testimonial Removed Succcessfully.');
		}else{
			$this->session->set_flashdata('error','Request Falied! Please Try Again.');
		}
		
		redirect('affiliate/banners/view/'.$pid);
	}
	/**
	 *@Desc :  Add Product testimonial
	 *@Param:  form post data
	 *@Return: true/false
	 **/
	function addProductTestimonial()
	{	
		$bannerId='';
		$validation=$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('global:title'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'description',
				'label' => lang('global:description'),
				'rules' => 'trim|required'
			),
		);
	
		// Are they TRYing to submit?
		if ($_POST)
		{
			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run())
			{ 
				$bannerId=$this->input->post('banner_id');
				if ($id =$this->affiliate_model->insertProductTestimonial($this->input->post()))
				{
					$msg="Testimonial Added Successfully.";
					$this->session->set_flashdata('success',$msg);
					//echo json_encode(array('msg' => $msg, 'status' => 'success'));
				}
				else
				{
				
					$msg='Request Failed! Please Try Agian Latter.';
					$this->session->set_flashdata('error',$msg);
					//echo json_encode(array('msg' => $msg, 'status' => 'error'));
				}
				
			}else{
				
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->form_validation->error_string();
				set_global_messages($msg,'error');
				//echo json_encode(array('msg' => $msg, 'status' => 'error'));
			}
		}
	
		redirect('affiliate/banners/view/'.encode($bannerId));
		
	}
	
	/**
	 *@Desc :  save affiliate product email and send email to friends
	 *@Param:  form post data
	 *@Return: Msg
	 **/
	function affiliateProductEmail()
	{
		$userId=is_logged_in();
		$bannerId='';
		$validation=$this->validation_rules = array(
			array(
				'field' => 'email_to',
				'label' => lang('global:email'),
				'rules' => 'trim|required|'
			),
		);
        $post = $this->input->post();			
		if ($post)
		{
			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run())
			{ 
				$bannerId=$this->input->post('banner_id');
				$emailTo=$this->input->post('email_to');
				$emailArray=explode(',',$emailTo);
				
				if(!empty($emailArray)){
						
					foreach($emailArray as $emailData){
						if($emailData!=''){
							$checkEmail=valid_email($emailData); 
							if (!$checkEmail)
							{
								$msg='Please enter valid email address :- "'.$emailData.'"';
								echo json_encode(array('msg'=>$msg,'status'=>'error'));
								return true;
							}
						}
					}
					
				}
				
			
				
				
				if ($id =$this->affiliate_model->insertAffiliateProductEmail($this->input->post()))
				{
					$banner_data=$this->common_model->getDataFromTabel('merchant_banner','*',array('banner_id'=>$bannerId));
					//insert email in gmail contact
					$this->affiliate_model->insertEmailIntoGmailContact($emailTo);
					
					$from=$this->current_user->email;
					$subject = "SyrecoHK : Great Product, Must Buy!";	
				
					$banner_url	= $this->generate_banner_url(array('banner_id'=>$bannerId,'merchant_id'=>$banner_data[0]->merchant_id,'affiliate_id'=>$userId));
					$banner['banner_url']= $banner_url;
			
					$banner['data'] = $banner_data[0];
					
					//to insert email share banner
					if(!empty($emailArray)){	
						$shareData=array('banner_id'=>$bannerId,'merchant_id'=>$banner_data[0]->merchant_id,'share_status'=>'4');
						foreach($emailArray as $emailData){
							if($emailData!=''){
								//insert banner share log (share_status=4 for email)
								$this->affiliate_model->insertShareBannerLog($shareData);
							}
						}
					}
					
					
					if($this->input->post('product_testi')){
						$banner['testiData'] = $this->common_model->getDataFromTabel('product_testimonial_log','title,description',array('affiliate_id'=>$userId,'banner_id'=>$bannerId));
					}
					$content = $this->load->view('gmail_banner_html',$banner,'true'); // Generate Email Content
					$content = $this->_parse(array('user_name'=>'Dear'),$content);
                    
					$this->sendMail($from,$emailTo,$subject,$content);
					$msg="Email Sent Successfully.";
					$this->session->set_flashdata('success',$msg);
					echo json_encode(array('msg'=>$msg,'status'=>'success'));
					return true;
					//$this->session->set_flashdata('success',$msg);
				}
				else
				{
					$msg='Request Failed! Please Try Agian Latter.';
					echo json_encode(array('msg'=>$msg,'status'=>'error'));
					return true;
					//$this->session->set_flashdata('error',$msg);
				}
				
			}else{
				
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->form_validation->error_string();
				echo json_encode(array('msg'=>$msg,'status'=>'error'));
				return true;
				//set_global_messages($msg,'error');
			}
			redirect('affiliate/banners/view/'.encode($bannerId));
		}
	}
	
	/**
	 *@Desc : get affiliate friends email
	 *@Param:  void
	 *@Return: filter email
	 **/
	function getAffiliateEmail()
	{
	
		$userId=is_logged_in();
		$serchEmail='';
		$emailString='';
		if($this->input->post('to_email'))
		{
			//to load email helper
			$emailArray=explode(',',$this->input->post('to_email'));
			if(!empty($emailArray)){
				foreach($emailArray as $emailData){
					$checkEmail=valid_email($emailData); 
					if (!$checkEmail)
					{
						$serchEmail=$emailData;
					}
				}
			}
			
			if($serchEmail==''){
				echo json_encode(array('addEmail'=>'','error'=>'0'));
				return true;
			}
			$friendsEmail=$this->affiliate_model->getAffiliateGmailContact();
			//$friendsEmail=$this->affiliate_model->getAffiliateGmailContact($serchEmail);
			//$friendsEmail=json_decode($this->input->post('frnd_emails'));
			$addEmail='';
			if(!empty($friendsEmail)){
				$addEmail='<ul class="email_contact">';
				foreach($friendsEmail as $email){
					$addEmail.='<li class="select_contact">';
					$addEmail.=$email->contact_email;
					$addEmail.='</li>';
				}
				$addEmail.='</ul>';
			}
			
			echo json_encode(array('addEmail'=>$addEmail,'error'=>'0'));
			die;
		}
		echo json_encode(array('addEmail'=>'','error'=>'0'));
		return true;
		
	}
	/**
	 *@Desc : get affiliate request view banner
	 *@Param:  paymentId
	 *@Return: object
	 **/
	function requestview($paymentId)
	{
		$id=decode($paymentId);
		$_request = $this->affiliate_model->getRequestBannerDetails($id);
		
		// Make sure we found something
		$_request or redirect('affiliate/request');
		
		$configuration = $this->common_model->getDataFromTabel('admin_configuration','*');
		$data["config"]='';
		if(!empty($configuration)){
			$configData=$configuration[0];
			$data["config"]=$configData;
		}
		
		$this->template
			->set('_banner', $_request)
			->build('request_view',$data); 
	}
	/**
	 *@Desc : get affiliate view banner
	 *@Param:  requestId
	 *@Return: object
	 **/
	function paymentview($id)
	{
		
		$id=decode($id);
		$_payment = $this->affiliate_model->getAffiliatePaymentDetails($id);
		// Make sure we found something
		$_payment or redirect('affiliate/request');
		
		$configuration = $this->common_model->getDataFromTabel('admin_configuration','*');
		$data["config"]='';
		if(!empty($configuration)){
			$configData=$configuration[0];
			$data["config"]=$configData;
		}
		
		$this->template
			->set('_banner', $_payment)
			->build('payment_view',$data); 
	}
	/**
	 *@Desc : get all paid request of affiliate
	 *@Param:  void
	 *@Return: array
	 **/
	function affiliatepayment()
	{
		$page=0;
		$userId=is_logged_in();
		//get all membership
		$payments=$this->affiliate_model->getAffiliatePaidProduct();
		//to add pagination 
		$uri=base_url()."affiliate/payment?";
		$config=$this->common_model->getPagination(count($payments),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data["links"] = $this->pagination->create_links(); 
	
		$configuration = $this->common_model->getDataFromTabel('admin_configuration','*');
		
		if(!empty($configuration)){
			$configData=$configuration[0];
			$data["config"]=$configData;
		}
		$data['products'] = $this->affiliate_model->getAffiliatePaidProduct($config["per_page"], $page,1);
		$this->template
			->build('affiliate_payment',$data); 
	}
	
	/**
	 *@Desc : get all payment request
	 *@Param:  void
	 *@Return: array
	 **/
	function paymentrequest()
	{
		$page=0;
		$userId=is_logged_in();
		//get all membership
		$payments=$this->affiliate_model->getAffiliatePaymentRequest();
		//to add pagination 
		$uri=base_url()."affiliate/request?";
		$config=$this->common_model->getPagination(count($payments),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data["links"] = $this->pagination->create_links(); 
	
		$configuration = $this->common_model->getDataFromTabel('admin_configuration','*');
		
		if(!empty($configuration)){
			$configData=$configuration[0];
		
			$data["config"]=$configData;
		}
		$data['products'] = $this->affiliate_model->getAffiliatePaymentRequest($config["per_page"], $page);
		$this->template
			->build('payment_request',$data); 
	}
	/**
	 * @Desc	:  add configuration setting
	 * @Param	:  void
	 * @Return	:  msg
	 **/
	function configuration()
	{
		$userId=is_logged_in();
		//to get paypal setting for 
		$affiliates = $this->common_model->getDataFromTabel('affiliate_configuration','*', array('user_id'=>$userId));
		$validation=$this->affiliate_model->configValidation();
		$chinaPayValidation=$this->affiliate_model->chinaPayValidation();
		
		
		$paypal = new stdClass();
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$paypal->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
		
		$chinapay = new stdClass();
		// Set default values as empty or POST values
		foreach ($chinaPayValidation as $rule)
		{
			$chinapay->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
		
		$save=true;
		$isPaypal=false;
		$isChinaPay=false;
		if(!empty($affiliates)){
			
			foreach($affiliates as $config){
				if($config->payment_mode==0){
					$paypal=$config;
					$isPaypal=true;
				}else if($config->payment_mode==1){
					$chinapay=$config;
					$isChinaPay=true;
				}
			}
		} 

		// Are they TRYing to submit?
		if ($_POST)
		{
			if($this->input->post('payment_mode')==1){
				if($isChinaPay){
					$save=false;
				}
				$this->form_validation->set_rules($chinaPayValidation);
			}else{
				if($isPaypal){
					$save=false;
				}
				$this->form_validation->set_rules($validation);
			}
			
			if ($this->form_validation->run())
			{
				if ($id =$this->affiliate_model->insertConfig($this->input->post(),$save))
				{
					
					if($save){
						$this->session->set_flashdata('success', 'Paypal details added successfully.');
					}else{
						$this->session->set_flashdata('success', 'Paypal details updated successfully.');
					}
				}
				else
				{
					$this->session->set_flashdata('error',lang('global:error_msg'));
				}
				redirect('affiliate/configuration');
			}else{
				
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->form_validation->error_string();
				set_global_messages($msg,'error');
		
			}
		}

		$this->template
		->set('_paypal', $paypal)
		->set('_chinapay', $chinapay)
		->build('configuration'); 
	}
	/*
	 * @Description	:This funtion used to add review of user (testimonial)
	 * @param		:void
	 * @return		:msg
	*/
	function addtestimonial()
	{
		$page='';
		$user=is_logged_in();
		if(!$user){
			redirect('');
		}
		
		$testimonial = new stdClass();
		//set validate fields
		$validation=$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('user:title'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => lang('global:description'),
				'rules' => 'trim|required|max_length[250]'
			),
		);	
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);
			if ($this->form_validation->run())
			{
				if ($id =$this->affiliate_model->addTestimonial($this->input->post(),$fileName,$imagePath))
				{
					$this->session->set_flashdata('success',lang('global:success_testimonials'));
					$msg=lang('global:success_testimonials');
					//set_global_messages($msgArray); 
					set_global_messages($msg,'success');
				}
				else
				{
					$this->session->set_flashdata('error', lang('global:error_msg'));
				}
			}else{
					$this->session->set_flashdata('error',lang('global:error_msg'));
			}
			redirect('affiliate/addtestimonial');
		}
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$testimonial->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
	
		//get all testimonials
		$testimonials=$this->affiliate_model->getAllTestimonial();
		//to add pagination 
		$uri=base_url()."affiliate/testimonial/?";
		$config=$this->common_model->getPagination(count($testimonials),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data["links"] = $this->pagination->create_links(); 
		$data['testimonials']=$this->affiliate_model->getAllTestimonial($config["per_page"],$page);
	
		$this->template
			->set('_testimonial', $testimonial)
		->build('add_testimonial',$data); 
	}
	/*
	 * @Description	:This funtion used to show all merchant feedback
	 * @param		:void
	 * @return		:merchantFeedbacks
	*/
	function merchantfeedback()
	{
		$userId=is_logged_in();
		$page='';
		
		$feedbacks = $this->affiliate_model->getMerchantFeedback();
		//to add pagination 
		$uri=base_url()."affiliate/feedback?";
		$config=$this->common_model->getPagination(count($feedbacks),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data["links"] = $this->pagination->create_links(); 
		
		$data['feedbacks']=$this->affiliate_model->getMerchantFeedback($config["per_page"],$page);
		
			$this->template
		->build('merchant_feedback',$data); 
		
	}
	/**
	 * @Desc	:  view feedback
	 * @Param	:  feedback id
	 * @Return	:  void
	 **/
	function viewfeedback($id='')
	{
		$id=decode($id);
		// Make sure we found data
		$id or redirect('affiliate/testimonial');
		
		$feedback=$this->affiliate_model->getFeedback($id);
	
		$this->template
			->set('feedback', $feedback)
		->build('view_feedback');
	}
	
	
	/*
	* @Function	- Share banner on Social Network sites
	* @Params	- type(Social network type)(string),banner_data(banner detail)(json),access_token(fb access token)(string),userdata(array) 
	* @Output	- 	
	*/
	function shareBanner($type)
	{
		$userdata = '';
		$data = $this->input->post();
		$banner_data    = json_decode($data['banner_data']);
		$userId			= is_logged_in();
		$merchant_id	= $banner_data->merchant_id;
		$banner_id		= $banner_data->banner_id;
		if($type=="fb")
		{
			if(!empty($banner_data))
			{
				//insert banner share log (share_status=3 for fb)
				$shareData=array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'share_status'=>'1');
				//insert banner in share log table
				$this->affiliate_model->insertShareBannerLog($shareData);
					
				$accessToken  = $data['access_token'];
				
				$productTesti  = $data['productTesti'];
				$this->session->set_userdata('fb_token',$accessToken);
				Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
				Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
				$this->facebook->setAccessToken($accessToken);
				if($banner_data->upload_type==1){
					$banner_img = base_url().$banner_data->upload_path.$banner_data->upload_image_name;
				}
				else{
					$banner_img = $banner_data->image_url;
				}
				$addTesti='';
				if($productTesti){
					$testi= $this->common_model->getDataFromTabel('product_testimonial_log','title,description',array('affiliate_id'=>$userId,'banner_id'=>$banner_id));
					if(!empty($testi)){
						$addTesti='My Testimonial : '.ucfirst($testi[0]->description);
					}
				}
				$banner_url = $this->generate_banner_url(array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'affiliate_id'=>$userId));
				$attachment =  array(
					 'access_token' => $this->facebook->getAccessToken(),
					 'message' => $banner_data->banner_name,
					 'name' => "Buy Now",
					 'description' => $addTesti,
					 'link' => $banner_url,
					 'picture' => $banner_img,
					 'caption' => 'Syrecohk',
					 'method'=>'stream.publish',
					 'actions' => array('name'=>'Try it now', 'link' =>$banner_url),
				);
			
			   try
			   {
				  $post_id = $this->facebook->api("me/feed","POST",$attachment);
				  if($post_id){echo json_encode(array('message'=>'Successfully Posted !','status'=>true));}	
               }
               catch(Exception $e)
               {
                  echo json_encode(array('message'=>$e->getMessage(),'status'=>false));
               }
           }
           else
           {
			   echo json_encode(array('message'=>'Invalid Request !','status'=>false)); 
		   }
		}
		else if($type=="gmail")
		{
			if(!empty($data))
			{
				//insert banner share log (share_status=3 for gmail)
				$shareData=array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'share_status'=>'3');
				//insert banner in share log table
				$this->affiliate_model->insertShareBannerLog($shareData);
				
				$banner_url	= $this->generate_banner_url(array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'affiliate_id'=>$userId));
				$banner['banner_url']	= $banner_url;
				//$banner_options = $this->common_model->getDataFromTabel('banner_option_details','*',array('banner_id'=>$banner_id));
				//$banner['banner_options']	= $banner_options;
				$banner['data'] = $banner_data;
				$banner['testiData'] = $this->common_model->getDataFromTabel('product_testimonial_log','title,description',array('affiliate_id'=>$userId,'banner_id'=>$banner_id));
				
				$content = $this->load->view('gmail_banner_html',$banner,'true'); // Generate Email Content
				$subject = "SyrecoHK : Great Product, Must Buy!";
				foreach($data['userdata'] as $user)
				{
					$email = $user['email'];
					$name  = $user['name'];
					if(empty($name))
					{
						$name = 'Dear';
					}
					
					$content = $this->_parse(array('user_name'=>$name),$content);
					$from = getAdminEmail();
					$this->sendMail($from,$email,$subject,$content);
				}
				echo json_encode(array('status'=>'success'));die;
			}
			else
			{
				echo json_encode(array('message'=>'Data should not empty !','status'=>false));	
			}
		}
		else 
		{
			echo json_encode(array('message'=>'Invalid Request !','status'=>false));	
		}
	}
	
	/*
	* @Function to Login on Twitter 
	*/
	function twitterLogin($bannerId){
	
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// User is already authenticated. Add your user notification code here.
			redirect(base_url('/'));
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url('/affiliate/callback/'.$bannerId));

			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else
			{
				// An error occured. Make sure to put your error notification code here.
				redirect(base_url('/'));
			}
		}
	}
	
	/**
	 * @Function - Twitter Callback, landing page for twitter.
	 * @access	public
	 * @return	void
	 */
	public function callback($bannerId)
	{
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(base_url('/affiliate/auth'));
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
			if ($this->connection->http_code == 200)
			{
				
				$banner_data = $this->common_model->getDataFromTabel('merchant_banner','*', array('banner_id'=>$bannerId));
		
				if(!empty($banner_data)){
					
					$userId			= is_logged_in();
					
					$merchant_id	= $banner_data[0]->merchant_id;
					$banner_id		= $banner_data[0]->banner_id;
					
					$shareData=array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'share_status'=>'2');
					//insert banner in share log table
					$this->affiliate_model->insertShareBannerLog($shareData);
					
					$banner_img = $banner_data[0]->image_url;
					if($banner_data[0]->upload_type==1){
						$banner_img = base_url().$banner_data[0]->upload_path.$banner_data[0]->upload_image_name;
					}
					$file_name = pathinfo($banner_img);
					$imageUrl  = FCPATH.'assets/banner_images/'.$file_name['basename'];
					if($banner_data[0]->upload_type==0){
						file_put_contents($imageUrl,file_get_contents($banner_img));
					}
					$banner_url = $this->generate_banner_url(array('banner_id'=>$banner_id,'merchant_id'=>$merchant_id,'affiliate_id'=>$userId));
					$this->session->set_userdata('tw_access_token', $access_token['oauth_token']);
					$this->session->set_userdata('tw_access_token_secret', $access_token['oauth_token_secret']);
					$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
					$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
					$this->session->unset_userdata('request_token');
					$this->session->unset_userdata('request_token_secret');
					$parameters = array('status'=>"click to buy now {$banner_url}",'media[]'  => "{$imageUrl}");
					$post = $this->connection->post('statuses/update_with_media',$parameters,true);
					if($banner_data[0]->upload_type==0){unlink($imageUrl);}
					$this->load->view('twitter_handler',array('post'=>$post));
				}
				else
				{
					die('Banner Data is empty!!');
				}
			}
			else
			{
				// An error occured. Add your notification code here.
				redirect(base_url('/affiliate/banners'));
			}
		}
	}
	
	/*
	* @Function - Gmail Oauth2 Callback function.
	*
	* */
	function oauth2callback(){
		if (isset($_GET['code'])) 
		{ 
			$this->gClient->authenticate($_GET['code']);
			$_SESSION['token'] = $this->gClient->getAccessToken();
			header('Location: ' . filter_var($this->config->item('google_redirect_url'), FILTER_SANITIZE_URL));
			return;
		}
		if(isset($_SESSION['token'])) 
		{ 
			$this->gClient->setAccessToken($_SESSION['token']);
		}

		if ($this->gClient->getAccessToken()) 
		{
			$accessToken = json_decode($this->gClient->getAccessToken());
			$this->session->set_userdata('gmailOauth',$accessToken);
			//For logged in user, get details from google using access token
			$google_oauthV2 = new Google_Oauth2Service($this->gClient);
			//set request headers for signed OAuth request
			$headers = array("Accept: application/xml");
			$contact_url = "https://www.google.com/m8/feeds/contacts/default/full?max-results=300&"
			."oauth_token=".$accessToken->access_token;
			$email_data = $this->gClient->exportGmailContacts($contact_url, 'GET', $headers); 
		
			//insert gmail contact of affiliate
			$this->affiliate_model->insertAffiliateGmailContact($email_data);
			
			$this->template
			->set('emails', $email_data)
			->build('gmail_contacts');
		}
		else 
		{
			//For Guest user, get google login url
			$authUrl = $this->gClient->createAuthUrl();
		}
	}
	
	function sendMail($from,$to,$subject='',$emailData='')
	{
		$fromName=$this->config->item('email_from_name');
		$this->load->library('email');
		$this->email->from($from,$fromName);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($emailData);
		if (!$this->email->send()) {
			//show_error($this->email->print_debugger()); 
		}
		else {
			return true;
		}
	
		return true;
	}
	
	function generate_banner_url($banner_data){
		if(!empty($banner_data)){
			$encoded_ids	= encode(implode(',',$banner_data));
			return $banner_url = base_url().'services/saveBannerClick/'.$encoded_ids.'/'.encode(REFERRAL_TOKEN).'/';
		}
		else{
			return false;
		}
	}
	
	/**
     * @param $array
     * @param $string
     * @return mixed
     */
    private function _parse($array, $string)
    {
		
        if(empty($string))
            return '';
        foreach($array as $key => $val)
        {
            $string = str_replace('{'.$key.'}', $val, $string);
			
        }
		//echo $string;die;
        return $string;
    }
    
    private function _sn_loader(){
		/*-------------SN Loader Start---------------*/
		
		/*--------Facebook Ouath--------*/
		$this->load->library('facebook');//fb lib
		$this->load->library('csimport'); //Gmail
		$this->load->config('gmail');
		$this->load->library('gmail/src/Google_Client');
		
		/*---Gmail Oauth start---*/
		$this->gClient = new Google_Client();
		$this->gClient->setApplicationName('Login to Sanwebe.com');
		$this->gClient->setClientId($this->config->item('google_client_id'));
		$this->gClient->setClientSecret($this->config->item('google_client_secret'));
		$this->gClient->setRedirectUri($this->config->item('google_redirect_url'));
		$this->gClient->setDeveloperKey($this->config->item('google_developer_key'));
		$this->gClient->setScopes("https://www.google.com/m8/feeds/");
		
		/*-------Twitter Init-------*/
		// Loading TwitterOauth library. Delete this line if you choose autoload method.
		$this->load->library('twitteroauth');
		// Loading twitter configuration.
		$this->config->load('twitter');
		
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// If user already logged in
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
		/*---------------Pinterest Config----------------*/
		$this->load->library('Pinterest_Api');
		/*---------------Pinterest Config----------------*/
		
		
		/*---------------------SN Loader End------------------------*/
	}
	
	function save_affiliate_payment_request()
	{
		$request_data = json_decode($this->input->post('request_data'),true);
		$feedback = $this->affiliate_model->save_affiliate_payment_request($request_data);
		echo json_encode($feedback);die;
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
		$id or redirect('affiliate/testimonial');
		
		$testimonial = $this->affiliate_model->getTestimonial($id);
		$this->template
		->set('testimonial', $testimonial)
		->build('view_testimonial'); 
	}
}
?>
