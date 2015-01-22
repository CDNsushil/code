<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
* Class - To perform external operations
* Author- CDNSOL
*/
//REST_Controller
class Services extends REST_Controller {
	
	/*
	* Service Constructor
	**/
	public function __construct(){
		parent::__construct();
		$this->load->model('services_model');
		$this->load->model('merchant/merchant_model');
		$this->load->library('chainPayment/pay_chained');
		
		
	}
	

	/*
	* @Function : set payap request .
	* @Params	: post data of product form
	* @Output : redirect to paypal
	**/
	
	function index_post()
	{
		if($_POST)
		{
			if ($this->input->post())
			{
				
				$productData['banner_color']=$this->input->post('banner_color');
				$productData['banner_size']=$this->input->post('banner_size');
				$productData['banner_price']=$this->input->post('pay_banner_price');
				$productData['banner_info']=$this->input->post('decode_data');
				$productData['product_quantity']='1';
				if($this->input->post('product_quantity')){
					$productData['product_quantity']=$this->input->post('product_quantity');
				}
				if($this->input->post('banner_price'))
				{
					$productData['banner_price']=$this->input->post('pay_banner_price');
				}
				$this->setPaypalExpresscheckout_get($productData);
			}
			else
			{
				$this->session->set_flashdata('error', 'Error');
			}
			
			redirect('');
			
		}
		
		
	}


	/*
	* @Function : Save banner, merchant and affiliate detail while click on banner.
	* @Params : encoded_data(contains banner id,affiliate id,merchant id in single string in encoded form), referral token(security token predefined in config)
	* @Output : redirect to banner product.
	**/
	function saveBannerClick_get($encoded_data='',$referral_token=''){
			
		if(!empty($encoded_data) && !empty($referral_token)) 
		{	$decoded_data = decode($encoded_data);
			$referral_token = decode($referral_token);
			$message = '';
			if($referral_token==REFERRAL_TOKEN) //Check for referral token
			{	$data = explode(',',$decoded_data); 
				if(!empty($data))
				{
					
					//$log_id  = $this->services_model->saveBannerClick($data);// create banner log 
					$bannerDetails= $this->merchant_model->getBanner($data[0]);// get banner details
					
					$banner_size = $this->common_model->getDataFromTabel('banner_option_details','*',array('banner_id'=>$data[0],'option_type'=>'0'));
					$banner_color = $this->common_model->getDataFromTabel('banner_option_details','*',array('banner_id'=>$data[0],'option_type'=>'1'));
				
					if(!empty($banner_size)){
						$renderData['banner_size']=$banner_size;
					}
					if(!empty($banner_color)){
						$renderData['banner_color']=$banner_color;
					}
					if(!empty($bannerDetails))
					{
						$this->services_model->saveBannerClick($data);
						$renderData['_banner']=$bannerDetails;
						$renderData['decode_data']=$decoded_data;
						$this->template->build('index',$renderData); 
						
						return true;

						//$this->setPaypalExpresscheckout_get($bannerDetails,$decoded_data);
						//redirect($bannerDetails->target_url."?redirect_url=".BASE_URL.'services/savePaymentInfo/'.encode($log_id).'/'); 
						//redirect to target product page 
					}
					else
					{
						$message =  "Invalid Banner !!!!!!!!";
					}
				}
				else
				{
					$message =  "Invalid key !!!!!!!!!";
				}
			}
			else
			{
				$message =  "Invalid URL !!!!!!!!!";
			}
		}
		$this->response(array('message'=>$message,'status'=>0),200);
		
	}
	

	
	function savePaymentInfo_get($banner_log_id='',$payment_status=0){
		if(!empty($banner_log_id)){
			$banner_log_id = decode($banner_log_id);
			$status = $this->services_model->savePaymentInfo($banner_log_id,$payment_status);
			if($status)
			{
				$data['message'] = 'Payment Info Successfully Updated !';
				$data['status']  = 1;  
			}
			else
			{
				$data['message'] = 'An error occurred while updating payment info !';
				$data['status']  = 0;
			}
			$this->response($data,200);
		}
		
	}
	
