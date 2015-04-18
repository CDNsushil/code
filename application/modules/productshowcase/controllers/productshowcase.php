<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Showcase Details ( Workshowcase)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 
class productshowcase extends MX_Controller {
	private $productData = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	private $userId = null;
	private $IndustryId = 0;
	private $ispublished = 1;
	private $product = 'Product';	
	private $productMediaTableName = 'ProductPromotionMedia';	
	private $promoImageField = array('mediaId',
			'mediaType',
			'mediaTitle',
			'mediaDescription',
			'fileId',
			'projId',
			'isMain');
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		 
		//Load required Model, Library, language and Helper files
			$load = array(
				'model'		=> 'model_productshowcase',  	
				'language' 	=> 'product',							
				//'config'		=>	'media/media' 
				'library' 	=> 'lib_sub_master_media'  		
			);
			
			parent::__construct($load);		
			
			$this->head->add_css($this->config->item('system_css').'frontend.css');
			$this->head->add_css($this->config->item('frontend_css').'anythingslider.css');
			//$this->head->add_js($this->config->item('frontend_js').'jquery.anythingslider.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery.tinycarousel.min.js');
			$this->head->add_js($this->config->item('frontend_js').'jquery-gallery-cdn.js');
			
			$this->userId= isLoginUser();
			// Load  path of css and cache file path
			$this->dirCacheProduct = ROOTPATH.'cache/productshowcase/';  
			$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/productshowcase/'; 
			$this->productData['dirUploadMedia'] = $this->dirUploadMedia; 
			//add advertising module if exists
			if(is_dir(APPPATH.'modules/advertising')){
				$this->load->model(array('advertising/model_advertising'));
			}
	}
		
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for Writing and Publishing project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index($userId=0,$productId=0) 
	{
		$userId = ($userId==0)?isLoginUser():$userId;
		
		$this->products($userId,$productId);
	}
	
	public function preview($userId=0,$id=0,$mathod='products') 
	{
		$this->isLoginUser();
		if($this->userId > 0 && ($userId==$this->userId)){
			
		}else{
			redirect('home');
		}
		
		$this->$mathod($userId,$id,$preview=1);
	}
	
	public function products($userId=0,$productId=0,$preview=0)
	{			
		$userId = ($userId==0)?isLoginUser():$userId;
		$norecord = true;
		
		$passProductData = $this->getProducts($userId,$productId,$preview);
		
		$passProductData['userId'] = $userId;				
		$passProductData['currentproductDetail'] = array();
		if($productId==0){
			$norecord = false;
			$passProductData['currentproductDetail'] = isset($passProductData['product_array'][0])?$passProductData['product_array'][0]:null;
		}
		else{
			foreach ($passProductData['product_array'] as $key =>$product_array_record) {
				if($product_array_record->productId == $productId) { 
					$norecord = false;
					$passProductData['currentproductDetail'] = $product_array_record;				
				}
			}
		}
				  
		/*For Product Type breadcrumb */
		 if(isset($passProductData['currentproductDetail']->catId) && $passProductData['currentproductDetail']->catId==1){
				$passProductData['productType'] =$this->lang->line('productforSale');
				$passProductData['productType_no_s'] =$this->lang->line('productforSale_no_s');
		 }
		  elseif(isset($passProductData['currentproductDetail']->catId) && $passProductData['currentproductDetail']->catId==2){
				$passProductData['productType'] = $this->lang->line('productWanted');
				$passProductData['productType_no_s'] = $this->lang->line('productWanted_no_s');
		 }
		  else {
				 $passProductData['productType'] = $this->lang->line('freeproduct');
				 $passProductData['productType_no_s'] = $this->lang->line('freeproduct_no_s');
		}
		
		$passProductData['workProfileId']=$this->model_productshowcase->userWorkProfile($userId);
		
		
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			/*Get section id */
			$advertSectionId = $this->config->item('productsSectionId');
			
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			$passProductData['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$passProductData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$advertSectionId),true);
		} 
		
		/* End */
		$breadcrumbItem=array('showcase',$passProductData['productType_no_s']);
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'/productshowcase/products/'.$userId);
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$passProductData['breadcrumbString']=$breadcrumbString;
		
		
		
		if($norecord == true)
			redirectToNorecord404();
		else
			$this->template_front_end->load('template_front_end','product',$passProductData);		
	}
	
	
		
	public function viewproject($userId=0,$productId=0)
	{
		$userId = ($userId==0)?isLoginUser():$userId;
		
		$norecord = true;
		$passProductData = $this->getProducts($userId,$productId);
	
		$passProductData['userId'] = $userId;	
		$passProductData['currentproductDetail'] = array();
		if($productId==0){
			$passProductData['currentproductDetail'] = $passProductData['product_array'][0];
			$norecord = false;
		}
		else{
			foreach ($passProductData['product_array'] as $key =>$product_array_record) {				
				if($product_array_record->productId == $productId) { 
					$passProductData['currentproductDetail'] = $product_array_record;	
					$norecord = false;			
				}
			}
		}
		
		/*For Product Type breadcrumb */
			if(@$passProductData['currentproductDetail']->catId==1){
				$passProductData['productType'] =$this->lang->line('productforSale');
				$passProductData['productType_no_s'] =$this->lang->line('productforSale_no_s');
				$productCat = 'productsSell';
			} elseif(@$passProductData['currentproductDetail']->catId==2){
				$passProductData['productType'] = $this->lang->line('productWanted');
				$passProductData['productType_no_s'] = $this->lang->line('productWanted_no_s');
				$productCat = 'productsWanted';
			} else {
				$passProductData['productType'] = $this->lang->line('freeproduct');	
				$passProductData['productType_no_s'] = $this->lang->line('freeproduct_no_s');	
				$productCat = 'productClassifiedFree';					    
			}
		  
			$passProductData['workProfileId']=$this->model_productshowcase->userWorkProfile($userId);
		  
		/* End */
	
		/*Get section id */
		$sectionId = $this->config->item($productCat.'SectionId');
		/*Get Entity id */
		/* Update view count */
		$viewEntityId = getMasterTableRecord('TDS_Product');
		if((!empty($viewEntityId)) && (!empty($productId))){
			$proId = $productId;
			manageViewCount($viewEntityId,$productId,$userId,$proId,$sectionId);
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			/*Get section id */
			$advertSectionId = $this->config->item('productsSectionId');
			
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			$passProductData['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$passProductData['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$advertSectionId),true);	
		} 
		
		$breadcrumbItem=array('showcase',$passProductData['productType_no_s']);
		$breadcrumbURL=array('showcase/aboutme/'.$userId,'/productshowcase/viewproject/'.$userId);
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$passProductData['breadcrumbString']=$breadcrumbString;
		
		if($norecord == true)
			redirectToNorecord404();
		else
			$this->template_front_end->load('template_front_end','view_project',$passProductData);
		
	}
	
	public function getProducts($userId=0,$productId=0,$preview=0) {		
	
		$orderby = 'elementId';
		$elementOrderBy = 'modifyDate';
		$orderBy = '';
		$order = 'DESC';
		$fetchFields = 'projId,projBaseImgPath';
		$fetchElementFields = '';
		
		$loggedUserId=$this->userId>0?$this->userId:0;
		$checkPublished=( ($userId==$loggedUserId) && isset($preview) && $preview ==1)?false:true;
		
		$this->productData['productEntityId'] = getMasterTableRecord($this->product);
		$this->productData['mediaEntityId'] = getMasterTableRecord($this->productMediaTableName);
		$this->productData['product_array'] =  $this->model_productshowcase->getproducts($userId,$checkPublished);
		
		if($productId==0) $productId = @$this->productData['product_array'][0]->productId;
		$defaultImage_m = $defaultImage_s = $this->config->item('defaultNoMediaImg');
		
		$this->productData['defaultproductId'] = $productId;
		$this->productData['list_promo_images'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productMediaTableName,$this->promoImageField,'prodId',$productId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		//echo $this->db->last_query();
		//echo '<pre />';print_r($this->productData['list_promo_images']);die;
		$imagesExists = 0;
		if(!empty($this->productData['list_promo_images'])){
			foreach($this->productData['list_promo_images'] as $k=> $PUImg)
			{					
				$this->productData['promo_images'][$k]['mediaId'] = @$PUImg['mediaId'];
				$this->productData['promo_images'][$k]['prodId'] = @$PUImg['prodId'];
				$this->productData['promo_images'][$k]['mediaTitle'] = @$PUImg['mediaTitle'];
				$this->productData['promo_images'][$k]['mediaDescription'] = @$PUImg['mediaDescription'];
				$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_m');
				$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');		
					if(!file_exists($promoThumbImage_m)) $this->productData['promo_images'][$k]['noMedia'] = 1;
					else $this->productData['promo_images'][$k]['noMedia'] = 0;
					
					$imagesExists = 1;
														
					$this->productData['promo_images'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
					$this->productData['promo_images'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
				
			}			
			//$this->productData['promo_images']['catId'] = @$this->productData['product_array'][0]->catId;
		}
		
		$this->productData['catId']=@$this->productData['product_array'][0]->catId;
		
		if(@$this->productData['product_array'][0]->catId==1 || @$this->productData['product_array'][0]->catId==3)
			$this->productData['defaultImage'] = $this->config->item('defaultProductForSale_m');
		else
			$this->productData['defaultImage'] = $this->config->item('defaultProductWanted_m');
			
		//If no file exists in folder for the current record
		if($imagesExists ==0) $this->productData['promo_images'] = array();	
		$this->productData['promo_video'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productMediaTableName,$this->promoImageField,'prodId',$productId,2,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		//$whereClause = array('productId'=>$productId,'mediaType'=>2);
		//$this->productData['promo_video'] = getDataFromTabel($this->productMediaTableName,'fileId',$whereClause);
		
		/*if(!is_dir($this->dirCacheProduct)){
			@mkdir($this->dirCacheProduct, 777, true);
		}
		
		$cmd3 = 'chmod -R 777 '.$this->dirCacheProduct;
		exec($cmd3);
		
		if($userId>0){
			$cacheFile = $this->dirCacheProduct.'product_'.$productId.'_'.$userId.'.php';
					
			$refereshCacheWork=LoginUserDetails('product_'.$productId.'_'.$userId);
			
			if($refereshCacheWork==1){				
					
					if(is_file($cacheFile)){
						@unlink($cacheFile);
					}
					
				$this->session->unset_userdata('product_'.$productId.'_'.$userId,1);
			}
				
			if(!is_file($cacheFile)){	
				
				$data=str_replace("'","&apos;",json_encode($this->productData));	//encode data in json format
				$stringData = '<?php $product=\''.$data.'\';?>';
				if (!write_file($cacheFile, $stringData)){					// write cache file
					echo 'Unable to write the file';
				}
			}

			require_once ($cacheFile);
			
			$product_data = json_decode($product, true);
		}*/
		
		return $this->productData;
		
	}
	
	
	public function popupimages() {
		$imagesExists = 0;	
		$orderBy = '';
		
		$productId = $this->input->get('val1');
		$activeRecord = $this->input->get('val2');
		$catId = $this->input->get('val3');
		
		$popupImages['promo_images'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productMediaTableName,$this->promoImageField,'prodId',$productId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		/*
		if(@$catId==1 || @$catId==3){
			$defaultImage_m = $this->config->item('defaultProductForSale_m');
			$defaultImage_s = $this->config->item('defaultProductForSale_s');
		}
		else{
			$defaultImage_m = $this->config->item('defaultProductWanted_m');
			$defaultImage_s = $this->config->item('defaultProductWanted_s');
		}
		
		foreach($popupImages['popupImages']  as $upcomingPUImg)
		{
			echo '<pre />';print_r($upcomingPUImg);
		}
		die;
		*/
		
		$defaultImage_m = $defaultImage_s = $this->config->item('defaultNoMediaImg');
		foreach($popupImages['promo_images'] as $k=> $PUImg)
		{					
			$promoThumbImage_m = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_b');											
			$promoThumbImage_s = addThumbFolder(@$PUImg['filePath'].@$PUImg['fileName'],'_s');											
			if(!file_exists($promoThumbImage_m)) $popupImages['promo_images'][$k]['noMedia'] = 1;
			else $popupImages['promo_images'][$k]['noMedia'] = 0;
			$imagesExists = 1;
			$popupImages['promo_images'][$k]['thumbFinalImg_m'] = getImage(@$promoThumbImage_m,$defaultImage_m);
			$popupImages['promo_images'][$k]['thumbFinalImg_s'] = getImage(@$promoThumbImage_s,$defaultImage_s);
		}
		$popupImages['activeRecord'] = 	$activeRecord;
		//If no file exists in folder for the current record
		if($imagesExists ==0) $popupImages['promo_images'] = array();
		$this->load->view('popup_images',$popupImages);		   //load template with media view
			
	}
	
	/*
	 * This funciton is used for set product bids
	 */
	public function setProductBid() {
		$productId = $this->input->get('val1');
		$productTitle = $this->input->get('val2');
		$data['productId'] = $productId;
		$data['productTitle'] = $productTitle;
		$this->load->view('product_bid',$data);		   //load template with product bid view	
	}
	
	/*
	 * This funciton is used to save users bid price
	 */
	public function postBidPrice() {
		$this->userId = isLoginUser();
		//Set bidding post values
		$data['entityId']  	=  getMasterTableRecord('TDS_Product');
		$data['elementId'] 	=  $this->input->post('projectId');
		$data['price']  	=  $this->input->post('bidPrice');
		$data['date']  	    =  date("Y-m-d H:i:s");
		$data['userId']  	=  $this->userId;
		$data['projectId'] 	=  $this->input->post('projectId');
		
		//Add users bid
		$insertBid = $this->model_productshowcase->addUserBid($data);
		if(isset($insertBid) && !empty($insertBid))
			$msg =array('msg'=>$this->lang->line('addUsersBid'),'');
		else
			$msg =array('msg'=>$this->lang->line('errorInUsersBid'),'');
			
		echo json_encode($msg);
	}
	
}

