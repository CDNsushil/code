<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*
	 Description:
	 * The model_upcommingproject class is meant to handle the processing of the Blog section
	 * It include functionality to fetch/add/edit Blog content for logged in user 
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
*/
class model_upcomingfrontend extends CI_Model {
	private $tableName = 'UpcomingProject';

	function __construct()
	{
		parent::__construct();
	}

	function getValuesFromUpcomingProjects($userId=0,$ispublished=0,$fetchFields="*",$excludeUserID=0)
	{
		
			
		$this->db->select($fetchFields);
		if($excludeUserID==0) $this->db->where('tdsUid',$userId);
		$this->db->where('UpcomingProject.projArchived','f');
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$this->db->order_by('projModifiedDate','desc');
		$query = $this->db->get('UpcomingProject');
	//	echo $this->db->last_query();die;
		return $query->result_array();
	}
	
	function getValueToUpdate($projId=0,$userId=0,$ispublished=0,$fetchFields="*")
	{
		
				
		$this->db->select($fetchFields);
		$this->db->where('tdsUid',$userId);
		$this->db->where('projId',$projId);
		if($ispublished==1)
		$this->db->where('UpcomingProject.isPublished','t');
		$query = $this->db->get('UpcomingProject');
		return $query->row();
	}
	
}
?>
