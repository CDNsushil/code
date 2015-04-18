<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Todasquare product Model Class
 *
 *  Fetch data for product (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_product extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	private $tableProduct = 'Product';
	private $MasterLang = 'MasterLang';
	private $MasterCountry = 'MasterCountry';
	private $UserShowcase	= 'UserShowcase';
	private $UserProfile	= 'UserProfile';
	private $MasterIndustry	= 'MasterIndustry';
	private $tableUserContainer	= 'UserContainer';
	
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	/**
	 * getProject fucntion 
	 *
	 * getProject call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function getProduct($userId=0,$catId,$productID=0,$limitFrom=0, $limitRecord=10){
			$table=$this->db->dbprefix('Product');
			
			$entityId=getMasterTableRecord($table);
			$this->db->select('*');
			$this->db->from('Product');
			//$this->db->join("ProductPromotionMedia", "ProductPromotionMedia.prodId = Product.productId", 'left');
			//$this->db->join("MediaFile", "MediaFile.fileId = ProductPromotionMedia.fileId", 'left');
			$this->db->join("UserAuth", "UserAuth.tdsUid = Product.tdsUid", 'left');
			$this->db->join("LogSummary", "LogSummary.elementId = Product.productId", 'left');
			
			$this->db->where('Product.tdsUid',$userId);
			$this->db->where('Product.productArchived','f');
			$this->db->where('Product.catId',$catId);
			$this->db->where('LogSummary.entityId',$entityId);
			$this->db->order_by("Product.productId", "desc"); 
			$this->db->limit($limitRecord,$limitFrom);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}

	public function productInformationInsert($data,$userId,$productId,$catId,$shipping_jsn)
		{
			$field = 'productId';

			$this->productTitle = $this->input->post('productTitle');
			$this->productOneLineDesc = $this->input->post('productOneLineDesc');
			$this->productTagWords = $this->input->post('productTagWords');
			$this->productDescription = $this->input->post('productDescription');
			$this->productCountryId = $this->input->post('productCountryId');
			$this->productReview = $this->input->post('productReview');
			$this->productIndustryIdId = $this->input->post('productIndustryId');
			$this->productReview = $this->input->post('productReviewLink');
			$this->productDownloadPrice = $this->input->post('productDownloadPrice');
			$this->productShipment = $shipping_jsn;

			if($this->input->post('productPrice')=='')
				$this->productPrice = '$0.00';
			else
				$this->productPrice = $this->input->post('productPrice');

			if($this->input->post('productwillingToPay') !='')
				$this->productwillingToPay = $this->input->post('productwillingToPay');
			$this->tdsUid = $userId;
			$this->productDateCreated = date("Y-m-d H:i:s");
			$this->catId = $catId;

			if($productId>0)
			{
				$this->productModifiedDate = date("Y-m-d H:i:s");
				$this->db->where($field,$productId);
				$this->db->update('Product',$this);

				$recordSet = getFieldValueFrmTable('*','Product','productId',$productId);
				$idProduct =  $recordSet[0]->productId;
			}
			else
			{
				$productExpiryDate = date("Y-m-d",strtotime("+3 Months"));
				$this->productExpiryDate = $productExpiryDate;
				$elementId =$this->db->insert('Product' , $this);
				$idProduct =  $this->db->insert_id();

				addDataIntoLogSummary('Product',$idProduct);

			}
			return $idProduct;
		}

	function productSellRecordSet($productId,$catId){	
		$table = 'Product';
		$Product= $this->db->dbprefix($table);
		$field = 'productId';
		$catIdField = 'catId';
		
		$this->db->select($table.'.*');
		 $this->db->select('re.title as "reviewsElementTitle"');
		 
		$this->db->where($field,$productId);
		$this->db->where($catIdField,$catId);
		
		$this->db->from($table);
		$this->db->join('ReviewsElement as re', 're.elementId = CAST("'.$Product.'"."associatedReviewsElementId" as int)', 'left');
		
		$dataProduct = $this->db->get();
		return $dataProduct->row();
		
	 }

	function deleteProduct($productId, $catId)
		{
			$fieldproductId = 'productId';
			$fieldcatId = 'catId';
			$this->db->where($fieldproductId,$productId);
			$this->db->set('productArchived','t');
			$this->db->update('Product');
		}
		
		
	function deletePermanently($productId, $catId)
	{
		//Check for the Media exists
		$result = $this->checkMediaExists($productId);

		if($result->num_rows() > 0)
		{
			$mediaId = $result->result();
		}else{
			$mediaId = 0;
		}
		

		if(is_array($mediaId)){

			foreach($mediaId as $id){
				echo "<pre />"; print_r($id);
				$fileId = $this->getMediaFileId($id->mediaId);

				$this->deleteLocalMediaFile($id->mediaId);

				$this->deleteMasterMediaFile($fileId);
			}
		}
		$this->db->delete('Product', array('productId' => $productId)); 
		return true;
	}
	
	function getMediaFileId($mediaId)
	{
		$this->db->select('fileId');
		$this->db->where('mediaId',$mediaId);
		$query = $this->db->get('TDS_ProductPromotionMedia');
		return $query->row()->fileId;
	}
	
	function checkMediaExists($productId)
	{
		$this->db->where('prodId',$productId);
		$query = $this->db->get('TDS_ProductPromotionMedia');
		return $query;
	}

	function deleteMasterMediaFile($fileId)
	{
		$this->db->delete('TDS_MediaFile', array('fileId' => $fileId)); 
		return true;
	}

	function deleteLocalMediaFile($mediaId)
	{
		$this->db->delete('TDS_ProductPromotionMedia', array('mediaId' => $mediaId)); 
		return true;
	}
	
	function restoreRecord($productId, $catId){
		$fieldproductId = 'productId';
		$fieldcatId = 'catId';
		$this->db->where($fieldproductId,$productId);
		$this->db->set('productArchived','f');
		$this->db->update('Product');
	}
	
	function chcekproductPromotionMediaExists($productPromotionMediaId,$catId)
		{
			$fieldproductPromotionMediaId = 'ProductPromotionMediaId';
			$fieldproductType = 'productCategory';
			$this->db->where($fieldproductType,$productType);
			$this->db->where('productPrmotionMediaType','image');
			$this->db->where($fieldproductPromotionMediaId,$productPromotionMediaId);
			$productproductPromotionMedia = $this->db->get('productPromotionMedia');
			if($productproductPromotionMedia->num_rows()<1)
			{
				return 0; // no record
			}
			else
			{
				return 1; // Having one record
			}
		}
	function changeproductPromotionMediaStatus($productPromotionMediaId,$productId)
		{
			$this->productPromotionMediaStatus = 't';
			$field = 'productPromotionMediaId';
			$this->db->where($field,$productPromotionMediaId);
			$this->db->update('productPromotionMedia',$this);
			
			/* $thisProduct->productImageId = $productPromotionMediaId;
			$field = 'productId';
			$this->db->where($field,$productId);
			$this->db->update('Product',$thisProduct); */
		}
	function chcekFeaturedImageChangeStatus($productId)
		{
			$fieldProductId = 'productId';
			$fieldproductPromotionMediaStatus = 'productPromotionMediaStatus';
			$this->db->where($fieldProductId,$productId);
			$this->db->where($fieldproductPromotionMediaStatus,'t');
			$getproductPromotionMediaStatus = $this->db->get('productPromotionMedia');
			//
			$result =  $getproductPromotionMediaStatus->row();
			//echo "<pre>"; print_r($result); die;
			$toBeupdatedImageId = $result->productPromotionMediaId;
			
			$this->productPromotionMediaStatus = 'f';
			$field = 'productPromotionMediaId';
			$this->db->where($field,$toBeupdatedImageId);
			$this->db->update('productPromotionMedia',$this);
			
			return true;
		}
	function checkImageCount($productId,$productType)
		{
			$fieldProductId = 'productId';
			$this->db->where($fieldProductId,$productId);
			$this->db->where('productCategory',$productType);
			$this->db->where('productPrmotionMediaType','image');
			$getproductPromotionMedia = $this->db->get('productPromotionMedia');
			return $getproductPromotionMedia->num_rows();
		}

	function saveproductPromotionMedia($insertData)
		{
			$this->db->insert('productPromotionMedia' , $insertData);
			return $this->db->insert_id();
		}
	
	function updateProductImage($productData,$productId)
		{
			$field = 'productId';
			$this->db->where($field,$productId);
			$this->db->update('Product',$productData);
			return true;
		}
		
	

	function deleteproductPromotionMedia($productPromotionMediaId,$productId,$productCategory,$productType){		
			$table = 'productPromotionMedia';
			$field = 'productPromotionMediaId';
			$fieldproductId = 'productId';
			$fieldproductPrmotionMediaType = 'productPrmotionMediaType';
			$fieldproductCategory = 'productCategory';
			$this->db->where($field,$productPromotionMediaId);
			$this->db->where($fieldproductId,$productId);
			$this->db->where($fieldproductPrmotionMediaType,$productType);
			$this->db->where($fieldproductCategory,$productCategory);
			$this->db->delete($table);
			return true;
		}
		
	function chcekForFeaturedImage($productId,$productCategory)
		{
			$fieldProductId = 'productId';
			$fieldproductCategory = 'productCategory';
			$fieldproductPromotionMediaStatus = 'productPromotionMediaStatus';
			$this->db->where($fieldProductId,$productId);
			$this->db->where($fieldproductCategory,$productCategory);
			$this->db->where('productPrmotionMediaType','image');
			$this->db->where($fieldproductPromotionMediaStatus,'t');
			$getproductPromotionMediaStatus = $this->db->get('productPromotionMedia');
			//
			$result =  $getproductPromotionMediaStatus->row();
			return $result->productPromotionMediaId;
		}

	function getImageDetail($productPromotionMediaId,$productCategory)
		{
			$fieldproductPromotionMediaId = 'productPromotionMediaId';
			$fieldproductCategory = 'productCategory';
			$this->db->where('productPrmotionMediaType','image');
			$this->db->where($fieldproductPromotionMediaId,$productPromotionMediaId);
			$this->db->where($fieldproductCategory,$productCategory);
			$productproductPromotionMedia = $this->db->get('productPromotionMedia');
			return $productproductPromotionMedia->row();
		}

	function updatePromotionImageStatus($productId,$productCategory)
		{
			$fieldproductCategory = 'productCategory';
			$this->db->where($fieldproductCategory,$productCategory);
			$this->db->where('productPrmotionMediaType','image');
			$this->db->where("productId", $productId);
			$this->db->limit(1);
			$query = $this->db->get('productPromotionMedia');
			$result =  $query->row();
			if(!empty($result)){
			$idToBeUpdated = $result->productPromotionMediaId;

			$this->db->set("productPromotionMediaStatus", 't');
			$this->db->where("productPromotionMediaId", $idToBeUpdated);
			$this->db->update("productPromotionMedia");

			$thisProduct->productImageId = $idToBeUpdated;
			$field = 'productId';
			$this->db->where($field,$productId);
			$this->db->update('Product',$thisProduct);
			
				return true;
			}else
			{
				return false;
			}
		}

		/* All Functionality Replated to Video*/
	function checkVideoCount($productId,$productType)
		{
			$fieldProductId = 'prodId';
			//$fieldproductCategory = 'productCategory';
			$this->db->where($fieldProductId,$productId);
			//$this->db->where($fieldproductCategory,$productType);
			$this->db->where('mediaType',$productType);
			$getproductPromotionMedia = $this->db->get('ProductPromotionMedia');
			//echo $this->db->last_query();
			return $getproductPromotionMedia->num_rows();
		}
		/* End of Video Functionality*/

	function previewProduct($productId){
		$this->db->select('*'); 	
		$this->db->where('productId', $productId);
		//$this->db->join('UserContacts', 'UserContacts.uId = Posts.custId');
		$data['previewPostQuery'] = $this->db->get('product'); 
		return $data['previewPostQuery']->result() ;
	}

	function getVideoDetail($videoId,$productType){
		
		$table = 'ProductPromotionMedia';
		$field = 'mediaId';
		$fieldproductType = 'mediaType';
		$this->db->where($field,$videoId);
		$this->db->where($fieldproductType,$productType);
		$this->db->join('MediaFile', 'MediaFile.fileId = '.$table.'.fileId');
		$dataProduct = $this->db->get($table);
		//echo $this->db->last_query();
		return $dataProduct->row();
		}

	function mediaInfoFreeStuff($imagePath, $Mediainfo, $prodId){
			$this->db->where('prodId',$prodId);
			$dataProduct = $this->db->get('ProductPromotionMedia');
			$countCheck =  $dataProduct->num_rows(); 	

		if($countCheck >0){
			$this->db->where('prodId',$prodId);
			$dataProduct = $this->db->get('ProductPromotionMedia');
			$dataMedia = $dataProduct->result();
			$fileId = $dataMedia[0]->fileId;

			$Mediadata['filePath'] = $imagePath;
			$Mediadata['fileName'] = $Mediainfo['upload_data']['file_name'];
			$Mediadata['fileSize'] = $Mediainfo['upload_data']['file_size'];
			$Mediadata['fileType'] = 1;

			$this->db->where('fileId',$fileId);
			$this->db->update('MediaFile',$Mediadata);

			/*$localMediadata['mediaType'] = 1;
			$localMediadata['isMain'] = 't';
			$this->db->where('fileId',$fileId);
			$this->db->where('prodId',$prodId);
			$this->db->update('TDS_ProductPromotionMedia',$localMediadata);*/
			return true;
			
		}else
		{
			$Mediadata['filePath'] = $imagePath;
			$Mediadata['fileName'] = $Mediainfo['upload_data']['file_name'];
			$Mediadata['fileSize'] = $Mediainfo['upload_data']['file_size'];
			$Mediadata['fileType'] = 1;
			$Mediadata['fileCreateDate'] = date("Y-m-d H:i:s");
			$fileId = $this->model_common->addDataIntoTabel('TDS_MediaFile', $Mediadata);

			$localMediadata['prodId'] = $prodId;
			$localMediadata['fileId'] = $fileId;

			$localMediadata['mediaType'] = 1;
			$localMediadata['isMain'] = 't';
			$this->model_common->addDataIntoTabel('TDS_ProductPromotionMedia', $localMediadata);
		}
		}
	
	function getproductdetail($userId=0,$productId=0,$catId=0,$isPublished=0,$isArchive='f',$offset=0,$limit=0)
	{	
		$tableproduct= $this->db->dbprefix('Product');
		$productPromotionMedia= $this->db->dbprefix('ProductPromotionMedia');
		$this->db->select($this->tableProduct.'.productId,'.$this->tableProduct.'.tdsUid,productTitle,productUrl,productOneLineDesc,productDescription,productDownloadPrice,productPrice,'.$this->tableProduct.'.isPublished,productCity,productCountryId,productExpiryDate,productwillingToPay,'.$this->tableProduct.'.catId,productLang,productIndustryId,productTagWords,productDateCreated,productArchived,productSellType,'.$this->tableProduct.'.isExpired,'.$this->tableProduct.'.isBlocked');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->select($this->UserShowcase.'.optionAreaName,'.$this->UserShowcase.'.enterprise,'.$this->UserShowcase.'.enterpriseName');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');
		$this->db->select($this->MasterLang.'.Language_local');
		$this->db->select($this->MasterCountry.'.countryName');
		$this->db->select($this->MasterIndustry.'.IndustryName');
		$this->db->select('ProdCategory.Category');
		$this->db->select($this->tableUserContainer.'.*');
		
		$this->db->join($productPromotionMedia, "".$productPromotionMedia.".prodId = ".$this->tableProduct.".productId and \"".$productPromotionMedia."\".\"isMain\"='t'", 'left');
		
		$this->db->join("MediaFile", "MediaFile.fileId = ".$productPromotionMedia.".fileId", 'left');
		$this->db->join('ProdCategory',"ProdCategory.catId = ".$this->tableProduct.".catId", 'left');
		$this->db->join($this->UserShowcase, $this->UserShowcase.".tdsUid = ".$this->tableProduct.".tdsUid", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProduct.".tdsUid", 'left');
		
		$this->db->join($this->MasterLang, $this->MasterLang.".langId = ".$this->tableProduct.".productLang", 'left');
		
		$this->db->join($this->MasterCountry, $this->MasterCountry.".countryId = ".$this->tableProduct.".productCountryId", 'left');
		$this->db->join($this->MasterIndustry, $this->MasterIndustry.".IndustryId = ".$this->tableProduct.".productIndustryId", 'left');
		$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableProduct.".userContainerId", 'left');
		
		if($userId>0) $this->db->where($this->tableProduct.'.tdsUid',$userId);
		if($productId>0) $this->db->where($this->tableProduct.'.productId',$productId);
		if($catId>0) $this->db->where($this->tableProduct.'.catId',$catId);
			
		$this->db->where('productArchived',$isArchive);
		if($isPublished==0)
			$this->db->where($this->tableProduct.'.isPublished','t');
			
		//$this->db->where('productExpiryDate >=',date('Y-m-d'));	
		$this->db->order_by('productModifiedDate', 'desc');
		
		if($limit > 0 || $offset > 0){
			$this->db->limit($limit,$offset);
		} 
		$productWantedQuery =  $this->db->get($this->tableProduct);	
	//	echo $this->db->last_query();	print_r($productWantedQuery->result());die;
		return $productWantedQuery->result_array();	
	}	
		
		
	}
/* End of file model_product.php */
/* Location: ./application/module/product/model/model_product.php */
