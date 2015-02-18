<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasqre Lib_upcomingproject Class
 *
 * manage Lib_upcomingproject details.
 *
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Mayank Kanungo
 * @link		http://www.cdnsol.com/
 */

Class lib_products {
	/***
	create properties
	***/
	var $keys = array
		(
		'productTitle' =>'',
		'productId' =>'',
		'tdsUid'=> '', 
		'catId'=> '',	
		'productDescription'=> '', 
		'productOneLineDesc'=> '',	
		'productTagWords'=> '',
		'productCity'=> '', 
		'productCountry'=> '', 
		'productCountryId'=> '', 
		'productLang'=> '', 
		'productPrice'=> 0,	
		'productQuantity'=>1,	
		'productReview'=> '',	
		'productIndustryId'=> '', 
		'productDownloadPrice'=> '',	
		'productwillingToPay'=> '', 
		'externalLink'=> '', 
		'productShipment'=> '', 
		'productDateCreated'=> '',	
		'productModifiedDate'=> '', 
		'productArchived'=> '', 
		'isPublished'=> '', 	 
		'productExpiryDate'=> '',
		'productUrl'=> '',
		'associatedReviewsElementId'=> 0,
		'userContainerId'=> 0,
		'productSellType'=> 0
	 );

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	function getValuesFromDB($userId, $catId,$deletedItems,$ispublished=1,$isArchive='f',$offset=0,$limit=0){
		$productListing = $this->CI->model_product->getproductdetail($userId,0,$catId,$ispublished=1,$isArchive,$offset,$limit);
		return $productListing;
	 }

	 function setValues($project_array){
		foreach($project_array as $k => $v){
			if(isset($this->keys[$k])){
					$this->keys[$k] = $v;
			}
			if($k=='reviewsElementTitle'){
				$this->keys[$k] = $v;
			}
		}
	 }

	 function getValues(){
		return $this->keys;
	 }

	function getValueToUpdate($productId,$catId)
	{

		$data = $this->CI->model_product->productSellRecordSet($productId,$catId);
		$this->setValues($data);
	}

	function save($data)
	{
		$table = 'Product';
		$field = 'productId';
		
		if(isset($data['isPublished']) && ($data['isPublished'] != 't' || $data['isPublished'] != 'f')){
			unset($data['isPublished']);
		}
		if($this->CI->input->post('mode')=="new"){
			
			$id = $this->CI->model_common->addDataIntoTabel($table, $data);	
			addDataIntoLogSummary($table,$id);
		}else
		{	
			$ID = $data['productId'];
			$where = array('productId' => $data['productId']);
			$this->CI->model_common->editDataFromTabel($table, $data, $field, $ID);
			$id = $ID;
		}
		return $id;
	}
}
