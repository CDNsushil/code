<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasqre Lib_masterMedia Class
 *
 * manage Lib_masterMedia details.
 *
 * @package		Toadsqure
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Sapna Jain
 * @link		http://www.cdnsol.com/
 */

Class Lib_masterMedia {
	/***
	create properties
	***/
	var $keymedia = array(
					'fileId'=> '',
					'filePath'=> '',
					'fileName'=> '',
					'fileLength'=> '',
					'fileSize'=> '',
					'fileType'=> '',
					'fileCreateDate'=> '',
					);
	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();

	}
	
	function setValues($mediaArray){
		foreach($mediaArray as $k => $v){
			if(isset($this->keymedia[$k])){
					$this->keymedia[$k] = $v;
			}
		}
	 }
	
	function getValues(){
		return $this->keymedia;
	 }

}
