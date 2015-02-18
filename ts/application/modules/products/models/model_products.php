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
class model_products extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableProduct					= 'Product';
	private $tableUserShowcase					= 'UserShowcase';
		
	private $tableMasterRating					= 'MasterRating';	
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
	private $tableMasterIndustry				= 'MasterIndustry';
		
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogInvite						= 'LogInvite';	
	private $tableLogCrave						= 'LogCrave';	
	private $tableLogRating						= 'LogRating';	
	private $tableLogShare						= 'LogShare';	
	private $tableLogShow						= 'LogShow';
	
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	 
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	
	/**
	 * getProjectElements fucntion 
	 *
	 * getProjectElements call by  getProject function 
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	public function getProjectElements($projId=0,$elementTblPrefix='Fv', $elementId=0,$orderby='order',$order='ASC',$fetchElementFields='*',$industryKey='')
	{
	   // Get Project elemnet data from table : (FvMedia, MaSong), ProjActivity, MediaFile
		$elementTable=$elementTblPrefix.$this->tableElement;
		$table=$this->db->dbprefix($elementTable);		
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);	
		$entityId=getMasterTableRecord($table);			

		$limit = 12;
		$fetchElementFields="".$elementTable.".elementId, ".$elementTable.".fileId,title,description,imagePath,modifyDate,createdDate";
		$this->db->select(''.$fetchElementFields.', '.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.tdsUid as projUserId,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.craveCount');
		
		$this->db->from($elementTable);
		$this->db->join($this->tableMasterIndustry,$this->tableMasterIndustry.'.IndustryId = '.$elementTable.'.industryId', 'left');
	
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$elementTable.'.projId', 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->where($elementTable.'.description !=','');
		$this->db->where($this->tableMasterIndustry.'.IndustryKey',$industryKey);
		//$this->db->where($this->tableLogSummary.'.entityId',$entityId);
		if($elementId>0){	
			$this->db->where($elementTable.'.elementId',$elementId);
		}		
		
		if($orderby=='order'){
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		
		$this->db->limit($limit);
		 
		$query = $this->db->get();
		
		$result=$query->result();
		//echo $this->db->last_query();die;
		return $result;
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
	public function getProducts($catId=0,$limit=0,$offset=0){
			
			$ProductPromotionMedia=$this->db->dbprefix('ProductPromotionMedia');
			
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
			$tableLogCrave=$this->db->dbprefix($this->tableLogCrave);
			$entityId=getMasterTableRecord($this->tableProduct);
			
			$this->db->select('productTitle,productId,'.$this->tableProduct.'.tdsUid,catId,productOneLineDesc,productExpiryDate,productPublished');
			$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
			
			$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
			$this->db->select('up.firstName, up.lastName');
			$this->db->select($this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.enterprise');
			
			$this->db->from($this->tableProduct);
			
			$this->db->join("ProductPromotionMedia", "ProductPromotionMedia.prodId = Product.productId AND \"".$ProductPromotionMedia."\".\"isMain\"='t' ", 'left');
			$this->db->join("MediaFile", "MediaFile.fileId = ProductPromotionMedia.fileId", 'left');
			
			$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableProduct.'.productId AND ls."entityId"='.$entityId,'left');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableProduct.'.tdsUid','left');
			$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProduct.".tdsUid");
			
			$loggedUserId=isloginUser();
			if(is_numeric($loggedUserId) && $loggedUserId > 0){
				$this->db->select($this->tableLogCrave.'.craveId');
				$this->db->join($this->tableLogCrave, $this->tableLogCrave.'.elementId = '.$this->tableProduct.'.productId AND  "'.$tableLogCrave.'"."entityId"='.$entityId.' AND  "'.$tableLogCrave.'"."tdsUid"='.$loggedUserId.' ', 'left');
			}
			
			$this->db->where($this->tableProduct.'.productArchived','f');
			$this->db->where($this->tableProduct.'.isPublished','t');	
			
			if(is_numeric($catId) && ($catId > 0)){
				$this->db->where($this->tableProduct.'.catId',$catId);	
			}
				
			$this->db->order_by($this->tableProduct.".productId", "DESC"); 
			if(is_numeric($limit) && ($limit > 0)){
				$this->db->limit($limit,$offset);
			}
			$query = $this->db->get();
			return $result=$query->result();
		}	
	
}

/* End of file model_products.php */
/* Location: ./application/module/media/model/model_media.php */
