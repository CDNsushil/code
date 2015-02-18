<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Todasquare dashboard Model Class
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/ */
class model_download extends CI_Model {
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	private $tableUserShowcase					= 'UserShowcase';	// user profiles
	private $UserSearchPreferences				= 'UserSearchPreferences';	// user profiles
	private $UserBuyerSettings					= 'UserBuyerSettings';	// user profiles
	private $UserSellerSettings					= 'UserSellerSettings';	// user profiles
	/**Constructor
	 * Loads the calendar language file and sets the default time reference*/
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	public function getDownloadFile($FD=''){
		$result=false;
		if((strlen($FD['elementTable']) > 1) && (strlen($FD['elementPrimeryField']) > 1)){
			$this->db->select($FD['tableName'].'.projPrice, '.$FD['tableName'].'.projName, '.$FD['tableName'].'.projDownloadPrice, '.$FD['tableName'].'.projSellstatus, '.$FD['tableName'].'.isprojPrice, '.$FD['tableName'].'.isprojDownloadPrice, '.$FD['tableName'].'.projCategory');
			$this->db->select('MediaFile.fileId,MediaFile.filePath,MediaFile.fileName,MediaFile.isExternal,MediaFile.rawFileName');
			$this->db->from($FD['tableName']);
		
			$this->db->select($FD['elementTable'].'.price, '.$FD['elementTable'].'.elementId, '.$FD['elementTable'].'.title, '.$FD['elementTable'].'.downloadPrice, '.$FD['elementTable'].'.isPrice, '.$FD['elementTable'].'.isDownloadPrice');
			$this->db->join($FD['elementTable'], $FD['elementTable'].'.'.$FD['primeryField'].' = '.$FD['tableName'].'.'.$FD['primeryField'], 'left');
			$this->db->join('MediaFile','MediaFile.fileId  = '.$FD['elementTable'].'.fileId', 'left');
			if($FD['isElement'] == 1){
				$this->db->where($FD['elementTable'].'.'.$FD['elementPrimeryField'],$FD['elementId']);
			}
			$this->db->where($FD['tableName'].'.'.$FD['primeryField'],$FD['projectId']);
			if($FD['fileId'] > 0){
				$this->db->where('MediaFile.fileId',$FD['fileId']);
			}
			$this->db->where('MediaFile.isExternal','f');
			$this->db->limit(1);
			$query = $this->db->get();
			$result=$query->result_array();
		}
		return $result;
	}
}
