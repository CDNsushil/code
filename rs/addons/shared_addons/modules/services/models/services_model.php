<?php
/*
* Class - To perform business logic operations
* Author- CDNSOL
*/
class Services_model extends MY_Model
{
	/*
	* Service Model Constructor
	**/
	public function __construct()
	{
		parent::__construct();
		$this->banner_click_log=$this->db->dbprefix('banner_click_log');
		$this->banner_payment_log=$this->db->dbprefix('banner_payment_log');
		
	}
	
	/*
	* @Function : Save banner, merchant and affiliate detail.
	* @Params   : data(banner id,affiliate id,merchant id) array
	* @Output   : Bool(true/false).
	**/
	function saveBannerClick($data=array()){
		if(!empty($data))
		{
			
			$banner_log_data['banner_id']		= $data[0];
			$banner_log_data['merchant_id']		= $data[1];
			$banner_log_data['affiliate_id']	= $data[2];
			$this->db->insert($this->banner_click_log,$banner_log_data);
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	
	/*
	* @Function : To save payment info.
	* @Params   : 
	* @Output   : 
	**/
	function savePaymentInfo($banner_log_id='',$payment_status){
		if(!empty($banner_log_id))
		{
			$data['payment_status'] = $payment_status;
			$this->db->where('banner_log_id', $banner_log_id);
			$this->db->update($this->banner_click_log,$data);
			return TRUE;
		}
		else
		{
			return false;
		}
	}
	/*
	* @Function : To save banner payment info.
	* @Params   : Payment details array
	* @Output   : 
	**/
	function saveBannerPaymentLog($response=array(),$bannerData=array())
	{
		
		if(array_key_exists('Ack',$response) && $response['Ack']=='Success')
		{
			$saveData=array();
			$saveData['ack']=$response['Ack'];
			$saveData['pay_key']=$response['PayKey'];
			$saveData['tracking_id']=$response['TrackingID'];
			
			$saveData['banner_id']=$bannerData['banner_id'];
			$saveData['merchant_id']=$bannerData['merchant_id'];
			$saveData['affiliate_id']=$bannerData['affiliate_id'];
			
			$saveData['banner_color']=$bannerData['banner_color'];
			$saveData['banner_size']=$bannerData['banner_size'];
			$saveData['banner_price']=$bannerData['banner_price'];
			$saveData['banner_quantity']=$bannerData['product_quantity'];
			$saveData['referral_commission']=$bannerData['referral_commission'];
			$saveData['currency']=$response['CurrencyCode'];
			
			$saveData['txn_id']=$response['PaymentInfo']['TransactionID'];
			$saveData['currency']=$response['CurrencyCode'];
			$saveData['sender_email']=$response['SenderEmail'];
			$saveData['order_time']=date('Y-m-d H:s:i');
			
			//primary reciever
			$saveData['receiver_email']=$response['Receiver']['Email'];
			$saveData['total_txn_amt']=$response['Receiver']['Amount'];
			$saveData['amount']=$bannerData['referral_commission']*$bannerData['product_quantity'];
			
			$saveData['pay_status']=0;
			$this->db->insert($this->banner_payment_log,$saveData);
			
		
			$saveData['receiver_email']=$bannerData['sec_receiver_email'];
			$saveData['amount']=$saveData['total_txn_amt']-($bannerData['referral_commission']*$bannerData['product_quantity']);
			$saveData['pay_status']=1;
			$this->db->insert($this->banner_payment_log,$saveData);
			
		
			if(!empty($bannerData))
			{
				if(array_key_exists('banner_details',$bannerData) && !empty($bannerData['banner_details']))
				{
					$bannerDetails=$bannerData['banner_details'];
					if($bannerDetails->checkout_url!=''){
						
						$response['Item']=$bannerDetails->banner_name;
						$response['Item']=$bannerDetails->banner_name;
						$response['banner_color']=$bannerData['banner_color'];
						$response['banner_size']=$bannerData['banner_size'];
						$response['Item']=$bannerDetails->banner_name;
						$response['item_id']=$bannerDetails->item_id;
						$response['banner_description']=$bannerDetails->banner_description;
						$response['referral_point']=$bannerDetails->referral_point;
						$response['cancel_url']=$bannerDetails->cancel_url;
						$response['checkout_url']=$bannerDetails->checkout_url;
						
						$url=$bannerDetails->checkout_url;
						
						//send paypal response to checkout url
						$this->sendPaypalResponse($response,$url);
						$this->session->set_flashdata('success','Payment has been sent sucessfully.');
						
						if($url.substr(0,4) != 'http'){
							$url = 'http://'.$url;
						 }
						redirect($url);
					}
				}
				
				$this->session->set_flashdata('success','Payment has been sent sucessfully.');
				redirect('');
			}
		}
		else{
		
			$this->session->set_flashdata('error','Payment Request Failed! Please Try Again.');
			redirect('');
		}
	}


	/*
	* @Function : Send respose to checkout Url
	* @Params   : paypal response array
	* @Output   : void
	**/
	function sendPaypalResponse($postArray=array(),$url)
	{
		
		if(!empty($postArray) && !empty($url))
		{
		
			$resp =array();
			//--Make query string from post data
			$postData = http_build_query($postArray);
			
			//log_message("ERROR","Function Name:: ".$function." Action Starts");
		
			//echo $CI->config->item('common_api_path');
			//--Send API request using curl
			//echo $CI->config->item('common_api_path').$function;die;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS,  $postData);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch,CURLOPT_TIMEOUT,30);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$resp = curl_exec($ch);

			return json_decode($resp);
			
		}
		
	}

}