	/*
	* @Function: set paypal details.
	* @Params :	banner data array 
	* @return : redirect to paypal.
	**/
	function setPaypalExpresscheckout_get($productData)
	{
		
		if(!empty($productData))
		{
			
			$reciverData=array();
	
			$banner_info = explode(',',$productData['banner_info']); 
			$bannerData= $this->merchant_model->getBanner($banner_info[0]);// get banner details
			
			$productData['banner_details']=$bannerData;
			if(!empty($bannerData)){
				
				//get admin data
				$adminPaypalId=getAdminPaypalId();
				$referralCommission='0';
				$refCommission=$this->common_model->getReferralPointCommisssion($bannerData->banner_id);
				if(!empty($refCommission)){
					$referralCommission=$refCommission['commission'];
				}
				$bannerPrice=$productData['banner_price']-$referralCommission;
				$productData['banner_price']=$bannerPrice;
				$PRODUCTDATA=encode($productData['banner_color'].','.$productData['banner_size'].','.$productData['banner_price'].','.$productData['product_quantity']);
				
				$BANNERINFO['BANNERINFO']=$productData['banner_info'];
				$BANNERINFO['PRODUCTDATA']=$PRODUCTDATA;
				$bannerInfo=json_encode($BANNERINFO);
				$return_url= base_url().'services/getCheckoutResponse?BANNERDATA='.$bannerInfo.'';
		
				$cancel_url=base_url().'services/getCancelResponse?cencel_url='.$bannerData->cancel_url;
				
				$merchantConfig=$this->common_model->getDataFromTabel('merchant_configuration','paypal_id',array('user_id'=>$bannerData->merchant_id));
				
				if(!empty($merchantConfig))
				{
					$reciver=$merchantConfig[0];
					$reciverData=array('RETURN_URL'=>$return_url,'CENCEL_URL'=>$cancel_url,'product_data'=>$productData,'BANNER_PRICE'=>$productData['banner_price'],'PRODUCT_QUANTITY'=>$productData['product_quantity'],'CURRENCYCODE'=>$bannerData->currency_type);
					
					
					$reciverData[]=array('AMT'=>$referralCommission+$productData['banner_price'],'CURRENCYCODE'=>$bannerData->currency_type,
									'PAYPAL_ID'=>$adminPaypalId,'PRIMARY'=>'true',
								);
					
					$reciverData[]=array('AMT'=>$productData['banner_price'],'CURRENCYCODE'=>$bannerData->currency_type,
									'PAYPAL_ID'=>$reciver->paypal_id,'PRIMARY'=>'false',
								);
				}
				
			
				if(!empty($reciverData)){
					
					$this->pay_chained->DoChainedPayment($reciverData);
				
				}else{
					$this->session->set_flashdata('error','Sorry! Reciver paypal id is not empty');
					redirect('');
				}
			
			}
		}
		else{
				$this->session->set_flashdata('error','Sorry! Request Failed Please Try Again.');
				redirect('');
			}
			
	
	}
	/*
	* @Function:get paypal response after checkout.
	* @Params :	void 
	* @Output : 
	**/
	function getCheckoutResponse_get()
	{
		$referralCommission='0';
			
		if(isset($_REQUEST['BANNERDATA']))
		{
			$BANNERDATA=json_decode($_REQUEST['BANNERDATA']);
			
			$bannerInfo = explode(',',$BANNERDATA->BANNERINFO); 
			
			if(!empty($bannerInfo)){
				$merchantConfig=$this->common_model->getDataFromTabel('merchant_configuration','paypal_id',array('user_id'=>$bannerInfo[1]));
			
				$product_data=explode(',',decode($BANNERDATA->PRODUCTDATA));
			
				$bannerData=array('banner_id'=>$bannerInfo[0],'merchant_id'=>$bannerInfo[1],'affiliate_id'=>$bannerInfo[2]);
				
				$bannerData['banner_color']=$product_data[0];
				$bannerData['banner_size']=$product_data[1];
				$bannerData['banner_price']=$product_data[2];
				$bannerData['product_quantity']=$product_data[3];
				
				$banner_details= $this->merchant_model->getBanner($bannerInfo[0]);// get banner details
				
				$bannerData['banner_details']= $banner_details;
				if(!empty($merchantConfig) && !empty($bannerData) &&  !empty($banner_details))
				{
					$reciver=$merchantConfig[0];
					
					$commission=$this->common_model->getReferralPointCommisssion($bannerInfo[0]); 
					$referralCommission=$commission['commission']; 
					$bannerData['sec_receiver_email']=$reciver->paypal_id;
				
				}
			}else{
				$this->session->set_flashdata('error','Payment Request Failed! Please Try Again.');
				redirect('');
			}
			//set referral point
			
			$bannerData['referral_commission']=$referralCommission;
			$bannerData['referral_point']=$banner_details->referral_point;
			$bannerData['cancel_url']=$banner_details->cancel_url;
			$bannerData['checkout_url']=$banner_details->checkout_url;
			
			if(!empty($bannerData)){
				$payKey=$this->session->userdata('PayKey');

				$secResponse=$this->pay_chained->sendPaymentToSecondryReciver($payKey);
			
				$paypalResponse=$this->pay_chained->getPaymentDetails($payKey);
				
				$this->session->unset_userdata('PayKey');
				//save banner payment details
				$this->services_model->saveBannerPaymentLog($paypalResponse,$bannerData);
				
			}
		
			
		
		
		}
		 redirect('');
	}
	/*
	* @Function:redirect after cencelletion from paypal.
	* @Params :	void 
	* @Output : 
	**/
	function getCancelResponse_get(){
		
		if(!empty($_REQUEST['token']) && !empty($_REQUEST['cencel_url'])){
			$token=$_REQUEST['token'];
			$cencel_url=$_REQUEST['cencel_url'];
			$this->session->set_flashdata('error','Paypal checkout request has been cancelled.');
			
			if($cencel_url.substr(0,4) != 'http'){
				$cencel_url = 'http://'.$cencel_url;
			}
			
			redirect($cencel_url.'?token='.$token);
			return true;
		}
		
		$this->session->set_flashdata('error','Paypal checkout request has been cancelled.');
		redirect('');
	}
	
	


}
?>
