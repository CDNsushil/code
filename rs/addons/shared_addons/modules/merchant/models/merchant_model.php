<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for backend merchant model 
 * @author		:Rajendra Patidar
 * @package		:Merchant
 *
 */
class Merchant_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		
		$this->memberships = $this->db->dbprefix('memberships');
		$this->membership_features = $this->db->dbprefix('membership_features');
		$this->membership_access = $this->db->dbprefix('membership_access');
		$this->merchant_banner = $this->db->dbprefix('merchant_banner');
		$this->users_table = $this->db->dbprefix('users');
		$this->banner_payment_log = $this->db->dbprefix('banner_payment_log');
		$this->merchant_configuration = $this->db->dbprefix('merchant_configuration');
		$this->merchant_feedback=$this->db->dbprefix('merchant_feedback');
		$this->banner_option=$this->db->dbprefix('banner_option');
		$this->banner_option_details=$this->db->dbprefix('banner_option_details');
		$this->banner_payment_log=$this->db->dbprefix('banner_payment_log');
		$this->banner_click_log=$this->db->dbprefix('banner_click_log');
		$this->banner_share_log = $this->db->dbprefix('banner_share_log');
		
	}
		
	/**
	 * Descrip:to get select membship and feature
	 * @param :void
	 * @return:array
	 */	
	
	public function getSelectMembershipFeatures()
	{
		$membershipData=array();
		$query = $this->db->get_where($this->memberships,array('membership_status'=>'0'));
		$memberships= $query->result();

		if(!empty($memberships)){
			foreach($memberships as $membership){
				$this->db->select('mf.*');
				$this->db->from($this->membership_features.' as mf');
				$this->db->join($this->membership_access.' as ma','ma.feature_id =mf.id	','left');
				
				$this->db->where('mf.feature_status','0');
				$this->db->where('ma.membership_id',$membership->id);
				$query = $this->db->get();
				$features=$query->result();
				
				$membershipData[]=array('membership'=>$membership,'features'=>$features);
			}
		}
		return $membershipData;
		
	}
	/**
	 * @Descr  :insert merchant banner details
	 * @param  :post data
	 * @return :array
	 */	
	public function insertBanner($input = array())
	{
		$userId=is_logged_in();
	
		
		$uploadImgPath='';
		if($input['image_option']==1){
			$uploadImgPath='assets/banner_images/';
		}
	
		$data= array(
			'merchant_id'				=> $userId,
			'banner_name'				=> $input['banner_name'],
			'item_id'					=> $input['item_id'],
			'banner_price'				=> $input['banner_price'],
			'currency_type'				=> $input['currency_type'],
			'banner_postage'			=> $input['banner_postage'],
			'tax_rate'					=> $input['tax_rate'],
			'change_order'				=> $input['change_order'],
			'shipping_address'			=> $input['shipping_address'],
			'cancel_url'				=> $input['cancel_url'],
			'checkout_url'				=> $input['checkout_url'],
			'upload_path'				=> $uploadImgPath,
			'upload_image_name'			=> $input['uploaded_img_name'],
			'upload_type'				=> $input['image_option'],
			
			'banner_description'		=> $input['banner_description'],
			'referral_point'			=> $input['referral_point'],
			'target_url'				=>'',
			//'target_url'				=> $input['target_url'],
			'image_url'					=> $input['image_url'],
			'image_type'				=> $input['image_type'],
			'created_at'				=> date('Y-m-d H:i:s')
		);
		if($input['image_type']==2){
			$data['image_width']= $input['image_width'];
			$data['image_height']= $input['image_height'];
		}
		

		$this->db->insert($this->merchant_banner,$data);
		if (!array_key_exists("csv",$input))
		{
			$input['banner_id']=$this->db->insert_id();
			$this->insertBannerOptions($input);
		}
		return $this->db->insert_id();
	}
	
	function insertBannerOptions($input)
	{
		$option=array();
		if (array_key_exists("color_option",$input))
		{
			$option['customise_color']=$input['customisecolor'];
		 	$customiseCurrency=$input['currency_type'];
			$colors=$input['customise_color'];
			$optionData['banner_id']=$input['banner_id'];
			$optionData['option_type']=0;
			
			$optionData['created_on']=date('Y-m-d H:s:i');
			if(!empty($colors)){
				foreach($colors as $key=>$value){
					 $price=$input['customise_price'][$key];
					 if($value!='' || $price!=''){
						 $optionData['option_name']=$value;
						 $optionData['price']=$price;
						  $optionData['currency_type']=$customiseCurrency;
						 $this->db->insert($this->banner_option_details,$optionData);
					 }
				}
			}
		}
		
			
		if(array_key_exists("size_option",$input))
		{	
			$sizes=$input['customise_size'];
			$option['customise_size']=$input['customisesize'];
			if(!empty($sizes))
			{
				$size['option_type']=1;
				$size['banner_id']=$input['banner_id'];
				$size['created_on']=date('Y-m-d H:s:i');
				foreach($sizes as $value)
				{
					$size['option_name']=$value;
					$this->db->insert($this->banner_option_details,$size);
				}
			}
		}
		if(!empty($option)){
			$option['banner_id']=$input['banner_id'];
			$option['created_on']=date('Y-m-d H:i:s');
			$this->db->insert($this->banner_option,$option);
			
		}
		return true;
		
	}

	
	/**
	 * @Descr  :insert merchant banner details
	 * @param  :post data
	 * @return :array
	 */	
	public function updateBanner($id = 0,$input = array())
	{
		$uploadImgPath='';
		if($input['image_option']==1){
			$uploadImgPath='assets/banner_images/';
		}

		$data= array(
			'banner_name'				=> $input['banner_name'],
			'item_id'					=> $input['item_id'],
			'banner_price'				=> $input['banner_price'],
			'currency_type'				=> $input['currency_type'],
			'banner_postage'			=> $input['banner_postage'],
			'tax_rate'					=> $input['tax_rate'],
			'change_order'				=> $input['change_order'],
			'shipping_address'			=> $input['shipping_address'],
			'cancel_url'				=> $input['cancel_url'],
			'checkout_url'				=> $input['checkout_url'],
			'upload_path'				=>$uploadImgPath,
			'upload_image_name'			=>$input['uploaded_img_name'],		
			'upload_type'				=>$input['image_option'],
			
			
			'banner_description'		=> $input['banner_description'],
			'referral_point'			=> $input['referral_point'],
			'target_url'				=>'',
			//'target_url'				=> $input['target_url'],
			'image_url'					=> $input['image_url'],
			'image_type'				=> $input['image_type'],
			'updated_at'				=> date('Y-m-d H:i:s')
		);
		if($input['image_type']==2){
			$data['image_width']= $input['image_width'];
			$data['image_height']= $input['image_height'];
		}
		
		//remove all banner option details
		$this->common_model->deleteRow('banner_option_details',array('banner_id'=>$id));
		//remove all banner option 
		$this->common_model->deleteRow('banner_option',array('banner_id'=>$id));
		//insert options
		$input['banner_id']=$id;
		$this->insertBannerOptions($input);
		
		$this->db->where('banner_id', $id);
        $this->db->update($this->merchant_banner,$data);
    
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	/**
	 * @Descr  :Get all merchant banner
	 * @param  :void
	 * @return :banner array 
	 */	
	public function getAllBanner()
	{
		$this->db->order_by("banner_id", "DESC");
		$query = $this->db->get($this->merchant_banner);
        return $query->result();
	}
	
	/**
	 * @Descr  :Get all merchant banner
	 * @param  :void
	 * @return :banner array 
	 */	
	public function getBanner($id)
	{
		$query = $this->db->get_where($this->merchant_banner,array('banner_id'=>$id));
        return $query->row();
	}
	
		

	
	/**
	 * @Desc  : to sales filter banner by name
	 * @param : name
	 * @return: seach data
	 */
	public function getSalesFilterBanner($bannerName='')
	{
		$userId=is_logged_in();
		$this->db->select('bpl.*,ut.first_name,mb.banner_name,mb.upload_type,mb.image_url,mb.upload_path,mb.upload_image_name');
		$this->db->from($this->banner_payment_log.' as bpl');
		$this->db->join($this->users_table.' as ut','ut.id =bpl.affiliate_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =bpl.banner_id','left');
	
		$this->db->order_by("bpl.payment_id", 'DESC');
	
		$this->db->where('bpl.pay_status','1');
		$this->db->where('bpl.merchant_id',$userId);
		$this->db->like('mb.banner_name', $bannerName);
		
		$query = $this->db->get();
		$request=$query->result();
		
		return $request;
	
		 
	}
	
	public function getURLFilterBanner($params = array())
	{
		
        $this->db->like('image_url', $params['image_url']);
		$query = $this->db->get($this->merchant_banner);
		$res=$query->result();
		return $res;
		 
	}
	
	/**
	 * @Descr  :Get banner click count,share count and purchase
	 * @param  :banner_id
	 * @return : object
	 */	
	function getBannerPurchaseCount($bannerId)
	{
		$userId=is_logged_in();
		$this->db->select('mb.*,count(bpl.banner_id) AS purchaseCount');
		
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->join($this->banner_payment_log.' as bpl','bpl.banner_id =mb.banner_id AND bpl.pay_status=1' ,'left');
		
		$this->db->where('mb.merchant_id',$userId);
		$this->db->where('mb.banner_id',$bannerId);
	
		$query = $this->db->get();
		$products=$query->row();
		return $products;
	}
	
	
	/**
	 * @Desc  : get all banner sahre count
	 * @param : shareCount array
	 * @return: seach data
	 */
	function getBannerShareCount()
	{
		$userId=is_logged_in();
		$this->db->select('mb.banner_id,count(bsl.banner_id) AS shareCount');
		
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->join($this->banner_share_log.' as bsl','bsl.banner_id =mb.banner_id','left');

		$this->db->where('mb.merchant_id',$userId);
		$this->db->group_by('mb.banner_id');
		$query = $this->db->get();
		$products=$query->result();
		
		//to create array for share count
		//we user banner id as a key and share count as a value
		$shareCountArray=array();
		if(!empty($products)){
			foreach($products as $product){
				$shareCountArray[$product->banner_id]=$product->shareCount;
			}
		}
	
		return $shareCountArray;
	}

	/**
	 * @Desc  : get all banner click and ahre count
	 * @param : clickCount array
	 * @return: seach data
	 */
	function getBannerClickCount()
	{
		$userId=is_logged_in();
		$this->db->select('mb.banner_id,count(bcl.banner_id) AS clickCount');
		
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->join($this->banner_click_log.' as bcl','bcl.banner_id =mb.banner_id','left');

		$this->db->where('mb.merchant_id',$userId);
		$this->db->group_by('mb.banner_id');
		$query = $this->db->get();
		$products=$query->result();
		//to create array for click count
		//we user banner id as a key and share count as a value
		$clickCountArray=array();
		if(!empty($products)){
			foreach($products as $product){
				$clickCountArray[$product->banner_id]=$product->clickCount;
			}
		}
		return $clickCountArray;
	}
	/**
	 * @Descr  :Get all merchant banners with purchase count
	 * @param  :void
	 * @return : array
	 */	
	function getMerchantBanners($limit=0,$offset=0,$bannerName='')
	{
		$userId=is_logged_in();
		$this->db->select('mb.*,count(bpl.banner_id) AS purchaseCount');
		
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->join($this->banner_payment_log.' as bpl','bpl.banner_id =mb.banner_id AND bpl.pay_status=1','left');
		$this->db->order_by("mb.banner_id", "DESC");
		$this->db->where('mb.merchant_id',$userId);
		$this->db->where('mb.delete_status','0');
		
		if($limit > 0){
			
			$this->db->limit($limit,$offset);
		}
		if($bannerName!=''){
			$this->db->like('mb.banner_name',$bannerName);
		}
		$this->db->group_by('mb.banner_id');
		$query = $this->db->get();
		$products=$query->result();
		return $products;
	}
	

	
	/**
	 * @Descr  :Get all purchased product of merchant
	 * @param  :void
	 * @return :merchant purchased product array
	 */	
	function getMerchantPurchsedProduct($limit=0,$offset=0,$bannerName='')
	{
	
		$userId=is_logged_in();
		$this->db->select('bpl.*,ut.first_name,ut.last_name,mb.*');
		$this->db->from($this->banner_payment_log.' as bpl');
		$this->db->join($this->users_table.' as ut','ut.id =bpl.affiliate_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =bpl.banner_id','left');
	
		$this->db->order_by("bpl.payment_id", "DESC");
	
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->where('bpl.pay_status','0');
		$this->db->where('bpl.merchant_id',$userId);
		if($bannerName!=''){
			$this->db->like('mb.banner_name',$bannerName);
		}
		$query = $this->db->get();
		$products=$query->result();
	
		return $products;
	} 

	/**
	 * @Descr  :insert configuration setting
	 * @param  :insert data
	 * @return :insert id
	 */	
	function insertConfig($input,$save=true)
	{
		
		$userId=is_logged_in();
		$data= array(
			'user_id'					=> $userId,
			'paypal_id'					=> $input['paypal_id'],
			'created_at'				=> date('Y-m-d H:i:s')
		);
		//update domian name
		
		$this->db->where('id', $userId);
		$this->db->update($this->users_table,array('domain_name'=>$input['domain_name']));
		
		//insert merchant config
		if($save){
			$this->db->insert($this->merchant_configuration,$data);
			return $this->db->insert_id();
		}else{
			$this->db->where('user_id', $userId);
			 $this->db->update($this->merchant_configuration,$data);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
		
		
	}
	
	/**
	 * @Desc   :get all enabled membership details
	 * @param  :void
	 * @return :array
	 */
	public function getMemberships()
	{
		$where=array('membership_status'=>'0');
		$this->db->order_by("id", "DESC");
		$this->db->where($where);
		$query=$this->db->get($this->memberships); 
		return $query->result();
	}
	/**
	 * Desc   :get array of enabled features
	 * @param :void
	 * @return:array
	 */
	public function getFeatures()
	{
		$this->db->order_by("id", "DESC");
		$where=array('feature_status'=>'0');
		$this->db->where($where);
		$query = $this->db->get($this->membership_features);
        return $query->result();
	}
	
	/**
	 * @Desc  :an array of all selected features
	 * @param :void
	 * @return:array
	 */
	public function getAllSelectFeatures($param=array())
	{
		$query = $this->db->get_where($this->membership_access,$param);
        return $query->result();
	}
	/**
	 * @Desc  :validation for config
	 * @param :void
	 * @return:array
	 */
	public function configValidation()
	{
		
		// Validation rules
		return $this->validation_rules = array(
		
			array(
				'field' => 'domain_name',
				'label' => lang('merchant:domain_name'),
				'rules' => 'trim|required|'
			),
		
			array(
				'field' => 'paypal_id',
				'label' => lang('merchant:paypal_id'),
				'rules' => 'trim|required|'
			),
			
		);
	}
	/**
	 * @Desc  :add Merchant Feedback
	 * @param :post data
	 * @return:insetId	
	 */
	function addMerchantFeedback($input)
	{
		
		$user=is_logged_in();
		$data=array(
			'merchant_id'		=> $user,
			'title'				=> $input['title'],
			'affiliate_id'		=> $input["affiliate_id"],
			'description'		=> $input['description'],
			'created_at'		=> date('Y-m-d H:i:s')
		); 
		
		$this->db->insert($this->merchant_feedback,$data);
		return $this->db->insert_id();
	}
	
	/**
	 * @Desc  :get merchant configuration settings
	 * @param :void
	 * @return:configuration details	
	 */
	function getMerchantConfig()
	{
		$user=is_logged_in(); 
		$this->db->select('mc.*,ut.domain_name');
		//$this->db->from($this->merchant_configuration.' as mc');
		//$this->db->join($this->users_table.' as ut','ut.id =mc.user_id','left');
		
		$this->db->from($this->users_table.' as ut');
		$this->db->join($this->merchant_configuration.' as mc','mc.user_id =ut.id','left');
		
		
		$this->db->where('ut.id',$user);
		$query = $this->db->get();
		$config=$query->row();
	
		return $config;
	}
	/**
	 * @Desc  :get merchant feedback
	 * @param :id
	 * @return:feedback details
	 */
	function getMerchantFeedback($id)
	{
		
		$this->db->select('mf.*,ut.first_name');
		$this->db->from($this->merchant_feedback.' as mf');
		$this->db->join($this->users_table.' as ut','ut.id =mf.affiliate_id','left');
		$this->db->where('mf.id',$id);
		$query = $this->db->get();
		$feedback=$query->row();
		return $feedback;
	}
	
	
	/**
	 * @Description	:Get all merchant purchased banner
	 * @Param 		:limit, offset for fileter
	 * @Return		:array of banner details with merchant name
	 *
	 */
		
	function getMerchantPurchasedBanner($limit=0,$offset=0)
	{
		$userId=is_logged_in();
		$this->db->select('bpl.*,ut.first_name,ut.last_name,mb.banner_name,mb.upload_type,mb.image_url,mb.upload_path,mb.upload_image_name');
		$this->db->from($this->banner_payment_log.' as bpl');
		$this->db->join($this->users_table.' as ut','ut.id =bpl.affiliate_id','left');
		$this->db->join($this->merchant_banner.' as mb','mb.banner_id =bpl.banner_id','left');
	
		$this->db->order_by("bpl.payment_id", 'DESC');
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$this->db->where('bpl.pay_status','1');
		$this->db->where('bpl.merchant_id',$userId);
		$query = $this->db->get();
		$request=$query->result();
		
		return $request;
	}
	
	/**
	 * @Desc  :Download for all banner
	 * @param :void
	 * @return:banner csv file	
	 */
	function exportBannerCSV()
	{
		
		$user=is_logged_in();
		//get all merchant banner details 
		$banners=$this->merchant_model->getMerchantBanners();
		
		$dataArray=array();
		if(!empty($banners)){
			foreach($banners as $banner)
			{
			
				$bannerArray=array('Item Name '=>$banner->banner_name,
					'Item Id '			=>$banner->item_id,
					'Price '			=>$banner->banner_price,
					'Currency Type'		=>$banner->currency_type,
					'Banner Postage'	=>$banner->banner_postage,
					'Tax Rate'			=>$banner->tax_rate,
					'Can customer change order quantities (No:0 Yes:1)'	=> $banner->change_order,
					'Required shipping address (No:0 Yes:1)'=> $banner->shipping_address,
					'Cancel URL '		=> $banner->cancel_url,
					'Checkout URL '	=> $banner->checkout_url,
					
					'Product Description'=>$banner->banner_description,
					'Referral Point'	 =>$banner->referral_point,
					'Image URL '		 =>$banner->image_url,
					'Upload Image '	 =>$banner->upload_image_name,
					'Image Width(px)'	 =>$banner->image_width,
					'Image Height(px)'	 =>$banner->image_height,
					'Banner Add Date'	 =>date('d M Y',strtotime($banner->created_at)),
					'Banner Update Date' =>date('d M Y',strtotime($banner->updated_at)),
					
					);
					array_push($dataArray,$bannerArray);
			}
		}
		
		force_download('banner.csv', $this->format->factory($dataArray)
			->{'to_csv'}());
	}
	
	/* @Desc  :Export CSV for merchant sales banner details
	 * @param :void
	 * @return:sales banner csv file	
	 */
	function exportMerchantSalesCSV()
	{
		//get all merchant sales banner
		$sales=$this->merchant_model->getMerchantPurchasedBanner();
		
			$dataArray=array();
			if(!empty($sales)){
				foreach($sales as $sale)
				{
					$bannerArray=array('Affiliate '=>$sale->first_name.' '.$sale->last_name,
						'Banner Name '				=>$sale->banner_name,
						'Purchase quantity '		=>$sale->banner_quantity,
						
						'Payment Status '			=>$sale->ack,
						'Paid Amount '				=>$sale->amount,
						'Banner Price '				=>$sale->banner_price,
						'Referral Commission '		=>$sale->referral_commission,
						'Currency '					=>$sale->currency,
						
						'Receiver Paypal Id'		=>$sale->receiver_email,
						'Payment On'				=>date('d M Y H:s:i',strtotime($sale->order_time)),
												
						);
						$imagePath=$sale->image_url;
						if($sale->upload_type==1){
							$imagePath=base_url().$sale->upload_path.$sale->upload_image_name;
						}
						$bannerArray['Banner Image']=$imagePath;
						array_push($dataArray,$bannerArray);
				}
			}
				
				force_download('affiliate_file.csv', $this->format->factory($dataArray)
					->{'to_csv'}());
	}
	
	/* @Desc  :export CSV for affiliate banner details
	 * @param :void
	 * @return:banner csv file	
	 */
	 function exportAffiliateCSV()
	 {
			//get all affiliate sales banner for merchant
			$affiliates=$this->merchant_model->getMerchantPurchsedProduct();
		
			$dataArray=array();
			if(!empty($affiliates)){
				foreach($affiliates as $affiliate)
				{
					$bannerArray=array('Affiliate '=>$affiliate->first_name.' '.$affiliate->last_name,
						'Banner Name '				=>$affiliate->banner_name,
						'Purchase quantity '		=>$affiliate->banner_quantity,
						
						'Payment Status '			=>$affiliate->ack,
						'Paid Amount '				=>$affiliate->amount,
						'Banner Price '				=>$affiliate->banner_price,
						'Referral Commission '		=>$affiliate->referral_commission,
						'Currency '					=>$affiliate->currency,
						
						'Receiver Paypal Id'		=>$affiliate->receiver_email,
						'Payment On'				=>date('d M Y H:s:i',strtotime($affiliate->order_time)),
												
						);
						$imagePath=$affiliate->image_url;
						if($affiliate->upload_type==1){
							$imagePath=base_url().$affiliate->upload_path.$affiliate->upload_image_name;
						}
						$bannerArray['Banner Image']=$imagePath;
						array_push($dataArray,$bannerArray);
				}
			}
				
				force_download('affiliate_file.csv', $this->format->factory($dataArray)
					->{'to_csv'}());
		}
	/**
	 * @Desc  :Download banner csv for example
	 * @param :void
	 * @return:banner csv file	
	 */
	function exportCSV()
	{
		$minReferralPoint='5';
		$user=is_logged_in();
		$this->db->select('mb.*');
		$this->db->from($this->merchant_banner.' as mb');
		$this->db->where('mb.merchant_id',$user);
		$query = $this->db->get();
		
		$config=$this->common_model->getDataFromTabel('admin_configuration','*');
		if(!empty($config)){
			$config=$config[0];
			$minReferralPoint=$config->minimum_referral_point;
		}

		//$data_array=$query->result_array();
		
			$dataArray1=array('Item Name *'=>'Natural scenery of highdefinition picture',
						'Item Id *'=>'#1122-A',
						'Price *'=>'1000',
						'Currency Type'=>'GBP',
						'Banner Postage'			=> '',
						'Tax Rate'					=> '10',
						'Can customer change order quantities (No:0 Yes:1)'	=> '1',
						'Required shipping address (No:0 Yes:1)'=> '0',
						'Cancel URL *'		=> 'http://wwww.example.com/cancel',
						'Checkout URL *'	=> 'http://wwww.example.com/success',
						
						'Product Description'=>'Natural beauty of high-quality pictures, natural scenery, landscapes, scenery, clouds, pyramid, desert, camels, characters, highways, roads, forest paths, sunset, sunrise and the sunset, blue sky, the sky, sun, mountains, meadows, roads, rocks, Dream, a vast, natural landscape, natural landscape',
						'Referral Point (min:'.$minReferralPoint.')*'=>'15',
						'Image URL *'=>'http://images.all-free-download.com/images/graphiclarge/natural_scenery_of_highdefinition_picture_166073.jpg',
						'Image Width(px)'=>'120',
						'Image Height(px)'=>'100',
						);
		
			$dataArray2=array('Item Name *'=>'HP Pavilion 11-n016tu x360',
						'Item Id *'=>'#10A',
						'Price *'=>'150',
						'Currency Type'=>'AUD',
						'Banner Postage'			=> '',
						'Tax Rate'					=> '10',
						'Can customer change order quantities (No:0 Yes:1)'	=> '1',
						'Required shipping address (No:0 Yes:1)'=> '1',
						'Cancel URL *'				=> 'http://wwww.example.com/cancel',
						'Checkout URL *'			=> 'http://wwww.example.com/success',
						
						'Product Description'=>'The HP Pavilion 11-n016tu x360 is a convertible laptop with a touchscreen that can fold around and lie flat..',
						'Referral Point (min:'.$minReferralPoint.')*'=>'15',
						'Image URL *'=>'http://c271790.r90.cf1.rackcdn.com/162273.jpg',
						'Image Width(px)'=>'120',
						'Image Height(px)'=>'100',
						);
		
	
		$dataArray3=array('Item Name *'=>'Stanley Park Vancouver wallpaper',
						'Item Id *'=>'#12',
						'Price *'=>'10',
						'Currency Type'=>'USD',
						'Banner Postage'			=> '',
						'Tax Rate'					=> '10',
						'Can customer change order quantities (No:0 Yes:1)'	=> '0',
						'Required shipping address (No:0 Yes:1)'=> '0',
						'Cancel URL *'				=> 'http://wwww.example.com/cancel',
						'Checkout URL *'			=> 'http://wwww.example.com/success',

						'Product Description'=>'Gorgeous Rooms and Waterfront Views Central Vancouver Location',
						'Referral Point (min:'.$minReferralPoint.')*'=>'10',
						'Image URL *'=>'http://static.hdw.eweb4.com/media/thumbs/1/87/867380.jpg',
						'Image Width(px)'=>'100',
						'Image Height(px)'=>'100',
						);
						
		$dataArray4=array('Item Name *'=>'Acer Aspire E1-570 NX.MEPSI.001',
						'Item Id *'=>'#13A',
						'Price *'=>'200',
						'Currency Type'=>'AUD',
						'Banner Postage'			=> '',
						'Tax Rate'					=> '10',
						'Can customer change order quantities (No:0 Yes:1)'	=> '1',
						'Required shipping address (No:0 Yes:1)'=> '1',
						'Cancel URL *'				=> 'http://wwww.example.com/cancel',
						'Checkout URL *'			=> 'http://wwww.example.com/success',
						
						'Product Description'=>'The detailed features and larger Need help choosing your next laptop? Click here to see all laptops and use the filters to help narrow down your search.',
						'Referral Point (min:'.$minReferralPoint.')*'=>'15',
						'Image URL *'=>'http://static.acer.com/up/Resource/Acer/Home/20140919/Find_your_Laptop_Aspire_Switch_10.png',
						'Image Width(px)'=>'120',
						'Image Height(px)'=>'100',
						);
						
				$dataArray5=array('Item Name *'=>'Acer Aspire E1-570 NX.MEPSI.001',
						'Item Id *'=>'#14A',
						'Price *'=>'60',
						'Currency Type'=>'DKK',
						'Banner Postage'			=> '',
						'Tax Rate'					=> '10',
						'Can customer change order quantities (No:0 Yes:1)'	=> '0',
						'Required shipping address (No:0 Yes:1)'=> '0',
						'Cancel URL *'				=> 'http://wwww.example.com/cancel',
						'Checkout URL *'			=> 'http://wwww.example.com/success',
						
						'Product Description'=>'Foxconn General Manager for Innovation Digital System Business Group (iDSBG) Young Liu showcasing an Intel-powered Foxconn tablet alongside James.',
						'Referral Point (min:'.$minReferralPoint.')*'=>'11',
						'Image URL *'=>'http://drop.ndtv.com/albums/GADGETS/intel_at_computex_2014/intel_keynote_computex_2014_and_overclocking_event_young_liu_with_renee_james_ndtv.jpg',
						'Image Width(px)'=>'120',
						'Image Height(px)'=>'100',
						);
						
		$data_array=array($dataArray1,$dataArray2,$dataArray3,$dataArray4,$dataArray5);

		force_download('banner.csv', $this->format->factory($data_array)
			->{'to_csv'}());
	}
	function upload_CSV($fileName)
	{
		$minReferralPoint='';
		$userId=is_logged_in();
		$referralConfig=$this->common_model->getDataFromTabel('admin_configuration','*');
		
		if(!empty($referralConfig)){
			$referralConfig=$referralConfig[0];
			$minReferralPoint=$referralConfig->minimum_referral_point;
		}
		
		if (isset($_FILES['file_name']) && $_FILES['file_name']['size'] > 0 && $_FILES['file_name']['error'] == 0) {
			// Upload the file:         
		
			$config['upload_path'] = SHARED_ADDONPATH.'modules/'.'merchant/uploads/productCSV';
			$config['allowed_types'] = 'csv';
			$config['file_name'] =$fileName;
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file_name'))
			{
				$error = array('error' => $this->upload->display_errors());
				
				return $error;
			}
			else
			{
			// It's uploaded, so open it, loop through it and do what you need to do
				$data = array('upload_data' => $this->upload->data());
				$file_path = $data['upload_data']['full_path'];
				 $row = 1;
				 $resultArray = array();
				 if (($handle = fopen($file_path, "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						if($row!=1){
							 $num = count($data);
							 
							 $db_row['merchant_id'] =$userId; 
							 $db_row['banner_name'] = $data[0];
							 $db_row['item_id'] = $data[1]; 
							 $db_row['banner_price'] = $data[2]; 
							 $db_row['currency_type'] = $data[3]; 
							 
							
							 $db_row['banner_postage'] = $data[4]; 
							 $db_row['tax_rate'] = $data[5]; 
							 $db_row['change_order'] = $data[6]; 
							 $db_row['shipping_address'] = $data[7]; 
							 $db_row['cancel_url'] = $data[8]; 
							 $db_row['checkout_url'] = $data[9]; 
							 $db_row['uploaded_img_name'] = ''; 
							

							 $db_row['banner_description'] = $data[10]; 
							 
							 $db_row['referral_point'] = $data[11];
							 $db_row['image_url'] = $data[12];
							 $db_row['image_width'] = $data[13];
							 $db_row['image_height'] = $data[14];
						
							 $db_row['image_type'] = '0';
							 $db_row['image_option'] = '0';
							 if(!empty($data[13])){
								  $db_row['image_type'] = '2';
							 }
							//check validation for insert csv data
							$this->validateInsertCSVData($db_row,$minReferralPoint);
							
							 $resultArray[]=$db_row;
						}
						$row+=1;
						// Any database insertion goes here...
					}
					if(!empty($resultArray)){
						foreach($resultArray as $result){
							$result['csv']='csv';
							$this->insertBanner($result);
						}
					}
					return true;
					 
				 }

			}
		}
	}
	/**
	 * @Desc  :check csv upload data
	 * @param :upload data array
	 * @return:error mesage
	 */
	function validateInsertCSVData($Csvdata=array(),$minReferralPoint)
	{
		if(!empty($Csvdata))
		{
			 
			$keyArray=array('banner_name','item_id','banner_price','cancel_url','checkout_url','referral_point','image_url');
			foreach($Csvdata as $key=>$value){
				
				if(in_array($key,$keyArray)){
					if($value==''){
				
						$word=ucwords(str_replace("_", " ", $key)); 
						$this->session->set_flashdata('error', 'Item '.$word.' field is required.(All * Field Mandatary)');
						redirect('merchant/upload-CSV');
					}else if($key=='referral_point'){
						
						if($minReferralPoint>$Csvdata['referral_point']){
							$point=$minReferralPoint-1;
							$this->session->set_flashdata('error', 'Referral point should be greater than '.$point);
							redirect('merchant/upload-CSV');
						}
					}else if($key=='image_url'){
							//check for valid url
							$urlValid=validUrl($Csvdata['image_url']);
							if ($urlValid){
								$this->session->set_flashdata('error', 'Please enter valid Image URL.');
								redirect('merchant/upload-CSV');
							}
						}
				}
			}
		}
		return true;
	}
	
	/**
	 * @Desc  :change delete status (0,1) of banner (1 for Banner not show in merchant account)
	 * @param :banner Id
	 * @return:mesage
	 */
	function deleteBanner($bannerId)
	{
		$data=array('delete_status'=>'1');
		$this->db->where_in('banner_id', $bannerId);
        $this->db->update($this->merchant_banner,$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
}
