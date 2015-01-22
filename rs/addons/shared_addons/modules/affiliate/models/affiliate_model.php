<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for backend merchant model 
 * @author		:Rajendra Patidar
 * @package		:Merchant
 *
 */
class Affiliate_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
        $this->memberships = $this->db->dbprefix('memberships');
		$this->membership_features = $this->db->dbprefix('membership_features');
		$this->membership_access = $this->db->dbprefix('membership_access');
		$this->merchant_banner = $this->db->dbprefix('merchant_banner');
		$this->purchase_product = $this->db->dbprefix('banner_payment_log');
		$this->affiliate_configuration = $this->db->dbprefix('affiliate_configuration');
		$this->affiliate_testimonial=$this->db->dbprefix('affiliate_testimonial');
		$this->users_table=$this->db->dbprefix('users');
		$this->merchant_feedback=$this->db->dbprefix('merchant_feedback');
		$this->affiliate_banner_log = $this->db->dbprefix('affiliate_banner_log');
		$this->payment_request = $this->db->dbprefix('referral_payment_request');
		$this->banner_share_log = $this->db->dbprefix('banner_share_log');
		$this->gmail_contact_log = $this->db->dbprefix('gmail_contact_log');
		$this->product_testimonial_log = $this->db->dbprefix('product_testimonial_log');
		$this->affiliate_product_email_log = $this->db->dbprefix('affiliate_product_email_log');
		
	}
		
	/**
	 * Desc   :To get all membship and memberhip feature
	 * @param :void
	 * @return:array
	 */	
	function getAllMemberhipFeature()
	{
		$membershipData=array();
		$query = $this->db->get_where($this->memberships,array('membership_status'=>'0'));
		$memberships= $query->result();

		if(!empty($memberships)){
			foreach($memberships as $membership){
				$this->db->select('mf.*,ma.feature_id	');
				$this->db->from($this->membership_features.' as mf');
				$this->db->join($this->membership_access.' as ma','ma.feature_id =mf.id	','left');
				
				$this->db->where('mf.feature_status','0');
				$this->db->where('ma.membership_id',$membership->id);
				$query = $this->db->get();
				$features=$query->result();
				
				$mdata=array('membership_id'=>$membership->id,
				'membership_title'=>$membership->membership_title,
				'membership_price'=>$membership->membership_price,
				'membership_description'=>$membership->membership_description,
				'created_at'=>$membership->created_at
				);
				$membershipData[]=array('membership'=>$mdata,'features'=>$features);
			}
		}
		return $membershipData;
		
	}
	/**
	 * @Descr  :Get affiliate request banner details
	 * @param  :paymentId
	 * @return :product details object
	 */	
	function getRequestBannerDetails($paymentId)
	{
		$this->db->select('mb.*,pp.banner_quantity,pp.pay_status,pp.order_time,pp.payment_id,pp.affiliate_id,pp.referral_commission,pp.amount,pp.currency');
		$this->db->from($this->purchase_product.' as pp');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =pp.banner_id','left');
		
		$this->db->where('pp.payment_id',$paymentId);			
		$query = $this->db->get();
		$products=$query->row();
	
		return $products;
	}
	
	/**
	 * @Descr  :Get affiliate payment banner details
	 * @param  :request_id
	 * @return :product details object
	 */	
	function getAffiliatePaymentDetails($requestId)
	{
	
		$this->db->select('mb.*,pr.*,pp.banner_quantity,pp.pay_status,pp.order_time');
		$this->db->from($this->payment_request.' as pr');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =pr.banner_id','left');
		$this->db->join($this->purchase_product.' as pp','pp.payment_id =pr.payment_id','left');

		$this->db->where('pr.request_id',$requestId);			
		$query = $this->db->get();
		$products=$query->row();
	
		return $products;
	}
	/**
	 * @Descr  :Get all affliate paid request
	 * @param  :void
	 * @return :puchase product of affiliate
	 */	
	function getAffiliatePaidProduct($limit=0,$offset=0)
	{
		$userId=is_logged_in();
	
		$this->db->select('pp.*,mb.*,u.first_name,u.last_name,pr.payment_status,pr.transaction_date,pr.referral_commission,pr.request_id');
		$this->db->from($this->purchase_product.' as pp');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =pp.banner_id','left');
		$this->db->join($this->users_table.' as u','u.id =mb.merchant_id','left');
		$this->db->join($this->payment_request.' as pr','pr.payment_id =pp.payment_id','left');
		$this->db->order_by("pp.payment_id", "DESC");
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->where('pp.affiliate_id',$userId);
		$this->db->where('pp.ack','Success');	
		$this->db->where('pp.pay_status','0');	
		$this->db->where('pp.affiliate_payment_status','1');	
		
		$query = $this->db->get();
		$products=$query->result();
		
	
		return $products;
	}
	/**
	 * @Descr  :Get all purchased product
	 * @param  :void
	 * @return :puchase product of affiliate
	 */	
	function getAffiliatePaymentRequest($limit=0,$offset=0,$paid=0)
	{
		$userId=is_logged_in();
	
		$this->db->select('pp.*,mb.*,u.first_name,u.last_name,pr.payment_status,pr.transaction_date,pr.request_id');
		$this->db->from($this->purchase_product.' as pp');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =pp.banner_id','left');
		$this->db->join($this->users_table.' as u','u.id =mb.merchant_id','left');
		$this->db->join($this->payment_request.' as pr','pr.payment_id =pp.payment_id','left');
		$this->db->order_by("pp.payment_id", "DESC");
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->where('pp.affiliate_id',$userId);
		$this->db->where('pp.ack','Success');	
		$this->db->where('pp.pay_status','0');
		$this->db->where('pp.affiliate_payment_status','0');		
	
		$query = $this->db->get();
		$products=$query->result();
	
		return $products;
	}
	/**
	 * @Descr  :insert configuration setting
	 * @param  :insert data
	 * @return :insert id
	 */	
	function insertConfig($input,$save='1')
	{
		$userId=is_logged_in();
		$payment_mode=$input['payment_mode'];
		$data= array(
			'user_id'					=> $userId,
			'payment_mode'				=> $input['payment_mode'],
			'email'						=> $input['email'],
			'user_id'					=> $userId,
			'first_name'				=> $input['first_name'],
			'last_name'					=> $input['last_name'],
			'address'					=> $input['address'],
			'created_at'				=> date('Y-m-d H:i:s')
		);
		//payment mode 0 for paypal and 1 for china pay
		if($input['payment_mode']==0){
			$data['paypal_id']=$input['paypal_id'];
		}else{
			$data['chinapay_id']=$input['chinapay_id'];
		}
		
		if($save==true && $payment_mode==0){
			$this->db->insert($this->affiliate_configuration,$data);
			return $this->db->insert_id();
		}if($save==true && $payment_mode==1){
			$this->db->insert($this->affiliate_configuration,$data);
			return $this->db->insert_id();
		}else{
			$this->db->where('user_id', $userId);
			$this->db->where('payment_mode', $input['payment_mode']);
			$this->db->update($this->affiliate_configuration,$data);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
	}
	function chinaPayValidation()
	{
		// Validation rules
		return $this->validation_rules = array(
		array(
				'field' => 'payment_mode',
				'label' => lang('affiliate:payment_mode'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'chinapay_id',
				'label' => lang('affiliate:chinapay_id'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'first_name',
				'label' => lang('global:first_name'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'last_name',
				'label' => lang('global:last_name'),
				'rules' => 'trim|required|'
			),
			
			array(
				'field' => 'address',
				'label' => lang('global:address'),
				'rules' => 'trim|required|max_length[250]'
			)
		);
	}
	public function configValidation()
	{
		
		// Validation rules
		return $this->validation_rules = array(
		array(
				'field' => 'payment_mode',
				'label' => lang('affiliate:payment_mode'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'paypal_id',
				'label' => lang('affiliate:paypal_id'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'trim|required|'
			),
			array(
				'field' => 'first_name',
				'label' => lang('global:first_name'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'last_name',
				'label' => lang('global:last_name'),
				'rules' => 'trim|required|'
			),
			
			array(
				'field' => 'address',
				'label' => lang('global:address'),
				'rules' => 'trim|required|max_length[250]'
			)
		);
	}
	/**
	 * @Desc  :add testimonial
	 * @param :post data
	 * @return:insetId	
	 */
	function addTestimonial($input,$fileName='',$imagePath='')
	{
		
		$user=is_logged_in();
		$data=array(
			'title'				=> $input['title'],
			'affiliate_id'		=> $user,
			'description'		=> $input['description'],
			'created_at'		=> date('Y-m-d H:i:s')
		); 
		//'image_name'		=> $fileName,
		//'image_path'		=> base_url().'/'.$imagePath,
		$this->db->insert($this->affiliate_testimonial,$data);
		return $this->db->insert_id();
	}

	function getALLTestimonial($limit='',$offset='')
	{
		$userId=is_logged_in();
		$this->db->select('at.*,ut.first_name');
		$this->db->from($this->affiliate_testimonial.' as at');
		$this->db->join($this->users_table.' as ut','ut.id =at.affiliate_id','left');
		$this->db->order_by("at.id", "DESC");
		$this->db->where('at.affiliate_id',$userId);
		//$this->db->where('tt.user_id',$userId);
		 if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		$data=$query->result();
		return $data;
	}
	/**
	 * @Desc  :get merchant feedback
	 * @param :void
	 * @return:feedback details	
	 */
	function getMerchantFeedback($limit='',$offset='')
	{
		$userId=is_logged_in();
		$this->db->select('mf.*,ut.first_name');
		$this->db->from($this->merchant_feedback.' as mf');
		$this->db->join($this->users_table.' as ut','ut.id =mf.merchant_id','left');
		$this->db->order_by("mf.id", "DESC");
		$this->db->where('mf.affiliate_id',$userId);
		 if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		$data=$query->result();
		return $data;
	
	}
	/**
	 * @Desc  :get merchant feedback details
	 * @param :id
	 * @return:feedback details
	 */
	function getFeedback($id)
	{
		
		$this->db->select('mf.*,ut.first_name');
		$this->db->from($this->merchant_feedback.' as mf');
		$this->db->join($this->users_table.' as ut','ut.id =mf.merchant_id','left');
		$this->db->where('mf.id',$id);
		$query = $this->db->get();
		$feedback=$query->row();
		return $feedback;
	}
		/*
	 * @descri: upload image
	 * @param: 	img data array
	 * @return 	true or error message
	 * 
	 **/ 
	function upload_image($imgArray) {
			$this->load->library('upload');
			$config = array(
				'allowed_types'=>'gif|jpg|png|jpeg|pdf',
				'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/".$imgArray['image_path'],
			);
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config['file_name'] = $imgArray['image_name'];
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			/********* If file upload successfull than in if other wise else  ***********/
			if($this->upload->do_upload('image_name') && $_FILES["image_name"]["name"]!="")
			{
				$data = array('upload_data' => $this->upload->data());
				$img = $data['upload_data']['file_name'];
				$config['source_image'] = $config['upload_path'].$img;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			
			return $this->upload->display_errors();
	}
	
	function get_affiliates_banners($aff_id){
		$this->db->select('mb.*');
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->join($this->affiliate_banner_log.' as mbl','mb.banner_id =mbl.banner_id');
		$this->db->where('mbl.affiliate_id',$aff_id);
		$query = $this->db->get();
		$feedback=$query->result();
		return $feedback;
	}
	
	function save_affiliate_payment_request($request_data=array())
	{
		if(!empty($request_data))
		{
			$data = array('banner_id'=>$request_data['banner_id'],'merchant_id'=>$request_data['merchant_id'],'referral_commission'=>$request_data['referral_commission'],'product_price'=>$request_data['amount'],'payment_status'=>0,'payment_id'=>$request_data['payment_id'],'currency_type'=>$request_data['currency'],'affiliate_id'=>$request_data['affiliate_id']);
			
			$this->db->insert($this->payment_request,$data);
			$res = $this->db->insert_id();
			if($res)
			{
				return array('status'=>true,'message'=>'Request Successfully Sent !!');
			}
			else
			{
				return array('status'=>false,'message'=>'Unable to respond due to technical error!');
			}
		}
		else
		{
			return array('status'=>false,'message'=>'Request Data is empty');
		}
	}
		/**
	 * @Desc  :get testimonial details
	 * @param :id
	 * @return:testimonial details
	 */
	function getTestimonial($id)
	{
		
		$this->db->select('af.*,ut.first_name');
		$this->db->from($this->affiliate_testimonial.' as af');
		$this->db->join($this->users_table.' as ut','ut.id =af.affiliate_id','left');
		$this->db->where('af.id',$id);
		
		$query = $this->db->get();
		$testimonial=$query->row();
		return $testimonial;
	}
	
	/**
	 * @Desc  :insert share banner details
	 * @param :banner details array
	 * @return:insert id
	 */
	function insertShareBannerLog($data=array())
	{
		$affiliateId= is_logged_in();
		if(!empty($data)){
			
			$data['affiliate_id']=$affiliateId;
			$data['share_date']=date('Y-m-d H:s:i');
			$this->db->insert($this->banner_share_log,$data);
			return $this->db->insert_id();
		}
	}
	
	/**
	 * @Desc  :Get affiliate email contact
	 * @param :Serch Email
	 * @return:void
	 */	
	function getAffiliateGmailContact()
	{
		
		$userId=is_logged_in();
		$this->db->select('afel.*');
		$this->db->from($this->gmail_contact_log.' as afel');
		$this->db->where('afel.affiliate_id',$userId);
		//$this->db->like('afel.contact_email',$searchEmail, 'after');
		
		$query = $this->db->get();
		$contactEmail=$query->result();
	
		return $contactEmail;
	}
	
	/**
	 * @Desc  :insert affiliate product email
	 * @param :post data
	 * @return:insert id
	 */	
	function insertAffiliateProductEmail($input=array())
	{
		$userId=is_logged_in();
		if(!empty($input)){
			$data=array(
			'affiliate_id'		=> $userId,
			'banner_id'			=> $input['banner_id'],
			'email_to'			=> $input["email_to"],
			'created_at'		=> date('Y-m-d H:i:s')
		); 
			
			$this->db->insert($this->affiliate_product_email_log,$data);
			
			return $this->db->insert_id();
		}
		return false;
	}
	
	
	/**
	 * @Desc  :insert product testimonial
	 * @param :post data
	 * @return:insert id
	 */
	function insertProductTestimonial($input=array())
	{
		$userId=is_logged_in();
		
		if(!empty($input)){
			$data=array(
		
			'banner_id'			=> $input['banner_id'],
			'affiliate_id'		=> $userId,
			'title'				=> $input["title"],
			'description'		=> $input['description'],
			'created_at'		=> date('Y-m-d H:i:s')
		); 
			$this->db->where('affiliate_id', $userId);
			$this->db->where('banner_id', $input['banner_id']);
			$this->db->update($this->product_testimonial_log,$data);
			$update=($this->db->affected_rows() > 0) ? TRUE : FALSE;

			if($update){
				return $update;
			}
			$this->db->insert($this->product_testimonial_log,$data);
			return $this->db->insert_id();
		}
	}
	
	/**
	 * @Desc  :insert affiliate email contact to gmail
	 * @param :email array
	 * @return:insert id
	 */
	function insertEmailIntoGmailContact($input)
	{
		$user=is_logged_in();
		
		//array to check for email exists
		$userExistsEmail=array();
		$emails=explode(',',$input);
		
		$contactEmails=$this->common_model->getDataFromTabel('gmail_contact_log','affiliate_id,contact_email',array('affiliate_id'=>$user,'contact_type'=>'1'));
		if(!empty($contactEmails)){
			foreach($contactEmails as $existsEmail){
				$userExistsEmail[]=$existsEmail->contact_email;
			}
		}
		
		if(!empty($emails)){
			foreach($emails as $email){
				//check for exists email
				if(!in_array($email,$userExistsEmail)){
				
					$data=array(
						'affiliate_id'		=> $user,
						'contact_email'		=> $email,
						'contact_type'		=> '1', //contact type for gmail 1
						'created_at'		=> date('Y-m-d H:i:s')
					); 
					$this->db->insert($this->gmail_contact_log,$data);
				}
			}
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	/**
	 * @Desc  :insert contact email of affiliate
	 * @param :email array
	 * @return:insert id
	 */
	function insertAffiliateGmailContact($emails)
	{
		$user=is_logged_in();
		
		//array to check for email exists
		$userExistsEmail=array();
		
		$contactEmails=$this->common_model->getDataFromTabel('gmail_contact_log','affiliate_id,contact_email',array('affiliate_id'=>$user,'contact_type'=>'1'));
		if(!empty($contactEmails)){
			foreach($contactEmails as $existsEmail){
				$userExistsEmail[]=$existsEmail->contact_email;
			}
		}
		
		if(!empty($emails)){
			foreach($emails as $key=>$email){
				//check for exists email
				if(!in_array($email['email'],$userExistsEmail)){
					
					$data=array(
						'affiliate_id'		=> $user,
						'contact_email'		=> $email['email'],
						'contact_type'		=> '1', //contact type for gmail 1
						'created_at'		=> date('Y-m-d H:i:s')
					); 
					$this->db->insert($this->gmail_contact_log,$data);
				}
			}
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
}
