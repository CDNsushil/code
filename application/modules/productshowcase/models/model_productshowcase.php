<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for User Member (FrontEnd Products)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_productshowcase extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	private $tableproduct = 'Product';
	private $tableworkProfile = 'WorkProfile';
	private $tableAuctionBid = 'AuctionBid';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	
	
	function getproducts($userId=0,$checkPublished=true)
	{	
		
		$productPromotionMedia= $this->db->dbprefix('ProductPromotionMedia');
		$this->db->select($this->tableproduct.'.productId,'.$this->tableproduct.'.tdsUid,catId,productIndustryId,productwillingToPay,productTitle,productOneLineDesc,productDescription,productDownloadPrice,productPrice,isPublished,productCity,productCountryId,productExpiryDate,catId,productLang,productUrl,productQuantity,productSellType,auctionStartDate,auctionEndDate,minimumBidPrice');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		
		$this->db->join($productPromotionMedia, "".$productPromotionMedia.".prodId = ".$this->tableproduct.".productId and \"".$productPromotionMedia."\".\"isMain\"='t'", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = ".$productPromotionMedia.".fileId", 'left');
		$field = 'productType';
		
		if($userId>0) $this->db->where($this->tableproduct.'.tdsUid',$userId);
		//if($productId>0) $this->db->where($this->tableproduct.'.productId',$productId);
			
		$this->db->where('productArchived','f');
		if($checkPublished==true){
			$this->db->where('isPublished','t');
		}
		
		//$this->db->where('productExpiryDate >=',date('Y-m-d'));	
		$this->db->order_by('catId', 'asc');
		$this->db->order_by('productModifiedDate', 'desc');
		$productWantedQuery =  $this->db->get($this->tableproduct);	
	//	echo $this->db->last_query();	print_r($productWantedQuery->result());die;
		return $productWantedQuery->result();	
	}
	
	
	
	/**
	 
	 * Function  to check Work Profile exists or not for user
		
	**/
	
	function userWorkProfile($UserId)
	{		
	    $this->db->select('workProfileId');
		$this->db->from($this->tableworkProfile);		
		$this->db->where('tdsUid',$UserId );		
		$result = $this->db->get()->row(); 
				
		if(!empty($result)){
			return $result->workProfileId;	
		}
		else{
			return FALSE;
		}
				
	} 	
	
	
	/*
	 * Function to save users bid
	 */
	function addUserBid($data) {
		$this->db->insert($this->tableAuctionBid,$data); 	
		$bidId = $this->db->insert_id();
		return $bidId; 
	}	
	
}

/* End of file model_products.php */
/* Location: ./application/module/media/model/model_media.php */
