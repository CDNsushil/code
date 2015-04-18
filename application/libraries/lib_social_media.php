<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class lib_social_media {
	/***
	create properties
	***/
	var $keys = array
	('profileSocialLinkId' =>'',
	 'socialLink' =>'',
	 'profileSocialMediaId'=> '', 
	 'profileSocialLinkType'=> '',	
	 'workProfileId'=> '', 
	 'socialLinkDateCreated'=> '',	
	 'socialLinkDateModified'=> '',
	 'position'=> '',
	 'profileSocialMediaName'=> '',
	 'profileSocialMediaPath'=> '');

	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
	}

 
	 function setValues($project_array){
		foreach($project_array as $k => $v){
			if(isset($this->keys[$k])){
					$this->keys[$k] = $v;
			}
		}
	 }

	 
	 function getValues(){
		return $this->keys;
	 }
	 
	function getValueToUpdate($profileSocialLinkId)
	{
		$data = $this->CI->model_workprofile->socialMediaLinkRecordSet($profileSocialLinkId);	
		$this->setValues($data);
	}
	
	function save($table, $data){
		if($this->CI->input->post('mode')=="new"){
			$this->CI->model_common->addDataIntoTabel($table,$data);	
		}else if($this->CI->input->post('mode')=="edit")
		{
			$where = array('profileSocialLinkId' => $data['profileSocialLinkId']);
			$this->CI->model_common->editDataFromTabel($table,$data,$where);	
		}
		else
		{
			$this->CI->model_common->addDataIntoTabel($table,$data);
		}
	}

}

