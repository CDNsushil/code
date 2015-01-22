<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 * 
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 */
class model_promo_material extends CI_Model {
	
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
 	
 	
 	function fetchImageDetail($where='',$mediaTableName)
	{		
		//echo '<pre />';print_r($mediaTableName);
		if(is_array($where) && count($where) > 0 )
		{
			$field = 'mediaId,isMain,mediaTitle,mediaDescription';
			$orderBy = 'mediaId';
			$order = 'DESC';

			$this->db->select($field);
			$this->db->select('MediaFile.*');
			$this->db->from($mediaTableName);
			$this->db->join('MediaFile','MediaFile.fileId = '.$mediaTableName.'.fileId', 'left');
			$this->db->where($where);
			$this->db->order_by($orderBy,$order);
			
			$querydatalaunch = $this->db->get();
			
			return $querydatalaunch->result_array();
		
		 }
		 else{
			return false;  
		 }
	}
	 
}



