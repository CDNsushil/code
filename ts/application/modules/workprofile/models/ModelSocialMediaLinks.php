<?php
Class ModelSocialMediaLinks extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{				
		$table = 'ProfileSocialLink';
		$dataProfileSocialLink = $this->db->get($table);	
		$dataProfileSocialLink = $dataProfileSocialLink->result_array();	
		$dataProfileSocialLink = $dataProfileSocialLink[0];				
	}
	
	function showSocialMediaLinks()
	{	
		$table = 'ProfileSocialLink';
		$dataProfileSocialLink = $this->db->get($table);	
		
			
		if(count($dataProfileSocialLink)>0)
			$dataProfileSocialLink = $dataProfileSocialLink->result_array();
		else
			$dataProfileSocialLink = 0;
			
		return $dataProfileSocialLink;		
	}
	
/**
	*
	* Insert/Update a new row into the specified database table from the common function
	*
*/	
	function EntryRecord($data){
		
		$table = 'ProfileSocialLink';
		$field = 'profileSocialLinkId';
		foreach($data['profileSocialLinkId'] as $id =>$stats) {
		
			echo $id; 
			$this->workProfileId   = $data['workProfileId']; 
			$this->profileSocialLinkType = $data['socialLinkType'][$id];
			$this->socialLink = $data['socialLink'][$id];
			
			if( $data['profileSocialLinkId'][$id] ==0) {
				$this->db->insert($table , $this);
			}
			else{ 
				$this->db->where($field,$stats);			
				$this->db->update($table,$this);
			}
		}
	}
	

}//End Of Class
?>