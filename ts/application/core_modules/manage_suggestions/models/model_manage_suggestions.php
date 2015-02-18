<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
**/

class Model_manage_suggestions extends CI_Model {
	private $Suggestions 					= 'Suggestions';	
	
	function __construct()
	{
		parent::__construct();  		
	}
	
	public function get_suggestions($limit=0,$offset=0)
	{
		$this->db->select('subject,suggestion_for, suggestion, suggestion_date, sender_id');
		$this->db->from($this->Suggestions);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('suggestion_date','Asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	

}
/* End of file model_suggestions.php */
