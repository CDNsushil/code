<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter Continent files editor.
 *
 */
class Model_Continent extends CI_Model {
	 
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* Get Continent listing.
	*/
	public function get_continent_listing($limit=0,$offset=0)
	{
		$this->db->select('*');
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('continent asc');
		$q = $this->db->get_where('MasterContinent');
		return $q->result_array();
	}
	
	/**
	* Get Continent data.
	*/
	public function get_continent_details($continentId)
	{	$data = array(); 
		$this->db->select('*');
		$this->db->limit('1');
		$options = array('id' => $continentId);
		$q = $this->db->get_where('MasterContinent', $options);
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
	* Insert New Continent.
	*/
	public function add_continent($continentData)
	{ 	
		$this->db->insert('MasterContinent', $continentData);
		return $this->db->insert_id();	     
	}
	
	/**
	* Update Continent.
	*/
	public function update_continent($continentData,$continentId)
	{ 
		$this->db->where('id', $continentId);
		$this->db->update('MasterContinent', $continentData);
	}
	
}
