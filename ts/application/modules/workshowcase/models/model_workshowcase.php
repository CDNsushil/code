<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for User Member (FrontEnd Products)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class model_workshowcase extends CI_Model {
	
	/**
	 * Constructor
	 */	
	private $tablework = 'Work';
	private $tableworkProfile = 'WorkProfile';
	
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}	
	

	
	function getWorks($userId=0,$checkPublished=true)
	{	
		$workPromotionMedia= $this->db->dbprefix('workPromotionMedia');
		$this->db->select($this->tablework.'.workId,'.$this->tablework.'.tdsUid,workTitle,workType,workCompany,workShortDesc,workDesc,workTypeDesc,workRemuneration,workRenumUnit,workLang1,workLang2,workLang3,isPublished,isUrgent,workExperiece,workCity,workCountryId,workExpireDate,workPublisheDate,workTag,workTypeAdditional');
		$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.fileType');
		$this->db->join("workPromotionMedia", "workPromotionMedia.workId = Work.workId and \"".$workPromotionMedia."\".\"isMain\"='t'", 'left');
		$this->db->join("MediaFile", "MediaFile.fileId = workPromotionMedia.fileId", 'left');
		$field = 'workType';
		
		$this->db->where('workArchived','f');
		if($userId>0)
			$this->db->where($this->tablework.'.tdsUid',$userId);
	
		if($checkPublished==true)
		$this->db->where('isPublished','t');
		
		//$this->db->where('workExpireDate >=',date('Y-m-d'));	
		$this->db->order_by('workType', 'asc');
		$this->db->order_by('workModifiedDate', 'desc');
		$workWantedQuery =  $this->db->get($this->tablework);	
		//echo $this->db->last_query();	print_r($workWantedQuery->result_array());die;
		return $workWantedQuery->result_array();	
	}
	
	
	/**
	 
	 * Function  to check Work Profile exists or not for user
		
	**/
	
	function checkWorkProfile($UserId)
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
	
	
		
	
	
}

/* End of file model_products.php */
/* Location: ./application/module/media/model/model_media.php */
