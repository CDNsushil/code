<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasqre lib_collaboration Class
 *
 * manage lib_collaboration details.
 *
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Mayank Kanungo
 * @link		http://www.cdnsol.com/
 */

Class lib_collaboration{
	/***
	create properties
	***/
	var $CI;
	var $keys = array(
		"collaborationId"=>0,
		"title"=>'',
		"tagwords"=>'',
		"shortDescription"=>'',
		"description"=>'',
		"industryId"=>0,
		"genreId"=>0,
		"genreOther"=>'',
		"ratingId"=>0,
		"langId1"=>0,
		"langId2"=>0,
		"countryId"=>0,
		"coverImage"=>'',
		"isEducationalMaterial"=>'f',
		"isEvent"=>'f',
		"startDate"=>null,
		"endDate"=>null,
		"userContainerId"=>0,
		"isPublished"=>'f',
		"publishedDate"=>null,
		"createDate"=>null,
		"lastModifyDate"=>null,
		"isArchive"=>'f',
		"isBlocked"=>'f',
		"isExpired"=>'f'
	);
	 /**
	 * Constructor
	 */
	function __construct(){
		$this->CI =& get_instance();
	}
	
	 function setValues($data_array){
		foreach($data_array as $k => $v){
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
	 
}
