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

Class Lib_upcomingprojectsImages extends Lib_upcomingprojects {
	/***
	create properties
	***/
	var $keyimages = array(
					'mediaId' =>'',
					'projId' =>'',
					'fileId'=> '',
					'mediaType'=> '',
					'mediaTitle'=> '',
					'mediaDescription'=> '',
					'isMain'=> '',
					);
	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();
		//load libraries
		$this->CI->load->database();
		$this->CI->load->model('model_upcomingprojects');
	}
	
	function setValues($image_array){
		foreach($image_array as $k => $v){
			if(isset($this->keyimages[$k])){
					$this->keyimages[$k] = $v;
			}
		}
	 }
	 
	function getValues(){
		return $this->keyimages;
	 }
	
	
	function save($data){
		if($data['mediaId']>0)
		{
			$where = array('mediaId' => $data['mediaId']);
			$this->CI->model_upcomingprojects->updateRecord('TDS_UpcomingProjectMedia',$data,$where);	
		}
		else{
			
			$this->CI->model_upcomingprojects->insertRecord('TDS_UpcomingProjectMedia',$data);	
		}
		}

}
