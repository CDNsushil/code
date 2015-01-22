<?php
/**
 * Users Model
 * Manage User record etc
 * @category	Users
 * @author	CDN Solutions
 */
class Point_model extends CI_Model
{
	private $read_db;	// private variable to store db read reference
	
	//Constructor
	function __construct(){
		parent::__construct();
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);
	}

	/** 
	*Get count of value of user
	*Params type {recent/all} 
	*Return number
	*Created : 15/05/2012
	*/			
	function get_activity($table_name)
	{	
		$this->read_db->select('*');
		$this->read_db->from($table_name);
		$result = $this->read_db->get();
		return $result->result();
	}
	
	function update_save()
	{	
		$table_name 	= $this->input->post('table_name');
		$col_name	= $this->input->post('col_name');
		$point 	    	= $this->input->post('point');
		$whr_col 	= $this->input->post('whr_col');
		$whr_id 	= $this->input->post('whr_id');
		$data = array(
			       $col_name => $point
			    );

		$this->db->where($whr_col, $whr_id);
		$this->db->update($table_name, $data);
	}
}
?>
