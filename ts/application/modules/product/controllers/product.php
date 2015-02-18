<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare product Controller Class
 *
 *  manage product details (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
 
class product extends MX_Controller {
	private $data = array();
	private $dirCacheproduct = '';
	private $userId = null;
	private $mediaPath = '';
	private $productPromotionMediaTable = 'ProductPromotionMedia';
	private $promoImageField = array('mediaId',
			'mediaType',
			'mediaTitle',
			'mediaDescription',
			'fileId',
			'prodId',
			'isMain');

	/**
	 * Constructor
	 */
	function __construct() {
		//Load required Model, Library, language and Helper files
		$load = array(
			'model'		=> 'model_common + model_product',  	
			'library' 	=> 'form_validation + upload + session + Lib_masterMedia + lib_sub_master_media + lib_image_config + lib_products',		 	
			'language' 	=> 'product',							
			'helper' 	=> 'form + file',
			'config'		=>	'product'	   		
		);
		parent::__construct($load);

		$this->dirCacheProduct ='cache/product/'; 
		//echo $this->dirCacheproduct;
		$this->userId= $this->isLoginUser();
		$this->mediaPath = "media/".LoginUserDetails('username')."/product/" ;
		$cmd = 'chmod -R 0777 '.$this->mediaPath;
		exec($cmd);
	}

	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for film & Video project type 
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index($productType='sell',$isArchive='f') {
		$this->data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'product', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			redirect('dashboard/products');
		}
		
		//Comment methode for croning
		if($productType=='sell') {
			//Modules::run("auction/sendAuctionInvitation"); //Send invitation to auctions winner if auction close 
		}
		
		if($isArchive !== 't'){$isArchive='f' ;}
		$this->load->language('product'); // load language file for Film and Video
		$userId=$this->userId;
		$productID=0;
		$deletedItems='';
		$this->data['productId']=$productID ;
		
		if(!is_dir($this->dirCacheproduct)){
			@mkdir($this->dirCacheproduct, 777, true);
		}
		
		$cmd3 = 'chmod -R 0777 '.$this->dirCacheproduct;
		exec($cmd3);

		$catId= $this->getCatId($productType);	
		$this->data['userId']=$this->userId ;
		$this->data['catId']=$catId ;
		$this->data['entityMediaType']=$productType ;
		$this->data['productType']=$productType ;
		$this->data['label']=$this->lang->language ;	
		
		
		$this->data['countResult']=$this->model_common->countResult('Product',array('tdsUid'=>$userId,'catId'=>$catId,'productArchived'=>$isArchive));
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordProduct');		
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];
		
	// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie($productType.'PerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie($productType.'PerPageVal',$this->data['perPageRecord']);		
		}
					
	    $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		$ispublished=1;
		$this->data['products']= $this->lib_products->getValuesFromDB($userId,$catId,$deletedItems,$ispublished,$isArchive,$pages->offst,$pages->limit);
		$this->data['isArchive'] = $isArchive;
		foreach($this->data['products'] as $pcount => $productDetail)
		{
			if($productDetail['catId']=1) $productDetail['productType']='Wanted';
			if($productDetail['catId']=2) $productDetail['productType']='For Sale';
			if($productDetail['catId']=3) $productDetail['productType']='Free';
			
			if($userId>0) {
				$cacheFile = $this->dirCacheProduct.'product_'.$productDetail['productId'].'_'.$userId.'.php';
				$dataToWrite = 	$productDetail;
				if(!is_file($cacheFile)){	
					$data=str_replace("'","&apos;",json_encode($dataToWrite));	//encode data in json format
					$stringData = '<?php $ProjectData=\''.$data.'\';?>';
					if (!write_file($cacheFile, $stringData)){					// write cache file
						echo 'Unable to write the file';
					}
				}
			}	
		}//End Foreach
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			 $this->load->view('product_listing',$this->data) ;
		}			   
		else{
			$this->data['header'] = $this->load->view('navigationMenu',$this->lib_products->keys,true);
			$breadcrumbItem=array('product',$productType);
			$breadcrumbURL=array('product/'.$productType,'');
			if($isArchive == 't'){
				$breadcrumbItem[]='deletedItems';
				$breadcrumbURL[]='product/'.$productType.'/deletedItems';
			}
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$this->data['breadcrumbString']=$breadcrumbString;
			//$this->template->load('template','product',$this->data);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/products'),
							'isDashButton'=>true
				  );
			if($productType=='freeStuff') {
				$leftData['isfreeProduct'] = 1;
			} else {
				$leftData['isClassifiedProduct'] = 1;
			}
			$leftView='dashboard/help_products';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','product',$this->data);
		}
	}
	
	public function deletedItems($productType='offered')
	{
		$this->index($productType,$isArchive='t');
	}
	
	public function getCatId($productType='sell'){
		$carArr = array('Category'=> $productType);
		$cat=getDataFromTabel('ProdCategory', 'catId', $carArr, '', '',1 )	;
		//echo 'last query cat'.$productType.$this->db->last_query();
		$catId=0;		
		if($cat){
			$catId=$cat[0]->catId;	
		}		
		return $catId;
	}

	public function sell($productId=0, $ProductInformation=''){
		
		if($productId === 'deletedItems'){
			$this->deletedItems('sell');
		}else{				
			if($ProductInformation == "description"){
				$this->addMoreInformation($productId,'sell');
			}else if ($ProductInformation == "promotional_image"){
				$this->productPromotionalImages($productId,'sell');
			}else if ($ProductInformation == "promotional_video"){
				$this->productPromotionalVideo($productId,'sell');
			}else if ($ProductInformation == ''){
				$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_sell.php';
				@unlink($cacheFile);
				$this->index('sell');
			}
		}
	}

	public function wanted($productId=0, $ProductInformation=''){
		
		if($productId === 'deletedItems'){
			$this->deletedItems('wanted');
		}
		else
		{
			if($ProductInformation == "description"){
				$this->addMoreInformation($productId,'wanted');
			}
			else if ($ProductInformation == "promotional_image"){
				$this->productPromotionalImages($productId,'wanted');
			}
			else if ($ProductInformation == "promotional_video"){
				$this->productPromotionalVideo($productId,'wanted');
			}
			else if ($ProductInformation == ''){
				$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_wanted.php';
				@unlink($cacheFile);
				$this->index('wanted');
			}
	   }
	}

	public function freeStuff($productId=0, $ProductInformation=''){
		if($productId === 'deletedItems'){
			$this->deletedItems('freeStuff');
		}
		elseif($ProductInformation == "description"){
			$this->addMoreInformation($productId,'freeStuff');
		}else{
			$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_freeStuff.php';
			@unlink($cacheFile);
			$this->index('freeStuff');
		}
	}

	public function addMoreInformation($productId=0,$productType='sell')
	{
		$updateUserContainerFlag=false;
		$addUserContainerFlag=false;
		$entityId=getMasterTableRecord('Product');
		
		$catId= $this->getCatId($productType);
		$this->data['label']=$this->lang->language; 
		$userId = $this->userId;
		
		//If sales product record not exist then redirect to nofound page
		if(isset($productId) && !empty($productId) && isset($userId)){
			$userDataWhere = array('productId'=>$productId,'tdsUid'=>$userId);
			checkUsersProjects('Product',$userDataWhere);
		}
		
		if($this->input->post('submit')=='Save')
		{
			//echo '<pre />';
			//print_r($this->input->post());
			//die;
			
			$dataSetValue = $this->lib_products->setValues($this->input->post());
			$data= $this->lib_products->getValues();
			
			
			 
			$shippingCheckbox = $this->input->post('shippingCheckbox');
			$shippingCountry = $this->input->post('shippingCountry');
			$shippingPrice = $this->input->post('shippingPrice');

			if((!empty($shippingCountry)) && (!empty($shippingPrice))){
				$counter=1;

				$index=1;
				foreach($shippingCountry as $key=>$val)
				{
					$shippingCountryArr[$index] = $val;
				$index++;
				}
				$index2=1;
				foreach($shippingPrice as $key=>$val)
				{
					$shippingPriceArr[$index2] = $val;
				$index2++;
				}

				$shipping =array(
				'shippingCountry' => $shippingCountryArr,
				'shippingPrice' => $shippingPriceArr,
				);
				$shipping_jsn=json_encode($shipping);
				}
				else
				{
					$shipping_jsn = '';
				}
			//print_r($this->input->post());
			//die;
			
				
			$errorConfig = array(
					array(
                     'field'   => 'productTitle',
                     'label'   =>  $this->data['label']['project_title'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				   array(
                     'field'   => 'productOneLineDesc',
                     'label'   =>  $this->data['label']['project_logLineDescription'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				   array(
                     'field'   => 'productTagWords',
                     'label'   =>  $this->data['label']['project_tags'],
                     'rules'   => 'trim|required|xss_clean'
                  ),
				   array(
                     'field'   => 'productDescription',
                     'label'   =>  $this->data['label']['furthrDescription'],
                     'rules'   => 'trim|xss_clean'
                  ),
                  
                  array(
                     'field'   => 'productUrl',
                     'label'   =>  $this->data['label']['furthrDescription'],
                     'rules'   => 'trim|xss_clean'
                  ),
                
			);
			$this->form_validation->set_rules($errorConfig); //Setting rules for validation
			$this->form_validation->set_error_delimiters('<span style="margin-left:0" class="required validation_error">', '</span>');


			if($this->form_validation->run())
			{ 
				
				//New Main folder for new producttype generated
				$newMainDestination = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/';
				if($productId>0)
				{
					//New Sub Main folder for new eventid generated. THis to used to create the folder and subfolder to be get used to copy the related files
					$newSubMainDestination = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/'.$productId.'/';
				}

				$cmdMain = 'chmod -R 0777 '.$newMainDestination;
				exec($cmdMain);

				if(!is_dir($newMainDestination)){
				mkdir($newMainDestination, 777, true);
				}
				$cmdMain = 'chmod -R 0777 '.$newMainDestination;
				exec($cmdMain);
				
				if($productId>0)
				{
					if(!is_dir($newSubMainDestination)){
					mkdir($newSubMainDestination, 777, true);
					}

					$cmdSub = 'chmod -R 0777 '.$newSubMainDestination;
					exec($cmdSub);
				}
				$data['productShipment'] = $shipping_jsn;
				$productExpiryDate = date("Y-m-d",strtotime("+3 Months"));
				$data['productExpiryDate'] = $productExpiryDate;
				//Set product sell type
				$data['productSellType'] = $this->input->post('productSellType');
				if($this->input->post('productPrice')=='')
					unset($data['productPrice']);
					
				if($this->input->post('auctionStartDate')=='')
					unset($data['auctionStartDate']);
					
				if($this->input->post('auctionEndDate')=='')
					unset($data['auctionEndDate']);
					
				if($this->input->post('mode')=="new")
				{					
					unset($data['productModifiedDate']);
					unset($data['productId']);
					$data['productDateCreated']=date("Y-m-d H:i:s");
					
					$sectionId=($productType=='freeStuff')?$this->config->item('productClassifiedFreeSectionId'):$this->config->item('productsSellSectionId');
					$userContainerId=$this->lib_package->getUserContainerId($sectionId);
					
					
					if($productType=='freeStuff'){
						$addUserContainerFlag=true;
					}else{
						$data['userContainerId']=$userContainerId;
						$updateUserContainerFlag=true;
					}					
				
				}
				else if($this->input->post('mode')=="edit")
				{
					unset($data['productExpiryDate']);
					unset($data['productDateCreated']);
					$data['productModifiedDate']=date("Y-m-d H:i:s");
				}
				
				if(empty($data['productCountryId']))
				{
					$data['productCountryId']=0;
				}
				
				if($data['catId']==1 || $data['catId']==3)
				{
					$data['productwillingToPay']=0;
				}
				else
				{
					unset($data['productwillingToPay']);//To remove database error for double datatype
				}
				
				if($data['catId']==2 || $data['catId']==3)
				{
					$data['productDownloadPrice']=0;
				}				
				else
				{
					unset($data['productDownloadPrice']);//To remove database for double datatype
				}
				
				// Add by me to add price by same form as per client requirement
				$productwillingToPay = $this->input->post('productwillingToPay');
				if($data['catId']==2 && !empty($productwillingToPay))
				{
					$data['productwillingToPay']=$productwillingToPay ;
				}	
				//End
				
				unset($data['productCountry']);
				unset($data['externalLink']);
				
				
				$productInformationInsert = $this->lib_products->save($data);
				if($updateUserContainerFlag && $productInformationInsert > 0){
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$productInformationInsert,$sectionId,$sectionId);
				}elseif($addUserContainerFlag && $productInformationInsert > 0){
					$this->lib_package->addUserContainer($userContainerId,$entityId,$productInformationInsert,$sectionId,$sectionId,'Product','productId');
				}
								
		if(!is_dir($this->dirCacheProduct)){
			@mkdir($this->dirCacheProduct, 777, true);
		}
		
		
		    	$productImgName = '';
				$imagePath = '';

				if($productType=='freeStuff'){
					
					$uploadedData = array(); // File Upload code
					$imagePath = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/'.$productInformationInsert.'/images/';

					if(!is_dir($this->mediaPath.$productType)){
					mkdir($this->mediaPath.$productType, 777, true);
					
					}
					
					$cmd1 = 'chmod -R 0777 '.$this->mediaPath.$productType;
					exec($cmd1);

					if(!is_dir($this->mediaPath.$productType.'/'.$productInformationInsert)){
						mkdir($this->mediaPath.$productType.'/'.$productInformationInsert, 777, true);
					}
					
					$cmd2 = 'chmod -R 0777 '.$this->mediaPath.$productType.'/'.$productInformationInsert;
					exec($cmd2);

					if(!is_dir($this->mediaPath.$productType.'/'.$productInformationInsert.'/images/')){
						mkdir($this->mediaPath.$productType.'/'.$productInformationInsert.'/images/', 777, true);
					}
					
					$cmd3 = 'chmod -R 0777 '.$this->mediaPath.$productType.'/'.$productInformationInsert.'/images/';
					exec($cmd3);

					$uploadedData = $this->lib_sub_master_media->do_upload($_FILES,$imagePath,$productId,1);
					if($_FILES['userfile']['name'] !='')
					{
						if(!isset($uploadedData['error']))
						{
							$productImgName = $uploadedData['upload_data']['file_name'];
							$mediaInfo = $this->model_product->mediaInfoFreeStuff($imagePath,$uploadedData,$productInformationInsert);
						}
						else
						{
							$this->data['productTitle']=$this->input->post('productTitle');
							$this->data['productOneLineDesc']=$this->input->post('productOneLineDesc');
							$this->data['productTagWords']=$this->input->post('productTagWords');
							$this->data['productDescription']=$this->input->post('productDescription');

							$Upload_File_Name['error'] = $uploadedData['error'];
							set_global_messages($Upload_File_Name['error'], 'error');
							redirect("product/".$productType.'/'.$productInformationInsert.'/description');
						}
					}
				}
				
			$dataToWrite = $this->writeProductCache($productInformationInsert);
				
		/* 
					
		
		$cmd3 ='chmod -R 777 '.$this->dirCacheProduct;
		exec($cmd3); */
		
		if($userId>0) {
		$cacheFile = $this->dirCacheProduct.'product_'.$productInformationInsert.'_'.$userId.'.php';	
			
	/*	$cacheFile = $this->dirCacheProduct.'product_'.$productInformationInsert.'_'.$userId.'.php';
				
		$refereshCacheWork = 1;
			if($refereshCacheWork==1){				
				
				if(is_file($cacheFile)){
					@unlink($cacheFile);
				}
				
			$this->session->unset_userdata('product_'.$productInformationInsert.'_'.$userId,1);
		}
			
			
		$data=str_replace("'","&apos;",json_encode($dataToWrite));	//encode data in json format
		$stringData = '<?php $ProjectData=\''.$data.'\';?>';
		if (!write_file($cacheFile, $stringData)){					// write cache file
			echo 'Unable to write the file';
		} */
		
	if($dataToWrite && is_array($dataToWrite) && count($dataToWrite) > 0){
			$entityId=getMasterTableRecord('Product');
			$prouctData=$dataToWrite[0];
			
			$enterpriseName=pg_escape_string($prouctData['enterpriseName']);
			$enterpriseName=trim($enterpriseName);
			$creative_name=($prouctData['enterprise']=='t')?$enterpriseName:pg_escape_string($prouctData['firstName'].' '.$prouctData['lastName']);
					
			
			$sectionid=$this->config->item('productsSectionId');
			$searchDataInsert=array(
				"entityid"=>$entityId,
				"elementid"=>$prouctData['productId'],
				"projectid"=>$prouctData['productId'],
				"sectionid"=>$sectionid,
				"section"=>'product',
				"ispublished"=>$prouctData['isPublished']=='t'?'t':'f',
				"cachefile"=>$cacheFile,
				"item.title"=>pg_escape_string($prouctData['productTitle']), 
				"item.tagwords"=>pg_escape_string($prouctData['productTagWords']), 
				"item.online_desctiption"=>pg_escape_string($prouctData['productOneLineDesc']),
				"item.userid"=>$this->userId,
				"item.creative_name"=>$creative_name, 
				"item.creative_area"=>pg_escape_string($prouctData['optionAreaName']),
				"item.languageid"=>$prouctData['productLang']>0?$prouctData['productLang']:0,  
				"item.language"=>$prouctData['Language_local'],
				"item.countryid"=>$prouctData['productCountryId']>0?$prouctData['productCountryId']:0, 
				"item.country"=>$prouctData['countryName'], 
				"item.city"=>pg_escape_string($prouctData['productCity']), 
				"item.industryid"=>$prouctData['productIndustryId']>0?$prouctData['productIndustryId']:0, 
				"item.industry"=>$prouctData['IndustryName'], 
				"item.sell_option"=>($prouctData['catId']==1)?'paid':'free',
				"item.categoryid"=>$prouctData['catId']>0?'product_'.$prouctData['catId']:'product_0',
				"item.category"=>$prouctData['Category'],
				"item.creation_date"=>$prouctData['productDateCreated'], 
				"item.publish_date"=>$prouctData['productDateCreated']
			);
			$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
		}

		//require_once ($cacheFile);
		
		//$product_data = json_decode($product, true);
		}	
				$msg = $this->lang->language['productSavedSuccessfully'];
				set_global_messages($msg, 'success');
				//Check product type 
				if((isset($productType)) && ($this->input->post('mode')=="new")){
					//Set isShowProductPopup session value
					$productCatId= $this->getCatId($productType);	
					$productCountResult = $this->model_common->countResult('Product',array('tdsUid'=>$userId,'catId'=>$productCatId,'productArchived'=>'f'));
				}
				
				if($productType == 'sell'){
					
					if($productId > 0)
					{
						redirect('product/sell');
					}
					else
					{
						//Set session for first product save
						if(isset($productCountResult) && $productCountResult==1){
							$this->session->set_userdata('isShowProductPopup',1);
						}
						redirect('product/sell/'.$productInformationInsert.'/promotional_image');
					}	
														
				}
				else if($productType == 'wanted')
				{					
					if($productId > 0)
					{
						redirect('product/wanted');
					}
					else
					{	
						//Set session for first product save
						if( isset($productCountResult) && $productCountResult==1){
							$this->session->set_userdata('isShowProductPopup',1);
						}
						redirect('product/wanted/'.$productInformationInsert.'/promotional_image');
					}					
				}
				else if($productType == 'freeStuff')
				{	
					//Set session for first product save
					if( isset($productCountResult) && $productCountResult==1){
							$this->session->set_userdata('isShowProductPopup',1);
						}
					redirect('product/freeStuff');
					
				}
				else
				{					
					if($productId > 0)
					{
						redirect('product/sell');
					}
					else
					{
						redirect('product/sell/'.$productInformationInsert.'/promotional_image');
					}
					
				}
			}
			else
			{
				if(validation_errors())
				{
					$msg = array('errors' => validation_errors());		
				}
			}
		}
		if($productId > 0)
		{
			$data = $this->lib_products->getValueToUpdate($productId,$catId);
			
			$this->lib_products->keys['mode'] = 'edit';
			$this->data = $this->lib_products->keys;
		}else
		{
			$sectionId=$this->input->post('sectionId');
			$this->lib_package->setUserContainerId($sectionId);
			$this->lib_products->keys['mode'] = 'new';
			$this->data = $this->lib_products->keys;
		}
			
		
		$this->data['language'] = getlanguageList();
		$this->data['location'] = getCountryList();

		$industry = loadIndustry();
		$this->data['industry'][''] = 'Select Industry';
		
		foreach ($industry as $resultIndustry)
		{
			$this->data['industry'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
		}
		
		$this->data['tdsUid'] = $this->userId; 
		$this->data['catId'] = $catId; 
		$this->data['countries'] = getCountryList();
		$this->data['entityMediaType'] = $productType ;
		$this->data['productType'] = $productType ;
		$this->data['productId'] = $productId;
		
		$this->data['productDefaultImage'] = 'stock_images/'.$this->config->item('defaultProductImg');
		
		$this->data['label'] = $this->lang->language;		
		
		//echo "<pre />"; print_r($this->data);
		$this->data['header'] = $this->load->view('navigationMenu',$this->data,true);
		
		//$this->template->load('template','productSale',$this->data);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/products'),
						'isDashButton'=>true
			  );
		if($productType=='freeStuff') {
			$leftData['isfreeProduct'] = 1;
		} else {
			$leftData['isClassifiedProduct'] = 1;
		}
		$leftView='dashboard/help_products';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','productSale',$this->data);
	}
	
	
 function writeProductCache($prodId){
	
	    $userId = $this->userId;	
    	$dataToWrite = $this->model_product->getproductdetail($userId,$prodId,0,1);
		
	/*  $imageInfo = $this->model_product->getProductPromotionalImages($prodId);		
		if($imageInfo){
			$dataToWrite[0]['fileId']   = $imageInfo[0]->fileId ;
			$dataToWrite[0]['filePath'] = $imageInfo[0]->filePath ;
			$dataToWrite[0]['fileName'] = $imageInfo[0]->fileName;
			$dataToWrite[0]['fileType'] = $imageInfo[0]->fileType ;				
	    }   */		
					
		
		$cmd3 ='chmod -R 777 '.$this->dirCacheProduct;
		exec($cmd3);		
			
		$cacheFile = $this->dirCacheProduct.'product_'.$prodId.'_'.$userId.'.php';
				
		$refereshCacheWork = 1;
		if($refereshCacheWork==1){				

			if(is_file($cacheFile)){
				@unlink($cacheFile);
			}

			$this->session->unset_userdata('product_'.$prodId.'_'.$userId,1);
		 }
			
			
		$data=str_replace("'","&apos;",json_encode($dataToWrite));	//encode data in json format
		$stringData = '<?php $ProjectData=\''.$data.'\';?>';
		if (!write_file($cacheFile, $stringData)){					// write cache file
			echo 'Unable to write the file';	
	      }	
	      
	      return $dataToWrite; 
	      
    }
	
	
	
	

	public function deleteProduct()
	{
		
		
		$productId =  decode($this->input->post('productId'));
		$productType = $this->input->post('productType');
		$catId= $this->getCatId($productType);		
		
		//$isDelete=$this->model_product->deleteProduct($productId,$catId);
		$entityId=getMasterTableRecord('Product');
		if($productId > 0 && $entityId > 0){
			
			$whereField=array('entityid'=>$entityId,'elementid'=>$productId);
			$res=$this->model_common->getDataFromTabel('search', 'id',  $whereField, '', '', '', $limit=1 );
			if($res){
				$id=$res[0]->id;
				if($id > 0){
					$this->model_common->deleteRow('search',$where=array('id'=>$id));
				}
				
			}
		}
		$cacheFile=$this->dirCacheproduct.'product_'.$productId.'_'.$this->userId.'_.php';
		
		if(is_file($cacheFile)){
			@unlink($cacheFile);
		}
		
		$Upload_File_Name['error'] = $this->lang->language['productDeletedSuccessfully'];
		set_global_messages($Upload_File_Name['error'], 'success');
		if($productType=='sell')
			redirect('product/sell');
		else if($productType=='wanted')
			redirect('product/wanted');
		else if($productType=='freeStuff')
			redirect('product/freeStuff');
		else
			redirect('product/sell');
	}

	public function productPromotionalImages($productId=0, $productType='sell')
	{
		$userId = $this->userId;
		//If sales record not exist then redirect to nofound page
		if(isset($productId) && !empty($productId) && isset($userId)){
			$userDataWhere = array('productId'=>$productId,'tdsUid'=>$userId);
			checkUsersProjects('Product',$userDataWhere);
		}
		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		$ImgConfig = $this->lib_image_config->getImgConfigValue();
		$formType = $this->input->post('formtype');
		//To make default display for accordin none,display mode get changed on saving 
		if(strcmp($formType,'promoImage')==0){
			$productPromotionalImages['promoDisplayStyle'] = 'style="display:block;"';
		}
		else{
			$productPromotionalImages['promoDisplayStyle'] = 'style="display:none;"';
		}
		$this->data['productId'] = $productId;
		$this->data['productId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$this->data['productId'];//Checks if eventId is set or not
		$imagePath = $this->mediaPath.$productType.'/'.$this->data['productId'].'/images/';
		$orderBy = 'isMain';
		$productPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productPromotionMediaTable,$this->promoImageField,'prodId',$productId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		$productPromotionalImages['label'] = $this->lang->language;
		if($this->data['productId']>0){
			//$projectPromotionMedia =  $this->lib_upcomingprojectsimages->projectPromotionMedia($productId,'1','');
				$productPromotionalImages['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->productPromotionMediaTable,'prodId',$this->data['productId'],'1','');

			if(strcmp($this->input->post('submit'),'Save')==0){
				$fileType = $this->input->post('fileType');
				$promoMediaFieldValues['mediaId'] = $this->input->post('mediaId');
				$promoMediaFieldValues['mediaTitle'] = $this->input->post('mediaTitle');
				$promoMediaFieldValues['mediaDescription'] = $this->input->post('mediaDescription');
				$promoMediaFieldValues['mediaType'] = $fileType;
				$promoMediaFieldValues['prodId'] = $this->data['productId'];
				 
				
				
				if(!is_dir($this->mediaPath)){
				mkdir($this->mediaPath, 777, true);
				}
				$cmd1 = 'chmod -R 0777 '.$this->mediaPath;
				exec($cmd1);
				
				if(!is_dir($this->mediaPath.$productType)){
					mkdir($this->mediaPath.$productType, 777, true);
				}
				$cmd2 = 'chmod -R 0777 '.$this->mediaPath.$productType;
				exec($cmd2);
				
				if(!is_dir($this->mediaPath.$productType.'/'.$this->data['productId'])){
					mkdir($this->mediaPath.$productType.'/'.$this->data['productId'], 777, true);
				}
				$cmd3 = 'chmod -R 0777 '.$this->mediaPath.$productType.'/'.$this->data['productId'];
				exec($cmd3);
				
				if(!is_dir($this->mediaPath.$productType.'/'.$this->data['productId'].'/images/')){
					mkdir($this->mediaPath.$productType.'/'.$this->data['productId'].'/images/', 777, true);
				}
				$cmd = 'chmod -R 0777 '.$this->mediaPath.$productType.'/'.$this->data['productId'].'/images/';
				exec($cmd);

				// $promoMediaFieldValues['mediaId']; die;
				if($promoMediaFieldValues['mediaId'] > 0){
					$promoMediaFieldValues['isMain'] = $this->input->post('isMain');
					}
				else if($productPromotionalImages['count'] <=0){
					$promoMediaFieldValues['isMain'] = 't';
				}else {
					$promoMediaFieldValues['isMain'] = 'f';
				}
				$returnUrl = "product/".$productType."/".$this->data['productId'].'/promotional_image';
				$uploadArray = $_FILES;

				saveUploadPromoMedia($this->productPromotionMediaTable,$this->promoImageField,$promoMediaFieldValues,$imagePath,$uploadArray,$this->data['productId'],$fileType,$returnUrl,$ImgConfig);
				redirect("product/".$productType."/".$this->data['productId'].'/promotional_image');
			}
			$orderBy = 'isMain';
			$ImgConfig = $this->lib_image_config->getImgConfigValue();

			$productPromotionalImages['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
			$productPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productPromotionMediaTable,$this->promoImageField,'prodId',$productId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
    		$productPromotionalImages['promoElementTable'] = $this->productPromotionMediaTable;
			$productPromotionalImages['productId'] = $productId;
			$productPromotionalImages['entityMediaType'] = $productType;
			$productPromotionalImages['header'] = $this->load->view('navigationMenu',$productPromotionalImages,true);
			$productPromotionalData['promoElementTable'] = $this->productPromotionMediaTable;
			$productPromotionalData['promoElementFieldId'] = 'mediaId';
			$productPromotionalImages['promoImageId'] = $productId;
			$productPromotionalData['promoImagePath'] = $imagePath;				
			$productPromotionalImages['label'] = $this->lang->language;
			
			//To show the make featured option in list view
			$productPromotionalImages['makeFeatured'] = 1;
			
			if(strcmp($productType,'sell')==0)
				$productPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultProductForSale_s');
			else
				$productPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultProductWanted_s');
			
			$productPromotionalData['productPromotionalImages'] = $productPromotionalImages;
			$productPromotionalData['promoElementTable']=$this->productPromotionMediaTable;
			$productPromotionalData['promoElementFieldId']='mediaId';
			$productPromotionalData['promoImagePath'] = $imagePath;
			$productPromotionalData['entityId'] = $productId;
			$productPromotionalData['promoEntityField'] = 'prodId';
			$productPromotionalData['browseImgJs'] = '_imgJs';	
			$productPromotionalData['entityMediaType'] = $productType;	
			$productPromotionalData['promoImageId'] = $productId;
			
			$fileMaxSize=$this->config->item('defaultContainerSize');
			$productPromotionalData['containerDetails'] = $this->model_common->getContainerDetails('Product',array('productId'=>$this->data['productId']));
			
			
			if(isset($productPromotionalData['containerDetails'][0]['containerSize']) && $productPromotionalData['containerDetails'][0]['containerSize'] > 0 ){
				
				$containerSize=$productPromotionalData['containerDetails'][0]['containerSize'];
				
				$dirname=$this->mediaPath;
				$dirSize=getFolderSize($dirname);
				$remainingBytes =($containerSize - $dirSize);
				if(!$remainingBytes > 0){
					$remainingBytes =0;
				}
				
				$containerSize=bytestoMB($containerSize,'mb');
				$dirSize=bytestoMB($dirSize,'mb');
				$remainingSize=($containerSize-$dirSize);
				if($remainingSize < 0){
						$remainingSize = 0;
				}
				$dirSize = number_format($dirSize,2,'.','');
				$remainingSize = number_format($remainingSize,2,'.','');
				$fileMaxSize=$remainingBytes;
			}
			$productPromotionalData['fileMaxSize']= $fileMaxSize;
			$productPromotionalData['productType'] = $productType;
			$productPromotionalData['userId'] = $this->userId;	
			
			
			//$this->template->load('template','productPromotionalImages',$productPromotionalData);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/products'),
							'isDashButton'=>true
				  );
				  
			if($productType=='freeStuff') {
				$leftData['isfreeProduct'] = 1;
			} else {
				$leftData['isClassifiedProduct'] = 1;
			}
			
			$leftView='dashboard/help_products';
			$productPromotionalData['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','productPromotionalImages',$productPromotionalData);

		} else {
			$msg = $this->lang->language['enterProduct'];
			set_global_messages($msg, 'error');
			redirect("product/".$productType);
		}
	}

	public function productPromotionalVideo($entityId=0, $productType='sell')
	{
		if($entityId>0){
			$productPromotionalVideo['productPromotionMediaRecordSet'] =  $this->model_common->PromotionVideoRecordSet($this->productPromotionMediaTable,'prodId',$entityId,2);		
		}

		$this->data['productId'] = $entityId;
		$this->data['productId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$this->data['productId'];//Checks if eventId is set or not

		$productPromotionalVideo['label'] = $this->lang->language;

		if($entityId >0){
			$productPromotionalVideo['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->productPromotionMediaTable,'prodId',$this->data['productId'],'2','');
			$VideoPath = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/'.$entityId.'/video/';
			if($this->input->post('save')=='Save'){
			if($this->input->post('embedVideo')==''){
				$uploadedData = array(); // File Upload code
				

				if(!is_dir($this->mediaPath)){
					mkdir($this->mediaPath, 777, true);
					}
				$cmd1 = 'chmod -R 777 '.$this->mediaPath;
				exec($cmd1);

				if(!is_dir($this->mediaPath.$productType)){
						mkdir($this->mediaPath.$productType, 777, true);
					}
				$cmd2 = 'chmod -R 777 '.$this->mediaPath.$productType;
				exec($cmd2);

				if(!is_dir($this->mediaPath.$productType.'/'.$entityId)){
						mkdir($this->mediaPath.$productType.'/'.$entityId, 777, true);
					}
				$cmd3 = 'chmod -R 777 '.$this->mediaPath.$productType.'/'.$entityId;
				exec($cmd3);

				if(!is_dir($this->mediaPath.$productType.'/'.$this->data['productId'].'/video/')){
						mkdir($this->mediaPath.$productType.'/'.$this->data['productId'].'/video/', 777, true);
					}
				$cmd = 'chmod -R 777 '.$this->mediaPath.$productType.'/'.$this->data['productId'].'/video/';
				exec($cmd);

				$uploadedData = $this->lib_sub_master_media->do_upload($_FILES,$VideoPath,$entityId,2);
				if(!isset($uploadedData['error'])){
						$productVideoName = $uploadedData['upload_data']['file_name'];
				}else{
					$message= $uploadedData['error'];
					$this->session->set_flashdata('error',$message);
					redirect("product/".$productType.'/'.$entityId.'/promotional_video');
				}
			}
			$this->data['checkVideoCount'] =  $this->lib_sub_master_media->countPromotionMedia($this->productPromotionMediaTable,'prodId',$this->data['productId'],'2','');

			$mediaData->productId = $entityId;
			$mediaData->userId = $this->userId;
			$mediaData->videoPrmotionMediaType = 2;
			$mediaData->videoCategory = $productType;
			if(isset($_POST['embedVideo']) && $_POST['embedVideo']!='')
			{
				$mediaData->videoPromotionMediaName = $_POST['embedVideo']; 
				$mediaData->videoPromotionMediaPath = '';
			}
			else
			{
				$mediaData->videoPromotionMediaName = $productVideoName;
				$mediaData->videoPromotionMediaPath = $VideoPath;
			}
			if($this->data['checkVideoCount'] > 0 )
			{
				$this->data['saveVideo'] = $this->model_common->updatePromotionVideo($this->productPromotionMediaTable,$mediaData,'prodId',$entityId);
			}
			else
			{
				$this->data['saveVideo'] = $this->model_common->insertPromotionVideo($this->productPromotionMediaTable,$mediaData,'prodId',$entityId);
			}

			$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_'.$productType.'_.php';
			@unlink($cacheFile); // Delete Cache file to show the image in FIrst page as Product Image.

			$msg['error'] = $this->lang->language['productPromotionVideoSaved'];
			set_global_messages($msg, 'success');
			redirect("product/".$productType.'/'.$entityId.'/promotional_video');
			}

			$orderBy = '';
			$ImgConfig = $this->lib_image_config->getImgConfigValue();

			$productPromotionalVideo['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
			$productPromotionalVideo['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->productPromotionMediaTable,$this->promoImageField,'prodId',$entityId,1,$orderBy,'');

			$productPromotionalVideo['productId'] = $entityId;
			$productPromotionalVideo['productType'] = $productType;
			$productPromotionalVideo['entityMediaType'] = $productType;
			$productPromotionalVideoData['header']=$this->load->view('navigationMenu',$productPromotionalVideo,true);
			
			$productPromotionalVideo['videoPath'] = $VideoPath;
			//Added by vikas to solve js error
			$productPromotionalVideoData['videoPath'] = $VideoPath;
			$productPromotionalVideoData['tableName'] = $this->productPromotionMediaTable;
			$productPromotionalVideoData['elementFieldId']='mediaId';
			
		
			$productPromotionalVideoData['productPromotionalVideo'] = $productPromotionalVideo;
			$this->load->view('productSalePromotionalVideo',$productPromotionalVideoData);
			//$this->template->load('template','productSalePromotionalVideo',$productPromotionalVideo);
			}
			else {
				$msg = $this->lang->language['enterProduct'];
				set_global_messages($msg, 'error');
				redirect("product/".$productType);
			}
		}
		
	function deleteproductPromotionVideo($promotionMediaId,$entityId)
	{
				
		$result = deletePromotionImage($this->productPromotionMediaTable,'mediaId',$promotionMediaId,'prodId',$entityId);
		$Upload_File_Name['error'] = 'Video Deleted Successfully';
		set_global_messages($Upload_File_Name['error'], 'success');
		//Go back to orignal page with error
					
					if(isset($_SERVER['HTTP_REFERER']))
					{
						$baclLink=$_SERVER['HTTP_REFERER'];
					}
					else
					{
						$baclLink='';
					}

					redirect($baclLink);
	}

	function do_upload_video($videoFiles,$productId,$productType)
	{
		$data = '';
		$userFolder = MEDIAUPLOADPATH.LoginUserDetails('username').'/product/'.$productType.'/'.$productId.'/video';

		if(!is_dir($userFolder)){
			mkdir($userFolder, 0777, true);
		}
		//@chmod($userFolder,0777);
		$imagePath = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/'.$productId.'/video';
		//	echo $imagePath;

		$_FILES['userfile']['name']     = $videoFiles['userfile']['name'];
		$_FILES['userfile']['type']     = $videoFiles['userfile']['type'];
		$_FILES['userfile']['tmp_name'] = $videoFiles['userfile']['tmp_name'];
		$_FILES['userfile']['error']    = $videoFiles['userfile']['error'];
		$_FILES['userfile']['size']     = $videoFiles['userfile']['size'];

		$config['allowed_types'] 	= 'flv|mpeg|mp4|avi';
		$config['max_size']		= '50000';
		$config['max_width']  		= '';
		$config['max_height']  		= '';

		$this->upload->initialize($config);
		$this->upload->set_upload_path($imagePath);
		$this->load->library('my_upload', $config);
		if (!$this->upload->do_upload()){
			$data = array('error' => $this->upload->display_errors());
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		}
		return $data;
	}

	function previewProduct($productId,$productType) //productType = sell/wanted/freeStuff
	{
		$catId= $this->getCatId($productType);			
		$postId = $this->input->get('UrlToShare');
		$this->lib_products->getValueToUpdate($productId,$catId);
		$this->data['productSellRecordSet'] =  $this->lib_products->getValues();

		$this->data['label'] = $this->lang->language; //load language variable
		$this->data['productType']=$productType ;
		$this->data['entityMediaType']=$productType ;
		$this->data['productId']=$productId ;
		$this->data['header']=$this->load->view('navigationMenu',$this->data,true);
		$table='ProjectShipping';
		
		$data['elementId']=$productId;
		$data['entityId']=getMasterTableRecord('Product');
		$whereField=array(
				'entityId'=>$data['entityId'],
				'elementId'=>$data['elementId']
		);
		
		$this->data['shippingData'] = $this->model_common->getDataFromTabel($table,'*',$whereField);
	
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit) {
			$this->load->view('previewProduct',$this->data);
		}	
		else{
			//$this->template->load('template','previewProduct',$this->data);	
		
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/products'),
							'isDashButton'=>true
				  );
			if($productType=='freeStuff') {
				$leftData['isfreeProduct'] = 1;
			} else {
				$leftData['isClassifiedProduct'] = 1;
			}
			$leftView='dashboard/help_products';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewProduct',$this->data);
			
		}	
	}

	function previewVideo($videoId)
	{
		$this->data['getVideoDetail'] =  $this->model_product->getVideoDetail($videoId,2);
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit) {
			$this->load->view('previewVideo',$this->data);
		}	
		else {
		
			//$this->template->load('template','previewVideo',$this->data);	
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/products'),
							'isDashButton'=>true,
							'isClassifiedProduct'=>1
				  );
			$leftView='dashboard/help_products';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewVideo',$this->data);
		}	
	}

	function playSlider($productId)
	{		
		//$this->template->load('template','slider');
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/products'),
						'isDashButton'=>true,
						'isClassifiedProduct'=>1
			  );
		$leftView='dashboard/help_products';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','slider',$data);	
	}

	//////////////////////////////// Delete Image Functionality ///////////////////////////////////////

	function deletePromotionImage($mediaId, $entityId,$productType)
	{
		$getFileType = getMediaFileType($this->productPromotionMediaTable,'mediaType', $mediaId); // Image or video		
		$result = deletePromotionImage($this->productPromotionMediaTable,'mediaId',$mediaId,'prodId',$entityId);

		if($getFileType==1){
			$message = $this->lang->language['imageForProductDeleted'];
			set_global_messages($message, 'success');
			if(isset($_SERVER['HTTP_REFERER']))
			{
				$baclLink=$_SERVER['HTTP_REFERER'];
			}
			else
			{
				$baclLink='';
			}

			redirect($baclLink);
		}
	}

	////////////////////////////// Featured Image functionality//////////////////////////////////////

	public function makeFeatured($mediaId,$entityId,$mediaType,$productType)
	{
		$promotionImageId =  $mediaId;
		$chcekFeaturedImage = chcekFeaturedImageChangeStatus($this->productPromotionMediaTable,'prodId',$entityId,$mediaType);
		$this->model_common->changePromotionMediaStatus($this->productPromotionMediaTable,$promotionImageId,'prodId',$entityId);

		$message = $this->lang->language['featuredImageChanged'];
		set_global_messages($message, 'success');
		redirect("product/".$productType.'/'.$entityId.'/promotional_image');
	}
	
	function deletePermanently($productId=0,$productType='sell')
	{
		$catId= $this->getCatId($productType);		

		$this->model_product->deletePermanently($productId,$catId);

		$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_'.$productType.'_.php';
		@unlink($cacheFile);
		$msg = $this->lang->language['productDeletedSuccessfully'];
		set_global_messages($msg, 'success');
		if($productType=='sell')
			redirect('product/sell');
		else if($productType=='wanted')
			redirect('product/wanted');
		else if($productType=='freeStuff')
			redirect('product/freeStuff');
		else
			redirect('product/sell');
	}

	function restoreRecord($productId=0,$productType='sell')
	{
		$catId= $this->getCatId($productType);		

		$this->model_product->restoreRecord($productId,$catId);

		$cacheFile=$this->dirCacheproduct.'product_user_'.$this->userId.'_'.$productType.'_.php';
		@unlink($cacheFile);
		$msg = $this->lang->language['recordRestore'];
		set_global_messages($msg, 'success');
		if($productType=='sell')
			redirect('product/sell');
		else if($productType=='wanted')
			redirect('product/wanted');
		else if($productType=='freeStuff')
			redirect('product/freeStuff');
		else
			redirect('product/sell');
	}
	
	public function updatePrice() {
		$dataProject = $this->input->post('val1');
		$productId = $this->input->post('val2');
		
		if($productId>0 && is_array($dataProject) && count($dataProject) > 0){
			$countResult=$this->model_common->countResult('Product','productId',$productId,1);
			if($countResult > 0){
				
				$this->model_common->editDataFromTabel('Product', $dataProject, 'productId', $productId);
			}
			//$this->session->set_userdata('mediaCache',1);
		}
	}
	
	public function updateWantedPrice() {
		$dataProject=$this->input->post('val1');
		$productId=$this->input->post('val2');
		//echo '<pre />';print_r($dataProject);
		//echo 'Id:'.$productId;
		if($productId>0 && is_array($dataProject) && count($dataProject) > 0){
			$countResult=$this->model_common->countResult('Product','productId',$productId,1);
			if($countResult > 0){
				$this->model_common->editDataFromTabel('Product', $dataProject, 'productId', $productId);
				//echo 'Product Price:'.$this->db->last_query();die;
			}
			//$this->session->set_userdata('mediaCache',1);
		}
	}
	
	function uploadMediaView()
	{
		
		$mediaType = $this->input->post('val1');
		$fileSize = $this->input->post('val2');
		$fileType = $this->input->post('val3');
		$filePath = $this->input->post('val4');
		$isEmbed = $this->input->post('val5');
		$embedPath = $this->input->post('val6');
		$browseId = $this->input->post('val7')?$this->input->post('val7'):'';
		$mediaTypeToShow = 'video';
		$showEmbed = 0;
		if($isEmbed=='f') $embedPath='';
		
		$data = array('browseId'=>$browseId,'required'=>'required','fileType'=>$fileType,'fileMaxSize'=>$fileSize,'isEmbed'=>$isEmbed,'fileName'=>'','fileMaxSize'=>$fileSize,'filePath'=>$filePath,'embedCode'=>$embedPath, 'label'=>$this->lang->line('file'), 'view'=>'uploadFileForm','flag'=>$showEmbed,'editFlag'=>false,'mediaTypeToShow'=>$mediaTypeToShow);
		echo Modules::run("common/formInputField",$data);
	}
	
	
	public function additionalInformation($productId=0,$entityMediaType='') {
		
		$userId = $this->userId;
		//If sales record not exist then redirect to nofound page
		if(isset($productId) && !empty($productId) && isset($userId)){
			$userDataWhere = array('productId'=>$productId,'tdsUid'=>$userId);
			checkUsersProjects('Product',$userDataWhere);
		}
		//$entityMediaType=''	;	
	/*	if(!$prductId > 0){
			redirect('media/'.$indusrty);
		} */
		
		//$this->data['method']=$method;
		$this->data['entityMediaType']=$entityMediaType;
		$action="editProject";
		$this->data['productId']=$productId;
		$this->data['projectId']=$productId;
		$this->data['additionalInformation']='black';
		//$this->data['indusrty']=$indusrty;
		$this->data['label']=$this->lang->language; 
		$this->data['header'] = $this->load->view('navigationMenu',$this->data, true);
		$this->data['additionalInfoSection']=array('addInfoNewsPanel','addInfoReviewsPanel'); 
		$natureId = 1;
		$this->data['recordId'] = $productId;
		$this->data['eventNatureId'] = $natureId;
		$this->data['tableId'] = getMasterTableRecord('Product');
		$this->data['userId']=$this->userId;
		
		//$this->template->load('template','additionalInfo/additional_info',$this->data);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/products'),
						'isDashButton'=>true,
						'isClassifiedProduct'=>1
			  );
		$leftView='dashboard/help_products';
		$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','additionalInfo/additional_info',$this->data);
		
	}
		
}

/* End of file product.php */
/* Location: ./application/module/product/product.php */
