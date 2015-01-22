<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package :Membership Type
 * @Author  :Rajendra Patidar
 */
 class Admin extends Admin_Controller {
	 
	public function __construct(){
			parent::__construct();
			$this->lang->load('request');
			$this->load->model('admin_model');
			$this->load->library('form_validation');
			$this->template
			->append_css('module::request.css');
			
	}

 /**
	 * @Desc  :  get all paid unpaid request
	 * @Author:  Rajendra patidar
	 * @Return:  array of request
	 * @Param :  pay status
	 */
	function index($payStatus='') {
		
		$page=0;
		$userId=is_logged_in();
		//get all request
		$requests=$this->common_model->getDataFromTabel('referral_payment_request','*');
		//to add pagination 
		$uri=base_url()."admin/request/index?";
		$config=$this->common_model->getPagination(count($requests),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
		$data['pay_status']=$payStatus;
		$data["links"] = $this->pagination->create_links(); 
		
		$data['requests']=$this->admin_model->getAffiliateRequests($config["per_page"], $page,$payStatus);
		
		
		$this->template
		->build('index',$data);	

	}
	
	 /**
	 * @Desc  :  get all merchant payment details
	 * @Return:  array
	 * @Param :  void
	 */
	function viewRequest($id)
	{
		
		$request = $this->admin_model->getAffiliateRequestsDetials($id);
		// Make sure we found data
		$request or redirect('admin/request/index');
	
		$this->template
			->set('_request', $request)
			->build('view_request'); 
	}
	 /**
	 * @Desc  :  get merchant payment details 
	 * @Return:  void
	 * @Param :  paymentId
	 */
	function viewMerchantPayment($id)
	{
		$id=decode($id);
		$payment = $this->admin_model->getMerchantPaymentDetails($id);
		
		// Make sure we found data
		$payment or redirect('admin/request/merchantPayment');
	
		$this->template
			->set('payment', $payment)
			->build('view_merchant_payment'); 
	}
	 /**
	 * @Desc  :  get all merchant payment details
	 * @Return:  array
	 * @Param :  void
	 */
	function merchantPayment()
	{
	
		$page=0;
		$userId=is_logged_in();
		//get all membership
		$payments=$this->common_model->getDataFromTabel('banner_payment_log','*',array('pay_status'=>'1'));
		//to add pagination 
		$uri=base_url()."admin/request/merchantPayment?";
		$config=$this->common_model->getPagination(count($payments),$uri);
		if(isset($_GET['per_page'])){ 
			$page= $_GET['per_page'];
		}
	
		$data["links"] = $this->pagination->create_links(); 
		
		$data['payments']=$this->admin_model->getMerchantPayments($config["per_page"], $page);
	
		$this->template
		->build('merchant_payment',$data);	
	}
	
	 /**
	 * @Desc  :  set Affilialte Payment
	 * @Return:  void
	 * @Param :  id
	 */
	function setAffiliatePayment($requestId=0)
	{
		$this->load->library('payments_pro');
		$request=$this->admin_model->getAffiRequestDetails($requestId);
		
		if(!empty($request)){
		
			$data['amt']=$request->referral_commission;
			$data['return_url']=base_url().'admin/request/getPaypalResponse/?&rid='.$requestId;
			$data['cancel_url']=base_url().'admin/request/getPaypalResponse/?&rid='.$requestId;
			$data['currency_code']=$request->currency_type;
			
			$this->payments_pro->Set_express_checkout($data);
			
		}
	}
	
		/*
	 * @Description	:This funtion used to get paypal response
	 * @param		:void
	 * @return		:msg
	*/
	function getPaypalResponse()
	{
		$this->load->library('payments_pro');
		$user=is_logged_in();
		if(isset($_REQUEST['PayerID']) && isset($_REQUEST['rid']))
		{
			$request=$this->admin_model->getAffiRequestDetails($_REQUEST['rid']);
			if(!empty($request)){
				
				$_REQUEST['amt']=$request->referral_commission;
				$_REQUEST['currency_type']=$request->currency_type;
				$_REQUEST['paypal_id']=$request->paypal_id;
			
				$result=$this->payments_pro->Do_express_checkout_payment($_REQUEST);
			
				$result['request_id']=$_REQUEST['rid'];
				$result['banner_id']=$request->banner_id;
				$result['affiliate_id']=$request->affiliate_id;
				$this->admin_model->saveAffiliatePaymentDetails($result);
				
			}
		}
		$this->session->set_flashdata('error','Sorry! Request Failed. Please Try Again.');
		redirect('admin/request/index');
	}
 
}
?>
