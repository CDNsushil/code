<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  Rajendra
 * @package merchant\Controllers
 */
 class Merchant extends Public_Controller {
        public function __construct(){
			parent::__construct();
	
		$this->load->model('merchant_model');
		
		$this->lang->load('merchant');
		$this->load->helper('frontend');
		$this->template->append_css('module::merchant.css');
		$this->template->append_js('module::merchant.js');

		$userId=is_logged_in();
		// check expired membership date
		if($this->method!='merchant'){
			checkExpiryMemberhipDate();	
		}
	
	if(!empty($userId) && ($this->method!='index')){
			//check for valid user
			isMerchantUser();
		}elseif($this->method!='index'){
			redirect('merchant');
		} 
    }
 
	public function index() {

		//get all membership
		$data['selectFeatures']=$this->merchant_model->getSelectMembershipFeatures();
        
        $this->template
			->title($this->module_details['name'], $this->module_details['name'])
            ->append_metadata($this->load->view('fragments/wysiwyg', array() , true))
            ->set('slug', 'merchants')
			->build('index',$data);
	}
	/**
	 * @Desc	: to view merchant dashbord
	 * @Return	: void
	 * */
	public function dashbord() {
	
		$this->template
		->build('dashbord'); 
	}
	/**
	 * @Desc	: show all merchant banners
	 * @Return	: void
	 * */
	public function sales() {
		
		$page=0;
		//get all sales banner
		$sales=$this->merchant_model->getMerchantPurchasedBanner();
		//to add pagination 
		$uri=base_url()."merchant/sales?";
		$config=$this->common_model->getPagination(count($sales),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		$data["links"] = $this->pagination->create_links(); 
		$data['sales']=$this->merchant_model->getMerchantPurchasedBanner($config["per_page"], $page);
	
		$this->template
		->build('sales',$data); 
	}
	/**
	 * @Desc	: To get all merchant banner
	 * @Param	: void
	 * @Return	: void
	 * */
	 public function banner() {

		$page=0;
		$userId=is_logged_in();
		//get all membership
		$banners=$this->common_model->getDataFromTabel('merchant_banner','*', array('merchant_id'=>$userId,'delete_status'=>0));
		//to add pagination 
		$uri=base_url()."merchant/banner?";
		$config=$this->common_model->getPagination(count($banners),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		//get total click and share count
		$data['bannerClick']=$this->merchant_model->getBannerClickCount();
		$data['bannerShare']=$this->merchant_model->getBannerShareCount();
		$data['banners']= $this->merchant_model->getMerchantBanners($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links(); 
		//to create sidebar menus
		
		//add sidebar
	
		
		$this->template
		->build('banner',$data); 
	}
	
	/**
	 * Desc  : Method for handling different form actions
	 * return: Void
	 * param : Void
	 */
	public function action()
	{
		// Determine the type of action
		switch ($this->input->post('btnAction'))
		{
			case 'Delete':
				$ids=$this->input->post('select_banner');
				$this->deletebanner($ids);
				break;
			default:
				redirect('merchant/banner');
				break;
		}
	}
	
	/**
	 * @Desc	: To filter affiliate banner by banner name
	 * @Param	: banner name by post
	 * @Return	: html content for banner details
	 * */
	function getAffiliateFilterBanner()
	{
	
		$searchWord=$this->input->post('word');	
		$data['purchases']=$this->merchant_model->getMerchantPurchsedProduct('', '',$searchWord);
		echo $this->load->view('affiliate_filter',$data, true);
	
	}
	/**
	 * @Desc	: To filter sales banner by name
	 * @Param	: banner name by post
	 * @Return	: html content for banner details
	 * */
	function getSalesFilterBanner()
	{
		$searchWord=$this->input->post('word');
		
		$data['sales']= $this->merchant_model->getSalesFilterBanner($searchWord);
		echo $this->load->view('sales_filter',$data, true);
	}
	/**
	 * @Desc	: To filter banner by name
	 * @Param	: banner name by post
	 * @Return	: html content for banner details
	 * */
	public function getFilterBanner()
	{
		$searchWord=$this->input->post('word');
		
		$data['bannerClick']=$this->merchant_model->getBannerClickCount();
		$data['bannerShare']=$this->merchant_model->getBannerShareCount();
	
		$data['banners']=$this->merchant_model->getMerchantBanners('','',$searchWord);
		echo $this->load->view('filter',$data, true);
		
	}
	
	public function getURLFilterBanner()
	{
		
		 $searchWord=$this->input->post('word'); 
		$param=array('image_url'=>$searchWord);
		
		$data['banners']=$this->merchant_model->getURLFilterBanner($param);
		echo $this->load->view('filter',$data, true);
		
	}
	/**
	 * @Desc  : To Add Merchant Banner
	 * @Param : void
	 * @Return: void
	 **/
	public function addbanner()
	{
		//check form validtion
		$validation=$this->validateAddBannerFormFields();
		
		$banner = new stdClass();
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$banner->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
		// Are they TRYing to submit?
		if ($_POST)
		{
		
			$imageType=$this->input->post('image_type');
			//check if image is own size
			if($imageType==2){
				$this->form_validation->set_rules('image_width',lang('merchant:width'),'trim|required|');
				$this->form_validation->set_rules('image_height',lang('merchant:height'),'trim|required|');
			}
			if($this->input->post('image_option')){
				$this->form_validation->set_rules('uploaded_img_name','upload image','trim|required|');
			}
			$referralPoint=$this->input->post('referral_point');
			$defaultReferralPoint=$this->input->post('default_referral_point');
			if($referralPoint<$defaultReferralPoint){
				$this->session->set_flashdata('error','Referral point should be greater than '.$defaultReferralPoint.' .');
				redirect('merchant/banner');
			}
			$this->form_validation->set_rules($this->validation_rules);
			
			if ($this->form_validation->run())
			{
				if ($id =$this->merchant_model->insertBanner($this->input->post()))
				{
					$this->session->set_flashdata('success', sprintf(lang('merchant:add_success'), $this->input->post('banner_name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('merchant:add_error'), $this->input->post('banner_name')));
				}
				redirect('merchant/banner');
			}else{
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->form_validation->error_string();
				set_global_messages($msg,'error');
			}
		}
		
		//get referral point details
		$referralPoint = $this->common_model->getDataFromTabel('admin_configuration','*');
	
		
		$data['banner_heading']= lang('merchant:add_banner');
		if(!empty($referralPoint)){
			$referral=$referralPoint[0];
			$data['referral_point']=$referral->minimum_referral_point;
		}
	
		$currencyArray=$this->common_model->getCorrencies();
		$data['currencies']=$currencyArray;
		$this->template
		->set('_banner', $banner)
		->build('add_banner',$data); 
	}
	/**
	 * @Desc  : Edit Merchant Banner
	 * @Param : bannerId
	 * @Return: void
	 **/
	public function editbanner($id)
	{
		$id=decode($id);
		$banner = $this->merchant_model->getBanner($id);
	
		// Make sure we found something
		$banner or redirect('merchant/banner');
		//check form validtion
		$validation=$this->validateAddBannerFormFields();
	
		// Are they TRYing to submit?
		if ($_POST)
		{
			$imageType=$this->input->post('image_type');
			//check if image is own size
			if($imageType==2){
				$this->form_validation->set_rules('image_width',lang('merchant:width'),'trim|required|max_length[2]');
				$this->form_validation->set_rules('image_height',lang('merchant:height'),'trim|required|max_length[2]');
			}
			if($this->input->post('image_option')){
				$this->form_validation->set_rules('uploaded_img_name',' upload image','trim|required|');
			}
			$this->form_validation->set_rules($this->validation_rules);
			
			if ($this->form_validation->run())
			{
				
				if ($id =$this->merchant_model->updateBanner($id, $this->input->post()))
				{
					$this->session->set_flashdata('success', sprintf(lang('merchant:update_msg'), $this->input->post('banner_name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('merchant:request_error'), $this->input->post('banner_name')));
				}
				redirect('merchant/banner');
			}else{
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
				$msg=$this->form_validation->error_string();
				set_global_messages($msg,'error');
			}
		}
		$data['banner_heading']= lang('merchant:edit_banner');
		$currencyArray=$this->common_model->getCorrencies();
		$data['currencies']=$currencyArray;
		//get banner option
		$options=$this->common_model->getDataFromTabel('banner_option','*',array('banner_id'=>$id));
		if(!empty($options)){
			$data['options']=$options[0];
		}
		//get banner options details
		$optionDetails=$this->common_model->getDataFromTabel('banner_option_details','*',array('banner_id'=>$id));
		$data['optionDetails']=$optionDetails;
		$data['banner_id']=$id;
		$this->template
		->set('_banner', $banner)
		->build('add_banner',$data); 
	}
	
	/**
	 * @Desc	:  Validation for add banner form fields
	 * @Param	:  post field data
	 * @Return	:  message
	 **/
	public function validateAddBannerFormFields()
	{
		
		// Validation rules
		return $this->validation_rules = array(
			array(
				'field' => 'banner_name',
				'label' => lang('merchant:banner_name'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'banner_description',
				'label' => lang('merchant:description'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'referral_point',
				'label' => lang('merchant:referral_point'),
				'rules' => 'trim|required|numeric|max_length[5]'
			),
			
			array(
				'field' => 'image_url',
				'label' => lang('merchant:image_url'),
				'rules' => 'trim|max_length[250]'
			),
			array(
				'field' => 'banner_price',
				'label' => lang('merchant:banner_price'),
				'rules' => 'trim|required|max_length[20]'
			),
			array(
				'field' => 'image_type',
				'label' => lang('merchant:image_type'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'image_url',
				'label' => lang('merchant:image_url'),
				'rules' => 'trim|max_length[250]'
			),
			array(
				'field' => 'cancel_url',
				'label' => lang('merchant:cancel_url'),
				'rules' => 'trim|required|max_length[250]'
			),
			array(
				'field' => 'checkout_url',
				'label' => lang('merchant:checkout_url'),
				'rules' => 'trim|required|max_length[250]'
			),
				array(
				'field' => 'image_width',
				'label' => lang('merchant:width'),
				'rules' => 'trim|max_length[3]'
			),
				array(
				'field' => 'image_height',
				'label' => lang('merchant:height'),
				'rules' => 'trim|max_length[3]'
			),
				array(
				'field' => 'item_id',
				'label' => lang('merchant:item_id'),
				'rules' => 'trim|max_length[25]'
			),
				array(
				'field' => 'tax_rate',
				'label' => lang('merchant:tax_rate'),
				'rules' => 'trim|max_length[10]'
			),
			array(
				'field' => 'banner_price',
				'label' => lang('merchant:banner_price'),
				'rules' => 'trim|required|max_length[10]'
			),
			array(
				'field' => 'banner_postage',
				'label' => lang('merchant:banner_postage'),
				'rules' => 'trim|max_length[100]'
			),
				array(
				'field' => 'upload_type',
				'label' => lang('merchant:upload_type'),
				'rules' => 'trim'
			),
				array(
				'field' => 'upload_image_name',
				'label' => lang('merchant:uploaded_image_name'),
				'rules' => 'trim|max_length[250]'
			),
				array(
				'field' => 'currency_type',
				'label' => lang('merchant:currency_type'),
				'rules' => 'trim|max_length[5]'
			),
				array(
				'field' => 'customisesize',
				'label' => 'Customise Color',
				'rules' => 'trim|max_length[150]'
			),
			array(
				'field' => 'customisecolor',
				'label' => 'Customise Size',
				'rules' => 'trim|max_length[150]'
			),
			array(
				'field' => 'shipping_address',
				'label' => 'Customer shipping address',
				'rules' => 'trim|max_length[1]'
			),
			array(
				'field' => 'change_order',
				'label' => 'Customer change order quantities',
				'rules' => 'trim|max_length[1]'
			),
			
		);
	}
	
	/**
	 * @Desc	:  view merchant banner details
	 * @Param	:  bannerId
	 * @Return	:  void
	 **/
	public function viewbanner($id)
	{
		$id=decode($id); 
		$userId=is_logged_in();
		//get banner details

		$banner = $this->merchant_model->getBannerPurchaseCount($id);
		
		// Make sure we found data
		$id or redirect('merchant/banner');
		$banner or redirect('merchant/banner');
		
		if(!empty($banner)){
			//get referral commission
			$refCommission=$this->common_model->getReferralPointCommisssion($id);
			if(!empty($refCommission)){
				$data['refCommission']=$refCommission;
			}
			
			//to check banner in array for click count
			$bannerClick=$this->merchant_model->getBannerClickCount();
		
			if(!empty($bannerClick)){
				if(array_key_exists($banner->banner_id,$bannerClick)){
					 $data['banner_click']=$bannerClick[$banner->banner_id];
				}
			}
			//to check banner in array for share count
			$bannerShare=$this->merchant_model->getBannerShareCount();
			if(!empty($bannerShare)){
				if(array_key_exists($banner->banner_id,$bannerShare)){
					 $data['banner_share']=$bannerShare[$banner->banner_id];
				}
			}
					
			$data['bannerEncodeID']=encode($id);
			
			$data['banner_heading']= lang('merchant:view_banner');
			$this->template
			->set('_banner', $banner)
			->build('view_banner',$data); 
		}
	}
	/**
	 * @Desc	:  Delete merchant banner
	 * @Param	:  bannerIds
	 * @Return	:  message
	 **/
	public function deletebanner($id)
	{
		
		if ($success = $this->merchant_model->deleteBanner($id))
		{
			$this->session->set_flashdata('success', lang('merchant:banner_delete_msg'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('merchant:request_error'));
		} 
		redirect('merchant/banner');
	}
	/**
	 * @Desc	:  get all affiliate who purchased merchant product
	 * @Param	:  void
	 * @Return	:  merchant affiliate details
	 **/
	public function affiliates()
	{
		$page=0;
		$userId=is_logged_in();
		//get all purchased
		$purchases=$this->merchant_model->getMerchantPurchsedProduct();
		//to add pagination 
		$uri=base_url()."merchant/affiliates?";
		$config=$this->common_model->getPagination(count($purchases),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}

		$data["links"] = $this->pagination->create_links(); 
		$data['purchases']=$this->merchant_model->getMerchantPurchsedProduct($config["per_page"], $page);
		$this->template
			->build('affiliates',$data); 
	}
	/**
	 * @Desc	:  get all pruchased product affilite wise
	 * @Param	:  affId
	 * @Return	:  product payment details
	 **/
	function purchaseview($affId)
	{
		$products=$this->merchant_model->getPurchaseProduct($affId);
		if(!empty($products)){
			foreach($products as $product){
				$data['form_heading']= lang('merchant:affiliate').' > '.ucfirst($product->first_name);
				break;
			}
		}
		
		$data['products']=$products;
			$this->template
			->build('purchase_view',$data); 
	}
	/**
	 * @Desc	:  get all payment details for affiliate
	 * @Param	:  void
	 * @Return	:  payment details
	 **/
	function payout()
	{
		//add sidebar
	
		$data['products']=$this->merchant_model->getMerchantPurchsedProduct();
		$data['form_heading']= lang('merchant:affiliate').' > '.lang('merchant:payout');
		$this->template
			->build('affiliate_payout',$data); 
	}
	/**
	 * @Desc	:  add configuration setting
	 * @Param	:  void
	 * @Return	:  msg
	 **/
	function configuration()
	{
		$userId=is_logged_in();
		
		//get mechant configuration settings
		$merchant = $this->merchant_model->getMerchantConfig();
	
		//set validation 
		$validation=$this->merchant_model->configValidation();
		
		$config = new stdClass();
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$config->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
		$save=true;
		if(!empty($merchant)){
			$config=$merchant;
			if($config->paypal_id!=''){
				$save=false;
			}
		
		}
	
		// Are they TRYing to submit?
		if ($_POST)
		{
			
			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run())
			{
				if ($id =$this->merchant_model->insertConfig($this->input->post(),$save))
				{
					if($save){
						$this->session->set_flashdata('success', lang('merchant:add_config_setting'));
					}else{
						$this->session->set_flashdata('success', lang('merchant:update_config_setting'));
					}
				}
				else
				{
					$this->session->set_flashdata('error',lang('global:error_msg'));
				}
				redirect('merchant/configuration');
			}else{
				// Return the validation error
				$this->template->error_string = $this->form_validation->error_string();
			}
		}
		//add sidebar
	
		$this->template
		->set('_config', $config)
		->build('configuration'); 
	}
	
	/*
	 * @Description	:This funtion used to add merchant feedback
	 * @param		:void
	 * @return		:msg
	*/
	function addfeedback()
	{
		$page='';
		$userId=is_logged_in();
		if(!$userId){
			redirect('');
		}
		
		$testimonial = new stdClass();
		//set validate fields
		$validation=$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('global:title'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => lang('global:description'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'affiliate_id',
				'label' => lang('global:affiliate'),
				'rules' => 'trim|required'
			)
		);	
		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);
			if ($this->form_validation->run())
			{
				if ($id =$this->merchant_model->addMerchantFeedback($this->input->post()))
				{
					$this->session->set_flashdata('success',lang('global:success_testimonials'));
					redirect('merchant/feedback');
				}
				else
				{
					$this->session->set_flashdata('error', lang('global:error_msg'));
					redirect('merchant/feedback');
				}
			}else{
					$this->session->set_flashdata('error',lang('global:error_msg'));
					redirect('merchant/feedback');
			}
		}
		// Set default values as empty or POST values
		foreach ($validation as $rule)
		{
			$testimonial->{$rule['field']} = $this->input->post($rule['field']) ? escape_tags($this->input->post($rule['field'])) : null;
		}
		//get all affiliate which is purchase merchant products
	
		$data['affiliates']=$this->merchant_model->getMerchantPurchsedProduct();
		
		//get all merchant feedback
		$testimonials=$this->common_model->getDataFromTabel('merchant_feedback','*', array('merchant_id'=>$userId));
		//to add pagination 
		$uri=base_url()."merchant/feedback?";
		$config=$this->common_model->getPagination(count($testimonials),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		
		$data['testimonials']= $this->common_model->getDataFromTabel('merchant_feedback','*',array('merchant_id'=>$userId),'','id','DESC',$config["per_page"], $page);
		$data["links"] = $this->pagination->create_links(); 
		//to create sidebar menus
		
		$this->template
			->set('_testimonial', $testimonial)
		->build('add_testimonial',$data); 
	}
	
	/**
	 * @Desc	:  remove testimonial
	 * @Param	:  testimonial id
	 * @Return	:  void
	 **/
	function removefeedback($id='')
	{
		
		$result=$this->common_model->deleteRow('merchant_feedback',array('id'=>$id));
		if($result){
			
			$this->session->set_flashdata('success',lang('merchant:remove_feedback_msg'));		
		}else{
			$this->session->set_flashdata('error',lang('global:error_msg'));	
			
		}
		redirect('merchant/feedback');
	}
	
	/**
	 * @Desc  :Export merchant sale banner details
	 * @param :void
	 * @return:merchant sales banner details csv file	
	 */
	function exportMerchantSalesCSV()
	{
		$this->load->helper('download');
		$this->load->library('format');
		$this->merchant_model->exportMerchantSalesCSV();
	}
	/**
	 * @Desc  :export CSV for affiliate banner details
	 * @param :void
	 * @return:banner csv file	
	 */
	function exportAffiliateCSV()
	{
		$this->load->helper('download');
		$this->load->library('format');
		$this->merchant_model->exportAffiliateCSV();
		
	}
	/**
	 * @Desc  :Download for all banner
	 * @param :void
	 * @return:banner csv file	
	 */
	function exportBannerCSV()
	{
		$this->load->helper('download');
		$this->load->library('format');
		
		$this->merchant_model->exportBannerCSV();
	}
	/**
	 * @Desc  :upload banner csv
	 * @param :void
	 * @return:banner csv file	
	 */
	function upload_CSV()
	{
		
		if ($_POST){
	
			$fileName=rand().$_FILES['file_name']['name'];
			if($this->merchant_model->upload_CSV($fileName)){
				$this->session->set_flashdata('success','File uploaded successfully!');	
			}else{
				$this->session->set_flashdata('error',lang('global:error_msg'));	
			}
			redirect('merchant/upload-CSV');
		}
		$this->template
		->build('upload_csv');
	}
	/**
	 * @Desc	:  Download banner CSV
	 * @Param	:  void
	 * @Return	:  void
	 **/
	function getBannerCSV()
	{
		$this->load->helper('download');
		$this->load->library('format');
		$this->merchant_model->exportCSV();
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
		$id or redirect('merchant/feedback');
		
		$feedback=$this->merchant_model->getMerchantFeedback($id);
		$this->template
			->set('feedback', $feedback)
		->build('view_feedback');
	}
	
	function uploadImage(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		// Settings
		$targetDir = FCPATH.'/assets/banner_images';
		//$targetDir='http://localhost/referralsystem/php/plupload'; 
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		// Remove old temp files	
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}	


		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {	
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
	
}
?>
