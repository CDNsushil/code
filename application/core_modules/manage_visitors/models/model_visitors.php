<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
 */
class Model_Visitors extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Genre listing.
	*/
	public function get_visitors_listing($limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('LogVisitors.*');
		//$this->db->select('MasterProjectType.projectTypeName');
		//$this->db->join('MasterProjectType', 'MasterProjectType.typeId = Genre.typeId');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('date asc');
		$q = $this->db->get('LogVisitors');
		return $q->result_array();
	}
		
}
