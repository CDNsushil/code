<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for request module 
 * @author		:Rajendra Patidar
 * @package		:Request
 *
 */
class Admin_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		
		$this->users_table = $this->db->dbprefix('users');
		$this->referral_payment_request = $this->db->dbprefix('referral_payment_request');
		$this->merchant_banner = $this->db->dbprefix('merchant_banner');
		$this->affiliate_configuration = $this->db->dbprefix('affiliate_configuration');
		$this->banner_payment_log = $this->db->dbprefix('banner_payment_log');
			
		
	}
	
	/**
	 * @Description	:fun to get affiliate request details 
	 * @Param 		:requestId
	 * @Return		:array of banner details with affiliate name
	 *
	 */
	function getAffiliateRequestsDetials($requestId)
	{

		$this->db->select('rpr.*,ut.first_name,mb.banner_name');
		$this->db->from($this->referral_payment_request.' as rpr');
		$this->db->join($this->users_table.' as ut','ut.id =rpr.affiliate_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =rpr.banner_id','left');
		
		$this->db->where('rpr.request_id',$requestId);
	
		$query = $this->db->get();
		$request=$query->row();
	
		return $request;
	}
	/**
	 * @Description	:fun to get affiliate request details 
	 * @Param 		:limit, offset,payStatus for fileter
	 * @Return		:array of banner details with affiliate name
	 *
	 */
	function getAffiliateRequests($limit=0,$offset=0,$payStatus='')
	{
		$userId=is_logged_in();
		$this->db->select('rpr.*,ut.first_name,mb.banner_name');
		$this->db->from($this->referral_payment_request.' as rpr');
		$this->db->join($this->users_table.' as ut','ut.id =rpr.affiliate_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =rpr.banner_id','left');
		
		$this->db->order_by("rpr.request_id", 'DESC');
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		
		if($payStatus!=''){
				$this->db->where('rpr.payment_status',$payStatus);
		}
		$query = $this->db->get();
		$request=$query->result();
	
		return $request;
	}
	
	/**
	 * @Description	:get request details with affiliate paypal id
	 * @Param 		:requestId
	 * @Return		:request object
	 *
	 */
	function getAffiRequestDetails($requestId=0)
	{
		$userId=is_logged_in();
		$this->db->select('rpr.*,ac.paypal_id');
		$this->db->from($this->referral_payment_request.' as rpr');
		$this->db->join($this->affiliate_configuration.' as ac','ac.user_id =rpr.affiliate_id AND ac.payment_mode=0','left');
		//$this->db->where('ac.payment_mode','0');
		$this->db->where('rpr.request_id',$requestId);
		$query = $this->db->get();
		$request=$query->row();
	
		return $request;
	}
	
	/**
	 * @Description	:save affiliate payment details
	 * @Param 		:paypal response
	 * @Return		:msg
	 */
	function saveAffiliatePaymentDetails($request=array())
	{
		if(array_key_exists('ACK',$request) && $request['ACK']=='Success')
		{
			$this->db->where('banner_id',$request['banner_id']);
			$this->db->where('affiliate_id',$request['affiliate_id']);
			$this->db->update($this->banner_payment_log,array('affiliate_payment_status'=>1));
			
			
			$data['token_id']=$request['TOKEN'];
			$data['txn_id']=$request['PAYMENTINFO_0_TRANSACTIONID'];
			$data['payment_status']='1';
			$data['transaction_date']=date('Y-m-d H:i:s');
			$this->db->where('request_id', $request['request_id']);
			$this->db->update($this->referral_payment_request,$data);
			
			$this->session->set_flashdata('success',lang('request:affi_payment_sent_msg'));
			redirect('admin/request/index');
			
		}
		else{
			$this->session->set_flashdata('error','Sorry! Request Failed. Please Try Again.');
			redirect('admin/request/index');
		}
	}
	
	/**
	 * @Description	:get merchant payments
	 * @Param 		:limit, offset for fileter
	 * @Return		:array of banner details with merchant name
	 *
	 */
	function getMerchantPayments($limit=0,$offset=0)
	{
		$userId=is_logged_in();
		$this->db->select('bpl.*,ut.first_name,mb.banner_name');
		$this->db->from($this->banner_payment_log.' as bpl');
		$this->db->join($this->users_table.' as ut','ut.id =bpl.merchant_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =bpl.banner_id','left');
		
		$this->db->order_by("bpl.payment_id", 'DESC');
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->where('bpl.pay_status','1');
		$query = $this->db->get();
		$request=$query->result();
	
		return $request;
	}
	/**
	 * @Description	:get merchant payment details
	 * @Param 		:payment Id
	 * @Return		:object of banner details with merchant name
	 *
	 */
	function getMerchantPaymentDetails($paymentId)
	{
		$userId=is_logged_in();
		$this->db->select('bpl.*,ut.first_name,mb.banner_name');
		$this->db->from($this->banner_payment_log.' as bpl');
		$this->db->join($this->users_table.' as ut','ut.id =bpl.merchant_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =bpl.banner_id','left');
		
		$this->db->where('bpl.payment_id',$paymentId);
		$query = $this->db->get();
		$result=$query->row();
		return $result;
	}
}
