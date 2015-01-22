<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter State files editor.
 *
 */
class Model_Managestates extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get State listing.
	*/
	public function get_state_listing($limit=0,$offset=0, $returnRow=false)
	{
		$this->db->select('MasterStates.*');
		$this->db->select('MasterCountry.countryName');
		$this->db->join('MasterCountry', 'MasterCountry.countryId = MasterStates.countryId');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('stateName asc');
		$q = $this->db->get_where('MasterStates');
		return $q->result_array();
	}
	
	/**
	* Get State data.
	*/
	public function get_state_details($stateId)
	{	$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('stateId' => $stateId);
		$q = $this->db->get_where('MasterStates', $options);
		if($q->num_rows() >0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[] = $row;
            }
            
            return $data;
        } else {
            return false;
        }
	}
	
	
	/**
	* Insert New State.
	*/
	public function add_state($stateData)
	{ 	
		$this->db->insert('MasterStates', $stateData);
		return $this->db->insert_id();	     
	}
	
	/**
	* Update State.
	*/
	public function update_state($stateData,$stateId)
	{ 
		$this->db->where('stateId', $stateId);
		$this->db->update('MasterStates', $stateData);
	}
	
}
