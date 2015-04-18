<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter report problem files editor.
 *
 */
class model_reportproblem extends CI_Model {
	 
	
	function __construct()
	{
		parent::__construct();
	}
	/*Function to insert abuse report data in db*/
	function insert_abuse_report ($report_data)
	{
		$this->db->insert("TDS_AbusiveReport",$report_data);
		return $this->db->insert_id();
	}
	/*Function to get email of user*/
	function recipients_email($recipientId)
	{
		$this->db->select('UserAuth.*');
		$this->db->select('UserProfile.firstName');
		$this->db->select('UserProfile.lastName');
		$this->db->from('UserAuth');
		$this->db->where('UserAuth.tdsUid',$recipientId);
		$this->db->join('UserProfile','UserProfile.tdsUid = UserAuth.tdsUid');
		return $this->db->get()->row();	
	}
	
	/*Function to block element*/
	function block_element($table, $primary_field, $publish_field, $elementId, $archived_field) 
	{
		if(!empty($archived_field))
		{
			$tblfield_info = array($publish_field=>'f',
				$archived_field=>'t',
				'isBlocked'=>'t');
		}
		else {
			$tblfield_info = array($publish_field=>'f',
								'isBlocked'=>'t');
		}
		$this->db->where($primary_field,$elementId);
		$this->db->update($table, $tblfield_info);
	}
	
	/*Function to block search contents */
	function block_search_element($entityId, $elementId)
	{
		$tblfield_info = array('ispublished'=>'f',
							'isblocked'=>'t');
		$this->db->where('entityid',$entityId);
		$this->db->where('elementid',$elementId);
		$this->db->update('TDS_search', $tblfield_info);
	}
	
	/*Function to get project type from table */
	function get_project_type($tbl, $field, $whereField, $whereValue)
	{
		$this->db->select($field);
		$this->db->from($tbl);
		$this->db->where($whereField,$whereValue);
		return $this->db->get()->row()->$field;
	}
	
	/*Function to Block project from search */
	function block_search_project($projectId, $entityId)
	{
		$tblfield_info = array('ispublished'=>'f',
							'isblocked'=>'t');
		$this->db->where('entityid',$entityId);
		$this->db->where('projectid',$projectId);
		$this->db->update('TDS_search', $tblfield_info);
	}
	
	/*Function to get project from search */
	function get_search_project($field,$projectId, $entityId, $elementId)
	{
		$this->db->select($field);
		$this->db->from('search');
		$this->db->where('entityid',$entityId);
		$this->db->where('projectid',$projectId);
		$this->db->where('elementid',$elementId);
		return $this->db->get()->row()->$field;
	}
}
/* End of file model_reportproblem.php */
